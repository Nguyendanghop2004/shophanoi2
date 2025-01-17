@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
<style>
    /* Page title */
    .tf-page-title.style-2 {
        background-color: #f0f0f0;
        padding: 50px 0;
        background-image: url('https://img.freepik.com/premium-photo/beautiful-girl-beige-raincoat-posing-studio-grey-background-girl-motion-free-space-horizontal-banner-website-design-portrait-copy-space_222877-15366.jpg?w=1380'); /* Thay đổi URL ảnh nền ở đây */
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
    }

    .tf-page-title .heading {
        font-size: 36px;
        font-weight: bold;
        color: black;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Để chữ dễ đọc trên nền */
    }

    /* Section styling */
    .flat-spacing-25 {
        padding: 50px 0;
        background-color: #fafafa;
    }

    .tf-main-area-page {
        max-width: 900px;
        margin: 0 auto;
        font-family: 'Roboto', sans-serif;
        color: #555;
    }

    .tf-main-area-page h4 {
        font-size: 28px;
        font-weight: bold;
        color: #222;
        margin-bottom: 30px;
    }

    .tf-main-area-page p {
        font-size: 16px;
        line-height: 1.8;
        color: #666;
        margin-bottom: 20px;
    }

    /* Image styling */
    .tf-main-area-page img {
        max-width: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }

    /* Centering images */
    .tf-main-area-page img {
        display: block;
        margin: 0 auto;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .tf-page-title .heading {
            font-size: 28px;
        }

        .tf-main-area-page {
            padding: 20px;
        }

        .tf-main-area-page h4 {
            font-size: 24px;
        }

        .tf-main-area-page p {
            font-size: 14px;
        }
    }
</style>


      

        <div class="tf-page-title style-2">
            <div class="container-full">
                <div class="heading text-center"><b>Chính Sách Bảo Mật</b></div>
                <img src="" alt="">
            </div>
        </div>
        <section class="flat-spacing-25">
            <div class="container">
                <div class="tf-main-area-page">
                    <h4><b>Chính Sách Công Ty TNHH</b></h4>
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <img data-src="images/item/tets3.jpg" src="{{ asset('client/assets/images/footer/8decdd05d1cec83dd65930d2f56d3c84.jpg') }}" alt="Ảnh sản phẩm" width="700px">
                    </div>
                    
                    <p>Công Ty TNHH và mỗi công ty con, công ty mẹ, công ty liên kết của chúng tôi (sau đây gọi là “chúng
                        tôi”) được xem là vận hành Website này nhận thức rõ rằng bạn quan tâm đến cách thông tin của bạn
                        được sử dụng và chia sẻ. Chúng tôi đã tạo Chính Sách Bảo Mật này để thông báo cho bạn biết thông tin
                        nào chúng tôi thu thập trên Website, cách chúng tôi sử dụng thông tin của bạn và các lựa chọn mà bạn
                        có liên quan đến việc thu thập và sử dụng thông tin đó. Vui lòng đọc kỹ Chính Sách Bảo Mật này. Việc
                        bạn sử dụng Website đồng nghĩa với việc bạn đã đọc và chấp nhận các thực tiễn bảo mật của chúng tôi
                        được nêu trong Chính Sách Bảo Mật này.</p>
                    <p>Vui lòng lưu ý rằng các thực tiễn được mô tả trong Chính Sách Bảo Mật này áp dụng đối với thông tin
                        mà chúng tôi, hoặc các công ty con, công ty liên kết hay đại lý của chúng tôi thu thập: (i) thông
                        qua Website này, (ii) khi có thể, thông qua Bộ phận Dịch vụ Khách hàng của chúng tôi liên quan đến
                        Website này, (iii) thông qua thông tin được cung cấp cho chúng tôi tại các cửa hàng bán lẻ độc lập
                        của chúng tôi, và (iv) thông qua thông tin được cung cấp cho chúng tôi liên quan đến các chương
                        trình khuyến mãi và rút thăm trúng thưởng.</p>
                    <p>Chúng tôi không chịu trách nhiệm đối với nội dung hoặc các thực tiễn bảo mật trên bất kỳ trang web
                        nào khác.</p>
                        <div style="display: flex; justify-content: center; align-items: center;">
                            <img data-src="images/item/tets3.jpg" src="{{ asset('client/assets/images/footer/8f549f849bc483e8e1f5aa4a6032533b.jpg') }}" alt="Ảnh sản phẩm" width="700px">
                        </div>
                        
                    <p>Chúng tôi có quyền, theo quyết định riêng, sửa đổi, cập nhật, bổ sung, ngừng hoạt động, loại bỏ hoặc
                        thay đổi bất kỳ phần nào của Chính Sách Bảo Mật này, toàn bộ hoặc một phần, vào bất kỳ thời điểm
                        nào. Khi chúng tôi sửa đổi Chính Sách Bảo Mật này, chúng tôi sẽ cập nhật ngày “cập nhật lần cuối”
                        được ghi ở đầu Chính Sách Bảo Mật này.</p>
                    <p>Nếu bạn cung cấp thông tin cho chúng tôi hoặc truy cập hoặc sử dụng Website dưới bất kỳ hình thức nào
                        sau khi Chính Sách Bảo Mật này đã được thay đổi, bạn sẽ được xem là đã đồng ý một cách vô điều kiện
                        và chấp nhận các thay đổi đó. Phiên bản mới nhất của Chính Sách Bảo Mật sẽ được đăng trên Website và
                        sẽ thay thế tất cả các phiên bản trước đó của Chính Sách Bảo Mật này.</p>
                    <p>Nếu bạn có bất kỳ câu hỏi nào liên quan đến Chính Sách Bảo Mật này, bạn nên liên hệ với Bộ phận Dịch
                        vụ Khách hàng của chúng tôi qua email tại Hanoiclothesshop@gmail.com</p>
                </div>
            </div>
        </section>
    </section>
@endsection
