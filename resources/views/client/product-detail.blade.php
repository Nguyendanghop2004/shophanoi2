@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')

    <!-- breadcrumb -->
    <div class="tf-breadcrumb">
        <div class="container">
            <div class="tf-breadcrumb-wrap d-flex justify-content-between flex-wrap align-items-center">
                <div class="tf-breadcrumb-list">
                    <a href="{{ route('home') }}" class="text">Home</a>
                    <i class="icon icon-arrow-right"></i>
                    {{-- <a href="#" class="text">Women</a>
                    <i class="icon icon-arrow-right"></i> --}}
                    <span class="text">{{ $product->product_name }}</span>
                </div>
                <div class="tf-breadcrumb-prev-next">
                    <a href="#" class="tf-breadcrumb-prev hover-tooltip center">
                        <i class="icon icon-arrow-left"></i>
                        <!-- <span class="tooltip">Cotton jersey top</span> -->
                    </a>
                    <a href="#" class="tf-breadcrumb-back hover-tooltip center">
                        <i class="icon icon-shop"></i>
                        <!-- <span class="tooltip">Back to Women</span> -->
                    </a>
                    <a href="#" class="tf-breadcrumb-next hover-tooltip center">
                        <i class="icon icon-arrow-right"></i>
                        <!-- <span class="tooltip">Cotton jersey top</span> -->
                    </a>
                </div>
            </div>
        </div>
    </div>
    <style>
        
    </style>
    <!-- /breadcrumb -->
    <!-- default -->
    <section class="flat-spacing-4 pt_0">
        <div class="tf-main-product section-image-zoom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="tf-product-media-wrap sticky-top">
                            <div class="thumbs-slider">
                                <div class="swiper tf-product-media-thumbs other-image-zoom" data-direction="vertical">
                                    <div class="swiper-wrapper stagger-wrap">
                                        @foreach ($product->images as $image)
                                            <div class="swiper-slide stagger-item">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="{{ asset('storage/' . $image->image_url) }}"
                                                        src="{{ asset('storage/' . $image->image_url) }}" alt="img-compare" width="100px">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="swiper tf-product-media-main" id="gallery-swiper-started">
                                    <div class="swiper-wrapper">
                                        @foreach ($product->images as $image)
                                            <div class="swiper-slide">
                                                <a href="{{ asset('storage/' . $image->image_url) }}" target="_blank"
                                                    class="item" data-pswp-width="770px" data-pswp-height="1075px">
                                                    <img class="tf-image-zoom lazyload"
                                                        data-zoom="{{ asset('storage/' . $image->image_url) }}"
                                                        data-src="{{ asset('storage/' . $image->image_url) }}"
                                                        src="{{ asset('storage/' . $image->image_url) }}" alt="">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next button-style-arrow thumbs-next"></div>
                                    <div class="swiper-button-prev button-style-arrow thumbs-prev"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="tf-product-info-wrap position-relative">
                            <div class="tf-zoom-main"></div>
                            <div class="tf-product-info-list other-image-zoom">
                                <div class="tf-product-info-title">
                                    <h5>{{ $product->product_name }}</h5>
                                </div>
                                {{-- <div class="tf-product-info-badges">
                                    <div class="badges">Best seller</div>
                                    <div class="product-status-content">
                                        <i class="icon-lightning"></i>
                                        <p class="fw-6">Selling fast! 56 people have this in their carts.</p>
                                    </div>
                                </div> --}}
                                <div class="tf-product-info-price">
                                    {{-- <div class="price-on-sale">${{ $product->price }}</div>
                                    <div class="compare-at-price">$10.00</div> --}}
                                    @if ($product->sale_price < $product->price)
                                        <span class="sale-price">{{ number_format($product->sale_price, 0, ',', '.') }}
                                            VNĐ</span>
                                        <span class="original-price" style="text-decoration: line-through; color: #888;">
                                            {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                        </span>
                                    @else
                                        <span class="regular-price">{{ number_format($product->price, 0, ',', '.') }}
                                            VNĐ</span>
                                    @endif

                                    {{-- <div class="badges-on-sale"><span>20</span>% OFF</div> --}}
                                </div>
                                <div class="tf-product-description">
                                    <p>{{ $product->short_description }}</p>
                                </div>
                                {{-- <div class="tf-product-info-liveview">
                                    <div class="liveview-count">20</div>
                                    <p class="fw-6">People are viewing this right now</p>
                                </div> --}}
                                {{-- <div class="tf-product-info-countdown">
                                    <div class="countdown-wrap">
                                        <div class="countdown-title">
                                            <i class="icon-time tf-ani-tada"></i>
                                            <p>HURRY UP! SALE ENDS IN:</p>
                                        </div>
                                        <div class="tf-countdown style-1">
                                            <div class="js-countdown" data-timer="1007500"
                                                data-labels="Days :,Hours :,Mins :,Secs"></div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="tf-product-info-variant-picker">
                                    <div class="variant-picker-item">
                                        <div class="variant-picker-label">
                                            Màu sắc: <span class="fw-6 variant-picker-label-value selected-color">Không
                                                có</span>
                                        </div>
                                        <div class="variant-picker-values">

                                            @foreach ($product->colors as $color)
                                                <input id="values-{{ $color->name }}" type="radio" name="color-1"
                                                    class="btn-color" data-color-id="{{ $color->id }}"
                                                    data-color-name="{{ $color->name }}"
                                                    {{ $loop->first ? 'checked' : '' }}>
                                                <label
                                                    class="hover-tooltip
                                                radius-60"
                                                    for="values-{{ $color->name }}" data-value="{{ $color->name }}">
                                                    <span class="btn-checkbox"
                                                        style="background-color: {{ $color->sku_color }}"></span>
                                                    <span class="tooltip">{{ $color->name }}</span>
                                                </label>
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="variant-picker-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="variant-picker-label">
                                                Kích thước: <span
                                                    class="fw-6 variant-picker-label-value selected-size">Không có</span>
                                            </div>
                                            <a href="#find_size" data-bs-toggle="modal" class="find-size fw-6">Tìm Kiếm Kích Thước Dành Cho Bạn</a>
                                        </div>
                                        <div class="variant-picker-values" id="size-options-container">
                                            <!-- Các kích thước sẽ được thêm vào đây bằng JavaScript khi chọn màu -->
                                        </div>
                                    </div>
                                </div>
                                <div class="tf-product-info-quantity">
                                    <div class="quantity-title fw-6">Số lượng</div>
                                    <div class="wg-quantity">
                                        <span class="btn-quantity minus-btn-detail">-</span>
                                        <input type="text" name="quantity_product" value="1">
                                        <span class="btn-quantity plus-btn-detail">+</span>
                                    </div>
                                    
                                </div>
                                <div class="tf-product-info-buy-buttons">
                                    <a href="javascript:void(0);"
                                            class="tf-product-btn-wishlist hover-tooltip box-icon bg_white wishlist btn-icon-action">
                                            @if(in_array($product['id'], $wishlist))

                                                <form action="{{ route('wishlist.remove') }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                                    <button type="submit" style="background: none; border: none;">
                                                        <span class="icon icon-delete"></span>
                                                        <span class="tooltip">Remove from Wishlist</span>
                                                    </button>
                                                </form>
                                            @else

                                                <form action="{{ route('wishlist.add') }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                                    <button type="submit" style="background: none; border: none;">
                                                        <span class="icon icon-heart"></span>
                                                        <span class="tooltip">Add to Wishlist</span>
                                                    </button>
                                                </form>
                                            @endif
                                        </a>
                                        </div>
                                <div class="tf-product-info-buy-button">
                                    <form class="">
                                        <a href="javascript:void(0);"
                                            class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart"><span>Thêm
                                                vào giỏ -&nbsp;<span class="tf-qty-price"
                                                    data-price="{{ $product->price }}"
                                                    data-sale-price="{{ isset($product->sale_price) && $product->sale_price < $product->price ? $product->sale_price : $product->price }}">
                                                    {{ number_format(isset($product->sale_price) && $product->sale_price < $product->price ? $product->sale_price : $product->price, 0, ',', '.') }}
                                                    VNĐ
                                                </span>
                                        </a>
                                       
                                        {{-- <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="tf-product-btn-wishlist hover-tooltip box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a> --}}

                                    </form>
                                   
                                        
                                </div>
                                
                                {{-- <div class="tf-product-info-extra-link">
                                    <a href="#compare_color" data-bs-toggle="modal" class="tf-product-extra-icon">
                                        <div class="icon">
                                            <img src="images/item/compare.svg" alt="">
                                        </div>
                                        <div class="text fw-6">Compare color</div>
                                    </a>
                                    <a href="#ask_question" data-bs-toggle="modal" class="tf-product-extra-icon">
                                        <div class="icon">
                                            <i class="icon-question"></i>
                                        </div>
                                        <div class="text fw-6">Ask a question</div>
                                    </a>
                                    <a href="#delivery_return" data-bs-toggle="modal" class="tf-product-extra-icon">
                                        <div class="icon">
                                            <svg class="d-inline-block" xmlns="http://www.w3.org/2000/svg" width="22"
                                                height="18" viewBox="0 0 22 18" fill="currentColor">
                                                <path
                                                    d="M21.7872 10.4724C21.7872 9.73685 21.5432 9.00864 21.1002 8.4217L18.7221 5.27043C18.2421 4.63481 17.4804 4.25532 16.684 4.25532H14.9787V2.54885C14.9787 1.14111 13.8334 0 12.4255 0H9.95745V1.69779H12.4255C12.8948 1.69779 13.2766 2.07962 13.2766 2.54885V14.5957H8.15145C7.80021 13.6052 6.85421 12.8936 5.74468 12.8936C4.63515 12.8936 3.68915 13.6052 3.33792 14.5957H2.55319C2.08396 14.5957 1.70213 14.2139 1.70213 13.7447V2.54885C1.70213 2.07962 2.08396 1.69779 2.55319 1.69779H9.95745V0H2.55319C1.14528 0 0 1.14111 0 2.54885V13.7447C0 15.1526 1.14528 16.2979 2.55319 16.2979H3.33792C3.68915 17.2884 4.63515 18 5.74468 18C6.85421 18 7.80021 17.2884 8.15145 16.2979H13.423C13.7742 17.2884 14.7202 18 15.8297 18C16.9393 18 17.8853 17.2884 18.2365 16.2979H21.7872V10.4724ZM16.684 5.95745C16.9494 5.95745 17.2034 6.08396 17.3634 6.29574L19.5166 9.14894H14.9787V5.95745H16.684ZM5.74468 16.2979C5.27545 16.2979 4.89362 15.916 4.89362 15.4468C4.89362 14.9776 5.27545 14.5957 5.74468 14.5957C6.21392 14.5957 6.59575 14.9776 6.59575 15.4468C6.59575 15.916 6.21392 16.2979 5.74468 16.2979ZM15.8298 16.2979C15.3606 16.2979 14.9787 15.916 14.9787 15.4468C14.9787 14.9776 15.3606 14.5957 15.8298 14.5957C16.299 14.5957 16.6809 14.9776 16.6809 15.4468C16.6809 15.916 16.299 16.2979 15.8298 16.2979ZM18.2366 14.5957C17.8853 13.6052 16.9393 12.8936 15.8298 12.8936C15.5398 12.8935 15.252 12.943 14.9787 13.04V10.8511H20.0851V14.5957H18.2366Z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="text fw-6">Delivery & Return</div>
                                    </a>
                                    <a href="#share_social" data-bs-toggle="modal" class="tf-product-extra-icon">
                                        <div class="icon">
                                            <i class="icon-share"></i>
                                        </div>
                                        <div class="text fw-6">Share</div>
                                    </a>
                                </div> --}}
                                {{-- <div class="tf-product-info-delivery-return">
                                    <div class="row">
                                        <div class="col-xl-6 col-12">
                                            <div class="tf-product-delivery">
                                                <div class="icon">
                                                    <i class="icon-delivery-time"></i>
                                                </div>
                                                <p>Estimate delivery times: <span class="fw-7">12-26 days</span>
                                                    (International), <span class="fw-7">3-6 days</span> (United States).
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-12">
                                            <div class="tf-product-delivery mb-0">
                                                <div class="icon">
                                                    <i class="icon-return-order"></i>
                                                </div>
                                                <p>Return within <span class="fw-7">30 days</span> of purchase. Duties &
                                                    taxes are non-refundable.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tf-product-info-trust-seal">
                                    <div class="tf-product-trust-mess">
                                        <i class="icon-safe"></i>
                                        <p class="fw-6">Guarantee Safe <br> Checkout</p>
                                    </div>
                                    <div class="tf-payment">
                                        <img src="images/payments/visa.png" alt="">
                                        <img src="images/payments/img-1.png" alt="">
                                        <img src="images/payments/img-2.png" alt="">
                                        <img src="images/payments/img-3.png" alt="">
                                        <img src="images/payments/img-4.png" alt="">
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="tf-sticky-btn-atc">
            <div class="container">
                <div class="tf-height-observer w-100 d-flex align-items-center">
                    <div class="tf-sticky-atc-product d-flex align-items-center">
                        <div class="tf-sticky-atc-img">
                            <img class="lazyloaded" data-src="images/shop/products/p-d1.png" alt=""
                                src="images/shop/products/p-d1.png">
                        </div>
                        <div class="tf-sticky-atc-title fw-5 d-xl-block d-none">Cotton jersey top</div>
                    </div>
                    <div class="tf-sticky-atc-infos">
                        <form class="">
                            <div class="tf-sticky-atc-variant-price text-center">
                                <select class="tf-select">
                                    <option selected="selected">Beige / S - $8.00</option>
                                    <option>Beige / M - $8.00</option>
                                    <option>Beige / L - $8.00</option>
                                    <option>Beige / XL - $8.00</option>
                                    <option>Black / S - $8.00</option>
                                    <option>Black / M - $8.00</option>
                                    <option>Black / L - $8.00</option>
                                    <option>Black / XL - $8.00</option>
                                    <option>Blue / S - $8.00</option>
                                    <option>Blue / M - $8.00</option>
                                    <option>Blue / L - $8.00</option>
                                    <option>Blue / XL - $8.00</option>
                                    <option>White / S - $8.00</option>
                                    <option>White / M - $8.00</option>
                                    <option>White / L - $8.00</option>
                                    <option>White / XL - $8.00</option>
                                </select>
                            </div>
                            <div class="tf-sticky-atc-btns">
                                <div class="tf-product-info-quantity">
                                    <div class="wg-quantity">
                                        <span class="btn-quantity minus-btn">-</span>
                                        <input type="text" name="number" value="1">
                                        <span class="btn-quantity plus-btn">+</span>
                                    </div>
                                </div>
                                <a href="javascript:void(0);"
                                    class="tf-btn btn-fill radius-3 justify-content-center fw-6 fs-14 flex-grow-1 animate-hover-btn btn-add-to-cart"><span>Add
                                        to cart</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    </section>
    <!-- /default -->
    <!-- tabs -->
    <section class="flat-spacing-17 pt_0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="widget-tabs style-has-border">
                        <ul class="widget-menu-tab">
                            <li class="item-title active">
                                <span class="inner">Mô tả</span>
                            </li>
                            <li class="item-title">
                                <span class="inner">Xem màu và kích thước</span>
                            </li>
                            <li class="item-title">
                                <span class="inner">Review</span>
                            </li>
                        </ul>
                        <div class="widget-content-tab">
                            <!-- Mô tả -->
                            <div class="widget-content-inner active">
                            <div class="form-group pl-5 pr-5">
                                    {!! $product->description !!}
                                </div>
                            </div>
    
                            <!-- Màu và kích thước -->
                            <div class="widget-content-inner">
    <table class="tf-pr-attrs">
        <tbody>
            <tr class="tf-attr-pa-color">
                <th class="tf-attr-label">Color</th>
                <td class="tf-attr-value">
                    <p>
                        @foreach($colorNames as $color)
                            {{ $color }}@if(!$loop->last), @endif
                        @endforeach
                    </p>
                </td>
            </tr>
            <tr class="tf-attr-pa-size">
                <th class="tf-attr-label">Size</th>
                <td class="tf-attr-value">
                    <p>
                        @foreach($sizeNames as $size)
                            {{ $size }}@if(!$loop->last), @endif
                        @endforeach
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

    
                            <!-- Reviews -->
                            <div class="widget-content-inner">
                                <div class="tf-page-privacy-policy">
                                    <div class="reviews-list">
                                        @if($reviews->count() > 0)
                                            @foreach($reviews as $review)
                                                <div class="review-item d-flex gap-3 align-items-start mb-4">
                                                    <div class="review-user-avatar">
                                                        <img src="{{ $review->user->image ? Storage::url($review->user->image) : asset('images/default-avatar.png') }}" 
                                                             alt="{{ $review->user->name }}" 
                                                             class="rounded-circle" 
                                                             style="width: 50px; height: 50px;">
                                                    </div>
                                                    <div class="review-content">
                                                        <h5 class="review-user-name mb-1">{{ $review->user->name }}</h5>
                                                        <div class="review-rating mb-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                            @endfor
                                                            
                                                        </div>
                                                        <p class="review-comment mb-0">{{ $review->comment }}</p>
                                                        <span class="text-muted">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- /tabs -->
    {{-- <!-- product -->
    <section class="flat-spacing-1 pt_0">
        <div class="container">
            <div class="flat-title">
                <span class="title">Sản phẩm liên quan</span>
            </div>
            <div class="hover-sw-nav hover-sw-2">
                <div class="swiper tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3" data-mobile="2"
                    data-space-lg="30" data-space-md="15" data-pagination="2" data-pagination-md="3"
                    data-pagination-lg="3">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/orange-1.jpg"
                                            src="images/products/orange-1.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/white-1.jpg"
                                            src="images/products/white-1.jpg" alt="image-product">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                    <div class="size-list">
                                        <span>S</span>
                                        <span>M</span>
                                        <span>L</span>
                                        <span>XL</span>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title link">Ribbed Tank Top</a>
                                    <span class="price">$16.95</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">Orange</span>
                                            <span class="swatch-value bg_orange-3"></span>
                                            <img class="lazyload" data-src="images/products/orange-1.jpg"
                                                src="images/products/orange-1.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Black</span>
                                            <span class="swatch-value bg_dark"></span>
                                            <img class="lazyload" data-src="images/products/black-1.jpg"
                                                src="images/products/black-1.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload" data-src="images/products/white-1.jpg"
                                                src="images/products/white-1.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/brown.jpg"
                                            src="images/products/brown.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/purple.jpg"
                                            src="images/products/purple.jpg" alt="image-product">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                    <div class="size-list">
                                        <span>M</span>
                                        <span>L</span>
                                        <span>XL</span>
                                    </div>
                                    <div class="on-sale-wrap">
                                        <div class="on-sale-item">-33%</div>
                                    </div>
                                    <div class="countdown-box">
                                        <div class="js-countdown" data-timer="1007500" data-labels="d :,h :,m :,s"></div>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title link">Ribbed modal T-shirt</a>
                                    <span class="price">From $18.95</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">Brown</span>
                                            <span class="swatch-value bg_brown"></span>
                                            <img class="lazyload" data-src="images/products/brown.jpg"
                                                src="images/products/brown.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Light Purple</span>
                                            <span class="swatch-value bg_purple"></span>
                                            <img class="lazyload" data-src="images/products/purple.jpg"
                                                src="images/products/purple.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Light Green</span>
                                            <span class="swatch-value bg_light-green"></span>
                                            <img class="lazyload" data-src="images/products/green.jpg"
                                                src="images/products/green.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/white-3.jpg"
                                            src="images/products/white-3.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/white-4.jpg"
                                            src="images/products/white-4.jpg" alt="image-product">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="#shoppingCart" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Add to cart</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                    <div class="size-list">
                                        <span>S</span>
                                        <span>M</span>
                                        <span>L</span>
                                        <span>XL</span>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title link">Oversized Printed T-shirt</a>
                                    <span class="price">$10.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/white-2.jpg"
                                            src="images/products/white-2.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/pink-1.jpg"
                                            src="images/products/pink-1.jpg" alt="image-product">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                    <div class="size-list">
                                        <span>S</span>
                                        <span>M</span>
                                        <span>L</span>
                                        <span>XL</span>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title">Oversized Printed T-shirt</a>
                                    <span class="price">$16.95</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload" data-src="images/products/white-2.jpg"
                                                src="images/products/white-2.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Pink</span>
                                            <span class="swatch-value bg_purple"></span>
                                            <img class="lazyload" data-src="images/products/pink-1.jpg"
                                                src="images/products/pink-1.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Black</span>
                                            <span class="swatch-value bg_dark"></span>
                                            <img class="lazyload" data-src="images/products/black-2.jpg"
                                                src="images/products/black-2.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/brown-2.jpg"
                                            src="images/products/brown-2.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/brown-3.jpg"
                                            src="images/products/brown-3.jpg" alt="image-product">
                                    </a>
                                    <div class="size-list">
                                        <span>S</span>
                                        <span>M</span>
                                        <span>L</span>
                                        <span>XL</span>
                                    </div>
                                    <div class="list-product-btn">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title link">V-neck linen T-shirt</a>
                                    <span class="price">$114.95</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">Brown</span>
                                            <span class="swatch-value bg_brown"></span>
                                            <img class="lazyload" data-src="images/products/brown-2.jpg"
                                                src="images/products/brown-2.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload" data-src="images/products/white-5.jpg"
                                                src="images/products/white-5.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/light-green-1.jpg"
                                            src="images/products/light-green-1.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/light-green-2.jpg"
                                            src="images/products/light-green-2.jpg" alt="image-product">
                                    </a>
                                    <div class="list-product-btn absolute-2">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title link">Loose Fit Sweatshirt</a>
                                    <span class="price">$10.00</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">Light Green</span>
                                            <span class="swatch-value bg_light-green"></span>
                                            <img class="lazyload" data-src="images/products/light-green-1.jpg"
                                                src="images/products/light-green-1.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Black</span>
                                            <span class="swatch-value bg_dark"></span>
                                            <img class="lazyload" data-src="images/products/black-3.jpg"
                                                src="images/products/black-3.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Blue</span>
                                            <span class="swatch-value bg_blue-2"></span>
                                            <img class="lazyload" data-src="images/products/blue.jpg"
                                                src="images/products/blue.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Dark Blue</span>
                                            <span class="swatch-value bg_dark-blue"></span>
                                            <img class="lazyload" data-src="images/products/dark-blue.jpg"
                                                src="images/products/dark-blue.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload" data-src="images/products/white-6.jpg"
                                                src="images/products/white-6.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Light Grey</span>
                                            <span class="swatch-value bg_light-grey"></span>
                                            <img class="lazyload" data-src="images/products/light-grey.jpg"
                                                src="images/products/light-grey.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-sw nav-next-slider nav-next-product box-icon w_46 round"><span
                        class="icon icon-arrow-left"></span></div>
                <div class="nav-sw nav-prev-slider nav-prev-product box-icon w_46 round"><span
                        class="icon icon-arrow-right"></span></div>
                <div class="sw-dots style-2 sw-pagination-product justify-content-center"></div>
            </div>
        </div>
    </section>
    <!-- /product --> --}}
    {{-- <!-- recent -->
    <section class="flat-spacing-4 pt_0">
        <div class="container">
            <div class="flat-title">
                <span class="title">Recently Viewed</span>
            </div>
            <div class="hover-sw-nav hover-sw-2">
                <div class="swiper tf-sw-recent wrap-sw-over" data-preview="4" data-tablet="3" data-mobile="2"
                    data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1"
                    data-pagination-lg="1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/light-green-1.jpg"
                                            src="images/products/light-green-1.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/light-green-2.jpg"
                                            src="images/products/light-green-2.jpg" alt="image-product">
                                    </a>
                                    <div class="list-product-btn absolute-2">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title link">Loose Fit Sweatshirt</a>
                                    <span class="price">$10.00</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">Light Green</span>
                                            <span class="swatch-value bg_light-green"></span>
                                            <img class="lazyload" data-src="images/products/light-green-1.jpg"
                                                src="images/products/light-green-1.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Black</span>
                                            <span class="swatch-value bg_dark"></span>
                                            <img class="lazyload" data-src="images/products/black-3.jpg"
                                                src="images/products/black-3.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Blue</span>
                                            <span class="swatch-value bg_blue-2"></span>
                                            <img class="lazyload" data-src="images/products/blue.jpg"
                                                src="images/products/blue.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Dark Blue</span>
                                            <span class="swatch-value bg_dark-blue"></span>
                                            <img class="lazyload" data-src="images/products/dark-blue.jpg"
                                                src="images/products/dark-blue.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload" data-src="images/products/white-6.jpg"
                                                src="images/products/white-6.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Light Grey</span>
                                            <span class="swatch-value bg_light-grey"></span>
                                            <img class="lazyload" data-src="images/products/light-grey.jpg"
                                                src="images/products/light-grey.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/brown-2.jpg"
                                            src="images/products/brown-2.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/brown-3.jpg"
                                            src="images/products/brown-3.jpg" alt="image-product">
                                    </a>
                                    <div class="size-list">
                                        <span>S</span>
                                        <span>M</span>
                                        <span>L</span>
                                        <span>XL</span>
                                    </div>
                                    <div class="list-product-btn">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title link">V-neck linen T-shirt</a>
                                    <span class="price">$114.95</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">Brown</span>
                                            <span class="swatch-value bg_brown"></span>
                                            <img class="lazyload" data-src="images/products/brown-2.jpg"
                                                src="images/products/brown-2.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload" data-src="images/products/white-5.jpg"
                                                src="images/products/white-5.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/white-2.jpg"
                                            src="images/products/white-2.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/pink-1.jpg"
                                            src="images/products/pink-1.jpg" alt="image-product">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                    <div class="size-list">
                                        <span>S</span>
                                        <span>M</span>
                                        <span>L</span>
                                        <span>XL</span>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title">Oversized Printed T-shirt</a>
                                    <span class="price">$16.95</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload" data-src="images/products/white-2.jpg"
                                                src="images/products/white-2.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Pink</span>
                                            <span class="swatch-value bg_purple"></span>
                                            <img class="lazyload" data-src="images/products/pink-1.jpg"
                                                src="images/products/pink-1.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Black</span>
                                            <span class="swatch-value bg_dark"></span>
                                            <img class="lazyload" data-src="images/products/black-2.jpg"
                                                src="images/products/black-2.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/white-3.jpg"
                                            src="images/products/white-3.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/white-4.jpg"
                                            src="images/products/white-4.jpg" alt="image-product">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="#shoppingCart" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Add to cart</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                    <div class="size-list">
                                        <span>S</span>
                                        <span>M</span>
                                        <span>L</span>
                                        <span>XL</span>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title link">Oversized Printed T-shirt</a>
                                    <span class="price">$10.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/brown.jpg"
                                            src="images/products/brown.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/purple.jpg"
                                            src="images/products/purple.jpg" alt="image-product">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                    <div class="size-list">
                                        <span>M</span>
                                        <span>L</span>
                                        <span>XL</span>
                                    </div>
                                    <div class="on-sale-wrap">
                                        <div class="on-sale-item">-33%</div>
                                    </div>
                                    <div class="countdown-box">
                                        <div class="js-countdown" data-timer="1007500" data-labels="d :,h :,m :,s">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title link">Ribbed modal T-shirt</a>
                                    <span class="price">From $18.95</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">Brown</span>
                                            <span class="swatch-value bg_brown"></span>
                                            <img class="lazyload" data-src="images/products/brown.jpg"
                                                src="images/products/brown.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Light Purple</span>
                                            <span class="swatch-value bg_purple"></span>
                                            <img class="lazyload" data-src="images/products/purple.jpg"
                                                src="images/products/purple.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Light Green</span>
                                            <span class="swatch-value bg_light-green"></span>
                                            <img class="lazyload" data-src="images/products/green.jpg"
                                                src="images/products/green.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product" data-src="images/products/orange-1.jpg"
                                            src="images/products/orange-1.jpg" alt="image-product">
                                        <img class="lazyload img-hover" data-src="images/products/white-1.jpg"
                                            src="images/products/white-1.jpg" alt="image-product">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="#quick_add" data-bs-toggle="modal"
                                            class="box-icon bg_white quick-add tf-btn-loading">
                                            <span class="icon icon-bag"></span>
                                            <span class="tooltip">Quick Add</span>
                                        </a>
                                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                            <span class="icon icon-delete"></span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                            class="box-icon bg_white compare btn-icon-action">
                                            <span class="icon icon-compare"></span>
                                            <span class="tooltip">Add to Compare</span>
                                            <span class="icon icon-check"></span>
                                        </a>
                                        <a href="#quick_view" data-bs-toggle="modal"
                                            class="box-icon bg_white quickview tf-btn-loading">
                                            <span class="icon icon-view"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>
                                    <div class="size-list">
                                        <span>S</span>
                                        <span>M</span>
                                        <span>L</span>
                                        <span>XL</span>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title link">Ribbed Tank Top</a>
                                    <span class="price">$16.95</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">Orange</span>
                                            <span class="swatch-value bg_orange-3"></span>
                                            <img class="lazyload" data-src="images/products/orange-1.jpg"
                                                src="images/products/orange-1.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Black</span>
                                            <span class="swatch-value bg_dark"></span>
                                            <img class="lazyload" data-src="images/products/black-1.jpg"
                                                src="images/products/black-1.jpg" alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload" data-src="images/products/white-1.jpg"
                                                src="images/products/white-1.jpg" alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-sw nav-next-slider nav-next-recent box-icon w_46 round"><span
                        class="icon icon-arrow-left"></span></div>
                <div class="nav-sw nav-prev-slider nav-prev-recent box-icon w_46 round"><span
                        class="icon icon-arrow-right"></span></div>
                <div class="sw-dots style-2 sw-pagination-recent justify-content-center"></div>
            </div>
        </div>
    </section>
    <!-- /recent --> --}}
@endsection
<style>
    .review-rating .bi-star-fill {
    color: #FFD700; 
}

.review-rating .bi-star {
    color: #ccc; 
}
</style>
@section('product-detail')
    <!-- modal compare_color -->
    <div class="modal fade modalDemo tf-product-modal modal-part-content" id="compare_color">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Compare color</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="tf-compare-color-wrapp">
                    <div class="tf-compare-color-grid">

                        <input type="checkbox" class="sr-only" id="remove-compare-color-beige-1">
                        <div class="tf-compare-color-item">
                            <div class="tf-compare-color-top">
                                <label for="remove-compare-color-beige-1" class="tf-compare-color-remove">Remove</label>
                                <img class="lazyload" data-src="images/shop/products/hmgoepprod2.jpg"
                                    src="images/shop/products/hmgoepprod2.jpg" alt="img-compare">
                            </div>
                            <div class="tf-compare-color-bottom">
                                <div class="tf-compare-color-color">
                                    <span class="tf-color-list-color bg-color-beige"></span>
                                    <span>Beige</span>
                                </div>
                                <form class="">
                                    <select class="tf-select" name="id">
                                        <option value="46633906045232" selected="">S - $8.00</option>
                                        <option value="47256262738224">M - $8.00</option>
                                        <option value="47256262770992">L - $8.00</option>
                                        <option value="47256262803760">XL - $8.00</option>
                                    </select>
                                    <a href="javascript:void(0);"
                                        class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn btn-add-to-cart"><span>Add
                                            to cart</span></a>
                                </form>
                            </div>
                        </div>

                        <input type="checkbox" class="sr-only" id="remove-compare-color-beige-2">
                        <div class="tf-compare-color-item">
                            <div class="tf-compare-color-top">
                                <label for="remove-compare-color-beige-2" class="tf-compare-color-remove">Remove</label>
                                <img class="lazyload" data-src="images/shop/products/hmgoepprod12.jpg"
                                    src="images/shop/products/hmgoepprod12.jpg" alt="">
                            </div>
                            <div class="tf-compare-color-bottom">
                                <div class="tf-compare-color-color">
                                    <span class="tf-color-list-color bg-color-blue"></span>
                                    <span>Blue</span>
                                </div>
                                <form class="">
                                    <select class="tf-select" name="id">
                                        <option value="46633906045232" selected="">S - $8.00</option>
                                        <option value="47256262738224">M - $8.00</option>
                                        <option value="47256262770992">L - $8.00</option>
                                        <option value="47256262803760">XL - $8.00</option>
                                    </select>
                                    <a href="javascript:void(0);"
                                        class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn btn-add-to-cart"><span>Add
                                            to cart</span></a>
                                </form>
                            </div>
                        </div>

                        <input type="checkbox" class="sr-only" id="remove-compare-color-beige-3">
                        <div class="tf-compare-color-item">
                            <div class="tf-compare-color-top">
                                <label for="remove-compare-color-beige-3" class="tf-compare-color-remove">Remove</label>
                                <img class="lazyload" data-src="images/shop/products/hmgoepprod7.jpg"
                                    src="images/shop/products/hmgoepprod7.jpg" alt="">
                            </div>
                            <div class="tf-compare-color-bottom">
                                <div class="tf-compare-color-color">
                                    <span class="tf-color-list-color bg-color-black"></span>
                                    <span>Black</span>
                                </div>
                                <form class="">
                                    <select class="tf-select" name="id">
                                        <option value="46633906045232" selected="">S - $8.00</option>
                                        <option value="47256262738224">M - $8.00</option>
                                        <option value="47256262770992">L - $8.00</option>
                                        <option value="47256262803760">XL - $8.00</option>
                                    </select>
                                    <a href="javascript:void(0);"
                                        class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn btn-add-to-cart"><span>Add
                                            to cart</span></a>
                                </form>
                            </div>
                        </div>

                        <input type="checkbox" class="sr-only" id="remove-compare-color-beige-4">
                        <div class="tf-compare-color-item">
                            <div class="tf-compare-color-top">
                                <label for="remove-compare-color-beige-4" class="tf-compare-color-remove">Remove</label>
                                <img class="lazyload" data-src="images/shop/products/hmgoepprod14.jpg"
                                    src="images/shop/products/hmgoepprod14.jpg" alt="">
                            </div>
                            <div class="tf-compare-color-bottom">
                                <div class="tf-compare-color-color">
                                    <span class="tf-color-list-color bg-color-white"></span>
                                    <span>White</span>
                                </div>
                                <form class="">
                                    <select class="tf-select" name="id">
                                        <option value="46633906045232" selected="">S - $8.00</option>
                                        <option value="47256262738224">M - $8.00</option>
                                        <option value="47256262770992">L - $8.00</option>
                                        <option value="47256262803760">XL - $8.00</option>
                                    </select>
                                    <a href="javascript:void(0);"
                                        class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn btn-add-to-cart"><span>Add
                                            to cart</span></a>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal compare_color -->

    <!-- modal ask_question -->
    <div class="modal modalCentered fade modalDemo tf-product-modal modal-part-content" id="ask_question">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Ask a question</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="overflow-y-auto">
                    <form class="">
                        <fieldset class="">
                            <label for="">Name *</label>
                            <input type="text" placeholder="" class="" name="text" tabindex="2"
                                value="" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="">
                            <label for="">Email *</label>
                            <input type="email" placeholder="" class="" name="text" tabindex="2"
                                value="" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="">
                            <label for="">Phone number</label>
                            <input type="number" placeholder="" class="" name="text" tabindex="2"
                                value="" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="">
                            <label for="">Message</label>
                            <textarea name="message" rows="4" placeholder="" class="" tabindex="2" aria-required="true"
                                required=""></textarea>
                        </fieldset>
                        <button type="submit"
                            class="tf-btn w-100 btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn"><span>Send</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal ask_question -->

    <!-- modal delivery_return -->
    <div class="modal modalCentered fade modalDemo tf-product-modal modal-part-content" id="delivery_return">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Shipping & Delivery</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="overflow-y-auto">
                    <div class="tf-product-popup-delivery">
                        <div class="title">Delivery</div>
                        <p class="text-paragraph">All orders shipped with UPS Express.</p>
                        <p class="text-paragraph">Always free shipping for orders over US $250.</p>
                        <p class="text-paragraph">All orders are shipped with a UPS tracking number.</p>
                    </div>
                    <div class="tf-product-popup-delivery">
                        <div class="title">Returns</div>
                        <p class="text-paragraph">Items returned within 14 days of their original shipment date in same
                            as new condition will be eligible for a full refund or store credit.</p>
                        <p class="text-paragraph">Refunds will be charged back to the original form of payment used for
                            purchase.</p>
                        <p class="text-paragraph">Customer is responsible for shipping charges when making returns and
                            shipping/handling fees of original purchase is non-refundable.</p>
                        <p class="text-paragraph">All sale items are final purchases.</p>
                    </div>
                    <div class="tf-product-popup-delivery">
                        <div class="title">Help</div>
                        <p class="text-paragraph">Give us a shout if you have any other questions and/or concerns.</p>
                        <p class="text-paragraph">Email: <a href="mailto:contact@domain.com"
                                aria-describedby="a11y-external-message"><span
                                    class="__cf_email__">contact@domain.com</span></a></p>
                        <p class="text-paragraph mb-0">Phone: +1 (23) 456 789</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal delivery_return -->
    <!-- modal share social -->
    <div class="modal modalCentered fade modalDemo tf-product-modal modal-part-content" id="share_social">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <div class="demo-title">Share</div>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="overflow-y-auto">
                    <ul class="tf-social-icon d-flex gap-10">
                        <li><a href="#" class="box-icon social-facebook bg_line"><i
                                    class="icon icon-fb"></i></a></li>
                        <li><a href="#" class="box-icon social-twiter bg_line"><i
                                    class="icon icon-Icon-x"></i></a></li>
                        <li><a href="#" class="box-icon social-instagram bg_line"><i
                                    class="icon icon-instagram"></i></a></li>
                        <li><a href="#" class="box-icon social-tiktok bg_line"><i
                                    class="icon icon-tiktok"></i></a></li>
                        <li><a href="#" class="box-icon social-pinterest bg_line"><i
                                    class="icon icon-pinterest-1"></i></a></li>
                    </ul>
                    <form class="form-share" method="post" accept-charset="utf-8">
                        <fieldset>
                            <input type="text" value="https://themesflat.co/html/ecomus/" tabindex="0"
                                aria-required="true">
                        </fieldset>
                        <div class="button-submit">
                            <button class="tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn"
                                type="button">Copy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal share social -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-color').click(function() {
                let colorName = $(this).data('color-name');
                let selectedColorId = $(this).data('color-id');

                // Cập nhật màu sắc đã chọn
                $('.selected-color').text(colorName);

                updateSizeOptions(selectedColorId);

                $('.btn-size').click(function() {
                    var sizeName = $(this).data('size-name');
                    var sizePrice = $(this).data('size-price');

                    $('.selected-size').text(`${sizeName} + ${formatPrice(sizePrice)}`);
                    updateTotalPrice();
                });
            });

            // Mặc định màu sắc và ảnh khi tải trang
            var defaultColorId = $('.btn-color:checked').data('color-id');
            $('.selected-color').text($('.btn-color:checked').data('color-name'));
            updateSizeOptions(defaultColorId);
            updateTotalPrice();





            // Thêm vào giỏ hàng
            $('.btn-add-to-cart').click(function(e) {
                e.preventDefault();

                var productId = {{ $product->id }};
                var colorId = $('.btn-color:checked').data('color-id');
                var sizeId = $('input[name="size"]:checked').data('size-id');
                var quantity = $('input[name="quantity_product"]').val();

                if (!sizeId) {
                    toastr.warning('Vui lòng chọn kích thước trước khi thêm giỏ', 'Lưu ý ');
                    return;
                }
                if (!colorId) {
                    toastr.warning('Vui lòng chọn kích thước trước khi thêm giỏ', 'Lưu ý ');
                    return;
                }
                var stock = getStockQuantity(colorId, sizeId); // Lấy số lượng tồn kho từ hàm
                if (quantity > stock) {
                    toastr.warning(`Hiện tại sản phẩm chỉ còn ${stock} chiếc trong kho.`, 'Lưu ý');
                    return;
                }

                $.ajax({
                    url: '/add-to-cart',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        color_id: colorId,
                        size_id: sizeId,
                        quantity: quantity,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success === true) {
                            // Nếu thành công, hiển thị modal giỏ hàng
                            $("#shoppingCart").modal("show");
                        } else {
                            toastr.error(response.message, 'Cảnh báo');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Thêm giỏ hàng thất bại!', 'Cảnh báo');
                        // console.error('Lỗi Ajax:', error);
                        // console.log(xhr.responseText);
                    }
                });
            });



            // Hàm lấy tồn kho (đã có trong code trước đó)
            function getStockQuantity(colorId, sizeId) {
                let stockQuantity = 0; // Mặc định là 0 nếu không tìm thấy
                var colorSizes = @json($colorSizes);
                if (colorSizes[colorId]) {
                    colorSizes[colorId].forEach(function(variant) {
                        if (variant.size.id === sizeId) {
                            stockQuantity = variant.stock_quantity;
                        }
                    });
                }

                return stockQuantity;
            }

            // Cập nhật giá trị tổng tiền
            function updateTotalPrice() {
                // Lấy số lượng sản phẩm
                let quantity = parseInt($('input[name="quantity_product"]').val()) || 1;

                // Lấy giá gốc và giá giảm
                let productPrice = parseFloat($('.tf-qty-price').data('price')) || 0; // Giá gốc
                let salePrice = parseFloat($('.tf-qty-price').data('sale-price')) ||
                    productPrice; // Giá giảm (nếu có)

                // Lấy giá cộng thêm từ kích thước (nếu có)
                let sizePrice = parseFloat($('input.btn-size:checked').data('size-price')) || 0;

                // Tính giá tổng
                let finalPrice = salePrice + sizePrice; // Giá cuối cùng cho 1 sản phẩm
                let totalPrice = finalPrice * quantity; // Tổng tiền

                // Cập nhật vào giao diện
                $('.tf-qty-price').text(Math.floor(totalPrice).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' VNĐ');

            }


            // sự kiện tăng giảm số lượng
            var btnQuantity = function() {
                const validateValue = ($input) => {
                    let value = parseInt($input.val(), 10);
                    // Kiểm tra nếu giá trị không hợp lệ hoặc nhỏ hơn 1
                    if (isNaN(value) || value < 1) {
                        value = 1; // Đặt giá trị mặc định
                    }
                    $input.val(value); // Cập nhật lại giá trị hợp lệ
                    return value;
                };

                $(".minus-btn-detail").on("click", function(e) {
                    e.preventDefault();
                    var $this = $(this);
                    var $input = $this.closest("div").find("input");
                    var value = validateValue($input);

                    if (value > 1) {
                        $input.val(value - 1);
                    }

                    updateTotalPrice();
                });

                $(".plus-btn-detail").on("click", function(e) {
                    e.preventDefault();
                    var $this = $(this);
                    var $input = $this.closest("div").find("input");
                    var value = validateValue($input);

                    $input.val(value + 1);

                    updateTotalPrice();
                });

                // Xử lý sự kiện khi người dùng nhập trực tiếp vào input
                $("input[name='quantity_product']").on("input", function() {
                    validateValue($(this));
                    updateTotalPrice();
                });

                // Đảm bảo giá trị hợp lệ khi rời khỏi ô input
                $("input[name='quantity_product']").on("blur", function() {
                    validateValue($(this));
                    updateTotalPrice();
                });
            };

            btnQuantity();
            // Cập nhật kích thước cho màu đã chọn
            function updateSizeOptions(colorId) {
                var sizeOptions = @json($colorSizes);
                var sizes = sizeOptions[colorId] || [];

                var sizeContainer = $('#size-options-container');
                sizeContainer.empty();

                sizes.forEach(function(sizeInfo, index) {
                    if (index === 0) {
                        $('.selected-size').text(`${sizeInfo.size.name} + ${formatPrice(sizeInfo.price)}`);
                    }

                    var sizeElement = `
                <input type="radio" class="btn-size" name="size" id="values-${sizeInfo.size.name}-${colorId}"
                    data-size-name="${sizeInfo.size.name}" data-size-id="${sizeInfo.size.id}"
                    data-size-price="${sizeInfo.price}" ${index === 0 ? 'checked' : ''}>
                <label class="style-text" for="values-${sizeInfo.size.name}-${colorId}" data-value="${sizeInfo.size.name}">
                    <p>${sizeInfo.size.name}</p>
                </label>
            `;
                    sizeContainer.append(sizeElement);
                });
                updateTotalPrice();
            }
            // Hàm định dạng giá tiền
            function formatPrice(price) {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND',
                }).format(price);
            }
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
@endpush
