@extends('client.layouts.master')

@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
<style>
/* CSS chỉ áp dụng trong trang này */

/* Toàn bộ vùng nội dung */
body {
    font-family: 'Arial', sans-serif;
    color: #333;
    background-color: #f4f4f9;
}

/* Thông báo lỗi */
.alert.alert-danger {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    background-color: #ffe6e6;
    color: #d93025;
    font-weight: bold;
    border: 1px solid #ffcccc;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Tiêu đề danh sách */
.out-of-stock-title {
    font-size: 1.8em;
    color: #444;
    margin-bottom: 20px;
    font-weight: bold;
    text-align: center;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}

/* Bảng danh sách */
.out-of-stock-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.out-of-stock-table th {
    background-color: #007bff;
    color: #fff;
    text-align: left;
    padding: 15px;
    font-size: 1em;
    font-weight: bold;
}

.out-of-stock-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 0.95em;
}

.out-of-stock-table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.out-of-stock-table tbody tr:hover {
    background-color: #f1f7ff;
    transition: background-color 0.3s ease;
}

/* Nút quay lại */
.back-to-cart-btn {
    display: inline-block;
    padding: 12px 25px;
    font-size: 1em;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    border-radius: 50px;
    background: linear-gradient(to right, #007bff, #0056b3);
    color: #fff;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    margin-top: 20px;
    display: block;
    width: fit-content;
    margin-left: auto;
    margin-right: auto;
}

.back-to-cart-btn:hover {
    background: linear-gradient(to right, #0056b3, #003d80);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

/* Khoảng cách cho phần nội dung */
.content-wrapper {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>

<div class="content-wrapper">
    <div class="alert alert-danger">
        <strong>Lỗi:</strong> {{ $error }}
    </div>
    @if (!empty($outOfStockItems))
        <h3 class="out-of-stock-title">Danh sách sản phẩm không đủ số lượng:</h3>
        <table class="out-of-stock-table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng yêu cầu</th>
                    <th>Số lượng còn lại</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($outOfStockItems as $item)
                    <tr>
                        <td>{{ $item['product_name'] }}</td>
                        <td>{{ $item['requested_quantity'] }}</td>
                        <td>{{ $item['remaining_quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{ route('cart') }}" class="back-to-cart-btn">Quay lại giỏ hàng</a>
</div>
@endsection
