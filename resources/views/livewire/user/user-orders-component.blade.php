<div>
<main class="main">

    <section class="pt-4 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="dashboard-menu">
                                <ul class="nav nav-tabs justify-content-start border-secondary mb-4" role="tablist">
                                <li class="nav-item">
                                        <a class="nav-link active" id="orders-tab" href="{{route('user.orders')}}"><i
                                                class="fi-rs-shopping-bag mr-10"></i>Đơn hàng</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('profile.edit')}}">
                                            <i class="fi-rs-user mr-10"></i>Thông tin tài khoản</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="tab-content dashboard-content">
                                <div class="tab-pane fade active show" id="orders" role="tabpanel"
                                    aria-labelledby="orders-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Đơn hàng của bạn</h5>
                                        </div>
                                        <div class="card-body">
                                            @if($orders->count() !== 0)
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Mã đơn</th>
                                                            <th>Phương thức thanh toán</th>
                                                            <th>Trạng thái đơn hàng</th>
                                                            <th>Tổng tiền</th>
                                                            <th>Ngày tạo</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($orders as $order)
                                                        <tr class="text-center">
                                                            <td>{{$order->id}}</td>
                                                            <td> @if($order->payment_method == 'cod')
                                                                Thanh toán khi giao hàng
                                                                @elseif($order->payment_method == 'vnp')
                                                                Chuyển khoản
                                                                @endif
                                                            </td>
                                                            <td> @if($order->order_status == 0)
                                                                Chờ duyệt
                                                                @elseif($order->order_status == 1)
                                                                Đã duyệt
                                                                @elseif($order->order_status == 2)
                                                                Đang giao
                                                                @elseif($order->order_status == 3)
                                                                Hoàn thành
                                                                @elseif($order->order_status == 4)
                                                                Đã huỷ
                                                                @endif
                                                            </td>

                                                            <td>{{ number_format($order->amount, 0, ',', ',') }} VND
                                                            </td>
                                                            <td>{{$order->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')}}</td>
                                                            <td>
                                                                <a href="{{route('user.order_detail', ['order_id' => $order->id])}}"
                                                                    class="btn-small d-block">Xem chi tiết</a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                {{$orders->links('pagination::bootstrap-4')}}
                                            </div>
                                            @else
                                                <h5>Không có đơn hàng</h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</div>