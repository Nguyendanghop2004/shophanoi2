@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Thanh Trượt</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Thanh Trượt của danh mục </h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.slider.create') }}" class="btn btn-primary">
                        Tạo Mới
                    </a>
                </div>
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
                                    <th scope="col">Thứ Tự</th>
                                    <th scope="col">Đường dẫn Thanh trượt</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="sortableTable">
                                @foreach ($sliders as $slider)
                                    <tr data-id="{{ $slider->id }}">
                                        <th scope="row">{{ $slider->id }}</th>
                                        <td><div style="padding: 5px;"><img src="{{ asset('storage/' . $slider->image_path) }}" alt="" style="max-height: 100px"></div></td>
                                        <td>{{ $slider->title }}</td>
                                        <td>{{ $slider->short_description }}</td>
                                        <td>{{ $slider->position }}</td>
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
                                                <div> <a href="{{ route('admin.slider.edit', $slider->id) }}"
                                                        class="btn btn-warning"><i class="fas fa-edit"
                                                            style="color: #ffffff;"></i></a>
                                                </div>
                                                <div>
                                                    <form action="{{ route('admin.slider.destroy', $slider->id) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger ml-2"><i
                                                                class="fas fa-trash" style="color: #ffffff;"></i></button>
                                                    </form>
                                                </div>
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
    <script>
        $(document).ready(function() {
            // Sử dụng jQuery UI để tạo khả năng kéo thả cho bảng
            $("#sortableTable").sortable({
                placeholder: "ui-state-highlight", // Định dạng hiển thị khi kéo thả
                update: function(event, ui) {
                    // Khi thứ tự thay đổi, lấy dữ liệu từ các hàng đã sắp xếp
                    var sortedIDs = $("#sortableTable tr").map(function() {
                        return $(this).data(
                            'id'); // Lấy giá trị 'data-id' từ từng hàng (đây là cột id)
                    }).get();

                    // Gửi yêu cầu AJAX để cập nhật thứ tự trong cơ sở dữ liệu
                    $.ajax({
                        url: '{{ route('admin.slider.updateOrder') }}', // Đường dẫn tới route xử lý cập nhật thứ tự
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Token bảo mật CSRF
                            order: sortedIDs, // Mảng ID của các slider theo thứ tự mới
                        },
                        success: function(response) {
                            // Xử lý sau khi cập nhật thành công
                            console.log(response
                                .message); // In ra thông báo thành công (từ server)
                            alert(
                                'Cập nhật thứ tự thành công!'); // Thông báo cho người dùng
                        },
                        error: function(xhr, status, error) {
                            // Ghi lại chi tiết lỗi trong console
                            console.error(xhr.responseText);
                            console.error(error);
                            console.error(status);
                            alert('Có lỗi xảy ra khi cập nhật thứ tự!'); // Thông báo lỗi
                        }
                    });
                }
            });

            // Kích hoạt kéo thả (disable text selection)
            $("#sortableTable").disableSelection();
        });
    </script>
@endpush
