@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection
<style>
    .tf-page-title{
        background-color: red;
    }
</style>
@section('content')
<style>
    <style>
    /* General Styling */
    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .tf-page-title.style-2 {
        background-image: url('https://img.freepik.com/premium-photo/beautiful-girl-beige-raincoat-posing-studio-grey-background-girl-motion-free-space-horizontal-banner-website-design-portrait-copy-space_222877-15366.jpg?w=1380'); /* Thay đổi URL ảnh nền ở đây */
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        padding: 80px 0;
    }

    .tf-page-title .heading {
        font-size: 36px;
        font-weight: bold;
        color:black;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Tạo bóng cho chữ để nổi bật trên nền */
    }

    .tf-page-title .heading {
        font-size: 2.5rem;
        font-weight: bold;
        text-transform: uppercase;
       
    }

    /* Section Container */
    .flat-spacing-25 {
        padding: 25px 0;
        background-color: #f9f9f9;
    }

    .tf-main-area-page {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 20px;
    }

    .tf-main-area-page .box {
        margin-bottom: 20px;
    }

    /* Headings */
    .tf-main-area-page h4 {
        font-size: 1.5rem;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    /* Tag List */
    .tag-list {
        list-style: none;
        padding-left: 0;
    }

    .tag-list li {
        padding: 8px 0;
        border-bottom: 1px solid #e0e0e0;
        color: #555;
    }

    .tag-list li:last-child {
        border-bottom: none;
    }

    /* Contact Information */
    .text_black-2 {
        font-size: 1rem;
        color: #2c3e50;
        margin: 5px 0;
    }

    /* Buttons (Optional) */
    .btn-contact {
        display: inline-block;
        background: #2c3e50;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px;
        margin-top: 15px;
    }

    .btn-contact:hover {
        background: #1abc9c;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .tf-page-title .heading {
            font-size: 1.8rem;
        }

        .tf-main-area-page {
            padding: 15px;
        }

        .tf-main-area-page h4 {
            font-size: 1.25rem;
        }
    }
</style>



    <!-- page-title -->
    <div class="tf-page-title style-2">
        
        <div class="container-full">
            <div class="heading text-center"><b>Chính Sách Giao Hàng và Trả Hàng</b></div>
        </div>
    </div>
    <!-- /page-title -->
    <!-- main-page -->
    <section class="flat-spacing-25">
        <div class="container">
            <div class="tf-main-area-page tf-page-delivery">
                <div class="box">
                    <h4><b>Giao Hàng</b></h4>
                    <ul class="tag-list">
                        <li>Tất cả đơn hàng được vận chuyển qua UPS Express.</li>
                        <li>Miễn phí vận chuyển cho đơn hàng trên 250 USD.</li>
                        <li>Tất cả đơn hàng đều được cung cấp số theo dõi UPS.</li>
                    </ul>
                </div>
                <div class="box">
                    <h4><b>Trả Hàng</b></h4>
                    <ul class="tag-list">
                        <li>Các mặt hàng được trả lại trong vòng 14 ngày kể từ ngày giao hàng ban đầu, trong tình trạng như mới, sẽ đủ điều kiện để được hoàn tiền đầy đủ hoặc tín dụng tại cửa hàng.</li>
                        <li>Tiền hoàn lại sẽ được chuyển về phương thức thanh toán ban đầu được sử dụng khi mua hàng.</li>
                        <li>Khách hàng chịu trách nhiệm về phí vận chuyển khi trả hàng và phí vận chuyển/xử lý ban đầu không được hoàn lại.</li>
                        <li>Tất cả các mặt hàng giảm giá là mua cuối cùng, không được hoàn trả.</li>
                    </ul>
                </div>
                <div class="box">
                    <h4><b>Hỗ Trợ</b></h4>
                    <p>Hãy liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi hoặc thắc mắc nào khác.</p>
                    <p class="text_black-2">Email: Hanoiclothesshop@gmail.com</p>
                    <p class="text_black-2">Điện thoại: 03973525321</p>
                </div>
            </div>
        </div>
    </section>
    


@endsection