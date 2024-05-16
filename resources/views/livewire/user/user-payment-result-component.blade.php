<main class="main">
    <section class="pt-20 pb-20">
        <div class="container">
            @if($messageType === "success" )
            <div class=" alert alert-success mt-3 mb-3">
                {{$message}}
            </div>
            @if(isset($order_id))
            <a href="{{route('user.order_detail', ['order_id' => $order_id])}}"
                class="btn btn-fill-out btn-block mt-30">Chi tiết đơn hàng</a>
            @endif
            @else
            <div class=" alert alert-danger mt-3 mb-3">
                {{$message}}
            </div>
            @endif

        </div>
    </section>
</main>