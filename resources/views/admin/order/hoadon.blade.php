<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn - Đơn Hàng #{{ $order->id }}</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url({{ storage_path('fonts/DejaVuSans.ttf') }}) format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'DejaVu Sans', serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0;
            font-size: 16px;
        }

        .order-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .order-details .customer-info, .order-details .shipping-info {
            width: 48%;
        }

        .order-details p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .table th, .table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table img {
            max-width: 50px;
            height: auto;
        }

        .total {
            text-align: right;
            font-size: 16px;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 50px;
            color: #777;
        }

        .footer p {
            margin: 5px 0;
        }

        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Hóa Đơn Mua Hàng</h1>
        <p>Đơn hàng #{{ $order->order_code }}</p>
        <p>Ngày: {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</p>
    </div>

    <div class="order-details">
        <div class="customer-info">
            <h3>Thông Tin Khách Hàng</h3>
            <p><strong>Tên:</strong> {{ $order->name }}</p>
            <p><strong>Điện thoại:</strong>  {{ substr($order->phone_number, 0, 4) . str_repeat('x', strlen($order->phone_number) - 4) }}</p>
        </div>
        <div class="shipping-info">
            <h3>Thông Tin Giao Hàng</h3>
            <p><strong>Thành Phố:</strong> {{ $city->name_thanhpho }}</p>
            <p><strong>Quận/Huyện:</strong> {{ $province->name_quanhuyen }}</p>
            <p><strong>Xã/Phường:</strong> {{ $ward->name_xaphuong }}</p>
            <p><strong>Địa chỉ cụ thể:</strong> {{$order->address }}</p>


        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tên Sản Phẩm</th>
                <th>Số Lượng</th>
                <th>Đơn Giá</th>
                <th>Thành Tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderitems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p><strong>Tổng Tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VNĐ</p>
    </div>
    <div class="footer">
        <p>Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi!</p>
    </div>
</div>

</body>
</html>
