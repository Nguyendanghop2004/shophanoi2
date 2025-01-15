@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Đánh Giá</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Đánh Giá</h4>
        </div>

        <div class="card-body">
            @if ($reviews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Đánh Giá</th>
                                <th>Nhận Xét</th>
                                <th>Người Dùng</th>
                                <th>Mã Đơn Hàng</th>
                                <th>Thời Gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $index => $review)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $review->product->product_name ?? 'N/A' }}</td>
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
                </div>

                <div class="card-body mx-auto">
                    <div class="buttons">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ $reviews->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $reviews->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>

                                @foreach ($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $reviews->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ $reviews->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $reviews->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">Không có đánh giá nào!</div>
            @endif
        </div>
    </div>
</section>
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
