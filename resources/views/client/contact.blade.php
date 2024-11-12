@extends('client.layouts.master')

@section('content')
@include('client.layouts.particals.page-title')

<!-- map -->
<section class="flat-spacing-9">
    <div class="container">
        <div class="tf-grid-layout gap-0 lg-col-2">
            <div class="w-100">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.334948709725!2d105.74518811517075!3d21.0385264951218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455e940879933%3A0xcf10b34e9f1a03df!2sTr%C6%B0%E1%BB%9Dng%20Cao%20%C4%91%E1%BA%B3ng%20FPT%20Polytechnic!5e0!3m2!1sen!2s!4v1698436915845!5m2!1sen!2s" width="100%" height="894" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="tf-content-left has-mt">
                <div class="sticky-top">
                    <h5 class="mb_20">Visit Our Campus</h5>
                    <div class="mb_20">
                        <p class="mb_15"><strong>Address</strong></p>
                        <p>Số 1, Đường Trịnh Văn Bô, Phường Tây Mỗ, Quận Nam Từ Liêm, Hà Nội.</p>
                    </div>
                    <div class="mb_20">
                        <p class="mb_15"><strong>Phone</strong></p>
                        <p>(039) 6075 753</p>
                    </div>
                    <div class="mb_20">
                        <p class="mb_15"><strong>Email</strong></p>
                        <p>hanoiclotheshop@gmail.com</p>
                    </div>
                    <div class="mb_36">
                        <p class="mb_15"><strong>Open Time</strong></p>
                        <p class="mb_15">Mở cửa đón khách mọi ngày trong tuần từ 8am 5pm</p>
                    </div>
                    <div>
                        <ul class="tf-social-icon d-flex gap-20 style-default">
                            <li><a href="#" class="box-icon link round social-facebook border-line-black"><i class="icon fs-14 icon-fb"></i></a></li>
                            <li><a href="#" class="box-icon link round social-twitter border-line-black"><i class="icon fs-12 icon-Icon-x"></i></a></li>
                            <li><a href="#" class="box-icon link round social-instagram border-line-black"><i class="icon fs-14 icon-instagram"></i></a></li>
                            <li><a href="#" class="box-icon link round social-tiktok border-line-black"><i class="icon fs-14 icon-tiktok"></i></a></li>
                            <li><a href="#" class="box-icon link round social-pinterest border-line-black"><i class="icon fs-14 icon-pinterest-1"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- maps -->

<!-- form -->
<section class="bg_grey-7 flat-spacing-9">
    <div class="container">
        <div class="flat-title">
            <span class="title">Hãy Liên Hệ</span>
            <p class="sub-title text_black-2">Nếu bạn có những sản phẩm tuyệt vời đang sản xuất hoặc muốn hợp tác với chúng tôi, hãy liên hệ với chúng tôi.</p>
        </div>
        <div>
            <form class="mw-705 mx-auto text-center form-contact" id="contactform" action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="d-flex gap-15 mb_15">
                    <fieldset class="w-100">
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required placeholder="Name *" value="{{ old('name') }}"/>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>
                    <fieldset class="w-100">
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required placeholder="Email *" value="{{ old('email') }}"/>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>
                </div>
                <div class="mb_15">
                    <fieldset class="w-100">
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone (optional)" value="{{ old('phone') }}"/>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>
                </div>
                <div class="mb_15">
                    <textarea class="form-control @error('message') is-invalid @enderror" placeholder="Message" name="message" id="message" required cols="30" rows="10">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="send-wrap">
                    <button type="submit" class="tf-btn radius-3 btn-fill animate-hover-btn justify-content-center">Gửi</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /form -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<script>
    $(document).ready(function () {
        toastr.options = {
            "closeButton": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });
</script>
@endsection
