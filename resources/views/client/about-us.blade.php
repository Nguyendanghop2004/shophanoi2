@extends('client.layouts.master')

@section('content')

    <!-- Slider -->
    <section class="tf-slideshow about-us-page position-relative">
        <div class="banner-wrapper">
            <img class="lazyload" src="{{ asset('client/assets/images/slider/about-banner-01.jpg') }}"
                data-src="{{asset('client/assets/images/slider/about-banner-01.jpg') }}" alt="hình ảnh bộ sưu tập">
            <div class="box-content text-center">
                <div class="container">
                    <div class="text text-white">Trao quyền cho phụ nữ để đạt được <br class="d-xl-block d-none"> mục tiêu thể hình với phong cách</div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Slider -->
    <!-- Tiêu đề -->
    <section class="flat-spacing-9">
        <div class="container">
            <div class="flat-title my-0">
                <span class="title">Chúng tôi là Hanoiclothesshop</span>
                <p class="sub-title text_black-2">
                Chào mừng đến với cửa hàng thời trang nam nữ trẻ trung của chúng tôi, nơi chúng tôi tin rằng <br class="d-xl-block d-none">
phong cách vượt thời gian luôn luôn tươi mới. Bộ sưu tập của chúng tôi bao gồm những sản phẩm cổ điển <br class="d-xl-block d-none">
vừa phong cách vừa linh hoạt, hoàn hảo để tạo dựng <br class="d-xl-block d-none">
một tủ đồ hiện đại và bền vững.
                </p>
            </div>
        </div>
    </section>
    <!-- /Tiêu đề -->
    <div class="container">
        <div class="line"></div>
    </div>
    <!-- hình ảnh và nội dung -->
    <section class="flat-spacing-23 flat-image-text-section">
        <div class="container">
            <div class="tf-grid-layout md-col-2 tf-img-with-text style-4">
                <div class="tf-image-wrap">
                    <img class="lazyload w-100" data-src="{{asset('client/assets/images/collections/collection-69.jpg') }}"
                        src="{{ asset('client/assets/images/collections/collection-69.jpg') }}" alt="ảnh bộ sưu tập">
                </div>
                <div class="tf-content-wrap px-0 d-flex justify-content-center w-100">
                    <div>
                        <div class="heading">Thành lập - 2024</div>
                        <div class="text">
                        HanoiClothesshop được thành lập vào năm 2024 bởi một nhóm bạn trẻ tại Việt Nam, những người yêu thời trang với <br class="d-xl-block d-none">
