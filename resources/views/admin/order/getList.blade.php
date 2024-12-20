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
                                <option value="chờ_xác_nhận" {{ request('status') == 'chờ_xác_nhận' ? 'selected' : '' }}>Chờ Xác Nhận</option>
                                <option value="đã_xác_nhận" {{ request('status') == 'đã_xác_nhận' ? 'selected' : '' }}>Đã Xác Nhận</option>
                                <option value="đang_giao_hàng" {{ request('status') == 'đang_giao_hàng' ? 'selected' : '' }}>Đang Giao Hàng</option>
                                <option value="giao_hàng_thành_công" {{ request('status') == 'giao_hàng_thành_công' ? 'selected' : '' }}>Giao Hàng Thành Công</option>
                                <option value="đã_nhận_hàng" {{ request('status') == 'đã_nhận_hàng' ? 'selected' : '' }}>Đã nhận hàng</option>
                                <option value="hủy" {{ request('status') == 'hủy' ? 'selected' : '' }}>Hủy</option>
                            </select>
                            <select name="payment_method" class="form-control ml-2" onchange="this.form.submit()">
                                <option value="">Tất cả thanh toán</option>
                                <option value="vnpay" {{ request('payment_method') == 'vnpay' ? 'selected' : '' }}>Thanh Toán VNPAY</option>
                                <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>Thanh Toán COD</option>
                            </select>
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
                            =
                                <th scope="col">Price</th>
                                <th scope="col">Mã Đơn Hàng</th>
                                <th scope="col">Thanh toán</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Action</th>
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
                                            @if($order->status == 'chờ_xác_nhận')
                                                <option value="chờ_xác_nhận" {{ $order->status == 'chờ_xác_nhận' ? 'selected' : '' }}>Chờ Xác Nhận</option>
                                                <option value="đã_xác_nhận" {{ $order->status == 'đã_xác_nhận' ? 'selected' : '' }}>Đã Xác Nhận</option>
                                                <option value="hủy" {{ $order->status == '' ? 'selected' : '' }}>Hủy</option>
                                            @elseif($order->status == 'đã_xác_nhận')
                                                <option value="đã_xác_nhận" {{ $order->status == 'đã_xác_nhận' ? 'selected' : '' }}>Đã Xác Nhận</option>
                                                <option value="chờ_giao_hàng" {{ $order->status == 'chờ_giao_hàng' ? 'selected' : '' }}>Chờ Giao Hàng</option>
                                                <option value="hủy" {{ $order->status == 'hủy' ? 'selected' : '' }}>Hủy</option>
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
                                        @if($order->status != 'hủy' &&  $order->status != 'giao_hàng_thành_công'  &&  $order->status != 'giao_hàng_không_thành_công' &&  $order->status != 'đã_nhận_hàng')
                                        <button type="submit" class="btn btn-success btn-sm mt-2">Cập Nhật</button>
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

@endsection
