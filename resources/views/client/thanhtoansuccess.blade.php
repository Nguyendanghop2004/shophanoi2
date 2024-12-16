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

/* Thiết kế cho thông tin đơn hàng */
.order-summary {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 50px; /* Tăng padding để các phần tử có không gian hơn */
    margin: 40px 0;
    width: 100%;
    max-width: 1000px; /* Tăng chiều rộng của container */
}

/* Tiêu đề của phần thanh toán thành công */
.success-title {
    color: #28a745;
    font-size: 32px; /* Tăng kích thước font */
    font-weight: bold;
    margin-bottom: 20px; /* Tăng khoảng cách dưới */
    text-align: center;
}

/* Lời cảm ơn */
.thank-you-note {
    color: #6c757d;
    font-size: 20px; /* Tăng kích thước font */
    margin-bottom: 30px; /* Tăng khoảng cách dưới */
    text-align: center;
}

/* Thông tin đơn hàng */
.order-info {
    list-style: none;
    padding: 0;
    margin-bottom: 40px; /* Tăng khoảng cách dưới */
    text-align: left;
    font-size: 20px; /* Tăng kích thước font */
}

.order-info li {
    margin-bottom: 15px; /* Tăng khoảng cách giữa các dòng */
}

.order-info li strong {
    color: #333;
    font-size: 22px; /* Tăng kích thước font cho phần tên */
}

/* Tiêu đề chi tiết đơn hàng */
.order-detail-title {
    font-size: 24px; /* Tăng kích thước font */
    font-weight: bold;
    margin-bottom: 20px; /* Tăng khoảng cách dưới */
    text-align: center;
}

/* Bảng chi tiết đơn hàng */
.order-detail-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 40px; /* Tăng khoảng cách dưới */
}

.order-detail-table th, .order-detail-table td {
    padding: 18px; /* Tăng padding cho các ô */
    text-align: left;
    border-bottom: 1px solid #ddd;
    font-size: 20px; /* Tăng kích thước font */
}

.order-detail-table th {
    background-color: #f8f9fa;
}

/* Tổng tiền đơn hàng */
.order-summary-total {
    text-align: right;
    font-size: 24px; /* Tăng kích thước font */
    font-weight: bold;
    margin-top: 30px; /* Tăng khoảng cách trên */
}

/* Nút quay lại trang chủ */
.continue-shopping {
    margin-top: 40px; /* Tăng khoảng cách trên */
}

.btn-primary {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 18px 30px; /* Tăng padding để nút to hơn */
    border-radius: 8px; /* Làm cho nút tròn hơn */
    font-size: 20px; /* Tăng kích thước font */
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
}

</style>
@endsection


