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
            <div class="price ">${{ number_format($product->price, 2) }}</div>
        </div>
    </div>
</div>
<div class="tf-product-info-variant-picker mb_15">
    <div class="variant-picker-item">
        <div class="variant-picker-label">
            <div class="variant-picker-label">
                Màu sắc: <span class="fw-6 variant-picker-label-value" id="selected-color">Mặc Định</span>
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
            Kích thước: <span class="fw-6 variant-picker-label-value" id="selected-size">Chưa Chọn</span>
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
            class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart"><span>Add
                to cart -&nbsp;</span><span class="tf-qty-price"
                data-price="{{ $product->price }}">${{ number_format($product->price, 2) }}</span></a>
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
            <a href="#" class="btns-full">Buy with <img src="images/payments/paypal.png" alt=""></a>
            <a href="#" class="payment-more-option">More payment options</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Khi người dùng chọn màu
        $('.btn-color').click(function() {
            var colorName = $(this).data('color-name');
            $('#selected-color').text(colorName);
            var selectedColorId = $(this).data('color-id');

            // Ẩn tất cả ảnh và chỉ hiển thị ảnh của màu đã chọn
            $('.product-image').hide();
            $('.product-image[data-color-id="' + selectedColorId + '"]').show();

            // Cập nhật các kích thước tương ứng với màu được chọn
            updateSizeOptions(selectedColorId);

            $('.btn-size').click(function() {
                var sizeName = $(this).data('size-name');
                $('#selected-size').text(sizeName);

            });
        });

        // Hiển thị màu và ảnh mặc định khi tải trang
        var defaultColorId = $('.btn-color:checked').data('color-id');
        $('#selected-color').text($('.btn-color:checked').data('color-name'));
        $('.product-image[data-color-id="' + defaultColorId + '"]').show();

        // Hiển thị kích thước mặc định của màu đầu tiên
        updateSizeOptions(defaultColorId);

        $('.btn-size').click(function() {
            var sizeName = $(this).data('size-name');
            $('#selected-size').text(sizeName);
        });
    });

    // Hàm cập nhật các kích thước tương ứng với màu được chọn
    function updateSizeOptions(colorId) {
        var sizeOptions = @json($colorSizes); // Lấy dữ liệu từ server (size của các màu)
        var sizes = sizeOptions[colorId] || [];

        var sizeContainer = $('#size-options-container');
        sizeContainer.empty(); // Xóa các size cũ

        sizes.forEach(function(sizeInfo, index) { // Thêm tham số index
            if (index === 0) {
                $('#selected-size').text(sizeInfo.size.name);
            }

            var sizeElement = `
                  <input type="radio" class="btn-size" name="size" id="values-${sizeInfo.size.name}-${colorId}" data-size-name="${sizeInfo.size.name}" data-size-id="${sizeInfo.size.id}"
                  data-size-price="${sizeInfo.price}" ${index === 0 ? 'checked' : ''}>
                  <label class="style-text" for="values-${sizeInfo.size.name}-${colorId}" data-value="${sizeInfo.size.name}">
                  <p>${sizeInfo.size.name}</p>
                  </label>
                  `;
            sizeContainer.append(sizeElement); // Thêm các size vào container
        });
        updateTotalPrice();
           // Lắng nghe sự kiện thay đổi của các nút radio
    $('input.btn-size').on('change', function() {
        updateTotalPrice(); // Cập nhật giá trị khi lựa chọn thay đổi
    });
    }
</script>

<script>
    $('input[name="quantity_product"]').on('input', function() {
        var quantity = $(this).val();
        if (!$.isNumeric(quantity) || quantity <= 0) {
            alert('Số lượng phải là số nguyên');
            $(this).val(1);
        }
    });

    $('.btn-add-to-cart').click(function(e) {
        e.preventDefault();

        var productId = {{ $product->id }}; // ID sản phẩm
        var colorId = $('.btn-color:checked').data('color-id'); // ID màu sắc đã chọn
        var sizeId = $('input[name="size"]:checked').data('size-id'); // Kích thước đã chọn
        var quantity = $('input[name="quantity_product"]').val(); // Số lượng

        // Kiểm tra xem tất cả thông tin có hợp lệ không
        if (!sizeId) {
            alert('Vui lòng chọn kích thước!');
            return;
        }

        // Gửi yêu cầu Ajax đến route xử lý thêm vào giỏ hàng
        $.ajax({
            url: '/add-to-cart',
            type: 'POST',
            data: {
                product_id: productId,
                color_id: colorId,
                size_id: sizeId,
                quantity: quantity,

                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            },
            success: function(response) {
                console.log(response); // Xem phản hồi từ server
            },
            error: function(xhr, status, error) {
                console.error('Lỗi Ajax:', error); // In ra chi tiết lỗi
                console.log(xhr.responseText); // Xem thông báo lỗi chi tiết từ server
            }
        });

    });
</script>

<script>
    function updateTotalPrice() {
        // Tính tổng giá
        let quantity = $('input[name="quantity_product"]').val();
        let priceBonus = parseFloat($('input.btn-size:checked').data('size-price')) || 0;
        let productPrice = parseFloat($('.tf-qty-price').data('price')); // Lấy giá sản phẩm từ data-price
        console.log(quantity, priceBonus, productPrice)
        const totalPrice = ((productPrice * 1 + priceBonus * 1) * quantity).toFixed(2); // Giữ 2 chữ số thập phân
        $('.tf-qty-price').text(`$${totalPrice}`); // Cập nhật giá trị tổng tiền
    }

    var btnQuantity = function() {
        $(".minus-btn").on("click", function(e) {
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest("div").find("input");
            var value = parseInt($input.val());

            if (value > 1) {
                value = value - 1;
            }
            $input.val(value);
            updateTotalPrice();
        });

        $(".plus-btn").on("click", function(e) {
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest("div").find("input");
            var value = parseInt($input.val());

            if (value > -1) {
                value = value + 1;
            }
            $input.val(value);
            updateTotalPrice();
        });
    };
    btnQuantity();
</script>
