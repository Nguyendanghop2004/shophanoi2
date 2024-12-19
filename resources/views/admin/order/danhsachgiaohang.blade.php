@extends('admin.layouts.master')

@section('content')
<style>
    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }
    .address-column {
        word-wrap: break-word;
        max-width: 200px;
    }
</style>
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Shipper Đang Có Đơn Hàng</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Shipper và đơn hàng</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Tên Shipper</th>
                            <th scope="col">Tên Khách Giao</th>
                            <th scope="col">Mã Đơn Hàng</th>
                            <th scope="col">Thanh Toán</th>
                            <th scope="col">Địa chỉ cụ thể</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shippers as $shipper)
                            @php
                                $shipperOrders = $orders->where('assigned_shipper_id', $shipper->id);
                            @endphp
                            @if($shipperOrders->isNotEmpty())
                                @foreach($shipperOrders as $order)
                                    <tr>
                                        <td>{{ $shipper->name }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->order_code }}</td>
                                        <td>{{ $order->payment_status}},<br>{{$order->payment_method}}</td>
                                        <td class="address-column">
                                            {{ $order->address }},
                                            <br>{{ $order->ward->name_xaphuong ?? "...." }},
                                            <br>{{ $order->province->name_quanhuyen ?? "...." }},
                                            {{ $order->city->name_thanhpho ?? "...." }}
                                        </td>
                                        <td>{{ $order->phone_number }}</td>
                                            <td>
                                                @if(!in_array($order->status, ['ship_đã_nhận','chờ_giao_hàng','đang_giao_hàng', 'giao_hàng_thành_công', 'đã_nhận_hàng','giao_hàng_không_thành_công']))
                                                <form action="{{ route('admin.order.removeShipper', $order->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Không nhận đơn</button>
                                                </form>
                                            @endif
                                            @if(in_array($order->status, ['đã_xác_nhận']))
                                            <form action="{{ route('admin.order.update-updateStatusShip', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="ship_đã_nhận">
                                                <button type="submit" class="btn btn-primary">Nhận đơn</button>
                                            </form>
                                        @endif
                                                <form action="{{ route('admin.order.update-updateStatusShip', $order->id) }}" method="POST">
                                                    @csrf
                                                    <select name="status" class="form-control " onchange="showReasonField(this)">
                                                        @if($order->status == 'chờ_xác_nhận')
                                                            <option value="chờ_xác_nhận" {{ $order->status == 'chờ_xác_nhận' ? 'selected' : '' }}>Chờ Xác Nhận</option>
                                                        @elseif($order->status == 'đã_xác_nhận')
                                                            <option value="đã_xác_nhận" {{ $order->status == 'đã_xác_nhận' ? 'selected' : '' }}>Đã Xác Nhận</option>
                                                        @elseif($order->status == 'ship_đã_nhận')
                                                            <option value="ship_đã_nhận" {{ $order->status == 'ship_đã_nhận' ? 'selected' : '' }}>Ship đã nhận</option>
                                                            <option value="chờ_giao_hàng" {{ $order->status == 'chờ_giao_hàng' ? 'selected' : '' }}>Chờ Giao Hàng</option>

                                                        @elseif($order->status == 'chờ_giao_hàng')
                                                            <option value="chờ_giao_hàng" {{ $order->status == 'chờ_giao_hàng' ? 'selected' : '' }}>Chờ Giao Hàng</option>
                                                            <option value="đang_giao_hàng" {{ $order->status == 'đang_giao_hàng' ? 'selected' : '' }}>Đang Giao Hàng</option>
                                                        @elseif($order->status == 'đang_giao_hàng')
                                                            <option value="đang_giao_hàng" {{ $order->status == 'đang_giao_hàng' ? 'selected' : '' }}>Đang Giao Hàng</option>
                                                            <option value="giao_hàng_thành_công" {{ $order->status == 'giao_hàng_thành_công' ? 'selected' : '' }}>Giao Hàng Thành Công</option>
                                                            <option value="giao_hàng_không_thành_công" {{ $order->status == 'giao_hàng_không_thành_công' ? 'selected' : '' }}>Giao Hàng Không Thành Công</option>
                                                        @elseif($order->status == 'giao_hàng_thành_công')
                                                            <option value="giao_hàng_thành_công" {{ $order->status == 'giao_hàng_thành_công' ? 'selected' : '' }}>Giao Hàng Thành Công</option>
                                                            @elseif($order->status == 'giao_hàng_không_thành_công')
                                                            <option value="giao_hàng_không_thành_công" {{ $order->status == 'giao_hàng_không_thành_công' ? 'selected' : '' }}>Giao Hàng Không Thành Công</option>
                                                        @elseif($order->status == 'đã_nhận_hàng')
                                                        <option value="đã_nhận_hàng" {{ $order->status == 'đã_nhận_hàng' ? 'selected' : '' }}>Đã nhận hàng</option>
                                                        @elseif($order->status == 'hủy')
                                                            <option value="hủy" {{ $order->status == 'hủy' ? 'selected' : '' }}>Hủy</option>
                                                        @endif
                                                    </select>
                                                    @if($order->status != 'hủy' &&  $order->status != 'giao_hàng_thành_công' &&  $order->status != 'đã_nhận_hàng' &&  $order->status != 'giao_hàng_không_thành_công'
                                                    &&  $order->status != 'chờ_xác_nhận'  &&  $order->status != 'đã_xác_nhận'
                                                    )
                                                    <button type="submit" class="btn btn-success btn-sm mt-2">Cập Nhật</button>
                                                    @endif
                                                </form>
                                            </td>
                                       
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
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
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });

   
</script>
@endsection
