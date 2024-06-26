<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Response_review;
use App\Models\Review_like;
use App\Models\User;
use App\Models\Wish;
use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Review; 
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
class DetailsComponent extends Component
{
    use WithPagination;
    public $slug;
    public $content;
    public $rating;
    public $comment;
    public $responseReview;
    public $quantity;
    public $product;
    
    public $review;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->rating = 5;
        $this->quantity = 1;
        $this->product = Product::where('slug', $this->slug)->first();
    }

    public function store($product_id, $product_name, $product_price, $product_quantity = 1)
    {
        if(Auth::check()) {
            $cart = Auth::user()->carts->where('product_id', $product_id)->first();
            if($cart) {
                $cart->update(['quantity'=> $product_quantity]);
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
        if(!Wish::where(['user_id' => Auth::user()->id, 'product_id' => $product_id])->exists()) {
            Wish::create([
                'user_id'=> Auth::user()->id,
                'product_id'=> $product_id,
            ]);
        }
    }

    public function removeFromWishlist($product_id){
        $wish = Wish::where(['user_id' => Auth::user()->id, 'product_id' => $product_id])->first();
        if($wish) {
            $wish->delete();
        }
    }

    public function incrementQuantity() {
        if($this->product) {
            if($this->quantity < $this->product->quantity) {
                $this->quantity += 1;
            }
        }
    }
    public function decrementQuantity(){
        if($this->product) {
            if($this->quantity > 1) {
                $this->quantity -= 1;
            }
        }
    }

    public function likeReview($review_id) 
    {
        if(Auth::check()) {
            $reviewLike = Review_like::where(['user_id'=> Auth::user()->id,'review_id' => $review_id])->first();
            if($reviewLike) {
                $reviewLike->delete();
                return;            
            }

            Review_like::create(['review_id' => $review_id, 'user_id' => Auth::user()->id]);
            return;
        } else {
            return redirect()->route('login');
        }
    }

    public function showModal($reviewId)
    {
        $this->responseReview = Response_review::where(['review_id' => $reviewId])->value('comment') ?? '';
        return;
    }

    public function sendResponseReview($reviewId)
    {
        if(!$this->responseReview) {
            return;
        }

        if(Auth::check() && Auth::user()->utype === "SELLER") {
            if(Review::where('id', $reviewId)->exists()) {
                if(Response_review::where(['review_id'=> $reviewId])->exists()) {
                    Response_review::where(['review_id'=> $reviewId])->update(['comment' => $this->responseReview]);
                    $this->responseReview = "";
                    return;
                }
                Response_review::create(['review_id' => $reviewId, 'comment' => $this->responseReview]);        
                $this->responseReview = "";
            }
        }
    }

    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required',
        ]);
    
        if (Auth::id() === null) {
            session()->flash('error_message', 'Bạn phải đăng nhập để đánh giá.');
            return;
        }
        if (!$this->userHasBoughtProduct($this->product->id)) {
            session()->flash('error_message', 'Bạn chỉ có thể đánh giá sau khi mua sản phẩm.');
            return;
        }
    
 
        $client = new Client();
    

        $response = $client->post('https://api.edenai.run/v2/text/moderation', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('EDEN_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'providers' => 'openai',
                'text' => $this->comment,
            ],
        ]);
    
        $moderationResult = json_decode($response->getBody(), true);
        $isNSFW = $moderationResult['openai']['nsfw_likelihood'] > 1;
    
        $status = $isNSFW ? 1 : 0;
    
        if ($this->userHasReviewedProduct($this->product->id)) {
            $review = Review::where('user_id', Auth::user()->id)
                            ->where('product_id', $this->product->id)
                            ->first();
            $review->rating = $this->rating;
            $review->comment = $this->comment;
            $review->status = $status;
            $review->save();
            $this->reset(['comment']);
            session()->flash('success_message', 'Đã cập nhật đánh giá.');
            return;
        }
    
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $this->product->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'status' => $status,
        ]);
        $this->emit('showSuccessMessage');
        $this->reset(['comment']);
        
        return;
    }
    
    private function userHasReviewedProduct($productId)
    {
        $user = Auth::user();
    
        
        return Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();
    }

    private function userHasBoughtProduct($productId)
    {
        $user = Auth::user();
    
        $hasBought = $user->orders()->whereHas('items', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })->where('order_status', 3)->exists();
    
        return $hasBought;
    }
    public function render()
    {
        if($this->product != null){
            $rproducts = Product::where('category_id', $this->product->category_id)->inRandomOrder()->limit(4)->get();
            $nproducts = Product::latest()->take(4)->get();
            $categories = Category::orderBy('name', 'ASC')->get();
            $publisher = Brand::where('id', $this->product->brand_id)->first();
            $reviews = Review::where('product_id', $this->product->id)->orderBy('updated_at', 'desc')->paginate(5);
            $wishCount = Wish::where('product_id' , $this->product->id)->count();
            return view('livewire.details-component', [
                'product' => $this->product,
                'rproducts' => $rproducts,
                'nproducts' => $nproducts,
                'categories' => $categories,
                'publisher' => $publisher,
                'reviews' => $reviews,
                'quantity' => $this->quantity,
                'wishCount' => $wishCount,
                'seller' => User::where('id', $this->product->user_id)->first(),
            ]);
        }else{
            return view('livewire.details-component', [
                'product' => null,
                'rproducts' => null,
                'nproducts' => null,
                'categories' => null,
                'publisher' => null,
                'reviews' => null,
                'quantity' => 0,
                'wishCount' => 0,
            ]);
        }
    }
}
