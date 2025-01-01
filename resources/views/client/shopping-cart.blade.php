@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection
@section('content')
    @include('client.layouts.particals.page-title')
<style>
    a[disabled] {
    pointer-events: none;
    cursor: not-allowed;
    opacity: 0.5;
}
</style>
    <!-- page-cart -->
    <section class="flat-spacing-11">
        <div class="container">
            <!-- <div class="tf-page-cart text-center mt_140 mb_200">
                                                                <h5 class="mb_24">Your cart is empty</h5>
                                                                <p class="mb_24">You may check out all the available products and buy some in the shop</p>
                                                                <a href="shop-default.html" class="tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn">Return to shop<i class="icon icon-arrow1-top-left"></i></a>
                                                            </div> -->
                                                        
            <div class="tf-page-cart-wrap">
                <div class="tf-page-cart-item">
                   
                        <table class="tf-table-page-cart">
                            <thead>
                                <tr>
                             
                                    <th>Tên Sản Phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
            $totalCart = 0;
        @endphp
    @if (count($cartDetails) > 0)
       
        @foreach ($cartDetails as $item)
            @php
                $totalCart += (int) $item['quantity'] * (float) $item['subtotal'];
            @endphp
            <tr class="tf-cart-item file-delete">
              
                <td class="tf-cart-item_product">
                    <a href="product-detail.html" class="img-box">
                        <img src="{{ asset('storage/' . $item['image_url']) }}" alt="img-product">
                    </a>
                    <div class="cart-info">
                        <a href="product-detail.html" class="cart-title link">{{ $item['product_name'] }}</a>
                        <div class="cart-meta-variant">{{ $item['color_name'] }} / {{ $item['size_name'] }}</div>
                        <span class="remove-cart link remove" onclick="removeFromCart({{ $item['product_id'] }}, {{ $item['color_id'] }}, {{ $item['size_id'] }})">Remove</span>
                    </div>
                </td>
                <td class="tf-cart-item_price" cart-data-title="Price">
                    <div class="cart-price">{{ number_format($item['subtotal'], 0, ',', '.') }} VNĐ</div>
                </td>
                <td class="tf-cart-item_quantity" cart-data-title="Quantity">
                    <div class="cart-quantity">
                        <div class="wg-quantity">

                            <span class="btn-quantity minus-btn-cart-2" data-url="{{ route('cart.update') }}" data-id="{{ $item['product_id'] }}" data-color="{{ $item['color_id'] }}" data-size="{{ $item['size_id'] }}">
                                <svg class="d-inline-block" width="9" height="1" viewBox="0 0 9 1" fill="currentColor">
                                    <path d="M9 1H5.14286H3.85714H0V1.50201e-05H3.85714L5.14286 0L9 1.50201e-05V1Z"></path>
                                </svg>
                            </span>
                            <input type="text" class="quantity-input quantity-input-update" name="number" value="{{ $item['quantity'] }}" data-url="{{ route('cart.update') }}" data-id="{{ $item['product_id'] }}" data-color="{{ $item['color_id'] }}" data-size="{{ $item['size_id'] }}">

                            <span class="btn-quantity plus-btn-cart-2" data-url="{{ route('cart.update') }}" data-id="{{ $item['product_id'] }}" data-color="{{ $item['color_id'] }}" data-size="{{ $item['size_id'] }}">
                                <svg class="d-inline-block" width="9" height="9" viewBox="0 0 9 9" fill="currentColor">
                                    <path d="M9 5.14286H5.14286V9H3.85714V5.14286H0V3.85714H3.85714V0H5.14286V3.85714H9V5.14286Z"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </td>
                <td class="tf-cart-item_total" cart-data-title="Total">
                    <div class="cart-total" data-price="{{ $item['subtotal'] }}">
                        {{ number_format((int) $item['quantity'] * (float) $item['subtotal'], 0, ',', '.') }} VNĐ
                    </div>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" class="text-center">
                <p class="text-muted">Giỏ hàng của bạn đang trống. </p>
            </td>
        </tr>
    @endif
