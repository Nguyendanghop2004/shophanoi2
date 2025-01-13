@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
<style>
    /* Global Styles */
body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    color: #333;
    background: linear-gradient(to bottom, #e3f2fd, #ffffff);
}

/* Page Title */
.tf-page-title {
    background: url('https://img.freepik.com/premium-photo/beautiful-girl-beige-raincoat-posing-studio-grey-background-girl-motion-free-space-horizontal-banner-website-design-portrait-copy-space_222877-15362.jpg?w=1380' ) no-repeat center center;
    background-size: cover;
    color: #fff;
    padding: 60px 0;
    text-align: center;
    box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.4);
}

.tf-page-title .heading {
    font-size: 3rem;
    font-weight: bold;
    margin: 0;
    text-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5);
}

/* Main Section */
.flat-spacing-25 {
    padding: 50px 15px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

/* Content Boxes */
.tf-main-area-page .box {
    margin-bottom: 30px;
    padding: 20px;
    border-radius: 12px;
    background: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
}

.tf-main-area-page .box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
}

/* Box Titles */
.tf-main-area-page .box h4 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #444;
    margin-bottom: 15px;
    border-left: 6px solid #6a11cb;
    padding-left: 15px;
}

/* Paragraphs */
.tf-main-area-page .box p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 10px;
    text-align: justify;
    line-height: 1.8;
}

.tf-main-area-page .box p a {
    color: #2575fc;
    text-decoration: none;
}

.tf-main-area-page .box p a:hover {
    text-decoration: underline;
}

/* Background Decorations */
.tf-main-area-page::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('https://source.unsplash.com/1920x1080/?packages') no-repeat center;
    background-size: cover;
    opacity: 0.05;
    z-index: -1;
}

/* Responsive Design */
@media (max-width: 768px) {
    .tf-page-title .heading {
        font-size: 2.5rem;
    }

    .tf-main-area-page .box h4 {
        font-size: 1.5rem;
    }

    .tf-main-area-page .box p {
        font-size: 0.95rem;
    }
}

</style>
<div class="tf-page-title style-2">
    <div class="container-full">
        <div class="heading text-center">Giao Hàng & Trả Hàng</div>
    </div>
</div>
<!-- /page-title -->
<!-- main-page -->
<section class="flat-spacing-25">
    <div class="container">
        <div class="tf-main-area-page tf-page-delivery">
            <!-- Delivery Section -->
            <div class="box">
                <h4>Giao Hàng</h4>
                <p>Tất cả đơn hàng được vận chuyển qua UPS Express.</p>
                <p>Miễn phí vận chuyển cho đơn hàng trên 250 USD.</p>
                <p>Tất cả đơn hàng đều được cung cấp số theo dõi UPS.</p>
                <img  data-src="images/item/tets3.jpg" src="{{ asset('client/assets/images/footer/th (1).jpg') }}" alt="Ảnh sản phẩm" width="300px">
            </div>
            <!-- Returns Section -->
            <div class="box">
                <h4>Trả Hàng</h4>
                <p>Các mặt hàng được trả lại trong vòng 14 ngày kể từ ngày giao hàng ban đầu, trong tình trạng như mới, sẽ đủ điều kiện để được hoàn tiền đầy đủ hoặc tín dụng tại cửa hàng.</p>
                <p>Tiền hoàn lại sẽ được chuyển về phương thức thanh toán ban đầu được sử dụng khi mua hàng.</p>
                <p>Khách hàng chịu trách nhiệm về phí vận chuyển khi trả hàng và phí vận chuyển/xử lý ban đầu không được hoàn lại.</p>
                <p>Tất cả các mặt hàng giảm giá là mua cuối cùng, không được hoàn trả.</p>

                <img  data-src="images/item/tets3.jpg" src="{{ asset('client/assets/images/footer/ed3c2b1a74548702b597a52a2fa30e84.jpg') }}" alt="Ảnh sản phẩm" width="300px">
            </div>
            <!-- Help Section -->
            <div class="box">
                <h4>Hỗ Trợ</h4>
                <p>Hãy liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi hoặc thắc mắc nào khác.</p>
                <p>Email: <a href="mailto:contact@domain.com" class="cf-mail">contact@domain.com</a></p>
                <p>Điện thoại: +1 (23) 456 789</p>
                <img  data-src="images/item/tets3.jpg" src="{{ asset('client/assets/images/footer/ca624a24c5e50bcc3eb5e2a4dd6dab11.jpg') }}" alt="Ảnh sản phẩm" width="300px">
            </div>
        </div>
    </div>
</section>



@endsection