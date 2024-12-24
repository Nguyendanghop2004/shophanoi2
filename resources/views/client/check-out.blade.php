@extends('client.layouts.master')
@section('content')

@include('client.layouts.particals.page-title')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- page-cart -->
 <style>
  .small-total-price {
    font-size: 20px;  /* Giảm kích thước chữ */
    text-align: right; /* Đẩy sang bên phải */
    color: #000;       /* Màu chữ (tùy chỉnh) */
    font-weight: bold;
    margin-top: 10px;  /* Tùy chọn: thêm khoảng cách trên nếu cần */
}  /* Màu chữ */

 </style>
<section class="flat-spacing-11">
    <form action="{{ route('order.place') }}" method="POST" class="tf-page-cart-checkout widget-wrap-checkout">
        @csrf
        <div class="container">
            <div class="tf-page-cart-wrap layout-2">
                <div class="tf-page-cart-item">
                    <h5 class="fw-5 mb_20">Thông Tin Chi Tiết</h5>
                    <fieldset class="fieldset">
                        <label for="first-name">Tên</label>
                        <input name="name" type="text" id="first-name" 
                            value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" 
                            placeholder="Your Name" >
                    </fieldset>
                    @error('name')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                    @enderror

                    <fieldset class="fieldset">
                        <label for="last-name">Email</label>
                        <input name="email" type="email" id="last-name" 
                            value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" >
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
                            @foreach($cities as $city)
                                <option value="{{ $city->matp }}" {{ old('city_id', auth()->check() ? auth()->user()->city_id : '') == $city->matp ? 'selected' : '' }}>{{ $city->name_thanhpho }}</option>
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
                            @foreach($provinces as $province)
                                <option value="{{ $province->maqh }}" {{ old('province_id', auth()->check() ? auth()->user()->province_id : '') == $province->maqh ? 'selected' : '' }}>{{ $province->name_quanhuyen }} </option>
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
                            @foreach($wards as $ward)
                                <option value="{{ $ward->xaid }}" {{ old('wards_id', auth()->check() ? auth()->user()->wards_id : '') == $ward->xaid ? 'selected' : '' }}>{{ $ward->name_xaphuong }}</option>
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
                            value="{{ old('address', auth()->check() ? auth()->user()->address : '') }}" >
                    </fieldset>
                    @error('address')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                    @enderror

                    <fieldset class="box fieldset">
                        <label for="phone">Số Điện Thoại</label>
                        <input type="text" name="phone_number" id="phone" 
                            value="{{ old('phone_number', auth()->check() ? auth()->user()->phone_number : '') }}" >
                    </fieldset>
                    @error('phone_number')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                    @enderror

                    <fieldset class="box fieldset">
                        <label for="note">Ghi Chú</label>
                        <textarea name="note" id="note">{{ old('note') }}</textarea>
                    </fieldset>
                </div>

                <div class="tf-page-cart-footer">
                    <div class="tf-cart-footer-inner">
                        <h5 class="fw-5 mb_20">Đơn hàng của bạn</h5>
                        <ul class="wrap-checkout-product">
                            @php $totalPrice = 0; @endphp
                            @foreach ($cartDetails as $item)
                                @php 
                                    $totalPrice += $item['price'] * $item['quantity']; 
                                @endphp
                                <li class="checkout-product-item">
                                    <figure class="img-product">
                                        <img src="{{ asset('storage/' . $item['image_url']) }}" alt="img-product">
                                        <span class="quantity">{{ $item['quantity'] }}</span>
                                    </figure>
                                    <div class="content">
                                        <div class="info">
                                            <p class="name">{{ $item['product_name'] }}</p>
                                            <span class="variant">{{ $item['color_name'] }} / {{ $item['size_name'] }}</span>
                                        </div>
                                        <span class="price">${{ number_format($item['price'], 0, ',', '.') }} VNĐ</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        
                        <h4 class="fw-5 mb_20 small-total-price">Tổng tiền: {{ number_format($totalPrice, 0, ',', '.') }} VND</h4>

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

                        <!-- Nút Tiếp tục mua hàng -->
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
   $(document).ready(function(){
    $('.choose').on('change', function(){
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
@endsection
