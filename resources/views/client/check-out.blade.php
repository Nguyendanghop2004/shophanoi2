@extends('client.layouts.master')
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
                    <h5 class="fw-5 mb_20">Billing details</h5>
                   
                        <fieldset class="fieldset">
                            <label for="first-name">Name</label>
                            <input name="name" type="text" id="first-name" 
                                value="{{ auth()->check() ? auth()->user()->name : '' }}" 
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
                                value="{{ auth()->check() ? auth()->user()->email : '' }}" 
                                >
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
                                <option value="{{ $city->matp }}" {{ auth()->check() && auth()->user()->city_id == $city->matp ? 'selected' : '' }}>{{ $city->name_thanhpho }}</option>
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
                            <option value="" >Chọn quận/huyện</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->maqh }}" {{ auth()->check() && auth()->user()->province_id == $province->maqh ? 'selected' : '' }}>{{ $province->name_quanhuyen }} </option>
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
                            <option value="" >Chọn xã/phường</option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->xaid }}" {{ auth()->check() && auth()->user()->wards_id == $ward->xaid ? 'selected' : '' }}>{{ $ward->name_xaphuong }}</option>
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
                            value="{{ auth()->check() ? auth()->user()->address : '' }}" 
                            >
                    </fieldset>
                    @error('address')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                    <fieldset class="box fieldset">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone_number" id="phone" 
                            value="{{ auth()->check() ? auth()->user()->phone_number : '' }}" 
                            >
                    </fieldset>
                    @error('phone_number')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                    <fieldset class="box fieldset">
                        <label for="note">Order notes (optional)</label>
                        <textarea name="note" id="note"></textarea>
                    </fieldset>
                </div>
    
                <div class="tf-page-cart-footer">
                    <div class="tf-cart-footer-inner">
                        <h5 class="fw-5 mb_20">Your order</h5>
                        <ul class="wrap-checkout-product">
                            @foreach ($cartDetails as $item)
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
                                        <span class="price">${{ number_format($item['price'], 2) }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
    
                     
    
                        <div class="wd-check-payment">
                            <div class="fieldset-radio mb_20">
                                <input type="radio" name="payment" id="bank" class="tf-check" value="vnpay" checked>
                                <label for="bank">Direct bank transfer (VNPay)</label>
                            </div>
                            <div class="fieldset-radio mb_20">
                                <input type="radio" name="payment" id="delivery" class="tf-check" value="cod">
                                <label for="delivery">Cash on delivery (COD)</label>
                            </div>
                            <p class="text_black-2 mb_20">
                                Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our 
                                <a href="privacy-policy.html" class="text-decoration-underline">privacy policy</a>.
                            </p>
                            <div class="box-checkbox fieldset-radio mb_20">
                                <input type="checkbox" id="check-agree" class="tf-check" required>
                                <label for="check-agree" class="text_black-2">
                                    I have read and agree to the website 
                                    <a href="terms-conditions.html" class="text-decoration-underline">terms and conditions</a>.
                                </label>
                            </div>
                        </div>
    
                        <button type="submit" name="redirect" class="tf-btn radius-3 btn-fill btn-icon animate-hover-btn justify-content-center ">
                            Place order
                        </button>
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
<!-- page-cart -->
@endsection
