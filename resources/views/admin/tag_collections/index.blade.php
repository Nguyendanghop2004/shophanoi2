@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Bộ Sưu Tập</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Sách Bộ Sưu Tập</h4>
            <div class="card-header-action">
                <a href="{{ route('tag_collections.create') }}" class="btn btn-primary">Thêm Bộ Sưu Tập</a>
            </div>
        </div>

        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0"></div>
                <div class="card-header-action">
                    <form class="form-inline" method="GET" action="{{ route('tag_collections.index') }}">
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
                            <th scope="col">Tên Bộ Sưu Tập</th>
                            <th scope="col">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tagCollections->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center text-danger">Không có bộ sưu tập nào.</td>
                            </tr>
                        @else
                            @foreach ($tagCollections as $index => $tagCollection)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $tagCollection->name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <a href="{{ route('tag_collections.edit', $tagCollection->id) }}" class="btn btn-warning ml-2"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('tag_collections.destroy', $tagCollection->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
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
                    <li class="page-item {{ $tagCollections->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $tagCollections->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>

                    @foreach ($tagCollections->getUrlRange(1, $tagCollections->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $tagCollections->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ $tagCollections->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $tagCollections->nextPageUrl() }}" aria-label="Next">
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
