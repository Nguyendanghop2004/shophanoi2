@extends('admin.layouts.master')

@section('content')
    <style>
        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .address-column {
            word-wrap: break-word;
            max-width: 200px;
        }.status-cho-xac-nhan {
    background-color: #ffc107;
    color: #000;
}
.status-chua-nhan {
    background-color:#8B1A1A; 
    color: #fff;
}
.status-huy {
    background-color:#FF0000; 
    color: #fff;
}
.status-da-nhan-hang {
    background-color: #00EE00; 
    color: #fff;
}
       

    </style>
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
                                <th scope="col">Lý do chưa nhận</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shippers as $shipper)
                                @php
                                    $shipperOrders = $orders->where('assigned_shipper_id', $shipper->id);
                                @endphp
                                @if ($shipperOrders->isNotEmpty())
                                    @foreach ($shipperOrders as $order)
                                        <tr>
                                            <td>{{ $shipper->name }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->order_code }}</td>
                                            <td>{{ $order->payment_status }},<br>{{ $order->payment_method }}</td>
                                            <td class="address-column">
                                                {{ $order->address }},
                                                <br>{{ $order->ward->name_xaphuong ?? '....' }},
                                                <br>{{ $order->province->name_quanhuyen ?? '....' }},
                                                {{ $order->city->name_thanhpho ?? '....' }}
                                            </td>
                                            <td>{{ $order->phone_number }}</td>
                                            <td>{{ $order->reason_faile_order}}</td>
                                            <td>
                                                @if (auth()->user()->hasRole('Shipper'))
                                                @if (
                                                    !in_array($order->status, [
                                                        'ship đã nhận',
                                                        'đang giao hàng',
                                                        'giao hàng thành công',
                                                        'đã nhận hàng',
                                                        'giao hàng không thành công',
                                                        'chưa nhận được hàng',

                                                    ]))
                                                    <form action="{{ route('admin.order.removeShipper', $order->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="button" class="btn btn-danger btn-sm mt-2"
                                                            onclick="confirmUpdateForm(this)">
                                                            Không nhận</button>
                                                    </form>
                                                @endif
                                                @if (in_array($order->status, ['đã xác nhận']))
                                                    <form
                                                        action="{{ route('admin.order.update-updateStatusShip', $order->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <input type="hidden" name="status" value="ship đã nhận">
                                                        <button type="button" class="btn btn-success btn-sm mt-2"
                                                            onclick="confirmUpdateForms(this)">
                                                            nhận đơn</button>
                                                    </form>
                                                @endif
                                            @endif
                                            
                                           
                                            
                                                <form
                                                    action="{{ route('admin.order.update-updateStatusShip', $order->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <select name="status" class="form-control"
                                                        onchange="showReasonField(this)">
                                                        @if ($order->status == 'chờ xác nhận')
                                                            <option value="chờ xác nhận"
                                                                {{ $order->status == 'chờ xác nhận' ? 'selected' : '' }}>
                                                                Chờ Xác Nhận</option>
                                                        @elseif($order->status == 'đã xác nhận')
                                                            <option value="đã xác nhận"
                                                                {{ $order->status == 'đã xác nhận' ? 'selected' : '' }}>Đã
                                                                Xác Nhận</option>
                                                        @elseif($order->status == 'ship đã nhận')
                                                            <option value="ship đã nhận"
                                                                {{ $order->status == 'ship đã nhận' ? 'selected' : '' }}>
                                                                Ship đã nhận</option>
                                                            <option value="đang giao hàng"
                                                                {{ $order->status == 'đang giao hàng' ? 'selected' : '' }}>
                                                                Đang Giao Hàng</option>
                                                        @elseif($order->status == 'đang giao hàng')
                                                            <option value="đang giao hàng"
                                                                {{ $order->status == 'đang giao hàng' ? 'selected' : '' }}>
                                                                Đang Giao Hàng</option>
                                                            <option value="giao hàng thành công"
                                                                {{ $order->status == 'giao hàng thành công' ? 'selected' : '' }}>
                                                                Giao Hàng Thành Công</option>
                                                            <option value="giao hàng không thành công"
                                                                {{ $order->status == 'giao hàng không thành công' ? 'selected' : '' }}>
                                                                Giao Hàng Không Thành Công</option>
                                                        @elseif($order->status == 'giao hàng thành công')
                                                            <option value="giao hàng thành công"
                                                                {{ $order->status == 'giao hàng thành công' ? 'selected' : '' }}>
                                                                Giao Hàng Thành Công</option>
                                                        @elseif($order->status == 'giao hàng không thành công')
                                                            <option value="giao hàng không thành công"
                                                                {{ $order->status == 'giao hàng không thành công' ? 'selected' : '' }}>
                                                                Giao Hàng Không Thành Công</option>
                                                        @elseif($order->status == 'đã nhận hàng')
                                                            <option value="đã nhận hàng"
                                                                {{ $order->status == 'đã nhận hàng' ? 'selected' : '' }}>Hoàn thành</option>
                                                        @elseif($order->status == 'chưa nhận được hàng')
                                                            <option value="chưa nhận được hàng"
                                                                {{ $order->status == 'chưa nhận được hàng' ? 'selected' : '' }}>Khách chưa nhận được hàng</option>
                                                        @elseif($order->status == 'hủy')
                                                            <option value="hủy"
                                                                {{ $order->status == 'hủy' ? 'selected' : '' }}>Hủy
                                                            </option>
                                                        @endif
                                                    </select>
                                                    @if (auth()->user()->hasRole('Shipper'))
                                                    @if (
                                                            $order->status != 'hủy' &&
                                                            $order->status != 'giao hàng thành công' &&
                                                            $order->status != 'đã nhận hàng' &&
                                                            $order->status != 'giao hàng không thành công' &&
                                                            $order->status != 'chờ xác nhận' &&
                                                            $order->status != 'chưa nhận được hàng' &&
                                                            $order->status != 'đã xác nhận')
                                                        <button type="button" class="btn btn-primary btn-sm mt-2"
                                                            onclick="confirmUpdateFormss(this)">
                                                            cập nhật</button>
                                                    @endif
                                                    @endif

                                                </form>
                                                @can('account_admin')
                                                @if (
                                                    !in_array($order->status, [
                                                        'ship đã nhận',
                                                        'đang giao hàng',
                                                        'giao hàng thành công',
                                                        'đã nhận hàng',
                                                        'giao hàng không thành công',
                                                    ]))
                                                     <form action="{{ route('admin.order.removeShipper', $order->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="button" class="btn btn-danger btn-sm mt-2"
                                                            onclick="confirmUpdateForm(this)">
                                                            Hoàn tác đơn</button>
                                                    </form>
                                                    @endif
                                                    @endcan
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmUpdateForm(button) {
            Swal.fire({
                title: 'Bạn muốn hủy nhận đơn hàng này?',
                text: "bạn có chắc không!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Cập nhật!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu xác nhận, gửi form
                    button.closest('form').submit();
                }
            });
        }

        function confirmUpdateForms(button) {
            Swal.fire({
                title: 'Bạn có muốn nhận đơn hàng này?',
                text: "bạn có chắc không!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Cập nhật!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu xác nhận, gửi form
                    button.closest('form').submit();
                }
            });
        }

        function confirmUpdateFormss(button) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?',
                text: "Bạn không thể hoàn tác thay đổi này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Cập nhật!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu xác nhận, gửi form
                    button.closest('form').submit();
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
    <script>
    function applyStatusColor(selectElement) {
    const statusClasses = {
        'chờ xác nhận': 'status-cho-xac-nhan',
        'đã xác nhận': 'status-da-xac-nhan',
        'ship đã nhận': 'status-ship-da-nhan',
        'đang giao hàng': 'status-dang-giao-hang',
        'giao hàng thành công': 'status-giao-hang-thanh-cong',
        'giao hàng không thành công': 'status-giao-hang-khong-thanh-cong',
        'hủy': 'status-huy',
        'chưa nhận được hàng': 'status-chua-nhan',
        'đã nhận hàng': 'status-da-nhan-hang'
    };

    selectElement.className = selectElement.className.replace(/status-\w+/g, '');

    const selectedStatus = selectElement.value.trim();
    if (statusClasses[selectedStatus]) {
        selectElement.classList.add(statusClasses[selectedStatus]);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('select[name="status"]').forEach(select => {
        applyStatusColor(select);
        select.addEventListener('change', function () {
            applyStatusColor(this);
        });
    });
});

</script>
@endsection
