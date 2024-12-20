<div class="tf-product-info-item">
    <div class="image">
        @foreach ($randomImages as $colorId => $image)
            @if ($image)
                <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $product->product_name }}"
                    class="product-image" data-color-id="{{ $colorId }}"
                    style="{{ $loop->first ? 'display: block;' : 'display: none;' }}">
            @endif
        @endforeach
    </div>

    <div class="content">
        <a href="product-detail.html">{{ $product->product_name }}</a>
        <div class="tf-product-info-price">
            <!-- <div class="price-on-sale">$8.00</div>
            <div class="compare-at-price">$10.00</div>
            <div class="badges-on-sale"><span>20</span>% OFF</div> -->
            <div class="price-product">{{ $product->price }} VNĐ</div>
        </div>
    </div>
</div>

<div class="tf-product-info-variant-picker mb_15">
    <div class="variant-picker-item">
        <div class="variant-picker-label">
            <div class="variant-picker-label">
                Màu sắc: <span class="fw-6 variant-picker-label-value" id="selected-color">Không </span>
            </div>
        </div>
        <div class="variant-picker-values">
            @foreach ($product->colors as $color)
                <input id="values-{{ $color->name }}" type="radio" name="color" class="btn-color"
                    data-color-id="{{ $color->id }}" data-color-name="{{ $color->name }}"
                    {{ $loop->first ? 'checked' : '' }}>
                <label class="hover-tooltip radius-60" for="values-{{ $color->name }}"
                    data-value="{{ $color->name }}">
                    <span class="btn-checkbox" style="background-color: {{ $color->sku_color }}"></span>
                    <span class="tooltip">{{ $color->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="variant-picker-item">
        <div class="variant-picker-label">
            Kích thước: <span class="fw-6 variant-picker-label-value" id="selected-size">Không </span>
        </div>
        <div class="variant-picker-values" id="size-options-container">
            <!-- Các kích thước sẽ được thêm vào đây bằng JavaScript khi chọn màu -->
        </div>
    </div>
</div>

<div class="tf-product-info-quantity mb_15">
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
            class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart"><span>Thêm vào giỏ -&nbsp;</span><span class="tf-qty-price"
                data-price="{{ $product->price }}">{{ $product->price }} VNĐ</span></a>
        <div class="tf-product-btn-wishlist btn-icon-action">
            <i class="icon-heart"></i>
            <i class="icon-delete"></i>
        </div>
        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
            class="tf-product-btn-wishlist box-icon bg_white compare btn-icon-action">
            <span class="icon icon-compare"></span>
            <span class="icon icon-check"></span>
        </a>
        <div class="w-100">
            <a href="#" class="btns-full">Mua với <img src="/storage/uploads/vnpay-logo-inkythuatso__2_-01-removebg-preview.png" alt="" style="max-width: 100px;"></a>
            <a href="#" class="payment-more-option">Nhiều lựa chọn hơn</a>
        </div>
    </form>
</div>


<script>
    $(document).ready(function() {
        // Khi người dùng chọn màu
        $('.btn-color').click(function() {
            var colorName = $(this).data('color-name');
            var selectedColorId = $(this).data('color-id');

            // Cập nhật màu sắc đã chọn
            $('#selected-color').text(colorName);

            // Ẩn tất cả ảnh và chỉ hiển thị ảnh của màu đã chọn
            $('.product-image').hide();
            $('.product-image[data-color-id="' + selectedColorId + '"]').show();

            // Cập nhật các kích thước tương ứng với màu được chọn
            updateSizeOptions(selectedColorId);
        });

        // Mặc định màu sắc và ảnh khi tải trang
        var defaultColorId = $('.btn-color:checked').data('color-id');
        $('#selected-color').text($('.btn-color:checked').data('color-name'));
        $('.product-image[data-color-id="' + defaultColorId + '"]').show();
        updateSizeOptions(defaultColorId);

        // Sự kiện thay đổi kích thước
        $('.btn-size').click(function() {
            var sizeName = $(this).data('size-name');
            $('#selected-size').text(sizeName);

            // Cập nhật lại giá sau khi chọn kích thước
            updateTotalPrice();
        });

        // Xử lý số lượng sản phẩm
        $('.btn-quantity').click(function(e) {
            e.preventDefault();
            var $input = $(this).closest("div").find("input");
            var currentValue = parseInt($input.val());
            var newValue = $(this).hasClass("minus-btn") ? Math.max(1, currentValue - 1) :
                currentValue + 1;
            $input.val(newValue);
            updateTotalPrice();
        });

        // Kiểm tra số lượng nhập vào
        $('input[name="quantity_product"]').on('input', function() {
            var quantity = $(this).val();
            if (!$.isNumeric(quantity) || quantity <= 0) {
                alert('Số lượng phải là số nguyên');
                $(this).val(1);
            }
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
                        toastr.error('Thêm giỏ hàng thất bại!', 'Cảnh báo');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Thêm giỏ hàng thất bại!', 'Cảnh báo');
                    // console.error('Lỗi Ajax:', error);
                    // console.log(xhr.responseText);
                }
            });
        });

        // Cập nhật giá trị tổng tiền
        function updateTotalPrice() {
            var quantity = parseInt($('input[name="quantity_product"]').val()) || 0;
            var priceBonus = parseFloat($('input.btn-size:checked').data('size-price')) || 0;
            var productPrice = parseFloat($('.tf-qty-price').data('price')) || 0;
            var totalPrice = (productPrice + priceBonus) * quantity;
            var price = productPrice + priceBonus;

            $('.tf-qty-price').text(`${totalPrice} VNĐ`);
            $('.price-product').text(`${price} VNĐ`);
        }

        // Cập nhật kích thước cho màu đã chọn
        function updateSizeOptions(colorId) {
            var sizeOptions = @json($colorSizes); // Lấy dữ liệu kích thước cho mỗi màu
            var sizes = sizeOptions[colorId] || [];

            var sizeContainer = $('#size-options-container');
            sizeContainer.empty();

            sizes.forEach(function(sizeInfo, index) {
                if (index === 0) {
                    $('#selected-size').text(sizeInfo.size.name);
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
    });
</script>