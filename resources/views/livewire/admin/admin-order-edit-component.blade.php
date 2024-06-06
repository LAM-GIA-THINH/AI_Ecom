<div>
        <main class="main">
            <div class="container" style="background-color: #f0f0f0; text-align: center; padding: 20px; margin-bottom: 20px">
                <h2 style="margin: 0; font-size: 24px; font-weight: bold; color: black;">Cập nhật đơn hàng</h2>
            </div>
            <section class="mt-50 mb-50">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Cập nhật trạng thái đơn hàng
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{route('admin.orders')}}" class="btn btn-success float-end">Tất cả đơn hàng</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(Session::has('message'))
                                    <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                                    @endif
                                    @if(Session::has('error'))
                                    <div class="alert alert-danger" role="alert">{{Session::get('error')}}</div>
                                    @endif
                                    <form wire:submit.prevent="updateOrder">
                                        <div class="row">
                                            <div class="mb-3 mt-3 col-md-3">
                                                <label for="order_id" class="form-label">Mã đơn hàng</label>
                                                <input type="text" name="order_id" class="form-control"  wire:model="order_id" disabled/>
                                            </div>
                                            <div class="mb-3 mt-3 col-md-3">
                                                <label for="name" class="form-label">Tên khách hàng</label>
                                                <input type="text" name="name" class="form-control"  wire:model="name" disabled/>
                                            </div>
                                            <div class="mb-3 mt-3 col-md-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="text" name="email" class="form-control"  wire:model="email" disabled/>
                                            </div>
                                            <div class="mb-3 mt-3 col-md-3">
                                                <label for="phone" class="form-label">Số điện thoại</label>
                                                <input class="form-control"  name="phone"  wire:model="phone" disabled></input>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="mb-3 mt-3 col-md-6">
                                                <label for="address" class="form-label">Địa chỉ</label>
                                                <textarea type="text" name="address" class="form-control"  wire:model="address" disabled></textarea>
                                            </div>
                                            <div class="mb-3 mt-3 col-md-6">
                                                <label for="note" class="form-label">Ghi chú</label>
                                                <textarea type="text" name="note" class="form-control"  wire:model="note" disabled></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 mt-3 col-md-6">
                                                <label for="payment_method" class="form-label" wire:model="payment_method">Phương thức thanh toán</label>
                                                <select class="form-control" name="payment_method" wire:model="payment_method" disabled>
                                                    <option value="cod">Thanh toán khi giao hàng</option>
                                                    <option value="vnpay">Chuyển khoản</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 mt-3 col-md-6">
                                                <label for="payment_status" class="form-label" wire:model="payment_status">Trạng thái thanh toán</label>
                                                <select class="form-control" name="payment_status" wire:model="payment_status" disabled>
                                                    <option value="0">Chưa thanh toán</option>
                                                    <option value="1">Đã thanh toán</option>
                                                    <option value="2">Thanh toán lỗi</option>
                                                    <option value="3">Đã hoàn tiền</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 mt-3 col-md-6">
                                                <label for="order_status" class="form-label" wire:model="order_status" >Trạng thái đơn hàng</label>
                                                <select class="form-select" style="background-color:white" name="order_status" wire:model="order_status" @if($order_status == '4' || $order_status == '3') readonly @endif>
                                                    <option value="0">Chờ duyệt</option>
                                                    <option value="1">Duyệt</option>
                                                    <option value="2">Đang giao hàng</option>
                                                    <option value="3">Hoàn thành</option>
                                                    <option value="4">Huỷ</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 mt-3 col-md-6" wire:ignore>
                                                <label for="ship_id" class="form-label" >Nhân viên giao hàng</label>
                                                <select class="form-select" style="background-color:white" name="ship_id" wire:model="shipper_id" id="userSelect">
                                                    <option value="">Chọn nhân viên</option>
                                                    @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('ship_id')
                                                <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">

                                        </div>
                                        <div class="table-responsive order_table text-center">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">Các sản phẩm</th>
                                                        <th>Tổng tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($orderItemsWithProducts as $orderItem)
                                                    <tr>
                                                        <td class="image product-thumbnail">
                                                            @php
                                                            $images = explode(',', $orderItem->product->image);
                                                            $firstImage = $images[0];
                                                            @endphp 
                                                            <img src="{{ asset('img/products/products/' . $firstImage) }}" alt="#" width="200" height="200">
                                                        </td>
                                                        <td>
                                                            <h5>
                                                                <a href="{{ route('product.details', ['slug' => $orderItem->product->slug]) }}">
                                                                    {{ $orderItem->product->name }}
                                                                </a>  x {{ $orderItem->quantity }}
                                                            </h5>
                                                            <span class="product-qty">{{ number_format($orderItem->unit_price) }} VND</span>
                                                        </td>
                                                        <td>{{ number_format($orderItem->unit_price * $orderItem->quantity) }} VND</td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <th>Tổng tiền các sản phẩm</th>
                                                        <td class="product-subtotal" colspan="2">{{$sub_total}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phí giao hàng</th>
                                                        <td colspan="2"><em>{{$shipping}}</em></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tổng cộng</th>
                                                        <td colspan="2" class="product-subtotal">
                                                            <span class="font-xl text-brand fw-900">{{$amount}}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-end">Cập nhật</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>