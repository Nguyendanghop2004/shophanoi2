@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
<style>
 
    .tf-page-title .heading {
        font-size: 2.5rem;
        font-weight: bold;
        text-transform: uppercase;
    }
    .tf-page-title.style-2 {
        background-image: url('https://img.freepik.com/premium-photo/happy-young-man-pointing-away-smiling-while-sitting-against-brown-background_425904-41318.jpg?w=1380'); /* URL ảnh nền */
        background-size: contain;  /* Đảm bảo ảnh được hiển thị đầy đủ */
        background-position: center center;  /* Căn giữa ảnh */
        background-repeat: no-repeat;  /* Không lặp lại ảnh */
        background-attachment: fixed;  /* Giữ ảnh nền cố định khi cuộn trang */
        padding: 80px 0;  /* Điều chỉnh khoảng cách trên dưới của phần tiêu đề */
    }

    .tf-page-title.style-2 .heading {
        font-size: 36px;
        font-weight: bold;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Thêm bóng cho chữ */
    }

    .tf-page-title.style-2 .heading {
        font-size: 36px;
        font-weight: bold;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Thêm bóng cho chữ dễ đọc hơn trên nền */
    }
    .tf-main-area-page {
        padding: 50px 20px;
        display: flex;
        gap: 30px;
    }

    .tf-accordion-wrap .content h5 {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 20px;
    }

    .flat-accordion .flat-toggle {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
      
    }

    .flat-accordion .toggle-title {
        padding: 15px;
        cursor: pointer;
        font-weight: bold;
        background-color: #eaeaea;
        border-bottom: 1px solid #ddd;
        transition: background-color 0.3s ease;
    }

    .flat-accordion .toggle-title.active {
        background-color: #333;
        color: white;
    }

    .flat-accordion .toggle-content {
        padding: 15px;
        display: none;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .flat-accordion .flat-toggle.active .toggle-content {
        display: block;
    }

    .box.tf-other-content {
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .tf-btn {
        display: inline-flex;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        text-align: center;
        transition: all 0.3s ease;
    }

    .tf-btn.btn-fill {
        background-color: #333;
        color: white;
    }

    .tf-btn.btn-fill:hover {
        background-color: #555;
    }

    .tf-btn.btn-line {
        border: 2px solid #333;
        color: #333;
        background-color: transparent;
    }

    .tf-btn.btn-line:hover {
        background-color: #333;
        color: white;
    }
</style>

<div class="tf-page-title style-2">
    <div class="container-full">
        <div class="heading text-center">Câu hỏi thường gặp 01</div>
    </div>
</div>
<!-- /page-title -->
<!-- FAQ -->
<section class="flat-spacing-11">
    <div class="container">
        <div class="tf-accordion-wrap d-flex justify-content-between">
            <div class="content">
                <h5 class="mb_24">Thông tin mua sắm</h5>
                <div class="flat-accordion style-default has-btns-arrow mb_60">
                    <div class="flat-toggle active">
                        <div class="toggle-title active">Pellentesque habitant morbi tristique senectus et netus?</div>
                        <div class="toggle-content">
                            <p>Đây là cách hoàn hảo để tận hưởng việc pha trà trên những cành cây thấp treo nhằm mục đích nhận diện. Duis autem vel eum iriure dolor in hendrerit vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. Theo tôi, phần quan trọng nhất để cải thiện nhiếp ảnh là chia sẻ nó. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="flat-toggle">
                        <div class="toggle-title">Phí vận chuyển là bao nhiêu và mất bao lâu?</div>
                        <div class="toggle-content">
                            <p>Đây là cách hoàn hảo để tận hưởng việc pha trà trên những cành cây thấp treo nhằm mục đích nhận diện. Duis autem vel eum iriure dolor in hendrerit vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. Theo tôi, phần quan trọng nhất để cải thiện nhiếp ảnh là chia sẻ nó. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="flat-toggle">
                        <div class="toggle-title">Mất bao lâu để nhận được gói hàng của tôi?</div>
                        <div class="toggle-content">
                            <p>Đây là cách hoàn hảo để tận hưởng việc pha trà trên những cành cây thấp treo nhằm mục đích nhận diện. Duis autem vel eum iriure dolor in hendrerit vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. Theo tôi, phần quan trọng nhất để cải thiện nhiếp ảnh là chia sẻ nó. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                    <div class="flat-toggle">
                        <div class="toggle-title">Thương hiệu đơn giản có phải là cách hiệu quả hơn để bán hàng?</div>
                        <div class="toggle-content">
                            <p>Đây là cách hoàn hảo để tận hưởng việc pha trà trên những cành cây thấp treo nhằm mục đích nhận diện. Duis autem vel eum iriure dolor in hendrerit vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. Theo tôi, phần quan trọng nhất để cải thiện nhiếp ảnh là chia sẻ nó. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                    </div>
                </div>
                <h5 class="mb_24">Thông tin thanh toán</h5>
                <div class="flat-accordion style-default has-btns-arrow mb_60">
                    <!-- ... Tiếp tục dịch các phần còn lại theo cùng cấu trúc -->
                </div>
            </div>
            <div class="box tf-other-content radius-10 bg_grey-8">
                <h5 class="mb_20">Bạn có câu hỏi?</h5>
                <p class="text_black-2 mb_40">Nếu bạn có vấn đề hoặc câu hỏi cần được hỗ trợ ngay lập tức, bạn có thể nhấp vào nút bên dưới để trò chuyện trực tiếp với nhân viên chăm sóc khách hàng.<br><br>Vui lòng chờ từ 06 - 12 ngày làm việc kể từ khi gói hàng của bạn đến với chúng tôi để hoàn tiền.</p>
                <div class="d-flex gap-20 align-items-center">
                    <a href="contact-1.html" class="tf-btn radius-3 btn-fill animate-hover-btn justify-content-center">Liên hệ với chúng tôi</a>
                    <a href="contact-2.html" class="tf-btn btn-line">Trò chuyện trực tiếp<i class="icon icon-arrow1-top-left"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
