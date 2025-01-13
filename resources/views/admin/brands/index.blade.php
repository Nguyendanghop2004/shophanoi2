@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Thương Hiệu</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Thương Hiệu</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">Thêm Thương Hiệu Mới</a>
            </div>
        </div>

        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0"></div>
                <div class="card-header-action">
                    <form class="form-inline" method="GET" action="{{ route('admin.brands.index') }}">
                        <div class="search-element">
                            <input class="form-control" type="search" placeholder="Tìm kiếm..." aria-label="Search" name="search" value="{{ request()->search }}" data-width="250">
                            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên Thương Hiệu</th>
                            <th scope="col">Ảnh Thương Hiệu</th>
                            <th scope="col">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($brands->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-danger">Không có thương hiệu nào.</td>
                            </tr>
                        @else
                            @foreach ($brands as $index => $brand)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        @if ($brand->image_brand_url)
                                            <img src="{{ asset('storage/' . $brand->image_brand_url) }}" alt="Ảnh thương hiệu" style="width: 100px; height: auto; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-warning ml-2"><i class="fas fa-edit"></i></a>
                                            
                                            <!-- Form Xóa với id động -->
                                            <form id="delete-form-{{ $brand->id }}" action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger ml-2" onclick="confirmDelete({{ $brand->id }})"><i class="fas fa-trash"></i></button>
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

    <div class="card-body mx-auto">
        <div class="buttons">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item {{ $brands->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $brands->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">«</span>
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
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

   
    function confirmDelete(brandId) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa thương hiệu này?',
            text: "Thương hiệu sẽ bị xóa vĩnh viễn!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
              
                const form = document.querySelector(`#delete-form-${brandId}`);
                form.submit();
            }
        });
    }
</script>
<script>
     document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });

   
</script>
@endsection
