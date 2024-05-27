<!-- Navbar Start -->
<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Danh mục</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0"
                id="navbar-vertical">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown">Thương hiệu <i
                                class="fa fa-angle-down float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                            @foreach($brands as $brand)
                                <a href="" class="dropdown-item">{{$brand->name}}</a>
                            @endforeach
                        </div>
                    </div>
                    @foreach($categories as $category)
                        <a href="{{route('product.category', ['slug' => $category->slug])}}" class="nav-item nav-link">
                            {{$category->name}} </a>
                    @endforeach

                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="index.html" class="nav-item nav-link active">Trang chủ</a>
                        <a href="shop/all" class="nav-item nav-link">Mua sắm</a>
                        <a href="detail.html" class="nav-item nav-link">Chi tiết</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Thông tin</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="user/orders" class="dropdown-item">Đơn hàng</a>
                                <a href="cart" class="dropdown-item">Giỏ hàng</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Liên hệ</a>
                    </div>

                </div>
            </nav>
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($slides as $index => $slide)
                    @if($slide->status === 1)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" style="height: 410px;">
                            <a href="{{ $slide->link }}" class="cat-img position-relative overflow-hidden mb-3">
                                <img class="img-fluid" src="{{ asset('img/products/slider/' . $slide->image) }}"
                                    alt="Image">
                            </a>
                        </div>
                    @endif
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n2"></span>
                    </div>
                </a>
                <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n2"></span>
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>
<!-- Navbar End -->
<div>
    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Chất lượng</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Giao nhanh</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Hoàn trả 14 ngày</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Hỗ trợ 24/7</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            @foreach ($categories as $index => $category)

                <div class="col-lg-4 col-md-6 pb-1 {{ $index == 0 ? 'active' : '' }}">
                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                        <p class="text-right">{{ $category->products_count }} Sản phẩm</p>
                        <a href="{{ route('product.category', ['slug' => $category->slug]) }}"
                            class="cat-img position-relative overflow-hidden mb-3">
                            <img class="img-fluid" src="{{ asset('img/products/category/' . $category->image) }}" alt="">
                        </a>
                        <h5 class="font-weight-semi-bold m-0">{{$category->name}}</h5>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
    <!-- Categories End -->


    <!-- Offer Start -->
    <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
        @foreach($slides as $slide)
        @if($slide->status === 0)
            <div class="col-md-6 pb-4 {{ $slide->status == 0 ? 'active' : '' }}">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="{{ asset('img/products/slider/' . $slide->image) }}" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">{{$slide->offer}}</h5>
                        <h1 class="mb-4 font-weight-semi-bold">{{$slide->title}}</h1>
                        <a href="{{ $slide->link }}" class="btn btn-outline-primary py-md-2 px-md-3">Mua ngay</a>
                    </div>
                </div>
            </div>
        @endif
        @endforeach
        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm nổi bật</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach($best_sell_products as $product)
                        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <a href="{{route('product.details', ['slug' => $product->slug])}}">
                                        @php
                                            $images = explode(',', $product->image);
                                            $firstImage = $images[0];
                                        @endphp
                                        <img class="img-fluid w-100" src="{{ asset('img/products/products/' . $firstImage) }}"
                                            alt="">
                                    </a>
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">
                                        <a style="font-weight: bold; color: black; font-size: 1.2em;"
                                            href="{{route('product.details', ['slug' => $product->slug])}}">{{$product->name}}
                                        </a>
                                    </h6>
                                    <div class="d-flex justify-content-center">
                                        <h6 style="font-weight: bold; color: red; font-size: 1.2em;font-family: Arial, sans-serif;">
                                            {{number_format($product->regular_price)}} ₫
                                        </h6>
                                        <h6 class="text-muted ml-2"><del>{{number_format($product->regular_price * 1.1)}} ₫</del>
                                        </h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    @livewireStyles
                                    @if(Auth::check())
                                        @if(Auth::user()->wishes && Auth::user()->wishes->pluck('product_id')->contains($product->id))
                                            <a style="color: red;" class="btn btn-sm text-dark p-0 " aria-label="Bỏ yêu thích"
                                                class="action-btn hover-up" href="#"
                                                wire:click.prevent="removeFromWishlist({{$product->id}})"><i
                                                    class="fas fa-heart text-primary"></i> &nbsp;Đã thích</a>
                                        @else
                                            <a class="btn btn-sm text-dark p-0 " aria-label="Yêu thích" class="action-btn hover-up" href="#"
                                                wire:click.prevent="addToWishlist({{$product->id}},'{{$product->name}}',{{$product->regular_price}})"><i
                                                    class="far fa-heart text-primary"></i> Yêu thích</a>
                                        @endif
                                    @else
                                        <a class="btn btn-sm text-dark p-0 " aria-label="Yêu thích" class="action-btn hover-up"
                                            href="{{route('login')}}"><i class="far fa-heart text-primary"></i> Yêu thích</a>
                                    @endif
                                    <a href="" class="btn btn-sm text-dark p-0 "></a>
                                    <a href="#" class="btn btn-sm text-dark p-0 "
                                        wire:click.prevent="store({{$product->id}},'{{$product->name}}',{{$product->regular_price}})">
                                        <i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ</a>
                                    @livewireScripts
                                </div>
                            </div>
                        </div>
            @endforeach  
        </div>
    </div>
    <!-- Products End -->


    <!-- Subscribe Start -->
    <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Cập nhật thông tin mới</span>
                    </h2>
                    <p>Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod
                        duo labore labore.</p>
                </div>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-white p-4" placeholder="Email Goes Here">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Đăng ký</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Subscribe End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm mới</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach($new_products as $product)
                        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <a href="{{route('product.details', ['slug' => $product->slug])}}">
                                        @php
                                            $images = explode(',', $product->image);
                                            $firstImage = $images[0];
                                        @endphp
                                        <img class="img-fluid w-100" src="{{ asset('img/products/products/' . $firstImage) }}"
                                            alt="">
                                    </a>
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">
                                        <a style="font-weight: bold; color: black; font-size: 1.2em;"
                                            href="{{route('product.details', ['slug' => $product->slug])}}">{{$product->name}}
                                        </a>
                                    </h6>
                                    <div class="d-flex justify-content-center">
                                        <h6 style="font-weight: bold; color: red; font-size: 1.2em;font-family: Arial, sans-serif;">
                                            {{number_format($product->regular_price)}} ₫</h6>
                                            <h6 class="text-muted ml-2"><del>{{number_format($product->regular_price * 1.1)}}
                                                    ₫</del></h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    @livewireStyles
                                    @if(Auth::check())
                                        @if(Auth::user()->wishes && Auth::user()->wishes->pluck('product_id')->contains($product->id))
                                            <a style="color: red;" class="btn btn-sm text-dark p-0 " aria-label="Bỏ yêu thích"
                                                class="action-btn hover-up" href="#"
                                                wire:click.prevent="removeFromWishlist({{$product->id}})"><i
                                                    class="fas fa-heart text-primary"></i> &nbsp;Đã thích</a>
                                        @else
                                            <a class="btn btn-sm text-dark p-0 " aria-label="Yêu thích" class="action-btn hover-up" href="#"
                                                wire:click.prevent="addToWishlist({{$product->id}},'{{$product->name}}',{{$product->regular_price}})"><i
                                                    class="far fa-heart text-primary"></i> Yêu thích</a>
                                        @endif
                                    @else
                                        <a class="btn btn-sm text-dark p-0 " aria-label="Yêu thích" class="action-btn hover-up"
                                            href="{{route('login')}}"><i class="far fa-heart text-primary"></i> Yêu thích</a>
                                    @endif
                                    <a href="" class="btn btn-sm text-dark p-0 "></a>
                                    <a href="#" class="btn btn-sm text-dark p-0 "
                                        wire:click.prevent="store({{$product->id}},'{{$product->name}}',{{$product->regular_price}})">
                                        <i class="fas fa-shopping-cart text-primary mr-1"></i>Thêm vào giỏ</a>
                                    @livewireScripts
                                </div>
                            </div>
                        </div>
            @endforeach
        </div>
    </div>
    <!-- Products End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="vendor-item border p-4">
                        <img src="img/apple.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/samsung.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/xiaomi.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/oppo.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/lenovo.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/dell.png" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/sony.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->


</div>