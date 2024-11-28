@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chi Tiết Đơn Hàng</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Đơn Hàng #{{ $order->id }}</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $order->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $order->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $order->phone_number }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>
                            {{ $order->address }},
                            {{ $ward->name_xaphuong ?? "...." }},
                            {{ $province->name_quanhuyen ?? "...." }},
                            {{ $city->name_thanhpho ?? "...." }}
                        </td>
                    </tr>
                    <tr>
                        <th>Total Price</th>
                        <td>{{ number_format($order->total_price, 0, ',', '.')}} VND</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $order->status }}</td>
                    </tr>
                    <tr>
                        <th>Lý do hủy</th>
                        <td>{{ $order->reason}}</td>
                    </tr>
                    <tr>
                        <th>Payment Method</th>
                        <td>{{ $order->payment_method}}</td>
                    </tr>
                    <tr>
                        <th>Order Code</th>
                        <td>{{ $order->order_code }}</td>
                    </tr>
                    <tr>
                        <th>Order PaymentStatus</th>
                        <td>{{ $order->payment_status }}</td>
                    </tr>
                    <tr>
                        <th>Note</th>
                        <td>{{ $order->note }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $order->updated_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-footer text-right">
            <a href="{{ route('admin.order.getList') }}" class="btn btn-primary">Quay Lại</a>
        </div>
    </div>
</section>
@endsection
