@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chỉnh Sửa Thương Hiệu</h1>
    </div>

    <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên Thương Hiệu</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $brand->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="image_brand_url">Ảnh Thương Hiệu</label>
                    <input type="file" name="image_brand_url" class="form-control">
                    <small class="form-text text-muted">Chọn ảnh mới nếu bạn muốn thay đổi ảnh thương hiệu.</small>
                    <img src="{{ asset('storage/' . $brand->image_brand_url) }}" alt="Brand Image" style="width: 150px; height: 150px; object-fit: cover; margin-top: 10px;">
                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary">Cập Nhật</button>
                <a href="{{ route('brands.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </form>
</section>
@endsection

