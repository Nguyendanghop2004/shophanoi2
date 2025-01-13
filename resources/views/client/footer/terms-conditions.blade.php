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
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    color: #333;
}
.tf-page-title.style-2 {
        background-color: #f0f0f0;
        padding: 50px 0;
        background-image:  url('https://img.freepik.com/premium-photo/beautiful-girl-beige-raincoat-posing-studio-grey-background-girl-motion-free-space-horizontal-banner-website-design-portrait-copy-space_222877-15366.jpg?w=1380'); /* Thay đổi URL ảnh nền ở đây */
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
    }

    .tf-page-title .heading {
        font-size: 36px;
        font-weight: bold;
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Để chữ dễ đọc trên nền */
    }
    
/* Page Title */
.tf-page-title {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: #fff;
    padding: 50px 0;
}

.tf-page-title .heading {
    font-size: 2.5rem;
    font-weight: bold;
    margin: 0;
}

/* Main Section */
.flat-spacing-25 {
    padding: 50px 15px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Boxes */
.tf-main-area-page .box {
    margin-bottom: 30px;
    padding: 20px;
    border-radius: 8px;
    background: #f4f6f9;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.tf-main-area-page .box:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

/* Box Titles */
.tf-main-area-page .box h4 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #444;
    margin-bottom: 15px;
    border-left: 4px solid #6a11cb;
    padding-left: 10px;
}

/* Paragraphs */
.tf-main-area-page .box p {
    font-size: 1rem;
    color: #555;
    margin-bottom: 10px;
    text-align: justify;
    line-height: 1.8;
}

/* Images */
.tf-main-area-page .box img {
    margin-top: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    max-width: 100%;
    height: auto;
}

/* Responsive Design */
@media (max-width: 768px) {
    .tf-page-title .heading {
        font-size: 2rem;
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
        <div class="heading text-center">Điều Khoản & Điều Kiện</div>
      
    </div>
</div>
<!-- /page-title -->
<!-- main-page -->
<section class="flat-spacing-25">
    <div class="container">
        <div class="tf-main-area-page tf-terms-conditions">
            <!-- Section: Thay Đổi Điều Khoản --> 
            <div class="box">
                <h4>Điều Khoản Này Có Thể Thay Đổi</h4>
                <p>Chúng tôi có quyền cập nhật hoặc sửa đổi các điều khoản này bất kỳ lúc nào mà không cần thông báo trước. Việc bạn sử dụng shop.company.com hoặc shop.beetle.com.sg sau bất kỳ thay đổi nào đều được xem như sự đồng ý tuân thủ và bị ràng buộc bởi các điều khoản đã thay đổi. Vì vậy, chúng tôi khuyến khích bạn thường xuyên xem lại các điều khoản này mỗi khi sử dụng trang web này.</p>
                <img  data-src="images/item/tets3.jpg" src="{{ asset('client/assets/images/footer/hop-dong_2906191407.jpg') }}" alt="Ảnh sản phẩm" width="100%">
            </div>
            <!-- Section: Giới Hạn Trách Nhiệm -->
            <div class="box">
                <h4>Giới Hạn Trách Nhiệm</h4>
                <p>The Company Pte Ltd không chịu trách nhiệm đối với bất kỳ thiệt hại nào, hoặc vi-rút có thể lây nhiễm vào thiết bị máy tính, thiết bị viễn thông hoặc tài sản khác của bạn do việc truy cập, sử dụng hoặc tải xuống bất kỳ tài liệu nào từ trang web này.</p>
                <p>Trong bất kỳ trường hợp nào, The Company Pte Ltd và các nhân viên, giám đốc, cổ đông, đại lý hoặc đối tác bán lẻ sẽ không chịu trách nhiệm đối với bất kỳ thiệt hại gián tiếp, đặc biệt hoặc hậu quả nào phát sinh từ việc sử dụng hoặc không thể sử dụng trang web này. Vui lòng tham khảo luật pháp địa phương của bạn để biết thêm chi tiết.</p>
            </div>
            <!-- Section: Bản Quyền và Thương Hiệu -->
            <div class="box">
                <h4>Bản Quyền và Thương Hiệu</h4>
                <p>Trừ khi được chỉ định khác, tất cả nội dung trên trang web này, bao gồm nhưng không giới hạn ở văn bản, hình ảnh, phần mềm và video, đều thuộc quyền sở hữu của The Company Private Limited. Do đó, không được sao chép, sửa đổi hoặc phân phối bất kỳ nội dung nào mà không có sự đồng ý bằng văn bản của chúng tôi.</p>
            </div>
            <!-- Section: Sản Phẩm, Nội Dung và Thông Số Kỹ Thuật -->
            <div class="box">
                <h4>Sản Phẩm, Nội Dung và Thông Số Kỹ Thuật</h4>
                <p>Tất cả thông tin về sản phẩm và giá cả có thể thay đổi mà không cần thông báo trước. Chúng tôi nỗ lực để hiển thị chính xác các thuộc tính sản phẩm, bao gồm màu sắc, nhưng không thể đảm bảo rằng màn hình của bạn sẽ hiển thị màu sắc chính xác.</p>
                <img  data-src="images/item/tets3.jpg" src="{{ asset('client/assets/images/footer/woman-using-smartphone-grocery-store_23-2148216090.avif') }}" alt="Ảnh sản phẩm" width="100%">
            </div>
            <!-- Section: Giới Hạn Vận Chuyển -->
            <div class="box">
                <h4>Giới Hạn Vận Chuyển</h4>
                <p>Các đơn hàng sẽ được giao đến địa chỉ chỉ định của người mua, miễn là địa chỉ đó tuân thủ các quy định vận chuyển. Nguy cơ mất mát và quyền sở hữu đối với sản phẩm sẽ được chuyển giao cho bạn sau khi giao hàng cho đơn vị vận chuyển.</p>
            </div>
            <!-- Section: Thuế và Lệ Phí -->
            <div class="box">
                <h4>Thuế và Lệ Phí</h4>
                <p>Bạn chịu trách nhiệm về các khoản thuế và lệ phí khi nhận hàng tại quốc gia của mình. Tất cả sản phẩm đều có thể bị kiểm tra và đánh thuế tùy theo luật pháp địa phương.</p>
            </div>
            <!-- Section: Tài Khoản của Bạn -->
            <div class="box">
                <h4>Tài Khoản của Bạn</h4>
                <p>Bạn chịu trách nhiệm bảo mật thông tin tài khoản và mật khẩu của mình. Việc bạn sử dụng tài khoản để đặt hàng được xem như bạn đồng ý tuân thủ các điều khoản của chúng tôi.</p>
                <img  data-src="images/item/tets3.jpg" src="{{ asset('client/assets/images/footer/khai niem bao niem thong tin.png') }}" alt="Ảnh sản phẩm" width="100%" height=100px">
            </div>
            <!-- Section: Chính Sách Đổi Trả -->
            <div class="box">
                <h4>Chính Sách Đổi Trả</h4>
                <p>Hàng hóa mới, chưa sử dụng, mua tại cửa hàng có thể được đổi trong vòng 7 ngày với hóa đơn gốc. Chúng tôi không hoàn tiền mặt, nhưng có thể cấp tín dụng sử dụng tại các cửa hàng ở Singapore.</p>
            </div>
            <!-- Section: Giao Tiếp Điện Tử -->
            <div class="box">
                <h4>Giao Tiếp Điện Tử</h4>
                <p>Khi bạn truy cập trang web này hoặc gửi email cho chúng tôi, bạn đồng ý nhận thông tin điện tử từ chúng tôi và các thông báo này đáp ứng yêu cầu pháp lý.</p>
            </div>
        </div>
    </div>
</section>
@endsection