<?php

namespace App\Http\Controllers;

use App\Models\vnpay_payments;
use Illuminate\Http\Request;
use \App\Models\Order;
use \App\Models\product;
use \App\Models\Order_item;
use App\Http\Livewire\User\UserOrderDetailComponent;
use Illuminate\Support\Facades\Http;
use App;

class OrderController extends Controller
{
    public function show(Request $request, $order_id)
    {
        $order = Order::where("id", $order_id)->where("user_id", auth()->user()->id)->first();
        if ($order) {
            $orderItems = Order_Item::where('order_id', $order->id)->get();
            $products = [];

            foreach ($orderItems as $value) {
                $products[$value->product_id] = Product::withTrashed()->where('id', $value->product_id)->first();
            }

            session(['order' => $order]);
            session(['orderItems' => $orderItems]);
            session(['products' => $products]);

            return App::call(UserOrderDetailComponent::class);
        }

        return redirect(route('shop'));
    }

    public function cancel(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)->where("user_id", auth()->user()->id)->first();
        $vnp_message = "";

        if ($order) {
            if($order->order_status !== 0) {
                return redirect(route('user.order_detail', ['order_id' => $order_id]))->with('error', 'Hủy đơn hàng thất bại. Vui lòng liên hệ CSKH để được hỗ trợ.');
            }
            $vnp = vnpay_payments::where('vnp_TxnRef', $order->id)->first();
            if ($vnp) {
                $vnp_TmnCode = env('VNP_TMN_CODE');
                $vnp_HashSecret = env('VNP_HASH_SECRET');
                $ipaddr = $_SERVER['REMOTE_ADDR'];
                $inputData = array(
                    "vnp_Version" => '2.1.0',
                    "vnp_TransactionType" => "02", // Hoàn tiền toàn phần
                    "vnp_Command" => "refund",
                    "vnp_CreateBy" => $order["email"],
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_TxnRef" => $vnp["vnp_TxnRef"],
                    "vnp_Amount" => $vnp["vnp_Amount"],
                    "vnp_OrderInfo" => $vnp["vnp_OrderInfo"],
                    "vnp_TransDate" => $vnp["vnp_PayDate"],
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_IpAddr" => $ipaddr
                );
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html" . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                    $vnp_apiUrl .= 'vnp_SecureHash=' . $vnpSecureHash;
                }

                $response = Http::get($vnp_apiUrl);
                if ($response->successful()) {
                    $content = $response->body();
                    parse_str($content, $queryArray);
                    if ($queryArray['vnp_ResponseCode'] === "00") {
                        $vnp_message = "Vui lòng chờ từ 1 đến 7 ngày để được xử lý hoàn tiền";
                    } else {
                        $vnp_message = "Đã xảy ra lỗi khi gửi yêu cầu hoàn tiền, vui lòng liên hệ CSKH để được hỗ trợ";
                        return redirect(route('order.detail.view', ['order_id' => $order_id]))->with('error', $vnp_message);
                    }
                } else {
                    // Xử lý trường hợp không thành công khi gọi API
                    return redirect(route('order.detail.view', ['order_id' => $order_id]))->with('error', 'Đã xảy ra lỗi khi gửi yêu cầu hoàn tiền. Vui lòng thử lại sau');
                }
            }
            $orderItems = Order_Item::where('order_id', $order_id)->get();
            foreach ($orderItems as $value) {
                product::withTrashed()->where('id', $value->product_id)->increment('quantity', $value->quantity);
            }
            $order->order_status = 4; // Đã hủy
            $order->payment_status = 3; // Đã hoàn tiền
            $order->save();
            return redirect(route('user.order_detail', ['order_id' => $order_id]))->with('success', 'Hủy đơn hàng thành công. ' . $vnp_message);
        }
        return redirect(route('shop'));
    }
}
