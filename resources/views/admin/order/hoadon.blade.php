

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
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
            max-width: 800px;  /* Giới hạn chiều rộng của container */
=======
=========
>>>>>>>>> Temporary merge branch 2
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
<<<<<<<<< Temporary merge branch 1
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
        /* Định dạng phần tiêu đề */
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
            font-family: 'Arial', sans-serif;
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
        }

        .header p {
            margin: 5px 0;
            font-size: 16px;
        }

<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
        /* Định dạng thông tin đơn hàng */
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
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

<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
        /* Định dạng bảng hiển thị sản phẩm */
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
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

<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
        /* Định dạng tổng tiền */
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
        .total {
            text-align: right;
            font-size: 16px;
            margin-top: 10px;
        }

<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
        /* Định dạng phần footer */
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 50px;
            color: #777;
        }

        .footer p {
            margin: 5px 0;
        }

<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
        /* Đảm bảo hình ảnh sản phẩm không bị lệch hoặc vỡ bố cục */
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
        .table img {
            max-width: 50px;
            height: auto;
        }
<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
=======

        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
    </style>
</head>
<body>

<div class="container">
<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
    <!-- Header -->
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
    <div class="header">
        <h1>Hóa Đơn Mua Hàng</h1>
        <p>Đơn hàng #{{ $order->order_code }}</p>
        <p>Ngày: {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</p>
    </div>

<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
    <!-- Order Details -->
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
    <div class="order-details">
        <div class="customer-info">
            <h3>Thông Tin Khách Hàng</h3>
            <p><strong>Tên:</strong> {{ $order->name }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Điện Thoại:</strong> {{ $order->phone_number }}</p>
        </div>
        <div class="shipping-info">
            <h3>Thông Tin Giao Hàng</h3>
            <p><strong>Địa Chỉ:</strong> {{ $order->address }}</p>
            <p><strong>Thành Phố:</strong> {{ $city->name_thanhpho }}</p>
            <p><strong>Quận/Huyện:</strong> {{ $province->name_quanhuyen }}</p>
            <p><strong>Xã/Phường:</strong> {{ $ward->name_xaphuong }}</p>
        </div>
    </div>

<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
    <!-- Order Items Table -->
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
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
<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
                    <td><img src="{{ Storage::url($item->image_url) }}"></td>
=======
                    <td><img src="{{ public_path('storage/' . $item->image_url) }}"></td>
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
    <!-- Total Amount -->
=======
>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
    <div class="total">
        <p><strong>Tổng Tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VNĐ</p>
    </div>

<<<<<<<<< Temporary merge branch 1
<<<<<<< HEAD
    <!-- Footer -->
=======
    <div class="qr-code">
        <p><strong>Mã QR:</strong></p>
        <img src="{{ storage_path('app/public/qr_codes/hoadon_' . $order->order_code . '.png') }}" alt="QR Code">
    </div>
    

>>>>>>> d01f4155e95f4a43c18a3d3b3ea4c26fbe41b21e
=========
>>>>>>>>> Temporary merge branch 2
    <div class="footer">
        <p>Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi!</p>
    </div>
</div>

</body>
</html>
