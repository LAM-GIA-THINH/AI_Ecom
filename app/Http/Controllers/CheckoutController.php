<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use \App\Models\Order;
use \App\Models\Cart;
use \App\Models\Order_item;
use \App\Models\vnpay_payments;
use \App\Models\product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function calculatorShipFee
    (
        $pickCity,
        $pickDistrict,
        $city,
        $district,
        $weight,
        $value = 0,
        $transport = "road",
        $deliverOption = "none"
    ) {
        try {
            // Dữ liệu yêu cầu gửi đến API
        $requestData = [
            "pick_province" => $pickCity,
            "pick_district" => $pickDistrict,
            "province" => $city,
            "district" => $district,
            "weight" => $weight,
            "value" => $value,
            "transport" => $transport,
            "deliver_option" => $deliverOption,
        ];

        // Chuyển đổi dữ liệu thành định dạng JSON
        $requestDataJson = json_encode($requestData);

        $headers = [
            'Content-Type: application/json',
            'token: ' . env('TOKEN_API_GHTK'),
        ];

        // Tạo yêu cầu HTTP
        $ch = curl_init('https://services.giaohangtietkiem.vn/services/shipment/fee');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestDataJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Thực hiện yêu cầu và nhận kết quả
        $response = curl_exec($ch);

        // Kiểm tra lỗi
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        // Đóng phiên cURL
        curl_close($ch);

        // Chuyển đổi dữ liệu JSON nhận được thành mảng PHP
        $result = json_decode($response, true);

        if(!$result['fee']['delivery']) {
            return -1;
        }
        return $result['fee']['fee'];
        } catch (\Throwable $th) {
            return -2; 
        }
        
    }
    public function payment(Request $request)
    {
        $request->validate([
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'numeric', 'digits_between:10,11'],
            'address' => ['required', 'string', 'max:255'],
            'ward' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'payment_option' => ['required', 'in:vnp,cod'], // chỉ chấp nhận 'vnp' hoặc 'cod'
            'seller_id' => ['required'],
        ], [
            'required' => 'Trường :attribute là bắt buộc.',
            'string' => 'Trường :attribute phải là một chuỗi.',
            'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
            'numeric' => 'Trường :attribute phải là một số.',
            'digits_between' => 'Trường :attribute phải có độ dài từ :min đến :max chữ số.',
            'in' => 'Trường :attribute không hợp lệ.',
        ], [
            'fullName' => 'Họ tên',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'ward' => 'Phường/Xã',
            'district' => 'Quận/Huyện',
            'city' => 'Thành phố',
            'payment_option' => 'Phương thức thanh toán',
            'seller_id' => 'Đơn hàng',
        ]);

        $data = $request->all();
        $orderId = date('YmdHis');
        $orderItems = [];
        try {
            $carts = Auth::user()->carts->where('seller_id', $data['seller_id']);
            $subtotal = intval(str_replace(',', '', $carts->sum(function($cart) {
                return $cart->quantity * $cart->product->regular_price;
            })));
            $seller = User::where('id', $data['seller_id'])->first();
            $sellerCity = array_reverse(explode(',', $seller->address))[0];
            $sellerDistrict = array_reverse(explode(',', $seller->address))[1];
            $weight = $carts->sum(function ($cart) {
                return $cart->quantity * $cart->product->weight;
            });
            $shipping = $this->calculatorShipFee($sellerCity, $sellerDistrict, $data['city'], $data['district'], $weight);
            if($shipping === -1) {
                return back()->withErrors('Địa chỉ giao hàng không được hỗ trợ.');
            } elseif ($shipping === -2) {
                return back()->withErrors('Xảy ra lỗi trong quá trình tính phí giao hàng.');
            }

            $amount = $subtotal + $shipping;
            $order = new Order([
                'id' => $orderId,
                'user_id' => Auth::user()->id,
                'address' => $data['address'] . ',' . $data['ward'] . ',' . $data['district'] . ',' . $data['city'],
                'name' => $data['fullName'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'payment_method' => $data['payment_option'],
                'payment_status' => 0,
                'order_status' => 0,
                'sub_total' => $subtotal,
                'shipping' => $shipping,
                'amount' => $amount,
                'note' => $data['note'],
            ]);

            foreach ($carts as $cartItem) {
                $product = $cartItem->product;
                if (!$product) {
                    return back()->withErrors('Không tìm thấy sản phẩm bạn cần đặt hàng.');
                }

                $availableQuantity = $product->quantity;

                // Kiểm tra xem có đủ sản phẩm để giảm quantity hay không
                if ($availableQuantity >= $cartItem->quantity) {
                    // decrement quantity của sản phẩm
                    product::where('id', $cartItem->product_id)->decrement('quantity', $cartItem->quantity);

                    array_push($orderItems, new Order_Item([
                        'order_id' => $orderId,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'unit_price' => intval($product->regular_price)
                    ]));
                } else {
                    // Xử lý tình huống khi không đủ sản phẩm
                    if ($availableQuantity === 0) {
                        return back()->withErrors('Sản phẩm ' . $product["name"] . ' đã hết hàng.');
                    }
                    return back()->withErrors("Sản phẩm " . $product["name"] . " vượt quá số lượng có trong kho. Số lượng hiện còn là (" . $product["quantity"] . ") vui lòng điều chỉnh lại");
                }
            }

            if ($data["payment_option"] == "cod") {
                $order->save();
                foreach ($orderItems as $item) {
                    $item->save();
                }
                $carts->each(function ($cart) {
                    $cart->delete();
                });
                return redirect()->route('user.order_detail', ['order_id' => $orderId])->with('success', 'Đặt hàng thành công');

            } else if ($data["payment_option"] == "vnp") {
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_ReturnUrl = "http://localhost:8000/handle-vnpay-return";
                $vnp_TmnCode = env('VNP_TMN_CODE');
                $vnp_HashSecret = env('VNP_HASH_SECRET');

                $vnp_TxnRef = $orderId;
                $vnp_OrderInfo = 'Payment order on Bookstore';
                $vnp_OrderType = 'billpayment';
                $vnp_Amount = $amount * 100;
                $vnp_Locale = 'vn';
                $vnp_BankCode = "";
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_ReturnUrl,
                    "vnp_TxnRef" => $vnp_TxnRef
                );

                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
                // }

                //var_dump($inputData);
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

                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                $returnData = array(
                    'code' => '00'
                    ,
                    'message' => 'success'
                    ,
                    'data' => $vnp_Url
                );
                if (isset($_POST['redirect'])) {
                    $order->save();
                    foreach ($orderItems as $value) {
                        $value->save();
                    }
                    header('Location: ' . $vnp_Url);
                    die();
                } else {
                    echo json_encode($returnData);
                }
            }
        } catch (\Throwable $th) {
            return back()->withErrors("Đã xảy ra lỗi trong quá trình đặt hàng vui lòng thử lại sau.");
        }
    }

    public function handleVNPayReturn(Request $request)
    {
        $data = $request->all();
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_SecureHash = $data['vnp_SecureHash'];
        unset($data['vnp_SecureHash']);
        ksort($data);
        $i = 0;
        $hashData = "";

        foreach ($data as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $orderId = $data['vnp_TxnRef'];
        $vnp_Amount = $data['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi

        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                $order = Order::where('id', $orderId)->first();

                if ($order) {
                    if (($data['vnp_ResponseCode'] == '24' && $order->order_status !== 4)) { // payment canceled by customer
                        $order->order_status = 4; // Đã hủy
                        $order->payment_status = 0; // Chưa thanh toán
                        $orderItems = Order_item::where('order_id', $order->id)->get();
                        foreach ($orderItems as $orderItem) {
                            $product = Product::where('id', $orderItem->product_id)->first();
                            if($product) {
                                $product->increment('quantity', $orderItem->quantity);
                            }
                            $orderItem->delete();
                        }
                        $order->delete();
                        return redirect()->route('user.checkout');
                    }

                    if ($order["amount"] == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    {
                        if ($order["payment_status"] !== NULL && $order["payment_status"] === 0) {
                            if ($data['vnp_ResponseCode'] == '00' || $data['vnp_TransactionStatus'] == '00') {
                                $status = 1; // Trạng thái thanh toán thành công
                                $order->update(['payment_status' => $status]);
                            } else {
                                $status = 2; // Trạng thái thanh toán thất bại / lỗi
                                $order->update(['payment_status' => $status]);
                            }
                            $payment = new vnpay_payments([
                                'vnp_Amount' => $data['vnp_Amount'],
                                'vnp_BankCode' => $data['vnp_BankCode'],
                                'vnp_CardType' => $data['vnp_CardType'],
                                'vnp_OrderInfo' => $data['vnp_OrderInfo'],
                                'vnp_PayDate' => $data['vnp_PayDate'],
                                'vnp_ResponseCode' => $data['vnp_ResponseCode'],
                                'vnp_TmnCode' => $data['vnp_TmnCode'],
                                'vnp_TransactionNo' => $data['vnp_TransactionNo'],
                                'vnp_TransactionStatus' => $data['vnp_TransactionStatus'],
                                'vnp_TxnRef' => $data['vnp_TxnRef'],
                                'vnp_SecureHash' => $request->all()['vnp_SecureHash'],
                            ]);

                            $payment->save();
                            $message = 'Thanh toán thành công';
                            if(Auth::check()) {
                                Auth::user()->carts->where('seller_id', $order->orderItems[0]->product->user_id)->each(function ($cart) {
                                    $cart->delete();
                                });
                            }
                            return redirect()->route('user.payment_result')->with(['message' => $message, 'messageType' => 'success', 'order_id' => $orderId]);
                        } else {
                            $message = 'Đơn hàng đã được thanh toán';
                        }
                    } else {
                        $message = 'Tổng tiền không hợp lệ';
                    }
                } else {
                    $message = 'Không tìm thấy đơn hàng';
                }
            } else {
                $message = 'Chữ ký không hợp lệ';
            }
        } catch (\Exception $e) {
            $message = 'Lỗi';
        }
        return redirect()->route('user.payment_result')->with(['message' => $message, 'messageType' => 'error']);
    }
}
