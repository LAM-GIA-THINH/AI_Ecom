<?php

namespace App\Http\Livewire;
use App\Models\Category;
use App\Models\HomeSlider;
use Livewire\Component;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use App\Models\Wish;
use App\Models\Cart;
use App\Models\Product;
class HomeComponent extends Component
{
    public $sellerId;
    public $pageSize = 8;
    public $slides;
    public function store($product_id, $product_name, $product_price, $product_quantity = 1)
    {
        if (Auth::check()) {
            $cart = Auth::user()->carts->where('product_id', $product_id)->first();
            if ($cart) {
                $cart->update(['quantity' => $product_quantity]);
                session()->flash('success_message', 'Đã thêm vào giỏ hàng');
                return redirect()->route('shop.cart');
            }

            Cart::create(['product_id' => $product_id, 'user_id' => Auth::user()->id, 'quantity' => $product_quantity]);
            session()->flash('success_message', 'Đã thêm vào giỏ hàng');
            return redirect()->route('shop.cart');
        }
        return redirect()->route('login');
    }
    public function addToWishlist($product_id, $product_name, $product_price)
    {
        if (!Wish::where(['user_id' => Auth::user()->id, 'product_id' => $product_id])->exists()) {
            Wish::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product_id,
            ]);
        }
    }

    public function removeFromWishlist($product_id)
    {
        $wish = Wish::where(['user_id' => Auth::user()->id, 'product_id' => $product_id])->first();
        if ($wish) {
            $wish->delete();
        }
    }
    public function render()
    {
        $sellerInfo = User::where('id', $this->sellerId)->first();
        $categories = Category::where('status',1)->withCount('products')->orderBy('created_at','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        $this->slides = HomeSlider::get();
        $bestSellProducts = Product::get()->sortByDesc('quantity_sold')->values()->all();
        $bestSellProducts = array_slice($bestSellProducts, 0, 8);
        $newProducts = Product::orderBy('created_at', 'DESC')->get()->take(8);
        $recommendedProducts = [];
        if (Auth::check()) {
            $favoriteCategoryCart = Auth::user()->carts->map(function ($cart) {
                return $cart->product ? $cart->product->category_id : null;
            })->filter()->unique();

            $favoriteCategoryOrders = Auth::user()->orders->map(function ($orderItem) {
                return $orderItem->product ? $orderItem->product->category_id : null;
            })->filter()->unique();

            $favoriteCategoryWishes = Auth::user()->wishes->map(function ($wish) {
                return $wish->product ? $wish->product->category_id : null;
            })->filter()->unique();
            $favoriteCategory = $favoriteCategoryCart->merge($favoriteCategoryOrders)->merge($favoriteCategoryWishes)->unique();
            $recommendedProducts = Product::whereIn('category_id', $favoriteCategory)->inRandomOrder()->get()->take(8);
        }
        $recommendedProducts = collect($recommendedProducts)->merge(
            Product::inRandomOrder()->get()->take(8)
        )->unique();
        $recommendedProducts = $recommendedProducts->take(8);
        return view('livewire.home-component', [
            'categories' => $categories,
            'brands' => $brands,
            'seller' => $sellerInfo,
            'slides' => $this->slides,
            'new_products' => $newProducts, 
            'best_sell_products' => $bestSellProducts
        ]);
    }
}
