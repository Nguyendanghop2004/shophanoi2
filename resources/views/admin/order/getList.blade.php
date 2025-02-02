@extends('admin.layouts.master')

@section('content')
<section class="section">
    <style>
        .status-cho-xac-nhan {
    background-color: #ffc107;
    color: #000;
}

.status-huy {
    background-color:#FF4040; 
    color: #fff;
}
.status-chua-nhan {
    background-color:#8B1A1A; 
    color: #fff;
}
.status-da-nhan-hang {
    background-color: #00EE00; 
    color: #fff;
}

    </style>
    <div class="section-header">
        <h1>Danh Mục Đơn Hàng</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Đơn Hàng</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-primary"></a>
            </div>
        </div>
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0"></div>
                <div class="card-header-action">
                    <form class="form-inline" method="GET" action="{{ route('admin.order.getList') }}">
                        <div class="search-element">
                            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm" value="{{ request('search') }}">
                            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                            <select name="status" class="form-control ml-2" onchange="this.form.submit()">
                                <option value="">Tất cả trạng thái</option>
                                <option value="chờ xác nhận" {{ request('status') == 'chờ xác nhận' ? 'selected' : '' }}>Chờ Xác Nhận</option>
                                <option value="đã xác nhận" {{ request('status') == 'đã xác nhận' ? 'selected' : '' }}>Đã Xác Nhận</option>
                                <option value="ship đã nhận" {{ request('status') == 'ship đã nhận' ? 'selected' : '' }}>Ship đã nhận</option>
                                <option value="đang giao hàng" {{ request('status') == 'đang giao hàng' ? 'selected' : '' }}>Đang Giao Hàng</option>
                                <option value="giao hàng thành công" {{ request('status') == 'giao hàng thành công' ? 'selected' : '' }}>Giao Hàng Thành Công</option>
                                <option value="giao hàng không thành công" {{ request('status') == 'giao không hàng thành công' ? 'selected' : '' }}>Giao Hàng Không Thành Công</option>
                                <option value="đã nhận hàng" {{ request('status') == 'đã nhận hàng' ? 'selected' : '' }}>Đã nhận hàng</option>
                                <option value="hủy" {{ request('status') == 'hủy' ? 'selected' : '' }}>Hủy</option>
                            </select>
                            <select name="payment_method" class="form-control ml-2" onchange="this.form.submit()">
                                <option value="">Tất cả thanh toán</option>
                                <option value="vnpay" {{ request('payment_method') == 'vnpay' ? 'selected' : '' }}>Thanh Toán VNPAY</option>
                                <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>Thanh Toán COD</option>
                            </select>
                            <div class="form-check form-check-inline ml-2">
                                <input type="checkbox" name="filter_7_days" class="form-check-input" id="filter7Days" 
                                       onchange="this.form.submit()" {{ request('filter_7_days') == 'on' ? 'checked' : '' }}>
                                <label class="form-check-label" for="filter7Days">Lọc đơn chưa xác nhận sau 7 ngày giao thành công</label>
                            </div>
                        </div>
                        
                    </form> 
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID đơn hàng </th>
                                <th scope="col">Tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Price</th>
                                <th scope="col">Mã Đơn Hàng</th>
                                <th scope="col">Thanh toán</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                            
                                <td>{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->payment_status}}</td>
                                <td>
                                    <form action="{{ route('admin.order.update-status', $order->id) }}" method="POST">
                                        @csrf
                                        <select name="status" class="form-control " onchange="showReasonField(this)">
                                            @if($order->status == 'chờ xác nhận')
                                                <option value="chờ xác nhận" {{ $order->status == 'chờ xác nhận' ? 'selected' : '' }}>Chờ Xác Nhận</option>
                                                <option value="đã xác nhận" {{ $order->status == 'đã xác nhận' ? 'selected' : '' }}>Đã Xác Nhận</option>
                                                <option value="hủy" {{ $order->status == '' ? 'selected' : '' }}>Hủy</option>
                                            @elseif($order->status == 'đã xác nhận')
                                                <option value="đã xác nhận" {{ $order->status == 'đã xác nhận' ? 'selected' : '' }}>Đã Xác Nhận</option>
                                                <option value="hủy" {{ $order->status == 'hủy' ? 'selected' : '' }}>Hủy</option>
                                            @elseif($order->status == 'ship đã nhận')
                                                <option value="ship đã nhận" {{ $order->status == 'ship đã nhận' ? 'selected' : '' }}>Ship đã nhận</option>
                                                <option value="đang giao hàng" {{ $order->status == 'đang giao hàng' ? 'selected' : '' }}>Đang Giao Hàng</option>
                                            @elseif($order->status == 'đang giao hàng')
                                                <option value="đang giao hàng" {{ $order->status == 'đang giao hàng' ? 'selected' : '' }}>Đang Giao Hàng</option>
                                                <option value="giao hàng thành công" {{ $order->status == 'giao hàng thành công' ? 'selected' : '' }}>Giao Hàng Thành Công</option>
                                                <option value="giao hàng không thành công" {{ $order->status == 'giao hàng không thành công' ? 'selected' : '' }}>Giao Hàng Không Thành Công</option>
                                            @elseif($order->status == 'giao hàng thành công')
                                                <option value="giao hàng thành công" {{ $order->status == 'giao hàng thành công' ? 'selected' : '' }}>Giao Hàng Thành Công</option>
                                                <option value="đã nhận hàng" {{ $order->status == 'đã nhận hàng' ? 'selected' : '' }}>Hoàn thành</option>
                                            @elseif($order->status == 'giao hàng không thành công')
                                                <option value="giao hàng không thành công" {{ $order->status == 'giao hàng không thành công' ? 'selected' : '' }}>Giao Hàng Không Thành Công</option>
                                            @elseif($order->status == 'đã nhận hàng')
                                            <option value="đã nhận hàng" {{ $order->status == 'đã nhận hàng' ? 'selected' : '' }}>Hoàn thành</option>
                                            @elseif($order->status == 'chưa nhận được hàng')
                                            <option value="chưa nhận được hàng" {{ $order->status == 'chưa nhận được hàng' ? 'selected' : '' }}>Chưa nhận được hàng</option>
                                            <option value="đã nhận hàng" {{ $order->status == 'đã nhận hàng' ? 'selected' : '' }}>Hoàn thành</option>

                                            @elseif($order->status == 'hủy')
                                                <option value="hủy" {{ $order->status == 'hủy' ? 'selected' : '' }}>Hủy</option>
                                            @endif
                                        </select>
                                        <div class="reason-field mt-2" style="display: none;">
                                            <select name="reason" class="form-control ">
                                                <option value="Không muốn mua nữa">Không muốn mua nữa</option>
                                                <option value="Thay đổi địa chỉ giao hàng">Thay đổi địa chỉ giao hàng</option>
                                                <option value="Sản phẩm không còn cần thiết">Sản phẩm không còn cần thiết</option>
                                                <option value="Tìm thấy giá rẻ hơn ở nơi khác">Tìm thấy giá rẻ hơn ở nơi khác</option>
                                                <option value="Quá trình giao hàng quá lâu">Quá trình giao hàng quá lâu</option>
                                                <option value="Phí vận chuyển quá cao">Phí vận chuyển quá cao</option>
                                                <option value="Đã đặt nhầm sản phẩm">Đã đặt nhầm sản phẩm</option>
                                                <option value="Đã mua sản phẩm từ cửa hàng khác">Đã mua sản phẩm từ cửa hàng khác</option>
                                                <option value="Sản phẩm không như mong đợi">Sản phẩm không như mong đợi</option>
                                            </select>
                                            <button type="button" class="btn btn-danger btn-sm mt-2 mx-2 close-btn" onclick="resetStatus(this)">X</button>
                                        </div>
                                        @if($order->status != 'hủy' &&  $order->status != 'giao hàng không thành công' &&  $order->status != 'đã nhận hàng')
                                    <button type="button"  class="btn btn-dark btn-sm mx-2 mt-2" onclick="confirmUpdateForm(this)">Cập Nhật</button>
                                         
                                    @endif

                                    </form>
                                </td>   
                                <td>
                                    <a href="{{ route('admin.order.chitiet',['id' => Crypt::encryptString($order->id)]) }}" class="btn btn-info btn-sm">Chi tiết</a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmUpdateForm(button) {
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
    let originalStatus = '';

    function showReasonField(selectElement) {
        var reasonField = selectElement.closest('td').querySelector('.reason-field');
        var selectedStatus = selectElement.value;

        if (selectedStatus === 'hủy' && !originalStatus) {
            originalStatus = selectElement.value;
        }

        if (selectedStatus === 'hủy') {
            reasonField.style.display = 'block';
        } else {
            reasonField.style.display = 'none';
        }
    }

    function resetStatus(button) {
        var reasonField = button.closest('.reason-field');
        var selectStatus = button.closest('td').querySelector('select[name="status"]');
        
        selectStatus.value = originalStatus;
        reasonField.style.display = 'none';
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
