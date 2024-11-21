@extends('client.layouts.master')

@section('content')

@include('client.layouts.particals.page-title')

<!-- page-cart -->
<section class="flat-spacing-11">
    <form action="{{route('placeOrder')}}" method="POST">
        @csrf
<div class="container">
    <div class="tf-page-cart-wrap layout-2">
        <div class="tf-page-cart-item">
            <h5 class="fw-5 mb_20">Billing details</h5>
         
                <div class="box grid-2">
                    <fieldset class="fieldset">
                        <label for="first-name">Name</label>
                        <input type="text" id="first-name" value="{{ auth()->check() ? auth()->user()->name : '' }}" placeholder="Themesflat">
                    </fieldset>
                    <fieldset class="fieldset">
                        <label for="last-name">Email</label>
                        <input type="text" id="last-name" value="{{ auth()->check() ? auth()->user()->email : '' }}">
                    </fieldset>
                </div>

                <fieldset class="box fieldset">
                    <label for="city">Address</label>
                    <input name="address" type="text" id="city" value="{{ auth()->check() ? auth()->user()->address : '' }}">
                </fieldset>

                <fieldset class="box fieldset">
                    <label for="phone">Phone Number</label>
                    <input name="phone_number" type="text" id="phone" value="{{ auth()->check() ? auth()->user()->phone_number : '' }}">
                </fieldset>

                <fieldset class="box fieldset">
                    <label for="note">Order notes (optional)</label>
                    <textarea name="note" id="note"></textarea>
                </fieldset>
           
        </div>

        <div class="tf-page-cart-footer">
            <div class="tf-cart-footer-inner">
                <h5 class="fw-5 mb_20">Your order</h5>
                <form class="tf-page-cart-checkout widget-wrap-checkout">
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

                    <div class="coupon-box">
                        <input type="text" placeholder="Discount code">
                        <a href="#" class="tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn">Apply</a>
                    </div>

                    <div class="d-flex justify-content-between line pb_20">
                        <h6 class="fw-5">Total</h6>
                        <h6 class="total fw-5">${{ number_format($totalPrice, 2) }}</h6>
                    </div>

                    <div class="wd-check-payment">
                        <div class="fieldset-radio mb_20">
                            <input type="radio" name="payment" id="bank" class="tf-check" checked>
                            <label for="bank">Direct bank transfer</label>
                        </div>
                        <div class="fieldset-radio mb_20">
                            <input type="radio" name="payment" id="delivery" class="tf-check">
                            <label for="delivery">Cash on delivery</label>
                        </div>
                        <p class="text_black-2 mb_20">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="privacy-policy.html" class="text-decoration-underline">privacy policy</a>.</p>
                        <div class="box-checkbox fieldset-radio mb_20">
                            <input type="checkbox" id="check-agree" class="tf-check">
                            <label for="check-agree" class="text_black-2">I have read and agree to the website <a href="terms-conditions.html" class="text-decoration-underline">terms and conditions</a>.</label>
                        </div>
                    </div>

                    <button type="submit" class="tf-btn radius-3 btn-fill btn-icon animate-hover-btn justify-content-center">Place order</button>
             
            </div>
        </div>
    </div>
</div>
</form>


</section>
<!-- page-cart -->
@endsection
