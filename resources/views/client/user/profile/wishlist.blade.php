@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection
@section('content')
    <style>
        .no-products p {
            text-align: center;
            /* Căn giữa chữ */
            font-size: 20px;
            /* Tăng kích thước chữ */
            font-weight: bold;
            /* Để chữ đậm hơn */
            color: #333;
            /* Màu chữ đen hoặc tùy chọn màu sắc */
            margin-top: 20px;
            /* Cách phần trên một chút */
            padding: 20px;

            /* Thêm khoảng cách xung quanh văn bản */

        }
    </style>
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
                <!-- page-title -->
                <div class="tf-page-title">
                    <div class="container-full">
                        <div class="heading text-center">Danh sách yêu thích</div>
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
                                <div class="my-account-content account-wishlist">
                                    @if (empty($products) || $products->isEmpty())
                                        <div class="no-products">
                                            <p>Không có sản phẩm yêu thích nào.</p>
                                        </div>
                                        <!-- card product 1 -->
                                    @else
                                        <div class="grid-layout wrapper-shop" data-grid="grid-3">

                                            @foreach ($products as $product)
                                                <div class="card-product">
                                                    <div class="card-product-wrapper">
                                                        <a href="{{ route('product-detail', $product['slug']) }}"
                                                            class="product-img">
                                                            <img class="lazyload img-product"
                                                                data-src="{{ asset('storage/' . $product['main_image_url']) }}"
                                                                src="{{ asset('storage/' . $product['main_image_url']) }}"
                                                                alt="image-product">
                                                            <img class="lazyload img-hover"
                                                                data-src="{{ asset('storage/' . $product['hover_main_image_url']) }}"
                                                                src="{{ asset('storage/' . $product['hover_main_image_url']) }}"
                                                                alt="image-product">
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="box-icon bg_white wishlist btn-icon-action">
                                                            <div class="list-product-btn absolute-2">
                                                                <form action="{{ route('wishlist.remove') }}" method="POST"
                                                                    style="display: inline;">
                                                                    @csrf
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $product['id'] }}">
                                                                    <button type="submit"
                                                                        style="background: none; border: none;">
                                                                        <span class="icon icon-delete"></span>
                                                                        <span class="tooltip" style="right: 3px;">Xóa</span>
                                                                    </button>
                                                                </form>
                                                        </a>

                                                        <a href="#quick_view" data-bs-toggle="modal"
                                                            data-product-id="{{ $product['id'] }}"
                                                            class="box-icon bg_white quickview tf-btn-loading">
                                                            <span class="icon icon-bag"></span>
                                                            <span class="tooltip">
                                                                Xem nhanh</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="size-list">
                                                    <span>Có sẵn {{ $product['distinct_size_count'] }} kích thước</span>
                                                </div>
                                                <div class="card-product-info">
                                                    <a href="{{ route('product-detail', $product['slug']) }}"
                                                        class="title link">{{ $product['name'] }}</a>
                                                    <span class="price">{{ $product['price'] }} VNĐ</span>
                                                    <ul class="list-color-product">
                                                        @foreach ($product['colors'] as $index => $color)
                                                            <li
                                                                class="list-color-item color-swatch @if ($index == 0) active @endif">
                                                                <span class="tooltip">{{ $color['name'] }}</span>
                                                                <span class="swatch-value"
                                                                    style="background-color: {{ $color['sku_color'] }}"></span>
                                                                <img class="lazyload image-product"
                                                                    data-src="{{ asset('storage/' . $color['main_image']) }}"
                                                                    src="{{ asset('storage/' . $color['main_image']) }}"
                                                                    alt="image-product">
                                                                <img class="lazyload hover-image-product"
                                                                    data-src="{{ asset('storage/' . $color['hover_image']) }}"
                                                                    src="{{ asset('storage/' . $color['hover_image']) }}"
                                                                    alt="image-product">
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach

                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </section>
    <style>
        /* Đặt kiểu mặc định cho nút */
        /* Kiểu mặc định cho nút */
        .wishlist-btn {
            background-color: #fff;
            /* Nền trắng mặc định */
            border: none;

            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            border-radius: 50%;
            /* Tùy chỉnh để có thể làm nút tròn */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Hiệu ứng nổi nhẹ */
        }

        .wishlist-btn .icon {
            font-size: 1.5rem;
            color: #333;
            transition: color 0.3s ease;
        }


        .wishlist-btn:hover {
            background-color: #000;
        }

        .wishlist-btn:hover .icon {
            color: #fff;
        }
    </style>
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
