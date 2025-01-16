
@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Mục Sản Phẩm</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Danh Mục Sản Phẩm</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.categories.add') }}" class="btn btn-primary">
                    Tạo Mới
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0"></div>
                <div class="card-header-action">
                    <form class="form-inline" method="GET" action="{{ route('admin.categories.list') }}">
                        <div class="search-element">
                            <input class="form-control" type="search" placeholder="Tìm kiếm..." aria-label="Search"
                                name="name" value="{{ $searchs }}" data-width="250">
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
                                <th scope="col">#</th>
                                <th scope="col">Ảnh Danh Mục</th>
                                <th scope="col">Tên Danh Mục</th>
                                <th scope="col">Đường Dẫn Thân Thiện</th>
                                <th scope="col">Mô Tả</th>
                                <th scope="col">Danh Mục Cha</th> 
                                <th scope="col">Trạng Thái</th>
                                <th scope="col">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                           @if($categories->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center text-danger">Không có danh mục nào.</td>
                                </tr>
                            @else
                                @foreach ($categories as $index => $cate)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><img src="{{ Storage::url($cate->image_path) }}" alt="Ảnh danh mục" width="100px" height="60px"></td>
                                        <td>{{ $cate->name }}</td>
                                        <td>{{ $cate->slug }}</td>
                                        <td>{{ $cate->description }}</td>
                                        <td>{{ $cate->parent ? $cate->parent->name : 'Không có' }}</td>
                                        <td>
                                            <span class="{{ $cate->status == 1 ? 'badge badge-success' : 'badge badge-danger' }}">
                                                {{ $cate->status == 1 ? 'hiển thị' : 'không hiển thị' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                @if(!$cate->parent_id)
                                                    <form action="{{ route('admin.categories.toggleStatus', $cate->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        <button type="button" class="btn btn-info ml-2" onclick="confirmStatusChange('{{ $cate->id }}')">
                                                            @if($cate->status == 1)
                                                                <i class="fas fa-eye" style="color: green;"></i>
                                                            @else
                                                                <i class="fas fa-eye-slash" style="color: red;"></i>
                                                            @endif
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.categories.toggleStatus', $cate->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="button" class="btn btn-info ml-2" onclick="confirmStatusChange('{{ $cate->id }}')">
                                                            @if($cate->status == 1)
                                                                <i class="fas fa-eye" style="color: green;"></i>
                                                            @else
                                                                <i class="fas fa-eye-slash" style="color: red;"></i>
                                                            @endif
                                                        </button>
                                                    </form>

                                                    <a href="{{ route('admin.categories.edit', ['id' => Crypt::encryptString($cate->id)]) }}" class="btn btn-warning ml-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <!-- <form action="{{ route('admin.categories.delete', $cate->id) }}" method="post" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger ml-2" onclick="confirmDelete('{{ $cate->id }}')">
                                                            <i class="fas fa-trash" style="color: #ffffff;"></i>
                                                        </button>
                                                    </form> -->
                                                </div>
                                            @endif
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
                        <li class="page-item {{ $categories->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $categories->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $categories->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ $categories->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $categories->nextPageUrl() }}" aria-label="Next">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  
    function confirmStatusChange(categoryId) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn thay đổi trạng thái danh mục này?',
            text: "Bạn không thể hoàn tác thay đổi này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
         
                const form = document.querySelector(`form[action="{{ route('admin.categories.toggleStatus', '') }}/${categoryId}"]`);
                form.submit();
            }
        });
    }

 
    function confirmDelete(categoryId) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa danh mục này?',
            text: "Danh mục sẽ bị xóa vĩnh viễn!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
             
                const form = document.querySelector(`form[action="{{ route('admin.categories.delete', '') }}/${categoryId}"]`);
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
