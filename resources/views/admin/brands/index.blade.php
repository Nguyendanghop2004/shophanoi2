@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Thương Hiệu</h1>
    </div>

    <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">Thêm Thương Hiệu</a>

    <div class="card card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="section-title mt-0">
                Danh sách thương hiệu
            </div>
            <div class="card-header-action">
                <form action="{{ route('brands.index') }}" method="GET" class="form-inline">
                    <div class="search-element">
                        <input class="form-control" name="search" type="text" placeholder="Tìm kiếm" aria-label="Search" data-width="250" value="{{ request()->search }}">
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
                            <th scope="col">Tên Thương Hiệu</th>
                            <th scope="col">Ảnh Thương Hiệu</th>
                            <th scope="col">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td>{{ $brand->name }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $brand->image_brand_url) }}" alt="Brand Image" style="width: 150px; height: 150px; object-fit: cover;">
                                </td>
                                <td>
                                    <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-icon btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
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
                        <li class="page-item {{ $brands->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $brands->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        @foreach ($brands->getUrlRange(1, $brands->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $brands->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ $brands->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $brands->nextPageUrl() }}" aria-label="Next">
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

<!-- Toastr Notifications -->
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
