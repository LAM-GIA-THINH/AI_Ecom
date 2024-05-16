<div>
<style>
    .wishlisted{
        background-color: #F15412 !important;
        border: 1px solid transparent !important; 
    }
    .wishlisted i{
        color: #fff !important;
    }
</style>
    @livewireStyles
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Yêu thích</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Sản phẩm yêu thích</p>
            </div>
        </div>
    </div>
    @if(Auth::user()->wishes->count() > 0)
                    @foreach($wishes as $item )
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div
                                class="card-header product-img position-relative overflow-hidden bg-transparent border p-0" style="height: 350px; ">
                                <a href="{{route('product.details',['slug'=>$item->product->slug])}}">
                                @php
                                    $images = explode(',', $item->product->image);
                                    $firstImage = $images[0];
                                @endphp 
                                <img class="img-fluid w-100" src="{{ asset('img/products/products/' . $firstImage) }}" alt="" >
                                </a>
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3" ><a style="font-weight: bold; color: black; font-size: 1.2em;"
                                                href="{{route('product.details',['slug'=>$item->product->slug])}}">{{$item->product->name}}</a></h6>
                                <div class="d-flex justify-content-center">
                                    <h6 style="font-weight: bold; color: red; font-size: 1.2em;font-family: Arial, sans-serif;">{{number_format($item->product->regular_price)}} ₫ </h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">

                            <a class="btn btn-sm text-dark p-0 " aria-label="Bỏ yêu thích" class="action-btn hover-up" href="#" wire:click.prevent="removeFromWishlist({{$item->product->id}})" style="font-size: 20px;"><i class="fas fa-heart text-primary"></i> Bỏ yêu thích</a>
                            
                              
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{$wishes->links('pagination::bootstrap-4')}}
                    @else
                        <div class="alert alert-warning" role="alert">
                            Bạn không có sản phẩm yêu thích!
                        </div>
                    @endif
                    @livewireScripts