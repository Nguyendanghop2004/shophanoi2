@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Màu Sắc</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Màu Sắc</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">Thêm Màu Sắc</a>
            </div>
        </div>

        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0"></div>
                <div class="card-header-action">
                    <form class="form-inline" method="GET" action="{{ route('admin.colors.index') }}">
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
                            <th scope="col">Tên Màu Sắc</th>
                            <th scope="col">SKU Color</th> <!-- Thêm cột SKU Color -->
                            <th scope="col">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($colors->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-danger">Không có màu sắc nào.</td>
                            </tr>
                        @else
                            @foreach ($colors as $index => $color)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $color->name }}</td>
                                    <td>{{ $color->sku_color }}</td> <!-- Hiển thị SKU Color -->
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <a href="{{ route('admin.colors.edit', $color->id) }}" class="btn btn-warning ml-2"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.colors.destroy', $color->id) }}" method="POST" style="display:inline-block" onsubmit="event.preventDefault(); confirmDelete('{{ $color->id }}')">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(colorId) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa màu sắc này?',
            text: "Màu sắc sẽ bị xóa vĩnh viễn!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi form xóa khi người dùng xác nhận
                const form = document.querySelector(`form[action="{{ route('admin.colors.destroy', '') }}/${colorId}"]`);
                form.submit();
            }
        });
    }

    // Hiển thị thông báo thành công hoặc lỗi sau khi hành động
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
