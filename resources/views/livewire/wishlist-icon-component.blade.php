@livewireStyles
<div class="header-action-icon-2">
    @auth
    <a class="mini-heart-icon" href="{{route('user.wishlist')}}">
        <i alt="Heart" class="fas fa-heart text-primary"></i>
        
            @if(Auth::user()->wishes->count()>0)
                <span class="pro-count blue">{{Auth::user()->wishes->count()}}</span>
            @endif
    </a>
    @else
    <a class="mini-cart-icon" href="{{route('login')}}">
        <i alt="Cart" class="fas fa-heart text-primary"></i>
    </a>
    @endif
</div>