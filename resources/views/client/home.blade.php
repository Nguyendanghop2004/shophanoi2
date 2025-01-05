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
                            @foreach ($collections as $collection)
                                <div class="collection-item-circle hover-img">
                                    <a href="shop-collection-sub.html" class="collection-image img-style">
                                        <img class="lazyload"
                                            data-src="{{ asset('storage/' . $collection->background_image) }}"
                                            src="{{ asset('storage/' . $collection->background_image) }}"
                                            alt="collection-img">
                                    </a>
                                    <div class="collection-content text-center">
                                        <a href="shop-collection-sub.html"
                                            class="link title fw-6">{{ $collection->name }}</a>
                                    </div>
                                </div>
                            @endforeach
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
    <!-- /slider -->

    {{-- <!-- Categories -->
    <section class="flat-spacing-5 pb_0">
        <div class="container">
            <div class="flat-title">
                <span class="title wow fadeInUp" data-wow-delay="0s">Categories you might like</span>
            </div>
            <div class="hover-sw-nav">

                <div class="swiper tf-sw-collection" data-preview="4" data-tablet="2" data-mobile="2" data-space-lg="30"
                    data-space-md="30" data-space="15" data-loop="false" data-auto-play="false">
                    <div class="swiper-wrapper">
                        @foreach ($categories as $category)
                            <div class="swiper-slide" lazy="true">

                                <div class="collection-item style-2 hover-img">
                                    <div class="collection-inner">
                                        <a href="" class="0">

                                            <img class="lazyload" data-src="{{ Storage::url($category->image_path) }}"
                                                src="{{ Storage::url($category->image_path) }}" alt="collection-img">
                                        </a>
                                        <div class="collection-content">
                                            <a href=""
                                                class="tf-btn collection-title hover-icon fs-15 rounded-full"><span>{{ $category->name }}</span><i
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
                <span class="title">Sản Phẩm Yêu Thích</span>
                <p class="sub-title">Thời trang đẹp mắt, tiện lợi và bền vững – dành cho mọi phong cách của bạn.</p>
            </div>
            @if(session('success'))
            <div style="position: relative; padding: 15px; margin: 15px 0; background: linear-gradient(to right, #a8e063, #56ab2f); color: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <strong style="font-size: 16px;">🎉 Thành công!</strong>
                <p style="margin: 5px 0; font-size: 14px;">{{ session('success') }}</p>
                <button style="position: absolute; top: 10px; right: 10px; background: none; border: none; color: #fff; font-size: 18px; font-weight: bold; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
            </div>
        @endif
        
        @if(session('error'))
            <div style="position: relative; padding: 15px; margin: 15px 0; background: linear-gradient(to right, #ff416c, #ff4b2b); color: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <strong style="font-size: 16px;">⚠️ Lỗi!</strong>
                <p style="margin: 5px 0; font-size: 14px;">{{ session('error') }}</p>
                <button style="position: absolute; top: 10px; right: 10px; background: none; border: none; color: #fff; font-size: 18px; font-weight: bold; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
            </div>
        @endif
            <div class="hover-sw-nav hover-sw-3">
                <div class="swiper tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3" data-mobile="2"
                    data-space-lg="30" data-space-md="15" data-pagination="2" data-pagination-md="3" data-pagination-lg="3">
                    <div class="swiper-wrapper">

                        @foreach ($products as $product)
                            <div class="swiper-slide" lazy="true">
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="{{ route('product-detail', $product['slug']) }}" class="product-img">
                                            <img class="lazyload img-product"
                                                data-src="{{ asset('storage/' . $product['main_image_url']) }}"
                                                src="{{ asset('storage/' . $product['main_image_url']) }}"
                                                alt="image-product">
                                            <img class="lazyload img-hover"
                                                data-src="{{ isset($product['hover_main_image_url']) && $product['hover_main_image_url'] ? asset('storage/' . $product['hover_main_image_url']) : asset('storage/' . $product['main_image_url']) }}"
                                                src="{{ isset($product['hover_main_image_url']) && $product['hover_main_image_url'] ? asset('storage/' . $product['hover_main_image_url']) : asset('storage/' . $product['main_image_url']) }}"
                                                alt="image-product">
                                        </a>
                                        
                                        <div class="list-product-btn">
                                            {{-- <a href="#quick_add" data-bs-toggle="modal"
                                                data-product-id="{{ $product['id'] }}"
                                                class="box-icon bg_white quick-add tf-btn-loading">
                                                <span class="icon icon-bag"></span>
                                                <span class="tooltip">Quick Add</span>
                                            </a> --}}
                                            <form action="{{ route('wishlist.add', $product['id']) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="box-icon bg_white wishlist btn-icon-action">
                                                    <span class="icon icon-heart"></span>
                                                    <span class="tooltip">Add to Wishlist</span>
                                                </button>
                                            </form>
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



                                            {{-- <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                                                class="box-icon bg_white compare btn-icon-action">
                                                <span class="icon icon-compare"></span>
                                                <span class="tooltip">Add to Compare</span>
                                                <span class="icon icon-check"></span>
                                            </a> --}}
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
                                        <span class="price">   @if ($product['sale_price'] < $product['price'])
                                            <span class="sale-price">{{ number_format($product['sale_price'], 0, ',', '.') }} VNĐ</span>
                                            <span class="original-price" style="text-decoration: line-through; color: #888;">
                                                {{ number_format($product['price'], 0, ',', '.') }} VNĐ
                                            </span>
                                        @else
                                            <span class="regular-price">{{ number_format($product['price'], 0, ',', '.') }} VNĐ</span>
                                        @endif</span>
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
        </div>
    </section>


    <section class="flat-spacing-15 pb_0">
        <div class="container">
            <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                <span class="title">Bài Viết</span>

            </div>
            <div class="blog-grid-main">
                <div class="container">
                    {{-- <div class="row">
                        @foreach ($data as $item)
                            <div class="col-xl-4 col-md-6 col-12">
                                <div class="blog-article-item">
                                    <div class="article-thumb">
                                        <a href="{{ route('blog.detail', $item->slug) }}">
                                            <img class="lazyload" src="{{ Storage::url($item->image) }} "
                                                style="width: 366px; height: 235px;" alt="img-blog">
                                        </a>
                                    </div>
                                    <div class="article-content">
                                        <div class="article-title">
                                            <a href="{{ route('blog.detail', $item->slug) }}"
                                                class="">{{ $item->title }}</a>
                                        </div>
                                        <div class="article-btn">
                                            <a href="{{ route('blog.detail', $item->slug) }}"
                                                class="tf-btn btn-line fw-6">Xêm Thêm<i
                                                    class="icon icon-arrow1-top-left"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div> --}}
                </div>
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
                    <div class="heading">Định nghĩa lại thời trang <br> Xuất sắc</div>
                    <p class="description">Đây là cơ hội để bạn nâng cấp tủ quần áo của mình với nhiều phong cách khác nhau
                    </p>
                    <a href="shop-collection-list.html"
                        class="tf-btn style-2 btn-fill rounded-full animate-hover-btn">Đọc câu chuyện của chúng tôi</a>
                </div>
            </div>
        </div>
    </section>
    <!-- /Shop Collection -->
    {{-- <!-- Testimonial -->
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
    <!-- /Testimonial --> --}}
    <!-- Icon box -->
    <section class="flat-spacing-11 pb_0 flat-iconbox wow fadeInUp mb-4" data-wow-delay="0s">
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
                                    <div class="title">Miễn phí vận chuyển</div>
                                    <p>Miễn phí vận chuyển cho đơn hàng 300.000</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-border-line text-center">
                                <div class="icon">
                                    <i class="icon-payment fs-22"></i>
                                </div>
                                <div class="content">
                                    <div class="title">Thanh toán linh hoạt</div>
                                    <p>Thanh toán bằng nhiều thẻ tín dụng</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-border-line text-center">
                                <div class="icon">
                                    <i class="icon-return fs-22"></i>
                                </div>
                                <div class="content">
                                    <div class="title">Trả hàng trong 14 ngày</div>
                                    <p>Trong vòng 30 ngày cho một cuộc trao đổi</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-border-line text-center">
                                <div class="icon">
                                    <i class="icon-suport"></i>
                                </div>
                                <div class="content">
                                    <div class="title">Hỗ trợ cao cấp</div>
                                    <p>Hỗ trợ cao cấp vượt trội</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="sw-dots style-2 sw-pagination-mb justify-content-center"></div>
            </div>
        </div>
    </section>
    <style>
    
    /* Đặt kiểu mặc định cho nút */
/* Kiểu mặc định cho nút */
.wishlist-btn {
    background-color: #fff; /* Nền trắng mặc định */
    border: none;
    
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
    border-radius: 50%; /* Tùy chỉnh để có thể làm nút tròn */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Hiệu ứng nổi nhẹ */
}

=
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
    <!-- /Icon box -->

    {{-- <!-- Brand -->
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
    <!-- /Brand --> --}}
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Bắt sự kiện click vào nút Quick Add
            $(".quick-add").on("click", function(e) {
                e.preventDefault();

                // Lấy ID sản phẩm từ thuộc tính data
                let productId = $(this).data("product-id");

                // Gửi yêu cầu AJAX
                $.ajax({
                    url: "/get-product-info", // Đường dẫn API xử lý
                    method: "GET",
                    data: {
                        id: productId
                    },
                    success: function(response) {
                        // Chèn nội dung nhận được vào modal
                        $("#product-modal-content").html(response);
                        // Hiển thị modal
                        $("#quick_add").modal("show");
                    },
                    error: function() {
                        toastr.error('Sản Phẩm Không Tồn Tại, Hãy Thử Tải Lại Trang!',
                            'Cảnh báo');
                    },
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Bắt sự kiện click vào nút Quick Add
            $(".quickview").on("click", function(e) {
                e.preventDefault();

                // Lấy ID sản phẩm từ thuộc tính data
                let productId = $(this).data("product-id");

                // Gửi yêu cầu AJAX
                $.ajax({
                    url: "/get-product-info-quick-view", // Đường dẫn API xử lý
                    method: "GET",
                    data: {
                        id: productId
                    },
                    success: function(response) {
                        // Chèn nội dung nhận được vào modal
                        $("#modal-quick-view-content").html(response);
                        // Hiển thị modal
                        $("#quick_view").modal("show");
                        // Khởi tạo Swiper sau khi nội dung đã được chèn
                        new Swiper('.tf-single-slide', {
                            loop: true,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                            autoplay: {
                                delay: 3000,
                            },
                        });
                    },
                    error: function() {
                        toastr.error('Sản Phẩm Không Tồn Tại, Hãy Thử Tải Lại Trang!',
                            'Cảnh báo');
                    },
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Khi modal mở, gọi API để cập nhật giỏ hàng
            $('#shoppingCart').on('show.bs.modal', function() {
                loadModalCart(); // Hàm gọi API để lấy thông tin giỏ hàng
            });
        });

        function loadModalCart() {
            $.ajax({
                url: '/cart/modal-cart', // Route API của phương thức getModalCart
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        renderModalCart(response.cart); // Cập nhật lại nội dung modal giỏ hàng

                    } else {
                        toastr.error(response.message, 'Cảnh báo');

                    }
                },
                error: function(error) {
                    // console.error('Error loading cart details:', error);
                    // alert('An error occurred while loading the cart.');
                    toastr.error('Gặp lỗi khi tải giỏ hàng hãy thử tải lại trang Web', 'Cảnh báo');

                }
            });
        }



        // Hàm hiển thị lại nội dung modal giỏ hàng
        function renderModalCart(cartDetails) {
            const modalCartContainer = $('.tf-mini-cart-items'); // Container của modal cart
            modalCartContainer.empty(); // Xóa nội dung cũ trước khi cập nhật mới

            if (cartDetails.length === 0) {
                modalCartContainer.append(`<div class="tf-mini-cart-items d-flex justify-content-center align-items-center" style="height: 100px;">
                                                 <div class="tf-mini-cart-item">
                                                     <p><i class="fa-solid fa-cart-arrow-down"></i> Giỏ hàng trống</p>
                                                 </div>
                                          </div>    `);
                return;
            }

            // Thêm từng sản phẩm vào modal
            cartDetails.forEach(item => {
                modalCartContainer.append(`
                                    <div class="tf-mini-cart-item">
                                        <div class="tf-mini-cart-image">
                                            <a href="product-detail.html">
                                                <img src="storage/${item.image_url}" alt="">
                                            </a>
                                        </div>
                                        <div class="tf-mini-cart-info">
                                            <a class="title link"
                                                href="product-detail.html">${item.product_name}</a>
                                            <div class="meta-variant">${item.color_name} / ${item.size_name}</div>
                                            <div class="price fw-6" data-price="${item.price * item.quantity}">${item.price * item.quantity}</div>
                                            <div class="tf-mini-cart-btns">
                                                <div class="wg-quantity small">
                                                    <!-- Nút giảm số lượng -->
                                                    <span class="btn-quantity minus-btn-cart"
                                                        data-url="{{ route('cart.update') }}"
                                                        data-id="${item.product_id}"
                                                        data-color="${item.color_id}"
                                                        data-size="${item.size_id}">
                                                        <svg class="d-inline-block" width="9" height="1"
                                                            viewBox="0 0 9 1" fill="currentColor">
                                                            <path
                                                                d="M9 1H5.14286H3.85714H0V1.50201e-05H3.85714L5.14286 0L9 1.50201e-05V1Z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                    <!-- Trường nhập số lượng -->
                                                    <input type="text" class="quantity-input quantity-input-cart" name="number"
                                                        value="${item.quantity}"
                                                        data-url="{{ route('cart.update') }}"
                                                        data-id="${item.product_id}"
                                                        data-color="${item.color_id}"
                                                        data-size="${item.size_id}">

                                                    <!-- Nút tăng số lượng -->
                                                    <span class="btn-quantity plus-btn-cart"
                                                        data-url="{{ route('cart.update') }}"
                                                        data-id="${item.product_id}"
                                                        data-color="${item.color_id}"
                                                        data-size="${item.size_id}">
                                                        <svg class="d-inline-block" width="9" height="9"
                                                            viewBox="0 0 9 9" fill="currentColor">
                                                            <path
                                                                d="M9 5.14286H5.14286V9H3.85714V5.14286H0V3.85714H3.85714V0H5.14286V3.85714H9V5.14286Z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                  <div class="tf-mini-cart-remove"
                                                    data-id="${item.product_id}"
                                                    data-color="${item.color_id}"
                                                    data-size="${item.size_id}">
                                                              Remove
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
             `);
            });
            // Gắn sự kiện click cho nút "Remove"
            $('.tf-mini-cart-remove').off('click').on('click', function() {
                const productId = $(this).data('id');
                const colorId = $(this).data('color');
                const sizeId = $(this).data('size');
                removeFromCart(productId, colorId, sizeId); // Gọi hàm xóa

            });
            // Lấy tất cả các phần tử <div> có class "price"
            const priceDivs = document.querySelectorAll('.price');

            // Tính tổng giá trị của tất cả các data-price
            let total = 0;
            priceDivs.forEach(div => {
                const price = parseFloat(div.getAttribute('data-price')) ||
                    0; // Lấy giá trị data-price, mặc định là 0 nếu không tồn tại
                total += price;
            });
            $('.tf-totals-total-value').text(total.toFixed(2));
        }
    </script>
    <script>
        // Xử lý khi nhấn nút xóa
        function removeFromCart(productId, colorId, sizeId) {
            $.ajax({
                url: '/remove-from-cart', // URL tới route xóa sản phẩm
                method: 'POST', // Chú ý: nên dùng POST thay vì GET cho hành động xóa
                data: {
                    product_id: productId,
                    color_id: colorId,
                    size_id: sizeId,
                    _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                },
                success: function(response) {
                    if (response.success) {
                        loadModalCart();
                    } else {
                        toastr.error(response.message, 'Cảnh báo');

                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error, xhr.responseText); // Ghi log lỗi AJAX
                    alert('There was an error processing your request.');
                }
            });

        }
    </script>
    <script>
        $(document).ready(function() {
            // Hàm gửi AJAX cập nhật số lượng
            function updateQuantity(productId, colorId, sizeId, newQuantity, url) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF Token
                        product_id: productId,
                        color_id: colorId,
                        size_id: sizeId,
                        quantity: newQuantity
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log('Cập nhật thành công');
                            loadModalCart();
                        } else {
                            toastr.error(response.message, 'Cảnh báo');
                            loadModalCart();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        toastr.error('Không thể cập nhật số lượng. Vui lòng thử lại!', 'Lỗi');
                    }
                });
            }

            // Gắn sự kiện click cho nút plus và minus
            $(document).off('click', '.minus-btn-cart, .plus-btn-cart').on('click',
                '.minus-btn-cart, .plus-btn-cart',
                function(e) {
                    e.preventDefault();

                    let button = $(this);
                    let inputField = button.siblings('.quantity-input'); // Trường input
                    let productId = button.data('id');
                    let colorId = button.data('color');
                    let sizeId = button.data('size');
                    let url = button.data('url');
                    let currentQuantity = parseInt(inputField.val()) || 1;

                    // Tăng hoặc giảm số lượng
                    if (button.hasClass('plus-btn-cart')) {
                        currentQuantity += 1;
                    } else if (button.hasClass('minus-btn-cart') && currentQuantity > 1) {
                        currentQuantity -= 1;
                    }

                    // Cập nhật số lượng trong input
                    inputField.val(currentQuantity);

                    // Gửi AJAX cập nhật
                    updateQuantity(productId, colorId, sizeId, currentQuantity, url);
                });

            // Gắn sự kiện change cho input
            $(document).off('change', '.quantity-input-cart').on('change', '.quantity-input-cart', function() {
                let inputField = $(this);
                let productId = inputField.data('id');
                let colorId = inputField.data('color');
                let sizeId = inputField.data('size');
                let url = inputField.data('url');
                let newQuantity = parseInt(inputField.val()) || 1;

                // Đảm bảo số lượng tối thiểu là 1
                if (newQuantity < 1) {
                    newQuantity = 1;
                    inputField.val(newQuantity);
                }

                // Gửi AJAX cập nhật
                updateQuantity(productId, colorId, sizeId, newQuantity, url);
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
