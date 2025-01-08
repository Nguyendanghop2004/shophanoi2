@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
<div class="container mt-4">
    <h5 class="text-center">Viết đánh giá cho đơn hàng #{{ $order->order_code }}</h5>

    <form action="{{ route('client.reviews.store') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        @foreach ($order->orderItems as $orderItem)
        @php
            $isReviewed = in_array($orderItem->product_id, $reviewedProducts);
        @endphp
    
        <div class="mb-4">
            <div class="d-flex gap-3 align-items-center">
                <img src="{{ Storage::url($orderItem->image_url) }}" alt="Product Image" class="img-fluid" style="width: 100px; height: auto;">
                <div>
                    <h5 class="mb-1">{{ $orderItem->product_name }}</h5>
                    <p class="text-muted mb-1">Size: {{ $orderItem->size_name }}</p>
                    <p class="text-muted mb-1">Màu sắc: {{ $orderItem->color_name }}</p>
                </div>
            </div>
        </div>
    
        <!-- Kiểm tra xem đã đánh giá chưa -->
        @if (!$isReviewed)
            <!-- Đánh giá sao cho sản phẩm -->
            <div class="mb-4">
                <label for="rating_{{ $orderItem->product_id }}" class="form-label fw-bold fs-5">Đánh giá cho {{ $orderItem->product_name }}</label>
                <div class="rating-stars-container d-flex gap-2" data-product-id="{{ $orderItem->product_id }}">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-star-value="{{ $i }}" data-product-id="{{ $orderItem->product_id }}">
                            <i class="bi {{ (old('ratings.' . $orderItem->product_id, 0) >= $i) ? 'bi-star-fill' : 'bi-star' }} fs-3"></i>
                        </span>
                    @endfor
                </div>
                <input type="hidden" name="ratings[{{ $orderItem->product_id }}]" id="rating_{{ $orderItem->product_id }}" value="{{ old('ratings.' . $orderItem->product_id, 0) }}">
                @error("ratings.{$orderItem->product_id}")
                    <div class="text-danger">Bạn cần chọn số sao</div>
                @enderror
            </div>
    
            <!-- Nhận xét cho sản phẩm -->
            <div class="mb-3">
                <label for="comment_{{ $orderItem->product_id }}" class="form-label">Nhận xét cho {{ $orderItem->product_name }}</label>
                <textarea name="comments[{{ $orderItem->product_id }}]" id="comment_{{ $orderItem->product_id }}" class="form-control" rows="4" placeholder="Viết nhận xét (tùy chọn)">{{ old('comments.' . $orderItem->product_id) }}</textarea>
                @error("comments.{$orderItem->product_id}")
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <!-- Input hidden để lưu product_id -->
            <input type="hidden" name="product_ids[]" value="{{ $orderItem->product_id }}">
        @else
            <div class="alert alert-info">Sản phẩm này đã được đánh giá</div>
        @endif
    @endforeach
    
    @if (!$isReviewed)
        <button type="submit" class="btn btn-success">Gửi đánh giá</button>
    @else
    <div class="alert alert-info">Cảm ơn bạn đã mua hàng của chúg tôi</div>
    @endif
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

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const selectedRating = parseInt(star.getAttribute('data-star-value'));
                const productId = star.getAttribute('data-product-id');
                const ratingInput = document.getElementById('rating_' + productId);

                // Gán giá trị rating vào input ẩn cho sản phẩm
                ratingInput.value = selectedRating;

                // Cập nhật giao diện sao đã chọn
                const productStars = document.querySelectorAll(`.rating-stars-container[data-product-id="${productId}"] .star`);
                productStars.forEach((s, idx) => {
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
