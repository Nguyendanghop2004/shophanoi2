@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="container text-center mt-5">
        <div class="welcome-card p-5 bg-primary text-white rounded shadow-lg">
            <!-- Tiêu đề chào mừng -->
            <h1 class="display-4 font-weight-bold mb-4">Chào mừng đến HaNoiClothesShop!</h1>
            
            <!-- Hiệu ứng chữ chạy -->
            <div class="marquee-container my-3">
                <p class="marquee">
                    Chúc bạn một ngày làm việc hiệu quả và tràn đầy năng lượng! &nbsp;&nbsp;|&nbsp;&nbsp;
                    Khám phá hệ thống quản lý của chúng tôi!
                </p>
            </div>

            <!-- Khu vực để ảnh -->
        </div>
    </div>
</section>

<!-- Custom CSS -->
<style>
    .marquee-container {
        overflow: hidden;
        white-space: nowrap;
        position: relative;
    }

    .marquee {
        display: inline-block;
        animation: marquee 10s linear infinite;
        font-size: 1.25rem;
        font-weight: bold;
    }

    @keyframes marquee {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }

    .image-container img {
        max-width: 100%;
        height: auto;
    }
</style>
@endsection
