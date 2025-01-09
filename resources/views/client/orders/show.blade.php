@extends('client.layouts.master')

@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
<div class="order-container">
    <!-- Header -->
    <div class="order-header">
        <h1 class="order-title">Thông Tin Đơn Hàng #{{ $order->order_code }}</h1>
        <div class="order-meta">
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
            <p>
                <strong>Trạng thái:</strong> 
                <span class="status {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
            </p>
        </div>
    </div>
    <div class="order-summary">
        <h3>Thông Tin Đơn Hàng</h3>
        <p><strong>Tên Khách Hàng:</strong> {{ $order->name }}</p>
        <p><strong>Số Điện Thoại:</strong> {{ $order->phone_number }}</p>
        <p><strong>Trạng Thái Thanh Toán:</strong> {{ $order->payment_status }}</p>
        <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
        <p><strong>Địa Chỉ Cụ Thể:</strong>{{ $city->name_thanhpho }},{{ $province->name_quanhuyen }},{{ $ward->name_xaphuong }}, {{ $order->address }}</p>
    </div>
    <!-- Danh sách sản phẩm -->
    <div class="order-details">
        <h2 class="product-list-title">chi tiết đơn hàng</h2>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderitems as $item)
                <tr>

                    <td> <img src="{{Storage::url($item->image_url)}}" alt="" width="50px">{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="order-summary-total">

    <strong>Tổng Tiền:</strong>  {{ number_format($orderitems->sum(fn($item) => $item->quantity * $item->price), 0, ',', '.') }} VNĐ
    <div class="continue-shopping text-center">
    <a href="{{ route('order.donhang') }}" class="btn btn-primary">Quay Lại</a>
</div>
</div>


      
    </div>

    <!-- Tổng kết -->
    
</div>
@endsection

<style>
/* Tổng quan */
body {
    font-family: 'Arial', sans-serif;
    background: #f7f7f7;
    color: #333;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

/* Container chính */
.order-container {
    max-width: 900px;
    margin: 50px auto;
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Header đơn hàng */
.order-header {
    text-align: center;
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
    margin-bottom: 20px;
}

.order-title {
    font-size: 24px;
    font-weight: bold;
    color: #222;
    margin: 0;
}

.order-meta p {
    font-size: 16px;
    margin: 5px 0;
}

.status {
    font-size: 14px;
    font-weight: bold;
    padding: 5px 10px;
    border-radius: 5px;
    background: #ddd;
    color: #555;
}

.status.processing {
    background: #ffe8a1;
    color: #856404;
}

.status.completed {
    background: #c3e6cb;
    color: #155724;
}

.status.cancelled {
    background: #f8d7da;
    color: #721c24;
}

/* Danh sách sản phẩm */
.product-list-title {
    font-size: 20px;
    font-weight: bold;
    margin: 20px 0;
    text-align: left;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.order-table th, .order-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.order-table th {
    font-weight: bold;
    background: #f9f9f9;
}

.order-table td {
    font-size: 14px;
    color: #333;
}

.order-table tr:last-child td {
    border-bottom: none;
}

/* Tóm tắt đơn hàng */
.order-summary {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.order-summary h3 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #222;
}

.order-summary p {
    font-size: 16px;
    margin: 5px 0;
}

.order-summary p strong {
    font-weight: bold;
    color: #333;
}

/* Responsive */
@media (max-width: 768px) {
    .order-container {
        padding: 20px;
    }

    .order-title {
        font-size: 20px;
    }

    .order-table th, .order-table td {
        font-size: 12px;
        padding: 8px;
    }

    .order-summary h3 {
        font-size: 16px;
    }

    .order-summary p {
        font-size: 14px;
    }

}
.order-summary-total {
    text-align: right;
    font-size: 18px;
    font-weight: bold;
    margin-top: 20px;
}
</style>
