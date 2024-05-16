<div>
@livewireStyles
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Giỏ hàng</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Giỏ hàng</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
            @if(Session::has('success_message'))
                <div class="alert alert-success">
                    <strong>{{Session::get('success_message')}}</strong>
                </div>
            @endif
            @if(Session::has('error_message'))
                <div class="alert alert-danger">
                    <strong>{{Session::get('error_message')}}</strong>
                </div>
            @endif
            @if(Auth::user()->carts->count()>0)
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th>Loại bỏ</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                    @foreach($carts as $item)
                        <tr>
                            <td class="align-middle">
                            @php
                                    $images = explode(',', $item->product->image);
                                    $firstImage = $images[0];
                                @endphp                           
                            <img src="{{ asset('img/products/products/' . $firstImage) }}" alt="" style="width: 50px;">
                            <a href="{{route('product.details',['slug'=>$item->product->slug])}}">{{$item->product->name}}</a>
                            </td>
                            <td class="align-middle">{{number_format(intval(str_replace(',', '',$item->product->regular_price)))}} VND</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" wire:click.prevent="decrementQuantity({{$item->id}})" >
                                        <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary text-center" value="{{$item->quantity}}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus" wire:click.prevent="incrementQuantity({{$item->id}})">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">{{number_format(intval(str_replace(',', '',$item->quantity * $item->product->regular_price)))}} VND</td>
                            <td class="align-middle"><button class="btn btn-sm btn-primary" wire:click.prevent="destroy('{{$item->id}}')"><i class="fa fa-times"></i></button></td>
                        </tr>
                        
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex align-items-end"><a href="#" class="text-danger ms-auto" wire:click.prevent="clearAll()">Xóa tất cả sản phẩm</a></div>
                @else
                    <div class="alert alert-warning">Chưa có sản phẩm trong giỏ hàng</div>
                @endif
            </div>
            <div class="col-lg-4">
                <form class="mb-5" action="">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                @if(Auth::user()->carts->count()>0)
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Thông tin</h4>
                    </div>

                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Tổng tiền các sản phẩm:</h5>
                            <h5 class="font-weight-bold">{{
                                                            number_format(intval(str_replace(',', '',Auth::user()->carts->sum(function($cart) {
                                                            return $cart->quantity * $cart->product->regular_price;
                                                        }))))}} VND</h5>
                        </div>
                        <a href="{{route('user.checkout')}}" class="btn btn-block btn-primary my-3 py-3">Mua hàng</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
