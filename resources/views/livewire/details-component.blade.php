<div>
<style>
    .description-container {
        position: relative;
    }

    .toggle-button {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px 10px;
        cursor: pointer;
        color: red;
        font-size: 2rem;
        background-image: linear-gradient(transparent, white);
        width: 100%;
        text-align: center;
        font-weight: bold;
    }

    .description-content.expanded {
        height: auto;
    }

</style>
<link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/css/lightgallery.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/thumbnail/lg-thumbnail.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/zoom/lg-zoom.min.css" rel="stylesheet">

    @php
        $averageRating = 0;
        $totalRatings = 0;
        if ($product) {
            $totalRatings = count($product->reviews);
            $sumRatings = 0;

            foreach ($product->reviews as $review) {
                $sumRatings += $review->rating;
            }

            $averageRating = $totalRatings > 0 ? $sumRatings / $totalRatings : 0;
        }
    @endphp
    @if(!$product)
            <div class="container-fluid bg-secondary mb-5">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
                <h1 class="font-weight-semi-bold text-uppercase mb-3">Sản Phẩm Không tại Hoặc đã xóa</h1>
                <div class="d-inline-flex">
                    <p class="m-0"><a href="">Trang chủ</a></p>
                    <p class="m-0 px-2">-</p>
                    <p class="m-0">Chi tiết sản phẩm</p>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid py-5">
            <div class="row px-xl-5">
                <div class="col-lg-5 pb-5" style="min-width: 600px; ">
                <div id="lightgallery" class="carousel slide" data-ride="carousel" style="width: 600px; height: 500px; overflow: hidden; position: relative;"> 
    <div class="carousel-inner border" style="width: 100%; height: 100%; position: relative;">
        @php
            $images = explode(',', $product->image);
        @endphp
        @foreach($images as $index => $image)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" wire:ignore style="width: 100%; height: 100%; position: absolute;">
            <a href="{{ asset('img/products/products/' . $image) }}" data-lg-size="1600-1068" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"> 
                <img src="{{ asset('img/products/products/' . $image) }}" alt="Image" style="max-width: 100%; max-height: 100%; object-fit: contain;"> 
            </a>
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#lightgallery" data-slide="prev">
        <i class="fa fa-2x fa-angle-left text-dark"></i>
    </a>
    <a class="carousel-control-next" href="#lightgallery" data-slide="next">
        <i class="fa fa-2x fa-angle-right text-dark"></i>
    </a>
