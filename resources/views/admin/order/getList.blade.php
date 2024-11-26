@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Mục Đơn Hàng</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Đơn Hàng</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary">Tạo Mới</a>
            </div>
        </div>

        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0"></div>
                <div class="card-header-action">
                    <form class="form-inline" method="GET" action="{{ route('admin.order.index') }}">
                        <div class="search-element">
                            <input class="form-control" type="search" placeholder="Tìm theo mã đơn hàng..." aria-label="Search" name="order_code" value="{{ request('order_code') }}" data-width="250">
                            <input class="form-control" type="search" placeholder="Tìm theo tên..." aria-label="Search" name="name" value="{{ request('name') }}" data-width="250">
                            <input class="form-control" type="search" placeholder="Tìm theo email..." aria-label="Search" name="email" value="{{ request('email') }}" data-width="250">
                            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID Order</th>
                                <th scope="col">UserName</th>
                                <th scope="col">Email</th>
                                <th scope="col">Thanh Toán</th>
                                <th scope="col">Price</th>
                                <th scope="col">Mã Đơn Hàng</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->total_price }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>
                                    <form action="{{ route('admin.order.update-status', $order->id) }}" method="POST">
                                        @csrf
                                        <select name="status" class="form-control">
                                            <option value="chờ_xác_nhận" {{ $order->status == 'chờ_xác_nhận' ? 'selected' : '' }}>Chờ Xác Nhận</option>
                                            <option value="đã_xác_nhận" {{ $order->status == 'đã_xác_nhận' ? 'selected' : '' }}>Đã Xác Nhận</option>
                                            <option value="đang_giao_hàng" {{ $order->status == 'đang_giao_hàng' ? 'selected' : '' }}>Đang Giao Hàng</option>
                                            <option value="giao_hàng_thành_công" {{ $order->status == 'giao_hàng_thành_công' ? 'selected' : '' }}>Giao Hàng Thành Công</option>
                                            <option value="đã_hủy" {{ $order->status == 'đã_hủy' ? 'selected' : '' }}>Đã Hủy</option>
                                        </select>
                                        <button type="submit" class="btn btn-success btn-sm">Cập Nhật</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.order.chitiet', $order->id) }}" class="btn btn-info btn-sm">Chi tiết</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-body mx-auto">
            {{ $orders->links() }}
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<script>
    $(document).ready(function () {
        toastr.options = {
            "closeButton": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "1000",
            "extendedTimeOut": "1000",
        };

        toastr.success("Đã làm mới trang");
    });
</script>
@endsection
