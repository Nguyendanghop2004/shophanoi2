@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Mục</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Thêm Mới Thương Hiệu</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Ảnh Thương Hiệu -->
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group">
                            <label>Ảnh Thương Hiệu</label>
                            <div class="image-preview mx-auto @error('image_brand_url') border-danger @enderror" style="border: 2px dashed #ccc; padding: 20px;">
                                <label for="image-upload" id="image-label" style="cursor: pointer;">Chọn Tập Tin</label>
                                <input type="file" name="image_brand_url" id="image-upload" accept="image/*" style="display: none;" />
                                <span id="image-preview" style="display: none;">
                                    <img src="" alt="Preview Image" style="width: 100%; height: 100%; object-fit: cover;" />
                                </span>
                            </div>
                            @error('image_brand_url')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Thông tin Thương Hiệu -->
                    <div class="col-lg-9 col-md-6 col-12">
                        <div class="form-group">
                            <label for="name">Tên Thương Hiệu</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nhập tên thương hiệu">
                            @error('name')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Nút Lưu -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Hiển thị ảnh đã chọn
        $('#image-upload').change(function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    $('#image-preview img').attr('src', event.target.result).parent().show();
                    $('#image-label').text(file.name);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
