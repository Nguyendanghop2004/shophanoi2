@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Shipper Đang Có Đơn Hàng</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Shipper Đã Nhận Đơn</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Tên Shipper</th>
                            <th scope="col">Tên Khách Hàng</th>
                            <th scope="col">Số Lượng Đơn Hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shippers as $shipper)
                        <tr>
                            <td>{{ $shipper->name }}</td>
                        </tr>
                        @endforeach
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->order_code }}</td>
                        </tr>
                        @endforeach
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
