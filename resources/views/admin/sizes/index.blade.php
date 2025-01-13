@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Kích Thước</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Kích Thước</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">Thêm Kích Thước</a>
            </div>
        </div>

        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0"></div>
                <div class="card-header-action">
                    <form class="form-inline" method="GET" action="{{ route('admin.sizes.index') }}">
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
                                            <form id="delete-form-{{ $size->id }}" action="{{ route('admin.sizes.destroy', $size->id) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger ml-2" onclick="confirmDelete({{ $size->id }})"><i class="fas fa-trash"></i></button>
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
                    <li class="page-item {{ $sizes->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $sizes->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>

                    @foreach ($sizes->getUrlRange(1, $sizes->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $sizes->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ $sizes->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $sizes->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(sizeId) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa kích thước này?',
            text: "Kích thước sẽ bị xóa vĩnh viễn!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi form xóa khi người dùng xác nhận
                document.getElementById('delete-form-' + sizeId).submit();
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 10000
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 10000
            });
        @endif
    });
</script>

@endsection
