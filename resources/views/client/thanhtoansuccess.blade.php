@extends('client.layouts.master')

@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
<section class="flat-spacing-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 order-summary">
                <h2 class="success-title">Thanh toán thành công</h2>
                <p class="thank-you-note">Cảm ơn bạn đã mua hàng. Thông tin thanh toán của bạn như sau:</p>
                <ul class="order-info">
                   
                    <li><strong>Mã Đơn Hàng:</strong> {{ $order->order_code}}</li>
                    <li><strong>Tên Khách Hàng:</strong> {{ $order->name}}</li>
                    <li><strong>Số Điện Thoại:</strong> {{ $order->phone_number}}</li>
                    <li><strong>Ngày Đặt:</strong> {{ $order->created_at->format('d-m-Y') }}</li>
                    <li><strong>Mã giao dịch VNPay:</strong> {{$order->payment_method }}</li>
                  
                    <li><strong>Địa Chỉ:</strong>{{ $city->name_thanhpho }},{{ $province->name_quanhuyen}},{{ $ward->name_xaphuong }}, {{ $order->address}}</li>
                </ul>
                <h3 class="order-detail-title">Thông tin chi tiết đơn hàng</h3>
                <table class="table order-detail-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($orderItems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                  
                </tr>
            @endforeach
                    </tbody>
                </table>
                <div class="order-summary-total">
    <strong>Tổng Tiền:</strong> {{ number_format($orderItems->sum(function ($item) { return $item->price * $item->quantity; }), 0, ',', '.') }}₫
</div>
<div class="continue-shopping text-center">
    <a href="{{ route('home') }}" class="btn btn-primary">Quay về trang chủ</a>
</div>
            </div>
        </div>
    </div>
</section>
<style>
    /* Căn giữa toàn bộ container */
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .order-summary {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin: 20px 0;
        width: 100%;
        max-width: 800px;
    }

    .success-title {
        color: #28a745;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 15px;
        text-align: center;
    }

    .thank-you-note {
        color: #6c757d;
        font-size: 16px;
        margin-bottom: 20px;
        text-align: center;
    }

    .order-info {
        list-style: none;
        padding: 0;
        margin-bottom: 30px;
        text-align: left;
        font-size: 16px;
    }

    .order-info li {
        margin-bottom: 10px;
    }

    .order-info li strong {
        color: #333;
    }

    .order-detail-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        text-align: center;
    }

    .order-detail-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .order-detail-table th, .order-detail-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .order-detail-table th {
        background-color: #f8f9fa;
    }

    .order-detail-table td.text-right {
        text-align: right;
    }

    .continue-shopping {
        margin-top: 30px;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
    .order-summary-total {
    text-align: right;
    font-size: 18px;
    font-weight: bold;
    margin-top: 20px;
}
</style>
@endsection


