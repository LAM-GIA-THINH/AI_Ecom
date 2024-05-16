<!-- Inline styles within the HTML tags -->

<body style="font-family: 'Arial', sans-serif; background-color: #f4f4f4; padding: 20px;">

    <p style="margin: 0; display: none;"><strong>Current Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>

    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h1 style="color: #3490dc;">Thông tin đơn hàng</h1>
        @if ($order->order_status === '1')
            <p style="line-height: 1.6; color: #333; font-size: 18px; font-weight: bold;">Đơn hàng của bạn đã được duyệt</p>
            <p style="line-height: 1.6; color: #333; font-size: 18px; font-weight: bold;">Chi tiết:</p>
        @elseif ($order->order_status === '2')
            <p style="line-height: 1.6; color: #333; font-size: 18px; font-weight: bold;">Đơn hàng của bạn đang được giao!</p>
            <p style="line-height: 1.6; color: #333; font-size: 18px; font-weight: bold;">Chi tiết:</p>
        @elseif ($order->order_status === '3')
            <p style="line-height: 1.6; color: #333; font-size: 18px; font-weight: bold;">Đơn hàng của bạn đã thành công!</p>
            <p style="line-height: 1.6; color: #333; font-size: 18px; font-weight: bold;">Chi tiết:</p>
        @elseif ($order->order_status === '4')
            <p style="line-height: 1.6; color: #333; font-size: 18px; font-weight: bold;">Đơn hàng của bạn đã bị huỷ!</p>
            <p style="line-height: 1.6; color: #333; font-size: 18px; font-weight: bold;">Chi tiết:</p>
        @endif

        <div style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px;">
            <p style="margin: 0;"><strong>Mã đơn:</strong> {{ $order->id }}</p>
            @if ($order->order_status === '2')
            <p style="margin: 0;"><strong>Theo dõi đơn hàng:</strong> {{ $order->tracking }}</p>
            @endif
            <p> </p>
            <p style="margin: 0;"><strong>Vào lúc:</strong> {{  \Carbon\Carbon::now()->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s') }}</p>
            
            <a href="{{ route('user.order_detail', ['order_id' => $order->id]) }}" 
               style="display: inline-block; padding: 10px 20px; background-color: #3490dc; color: #fff; text-decoration: none; border-radius: 5px;">
               Xem chi tiết đơn hàng
            </a>
            <p style="margin: 0; display: none;"><strong>Vào lúc:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>

</body>