</div>

                </div>


                <div class="col-lg-7 pb-5">
                    <h3 class="font-weight-semi-bold">{{$product->name}}</h3>
                    <div class="d-flex mb-3">
                        @php
                            $totalRatings = count($product->reviews);
                            $countRatings = [0, 0, 0, 0, 0];
                            $sumRatings = 0;

                            foreach ($product->reviews as $review) {
                                $sumRatings += $review->rating;
                                switch ($review->rating) {
                                    case 1:
                                        $countRatings[0] += 1;
                                        break;
                                    case 2:
                                        $countRatings[1] += 1;
                                        break;
                                    case 3:
                                        $countRatings[2] += 1;
                                        break;
                                    case 4:
                                        $countRatings[3] += 1;
                                        break;
                                    default:
                                        $countRatings[4] += 1;
                                }
                            }

                            $averageRating = $totalRatings > 0 ? $sumRatings / $totalRatings : 0;
                        @endphp
                        <div class="text-primary mr-2" wire:ignore>
                            <small class="star far fa-star"></small>
                            <small class="star far fa-star"></small>
                            <small class="star far fa-star"></small>
                            <small class="star far fa-star"></small>
                            <small class="star far fa-star"></small>
                        </div>
                        <small class="pt-1">({{$totalRatings}} Đánh giá)</small>
                    </div>

                        <p style="font-size:17px">Thương hiệu: <span class="text-brand"
                                style="color:#67a0f7 ; font-weight: bold;">{{ $product->brand->name }}</span>
                        </p>

                    <p style="font-size:17px;">Danh mục: <span class="text-brand" style="color:#67a0f7 ; font-weight: bold;">{{ $product->category->name }}</span></p>
                    <p style="font-size:17px">Đã bán: <span class="text-brand">{{ $product->quantity_sold }}</span></p>
                    <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Mẫu khác:</p>
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="currentProduct" name="productRadio" value="{{$product->slug}}" checked>
                            <label class="custom-control-label" for="currentProduct">Hiện tại</label>
                        </div>
                        @foreach($rproducts as $similarProduct)
                            @php
                                $currentProductLine = implode(' ', array_slice(explode(' ', $product->name), 0, -1)); 
                                $similarProductLine = implode(' ', array_slice(explode(' ', $similarProduct->name), 0, -1));
                            @endphp

                            @if ($currentProductLine === $similarProductLine && $similarProduct->id != $product->id)
                                <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" 
                                class="custom-control-input" 
                                id="similarProduct{{$similarProduct->id}}" 
                                name="productRadio" 
                                value="{{$similarProduct->id}}"
                                data-slug="{{ route('product.details', ['slug' => $similarProduct->slug]) }}">
                                <label class="custom-control-label" for="similarProduct{{$similarProduct->id}}">{{substr($similarProduct->name, -5)}}</label> 
                                </div>
                            @endif
                        @endforeach
                    </form>
                </div>
                    <h3 class="font-weight-semi-bold mb-4" style="color:red;">{{number_format($product->regular_price)}} VND
                    </h3>
                    <p class="mb-4"></p>
                    <div class="d-flex align-items-center mb-4 pt-2">

                        <div class="input-group quantity mr-3" style="width: 130px;" >
                            @if($quantity != 1)
                                <div class="input-group-btn" >
                                    <button class="btn btn-primary btn-minus" wire:click.prevent="decrementQuantity()">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            @endif
                            <input type="text" class="form-control bg-secondary text-center" value="{{$quantity}}">
                            @if($quantity != $product->quantity)
                                <div class="input-group-btn">
                                    <button class="btn btn-primary btn-plus" wire:click.prevent="incrementQuantity()">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        @if($product->quantity > 0)
                            <button class="btn btn-primary px-3"
                                wire:click.prevent="store({{$product->id}},'{{$product->name}}',{{$product->regular_price}}, {{$quantity}})"><i
                                    class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</button>
                        @else 
                            <button class="btn btn-primary px-3" style="color:white; font-weight: bold;"
                                onclick="addToCart('{{$product->name}}')">HẾT HÀNG</button>
                        @endif
                    </div>
                    <div class="d-flex pt-2">
                        <p class="text-dark font-weight-medium mb-0 mr-2">Chia sẻ:</p>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row px-xl-5">
                <div class="col">
                    <div class="nav nav-tabs justify-content-center border-secondary mb-4" wire:ignore>
                        <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1" wire:ignore>Chi tiết</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Vận chuyển</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Đánh giá ({{$totalRatings}})</a>
                    </div>
                    <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1" wire:ignore>
                    <div class="description-container" style="position: relative; height: 400px; overflow: hidden;">
                            <div class="description-content" id="description-content">
                                {!! $product->description !!}
                            </div>
                            <span id="toggle-button" class="toggle-button">Đọc thêm</span>
                        </div>
                    </div>
                        <div class="tab-pane fade" id="tab-pane-2" wire:ignore>
                            <h4 class="mb-3">Thông tin vận chuyển</h4>
                            <p>Giá thành và thời gian vận chuyển .</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Nội thành
                                        </li>
                                        <li class="list-group-item px-0">
                                            Giá vận chuyển: 10-15k.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Thời gian giao: 1-2 ngày.
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Ngoại thành
                                        </li>
                                        <li class="list-group-item px-0">
                                            Giá vận chuyển: 20-35k.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Thời gian giao: 3-5 ngày.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3" wire:ignore>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">{{$totalRatings}} review Sản phẩm "{{$product->name}}"</h4>
                                    @foreach($reviews as $review)
                                        @if($review->status == 0)
                                            <div id="review-{{ $review->user->id }}-{{ $review->id }}" class="media rounded border px-1 py-2 mb-4" style="background-color: #fff; border-width: 3px;" data-rating="{{ $review->rating }}">
                                                <img src="{{ $review->user->profile_photo_path ? asset($review->user->profile_photo_path) : asset('img/user.png') }}" alt="User Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                                <div class="media-body">
                                                    <h6>{{ $review->user->name }}<small> - <i>{{ $review->updated_at->timezone('Asia/Ho_Chi_Minh')->format('H:i d-m-Y') }}</i></small></h6>
                                                    <div class="text-primary mr-2" wire:ignore>
                                                        <small class="star1 far fa-star"></small>
                                                        <small class="star1 far fa-star"></small>
                                                        <small class="star1 far fa-star"></small>
                                                        <small class="star1 far fa-star"></small>
                                                        <small class="star1 far fa-star"></small>
                                                    </div>
                                                    <p>{{ $review->comment }}</p>
                                                </div>
                                                <a aria-label="" class="action-btn hover-up d-flex gap-1 align-items-center" href="#" style="color: {{ Auth::check() && $review->review_likes->where('user_id', Auth::user()->id)->first() ? '#07b55b' : '#999' }};" wire:click.prevent="likeReview({{ $review->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="18" height="18" fill="{{ Auth::check() && $review->review_likes->where('user_id', Auth::user()->id)->first() ? '#07b55b' : '#999' }}">
                                                        <path d="M6,8H3a3,3,0,0,0-3,3v8a3,3,0,0,0,3,3H6Z"/>
                                                        <path d="M14,8l.555-3.328a2.269,2.269,0,0,0-1.264-2.486,2.247,2.247,0,0,0-2.9,1.037L8,8V22H22l2-11V8Z"/>
                                                    </svg>
                                                    {{ $review->review_likes && $review->review_likes->count() > 0 ? (Auth::check() && $review->review_likes->where('user_id', Auth::user()->id)->first() ? 'Đã thích' : '') . ' (' . $review->review_likes->count() . ')' : 'Hữu ích?' }}
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                                <div class="col-md-6">
                                @if(Auth::check())
                                            @if(Auth::user()->utype === 'USR')
                                                @if($errors->any())
                                                    <div class="alert alert-danger" role="alert">Vui lòng đánh giá sản phẩm trước
                                                        khi gửi.</div>
                                                @endif

                                                @if(Session::has('error_message'))
                                                    <div class="alert alert-danger" role="alert">{{Session::get('error_message')}}
                                                    </div>
                                                @endif

                                                @if(Session::has('success_message'))
                                                    <div class="alert alert-success" role="alert">
                                                        {{Session::get('success_message')}}</div>
                                                @endif

                                                <div class="comment-form pt-0 border-0">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <form class="form-contact comment_form"
                                                                wire:submit.prevent="submitReview" wire:ignore id="commentForm">
                                                                <h4 class="">Thêm đánh giá của bạn</h4>
                                                                <div id="stars" style="margin-top: 20px;" wire:ignore>

                                                                    <label id="label1" for="star1"
                                                                        style="cursor: pointer; font-size: 35px; color: gold; margin: 0 5px;"
                                                                        onclick="setRating(1)">
                                                                        <input required type="radio" name="rating" id="star1"
                                                                            value="1" style="display: none"
                                                                            wire:model.lazy="rating">★
                                                                    </label>

                                                                    <label id="label2" for="star2"
                                                                        style="cursor: pointer; font-size: 35px; color: gold; margin: 0 5px;"
                                                                        onclick="setRating(2)">
                                                                        <input type="radio" name="rating" id="star2" value="2"
                                                                            style="display: none" wire:model.lazy="rating">★
                                                                    </label>

                                                                    <label id="label3" for="star3"
                                                                        style="cursor: pointer; font-size: 35px; color: gold; margin: 0 5px;"
                                                                        onclick="setRating(3)">
                                                                        <input type="radio" name="rating" id="star3" value="3"
                                                                            style="display: none" wire:model.lazy="rating">★
                                                                    </label>

                                                                    <label id="label4" for="star4"
                                                                        style="cursor: pointer; font-size: 35px; color: gold; margin: 0 5px;"
                                                                        onclick="setRating(4)">
                                                                        <input type="radio" name="rating" id="star4" value="4"
                                                                            style="display: none" wire:model.lazy="rating">★
                                                                    </label>

                                                                    <label id="label5" for="star5"
                                                                        style="cursor: pointer; font-size: 35px; color: gold; margin: 0 5px;"
                                                                        onclick="setRating(5)">
                                                                        <input type="radio" name="rating" id="star5" value="5"
                                                                            style="display: none" wire:model.lazy="rating">★
                                                                    </label>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <textarea class="form-control w-100" name="comment"
                                                                                wire:model.lazy="comment" id="comment" cols="30"
                                                                                rows="5"
                                                                                placeholder="Viết đánh giá của bạn về sản phẩm này."></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-primary button-contactForm">Gửi
                                                                        đánh giá</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        @else

                                            <h4 class="">Đăng nhập để được đánh giá.</h4>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Detail End -->


        <!-- Products Start -->
        <div class="container-fluid py-5">
            <div class="text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">Sản phẩm liên quan</span></h2>
            </div>
            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel related-carousel" wire:ignore>
                        @foreach($rproducts as $rproduct)
                        <div class="card product-item border-0">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0" style="height: 350px; ">
                                <a href="{{ route('product.details', ['slug' => $rproduct->slug]) }}">
                                    @php
                                        $images = explode(',', $rproduct->image);
                                        $firstImage = $images[0];
                                    @endphp
                                    <img class="img-fluid " src="{{ asset('img/products/products/' . $firstImage) }}" alt="">
                                </a>
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">
                                    <a style="font-weight: bold; color: black; font-size: 1.2em;"
                                        href="{{ route('product.details', ['slug' => $rproduct->slug]) }}">{{ $rproduct->name }}</a>
                                </h6>
                                <div class="d-flex justify-content-center">
                                    <h6 style="font-weight: bold; color: red; font-size: 1.2em; font-family: Arial, sans-serif;">
                                        {{ number_format($rproduct->regular_price) }} ₫
                                    </h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">


                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        <!-- Products End -->

    @endif






