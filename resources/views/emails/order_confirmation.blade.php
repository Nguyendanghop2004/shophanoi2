<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đơn Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #4CAF50;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        ul li strong {
            width: 120px;
            display: inline-block;
        }
        .order-details, .product-details {
            margin-top: 20px;
        }
        .product-details ul {
            padding: 0;
        }
        .product-details ul li {
            border: none;
        }
        .product-details ul li span {
            display: block;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chào bạn {{ $order->name }}</h2>
        <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được xác nhận.</p>
        <div class="order-details">
            <h3>Thông tin đơn hàng:</h3>
            <ul>
                <li><strong>Họ tên:</strong> {{ $order->name ?? '' }}</li>
                <li><strong>Email:</strong> {{ $order->email ?? '' }}</li>
                <li><strong>Mã đơn hàng:</strong> {{ $order->order_code ?? '' }}</li>
                <li><strong>Tổng giá trị:</strong> {{ isset($order->total_price) ? number_format($order->total_price, 0, ',', '.') . ' VND' : '' }}</li>
                <li><strong>Địa chỉ giao hàng:</strong> {{ $order->address ?? '' }}</li>
                <li><strong>Số điện thoại:</strong> {{ $order->phone_number ?? '' }}</li>
            </ul>
        </div>
        <div class="product-details">
            <h4>Chi tiết sản phẩm:</h4>
            <ul>
                @foreach($orderItems as $item)
                    <li>
                        <span>{{ $item['quantity'] }} x {{ $item['product_name'] }}</span>
                        <span>Màu: {{ $item['color_name'] }}, Size: {{ $item['size_name'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <p>Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng và giao hàng trong thời gian sớm nhất.</p>
        <p>Trân trọng,</p>
        <p>Đội ngũ cửa hàng</p>
        <div class="footer">
            <p>&copy; 2024 Cửa hàng của chúng tôi. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
