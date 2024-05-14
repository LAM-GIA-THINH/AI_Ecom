<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserCheckoutComponent extends Component
{
    public $city = "";
    public $district = "";
    public $ward = "";

    public $shipFees = [];


    public function mount()
    {
        $address = Auth::user()->address;
        if($address) {
            $this->city = array_reverse(explode(',', $address))[0];
            $this->district = array_reverse(explode(',', $address))[1];
            $this->ward = array_reverse(explode(',', $address))[2];
        }
    }

    public function handleChangeDistrict()
    {
        $this->emit('city');
        $this->emit('district');
    }

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


    public function render()
    {
        $errorMessage = '';
        if($this->city && $this->district) {
            foreach (Auth::user()->carts->groupBy('seller_id') as $sellerId => $carts) {
                $seller = User::where('id', $sellerId)->first();
                $sellerCity = array_reverse(explode(',', $seller->address))[0];
                $sellerDistrict = array_reverse(explode(',', $seller->address))[1];
                $weight = $carts->sum(function ($cart) {
                    return $cart->quantity * $cart->product->weight;
                });
                $this->shipFees[$sellerId] = $this->calculatorShipFee($sellerCity, $sellerDistrict, $this->city, $this->district, $weight);
                if($this->shipFees[$sellerId] === -1) {
                    $errorMessage = 'Địa chỉ này không được hỗ trợ giao hàng';
                } elseif ($this->shipFees[$sellerId] === -2) {
                    $errorMessage = 'Xảy ra lỗi trong quá trình tính phí giao hàng, vui lòng thử lại sau';
                }
            }
        }
        return view('livewire.user.user-checkout-component', ['shipFees' => $this->shipFees]);
    }
}
