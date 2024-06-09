<div>
    <style>
        .wishlisted {
            background-color: #F15412 !important;
            border: 1px solid transparent !important;
        }

        .wishlisted i {
            color: #fff !important;
        }

        ul {
            list-style: none;
        }
    </style>

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 style="font-family: Arial, sans-serif;" class="font-weight-semi-bold text-uppercase mb-3">
                Đã tìm thấy <strong class="text-brand">{{$products->total()}}</strong> sản phẩm cho bạn!
            </h1>

            <div class="d-inline-flex">
                <p class="m-0"><a href="">Trang chủ</a></p>
                <p class="m-0 px-2">/</p>
                <p class="m-0">Mua sắm</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Lọc theo giá</h5>
                    <form>

                        <div class="price-filter">
                            <div class="price-filter-inner">
                                <div id="slider-range" wire:ignore></div>
                                <div class="price_slider_amount">
                                    <br>
                                    <div class="label-input" style="font-size: 1.2em;text-align:center">
                                        <span></span> <span class="text-info">{{number_format($min_value)}} VND</span> -
                                        <span class="text-info">{{number_format($max_value)}} VND</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- Price End -->

                <div class="mb-5">
                    <h5 class="font-weight-semi-bold mb-4">Lọc theo danh mục</h5>
                    <form>
                        @foreach($categories as $category)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" id="category-{{ $category->id }}"
                                name="checkboxCategory" 
                                value="{{$category->id}}"
                                data-slug="{{ route('product.category', ['slug' => $category->slug]) }}">
                                <label class="custom-control-label" for="category-{{ $category->id }}"
                                    style="font-size: 1.2em;">
                                    <a href="{{ route('product.category', ['slug' => $category->slug]) }}">
                                        {{ $category->name }}
                                    </a>

                                </label>
                                <span class="badge border font-weight-normal">{{ $category->products_count }}</span>

                            </div>
                        @endforeach
                    </form>
                </div>

                <!-- Size Start -->

                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Nhập tên sản phẩm">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-transparent text-primary">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            <div class="ml-auto">
                                <div class="dropdown d-inline-block mr-3">
                                    <button class="btn border dropdown-toggle" type="button" id="pageSizeDropdown"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Hiển thị {{$pageSize}} <i class="fi-rs-angle-small-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" style="height:110px"
                                        aria-labelledby="pageSizeDropdown">
                                        <ul style="padding-left: 0;">
                                            <li><a href="" class="dropdown-item {{ $pageSize == 12 ? 'active' : ''}}"
                                                    wire:click.prevent="changePageSize(12)">12</a></li>
                                            <li><a href="" class="dropdown-item {{ $pageSize == 24 ? 'active' : ''}}"
                                                    wire:click.prevent="changePageSize(24)">24</a></li>
                                            <li><a href="" class="dropdown-item {{ $pageSize == 36 ? 'active' : ''}}"
                                                    wire:click.prevent="changePageSize(36)">36</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="dropdown d-inline-block">
                                    <button class="btn border dropdown-toggle" type="button" id="filterDropdown"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Lọc theo {{$orderBy}} <i class="fi-rs-angle-small-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
                                        <ul style=" padding-left:0">
                                            <li><a href=""
                                                    class="dropdown-item {{ $orderBy == 'Mặc định' ? 'active' : ''}}"
                                                    wire:click.prevent="changeOrderBy('Mặc định')">Mặc định</a></li>
                                            <li><a href=""
                                                    class="dropdown-item {{ $orderBy == 'Giá: thấp đến cao' ? 'active' : ''}}"
                                                    wire:click.prevent="changeOrderBy('Giá: thấp đến cao')">Giá: thấp
                                                    đến cao</a></li>
                                            <li><a href=""
                                                    class="dropdown-item {{ $orderBy == 'Giá: cao đến thấp' ? 'active' : ''}}"
                                                    wire:click.prevent="changeOrderBy('Giá: cao đến thấp')">Giá: cao đến
                                                    thấp</a></li>
                                            <li><a href=""
                                                    class="dropdown-item {{ $orderBy == 'Sản phẩm mới' ? 'active' : ''}}"
                                                    wire:click.prevent="changeOrderBy('Sản phẩm mới')">Sản phẩm mới</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($products as $product)
                                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                                            <div class="card product-item border-0 mb-4">
                                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0"
                                                    style="height: 350px; ">
                                                    <a href="{{route('product.details', ['slug' => $product->slug])}}">
                                                        @php
                                                            $images = explode(',', $product->image);
                                                            $firstImage = $images[0];
                                                        @endphp
                                                        <img class="img-fluid w-100"
                                                            src="{{ asset('img/products/products/' . $firstImage) }}" alt="">
                                                    </a>
                                                </div>
                                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                                    <h6 class="text-truncate mb-3"><a
                                                            style="font-weight: bold; color: black; font-size: 1.2em;"
                                                            href="{{route('product.details', ['slug' => $product->slug])}}">{{$product->name}}</a>
                                                    </h6>
                                                    <div class="d-flex justify-content-center">
                                                        <h6
                                                            style="font-weight: bold; color: red; font-size: 1.2em;font-family: Arial, sans-serif;">
                                                            {{number_format($product->regular_price)}} ₫
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="card-footer d-flex justify-content-between bg-light border">

                                                    @if(Auth::check())
                                                        @if(Auth::user()->wishes && Auth::user()->wishes->pluck('product_id')->contains($product->id))
                                                            <a style="color: red;" class="btn btn-sm text-dark p-0 " aria-label="Bỏ yêu thích"
                                                                class="action-btn hover-up" href="#"
                                                                wire:click.prevent="removeFromWishlist({{$product->id}})"><i
                                                                    class="fas fa-heart text-primary"></i> &nbsp;Đã thích</a>
                                                        @else
                                                            <a class="btn btn-sm text-dark p-0 " aria-label="Yêu thích" class="action-btn hover-up"
                                                                href="#"
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

                                                </div>
                                            </div>
                                        </div>
                    @endforeach

                    <div class="col-12 pb-1">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-3">
                                {{$products->links('pagination::bootstrap-4')}}
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        const checkBoxes = document.querySelectorAll('input[name="checkboxCategory"]');

        checkBoxes.forEach(checkBox => {
            checkBox.addEventListener('click', function () {
                window.location.href = this.dataset.slug;
                this.checked = false;
            });
        });
    </script>
    <script>
        var sliderrange = $('#slider-range');
        console.log(sliderrange.slider);
        var amountprice = $('#amount');
        $(function () {
            sliderrange.slider({
                range: true,
                min: 100000,
                max: 90000000,
                values: [100000, 90000000],
                slide: function (event, ui) {
                    //amountprice.val("$" + ui.values[0] + " - $" + ui.values[1]);
                    @this.set('min_value', ui.values[0]);
                    @this.set('max_value', ui.values[1]);
                }
            });
        }); 
    </script>
</div>