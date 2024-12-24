@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Thanh Trượt</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Thùng Rác Thanh Trượt Đã Xóa </h4>
            </div>
            <div class="card-body">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="section-title mt-0">
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="form-inline" method="GET" action="{{ route('admin.slider.index') }}">
                            <div class="search-element">
                                <input class="form-control" name="search" type="search" placeholder="Search"
                                    aria-label="Search" data-width="250" value="{{ request()->input('search') }}">
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
                                    <th scope="col">Ảnh Thanh Trượt</th>
                                    <th scope="col">Tiêu Đề</th>
                                    <th scope="col">Mô tả ngắn</th>
                                    <th scope="col">Đường dẫn Thanh trượt</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sliders as $slider)
                                    <tr>
                                        <th scope="row">{{ $slider->id }}</th>
                                        <td><div style="padding: 5px;"><img src="{{ asset('storage/' . $slider->image_path) }}" style="max-height: 100px;max-width: 100px" alt=""></div></td>
                                        <td>{{ $slider->title }}</td>
                                        <td>{{ $slider->short_description }}</td>
                                        <td>{{ $slider->link_url }}</td>
                                        <td>

                                            @if ($slider->is_active == true)
                                                <span class="badge badge-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-warning">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td scope="row">
                                            <div class="d-flex justify-content-start">
                                                <form action="{{ route('admin.slider.restore', $slider->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success"
                                                        onclick="return confirm('Bạn có chắc chắn muốn khôi phục slider này?');">
                                                        <i class="fas fa-recycle"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.slider.forceDelete', $slider->id) }}"
                                                    method="POST" style="display: inline;" class="ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn slider này?');">
                                                        <i class="fas fa-trash" style="color: #ffffff;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-body mx-auto">
                <div class="buttons">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item {{ $sliders->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $sliders->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($page = 1; $page <= $sliders->lastPage(); $page++)
                                <li class="page-item {{ $page == $sliders->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $sliders->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $sliders->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $sliders->nextPageUrl() }}" aria-label="Next">
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
@endsection
@push('scripts')
@endpush