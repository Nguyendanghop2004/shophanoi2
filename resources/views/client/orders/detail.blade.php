@extends('client.layouts.master')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            font-size: 24px;
            color: #007bff;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .order-status {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .status-box {
            flex: 1;
            padding: 15px 0;
            text-align: center;
            border-radius: 8px;
            font-weight: bold;
            color: white;
        }

        .status-box.pending {
            background-color: #ffc107;
        }

        .status-box.confirmed {
            background-color: #28a745;
        }

        .status-box.shipping {
            background-color: #007bff;
        }

        .status-box.shipping-done {
            background-color: #17a2b8;
        }

        .status-box.delivered {
            background-color: #6f42c1;
        }

        .status-box.received {
            background-color: #20c997;
        }

        .status-box.canceled {
            background-color: #dc3545;
        }

        .order-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .order-info div {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .order-info h3 {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .order-info p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .order-items {
            margin-bottom: 30px;
        }

        .order-items h3 {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .order-items ul {
            list-style: none;
            padding: 0;
        }

        .order-items li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 16px;
            color: #333;
        }

        .order-items li img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 15px;
        }

        .order-items li .product-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .order-items li .product-details span {
            margin-bottom: 5px;
        }

        .order-items li .product-details .price {
            font-weight: bold;
            color: #ff6600;
        }

        .payment-info {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .payment-info h3 {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .payment-info ul {
            list-style: none;
            padding: 0;
        }

        .payment-info li {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .payment-info li span {
            font-weight: bold;
            color: #333;
        }

        .back-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
            margin-top: 30px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="container">
        <h2>Trang trạng thái đơn hàng: {{ $order->order_code }}</h2>

        <!-- Trạng thái đơn hàng -->
        <div class="order-status">
            <div class="status-box {{ $order->status == 'pending' ? 'pending' : '' }}">Chờ xác nhận</div>
            <div class="status-box {{ $order->status == 'confirmed' ? 'confirmed' : '' }}">Đã xác nhận</div>
            <div class="status-box {{ $order->status == 'shipping' ? 'shipping' : '' }}">Chờ giao hàng</div>
            <div class="status-box {{ $order->status == 'shipping-done' ? 'shipping-done' : '' }}">Đang giao hàng</div>
            <div class="status-box {{ $order->status == 'delivered' ? 'delivered' : '' }}">Giao hàng thành công</div>
            <div class="status-box {{ $order->status == 'received' ? 'received' : '' }}">Đã nhận hàng</div>
            <div class="status-box {{ $order->status == 'canceled' ? 'canceled' : '' }}">Hủy</div>
        </div>

        <!-- Thông tin khách hàng và giao nhận -->
        <div class="order-info">
            <!-- Thông tin khách hàng -->
            <div>
                <h3>Thông tin khách hàng</h3>
                <p><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
                <p><strong>Điện thoại:</strong> {{ $order->phone_number }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                <p><strong>Phường/Xã:</strong> {{ $order->ward }}</p>
                <p><strong>Quận/Huyện:</strong> {{ $order->district }}</p>
                <p><strong>Thành phố/Tỉnh:</strong> {{ $order->city }}</p>
            </div>

            <!-- Thông tin giao nhận -->
            <div>
                <h3>Thông tin giao nhận</h3>
                <p><strong>Họ tên:</strong> {{ $order->delivery_name }}</p>
                <p><strong>Điện thoại:</strong> {{ $order->delivery_phone }}</p>
                <p><strong>Email:</strong> {{ $order->delivery_email }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->delivery_address }}</p>
                <p><strong>Phường/Xã:</strong> {{ $order->delivery_ward }}</p>
                <p><strong>Quận/Huyện:</strong> {{ $order->delivery_district }}</p>
                <p><strong>Thành phố/Tỉnh:</strong> {{ $order->delivery_city }}</p>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="order-items">
            <h3>Danh sách sản phẩm</h3>
            <ul>
                @foreach($order->orderItems as $item)
                    <li>
                        <img src="{{ Storage::url($item->image_url) }}" alt="Product Image">
                        <div class="product-details">
                            <span>{{ $item->product_name }} (Màu: {{ $item->color_name }}, Size: {{ $item->size_name }})</span>
                            <span class="price">{{ number_format($item->price, 0, ',', '.') }} VND</span>
                            <span>Số lượng: {{ $item->quantity }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Thanh toán -->
        <div class="payment-info">
            <h3>Thanh toán</h3>
            <ul>
                <li><span>Trị giá đơn hàng:</span> {{ number_format($order->total_price, 0, ',', '.') }} VND</li>
                <li><span>Giảm giá:</span> {{ number_format($order->discount, 0, ',', '.') }} VND</li>
                <li><span>Phí giao hàng:</span> {{ number_format($order->shipping_fee, 0, ',', '.') }} VND</li>
                <li><span>Phí thanh toán:</span> {{ number_format($order->payment_fee, 0, ',', '.') }} VND</li>
                <li><span>Tổng thanh toán:</span> {{ number_format($order->final_price, 0, ',', '.') }} VND</li>
            </ul>
        </div>

        <a href
