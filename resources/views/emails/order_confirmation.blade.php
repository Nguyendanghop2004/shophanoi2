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
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            background-image: linear-gradient(to right, #f9f9f9, #fff);
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-header h2 {
            margin: 0;
            font-size: 28px;
            color: #333;
            font-weight: bold;
        }

        .invoice-header p {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }

        .invoice-info {
            margin-bottom: 20px;
        }

        .invoice-info ul {
            list-style-type: none;
            padding: 0;
            font-size: 16px;
            line-height: 1.8;
        }

        .invoice-info ul li {
            color: #555;
        }

        .invoice-info ul li strong {
            color: #333;
        }

        .product-list {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .product-list th, .product-list td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 16px;
        }

        .product-list th {
            background-color: #f7f7f7;
            color: #333;
        }

        .product-list tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .product-list img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .total-price {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            color: #333;
            margin-top: 20px;
        }

        .cancel-order, .order-detail {
            background-color: #e91e63;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .cancel-order:hover, .order-detail:hover {
            background-color: #c2185b;
            transform: translateY(-2px);
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        .footer p {
            margin: 5px;
        }

        /* Đường viền ngoài với hiệu ứng khung */
        .invoice-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 5px solid #f44336;
            border-radius: 12px;
            pointer-events: none;
            box-sizing: border-box;
        }

        /* Hiệu ứng hover cho bảng sản phẩm */
        .product-list tr:hover {
            background-color: #f1f1f1;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h2>Xác Nhận Đơn Hàng</h2>
            <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi!</p>
        </div>

        <div class="invoice-info">
            <ul>
                <li><strong>Họ và tên:</strong> {{ $order->name }}</li>
                <li><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</li>
                <li><strong>Tổng giá trị:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND</li>
                <li><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</li>
                <li><strong>Số điện thoại:</strong> {{ $order->phone_number }}</li>
            </ul>
        </div>

        <h3>Chi Tiết Sản Phẩm:</h3>
        <table class="product-list">
            <thead>
                <tr>
                    
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Màu sắc</th>
                    <th>Size</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                  
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->color_name }}</td>
                    <td>{{ $item->size_name }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-price">
            <p><strong>Tổng cộng: </strong>{{ number_format($order->total_price, 0, ',', '.') }} VND</p>
        </div>

        <p>
            <a href="{{ route('cancel.order.page', ['order_code' => Crypt::encryptString($order->order_code)]) }}" class="cancel-order">
                Hủy Đơn Hàng
            </a>
            
        </p>
        
        <div class="footer">
            <p>Trân trọng,</p>
            <p>Đội ngũ cửa hàng</p>
        </div>
    </div>
</body>
</html>
