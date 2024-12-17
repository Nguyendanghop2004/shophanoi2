@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Gán Shipper cho Đơn Hàng</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Đơn Hàng Cần Gán Shipper</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID Đơn Hàng</th>
                            <th scope="col">Tên Người Mua</th>
                            <th scope="col">Email</th>
                            <th scope="col">Trạng Thái</th>
                            <th scope="col">Gán Shipper</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <form action="{{ route('admin.order.assignShipper', $order->id) }}" method="POST">
                                    @csrf
                                    <select name="assigned_shipper_id" class="form-control">
                                        <option value="">Chọn Shipper</option>
                                        @foreach ($shippers as $shipper)
                                            <option value="{{ $shipper->id }}">{{ $shipper->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-2">Gán Shipper</button>
                                </form>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
