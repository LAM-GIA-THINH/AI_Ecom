<?php

namespace App\Http\Livewire;

use App\Models\Wish;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WishlistComponent extends Component
{
    public function removeFromWishlist($product_id){
        $wish = Wish::where(['user_id' => Auth::user()->id, 'product_id' => $product_id])->first();
        if($wish) {
            $wish->delete();
        }
    }
    public function render()
    {
        $wishes = Wish::where(['user_id'=> Auth::user()->id])->paginate(8);
        return view('livewire.wishlist-component', ['wishes'=> $wishes]);
    }
}
