@livewireStyles
<div class="header-action-icon-2">
    @auth
    <a class="mini-cart-icon" href="{{route('shop.cart')}}">
        <i alt="Cart" class="fas fa-shopping-cart text-primary"></i>
        
            @if(Auth::user()->carts->count()>0)
                <span class="pro-count blue">{{Auth::user()->carts->count()}}</span>
            @endif
    </a>
    @else
    <a class="mini-cart-icon" href="{{route('login')}}">
        <i alt="Cart" class="fas fa-shopping-cart text-primary"></i>
    </a>
    @endif

    @auth
    <div class="cart-dropdown-wrap cart-dropdown-hm2">
        <ul>
            @foreach(Auth::user()->carts as $item)
            <li class="mw-80vh" style="max-height: 50vh;">
                <div class="shopping-cart-img">
                    <a href="{{route('product.details',['slug'=>$item->product->slug])}}">
                    @php
                        $images = explode(',', $item->product->image);
                        $firstImage = $images[0];
                    @endphp                    
                    <img alt="{{$item->product->name}}" src="{{ asset('img/products/products/' . $firstImage) }}"></a>
                </div>
                <div class="shopping-cart-title">
                    <h4><a href="{{route('product.details',['slug'=>$item->product->slug])}}">{{substr($item->product->name,0,18)}}</a></h4>
                    <h4><span>{{$item->quantity}} x </span>{{number_format($item->product->regular_price)}} VND</h4>
                </div>
               
            </li>
            @endforeach
        </ul>
        <div class="shopping-cart-footer">
            <div class="shopping-cart-total">
                <h4>Tổng tiền <span>{{number_format(intval(Auth::user()->carts->sum(function($cart) {
                    return $cart->quantity * $cart->product->regular_price;
                })))}} VND</span></h4>
            </div>
            <div class="shopping-cart-button">
                <a href="{{route('shop.cart')}}" class="outline">Xem giỏ hàng</a>
                <a href="{{route('user.checkout')}}">Thanh toán</a>
            </div>
        </div>
    </div>
    @endif
</div>
@livewireStyles