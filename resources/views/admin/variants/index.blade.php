@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Biến Thể Sản Phẩm</h1>
    </div>

    <a href="{{ route('variants.create') }}" class="btn btn-primary mb-3">Thêm Biến Thể Sản Phẩm</a>

    <div class="card card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="section-title mt-0">
                Danh sách biến thể sản phẩm
            </div>
            <div class="card-header-action">
                <form action="{{ route('variants.search') }}" method="GET" class="form-inline">
                    <div class="search-element">
                        <input class="form-control" name="search" type="text" placeholder="Tìm kiếm" aria-label="Search" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Sản Phẩm</th>
                            <th scope="col">Màu Sắc</th>
                            <th scope="col">Kích Thước</th>
                            <th scope="col">Số Lượng Tồn Kho</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($variants as $variant)
                            <tr>
                                <td>{{ $variant->product->name }}</td>
                                <td>{{ $variant->color->name }}</td>
                                <td>{{ $variant->size->name }}</td>
                                <td>{{ $variant->stock_quantity }}</td>
                                <td>{{ number_format($variant->price, 2) }} VNĐ</td>
                                <td>
                                    <a href="{{ route('variants.edit', $variant->id) }}" class="btn btn-icon btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('variants.destroy', $variant->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body mx-auto">
            <div class="buttons">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $variants->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $variants->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        @foreach ($variants->getUrlRange(1, $variants->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $variants->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ $variants->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $variants->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">»</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<script>
    $(document).ready(function () {
        toastr.options = {
            "closeButton": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });
</script>
@endsection
