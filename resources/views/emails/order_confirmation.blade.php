<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đơn Hàng</title>
    <style>
        .container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .cancel-order {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .cancel-order:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chào bạn {{ $order->user_name }}</h2>
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
            @foreach($order->orderItems as $item)
                <li>
                    <img src="{{ Storage::url($item->image_url) }}" style="width: 100px; height: 100px; object-fit: cover;">
                    <br>
                    {{ $item->quantity }} x {{ $item->product_name }} 
                    (Màu: {{ $item->color_name }}, Size: {{ $item->size_name }})
                </li>
            @endforeach
        </ul>

        <p>Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng và giao hàng trong thời gian sớm nhất.</p>

       
        <p>
            <a href="{{ route('cancel.order.page', ['order_code' => Crypt::encryptString($order->order_code)]) }}" class="cancel-order">
                Hủy Đơn Hàng
            </a>
        </p>
        <p>
            <a href="{{ route('order.detail.page', ['order_code' => Crypt::encryptString($order->order_code)]) }}" class="cancel-order">
                Xem Chi Tiết
            </a>
        </p>
        <p>Trân trọng,</p>
        <p>Đội ngũ cửa hàng</p>
    </div>
</body>
</html>
