<!DOCTYPE html>
<html>
<head>
    <title>Cập nhật trạng thái đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            font-size: 24px;
            text-align: center;
        }

        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .order-details {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            background-color: #28a745;
            color: #ffffff;
            border-radius: 4px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thông báo cập nhật trạng thái đơn hàng</h2>
        <p>Xin chào {{ $order->name }},</p>
    
        <div class="order-details">
            <p><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</p>
            <p><strong>Trạng thái hiện tại:</strong> {{ $order->status }}</p>
        </div>
        
        <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>

        @if ($order->user_id && $order->status === 'giao hàng thành công')
            <a href="{{ route('orders.confirm', $order->id) }}" class="btn">Đã nhận hàng</a>
        @endif
    </div>
</body>
</html>
