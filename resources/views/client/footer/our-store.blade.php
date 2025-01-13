@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
<style>/* Chung cho toàn bộ trang */
    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f4f4f4;
    }
    
    /* Tiêu đề trang */
    .tf-page-title .heading {
        font-size: 36px;
        font-weight: 700;
        color: #222;
        text-transform: uppercase;
        margin-bottom: 40px;
    }
    .tf-page-title.style-2 {
    background-image: url('https://img.freepik.com/premium-photo/fashion-woman-hold-shopping-gray-bags-fashionable-hair-style-asian-girl-with-black-hat-white-pants-throw-pink-green-bags_121764-666.jpg?w=1380'); /* Đường dẫn ảnh nền */
    background-size: cover; /* Đảm bảo ảnh phủ kín toàn bộ phần nền */
    background-position: center center; /* Căn giữa ảnh */
    background-repeat: no-repeat; /* Không lặp lại ảnh */
    height: 100vh; /* Chiều cao của phần này sẽ bằng chiều cao cửa sổ trình duyệt */
    display: flex; /* Đảm bảo nội dung căn giữa */
    justify-content: center; /* Căn giữa theo chiều ngang */
    align-items: center; /* Căn giữa theo chiều dọc */
    text-align: center; /* Căn giữa nội dung */
}

