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
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow">Trang Chủ</a>
                    <span></span> Mua Sắm
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="shop-product-fillter">
                            <div class="totall-product">
                                <p> Chúng tôi tìm thấy <strong class="text-brand">{{$products->total()}} </strong>
                                    của danh mục 
                                    <strong class="text-brand">{{$category_name}}</strong>
                                </p>
                            </div>
                            <div class="sort-by-product-area">
                                <div class="sort-by-cover mr-10">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps"></i>Hiển thị:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span>{{$pageSize}} <i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="{{ $pageSize==12 ? 'active': ''}}"
                                                    wire:click.prevent="changePageSize(12)">12</a></li>
                                            <li><a class="{{ $pageSize==24 ? 'active': ''}}"
                                                    wire:click.prevent="changePageSize(24)">24</a></li>
                                            <li><a class="{{ $pageSize==36 ? 'active': ''}}"
                                                    wire:click.prevent="changePageSize(36)">36</a></li>
                                            <li><a class="{{ $pageSize==48 ? 'active': ''}}"
                                                    wire:click.prevent="changePageSize(48)">48</a></li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="sort-by-cover">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps-sort"></i>Sắp xếp:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span>{{$orderBy}}<i class="fi-rs-angle-small-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a class="{{ $orderBy=='Mặc định' ? 'active': ''}}"
                                                    wire:click.prevent="changeOrderBy('Mặc định')">Mặc định</a></li>
                                            <li><a class="{{ $orderBy=='Giá: thấp đến cao' ? 'active': ''}}"
                                                    wire:click.prevent="changeOrderBy('Giá: thấp đến cao')">Giá: thấp đến cao</a></li>
                                            <li><a class="{{ $orderBy=='Giá: cao đến thấp' ? 'active': ''}}"
                                                    wire:click.prevent="changeOrderBy('Giá: cao đến thấp')">Giá: cao đến thấp</a></li>
                                            <li><a class="{{ $orderBy=='Sản phẩm mới' ? 'active': ''}}"
                                                    wire:click.prevent="changeOrderBy('Sản phẩm mới')">Sản phẩm mới</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row product-grid-3">
                            @php 
                                $witems = Cart::instance('wishlist')->content()->pluck('id');
                            @endphp
                            @foreach($products as $product )
                            <div class="col-lg-4 col-md-4 col-6 col-sm-6">
                                <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{route('product.details',['slug'=>$product->slug])}}">
                                                <img class="default-img"
                                                    src="{{asset('assets/imgs/products/products')}}/{{$product->image}}"
                                                    alt="{{$product->name}}">
                                                <img class="hover-img"
                                                    src="{{asset('assets/imgs/products/products')}}/{{$product->image}}"
                                                    alt="{{$product->name}}">
                                            </a>
                                        </div>
                                     
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="hot">Hot</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            
                                        </div>
                                        <h2><a
                                                href="{{route('product.details',['slug'=>$product->slug])}}">{{$product->name}}</a>
                                        </h2>
                                        
                                        <div class="row">
                                        <div class="mb-3 mt-3"> 
                                        <div class="product-price">
                                            <span>{{number_format($product->regular_price)}} VND </span>
                                            <span class="old-price font-md ml-1">{{number_format($product->sale_price)}}</span>
                                            <!-- <span class="old-price">$245.8</span> -->
                                        </div>
                                        <div class="product-action-1 show">
                                            @livewireStyles
                                            @if(Auth::check())
                                                @if(Auth::user()->wishes && Auth::user()->wishes->pluck('product_id')->contains($product->id))
                                                    <a aria-label="Bỏ yêu thích" class="action-btn hover-up" style="background-color: #07b55b; color: #fff;" href="#" wire:click.prevent="removeFromWishlist({{$product->id}})"><i class="fi-rs-heart"></i></a>
                                                @else
                                                    <a aria-label="Yêu thích" class="action-btn hover-up" href="#" wire:click.prevent="addToWishlist({{$product->id}},'{{$product->name}}',{{$product->regular_price}})"><i class="fi-rs-heart"></i></a>
                                                @endif
                                            @else
                                                <a aria-label="Yêu thích" class="action-btn hover-up" href="{{route('login')}}"><i class="fi-rs-heart"></i></a>
                                            @endif
                                            <a aria-label="Thêm vào giỏ hàng" class="action-btn hover-up"
                                                wire:click.prevent="store({{$product->id}},'{{$product->name}}',{{$product->regular_price}})"><i
                                                    class="fi-rs-shopping-bag-add"></i></a>
                                            @livewireScripts

                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endforeach

                        </div>

                        <!--pagination-->
                        <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                            @livewireStyles
                            {{$products->links('pagination::bootstrap-4')}}
                            @livewireScripts


                            <!-- <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-start">
                                    <li class="page-item active"><a class="page-link" href="#">01</a></li>
                                    <li class="page-item"><a class="page-link" href="#">02</a></li>
                                    <li class="page-item"><a class="page-link" href="#">03</a></li>
                                    <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                                    <li class="page-item"><a class="page-link" href="#">16</a></li>
                                    <li class="page-item"><a class="page-link" href="#"><i class="fi-rs-angle-double-small-right"></i></a></li>
                                </ul>
                            </nav> -->
                        </div>
                    </div>
                    

                    <div class="col-lg-3 primary-sidebar">
                        <div class="row">
                            <div class="col-lg-12 col-mg-6"></div>
                            <div class="col-lg-12 col-mg-6"></div>
                        </div>
                        <!-- Fillter By Price -->
                        <div class=" sidebar-widget price_range range mb-30">
                            <div class="widget-header position-relative mb-20 pb-10">
                                <h5 class="widget-title mb-10">Lọc Theo Giá</h5>
                                <div class="bt-1 border-color-1"></div>
                            </div>
                            <div class="price-filter">
                                <div class="price-filter-inner">
                                    <div id="slider-range" wire:ignore></div>
                                    <div class="price_slider_amount">
                                        <div class="label-input">
                                            <span></span> <span class="text-info">{{$min_value}} VND</span> - <span class="text-info">{{$max_value}} VND</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                           
                        </div>
                        <div class="widget-category mb-30">
                            <h5 class="section-title style-1 mb-30 wow fadeIn animated">Danh Mục</h5>
                            <ul class="categories">
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{route('product.category',['slug'=>$category->slug])}}">
                                        {{$category->name}}
                                    </a>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @livewireScripts
</div>
@push('scripts')
    <script>
        var sliderrange = $('#slider-range');
        var amountprice = $('#amount');
        $(function() {
            sliderrange.slider({
                range: true,
                min: 10000,
                max: 900000,
                values: [10000, 900000],
                slide: function(event, ui) {
                    //amountprice.val("$" + ui.values[0] + " - $" + ui.values[1]);
                    @this.set('min_value',ui.values[0]);
                    @this.set('max_value',ui.values[1]);
                }
            });
        }); 
    </script>
@endpush