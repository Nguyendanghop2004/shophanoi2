

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
    }.nav-tabs .nav-item .nav-link {
    margin: 5px;
    padding: 10px 20px;
    border-radius: 25px;
    background: linear-gradient(135deg, #8a2387, #e94057, #f27121); 
    border: none;
    color: white;
    cursor: pointer;
    transition: background 0.3s, color 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.nav-tabs .nav-item .nav-link.active {
    background: linear-gradient(135deg, #8a2387, #e94057, #f27121); 
    color: white;
}

.nav-tabs .nav-item .nav-link:hover {
    background: linear-gradient(135deg, #f27121, #e94057, #8a2387); 
    color: white;
}
.badge {
    padding: 5px 10px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: bold;
    display: inline-block;
    text-align: center;
}

.badge-chờ-xác-nhận {
    background-color: #ffc107;
    color: #fff;
}

.badge-đã-xác-nhận {
    background-color: #007bff;
    color: #fff;
}

.badge-hủy {
    background-color: #dc3545;
    color: #fff;
}

.badge-ship-đã-nhận {
    background-color: #17a2b8;
    color: #fff;
}

.badge-đang-giao-hàng {
    background-color: #6c757d;
    color: #fff;
}

.badge-giao-hàng-thành-công {
    background-color: #28a745;
    color: #fff;
}

.badge-giao-hàng-không-thành-công {
    background-color: #6c757d;
    color: #fff;
}

.badge-đã-nhận-hàng {
    background-color: #28a745;
    color: #fff;
}



</style>

<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <button class="nav-link btn {{ $status === '' ? 'active' : '' }}" onclick="window.location.href='{{ route('order.donhang', ['status' => '']) }}'">Tất cả đơn hàng</button>
        </li>
        <li class="nav-item">
            <button class="nav-link btn {{ $status === 'chờ xác nhận' ? 'active' : '' }}" onclick="window.location.href='{{ route('order.donhang', ['status' => 'chờ xác nhận']) }}'">Chờ xác nhận</button>
        </li>
        <li class="nav-item">
            <button class="nav-link btn {{ $status === 'đã xác nhận' ? 'active' : '' }}" onclick="window.location.href='{{ route('order.donhang', ['status' => 'đã xác nhận']) }}'">Đã xác nhận</button>
        </li>
        <li class="nav-item">
            <button class="nav-link btn {{ $status === 'ship đã nhận' ? 'active' : '' }}" onclick="window.location.href='{{ route('order.donhang', ['status' => 'ship đã nhận']) }}'">Ship đã nhận</button>
        </li>
        <li class="nav-item">
            <button class="nav-link btn {{ $status === 'đang giao hàng' ? 'active' : '' }}" onclick="window.location.href='{{ route('order.donhang', ['status' => 'đang giao hàng']) }}'">Đang giao hàng</button>
        </li>
        <li class="nav-item">
            <button class="nav-link btn {{ $status === 'giao hàng thành công' ? 'active' : '' }}" onclick="window.location.href='{{ route('order.donhang', ['status' => 'giao hàng thành công']) }}'">Giao hàng thành công</button>
        </li>
        <li class="nav-item">
            <button class="nav-link btn {{ $status === 'đã nhận hàng' ? 'active' : '' }}" onclick="window.location.href='{{ route('order.donhang', ['status' => 'đã nhận hàng']) }}'">Đơn hàng đã nhận</button>
        </li>
        <li class="nav-item">
            <button class="nav-link btn {{ $status === 'chưa nhận được hàng' ? 'active' : '' }}" onclick="window.location.href='{{ route('order.donhang', ['status' => 'chưa nhận được hàng']) }}'">Chưa nhận được hàng</button>
        </li>
        <li class="nav-item">
            <button class="nav-link btn {{ $status === 'giao hàng không thành công' ? 'active' : '' }}" onclick="window.location.href='{{ route('order.donhang', ['status' => 'giao hàng không thành công']) }}'">Đơn hàng hoàn về</button>
        </li>
        <li class="nav-item">
            <button class="nav-link btn {{ $status === 'hủy' ? 'active' : '' }}" onclick="window.location.href='{{ route('order.donhang', ['status' => 'hủy']) }}'">Đã hủy</button>
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
                                    <h5 class="card-title mb-1">{{ $order->order_code }}</h5>
                                    <span class="badge badge-{{ str_replace(' ', '-', strtolower($order->status)) }}">{{ $order->status }}</span>
                                </div>

                                <p class="card-text mb-1"><small class="text-muted">{{ $order->created_at }}</small></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="card-text mb-1"><strong>Tổng tiền: </strong> <span class="text-danger"> {{ number_format($order->total_price, 0, ',', '.') }} VND</span></p>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('client.orders.show', ['id' => Crypt::encryptString($order->id)]) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                                    
                                    @if ($order->status === 'đã nhận hàng')
                                       
                                            <a href="{{ route('client.reviews.create', ['orderId' => $order->id, 'productId' => $order->product_id]) }}" class="btn btn-warning btn-sm">Đánh giá sản phẩm  </a>
                                       
                                    @endif
                                    @if ($order->status === 'giao hàng thành công')
                                    <form action="{{ route('orders.confirm', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Đã nhận hàng</button>
                                    </form>
                                    @endif
                                    @if ($order->status === 'giao hàng thành công')
                                    <button class="btn btn-danger btn-sm notReceivedBtn" data-order-id="{{ $order->id }}" data-action="{{ route('orders.notReceived', $order->id) }}">Chưa nhận được hàng</button>
                                 @endif
                                

                                    @if (in_array($order->status, ['chờ xác nhận', 'đã xác nhận']))
                                        <button class="btn btn-danger cancelOrderBtn" data-order-id="{{ $order->id }}" data-action="{{ route('client.orders.cancel', $order->id) }}">Hủy đơn hàng</button>
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
{{-- hủy đơn hàng --}}
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Lý do hủy đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cancelOrderForm" action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="cancelReason" class="form-label">Chọn lý do hủy đơn</label>
                        <select class="form-select" id="cancelReason" name="reason" required>
                            <option value="" disabled selected>Chọn lý do</option>
                            <option value="Không muốn mua nữa">Không muốn mua nữa</option>
                            <option value="Thay đổi địa chỉ giao hàng">Thay đổi địa chỉ giao hàng</option>
                            <option value="Sản phẩm không còn cần thiết">Sản phẩm không còn cần thiết</option>
                            <option value="Thay đổi quyết định">Thay đổi quyết định</option>
                     
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- chưa nhận đc hàng --}}
<div class="modal fade" id="notReceivedModal" tabindex="-1" aria-labelledby="notReceivedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notReceivedModalLabel">Lý do chưa nhận được hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="notReceivedForm" action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="notReceivedReason" class="form-label">Chọn lý do</label>
                        <select class="form-select" id="notReceivedReason" name="reason" required>
                            <option value="" disabled selected>Chọn lý do</option>
                            <option value="Hàng chưa được giao đến địa chỉ">Hàng chưa được giao đến địa chỉ</option>
                            <option value="Thời gian giao hàng chậm trễ">Thời gian giao hàng chậm trễ</option>
                            <option value="Người giao hàng không liên lạc được">Người giao hàng không liên lạc được</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.cancelOrderBtn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); 

                const orderId = this.getAttribute('data-order-id');
                const actionUrl = this.getAttribute('data-action');

                const cancelOrderForm = document.getElementById('cancelOrderForm');
                cancelOrderForm.action = actionUrl;

                const modal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
                modal.show(); 
            });
        });

        document.getElementById('cancelOrderForm').addEventListener('submit', function (event) {
            const reason = document.getElementById('cancelReason').value;
            if (!reason) {
                event.preventDefault();
                alert('Vui lòng chọn lý do hủy đơn');
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
     document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 5000
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 5000
                });
            @endif
        });

   
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.notReceivedBtn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const orderId = this.getAttribute('data-order-id');
            const actionUrl = this.getAttribute('data-action');

            const notReceivedForm = document.getElementById('notReceivedForm');
            notReceivedForm.action = actionUrl;

            const modal = new bootstrap.Modal(document.getElementById('notReceivedModal'));
            modal.show();
        });
    });

    document.getElementById('notReceivedForm').addEventListener('submit', function (event) {
        const reason = document.getElementById('notReceivedReason').value;
        if (!reason) {
            event.preventDefault();
            alert('Vui lòng chọn lý do chưa nhận được hàng');
        }
    });
});

</script>
@endsection