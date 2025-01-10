<div class="tf-product-media-wrap">
    <div class="swiper tf-single-slide">
        <div class="swiper-wrapper">
            @foreach ($product->images as $image)
                <div class="swiper-slide">
                    <div class="item">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next button-style-arrow single-slide-prev"></div>
        <div class="swiper-button-prev button-style-arrow single-slide-next"></div>
    </div>
</div>
<div class="tf-product-info-wrap position-relative">
    <div class="tf-product-info-list">
        <div class="tf-product-info-title">
            <h5><a class="link" href="{{ route('product-detail', $product->slug) }}">{{ $product->product_name }}</a>
            </h5>
        </div>
        {{-- <div class="tf-product-info-badges">   
            <div class="badges text-uppercase">Best seller</div>
            <div class="product-status-content">
                <i class="icon-lightning"></i>
                <p class="fw-6">Selling fast! 48 people have this in their carts.</p>
            </div>
        </div> --}}
        <div class="tf-product-info-price">
            @if ($product->sale_price < $product->price)
                <span class="sale-price">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                <span class="original-price" style="text-decoration: line-through; color: #888;">
                    {{ number_format($product->price, 0, ',', '.') }} VNĐ
                </span>
            @else
                <span class="regular-price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
            @endif
        </div>
        <div class="tf-product-description">
            <p>{{ $product->short_description }}</p>
        </div>
        <div class="tf-product-info-variant-picker">
            <div class="variant-picker-item">
                <div class="variant-picker-label">
                    Màu sắc: <span class="fw-6 variant-picker-label-value selected-color">Không có</span>
                </div>
                <div class="variant-picker-values">
                    @foreach ($product->colors as $color)
                        <input id="values-{{ $color->name }}" type="radio" name="color-1" class="btn-color"
                            data-color-id="{{ $color->id }}" data-color-name="{{ $color->name }}"
                            {{ $loop->first ? 'checked' : '' }}>
                        <label class="hover-tooltip
                            radius-60"
                            for="values-{{ $color->name }}" data-value="{{ $color->name }}">
                            <span class="btn-checkbox" style="background-color: {{ $color->sku_color }}"></span>
                            <span class="tooltip">{{ $color->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="variant-picker-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="variant-picker-label">
                        Kích thước: <span class="fw-6 variant-picker-label-value selected-size">Không có</span>
                    </div>
                    <div class="find-size btn-choose-size fw-6">Tìm Kiếm Kích Thước Dành Cho Bạn</div>
                </div>
                <div class="variant-picker-values" id="size-options-container">
                    <!-- Các kích thước sẽ được thêm vào đây bằng JavaScript khi chọn màu -->
                </div>
            </div>
        </div>
        <div class="tf-product-info-quantity">
            <div class="quantity-title fw-6">Số lượng</div>
            <div class="wg-quantity">
                <span class="btn-quantity minus-btn">-</span>
                <input type="text" name="quantity_product" value="1">
                <span class="btn-quantity plus-btn">+</span>
            </div>
        </div>
        <div class="tf-product-info-buy-button">
            <form class="">
                <a href="javascript:void(0);"
                    class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart"><span>Thêm
                        vào giỏ -&nbsp;<span class="tf-qty-price" data-price="{{ $product->price }}"
                            data-sale-price="{{ isset($product->sale_price) && $product->sale_price < $product->price ? $product->sale_price : $product->price }}">
                            {{ number_format(isset($product->sale_price) && $product->sale_price < $product->price ? $product->sale_price : $product->price, 0, ',', '.') }}
                            VNĐ
                        </span>
                </a>
                <a href="javascript:void(0);"
                    class="tf-product-btn-wishlist hover-tooltip box-icon bg_white wishlist btn-icon-action">
                    <span class="icon icon-heart"></span>
                    <span class="tooltip">Add to Wishlist</span>
                    <span class="icon icon-delete"></span>
                </a>
                {{-- <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                    class="tf-product-btn-wishlist hover-tooltip box-icon bg_white compare btn-icon-action">
                    <span class="icon icon-compare"></span>
                    <span class="tooltip">Add to Compare</span>
                    <span class="icon icon-check"></span>
                </a> --}}
            </form>
        </div>
        <div>
            <a href="{{ route('product-detail', $product->slug) }}" class="tf-btn fw-6 btn-line">Chi Tiết<i
                    class="icon icon-arrow1-top-left"></i></a>
        </div>
    </div>
</div>


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

        
        $('.find-size').click(function() {
            $("#find_size").modal("show");
        });

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
                        updateCartCount();
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
            $('.tf-qty-price').text(`${totalPrice.toLocaleString('vi-VN')} VNĐ`);
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

            $(".minus-btn").on("click", function(e) {
                e.preventDefault();
                var $this = $(this);
                var $input = $this.closest("div").find("input");
                var value = validateValue($input);

                if (value > 1) {
                    $input.val(value - 1);
                }

                updateTotalPrice();
            });

            $(".plus-btn").on("click", function(e) {
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
