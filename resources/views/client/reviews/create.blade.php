@extends('client.layouts.master')

@section('content')
<div class="container mt-4">
    <h5 class="text-center">Viết đánh giá cho đơn hàng #{{ $order->order_code }}</h5>

    <form action="{{ route('client.reviews.store') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <input type="hidden" name="product_id" value="{{ $product->id }}"> <!-- Đảm bảo truyền product_id -->

        <!-- Thông tin sản phẩm -->
        <div class="mb-4">
            <div class="d-flex gap-3 align-items-center">
                <img src="{{ Storage::url($order->orderItems->first()->image_url) }}" alt="Product Image" class="img-fluid" style="width: 100px; height: auto;">

                <div>
                    <h5 class="mb-1">{{ $order->orderItems->first()->product_name }}</h5>
                    <p class="text-muted mb-1">Size: {{ $order->orderItems->first()->size_name }}</p>
                    <p class="text-muted mb-1">Màu sắc: {{ $order->orderItems->first()->color_name }}</p>
                </div>
            </div>
        </div>

        <!-- Đánh giá sao -->
        <div class="mb-4">
            <label for="rating" class="form-label fw-bold fs-5">Đánh giá của bạn</label>
            <div class="rating-stars-container d-flex gap-2">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="star {{ old('rating') >= $i ? 'selected' : '' }}" data-star-value="{{ $i }}">
                        <i class="bi bi-star fs-3"></i>
                    </span>
                @endfor
            </div>
            <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}">
            @error('rating') <!-- Hiển thị lỗi nếu có -->
                <div class="text-danger">Bạn cần chọn số sao</div>
            @enderror
        </div>
        
        <!-- Nhận xét -->
        <div class="mb-3">
            <label for="comment" class="form-label">Nhận xét</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Viết nhận xét (tùy chọn)">{{ old('comment') }}</textarea>
            @error('comment') <!-- Hiển thị lỗi nếu có -->
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Gửi đánh giá</button>
    </form>
</div>
@endsection

<style>
    .rating-stars-container {
        display: flex;
        cursor: pointer;
    }

    .rating-stars-container .star i {
        color: #ffc107; 
        transition: color 0.3s ease;
    }

    .rating-stars-container .star.selected i {
        color: #ffc107; 
    }

    .rating-stars-container .star:hover i,
    .rating-stars-container .star:hover ~ .star i {
        color: #ffc107; 
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.rating-stars-container .star');
        const ratingInput = document.getElementById('rating');

        stars.forEach((star, index) => {
            star.addEventListener('click', function () {
                const selectedRating = index + 1;

                // Gán giá trị rating vào input ẩn
                ratingInput.value = selectedRating;

                // Cập nhật giao diện sao đã chọn
                stars.forEach((s, idx) => {
                    const icon = s.querySelector('i');
                    if (idx < selectedRating) {
                        icon.classList.remove('bi-star'); 
                        icon.classList.add('bi-star-fill'); 
                    } else {
                        icon.classList.remove('bi-star-fill'); 
                        icon.classList.add('bi-star'); 
                    }
                });
            });
        });
    });
</script>
