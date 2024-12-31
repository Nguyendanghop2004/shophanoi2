@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Màu Sắc và Kích Thước</h1>
    </div>

    <div class="row">
        <!-- Bảng Màu Sắc -->
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Danh Sách Màu Sắc</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">Thêm Màu Sắc</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <form class="form-inline" method="GET" action="{{ route('admin.colors.index') }}">
                            <div class="search-element">
                                <input class="form-control" type="search" placeholder="Tìm kiếm màu sắc..." aria-label="Search" name="searchColor" value="{{ request()->searchColor }}" data-width="250">
                                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên Màu Sắc</th>
                                    <th scope="col">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($colors->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center text-danger">Không có màu sắc nào.</td>
                                    </tr>
                                @else
                                    @foreach ($colors as $index => $color)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $color->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start">
                                                    <a href="{{ route('admin.colors.edit', $color->id) }}" class="btn btn-warning ml-2"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('admin.colors.destroy', $color->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng Kích Thước -->
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Danh Sách Kích Thước</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">Thêm Kích Thước</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <form class="form-inline" method="GET" action="{{ route('admin.sizes.index') }}">
                            <div class="search-element">
                                <input class="form-control" type="search" placeholder="Tìm kiếm kích thước..." aria-label="Search" name="searchSize" value="{{ request()->searchSize }}" data-width="250">
                                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>                        
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên Kích Thước</th>
                                    <th scope="col">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($sizes->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center text-danger">Không có kích thước nào.</td>
                                    </tr>
                                @else
                                    @foreach ($sizes as $index => $size)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $size->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start">
                                                    <a href="{{ route('admin.sizes.edit', $size->id) }}" class="btn btn-warning ml-2"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('admin.sizes.destroy', $size->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Phân trang cho cả 2 bảng -->
    <div class="card-body mx-auto">
        <div class="buttons">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item {{ $colors->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $colors->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>

                    @foreach ($colors->getUrlRange(1, $colors->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $colors->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ $colors->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $colors->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </nav>
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
