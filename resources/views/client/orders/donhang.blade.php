@extends('client.layouts.master')

@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
<style>
    .custom-card {
        border: 1px solid #eaeaea;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .custom-img-col {
        max-width: 120px;
        padding-right: 0;
    }

    .custom-img {
        width: 100%;
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
</style>
<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $status === 'chờ_xác_nhận' ? 'active' : '' }}" href="{{ route('order.donhang', ['status' => 'chờ_xác_nhận']) }}">Chờ xác nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'đã_xác_nhận' ? 'active' : '' }}" href="{{ route('order.donhang', ['status' => 'đã_xác_nhận']) }}">Đã xác nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'trả_hàng' ? 'active' : '' }}" href="{{ route('order.donhang', ['status' => 'đóng_hàng']) }}">Đóng hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'đã_giao' ? 'active' : '' }}" href="{{ route('order.donhang', ['status' => 'đang_giao_hàng']) }}">Đang giao hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'đã_giao' ? 'active' : '' }}" href="{{ route('order.donhang', ['status' => 'giao_hàng_thành_công']) }}">Giao hàng thành công</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status === 'đã_hủy' ? 'active' : '' }}" href="{{ route('order.donhang', ['status' => 'hủy']) }}">Đã hủy</a>
        </li>
    </ul>
    
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="trahang">
            @foreach ($orders as $order)
                <div class="card mb-3 custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 custom-img-col">
                                <img src="{{ Storage::url($order->orderItems->first()->image_url) }}" alt="Product Image" class="img-fluid custom-img">
                            </div>
                            <div class="col-9">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-1">{{ $order->orderItems->first()->product_name }} - {{ $order->orderItems->first()->product_description }}</h5>
                                    <span class="badge badge-success">{{ $order->status }}</span>
                                </div>
                                <p class="card-text mb-1">{{ $order->order_code }}</p>
                                <p class="card-text mb-1"><small class="text-muted">{{ $order->created_at }}</small></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="card-text mb-1"><strong>Giá: </strong> <span class="text-danger"> {{ number_format($order->total_price, 0, ',', '.') }} VND</span></p>
                                    <p class="card-text mb-1"><strong>Số tiền hoàn: </strong>{{ number_format($order->refund_amount, 0, ',', '.') }} VND</p>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('client.orders.show', $order->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                                    @if (in_array($order->status, ['chờ_xác_nhận', 'đã_xác_nhận']))
                                        <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST" class="ml-2">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Hủy đơn hàng</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection