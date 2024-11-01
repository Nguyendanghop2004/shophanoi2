@extends('client.layouts.master')

@section('content')
    <!-- breadcrumb -->
    <div class="tf-breadcrumb">
        <div class="container">
            <div class="tf-breadcrumb-wrap d-flex justify-content-between flex-wrap align-items-center">
                <div class="tf-breadcrumb-list">
                    <a href="index.html" class="text">Home</a>
                    <i class="icon icon-arrow-right"></i>
                    <a href="#" class="text">Women</a>
                    <i class="icon icon-arrow-right"></i>
                    <span class="text">{{ $product->product_name }}</span>
                    
                </div>
                <div class="tf-breadcrumb-prev-next">
                    <a href="#" class="tf-breadcrumb-prev hover-tooltip center">
                        <i class="icon icon-arrow-left"></i>
                    </a>
                    <a href="#" class="tf-breadcrumb-back hover-tooltip center">
                        <i class="icon icon-shop"></i>
                    </a>
                    <a href="#" class="tf-breadcrumb-next hover-tooltip center">
                        <i class="icon icon-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
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
                <div class="swiper-wrapper">
                    @foreach ($product->images as $image)
                        <div class="swiper-slide">
                            <div class="item">
                                <img class="lazyload" data-src="{{Storage::Url($image->image_url)}}"
                                     src="{{Storage::Url($image->image_url)}}" alt="">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper tf-product-media-main" id="gallery-swiper-started">
                <div class="swiper-wrapper">
                    @foreach ($product->images as $image)
                        <div class="swiper-slide">
                            <a href="{{Storage::Url($image->image_url)}}" target="_blank" class="item"
                               data-pswp-width="770px" data-pswp-height="1075px">
                                <img class="lazyload" data-zoom="{{Storage::Url($image->image_url)}}"
                                     data-src="{{Storage::Url($image->image_url)}}"
                                     src="{{Storage::Url($image->image_url)}}" alt="">
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
            <div class="tf-product-info-badges">
                <div class="badges">Best seller</div>
                <div class="product-status-content">
                    <i class="icon-lightning"></i>
                    <p class="fw-6">Selling fast! 56 people have this in their carts.</p>
                </div>
            </div>
            <div class="tf-product-info-price">
                @php
                    $final_price = $product->price + ($additional_price ?? 0);
                @endphp
                <div class="price-on-sale" id="final-price">{{ number_format($final_price, 0, ',', '.') }} VND</div>
                <div class="compare-at-price">{{ number_format($product->price, 0, ',', '.') }} VND</div>
                @if ($additional_price > 0)
                    <div class="badges-on-sale">
                        <span>{{ round(($additional_price / $product->price) * 100, 2) }}</span>% OFF
                    </div>
                @endif
            </div>
            <div class="tf-product-info-liveview">
                <div class="liveview-count">20</div>
                <p class="fw-6">People are viewing this right now</p>
            </div>
            <div class="tf-product-info-countdown">
                <div class="countdown-wrap">
                    <div class="countdown-title">
                        <i class="icon-time tf-ani-tada"></i>
                        <p>HURRY UP! SALE ENDS IN:</p>
                    </div>
                    <div class="tf-countdown style-1">
                        <div class="js-countdown" data-timer="1007500" data-labels="Days :,Hours :,Mins :,Secs"></div>
                    </div>
                </div>
            </div>
            <div class="tf-product-info-variant-picker">
                <div class="variant-picker-item">
                    <div class="variant-picker-label">
                        Color: <span class="fw-6 variant-picker-label-value">{{ $selected_color->name ?? 'N/A' }}</span>
                    </div>
                    <div class="variant-picker-values">
                        @php $lastColorName = ''; @endphp
                        @foreach ($product->variants as $variant)
                            @php
                                $colorName = $variant->color->name;
                                $colorCode = $variant->color->sku_color;
                                if ($colorName !== $lastColorName) {
                                    $lastColorName = $colorName;
                            @endphp
                                <input id="color-{{ $variant->color->sku_color }}" type="radio" name="color" value="{{ $variant->color_id }}" data-price="{{ $variant->price }}" {{ $variant->color_id == ($selected_color->id ?? null) ? 'checked' : '' }}>
                                <label class="hover-tooltip radius-60" for="color-{{ $variant->color->sku_color }}" data-value="{{ $variant->color->name }}">
                                    <span class="btn-checkbox" style="background-color: {{ $colorCode }};"></span>
                                    <span class="tooltip">{{ $variant->color->name }}</span>
                                </label>
                            @php
                                }
                            @endphp
                        @endforeach
                    </div>
                </div>
                <div class="variant-picker-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="variant-picker-label">
                            Size: <span class="fw-6 variant-picker-label-value">{{ $selected_size->name ?? 'N/A' }}</span>
                        </div>
                        <a href="#find_size" data-bs-toggle="modal" class="find-size fw-6">Find your size</a>
                    </div>
                    <div class="variant-picker-values">
                        @php 
                            $displayedSizes = []; 
                        @endphp
                        @foreach ($product->variants as $variant)
                            @php
                                $sizeName = $variant->size->name;
                                if (!in_array($sizeName, $displayedSizes)) { 
                                    $displayedSizes[] = $sizeName; 
                            @endphp
                                <input type="radio" name="size" id="size-{{ $variant->size->id }}" value="{{ $variant->size_id }}" {{ $variant->size_id == ($selected_size->id ?? null) ? 'checked' : '' }} data-stock="{{ $variant->stock_quantity }}">
                                <label class="style-text" for="size-{{ $variant->size->id }}" data-value="{{ $variant->size->name }}">
                                    <p>{{ $variant->size->name }}</p>
                                </label>
                            @php
                                }
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tf-product-info-quantity">
    <div class="quantity-title fw-6">Quantity</div>
    <div class="wg-quantity">
        <span class="btn-quantity minus-btn" onclick="changeQuantity(-1)">-</span>
        <input type="number" id="quantity-input" name="number" value="1" min="1" max="{{ $total_stock_quantity }}" oninput="validateQuantity()">
        <span class="btn-quantity plus-btn" onclick="changeQuantity(1)">+</span>
    </div>
    <div class="stock-info">
        <p class="fw-6">Số lượng: <span id="remaining-stock">{{ $total_stock_quantity }} còn lại</span></p>
    </div>
</div>


            <div class="tf-product-info-buy-button">
                <form>
                    <a href="javascript:void(0);" class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart">
                        <span>Add to cart -&nbsp;</span>
                        <span class="tf-qty-price">{{ number_format($final_price, 0, ',', '.') }} VND</span>
                    </a>
                    <a href="javascript:void(0);" class="tf-product-btn-wishlist hover-tooltip box-icon bg_white wishlist btn-icon-action">
                        <span class="icon icon-heart"></span>
                        <span class="tooltip">Add to Wishlist</span>
                        <span class="icon icon-delete"></span>
                    </a>
                    <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft" class="tf-product-btn-wishlist hover-tooltip box-icon bg_white compare btn-icon-action">
                        <span class="icon icon-compare"></span>
                        <span class="tooltip">Add to Compare</span>
                        <span class="icon icon-check"></span>
                    </a>
                    <div class="w-100">
                        <a href="#" class="btns-full">Buy with <img src="images/payments/paypal.png" alt=""></a>
                        <a href="#" class="payment-more-option">More payment options</a>
                    </div>
                </form>
            </div>
            <div class="tf-product-info-extra-link">
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
                        <svg class="d-inline-block" xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="currentColor">
                            <path d="M21.7872 10.4724C21.7872 9.73685 21.5432 9.00864 21.1002 8.4217L18.7221 5.27043C18.2421 4.63481 17.4804 4.25532 16.684 4.25532H14.9787V2.54885C14.9787 1.14111 13.8334 0 12.4255 0H9.95745V1.69779H12.4255C12.8948 1.69779 13.2766 2.07962 13.2766 2.54885V14.5957H8.15145C7.80021 13.6052 6.85421 12.8936 5.74468 12.8936H2.05465C0.86819 12.8936 0 13.7494 0 15.0057C0 16.262 0.86819 17.1188 2.05465 17.1188H5.74468C7.24889 17.1188 8.51934 18.1624 9.23465 19.0904H16.1553C16.9521 19.0904 17.6333 18.4092 17.6333 17.6123C17.6333 16.9712 17.1682 16.5 16.484 16.5H13.2766V15.0057H16.484C17.7064 15.0057 18.8789 14.0082 18.8789 12.6324V10.4724H21.7872Z"></path>
                        </svg>
                    </div>
                    <div class="text fw-6">Delivery & Return</div>
                </a>
            </div>
        </div>
    </div>
</div>



                </div>
            </div>
        </div>
        <div class="tf-sticky-btn-atc">
            <div class="container">
            <div class="tf-height-observer w-100 d-flex align-items-center">
    <div class="tf-sticky-atc-product d-flex align-items-center">
        <div class="tf-sticky-atc-img">
            <img class="lazyload" data-src="{{ Storage::url($product->images->first()->image_url) }}" alt=""
                 src="{{ Storage::url($product->images->first()->image_url) }}">
        </div>
        <div class="tf-sticky-atc-title fw-5 d-xl-block d-none">{{ $product->name }}</div>
    </div>
    <div class="tf-sticky-atc-infos">
        <form>
            <div class="tf-sticky-atc-variant-price text-center">
            <select class="tf-select" id="variant-select">
    @foreach ($product->variants as $variant)
        <option value="{{ $variant->id }}" data-price="{{ $variant->price }}">
            {{ $variant->color->name }} / {{ $variant->size->name }} - {{ number_format($base_price + $variant->price, 0, ',', '.') }} VND
        </option>
    @endforeach
</select>
            </div>
            <div class="tf-sticky-atc-btns">
          

                <a href="javascript:void(0);" class="tf-btn btn-fill radius-3 justify-content-center fw-6 fs-14 flex-grow-1 animate-hover-btn btn-add-to-cart">
                    <span>Add to cart</span>
                </a>
            </div>
        </form>
    </div>



            </div>
        </div>
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
                                <span class="inner">Description</span>
                            </li>
                            <li class="item-title">
                                <span class="inner">Review</span>
                            </li>
                            <li class="item-title">
                                <span class="inner">Shipping</span>
                            </li>
                            <li class="item-title">
                                <span class="inner">Return Policies</span>
                            </li>
                        </ul>
                        <div class="widget-content-tab">
                            <div class="widget-content-inner active">
                                <div class="">
                                    <p class="mb_30">
                                        Button-up shirt sleeves and a relaxed silhouette. It’s tailored with drapey,
                                        crinkle-texture fabric that’s made from LENZING™ ECOVERO™ Viscose — responsibly
                                        sourced wood-based
                                        fibres produced through a process that reduces impact on forests, biodiversity and
                                        water supply.
                                    </p>
                                    <div class="tf-product-des-demo">
                                        <div class="right">
                                            <h3 class="fs-16 fw-5">Features</h3>
                                            <ul>
                                                <li>Front button placket</li>
                                                <li> Adjustable sleeve tabs</li>
                                                <li>Babaton embroidered crest at placket and hem</li>
                                            </ul>
                                            <h3 class="fs-16 fw-5">Materials Care</h3>
                                            <ul class="mb-0">
                                                <li>Content: 100% LENZING™ ECOVERO™ Viscose</li>
                                                <li>Care: Hand wash</li>
                                                <li>Imported</li>
                                            </ul>
                                        </div>
                                        <div class="left">
                                            <h3 class="fs-16 fw-5">Materials Care</h3>
                                            <div class="d-flex gap-10 mb_15 align-items-center">
                                                <div class="icon">
                                                    <i class="icon-machine"></i>
                                                </div>
                                                <span>Machine wash max. 30ºC. Short spin.</span>
                                            </div>
                                            <div class="d-flex gap-10 mb_15 align-items-center">
                                                <div class="icon">
                                                    <i class="icon-iron"></i>
                                                </div>
                                                <span>Iron maximum 110ºC.</span>
                                            </div>
                                            <div class="d-flex gap-10 mb_15 align-items-center">
                                                <div class="icon">
                                                    <i class="icon-bleach"></i>
                                                </div>
                                                <span>Do not bleach/bleach.</span>
                                            </div>
                                            <div class="d-flex gap-10 mb_15 align-items-center">
                                                <div class="icon">
                                                    <i class="icon-dry-clean"></i>
                                                </div>
                                                <span>Do not dry clean.</span>
                                            </div>
                                            <div class="d-flex gap-10 align-items-center">
                                                <div class="icon">
                                                    <i class="icon-tumble-dry"></i>
                                                </div>
                                                <span>Tumble dry, medium hear.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-inner">
                                <table class="tf-pr-attrs">
                                    <tbody>
                                        <tr class="tf-attr-pa-color">
                                            <th class="tf-attr-label">Color</th>
                                            <td class="tf-attr-value">
                                                <p>White, Pink, Black</p>
                                            </td>
                                        </tr>
                                        <tr class="tf-attr-pa-size">
                                            <th class="tf-attr-label">Size</th>
                                            <td class="tf-attr-value">
                                                <p>S, M, L, XL</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="widget-content-inner">
                                <div class="tf-page-privacy-policy">
                                    <div class="title">The Company Private Limited Policy</div>
                                    <p>The Company Private Limited and each of their respective subsidiary, parent and
                                        affiliated companies is deemed to operate this Website (“we” or “us”) recognizes
                                        that you care how information about you is used and shared. We have created this
                                        Privacy Policy to inform you what information we collect on the Website, how we use
                                        your information and the choices you have about the way your information is
                                        collected and used. Please read this Privacy Policy carefully. Your use of the
                                        Website indicates that you have read and accepted our privacy practices, as outlined
                                        in this Privacy Policy.</p>
                                    <p>Please be advised that the practices described in this Privacy Policy apply to
                                        information gathered by us or our subsidiaries, affiliates or agents: (i) through
                                        this Website, (ii) where applicable, through our Customer Service Department in
                                        connection with this Website, (iii) through information provided to us in our free
                                        standing retail stores, and (iv) through information provided to us in conjunction
                                        with marketing promotions and sweepstakes.</p>
                                    <p>We are not responsible for the content or privacy practices on any websites.</p>
                                    <p>We reserve the right, in our sole discretion, to modify, update, add to, discontinue,
                                        remove or otherwise change any portion of this Privacy Policy, in whole or in part,
                                        at any time. When we amend this Privacy Policy, we will revise the “last updated”
                                        date located at the top of this Privacy Policy.</p>
                                    <p>If you provide information to us or access or use the Website in any way after this
                                        Privacy Policy has been changed, you will be deemed to have unconditionally
                                        consented and agreed to such changes. The most current version of this Privacy
                                        Policy will be available on the Website and will supersede all previous versions of
                                        this Privacy Policy.</p>
                                    <p>If you have any questions regarding this Privacy Policy, you should contact our
                                        Customer Service Department by email at marketing@company.com</p>
                                </div>
                            </div>
                            <div class="widget-content-inner">
                                <ul class="d-flex justify-content-center mb_18">
                                    <li class="">
                                        <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222"
                                            margin="5px">
                                            <path fill="currentColor"
                                                d="M8.7 30.7h22.7c.3 0 .6-.2.7-.6l4-25.3c-.1-.4-.3-.7-.7-.8s-.7.2-.8.6L34 8.9l-3-1.1c-2.4-.9-5.1-.5-7.2 1-2.3 1.6-5.3 1.6-7.6 0-2.1-1.5-4.8-1.9-7.2-1L6 8.9l-.7-4.3c0-.4-.4-.7-.7-.6-.4.1-.6.4-.6.8l4 25.3c.1.3.3.6.7.6zm.8-21.6c2-.7 4.2-.4 6 .8 1.4 1 3 1.5 4.6 1.5s3.2-.5 4.6-1.5c1.7-1.2 4-1.6 6-.8l3.3 1.2-3 19.1H9.2l-3-19.1 3.3-1.2zM32 32H8c-.4 0-.7.3-.7.7s.3.7.7.7h24c.4 0 .7-.3.7-.7s-.3-.7-.7-.7zm0 2.7H8c-.4 0-.7.3-.7.7s.3.6.7.6h24c.4 0 .7-.3.7-.7s-.3-.6-.7-.6zm-17.9-8.9c-1 0-1.8-.3-2.4-.6l.1-2.1c.6.4 1.4.6 2 .6.8 0 1.2-.4 1.2-1.3s-.4-1.3-1.3-1.3h-1.3l.2-1.9h1.1c.6 0 1-.3 1-1.3 0-.8-.4-1.2-1.1-1.2s-1.2.2-1.9.4l-.2-1.9c.7-.4 1.5-.6 2.3-.6 2 0 3 1.3 3 2.9 0 1.2-.4 1.9-1.1 2.3 1 .4 1.3 1.4 1.3 2.5.3 1.8-.6 3.5-2.9 3.5zm4-5.5c0-3.9 1.2-5.5 3.2-5.5s3.2 1.6 3.2 5.5-1.2 5.5-3.2 5.5-3.2-1.6-3.2-5.5zm4.1 0c0-2-.1-3.5-.9-3.5s-1 1.5-1 3.5.1 3.5 1 3.5c.8 0 .9-1.5.9-3.5zm4.5-1.4c-.9 0-1.5-.8-1.5-2.1s.6-2.1 1.5-2.1 1.5.8 1.5 2.1-.5 2.1-1.5 2.1zm0-.8c.4 0 .7-.5.7-1.2s-.2-1.2-.7-1.2-.7.5-.7 1.2.3 1.2.7 1.2z">
                                            </path>
                                        </svg>
                                    </li>
                                    <li class="">
                                        <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222"
                                            margin="5px">
                                            <path fill="currentColor"
                                                d="M36.7 31.1l-2.8-1.3-4.7-9.1 7.5-3.5c.4-.2.6-.6.4-1s-.6-.5-1-.4l-7.5 3.5-7.8-15c-.3-.5-1.1-.5-1.4 0l-7.8 15L4 15.9c-.4-.2-.8 0-1 .4s0 .8.4 1l7.5 3.5-4.7 9.1-2.8 1.3c-.4.2-.6.6-.4 1 .1.3.4.4.7.4.1 0 .2 0 .3-.1l1-.4-1.5 2.8c-.1.2-.1.5 0 .8.1.2.4.3.7.3h31.7c.3 0 .5-.1.7-.4.1-.2.1-.5 0-.8L35.1 32l1 .4c.1 0 .2.1.3.1.3 0 .6-.2.7-.4.1-.3 0-.8-.4-1zm-5.1-2.3l-9.8-4.6 6-2.8 3.8 7.4zM20 6.4L27.1 20 20 23.3 12.9 20 20 6.4zm-7.8 15l6 2.8-9.8 4.6 3.8-7.4zm22.4 13.1H5.4L7.2 31 20 25l12.8 6 1.8 3.5z">
                                            </path>
                                        </svg>
                                    </li>
                                    <li class="">
                                        <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222"
                                            margin="5px">
                                            <path fill="currentColor"
                                                d="M5.9 5.9v28.2h28.2V5.9H5.9zM19.1 20l-8.3 8.3c-2-2.2-3.2-5.1-3.2-8.3s1.2-6.1 3.2-8.3l8.3 8.3zm-7.4-9.3c2.2-2 5.1-3.2 8.3-3.2s6.1 1.2 8.3 3.2L20 19.1l-8.3-8.4zM20 20.9l8.3 8.3c-2.2 2-5.1 3.2-8.3 3.2s-6.1-1.2-8.3-3.2l8.3-8.3zm.9-.9l8.3-8.3c2 2.2 3.2 5.1 3.2 8.3s-1.2 6.1-3.2 8.3L20.9 20zm8.4-10.2c-1.2-1.1-2.6-2-4.1-2.6h6.6l-2.5 2.6zm-18.6 0L8.2 7.2h6.6c-1.5.6-2.9 1.5-4.1 2.6zm-.9.9c-1.1 1.2-2 2.6-2.6 4.1V8.2l2.6 2.5zM7.2 25.2c.6 1.5 1.5 2.9 2.6 4.1l-2.6 2.6v-6.7zm3.5 5c1.2 1.1 2.6 2 4.1 2.6H8.2l2.5-2.6zm18.6 0l2.6 2.6h-6.6c1.4-.6 2.8-1.5 4-2.6zm.9-.9c1.1-1.2 2-2.6 2.6-4.1v6.6l-2.6-2.5zm2.6-14.5c-.6-1.5-1.5-2.9-2.6-4.1l2.6-2.6v6.7z">
                                            </path>
                                        </svg>
                                    </li>
                                    <li class="">
                                        <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222"
                                            margin="5px">
                                            <path fill="currentColor"
                                                d="M35.1 33.6L33.2 6.2c0-.4-.3-.7-.7-.7H13.9c-.4 0-.7.3-.7.7s.3.7.7.7h18l.7 10.5H20.8c-8.8.2-15.9 7.5-15.9 16.4 0 .4.3.7.7.7h28.9c.2 0 .4-.1.5-.2s.2-.3.2-.5v-.2h-.1zm-28.8-.5C6.7 25.3 13 19 20.8 18.9h11.9l1 14.2H6.3zm11.2-6.8c0 1.2-1 2.1-2.1 2.1s-2.1-1-2.1-2.1 1-2.1 2.1-2.1 2.1 1 2.1 2.1zm6.3 0c0 1.2-1 2.1-2.1 2.1-1.2 0-2.1-1-2.1-2.1s1-2.1 2.1-2.1 2.1 1 2.1 2.1z">
                                            </path>
                                        </svg>
                                    </li>
                                    <li class="">
                                        <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222"
                                            margin="5px">
                                            <path fill="currentColor"
                                                d="M20 33.8c7.6 0 13.8-6.2 13.8-13.8S27.6 6.2 20 6.2 6.2 12.4 6.2 20 12.4 33.8 20 33.8zm0-26.3c6.9 0 12.5 5.6 12.5 12.5S26.9 32.5 20 32.5 7.5 26.9 7.5 20 13.1 7.5 20 7.5zm-.4 15h.5c1.8 0 3-1.1 3-3.7 0-2.2-1.1-3.6-3.1-3.6h-2.6v10.6h2.2v-3.3zm0-5.2h.4c.6 0 .9.5.9 1.7 0 1.1-.3 1.7-.9 1.7h-.4v-3.4z">
                                            </path>
                                        </svg>
                                    </li>
                                    <li class="">
                                        <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222"
                                            margin="5px">
                                            <path fill="currentColor"
                                                d="M30.2 29.3c2.2-2.5 3.6-5.7 3.6-9.3s-1.4-6.8-3.6-9.3l3.6-3.6c.3-.3.3-.7 0-.9-.3-.3-.7-.3-.9 0l-3.6 3.6c-2.5-2.2-5.7-3.6-9.3-3.6s-6.8 1.4-9.3 3.6L7.1 6.2c-.3-.3-.7-.3-.9 0-.3.3-.3.7 0 .9l3.6 3.6c-2.2 2.5-3.6 5.7-3.6 9.3s1.4 6.8 3.6 9.3l-3.6 3.6c-.3.3-.3.7 0 .9.1.1.3.2.5.2s.3-.1.5-.2l3.6-3.6c2.5 2.2 5.7 3.6 9.3 3.6s6.8-1.4 9.3-3.6l3.6 3.6c.1.1.3.2.5.2s.3-.1.5-.2c.3-.3.3-.7 0-.9l-3.8-3.6z">
                                            </path>
                                        </svg>
                                    </li>
                                    <li class="">
                                        <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222"
                                            margin="5px">
                                            <path fill="currentColor"
                                                d="M34.1 34.1H5.9V5.9h28.2v28.2zM7.2 32.8h25.6V7.2H7.2v25.6zm13.5-18.3a.68.68 0 0 0-.7-.7.68.68 0 0 0-.7.7v10.9a.68.68 0 0 0 .7.7.68.68 0 0 0 .7-.7V14.5z">
                                            </path>
                                        </svg>
                                    </li>
                                </ul>
                                <p class="text-center text-paragraph">LT01: 70% wool, 15% polyester, 10% polyamide, 5%
                                    acrylic 900 Grms/mt</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /tabs -->
    <!-- product -->
    <section class="flat-spacing-1 pt_0">
        <div class="container">
            <div class="flat-title">
                <span class="title">People Also Bought</span>
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
    <!-- /product -->
    <!-- recent -->
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
    <!-- /recent -->
