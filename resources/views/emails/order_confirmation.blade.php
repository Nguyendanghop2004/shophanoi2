<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đơn Hàng</title>
</head>
<body>
    <h2>Chào bạn {{ $userName }}</h2>
    <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được xác nhận.</p>
    <h3>Thông tin đơn hàng:</h3>
    <ul>
        <li><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</li>
        <li><strong>Tổng giá trị:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND</li>
        <li><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</li>
        <li><strong>Số điện thoại:</strong> {{ $order->phone_number }}</li>
    </ul>

    <h4>Chi tiết sản phẩm:</h4>
    <ul>
        @foreach($orderItems as $item)
            <li>{{ $item['quantity'] }} x {{ $item['product_name'] }} (Màu: {{ $item['color_name'] }}, Size: {{ $item['size_name'] }})</li>
        @endforeach
    </ul>

    <p>Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng và giao hàng trong thời gian sớm nhất.</p>
    <p>Trân trọng,</p>
    <p>Đội ngũ cửa hàng</p>
</body>
</html>
