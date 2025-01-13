@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('topbar')
    
@endsection

@section('content')
    @include('client.layouts.particals.page-title')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- page-cart -->
    <section class="flat-spacing-11">
        <form action="{{ route('order.place') }}" method="POST" class="tf-page-cart-checkout widget-wrap-checkout">
            @csrf
            <div class="container">
                <div class="tf-page-cart-wrap layout-2">
                    <div class="tf-page-cart-item">
                        <h5 class="fw-5 mb_20">Chi Tiết Thanh Toán</h5>

                        <fieldset class="fieldset">
                            <label for="first-name">Họ Và Tên</label>
                            <input name="name" type="text" id="first-name"
                                value="{{ auth()->check() ? auth()->user()->name : '' }}" placeholder="Your Name">
                        </fieldset>
                        @error('name')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <fieldset class="fieldset">
                            <label for="last-name">Email</label>
                            <input name="email" type="email" id="last-name"
                                value="{{ auth()->check() ? auth()->user()->email : '' }}">
                        </fieldset>
                        @error('email')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror


                        <div class="form-group">
                            <label for="city">Chọn thành phố</label>
                            <select name="city_id" id="city" class="form-control choose city">
                                <option value="" disabled selected>Chọn thành phố</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->matp }}"
                                        {{ auth()->check() && auth()->user()->city_id == $city->matp ? 'selected' : '' }}>
                                        {{ $city->name_thanhpho }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('city_id')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">
                            <label for="province">Chọn quận/huyện</label>
                            <select name="province_id" id="province" class="form-control province choose">
                                <option value="">Chọn quận/huyện</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->maqh }}"
                                        {{ auth()->check() && auth()->user()->province_id == $province->maqh ? 'selected' : '' }}>
                                        {{ $province->name_quanhuyen }} </option>
                                @endforeach
                            </select>
                        </div>
                        @error('province_id')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">
                            <label for="wards">Chọn xã/phường</label>
                            <select name="wards_id" id="wards" class="form-control wards">
                                <option value="">Chọn xã/phường</option>
                                @foreach ($wards as $ward)
                                    <option value="{{ $ward->xaid }}"
                                        {{ auth()->check() && auth()->user()->wards_id == $ward->xaid ? 'selected' : '' }}>
                                        {{ $ward->name_xaphuong }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('wards_id')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <!-- Địa chỉ cụ thể -->
                        <fieldset class="box fieldset">
                            <label for="address">Địa chỉ cụ thể</label>
                            <input name="address" type="text" id="address"
                                value="{{ auth()->check() ? auth()->user()->address : '' }}">
                        </fieldset>
                        @error('address')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <fieldset class="box fieldset">
                            <label for="phone">Số Điện Thoại</label>
                            <input type="text" name="phone_number" id="phone"
                                value="{{ auth()->check() ? auth()->user()->phone_number : '' }}">
                        </fieldset>
                        @error('phone_number')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <fieldset class="box fieldset">
                            <label for="note">Ghi chú</label>
                            <textarea name="note" id="note"></textarea>
                        </fieldset>
                    </div>

                    <div class="tf-page-cart-footer">
                        <div class="tf-cart-footer-inner">
                            <h5 class="fw-5 mb_20">Sản Phẩm</h5>
                            <ul class="wrap-checkout-product mb-3">
                                @foreach ($cartDetails as $item)
                                    <li class="checkout-product-item">
                                        <figure class="img-product">
                                            <img src="{{ asset('storage/' . $item['image_url']) }}" alt="img-product">
                                            <span class="quantity">{{ $item['quantity'] }}</span>
                                        </figure>
                                        <div class="content">
                                            <div class="info">
                                                <p class="name">{{ $item['product_name'] }}</p>
                                                <span class="variant">{{ $item['color_name'] }} /
                                                    {{ $item['size_name'] }} + {{ $item['pricebonus'] }} VNĐ</span>
                                            </div>
                                            <span class="price">
                                                <span
                                                    class="sale-price">{{ number_format($item['final_price'], 0, ',', '.') }}
                                                    VNĐ</span>
                                                <span class="original-price"
                                                    style="text-decoration: line-through; color: #888;">
                                                    {{ $item['price'] > $item['final_price'] ? number_format($item['price'], 0, ',', '.') . ' VNĐ' : '' }}
                                                </span>
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="coupon-box mb-3">
                                <input type="text" id="coupon-code" name="coupon-code" placeholder="Nhập mã giảm giá">
                                <a href="#" id="apply-coupon-btn"
                                    class="tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn">Áp Mã</a>
                            </div>
                            <div id="coupon-message" style="color: red; margin-top: 10px;"></div>
                            <!-- Nơi hiển thị thông báo -->

                            <div class="d-flex justify-content-between line pb_20">
                                <h6 class="fw-5">Tổng Tiền</h6>
                                <h6 class="total fw-5 tf-totals-total-value">{{ number_format($totalPrice) }} VNĐ</h6>
                            </div>

                            <div class="wd-check-payment">
                            <div class="fieldset-radio mb_20">
                                <input type="radio" name="payment" id="bank" class="tf-check" value="vnpay" checked>
                                <label for="bank">Chuyển khoản ngân hàng trực tiếp (VNPay)</label>
                            </div>
                            <div class="fieldset-radio mb_20">
                                <input type="radio" name="payment" id="delivery" class="tf-check" value="cod">
                                <label for="delivery">Thanh toán khi nhận hàng (COD)</label>
                            </div>
                            <p class="text_black-2 mb_20">
                                Dữ liệu cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng, hỗ trợ trải nghiệm của bạn trong suốt website này, và cho các mục đích khác theo mô tả trong 
                                <a href="privacy-policy.html" class="text-decoration-underline">chính sách bảo mật</a>.
                            </p>
                            <div class="box-checkbox fieldset-radio mb_20">
                                <input type="checkbox" id="check-agree" class="tf-check" required>
                                <label for="check-agree" class="text_black-2">
                                    Tôi đã đọc và đồng ý với 
                                    <a href="terms-conditions.html" class="text-decoration-underline">điều khoản và điều kiện</a> của website.
                                </label>
                            </div>
                        </div>

                        <button type="submit" name="redirect" class="tf-btn radius-3 btn-fill btn-icon animate-hover-btn justify-content-center">
                            Đặt hàng
                        </button>
                        <a href="{{ route('home') }}" class="tf-btn radius-3 btn-outline btn-icon animate-hover-btn justify-content-center mt_20">
                            Tiếp tục mua hàng
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>



    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.choose').on('change', function() {
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';

                if (action === 'city') {
                    result = 'province';
                    $('#province').html('<option value="">Chọn quận/huyện</option>');
                    $('#wards').html('<option value="">Chọn xã/phường</option>');
                } else if (action === 'province') {
                    result = 'wards';
                    $('#wards').html('<option value="">Chọn xã/phường</option>');
                }

                $.ajax({
                    url: '{{ url('select-address') }}',
                    method: 'POST',
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    },

                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                        console.log(xhr.responseText);
                    }
                });

                if (action === 'city') {
                    $('#province').html('<option value="">Chọn quận/huyện</option>');
                    $('#wards').html('<option value="">Chọn xã/phường</option>');
                } else if (action === 'province') {
                    $('#wards').html('<option value="">Chọn xã/phường</option>');
                }
            });
        });
    </script>
    <!-- page-cart -->
    <script>
        $(document).ready(function() {
            $('#apply-coupon-btn').on('click', function(e) {
                e.preventDefault(); // Ngăn chặn hành động mặc định

                const couponCode = $('#coupon-code').val(); // Lấy mã giảm giá
                const messageBox = $('#coupon-message'); // Thông báo lỗi

                if (!couponCode) {
                    messageBox.text('Vui lòng nhập mã giảm giá.');
                    return;
                }

                $.ajax({
                    url: '/apply-coupon',
                    type: 'POST',
                    data: {
                        coupon: couponCode,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        if (response.success) {
                            messageBox.css('color', 'green').text(response.message);
                            $('.tf-totals-total-value').text(response.newTotal +
                                ' VNĐ'); // Cập nhật tổng giá
                        } else {
                            if (response.redirect) {
                                // Nếu cần đăng nhập, chuyển hướng
                                window.location.href = response.redirect;
                            } else {
                                // Hiển thị lỗi
                                messageBox.css('color', 'red').text(response.message);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'Đã xảy ra lỗi. Vui lòng thử lại.'; // Lỗi mặc định

                        // Lấy thông tin lỗi chi tiết từ phản hồi server
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message; // Hiển thị lỗi từ server
                        } else if (xhr.responseText) {
                            errorMessage = xhr
                            .responseText; // Hiển thị toàn bộ phản hồi nếu không có JSON
                        }

                        messageBox.css('color', 'red').text(
                        errorMessage); // Hiển thị lỗi trong giao diện
                        console.error('Chi tiết lỗi:',
                        xhr); // Ghi lỗi chi tiết vào console để debug
                    },
                });
            });

        });
    </script>
@endsection
