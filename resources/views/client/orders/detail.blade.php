@extends('client.layouts.master')

@section('content')
    <style>
        .container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .back-to-orders {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .back-to-orders:hover {
            background-color: #0056b3;
        }
        .order-info, .order-items, .order-status {
            margin-bottom: 20px;
        }
        .order-info ul, .order-items ul {
            list-style: none;
            padding: 0;
        }
        .order-info li, .order-items li {
            padding: 5px 0;
        }
        .order-status {
            font-size: 18px;
        }
        .order-status span {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chi Tiết Đơn Hàng</h2>

        <h3>Thông tin đơn hàng:</h3>
        <div class="order-info">
            <ul>
                <li><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</li>
                <li><strong>Tổng giá trị:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND</li>
                <li><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</li>
                <li><strong>Số điện thoại:</strong> {{ $order->phone_number }}</li>
                <li><strong>Email:</strong> {{ $order->email }}</li>
            </ul>
        </div>

        <h4>Chi tiết sản phẩm:</h4>
        <div class="order-items">
            <ul>
                @foreach($order->orderItems as $item)
                    <li>
                        <img src="{{ Storage::url($item->image_url) }}" style="width: 100px; height: 100px; object-fit: cover;">
                        <br>
                        <strong>{{ $item->quantity }} x {{ $item->product_name }}</strong>
                        (Màu: {{ $item->color_name }}, Size: {{ $item->size_name }})
                    </li>
                @endforeach
            </ul>
        </div>

        <h4>Trạng thái đơn hàng:</h4>
        <div class="order-status">
            <p><strong>Trạng thái:</strong> <span>{{ $order->status }}</span></p>
            <p><strong>Ngày tạo:</strong> {{ $order->created_at }}</p>
            <p><strong>Ngày cập nhật:</strong> {{ $order->updated_at }}</p>
        </div>

      
    </div>
</body>
</html>
@endsection