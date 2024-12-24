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
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Ảnh Thương Hiệu -->
                        <div class="form-group">
                            <label>Ảnh Thương Hiệu</label>
                            <div class="image-preview mx-auto" @error('image_brand_url') style="border:2px dashed red" @enderror>
                                <label for="image-upload" id="image-label">Chọn Tập Tin</label>
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

                    <div class="col-lg-9 col-md-6 col-12">
                        <!-- Tên Thương Hiệu -->
                        <div class="form-group">
                            <label>Tên Thương Hiệu</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Nút Lưu -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu</button>
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
