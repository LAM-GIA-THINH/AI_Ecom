<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Wish;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;
    public $search = '';
    public $pageSize = 12;
    public $orderBy = "Mặc định";
    public $min_value = 100000;
    public $max_value = 90000000;

    public $sellerId;

    public function mount($seller_id)
    {
        $this->sellerId = $seller_id;
    }

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

    public function changePageSize($size)
    {
        $this->pageSize = $size;
    }

    public function changeOrderBy($order)
    {
        $this->orderBy = $order;
    }

    public function render()
    {
        $sellerInfo = User::where('id', $this->sellerId)->first();

        $query = Product::query();

        // Apply seller filter if sellerId is available
        if ($sellerInfo) {
            $query->where('user_id', $this->sellerId);
        }

        // Apply price range filter
        $query->whereBetween('regular_price', [$this->min_value, $this->max_value]);

        // Apply search filter
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Apply sorting
        if ($this->orderBy == "Giá: thấp đến cao") {
            $query->orderBy('regular_price', 'ASC');
        } else if ($this->orderBy == "Giá: cao đến thấp") {
            $query->orderBy('regular_price', 'DESC');
        } else if ($this->orderBy == 'Sản phẩm mới') {
            $query->orderBy('created_at', 'DESC');
        }

        // Paginate results
        $products = $query->paginate($this->pageSize);

        // Fetch categories
        $categories = Category::withCount('products')->orderBy('name', 'ASC')->get();

        return view('livewire.shop-component', [
            'products' => $products,
            'categories' => $categories,
            'seller' => $sellerInfo,
        ]);
    }

}