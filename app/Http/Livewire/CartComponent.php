<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartComponent extends Component
{
    public function incrementQuantity($cartId){

        $cart = Cart::where('id', $cartId)->first();
        if($cart) {
            $product = $cart->product;
            if($cart->quantity < $product->quantity) {
                $cart->increment("quantity", 1);
            } else {
                session()->flash('error_message','Số lượng đã đạt đến giới hạn trong kho hàng');
                return;
            }
        }
    }
    public function decrementQuantity($cartId) {
        $cart = Cart::where('id', $cartId)->first();
        if($cart) {
            if($cart->quantity === 1) {
                $cart->delete();
                return;
            }
            $cart->decrement("quantity", 1);
        }
    }

    public function destroy($cartId){
        $cart = Cart::where('id', $cartId)->first();
        if($cart){
            $cart->delete();
            session()->flash('success_message','Sản phẩm đã bị xoá');
            return;
        }
        session()->flash('error_message','Xảy ra lỗi khi xóa');
        return;
    }

    public function clearAll(){
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        if($carts->isNotEmpty()) {
            $carts->each(function ($cart) {
                $cart->delete();
            });
            session()->flash('success_message','Tất cả sản phẩm đã bị xoá');
        }
    }
    public function render()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        return view('livewire.cart-component', compact('carts'));
    }
}
