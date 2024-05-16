<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\vnpay_payments;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\ShippingNotification;
use \App\Models\product;
use \App\Models\Order_item;
use App\Models\User;


class AdminOrderEditComponent extends Component
{
    public $order_id;
    public $user_id;
    public $ship_id;
    public $address;
    public $name;
    public $phone;
    public $email;
    public $order_status;
    public $payment_method;
    public $payment_status;
    public $sub_total;
    public $tax;
    public $shipping;
    public $amount;
    public $note;
    public $tracking;
    public $orderItemsWithProducts;
    protected $listeners = ['selectedUserChanged'];
    public function mount($order_id)
    {
        $order = Order::find($order_id);
        $this->order_id = $order->id;
        $this->name = $order->name;
        $this->user_id = $order->user_id;
        $this->ship_id = $order->ship_id;
        $this->address = $order->address;
        $this->phone = $order->phone;
        $this->email = $order->email;
        $this->order_status = $order->order_status;
        $this->payment_method = $order->payment_method;
        $this->payment_status = $order->payment_status;
        $this->sub_total = number_format($order->sub_total, 0, ',', ',') . ' VND';
        $this->shipping = number_format($order->shipping, 0, ',', ',') . ' VND';
        $this->amount = number_format($order->amount, 0, ',', ',') . ' VND';
        $this->note = $order->note;
        $this->tracking = $order->tracking;
        $this->orderItemsWithProducts = $order->orderItems()->with(['product' => function ($query) {
            $query->withTrashed(); 
        }])->get();
    }

    public function updateOrder()
    {
        $order = Order::find($this->order_id);
        $previousStatus = $order->order_status;
        $order->order_status = $this->order_status;
        $order->tracking = $this->tracking;
        $order->ship_id =$this->ship_id;

        if ($order->payment_method == 'vnp'  && $order->order_status === '4' && $order->payment_status !== '3') {
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
                    if ($queryArray['vnp_ResponseCode'] !== "00") {
                        session()->flash('error', 'Đã xảy ra lỗi khi gửi yêu cầu hoàn tiền.');
                        return redirect()->route('admin.order.edit', ['order_id' => $this->order_id]);
                    }
                } else {
                    // Xử lý trường hợp không thành công khi gọi API
                    session()->flash('error', 'Đã xảy ra lỗi khi gửi yêu cầu hoàn tiền. Vui lòng thử lại sau');
                    return redirect()->route('admin.order.edit', ['order_id' => $this->order_id]);
                }
            }
        }
        $order->save();
        if (in_array($this->order_status, ['1', '2', '3', '4']) && $previousStatus !== $this->order_status) {
            $userEmail = $order->email;
            Mail::to($userEmail)->send(new ShippingNotification($order));
        }
        if($order->order_status === '4') {
            $orderItems = Order_Item::where('order_id', $order->id)->get();
            foreach ($orderItems as $value) {
                product::withTrashed()->where('id', $value->product_id)->increment('quantity', $value->quantity);
            }
        }
        session()->flash('message', 'Đã cập nhật đơn hàng thành công!');
        return redirect()->route('admin.order.edit', ['order_id' => $this->order_id]);
    }

    public function render()
    {
        $users = User::where('utype', 'SHIP')
             ->orderBy('name', 'ASC')
             ->get();
        return view('livewire.admin.admin-order-edit-component', ['users' => $users, 'orderItemsWithProducts' => $this->orderItemsWithProducts])->layout('layouts.guest') ;;
    }
    public function selectedUserChanged($value)
    {
        $this->ship_id = $value;
    }
}