@endsection
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
    <script>
   
    const colorInputs = document.querySelectorAll('input[name="color"]');
    const sizeInputs = document.querySelectorAll('input[name="size"]');
    const finalPrice = document.getElementById('final-price');
    const addToCartButton = document.querySelector('.btn-add-to-cart .tf-qty-price');

    function updatePrice() {
        let basePrice = {{ $product->price }};
        let additionalPrice = 0;

      
        colorInputs.forEach(input => {
            if (input.checked) {
                additionalPrice = parseFloat(input.dataset.price) || 0;
            }
        });

        
        const totalPrice = basePrice + additionalPrice;
        finalPrice.innerText = `$${totalPrice.toFixed(2)}`;
        addToCartButton.innerText = `$${totalPrice.toFixed(2)}`;
    }

    colorInputs.forEach(input => input.addEventListener('change', updatePrice));
    sizeInputs.forEach(input => input.addEventListener('change', updatePrice));
    $(document).ready(function() {
    


        document.getElementById('variant-select').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var basePrice = {{ $product->price }}; 
    var variantPrice = parseFloat(selectedOption.getAttribute('data-price')); 
    var totalPrice = basePrice + variantPrice; 

    
    document.getElementById('current-price').innerText = '$' + totalPrice.toFixed(2);
    
    
    var color = selectedOption.getAttribute('data-color');
    var size = selectedOption.getAttribute('data-size');
    document.getElementById('selected-color').innerText = color;
    document.getElementById('selected-size').innerText = size;
});
const maxQuantity = {{ $total_stock_quantity }};

    function changeQuantity(delta) {
        const quantityInput = document.getElementById('quantity-input');
        let currentQuantity = parseInt(quantityInput.value);

        currentQuantity += delta;

        
        if (currentQuantity < 1) {
            currentQuantity = 1; 
        } else if (currentQuantity > maxQuantity) {
            currentQuantity = maxQuantity; 
        }

        quantityInput.value = currentQuantity;
    }
});


</script>
@endsection