</tbody>

                        </table>
                       
                  
                </div>
                <div class="tf-page-cart-footer">
    <div class="tf-cart-footer-inner">
        <div class="tf-page-cart-checkout">
            <div class="tf-cart-totals-discounts">
                <h3>Tổng Tiền</h3>
                <span class="total-value">{{ number_format($totalCart, 0, ',', '.') }} VNĐ</span>
               
            </div>
          
            <div class="cart-checkbox">
    <input type="checkbox" class="tf-check" id="check-agree" required>
    <label for="check-agree" class="fw-4">
        Tôi đồng ý với các <a href="terms-conditions.html">điều khoản và điều kiện</a> 
    </label>
</div>
<div class="cart-checkout-btn">
    <a href="{{ count($cartDetails) === 0 ? 'javascript:void(0);' : route('checkout') }}" 
       class="tf-btn w-100 btn-fill animate-hover-btn radius-3 justify-content-center"
       {{ count($cartDetails) === 0 ? 'disabled' : '' }}>
        <span>Tiến hành Đặt Hàng</span>
    </a>
</div>
<br>
<div class="cart-continue-btn">
                <a href="{{ route('home') }}" class="tf-btn w-100 btn-outline animate-hover-btn radius-3 justify-content-center">
                    <span>Tiếp Tục Mua Hàng</span>
                </a>
            </div>
            <div class="tf-page-cart_imgtrust">
                <p class="text-center fw-6">Đảm bảo thanh toán an toàn</p>
                <div class="cart-list-social">
                    <div class="payment-item">
                        <svg viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" role="img" width="38" height="24" aria-labelledby="pi-visa">
                            <title id="pi-visa">Visa</title>
                            <path opacity=".07"
                                            d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z">
                                        </path>
                                        <path fill="#fff"
                                            d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32">
                                        </path>
                                        <path
                                            d="M28.3 10.1H28c-.4 1-.7 1.5-1 3h1.9c-.3-1.5-.3-2.2-.6-3zm2.9 5.9h-1.7c-.1 0-.1 0-.2-.1l-.2-.9-.1-.2h-2.4c-.1 0-.2 0-.2.2l-.3.9c0 .1-.1.1-.1.1h-2.1l.2-.5L27 8.7c0-.5.3-.7.8-.7h1.5c.1 0 .2 0 .2.2l1.4 6.5c.1.4.2.7.2 1.1.1.1.1.1.1.2zm-13.4-.3l.4-1.8c.1 0 .2.1.2.1.7.3 1.4.5 2.1.4.2 0 .5-.1.7-.2.5-.2.5-.7.1-1.1-.2-.2-.5-.3-.8-.5-.4-.2-.8-.4-1.1-.7-1.2-1-.8-2.4-.1-3.1.6-.4.9-.8 1.7-.8 1.2 0 2.5 0 3.1.2h.1c-.1.6-.2 1.1-.4 1.7-.5-.2-1-.4-1.5-.4-.3 0-.6 0-.9.1-.2 0-.3.1-.4.2-.2.2-.2.5 0 .7l.5.4c.4.2.8.4 1.1.6.5.3 1 .8 1.1 1.4.2.9-.1 1.7-.9 2.3-.5.4-.7.6-1.4.6-1.4 0-2.5.1-3.4-.2-.1.2-.1.2-.2.1zm-3.5.3c.1-.7.1-.7.2-1 .5-2.2 1-4.5 1.4-6.7.1-.2.1-.3.3-.3H18c-.2 1.2-.4 2.1-.7 3.2-.3 1.5-.6 3-1 4.5 0 .2-.1.2-.3.2M5 8.2c0-.1.2-.2.3-.2h3.4c.5 0 .9.3 1 .8l.9 4.4c0 .1 0 .1.1.2 0-.1.1-.1.1-.1l2.1-5.1c-.1-.1 0-.2.1-.2h2.1c0 .1 0 .1-.1.2l-3.1 7.3c-.1.2-.1.3-.2.4-.1.1-.3 0-.5 0H9.7c-.1 0-.2 0-.2-.2L7.9 9.5c-.2-.2-.5-.5-.9-.6-.6-.3-1.7-.5-1.9-.5L5 8.2z"
                                            fill="#142688"></path>
                        </svg>
                    </div>
                    <div class="payment-item">
                        <svg viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" width="38" height="24" role="img" aria-labelledby="pi-paypal">
                            <title id="pi-paypal">PayPal</title>
                            <path opacity=".07"
                                            d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z">
                                        </path>
                                        <path fill="#fff"
                                            d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32">
                                        </path>
                                        <path fill="#003087"
                                            d="M23.9 8.3c.2-1 0-1.7-.6-2.3-.6-.7-1.7-1-3.1-1h-4.1c-.3 0-.5.2-.6.5L14 15.6c0 .2.1.4.3.4H17l.4-3.4 1.8-2.2 4.7-2.1z">
                                        </path>
                                        <path fill="#3086C8"
                                            d="M23.9 8.3l-.2.2c-.5 2.8-2.2 3.8-4.6 3.8H18c-.3 0-.5.2-.6.5l-.6 3.9-.2 1c0 .2.1.4.3.4H19c.3 0 .5-.2.5-.4v-.1l.4-2.4v-.1c0-.2.3-.4.5-.4h.3c2.1 0 3.7-.8 4.1-3.2.2-1 .1-1.8-.4-2.4-.1-.5-.3-.7-.5-.8z">
                                        </path>
                                        <path fill="#012169"
                                            d="M23.3 8.1c-.1-.1-.2-.1-.3-.1-.1 0-.2 0-.3-.1-.3-.1-.7-.1-1.1-.1h-3c-.1 0-.2 0-.2.1-.2.1-.3.2-.3.4l-.7 4.4v.1c0-.3.3-.5.6-.5h1.3c2.5 0 4.1-1 4.6-3.8v-.2c-.1-.1-.3-.2-.5-.2h-.1z">
                                        </path>
                        </svg>
                    </div>
                    <div class="payment-item">
                        <svg viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" role="img" width="38" height="24" aria-labelledby="pi-master">
                            <title id="pi-master">Mastercard</title>
                            <path opacity=".07"
                                            d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z">
                                        </path>
                                        <path fill="#fff"
                                            d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32">
                                        </path>
                                        <circle fill="#EB001B" cx="15" cy="12" r="7"></circle>
                                        <circle fill="#F79E1B" cx="23" cy="12" r="7"></circle>
                                        <path fill="#FF5F00"
                                            d="M22 12c0-2.4-1.2-4.5-3-5.7-1.8 1.3-3 3.4-3 5.7s1.2 4.5 3 5.7c1.8-1.2 3-3.3 3-5.7z">
                                        </path>
                        </svg>
                    </div>
                    <div class="payment-item">
                        <svg xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="pi-american_express" viewBox="0 0 38 24" width="38" height="24">
                            <title id="pi-american_express">American Express</title>
                            <path fill="#000"
                                            d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3Z"
                                            opacity=".07"></path>
                                        <path fill="#006FCF"
                                            d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32Z">
                                        </path>
                                        <path fill="#FFF"
                                            d="M22.012 19.936v-8.421L37 11.528v2.326l-1.732 1.852L37 17.573v2.375h-2.766l-1.47-1.622-1.46 1.628-9.292-.02Z">
                                        </path>
                                        <path fill="#006FCF"
                                            d="M23.013 19.012v-6.57h5.572v1.513h-3.768v1.028h3.678v1.488h-3.678v1.01h3.768v1.531h-5.572Z">
                                        </path>
                                        <path fill="#006FCF"
                                            d="m28.557 19.012 3.083-3.289-3.083-3.282h2.386l1.884 2.083 1.89-2.082H37v.051l-3.017 3.23L37 18.92v.093h-2.307l-1.917-2.103-1.898 2.104h-2.321Z">
                                        </path>
                                        <path fill="#FFF"
                                            d="M22.71 4.04h3.614l1.269 2.881V4.04h4.46l.77 2.159.771-2.159H37v8.421H19l3.71-8.421Z">
                                        </path>
                                        <path fill="#006FCF"
                                            d="m23.395 4.955-2.916 6.566h2l.55-1.315h2.98l.55 1.315h2.05l-2.904-6.566h-2.31Zm.25 3.777.875-2.09.873 2.09h-1.748Z">
                                        </path>
                                        <path fill="#006FCF"
                                            d="M28.581 11.52V4.953l2.811.01L32.84 9l1.456-4.046H37v6.565l-1.74.016v-4.51l-1.644 4.494h-1.59L30.35 7.01v4.51h-1.768Z">
                                        </path>
                        </svg>
                    </div>
                    <div class="payment-item">
                        <svg xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 38 24" width="38" height="24" aria-labelledby="pi-amazon">
                            <title id="pi-amazon">Amazon</title>
                            <path
                                            d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"
                                            fill="#000" fill-rule="nonzero" opacity=".07"></path>
                                        <path
                                            d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"
                                            fill="#FFF" fill-rule="nonzero"></path>
                                        <path
                                            d="M25.26 16.23c-1.697 1.48-4.157 2.27-6.275 2.27-2.97 0-5.644-1.3-7.666-3.463-.16-.17-.018-.402.173-.27 2.183 1.504 4.882 2.408 7.67 2.408 1.88 0 3.95-.46 5.85-1.416.288-.145.53.222.248.47v.001zm.706-.957c-.216-.328-1.434-.155-1.98-.078-.167.024-.193-.148-.043-.27.97-.81 2.562-.576 2.748-.305.187.272-.047 2.16-.96 3.063-.14.138-.272.064-.21-.12.205-.604.664-1.96.446-2.29h-.001z"
                                            fill="#F90" fill-rule="nonzero"></path>
                                        <path
                                            d="M21.814 15.291c-.574-.498-.676-.73-.993-1.205-.947 1.012-1.618 1.315-2.85 1.315-1.453 0-2.587-.938-2.587-2.818 0-1.467.762-2.467 1.844-2.955.94-.433 2.25-.51 3.25-.628v-.235c0-.43.033-.94-.208-1.31-.212-.333-.616-.47-.97-.47-.66 0-1.25.353-1.392 1.085-.03.163-.144.323-.3.33l-1.677-.187c-.14-.033-.296-.153-.257-.38.386-2.125 2.223-2.766 3.867-2.766.84 0 1.94.234 2.604.9.842.82.762 1.918.762 3.11v2.818c0 .847.335 1.22.65 1.676.113.164.138.36-.003.482-.353.308-.98.88-1.326 1.2a.367.367 0 0 1-.414.038zm-1.659-2.533c.34-.626.323-1.214.323-1.918v-.392c-1.25 0-2.57.28-2.57 1.82 0 .782.386 1.31 1.05 1.31.487 0 .922-.312 1.197-.82z"
                                            fill="#221F1F"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            </div>
            </form>
        </div>
    </section>
    <section class="flat-spacing-15 pb_0">
        <div class="container">
            <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                <span class="title">Sản Phẩm Liên Quan</span>
              
            </div>
            <div class="hover-sw-nav hover-sw-3">
                <div class="swiper tf-sw-product-sell wrap-sw-over" data-preview="4" data-tablet="3" data-mobile="2"
                    data-space-lg="30" data-space-md="15" data-pagination="2" data-pagination-md="3" data-pagination-lg="3">
                    <div class="swiper-wrapper">

                        @foreach ($products as $product)
                            <div class="swiper-slide" lazy="true">
                                <div class="card-product">
                                    <div class="card-product-wrapper">
                                        <a href="{{route('product-detail',$product['slug'])}}" class="product-img">
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
                                            <a href="#quick_add" data-bs-toggle="modal"
                                                data-product-id="{{ $product['id'] }}"
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
                                            <span>{{ $product['distinct_size_count'] }} sizes available</span>
                                        </div>
                                    </div>
                                    <div class="card-product-info">
                                        <a href="{{route('product-detail',$product['slug'])}}" class="title link">{{ $product['name'] }}</a>
                                        <span class="price">${{ $product['price'] }}</span>
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
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
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
    function updateCartTotal() {
        $('.tf-cart-item').each(function() {
            var cartTotalDiv = $(this).find('.cart-total');
            var price = parseFloat(cartTotalDiv.data('price'));
            var quantity = $(this).find('.quantity-input-update').val();
            console.log(quantity);

            // Tính toán lại subtotal
            var subtotal = price * quantity;

            // Định dạng lại subtotal (thêm dấu phân cách hàng nghìn và tiền tệ)
            var formattedSubtotal = subtotal.toLocaleString('vi-VN') + ' VND';

            // Cập nhật giá trị subtotal cho mỗi sản phẩm
            cartTotalDiv.text(formattedSubtotal);
        });
    }

    function removeFromCart(productId, colorId, sizeId) {
        console.log("Input data:", { product_id: productId, color_id: colorId, size_id: sizeId });
        $.ajax({
            url: '/remove-from-cart',
            method: 'POST',
            data: {
                product_id: productId,
                color_id: colorId,
                size_id: sizeId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    console.log("Response:", response);
                    alert(response.message);
                    updateCartTotal(); // Cập nhật lại giỏ hàng
                } else {
                    console.error("Failed to remove product:", response);
                    alert('Failed to remove product from cart');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error, xhr.responseText);
                alert('There was an error processing your request.');
            }
        });
    }

    $(document).ready(function() {
        let debounceTimer;

        function updateQuantity(productId, colorId, sizeId, newQuantity, url, inputField) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    product_id: productId,
                    color_id: colorId,
                    size_id: sizeId,
                    quantity: newQuantity
                },
                success: function(response) {
                    if (response.success) {
                        updateCartTotal();
                        console.log('Cập nhật thành công');
                    } else {
                        // Nếu số lượng không hợp lệ, quay lại giá trị cũ
                        inputField.val(inputField.data('oldQuantity'));
                        alert(response.message || 'Đã xảy ra lỗi!');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Không thể cập nhật số lượng. Vui lòng thử lại!');
                }
            });
        }

        $(document).off('click', '.btn-quantity').on('click', '.btn-quantity', function(e) {
            e.preventDefault();

            let button = $(this);
            let inputField = button.siblings('.quantity-input');
            let productId = button.data('id');
            let colorId = button.data('color');
            let sizeId = button.data('size');
            let url = button.data('url');
            let currentQuantity = parseInt(inputField.val()) || 1;

            // Lưu lại giá trị hiện tại trước khi thay đổi
            inputField.data('oldQuantity', currentQuantity);

            if (button.hasClass('plus-btn-cart-2')) {
                currentQuantity += 1;
            } else if (button.hasClass('minus-btn-cart-2') && currentQuantity > 1) {
                currentQuantity -= 1;
            }

            inputField.val(currentQuantity);

            // Gửi AJAX cập nhật sau khi debounce
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                updateQuantity(productId, colorId, sizeId, currentQuantity, url, inputField);
            }, 500); // 500ms debounce
        });

        // $(document).off('change', '.quantity-input').on('change', '.quantity-input', function() {
        //     let inputField = $(this);
        //     let productId = inputField.data('id');
        //     let colorId = inputField.data('color');
        //     let sizeId = inputField.data('size');
        //     let url = inputField.data('url');
        //     let newQuantity = parseInt(inputField.val()) || 1;

        //     // Lưu lại giá trị cũ trước khi thay đổi
        //     inputField.data('oldQuantity', newQuantity);

        //     if (newQuantity < 1) {
        //         newQuantity = 1;
        //         inputField.val(newQuantity);
        //     }

        //     // Gửi AJAX cập nhật sau khi debounce
        //     clearTimeout(debounceTimer);
        //     debounceTimer = setTimeout(function() {
        //         updateQuantity(productId, colorId, sizeId, newQuantity, url, inputField);
        //     }, 500);
        // });
    });
</script>

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
@endpush

