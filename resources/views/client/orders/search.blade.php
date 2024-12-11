@extends('client.layouts.master')

@section('content')
<style>
    .custom-card {
        border: 1px solid #eaeaea;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .custom-img-col {
        max-width: 80px;
        padding-right: 0;
    }

    .custom-img {
        width: 80px;
        height: auto;
        border-radius: 4px;
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
    }

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .align-items-center {
        align-items: center;
    }

    .order-step {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .order-step div {
        text-align: center;
        padding: 10px;
        flex-grow: 1;
    }

    .order-step .chờ_xác_nhận {
        background-color: #ffc107;
        color: #fff;
    }

    .order-step .đã_xác_nhận {
        background-color: #28a745;
        color: #fff;
    }

    .order-step .chờ_giao_hàng {
        background-color: #007bff;
        color: #fff;
    }

    .order-step .đang_giao_hàng {
        background-color: #17a2b8;
        color: #fff;
    }

    .order-step .giao_hàng_thành_công {
        background-color: #6f42c1;
        color: #fff;
    }

    .order-step .đã_nhận_hàng {
        background-color: #20c997;
        color: #fff;
    }

    .order-step .hủy {
        background-color: #dc3545;
        color: #fff;
    }

    .order-step .not-started {
        background-color: #eaeaea;
        color: #6c757d;
    }

    .info-section {
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #eaeaea;
    border-radius: 8px;
    max-height: 300px; 
    overflow-y: auto; 
    margin-top: 20px;
}
.info-section-2 {
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #eaeaea;
    border-radius: 8px;
    max-height: 200px;
    overflow-y: auto; 
    margin-top: 20px;

}

    .info-section p {
        margin: 0;
        padding: 2px 0;
    }

    .product-info img {
        width: 80px;
        height: auto;
        border-radius: 4px;
    }

    .btn-primary {
        background-color: #ff6600;
        border-color: #ff6600;
    }
</style>

<div class="container mt-5">
    <h4 style="text-align: center">Thông tin đơn hàng</h4>
    <br>
    <p style="color: red; text-align: center">Mong bạn thông cảm! Vì hệ thống đang cao điểm nên việc giao hàng có thể chậm hơn dự kiến</p>
    @if($orders->isEmpty())
        <h3>Không tìm thấy đơn hàng.</h3>
    @else
        @foreach($orders as $order)
            <div class="custom-card">
                <div class="order-info">
                    <h5>Trạng thái đơn hàng: <span style="color: #ff6600;">{{ $order->order_code }}</span></h5>
                    <div class="order-step">
                        <div class="{{ $order->status == 'chờ_xác_nhận' ? 'chờ_xác_nhận' : 'not-started' }}">Chờ xác nhận</div>
                        <div class="{{ $order->status == 'đã_xác_nhận' ? 'đã_xác_nhận' : 'not-started' }}">Đã xác nhận</div>
                        <div class="{{ $order->status == 'chờ_giao_hàng' ? 'chờ_giao_hàng' : 'not-started' }}">Chờ giao hàng</div>
                        <div class="{{ $order->status == 'đang_giao_hàng' ? 'đang_giao_hàng' : 'not-started' }}">Đang giao hàng</div>
                        <div class="{{ $order->status == 'giao_hàng_thành_công' ? 'giao_hàng_thành_công' : 'not-started' }}">Giao hàng thành công</div>
                        <div class="{{ $order->status == 'đã_nhận_hàng' ? 'đã_nhận_hàng' : 'not-started' }}">Đã nhận hàng</div>
                        <div class="{{ $order->status == 'hủy' ? 'hủy' : 'not-started' }}">Hủy</div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-section">
                            <h5>Thông tin khách hàng</h5>
                            <p>Họ tên: {{ $order->name }}</p>
                            <p>Điện thoại: {{ $order->phone_number }}</p>
                            <p>Email: {{ $order->email }}</p>
                            <p>Địa chỉ: {{ $order->address }}</p>
                            <p>Phường/Xã: {{ $order->ward->name_xaphuong }}</p>
                            <p>Quận/Huyện: {{ $order->province->name_quanhuyen }}</p>
                            <p>Thành phố/Tỉnh: {{ $order->city->name_thanhpho }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-section">
                            <h5>Thông tin giao nhận</h5>
                            <p>Họ tên: {{ $order->name }}</p>
                            <p>Điện thoại: {{ $order->phone_number }}</p>
                            <p>Email: {{ $order->email }}</p>
                            <p>Địa chỉ: {{ $order->address }}</p>
                            <p>Phường/Xã: {{ $order->ward->name_xaphuong }}</p>
                            <p>Quận/Huyện: {{ $order->province->name_quanhuyen }}</p>
                            <p>Thành phố/Tỉnh: {{ $order->city->name_thanhpho }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-section-2">
                            <h5>Danh sách sản phẩm</h5>
                            @foreach($order->orderItems as $item)
                                <div class="d-flex align-items-center">
                                    <img src="{{ Storage::url($item->image_url) }}" style="width:100px" alt="Product Image" class="product-info">
                                    <div class="ml-3">
                                        <p class="mx-4">{{ $item->product_name }}</p>
                                        <p class="mx-4" >Giá: {{ number_format($item->price, 0, ',', '.') }} VND</p>
                                        <p class="mx-4" >Size: {{ $item->size }}</p>
                                        <p class="mx-4" >Số lượng: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-section">
                            <h5>Thanh toán</h5>
                            <p>Trị giá đơn hàng: {{ number_format($order->total_price, 0, ',', '.') }} VND</p>
                            <p>Giảm giá: 0 VND</p>
                            <p>Phí giao hàng: 30.000 VND</p>
                            <p>Phí thanh toán: 0 VND</p>
                            <p>Tổng thanh toán: {{ number_format($order->total_price + 30000, 0, ',', '.') }} VND</p>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/') }}" class="btn btn-primary">Quay lại trang chủ</a>
            </div>
        @endforeach

    @endif
</div>
@endsection
