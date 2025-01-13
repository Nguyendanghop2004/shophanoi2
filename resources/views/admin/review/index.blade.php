@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Danh sách đánh giá</h2>

    @if ($reviews->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên sản phẩm</th>
                    <th>Đánh giá</th>
                    <th>Nhận xét</th>
                    <th>Người dùng</th>
                    <th>Mã đơn hàng</th>
                    <th>Thời gian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $index => $review)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $review->product->name ?? 'N/A' }}</td>
                        <td>
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}" style="color: #ffc107;"></i>
                            @endfor
                        </td>
                        <td>{{ $review->comment ?? 'Không có nhận xét' }}</td>
                        <td>{{ $review->user->name ?? 'Khách hàng ẩn danh' }}</td>
                        <td>{{ $review->order->order_code ?? 'N/A' }}</td>
                        <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center">
            {{ $reviews->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">Không có đánh giá nào!</div>
    @endif
</div>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
