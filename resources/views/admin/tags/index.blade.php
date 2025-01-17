@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Tags</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Tags</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">Thêm Tag Mới</a>
            </div>
        </div>

        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0"></div>
                <div class="card-header-action">
                    <form class="form-inline" method="GET" action="{{ route('admin.tags.index') }}">
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
                            <th scope="col">Tên Tag</th>
                            <th scope="col">Loại</th>
                            <th scope="col">Ảnh Nền</th>
                            <th scope="col">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tags->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-danger">Không có tags nào.</td>
                            </tr>
                        @else
                            @foreach ($tags as $index => $tag)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->type }}</td>
                                    <td>
                                        @if ($tag->background_image)
                                            <img src="{{ asset('storage/' . $tag->background_image) }}" alt="Ảnh nền" style="width: 100px; height: auto; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-warning ml-2"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" style="display:inline-block" onsubmit="event.preventDefault(); confirmDelete('{{ $tag->id }}')">
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
                    <li class="page-item {{ $tags->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $tags->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>

                    @foreach ($tags->getUrlRange(1, $tags->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $tags->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ $tags->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $tags->nextPageUrl() }}" aria-label="Next">
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
    function confirmDelete(tagId) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa tag này?',
            text: "Tag sẽ bị xóa vĩnh viễn!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gửi form xóa khi người dùng xác nhận
                const form = document.querySelector(`form[action="{{ route('admin.tags.destroy', '') }}/${tagId}"]`);
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
