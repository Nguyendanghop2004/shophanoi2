@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Danh sách mã giảm giá</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh sách mã giảm giá </h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.discount_codes.create') }}" class="btn btn-primary">
                        Tạo Mới
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="section-title mt-0">
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Bộ lọc -->
                        <form method="GET" action="{{ route('admin.discount_codes.index') }}"
                            class="mb-3 d-flex align-items-center">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="code">Tìm kiếm mã giảm giá</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                        value="{{ request('code') }}" placeholder="Nhập mã giảm giá">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="discount_type">Loại giảm giá</label>
                                    <select name="discount_type" id="discount_type" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="percent"
                                            {{ request('discount_type') == 'percent' ? 'selected' : '' }}>Phần trăm</option>
                                        <option value="fixed" {{ request('discount_type') == 'fixed' ? 'selected' : '' }}>
                                            Cố định</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang
                                            hoạt động</option>
                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Hết
                                            hạn</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary ml-3">Lọc</button>
                            <a href="{{ route('admin.discount_codes.index') }}" class="btn btn-secondary ml-3">Xóa bộ
                                lọc</a>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mã</th>
                                    <th>Loại</th>
                                    <th>Giá trị</th>
                                    <th>Đã sử dụng</th>
                                    <th>Bắt đầu</th>
                                    <th>Kết thúc</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($discountCodes as $code)
                                <tr>
                                    <td>{{ $code->id }}</td>
                                    <td>{{ $code->code }}</td>
                                    <td>{{ ucfirst($code->discount_type) }}</td>
                                    <td>{{ $code->discount_value }}</td>
                                    <td>{{ $code->times_used }}/{{ $code->usage_limit ?? 'Không giới hạn' }}</td>
                                    <td>{{ $code->start_date }}</td>
                                    <td>{{ $code->end_date }}</td>
                                    <td>
                                        @if ($code->end_date && $code->end_date->lt(now()))
                                            <span class="badge badge-danger">Hết hạn</span>
                                        @else
                                            <span class="badge badge-success">Còn hiệu lực</span>
                                        @endif
                                    </td>                               
                                    <td>
                                        <a href="{{ route('admin.discount_codes.edit', $code->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                        <form action="{{ route('admin.discount_codes.destroy', $code->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Chưa có mã giảm giá nào.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Phân trang -->
            <div class="d-flex justify-content-center">
                {{ $discountCodes->links() }}
            </div>

        </div>
    </section>
@endsection
