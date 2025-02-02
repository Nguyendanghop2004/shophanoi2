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
    <section class="flat-spacing-15 pb_0">
        <div class="container">
            <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                <span class="title">Sản Phẩm Yêu Thích</span>

            </div>

            @if (empty($products) || $products->isEmpty())
                <div class="no-products">
                    <p>Không có sản phẩm yêu thích nào.</p>
                </div>
            @else
                <div class="hover-sw-nav hover-sw-3">
                    <div class="swiper tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3" data-mobile="2"
                        data-space-lg="30" data-space-md="15" data-pagination="2" data-pagination-md="3"
                        data-pagination-lg="3">
                        <div class="swiper-wrapper">
                            @foreach ($products as $product)
                                <div class="swiper-slide" lazy="true">
                                    <div class="card-product">
                                        <div class="card-product-wrapper"style="height: 465px ; width: 332px;">
                                            <a href="{{ route('product-detail', $product['slug']) }}" class="product-img">
                                                <img class="lazyload img-product"
                                                    data-src="{{ asset('storage/' . $product['main_image_url']) }}"
                                                    src="{{ asset('storage/' . $product['main_image_url']) }}"
                                                    alt="image-product">
                                                <img class="lazyload img-hover"
                                                    data-src="{{ asset('storage/' . $product['hover_main_image_url']) }}"
                                                    src="{{ asset('storage/' . $product['hover_main_image_url']) }}"
                                                    alt="image-product">
                                            </a>
                                            <div class="list-product-btn">
                                            <div class="tf-product-btn-wishlist hover-tooltip box-icon bg_white wishlist btn-icon-action">
    @if(in_array($product['id'], $wishlist))
        <form action="{{ route('wishlist.remove') }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
            <button type="submit" class="wishlist-btn remove-wishlist">
                <span class="icon icon-delete"></span>
            </button>
        </form>
    @else
        <form action="{{ route('wishlist.add') }}" method="POST" style="display: inline;">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
            <button type="submit" class="wishlist-btn add-wishlist">
                <span class="icon icon-heart"></span>
            </button>
        </form>
    @endif
</div>
                                                <a href="#quick_view" data-bs-toggle="modal"
                                                    data-product-id="{{ $product['id'] }}"
                                                    class="box-icon bg_white quickview tf-btn-loading">
                                                    <span class="icon icon-bag"></span>
                                                    <span class="tooltip">Quick View</span>
                                                </a>
                                            </div>
                                            <div class="size-list">
                                                <span>{{ $product['distinct_size_count'] }} sizes available</span>
                                            </div>
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
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="nav-sw nav-next-slider nav-next-product box-icon w_46 round"><span
                            class="icon icon-arrow-left"></span></div>
                    <div class="nav-sw nav-prev-slider nav-prev-product box-icon w_46 round"><span
                            class="icon icon-arrow-right"></span></div>
                </div>
            @endif
        </div>
    </section>

  
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
