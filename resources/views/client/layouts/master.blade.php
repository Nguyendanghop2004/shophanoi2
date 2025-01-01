<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Ecomus - Ultimate HTML</title>

    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- font -->
    <link rel="stylesheet" href="{{ asset('client/assets/fonts/fonts.css') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('client/assets/fonts/font-icons.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-B+1K+q+czpOjPvMI5DjwukDqa8GdHsO6IMB+CHCaDeFE64ct5LKfHEJ87rXT2y7I5GpqHgExGzxt9QZ8clUBiA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('client/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/assets/css/animate.css') }}">
    <link rel="stylesheet"type="text/css" href="{{ asset('client/assets/css/styles.css') }}" />
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{ asset('client/assets/images/logo/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('client/assets/images/logo/favicon.png') }}">

</head>

<body class="preload-wrapper">
    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div id="wrapper">
        @yield('topbar')
        @hasSection('header-home')
            @yield('header-home')
        @else
            <!-- Header mặc định cho các trang khác -->
            @include('client.layouts.particals.header-default')
        @endif

        @yield('content')
        <!-- /categories -->

        <!-- footer -->
        @include('client.layouts.particals.footer')
        <!-- /footer -->

    </div>
    @yield('product-detail')
    <!-- gotop -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;">
            </path>
        </svg>
    </div>
    <!-- /gotop -->

    <!-- toolbar-bottom mobile-->
    @include('client.layouts.components.mobile.tool-bar-bot-mobile')
    <!-- /toolbar-bottom -->

    <!-- mobile menu -->
    @include('client.layouts.components.mobile.menu-mobile')
    <!-- /mobile menu -->

    <!-- canvasSearch -->
    @include('client.layouts.components.modal.canvas-search')
    <!-- /canvasSearch -->

    <!-- toolbarShopmb mobile-->
    @include('client.layouts.components.mobile.tool-bar-mobile')
    <!-- /toolbarShopmb -->

    <!-- modal login -->
    @include('client.layouts.components.modal.modal-login')
    <!-- /modal login -->

    <!-- shoppingCart -->
    @include('client.layouts.components.modal.shopping-cart')
    <!-- /shoppingCart -->

    <!-- modal compare -->
    @include('client.layouts.components.modal.modal-compare')
    <!-- /modal compare -->

    <!-- modal quick_add -->
    @include('client.layouts.components.modal.modal-quick-add')
    <!-- /modal quick_add -->

    <!-- modal quick_view -->
    @include('client.layouts.components.modal.modal-quick-view')
    <!-- /modal quick_view -->

    <!-- modal find_size -->
    @include('client.layouts.components.modal.modal-fine-size')
    <!-- /modal find_size -->

    <!-- Javascript -->
    <script type="text/javascript" src="{{ asset('client/assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/lazysize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/count-down.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/multiple-modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/main.js') }}"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- cấu hình cơ bản toastr --}}
    <script>
        // Cấu hình tùy chỉnh toastr (tùy chọn)
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
    @stack('scripts')

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
                const productDetailUrl = `/product/${item.slug}`;
                modalCartContainer.append(`
                                    <div class="tf-mini-cart-item">
                                        <div class="tf-mini-cart-image">
                                            <a href="${productDetailUrl}">
                                                <img src="/storage/${item.image_url}" alt="">
                                            </a>
                                        </div>
                                        <div class="tf-mini-cart-info">
                                            <a class="title link"
                                                href="${productDetailUrl}">${item.product_name}</a>
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
    
</body>

</html>