.tf-page-title .heading {
    font-size: 40px;
    font-weight: bold;
    color: white;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6); /* Tạo hiệu ứng bóng cho chữ */
    margin: 0;
}
    /* Cửa hàng */
    .tf-ourstore-img img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .tf-ourstore-img img:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    /* Nội dung cửa hàng */
    .tf-ourstore-content {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .tf-ourstore-content h5 {
        font-size: 28px;
        color: #222;
        margin-bottom: 24px;
    }
    
    /* Các thông tin cửa hàng */
    .tf-ourstore-content p {
        font-size: 16px;
        color: #555;
        margin-bottom: 10px;
    }
    
    /* Các tiêu đề con */
    .tf-ourstore-content strong {
        color: #333;
        font-weight: bold;
    }
    
    /* Các icon mạng xã hội */
    .tf-social-icon {
        display: flex;
        gap: 15px;
    }
    
    .tf-social-icon li a {
        width: 40px;
        height: 40px;
        background-color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .tf-social-icon li a:hover {
        background-color: #000;
        color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .tf-social-icon li a i {
        font-size: 18px;
    }
    
    /* Nút nhận lộ trình */
    .tf-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 10px 20px;
        border: 2px solid #000;
        background-color: transparent;
        color: #000;
        font-size: 16px;
        border-radius: 3px;
        transition: all 0.3s ease;
    }
    
    .tf-btn:hover {
        background-color: #000;
        color: #fff;
    }
    
    .tf-btn span {
        margin-right: 8px;
    }
    
    .tf-btn i {
        font-size: 18px;
    }
    
    /* Thêm một chút không gian cho các section */
    .flat-spacing-16, .flat-spacing-10, .flat-spacing-15 {
        padding: 40px 0;
    }
    
    /* Thêm các hiệu ứng cho image */
    .tf-ourstore-img img {
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .tf-ourstore-img img:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* Hỗ trợ thiết kế trên các màn hình nhỏ */
    @media (max-width: 768px) {
        .tf-grid-layout {
            flex-direction: column;
        }
    
        .tf-ourstore-content {
            padding: 20px;
        }
    
        .tf-ourstore-img img {
            margin-bottom: 20px;
        }
    }
    
    @media (max-width: 480px) {
        .tf-ourstore-content h5 {
            font-size: 24px;
        }
    
        .tf-ourstore-content p {
            font-size: 14px;
        }
    
        .tf-btn {
            padding: 8px 16px;
            font-size: 14px;
        }
    }
    </style>
<div class="tf-page-title style-2">
    <div class="container-full">
        <div class="heading text-center">Cửa Hàng Của Chúng Tôi</div>
    </div>
</div>
<!-- /page-title -->

<!-- Cửa Hàng Của Chúng Tôi -->
<section class="flat-spacing-16">
    <div class="container">
        <div class="tf-grid-layout md-col-2">
            <div class="tf-ourstore-img">
                <img  data-src="resources/views/img/footer/R.png" src="{{ asset('client/assets/images/footer/th.jpg') }}" alt="our-store">
            </div>
            <div class="tf-ourstore-content">
                <h5 class="mb_24">Ecomus Paris</h5>
                <div class="mb_20">
                    <p class="mb_15"><strong>Địa chỉ</strong></p>
                    <p>66 Mott St, New York, New York, Mã bưu chính: 10006, AS</p>
                </div>
                <div class="mb_20">
                    <p class="mb_15"><strong>Điện thoại</strong></p>
                    <p>(623) 934-2400</p>
                </div>
                <div class="mb_20">
                    <p class="mb_15"><strong>Email</strong></p>
                    <p>EComposer@example.com</p>
                </div>
                <div class="mb_36">
                    <p class="mb_15"><strong>Giờ Mở Cửa</strong></p>
                    <p class="mb_15">Cửa hàng của chúng tôi đã mở lại để mua sắm, </p>
                    <p>và trao đổi mỗi ngày từ 11am đến 7pm</p>
                </div>
                <div class="mb_30">
                    <ul class="tf-social-icon d-flex gap-15 style-default">
                        <li><a href="#" class="box-icon link round social-facebook border-line-black"><i class="icon fs-16 icon-fb"></i></a></li>
                        <li><a href="#" class="box-icon link round social-twiter border-line-black"><i class="icon fs-16 icon-Icon-x"></i></a></li>
                        <li><a href="#" class="box-icon link round social-instagram border-line-black"><i class="icon fs-16 icon-instagram"></i></a></li>
                        <li><a href="#" class="box-icon link round social-tiktok border-line-black"><i class="icon fs-16 icon-tiktok"></i></a></li>
                        <li><a href="#" class="box-icon link round social-pinterest border-line-black"><i class="icon fs-16 icon-pinterest-1"></i></a></li>
                    </ul>
                </div>
                <div>
                    <a href="contact-2.html" class="tf-btn btn-outline-dark radius-3"><span>Nhận Lộ Trình</span><i class="icon icon-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="flat-spacing-10">
    <div class="container">
        <div class="tf-grid-layout md-col-2">
            <div class="tf-ourstore-content pl-124">
                <h5 class="mb_24">Ecomus London</h5>
                <div class="mb_20">
                    <p class="mb_15"><strong>Địa chỉ</strong></p>
                    <p>66 Mott St, New York, New York, Mã bưu chính: 10006, AS</p>
                </div>
                <div class="mb_20">
                    <p class="mb_15"><strong>Điện thoại</strong></p>
                    <p>(623) 934-2400</p>
                </div>
                <div class="mb_20">
                    <p class="mb_15"><strong>Email</strong></p>
                    <p>EComposer@example.com</p>
                </div>
                <div class="mb_36">
                    <p class="mb_15"><strong>Giờ Mở Cửa</strong></p>
                    <p class="mb_15">Cửa hàng của chúng tôi đã mở lại để mua sắm, </p>
                    <p>và trao đổi mỗi ngày từ 11am đến 7pm</p>
                </div>
                <div class="mb_30">
                    <ul class="tf-social-icon d-flex gap-15 style-default">
                        <li><a href="#" class="box-icon link round social-facebook border-line-black"><i class="icon fs-16 icon-fb"></i></a></li>
                        <li><a href="#" class="box-icon link round social-twiter border-line-black"><i class="icon fs-16 icon-Icon-x"></i></a></li>
                        <li><a href="#" class="box-icon link round social-instagram border-line-black"><i class="icon fs-16 icon-instagram"></i></a></li>
                        <li><a href="#" class="box-icon link round social-tiktok border-line-black"><i class="icon fs-16 icon-tiktok"></i></a></li>
                        <li><a href="#" class="box-icon link round social-pinterest border-line-black"><i class="icon fs-16 icon-pinterest-1"></i></a></li>
                    </ul>
                </div>
                <div>
                    <a href="contact-1.html" class="tf-btn btn-outline-dark radius-3"><span>Nhận Lộ Trình</span><i class="icon icon-arrow-right"></i></a>
                </div>
            </div>
            <div class="tf-ourstore-img">
                <img  data-src="images/shop/store/ourstore4.png" src="{{ asset('client/assets/images/footer/1.jpg') }}" alt="our-store">
            </div>
        </div>
    </div>
</section>
<section class="flat-spacing-15">
    <div class="container">
        <div class="tf-grid-layout md-col-2">
            <div class="tf-ourstore-img">
                <img  data-src="images/shop/store/ourstore3.png" src="{{ asset('client/assets/images/footer/Scalpers-Gran-Via-3-1110x740.jpg') }}" alt="our-store">
            </div>
            <div class="tf-ourstore-content">
                <h5 class="mb_24">Ecomus Dubai</h5>
                <div class="mb_20">
                    <p class="mb_15"><strong>Địa chỉ</strong></p>
                    <p>66 Mott St, New York, New York, Mã bưu chính: 10006, AS</p>
                </div>
                <div class="mb_20">
                    <p class="mb_15"><strong>Điện thoại</strong></p>
                    <p>(623) 934-2400</p>
                </div>
                <div class="mb_20">
                    <p class="mb_15"><strong>Email</strong></p>
                    <p>EComposer@example.com</p>
                </div>
                <div class="mb_36">
                    <p class="mb_15"><strong>Giờ Mở Cửa</strong></p>
                    <p class="mb_15">Cửa hàng của chúng tôi đã mở lại để mua sắm, </p>
                    <p>và trao đổi mỗi ngày từ 11am đến 7pm</p>
                </div>
                <div class="mb_30">
                    <ul class="tf-social-icon d-flex gap-15 style-default">
                        <li><a href="#" class="box-icon link round social-facebook border-line-black"><i class="icon fs-16 icon-fb"></i></a></li>
                        <li><a href="#" class="box-icon link round social-twiter border-line-black"><i class="icon fs-16 icon-Icon-x"></i></a></li>
                        <li><a href="#" class="box-icon link round social-instagram border-line-black"><i class="icon fs-16 icon-instagram"></i></a></li>
                        <li><a href="#" class="box-icon link round social-tiktok border-line-black"><i class="icon fs-16 icon-tiktok"></i></a></li>
                        <li><a href="#" class="box-icon link round social-pinterest border-line-black"><i class="icon fs-16 icon-pinterest-1"></i></a></li>
                    </ul>
                </div>
                <div>
                    <a href="contact-2.html" class="tf-btn btn-outline-dark radius-3"><span>Nhận Lộ Trình</span><i class="icon icon-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