niềm đam mê phong cách vượt thời gian. Họ luôn bị cuốn hút bởi những sản phẩm thời trang trẻ trung <br class="d-xl-block d-none">
có thể mặc qua nhiều mùa, và tin rằng <br class="d-xl-block d-none">
thị trường còn thiếu một cửa hàng tập trung vào trang phục nữ cổ điển. <br class="d-xl-block d-none">
Cửa hàng đầu tiên được mở tại một thị trấn nhỏ, nhanh chóng trở thành lựa chọn yêu thích của người dân địa phương.

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="flat-spacing-15">
        <div class="container">
            <div class="tf-grid-layout md-col-2 tf-img-with-text style-4">
                <div class="tf-content-wrap px-0 d-flex justify-content-center w-100">
                    <div>
                        <div class="heading">Sứ mệnh của chúng tôi</div>
                        <div class="text">
                            Sứ mệnh của chúng tôi là trao quyền cho mọi người thông qua thời trang bền vững. <br class="d-xl-block d-none">
                            Chúng tôi muốn mọi người trông đẹp và cảm thấy tuyệt vời, đồng thời đóng góp vào việc <br class="d-xl-block d-none">
                            bảo vệ môi trường. Chúng tôi tin rằng thời trang cần phong cách, <br class="d-xl-block d-none">
                            giá cả phải chăng và dễ tiếp cận với mọi người. Giá trị về sự tích cực và đa dạng là nền tảng của thương hiệu chúng tôi.
                        </div>
                    </div>
                </div>
                <div class="grid-img-group">
                    <div class="tf-image-wrap box-img item-1">
                        <div class="img-style">
                            <img class="lazyload" src="{{ asset('client/assets/images/collections/collection-71.jpg') }}"
                                data-src="{{asset('client/assets/images/collections/collection-71.jpg') }}" alt="ảnh bộ sưu tập">
                        </div>
                    </div>
                    <div class="tf-image-wrap box-img item-2">
                        <div class="img-style">
                            <img class="lazyload" src="{{ asset('client/assets/images/collections/collection-70.jpg') }}"
                                data-src="{{asset('client/assets/images/collections/collection-70.jpg') }}" alt="ảnh bộ sưu tập">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /hình ảnh và nội dung -->
    <!-- Hộp icon -->
    <section>
        <div class="container">
            <div class="bg_grey-2 radius-10 flat-wrap-iconbox">
                <div class="flat-title lg">
                    <span class="title fw-5">Chất lượng là ưu tiên của chúng tôi</span>
                    <div>
                        <p class="sub-title text_black-2">Đội ngũ stylist tài năng đã tạo ra những bộ trang phục hoàn hảo cho mùa này.</p>
                        <p class="sub-title text_black-2">Họ đã nghĩ ra nhiều cách để truyền cảm hứng cho phong cách thời trang hiện đại của bạn.</p>
                    </div>
                </div>
                <div class="flat-iconbox-v3 lg">
                    <div class="wrap-carousel wrap-mobile">
                        <div class="swiper tf-sw-mobile" data-preview="1" data-space="15">
                            <div class="swiper-wrapper wrap-iconbox lg">
                                <div class="swiper-slide">
                                    <div class="tf-icon-box text-center">
                                        <div class="icon">
                                            <i class="icon-materials"></i>
                                        </div>
                                        <div class="content">
                                            <div class="title">Chất liệu cao cấp</div>
                                            <p class="text_black-2">Sản phẩm được chế tác tỉ mỉ từ các chất liệu cao cấp, mang lại sự thoải mái và bền bỉ vượt trội.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="tf-icon-box text-center">
                                        <div class="icon">
                                            <i class="icon-design"></i>
                                        </div>
                                        <div class="content">
                                            <div class="title">Thiết kế tối giản</div>
                                            <p class="text_black-2">Sự tinh tế từ đơn giản. Sản phẩm của chúng tôi mang đến phong cách tối giản mà vẫn nổi bật.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="tf-icon-box text-center">
                                        <div class="icon">
                                            <i class="icon-sizes"></i>
                                        </div>
                                        <div class="content">
                                            <div class="title">Đa dạng kích cỡ</div>
                                            <p class="text_black-2">Dành cho mọi dáng người, sản phẩm của chúng tôi tôn vinh vẻ đẹp cá nhân với nhiều kích cỡ đa dạng.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sw-dots style-2 sw-pagination-mb justify-content-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Hộp icon -->
    <!-- Đánh giá -->
    <section class="flat-testimonial-v2 flat-spacing-24">
        <div class="container">
            <div class="wrapper-thumbs-testimonial-v2 flat-thumbs-testimonial">
                <div class="box-left">
                    <div class="swiper tf-sw-tes-2" data-preview="1" data-space-lg="40" data-space-md="30">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="testimonial-item lg lg-2">
                                    <h4 class="mb_40">Đánh giá của khách hàng</h4>
                                    <div class="icon">
                                        <img class="lazyload" data-src="{{asset('client/assets/images/item/quote.svg') }}" alt=""
                                            src="{{ asset('client/assets/images/item/quote.svg') }}">
                                    </div>
                                    <div class="rating">
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                        <i class="icon-start"></i>
                                    </div>
                                    <p class="text">
                                        "Tôi đã mua sắm trên trang này hơn một năm và tôi có thể tự tin nói rằng đây là trang thời trang online tốt nhất. Giao hàng luôn nhanh và đội ngũ hỗ trợ thân thiện. Tôi rất khuyên mọi người nên thử!"
                                    </p>
                                    <div class="author box-author">
                                        <div class="content">
                                            <div class="name">Robert Smith</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Thêm đánh giá khác tại đây -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Đánh giá -->
@endsection
