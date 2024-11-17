@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Thêm Thương Hiệu</h1>
    </div>

    <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên Thương Hiệu</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="image_brand_url">Ảnh Thương Hiệu</label>
                    <input type="file" name="image_brand_url" class="form-control" required>
                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary">Thêm</button>
                <a href="{{ route('brands.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </form>
</section>
@endsection
