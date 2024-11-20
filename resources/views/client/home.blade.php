@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')


    <!-- categories -->
    <section class="flat-spacing-20">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tf-categories-wrap">
                        <div class="tf-categories-container">
                            <div class="collection-item-circle hover-img">
                                <a href="shop-collection-sub.html" class="collection-image img-style">
                                    <img class="lazyload"
                                        data-src="{{ asset('client/assets/images/collections/collection-circle-8.jpg') }}"
                                        src="{{ asset('client/assets/images/collections/collection-circle-8.jpg') }}"
                                        alt="collection-img">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-collection-sub.html" class="link title fw-6">New Arrivals</a>
                                </div>
                            </div>
                            {{-- @dd(Auth::user()->name) --}}
                            <div class="collection-item-circle hover-img">
                                <a href="shop-collection-sub.html" class="collection-image img-style">
                                    <img class="lazyload"
                                        data-src="{{ asset('client/assets/images/collections/collection-circle-9.jpg') }}"
                                        src="{{ asset('client/assets/images/collections/collection-circle-9.jpg') }}"
                                        alt="collection-img">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-collection-sub.html" class="link title fw-6">Best Sellers</a>
                                </div>
                            </div>
                            <div class="collection-item-circle hover-img">
                                <a href="shop-collection-sub.html" class="collection-image img-style">
                                    <img class="lazyload"
                                        data-src="{{ asset('client/assets/images/collections/collection-circle-10.jpg') }}"
                                        src="{{ asset('client/assets/images/collections/collection-circle-10.jpg') }}"
                                        alt="collection-img">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-collection-sub.html" class="link title fw-6">Top Rated</a>
                                </div>
                            </div>
                            <div class="collection-item-circle hover-img">
                                <a href="shop-collection-sub.html" class="collection-image img-style">
                                    <img class="lazyload"
                                        data-src="{{ asset('client/assets/images/collections/collection-circle-11.jpg') }}"
                                        src="{{ asset('client/assets/images/collections/collection-circle-11.jpg') }}"
                                        alt="collection-img">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-collection-sub.html" class="link title fw-6">Brands We Love</a>
                                </div>
                            </div>
                            <div class="collection-item-circle hover-img">
                                <a href="shop-collection-sub.html" class="collection-image img-style">
                                    <img class="lazyload"
                                        data-src="{{ asset('client/assets/images/collections/collection-circle-12.jpg') }}"
                                        src="{{ asset('client/assets/images/collections/collection-circle-12.jpg') }}"
                                        alt="collection-img">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-collection-sub.html" class="link title fw-6">Trending</a>
                                </div>
                            </div>
                            <div class="collection-item-circle hover-img">
                                <a href="shop-collection-sub.html" class="collection-image img-style">
                                    <img class="lazyload"
                                        data-src="{{ asset('client/assets/images/collections/collection-circle-13.jpg') }}"
                                        src="{{ asset('client/assets/images/collections/collection-circle-13.jpg') }}"
                                        alt="collection-img">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-collection-sub.html" class="link title fw-6">The Re-Imagined</a>
                                </div>
                            </div>
                            <div class="collection-item-circle hover-img">
                                <div class="has-saleoff-wrap position-relative">
                                    <a href="shop-collection-sub.html" class="collection-image img-style">
                                        <img class="lazyload"
                                            data-src="{{ asset('client/assets/images/collections/sale.jpg') }}"
                                            src="{{ asset('client/assets/images/collections/sale.jpg') }}"
                                            alt="collection-img">
                                    </a>
                                    <div class="sale-off fw-5">30% off</div>
                                </div>
                                <div class="collection-content text-center">
                                    <a href="shop-collection-sub.html" class="link title fw-6">Sale</a>
                                </div>
                            </div>
                        </div>
                        <div class="tf-shopall-wrap">
                            <div class="collection-item-circle tf-shopall">
                                <a href="shop-collection-sub.html" class="collection-image img-style tf-shopall-icon">
                                    <i class="icon icon-arrow1-top-left"></i>
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-collection-sub.html" class="link title fw-6">Shop all</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /categories -->
    {{--
    <!-- slider -->
    <div class="tf-slideshow slider-women slider-effect-fade position-relative">
        <div class="swiper tf-sw-slideshow" data-preview="1" data-tablet="1" data-mobile="1" data-centered="false"
            data-space="0" data-loop="true" data-auto-play="false" data-delay="2000" data-speed="1000">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    <div class="swiper-slide" lazy="true">
                        <div class="wrap-slider">
                            <img class="lazyload" data-src="{{ asset('storage/' . $slider->image_path) }}"
                                src="{{ asset('storage/' . $slider->image_path) }}" alt="women-slideshow-01">
                            <div class="box-content">
                                <div class="container">
                                    <h1 class="fade-item fade-item-1">{{ $slider->title }}</h1>
                                    <p class="fade-item fade-item-2">{{ $slider->short_description }}</p>
                                    @if ($slider->link_url !== null)
                                        <a href="{{ $slider->link_url }}"
                                            class="fade-item fade-item-3 tf-btn btn-fill animate-hover-btn btn-xl radius-60"><span>Đi
                                                đến cửa hàng</span><i class="icon icon-arrow-right"></i></a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
        <div class="wrap-pagination">
            <div class="container">
                <div class="sw-dots sw-pagination-slider justify-content-center"></div>
            </div>
        </div>
    </div>
    <!-- /slider --> --}}

    {{-- <!-- Categories -->
    <section class="flat-spacing-5 pb_0">
        <div class="container">
            <div class="flat-title">
                <span class="title wow fadeInUp" data-wow-delay="0s">Categories you might like</span>
            </div>
            <div class="hover-sw-nav">
       
                <div class="swiper tf-sw-collection" data-preview="4" data-tablet="2" data-mobile="2"
                    data-space-lg="30" data-space-md="30" data-space="15" data-loop="false" data-auto-play="false">
                    <div class="swiper-wrapper">
                    @foreach($categories as $category)
                        <div class="swiper-slide" lazy="true">
                     
                            <div class="collection-item style-2 hover-img" >
                                <div class="collection-inner">
                                    <a href="" class="0"> 
                                        <img class="lazyload"
                                            data-src="{{ asset('client/assets/images/collections/collection-42.jpg') }}"
                                            src="{{ asset('client/assets/images/collections/collection-42.jpg') }}"
                                            alt="collection-img">
                                    </a>
                                    <div class="collection-content">
                                        <a href=""
                                            class="tf-btn collection-title hover-icon fs-15 rounded-full"><span>{{$category->name}}</span><i
                                                class="icon icon-arrow1-top-left"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>          
                       
                        
                       
                       
                        @endforeach
                    </div>
                    
                </div>
                <div class="nav-sw nav-next-slider nav-next-collection box-icon w_46 round"><span
                        class="icon icon-arrow-left"></span></div>
                <div class="nav-sw nav-prev-slider nav-prev-collection box-icon w_46 round"><span
                        class="icon icon-arrow-right"></span></div>
                <div class="sw-dots style-2 sw-pagination-collection justify-content-center"></div>
            </div>
        </div>
    </section>
    <!-- /Categories --> --}}
    {{-- <!-- Banner Collection -->
    <section class="flat-spacing-10 pb_0">
        <div class="container">
            <div class="swiper tf-sw-recent" data-preview="2" data-tablet="2" data-mobile="1.3" data-space-lg="30"
                data-space-md="15" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" lazy="true">
                        <div class="collection-item-v4 hover-img">
                            <div class="collection-inner">
                                <a href="shop-collection-sub.html" class="collection-image img-style radius-10">
                                    <img class="lazyload"
                                        data-src="{{ asset('client/assets/images/collections/collection-47.jpg') }}"
                                        src="{{ asset('client/assets/images/collections/collection-47.jpg') }}"
                                        alt="collection-img">
                                </a>
                                <div class="collection-content wow fadeInUp" data-wow-delay="0s">
                                    <h5 class="heading text_white">The January Collection</h5>
                                    <a href="shop-collection-sub.html"
                                        class="tf-btn style-3 fw-6 btn-light-icon rounded-full animate-hover-btn"><span>Shop
                                            now</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide" lazy="true">
                        <div class="collection-item-v4 hover-img">
                            <div class="collection-inner">
                                <a href="shop-collection-sub.html" class="collection-image img-style radius-10">
                                    <img class="lazyload"
                                        data-src="{{ asset('client/assets/images/collections/collection-48.jpg') }}"
                                        src="{{ asset('client/assets/images/collections/collection-48.jpg') }}"
                                        alt="collection-img">
                                </a>
                                <div class="collection-content wow fadeInUp" data-wow-delay="0s">
                                    <h5 class="heading text_white">Olympia's picks</h5>
                                    <a href="shop-collection-sub.html"
                                        class="tf-btn style-3 fw-6 btn-light-icon rounded-full animate-hover-btn"><span>Shop
                                            now</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Banner Collection --> --}}

    <!-- Best seller -->
    <section class="flat-spacing-15 pb_0">
        <div class="container">
            <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                <span class="title">Ecomus’s Favorites</span>
                <p class="sub-title">Beautifully Functional. Purposefully Designed. Consciously Crafted.</p>
            </div>
            <div class="hover-sw-nav hover-sw-3">
                <div class="swiper tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3" data-mobile="2"
                    data-space-lg="30" data-space-md="15" data-pagination="2" data-pagination-md="3"
                    data-pagination-lg="3">
                    <div class="swiper-wrapper">
                        @foreach ($products as $product)
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="" class="product-img">
                                        <!-- Ảnh chính của sản phẩm -->
                                        <img class="lazyload img-product"
                                            data-src="{{ asset('storage/' . $product->main_image_url) }}"
                                            src="{{ asset('storage/' . $product->main_image_url) }}"
                                            alt="{{ $product->product_name }}">

                                            <!-- Ảnh hover, có thể lấy ảnh khác từ bảng images nếu có nhiều ảnh -->
                                            @php
                                                $hoverImage = $product->images->first(); // Giả sử bạn có quan hệ images trong model
                                            @endphp
                                            @if ($hoverImage)
                                                <img class="lazyload img-hover"
                                                    data-src="{{ asset('storage/' . $hoverImage->image_url) }}"
                                                    src="{{ asset('storage/' . $hoverImage->image_url) }}"
                                                    alt="{{ $product->product_name }}">
                                            @endif
                                        </a>

                                        <div class="list-product-btn">
                                            <a href="#quick_add" data-bs-toggle="modal" data-product-id="{{ $product->id }}"
                                                class="box-icon bg_white quick-add tf-btn-loading">
                                                <span class="icon icon-bag"></span>
                                                <span class="tooltip">Quick Add</span>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="box-icon bg_white wishlist btn-icon-action">
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
                                            <span>{{ $product->variants->count() }} sizes available</span>
                                        </div>
                                    </div>

                                    <div class="card-product-info">
                                        <a href="" class="title link">{{ $product->product_name }}</a>
                                        <span class="price">${{ number_format($product->price, 2) }}</span>

                                        <!-- Hiển thị màu sắc -->
                                        <ul class="list-color-product">
                                            @foreach ($product->colors as $color)
                                                <li
                                                    class="list-color-item color-swatch {{ $loop->first ? 'active' : '' }}">
                                                    <span class="tooltip">{{ $color->name }}</span>
                                                    <span class="swatch-value"
                                                        style="background-color: {{ $color->sku_color }}"></span>

                                                    @php
                                                        // Tìm ảnh của màu tương ứng
                                                        $colorImage = $product->images->firstWhere(
                                                            'color_id',
                                                            $color->id,
                                                        );
                                                    @endphp
                                                    @if ($colorImage)
                                                        <img class="lazyload"
                                                            data-src="{{ asset('storage/' . $colorImage->image_url) }}"
                                                            src="{{ asset('storage/' . $colorImage->image_url) }}"
                                                            alt="{{ $color->name }}">
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach



                        {{-- <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product"
                                            data-src="{{ asset('client/assets/images/products/brown.jpg') }}"
                                            src="{{ asset('client/assets/images/products/brown.jpg') }}"
                                            alt="image-product">
                                        <img class="lazyload img-hover"
                                            data-src="{{ asset('client/assets/images/products/purple.jpg') }}"
                                            src="{{ asset('client/assets/images/products/purple.jpg') }}"
                                            alt="image-product">
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
                                        <span>4 sizes available</span>
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
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/brown.jpg') }}"
                                                src="{{ asset('client/assets/images/products/brown.jpg') }}"
                                                alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Light Purple</span>
                                            <span class="swatch-value bg_purple"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/purple.jpg') }}"
                                                src="{{ asset('client/assets/images/products/purple.jpg') }}"
                                                alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Light Green</span>
                                            <span class="swatch-value bg_light-green"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/green.jpg') }}"
                                                src="{{ asset('client/assets/images/products/green.jpg') }}"
                                                alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product"
                                            data-src="{{ asset('client/assets/images/products/white-3.jpg') }}"
                                            src="{{ asset('client/assets/images/products/white-3.jpg') }}"
                                            alt="image-product">
                                        <img class="lazyload img-hover"
                                            data-src="{{ asset('client/assets/images/products/white-4.jpg') }}"
                                            src="{{ asset('client/assets/images/products/white-4.jpg') }}"
                                            alt="image-product">
                                    </a>
                                    <div class="list-product-btn absolute-2">
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
                                        <img class="lazyload img-product"
                                            data-src="{{ asset('client/assets/images/products/white-2.jpg') }}"
                                            src="{{ asset('client/assets/images/products/white-2.jpg') }}"
                                            alt="image-product">
                                        <img class="lazyload img-hover"
                                            data-src="{{ asset('client/assets/images/products/pink-1.jpg') }}"
                                            src="{{ asset('client/assets/images/products/pink-1.jpg') }}"
                                            alt="image-product">
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
                                        <span>4 sizes available</span>
                                    </div>
                                </div>
                                <div class="card-product-info">
                                    <a href="product-detail.html" class="title">Oversized Printed T-shirt</a>
                                    <span class="price">$16.95</span>
                                    <ul class="list-color-product">
                                        <li class="list-color-item color-swatch active">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/white-2.jpg') }}"
                                                src="{{ asset('client/assets/images/products/white-2.jpg') }}"
                                                alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Pink</span>
                                            <span class="swatch-value bg_purple"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/pink-1.jpg') }}"
                                                src="{{ asset('client/assets/images/products/pink-1.jpg') }}"
                                                alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Black</span>
                                            <span class="swatch-value bg_dark"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/black-2.jpg') }}"
                                                src="{{ asset('client/assets/images/products/black-2.jpg') }}"
                                                alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product"
                                            data-src="{{ asset('client/assets/images/products/brown-2.jpg') }}"
                                            src="{{ asset('client/assets/images/products/brown-2.jpg') }}"
                                            alt="image-product">
                                        <img class="lazyload img-hover"
                                            data-src="{{ asset('client/assets/images/products/brown-3.jpg') }}"
                                            src="{{ asset('client/assets/images/products/brown-3.jpg') }}"
                                            alt="image-product">
                                    </a>
                                    <div class="size-list">
                                        <span>4 sizes available</span>
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
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/brown-2.jpg') }}"
                                                src="{{ asset('client/assets/images/products/brown-2.jpg') }}"
                                                alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/white-5.jpg') }}"
                                                src="{{ asset('client/assets/images/products/white-5.jpg') }}"
                                                alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide" lazy="true">
                            <div class="card-product">
                                <div class="card-product-wrapper">
                                    <a href="product-detail.html" class="product-img">
                                        <img class="lazyload img-product"
                                            data-src="{{ asset('client/assets/images/products/light-green-1.jpg') }}"
                                            src="{{ asset('client/assets/images/products/light-green-1.jpg') }}"
                                            alt="image-product">
                                        <img class="lazyload img-hover"
                                            data-src="{{ asset('client/assets/images/products/light-green-2.jpg') }}"
                                            src="{{ asset('client/assets/images/products/light-green-2.jpg') }}"
                                            alt="image-product">
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
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/light-green-1.jpg') }}"
                                                src="{{ asset('client/assets/images/products/light-green-1.jpg') }}"
                                                alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Black</span>
                                            <span class="swatch-value bg_dark"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/black-3.jpg') }}"
                                                src="{{ asset('client/assets/images/products/black-3.jpg') }}"
                                                alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Blue</span>
                                            <span class="swatch-value bg_blue-2"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/blue.jpg') }}"
                                                src="{{ asset('client/assets/images/products/blue.jpg') }}"
                                                alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Dark Blue</span>
                                            <span class="swatch-value bg_dark-blue"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/dark-blue.jpg') }}"
                                                src="{{ asset('client/assets/images/products/dark-blue.jpg') }}"
                                                alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">White</span>
                                            <span class="swatch-value bg_white"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/white-6.jpg') }}"
                                                src="{{ asset('client/assets/images/products/white-6.jpg') }}"
                                                alt="image-product">
                                        </li>
                                        <li class="list-color-item color-swatch">
                                            <span class="tooltip">Light Grey</span>
                                            <span class="swatch-value bg_light-grey"></span>
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/products/light-grey.jpg') }}"
                                                src="{{ asset('client/assets/images/products/light-grey.jpg') }}"
                                                alt="image-product">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="nav-sw nav-next-slider nav-next-product box-icon w_46 round"><span
                        class="icon icon-arrow-left"></span></div>
                <div class="nav-sw nav-prev-slider nav-prev-product box-icon w_46 round"><span
                        class="icon icon-arrow-right"></span></div>
            </div>
        </div>
    </section>
    <!-- /Best seller -->

    <!-- Shop Collection -->
    <section class="flat-spacing-19">
        <div class="container">
            <div class="tf-grid-layout md-col-2 tf-img-with-text style-1">
                <div class="tf-image-wrap wow fadeInUp" data-wow-delay="0s">
                    <img class="lazyload" data-src="{{ asset('client/assets/images/collections/collection-58.jpg') }}"
                        src="{{ asset('client/assets/images/collections/collection-58.jpg') }}" alt="collection-img">
                </div>
                <div class="tf-content-wrap wow fadeInUp" data-wow-delay="0s">
                    <div class="heading">Redefining Fashion <br> Excellence</div>
                    <p class="description">Here is your chance to upgrade your wardrobe with a variation of styles
                    </p>
                    <a href="shop-collection-list.html"
                        class="tf-btn style-2 btn-fill rounded-full animate-hover-btn">Read our stories</a>
                </div>
            </div>
        </div>
    </section>
    <!-- /Shop Collection -->
    <!-- Testimonial -->
    <section class="flat-testimonial-v2 py-0 wow fadeInUp" data-wow-delay="0s">
        <div class="container">
            <div class="wrapper-thumbs-testimonial-v2 type-1 flat-thumbs-testimonial">
                <div class="box-left">
                    <div class="swiper tf-sw-tes-2" data-preview="1" data-space-lg="40" data-space-md="30">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="testimonial-item lg lg-2">
                                    <div class="icon">
                                        <img class="lazyloaded"
                                            data-src="{{ asset('client/assets/images/item/quote.svg') }}"
                                            src="{{ asset('client/assets/images/item/quote.svg') }}">
                                    </div>
                                    <div class="heading fs-12 mb_18">PEOPLE ARE TALKING</div>
                                    <div class="rating">
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                    </div>
                                    <p class="text">
                                        "The shipping is always fast and the customer service team is friendly and
                                        helpful. I highly recommend this site to anyone looking for affordable
                                        clothing."
                                    </p>
                                    <div class="author box-author">
                                        <div class="box-img d-md-none rounded-0">
                                            <img class="lazyload img-product"
                                                data-src="{{ asset('client/assets/images/slider/te4.jpg') }}"
                                                src="{{ asset('client/assets/images/slider/te4.jpg') }}"
                                                alt="image-product">
                                        </div>
                                        <div class="content">
                                            <div class="name">Robert smith</div>
                                            <a href="product-detail.html" class="metas link">Purchase item :
                                                <span>Boxy T-shirt</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="testimonial-item lg lg-2">
                                    <div class="icon">
                                        <img class="lazyloaded"
                                            data-src="{{ asset('client/assets/images/item/quote.svg') }}"
                                            src="{{ asset('client/assets/images/item/quote.svg') }}" alt=""
                                            src="{{ asset('client/assets/images/item/quote.svg') }}">
                                    </div>
                                    <div class="heading fs-12 mb_18">PEOPLE ARE TALKING</div>
                                    <div class="rating">
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                    </div>
                                    <p class="text">
                                        "The shipping is always fast and the customer service team is friendly and
                                        helpful. I highly recommend this site to anyone looking for affordable
                                        clothing."
                                    </p>
                                    <div class="author box-author">
                                        <div class="box-img d-md-none rounded-0">
                                            <img class="lazyload img-product"
                                                data-src="{{ asset('client/assets/images/slider/te6.jpg') }}"
                                                src="{{ asset('client/assets/images/slider/te6.jpg') }}"
                                                alt="image-product">
                                        </div>
                                        <div class="content">
                                            <div class="name">Jenifer Unix</div>
                                            <a href="product-detail.html" class="metas link">Purchase item :
                                                <span> Sweetheart-neckline Top</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-md-flex d-none box-sw-navigation">
                        <div class="nav-sw nav-next-slider nav-next-tes-2"><span class="icon icon-arrow-left"></span>
                        </div>
                        <div class="nav-sw nav-prev-slider nav-prev-tes-2"><span class="icon icon-arrow-right"></span>
                        </div>
                    </div>
                    <div class="d-md-none sw-dots style-2 sw-pagination-tes-2"></div>
                </div>
                <div class="box-right">
                    <div class="swiper tf-thumb-tes" data-preview="1" data-space="30">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="grid-img-group style-ter-1">
                                    <div class="box-img item-1 hover-img">
                                        <div class="img-style">
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/slider/te4.jpg') }}"
                                                src="{{ asset('client/assets/images/slider/te4.jpg') }}"
                                                alt="img-slider">
                                        </div>
                                    </div>
                                    <div class="box-img item-2 hover-img">
                                        <div class="img-style">
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/slider/te3.jpg') }}"
                                                src="{{ asset('client/assets/images/slider/te3.jpg') }}"
                                                alt="img-slider">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="grid-img-group style-ter-1">
                                    <div class="box-img item-1 hover-img">
                                        <div class="img-style">
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/slider/te6.jpg') }}"
                                                src="{{ asset('client/assets/images/slider/te6.jpg') }}"
                                                alt="img-slider">
                                        </div>
                                    </div>
                                    <div class="box-img item-2 hover-img">
                                        <div class="img-style">
                                            <img class="lazyload"
                                                data-src="{{ asset('client/assets/images/slider/te5.jpg') }}"
                                                src="{{ asset('client/assets/images/slider/te5.jpg') }}"
                                                alt="img-slider">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Testimonial -->
    <!-- Icon box -->
    <section class="flat-spacing-11 pb_0 flat-iconbox wow fadeInUp" data-wow-delay="0s">
        <div class="container">
            <div class="wrap-carousel wrap-mobile">
                <div class="swiper tf-sw-mobile" data-preview="1" data-space="15">
                    <div class="swiper-wrapper wrap-iconbox">
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-border-line text-center">
                                <div class="icon">
                                    <i class="icon-shipping"></i>
                                </div>
                                <div class="content">
                                    <div class="title">Free Shipping</div>
                                    <p>Free shipping over order $120</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-border-line text-center">
                                <div class="icon">
                                    <i class="icon-payment fs-22"></i>
                                </div>
                                <div class="content">
                                    <div class="title">Flexible Payment</div>
                                    <p>Pay with Multiple Credit Cards</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-border-line text-center">
                                <div class="icon">
                                    <i class="icon-return fs-22"></i>
                                </div>
                                <div class="content">
                                    <div class="title">14 Day Returns</div>
                                    <p>Within 30 days for an exchange</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-border-line text-center">
                                <div class="icon">
                                    <i class="icon-suport"></i>
                                </div>
                                <div class="content">
                                    <div class="title">Premium Support</div>
                                    <p>Outstanding premium support</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="sw-dots style-2 sw-pagination-mb justify-content-center"></div>
            </div>
        </div>
    </section>
    <!-- /Icon box -->

    <!-- Brand -->
    <section class="flat-spacing-12">
        <div class="">
            <div class="wrap-carousel wrap-brand wrap-brand-v2 autoplay-linear">
                <div class="swiper tf-sw-brand border-0" data-play="true" data-loop="true" data-preview="6"
                    data-tablet="4" data-mobile="2" data-space-lg="30" data-space-md="15">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="brand-item-v2">
                                <img class="lazyload" data-src="{{ asset('client/assets/images/brand/brand-01.png') }}"
                                    src="{{ asset('client/assets/images/brand/brand-01.png') }}" alt="image-brand">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="brand-item-v2">
                                <img class="lazyload" data-src="{{ asset('client/assets/images/brand/brand-02.png') }}"
                                    src="{{ asset('client/assets/images/brand/brand-02.png') }}" alt="image-brand">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="brand-item-v2">
                                <img class="lazyload" data-src="{{ asset('client/assets/images/brand/brand-03.png') }}"
                                    src="{{ asset('client/assets/images/brand/brand-03.png') }}" alt="image-brand">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="brand-item-v2">
                                <img class="lazyload" data-src="{{ asset('client/assets/images/brand/brand-04.png') }}"
                                    src="{{ asset('client/assets/images/brand/brand-04.png') }}" alt="image-brand">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="brand-item-v2">
                                <img class="lazyload" data-src="{{ asset('client/assets/images/brand/brand-05.png') }}"
                                    src="{{ asset('client/assets/images/brand/brand-05.png') }}" alt="image-brand">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="brand-item-v2">
                                <img class="lazyload" data-src="{{ asset('client/assets/images/brand/brand-06.png') }}"
                                    src="{{ asset('client/assets/images/brand/brand-06.png') }}" alt="image-brand">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Brand -->
@endsection
