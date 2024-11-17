@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Chất Liệu</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Chất Liệu</h4>
            <div class="card-header-action">
                <a href="{{ route('tags.create') }}" class="btn btn-primary">Thêm Chất Liệu</a>
            </div>
        </div>

        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <form class="form-inline" method="GET" action="{{ route('material.index') }}">
                    <div class="search-element">
                        <input class="form-control" type="search" placeholder="Tìm kiếm..." aria-label="Search" name="search" value="{{ request()->search }}" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên Chất Liệu</th>
                            <th scope="col">Mô Tả</th>
                            <th scope="col">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tagMaterials->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-danger">Không có Chất Liệu nào.</td>
                            </tr>
                        @else
                            @foreach ($tagMaterials as $index => $tag)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->description }}</td>
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-warning ml-2"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
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

    <!-- Phân trang -->
    <div class="card-body mx-auto">
        <div class="buttons">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item {{ $tagMaterials->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $tagMaterials->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    @foreach ($tagMaterials->getUrlRange(1, $tagMaterials->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $tagMaterials->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="page-item {{ $tagMaterials->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $tagMaterials->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>
@endsection

