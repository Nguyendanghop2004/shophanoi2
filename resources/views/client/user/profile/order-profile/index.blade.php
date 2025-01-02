@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection
@section('content')
    <!-- categories -->
    <section class="flat-spacing-20">
        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <!-- page-cart -->
                <!-- page-title -->
                <div class="tf-page-title">
                    <div class="container-full">
                        <div class="heading text-center">Đơn hàng của tôi</div>
                    </div>
                </div>
                <!-- /page-title -->

                <!-- page-cart -->
                <section class="flat-spacing-11">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3">
                                <ul class="my-account-nav">
                                    @include('client.user.account-nav')

                                </ul>
                            </div>
                            <div class="col-lg-9">
                                <div class="wd-form-order">

                                    <div class="order-head">
                                        {{-- <figure class="img-product">
                                            @foreach ($order->Orderitems as $item)
                                                <img src="{{ Storage::url($item->image_url) }}" alt="Ảnh sản phẩm">
                                            @endforeach
                                        </figure> --}}
                                        <div class="content">
                                            <h6 class="mt-8 fw-5">Mã đơn hàng:{{ $order['order_code'] }}</h6>
                                        </div>
                                    </div>
                                    <div class="tf-grid-layout md-col-2 gap-15">

                                        {{-- {{  }} --}}
                                        {{-- @dd($order->Orderitems) --}}
                                        {{-- <div class="item">
                                            <div class="text-2 text_black-2">Trạng thái đơn hàng</div>
                                            <div class="text-2 mt_4 fw-6">

                                                {{ $order['status'] }}

                                            </div>
                                        </div> --}}
                                        <div class="item">
                                            <div class="text-2 text_black-2">Thời gian</div>
                                            <div class="text-2 mt_4 fw-6">

                                                {{ $order->created_at->format('d/m/Y H:i:s') }}
                                            </div>
                                        </div>

                                        <div class="item">
                                            <div class="text-2 text_black-2">Đỉa chỉ</div>
                                            <div class="text-2 mt_4 fw-6">{{ $order->address }}</div>
                                        </div>
                                    </div>
                                    <div class="widget-tabs style-has-border widget-order-tab">
                                        <ul class="widget-menu-tab">
                                            <li class="item-title active">
                                                <span class="inner">Lịch sử đơn hàng</span>
                                            </li>
                                            <li class="item-title">
                                                <span class="inner">Chi tiết mặt hàng</span>
                                            </li>
                                            <li class="item-title">
                                                <span class="inner">Người nhận</span>
                                            </li>
                                        </ul>
                                        <div class="widget-content-tab">
                                            <div class="widget-content-inner active">
                                                <div class="widget-timeline">
                                                    <ul class="timeline">
                                                        {{-- <li>
                                                            <div class="timeline-badge success"></div>
                                                            <div class="timeline-box">
                                                                <div class="text-2 fw-6"> Trang thái </div>
                                                                <span>{{ $order->status }} </span>
                                                                <p><strong>Courier Service : </strong>FedEx World Service
                                                                    Center</p>
                                                                <p><strong>Thời gian :
                                                                    </strong>{{ $order->updated_at->format('d/m/Y H:i:s') }}
                                                                </p>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="timeline-badge success"></div>
                                                            <div class="timeline-box">
                                                                <div class="text-2 fw-6"> Trang thái </div>
                                                                <span>{{ $order->status }} </span>
                                                                <p><strong>Courier Service : </strong>FedEx World Service
                                                                    Center</p>
                                                                <p><strong>Thời gian :
                                                                    </strong>{{ $order->updated_at->format('d/m/Y H:i:s') }}
                                                                </p>
                                                            </div>
                                                        </li> --}}
                                                        @if ($order->status = 'hủy')
                                                        <li>
                                                            <div class="timeline-badge "></div>
                                                            <div class="timeline-box">

                                                                <div class="text-2 fw-6">Trang thái:</div>
                                                                <span>Đơn hàng của bạn đã hủy</span>
                                                                <div class="text-2 fw-6">Thời gian cập nhật:</div>
                                                                <span>{{ $order->updated_at->format('d/m/Y H:i:s') }}</span>

                                                            </div>
                                                        </li>
                                                        @else
                                                            <li>
                                                                <div class="timeline-badge success"></div>
                                                                <div class="timeline-box">

                                                                    <div class="text-2 fw-6">Trang thái:</div>
                                                                    <span>{{ $order->status }}</span>
                                                                    <div class="text-2 fw-6">Thời gian cập nhật:</div>
                                                                    <span>{{ $order->updated_at->format('d/m/Y H:i:s') }}</span>

                                                                </div>
                                                            </li>
                                                        @endif


                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="widget-content-inner">
                                                @foreach ($order->Orderitems as $item)
                                                    <div class="order-head">
                                                        <figure class="img-product">
                                                            <img src="{{ Storage::url($item->image_url) }}" alt="product">
                                                        </figure>
                                                        <div class="content">

                                                            <div class="text-2 fw-6">{{ $item->product_name }}</div>
                                                            <div class="mt_4"><span class="fw-6">Giá :</span>
                                                                {{ $item->price }}
                                                            </div>
                                                            <div class="mt_4"><span class="fw-6">Kích thước :</span>
                                                                {{ $item->size_name }}</div>
                                                            <div class="mt_4"><span class="fw-6">Màu sắc :</span>
                                                                {{ $item->color_name }}</div>
                                                            <div class="mt_4"><span class="fw-6">Số lượng :</span>
                                                                {{ $item->quantity }}</div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                                <ul>
                                                    <li class="d-flex justify-content-between text-2">
                                                        <span>Tổng giá</span>
                                                        <span class="fw-6">{{ $order->total_price }}</span>
                                                    </li>
                                                    <li class="d-flex justify-content-between text-2 mt_4 pb_8 line">
                                                        <span>Giảm</span>
                                                        <span class="fw-6">$10</span>

                                                    </li>
                                                    <li class="d-flex justify-content-between text-2 mt_8">
                                                        <span>Tổng đơn hàng</span>
                                                        <span class="fw-6">{{ $order->total_price }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="widget-content-inner">
                                                <ul class="mt_20">
                                                    <li>Số đơn hàng : <span class="fw-7">{{ $order->order_code }}</span>
                                                    </li>
                                                    <li>Thời gian : <span class="fw-7">
                                                            {{ $order->created_at->format('d/m/Y H:i:s') }}</span></li>
                                                    <li>Tổng đơn hàng : <span
                                                            class="fw-7">{{ $order->total_price }}</span></li>
                                                    <li>Phương thức thanh toán : <span
                                                            class="fw-7">{{ $order->payment_method }}</span></li>

                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- page-cart -->
                <!-- page-cart -->
            </div>
        </div>
        </div>

        </div>
    </section>
@endsection

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
    q
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.add('fade');
                alert.classList.remove('show');
            }, 5000); // 5 giây
        });
    });
</script>
