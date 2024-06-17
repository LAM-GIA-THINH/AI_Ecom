<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Think Mart - AI</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <link href="{{ asset('img/theme/favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>

        .coze-webchat {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px; 
        }
    </style>
    <style>
        .fda3723591e0b38e7e52 {
            top: 650px;
        }
    </style>
    <style>
        body,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        a,
        span {
            font-family: Arial, sans-serif !important;
        }
    </style>
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

    @livewireStyles
</head>

<body>

    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Trợ giúp</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Tư vấn</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
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
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="/" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">Think</span>Mart</h1>
                </a>
            </div>
            @livewire('search')

            <div class="row header-action-2 align-items-center " style="margin-top:0px; margin-left:auto; margin-right:15px;">
                <a href="">
                    @livewire('wishlist-icon-component')
                </a>
                <a href="" >
                    @livewire('cart-icon-component')
                </a>


                @auth

                    <div class="btn-group dropdown d-flex align-items-center" style="margin-left:15px">
                        <div class="rounded border px-1 py-0 d-flex align-items-center " style="background-color: #fff;">
                            <a class="nav-link" data-toggle="collapse" href="#navbar-vertical1" style="display: flex;">
                                <div class="rounded-circle img-thumbnail mr-2"
                                    style="width: 30px; height: 30px; overflow: hidden; background-size: cover; background-position: center; background-image: url('{{Auth::user()->profile_photo_path ? asset('img/products/avatars/' . Auth::user()->profile_photo_path) : asset('assets/imgs/user.png')}}')">
                                </div>
                                <div style="margin-top:3px;">
                                    {{ Auth::user()->name }}
                                    @if(Auth::user()->utype === "SHIP")
                                        <span class="badge bg-warning text-dark">Shipper</span>
                                    @elseif(Auth::user()->utype === "ADM")
                                        <span class="badge bg-danger text-light">Admin</span>
                                    @elseif(Auth::user()->utype === "GAR")
                                        <span class="badge text-white" style="background-color: blue;">QL Kho</span>
                                    @endif
                                </div>
                                <i class="fi-rs-angle-down ml-1"></i>
                            </a>
                            <nav class="collapse navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 position-absolute"
                                style="top: 100%; left: 0; z-index: 100;" id="navbar-vertical1">
                                <div class="navbar-nav w-100 overflow-hidden"
                                    style="max-height: 410px;;background-color:white">
                                    <a class="dropdown-item" href="{{route('profile.edit')}}">Trang cá nhân</a>
                                    @if(Auth::user()->utype === "USR")
                                        <a class="dropdown-item" href="{{route('user.orders')}}">Đơn hàng</a>
                                    @elseif(Auth::user()->utype === "ADM" || Auth::user()->utype === "SHIP" || Auth::user()->utype === "GAR")
                                        <a class="dropdown-item" href="{{route('admin.dashboard')}}">Trang quản lý</a>
                                    @endif
                                    <div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button class="dropdown-item text-danger text-align-center"
                                                onClick="event.preventDefault(); this.closest('form').submit();">Đăng
                                                xuất</button>
                                        </form>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                @else
                <div class="col">
                    <a href="{{ route('login') }}" style="text-decoration: none;">
                        <span style="margin-right: 5px;">Đăng nhập </span>
                    </a>
                    <span style="margin-right: 5px;">/</span>
                    <a href="{{ route('register') }}" style="text-decoration: none;">
                        <span>Đăng ký</span>
                    </a>
                </div>
                @endif 
            </div>
        </div>

    </div>


    {{$slot}}


    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border border-white px-3 mr-1">Think</span>Mart</h1>
                </a>
                <p>Chúng tôi cung cấp các sản phẩm công nghệ hàng đầu - tất cả đều được chọn lọc kỹ càng để phù hợp với mọi nhu cầu và phong cách sống.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>21 Cao Thắng, Đà Nẵng, Việt Nam
                </p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>2050531200340@sv.ute.udn.vn</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+093 5425 651</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Đường dẫn</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Trang
                                chủ</a>
                            <a class="text-dark mb-2" href="shop/all"><i class="fa fa-angle-right mr-2"></i>Mua sắm</a>
                            <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Chi
                                tiết</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Giỏ
                                hàng</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Thanh
                                toán</a>
                            <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Liên hệ</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">


                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Nhận mail</h5>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4" placeholder="Tên của bạn"
                                    required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4" placeholder="Email"
                                    required="required" />
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block border-0 py-3" type="submit">Đăng ký
                                    ngay</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">Think Mart</a>.<br>
                    Sản phẩm của <a href="" target="_blank">Lâm Gia Thịnh</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <script src="https://sf-cdn.coze.com/obj/unpkg-va/flow-platform/chat-app-sdk/0.1.0-beta.3/libs/oversea/index.js"></script>
      <script>
          new CozeWebSDK.WebChatClient({
            config: {
              bot_id: '7346487317957263361',
            },
            componentProps: {
                title: 'Think Mart',
                icon: 'https://files.catbox.moe/fuwjvx.png',
            },
          });
      </script>
    <script src="{{ asset('https://code.jquery.com/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

    @livewireScripts

    <script src="{{ asset('js/main.js') }}"></script>

    <script src="{{ asset('https://cdn.jsdelivr.net/npm/sweetalert2@11') }}"></script>

    @stack('scripts')
</body>

</html>