<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/lightgallery.min.js"></script>

<script>
    const radioButtons = document.querySelectorAll('input[name="productRadio"]');

    radioButtons.forEach(radioButton => {
        radioButton.addEventListener('click', function () {
            window.location.href = this.dataset.slug; 
        });
    });
</script>


<script>
    Livewire.on('showSuccessMessage', () => {
        Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Đã gửi đánh giá!',
        showConfirmButton: false,
        timer: 1500
        });
        setTimeout(() => {
            window.location.reload();
        }, 1500); 
    });
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const content = document.getElementById('description-content');
        const container = document.querySelector('.description-container');
        const button = document.getElementById('toggle-button');
        let isExpanded = false;

        button.addEventListener('click', function() {
            if (isExpanded) {
                content.classList.remove('expanded');
                container.style.height = '400px';
                button.textContent = 'Đọc thêm';
            } else {
                content.classList.add('expanded');
                container.style.height = content.scrollHeight + 'px';
                button.textContent = 'Thu gọn';
            }
            isExpanded = !isExpanded;
        });

        function setStarRating(element, rating) {
            const stars = element.querySelectorAll('.star, .star1');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        }

        const averageRating = <?php echo $averageRating; ?>;
        setStarRating(document, averageRating);

        document.querySelectorAll('.media[data-rating]').forEach(review => {
            const reviewRating = review.getAttribute('data-rating');
            setStarRating(review, reviewRating);
        });
        function setRating(rating) {
        for (let i = 1; i <= 5; i++) {
            document.getElementById('label' + i).style.color = '#ccc';
        }

        for (let i = 1; i <= rating; i++) {
            document.getElementById('label' + i).style.color = 'gold';
        }
    }

            const starLabels = document.querySelectorAll('#stars label');
            starLabels.forEach((label, index) => {
                label.addEventListener('click', function (event) {
                    event.preventDefault(); 
                    event.stopPropagation();
                    setRating(index + 1);
                    return false; 
                });
            });

 
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });

            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
            }
        });

        lightGallery(document.getElementById('lightgallery'), {
                thumbnail: true,
                animateThumb: true,
                showThumbByDefault: true,
                zoom: true,
                scale: 1,
                download: true,
                selector: '.carousel-item a', 
                exThumbImage: 'data-exThumbImage' 
            });
</script>

</div>