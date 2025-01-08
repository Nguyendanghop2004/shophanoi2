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
                        <th>Ngày đặt</th>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Tên Shipper</th>
                        <td>{{ $shipper ? $shipper->name : 'Chưa có shipper' }}</td>
                    </tr>
                    
                </table>
                <tr>
                    <h3>Tổng sản phẩm đã đặt</h3>
                    <td>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh Sản Phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderitems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <img src="{{Storage::Url($item->image_url)}}" width="60px" height="60px">
                                        </td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</td>
                                    </tr>

                                @endforeach
                                <tr>
                                    <th>Total Price</th>
                                    <td class="text-left">{{ number_format($order->total_price, 0, ',', '.')}} VND</td>
                                </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
            </div>
        </div>
        <div class="card-footer text-right">
            <a href="{{ route('admin.order.getList') }}" class="btn btn-primary">Quay Lại</a>
            <a href="{{ route('admin.order.inHoaDon', ['id' => Crypt::encryptString($order->id)]) }}" 
   class="btn btn-success" 
   onclick="confirmPrintInvoice(event)">
    In Hóa Đơn
</a>
        </div>
        
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmPrintInvoice(event) {
        event.preventDefault(); // Ngừng hành động mặc định của thẻ <a>
        Swal.fire({
            title: 'Bạn có muốn in hóa đơn này?',
            text: "Bạn không thể hoàn tác thay đổi này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'In Hóa Đơn',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Nếu xác nhận, chuyển hướng tới URL in hóa đơn
                window.location.href = event.target.href;
            }
        });
    }
</script>
<script>
         document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });
</script>
@endsection