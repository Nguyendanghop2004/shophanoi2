@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chỉnh Sửa Thương Hiệu</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Chỉnh Sửa Thương Hiệu</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Ảnh Thương Hiệu -->
                        <div class="form-group">
                            <label>Ảnh Hiện Tại</label>
                            <div class="mb-2">
                                @if ($brand->image_brand_url)
                                    <img src="{{ asset('storage/' . $brand->image_brand_url) }}" alt="Ảnh hiện tại" style="width: 100%; height: auto; object-fit: cover;">
                                @else
                                    <p class="text-muted">Không có ảnh</p>
                                @endif
                            </div>
                            <label>Cập Nhật Ảnh</label>
                            <div class="image-preview mx-auto" @error('image_brand_url') style="border:2px dashed red" @enderror>
                                <label for="image-upload" id="image-label"> Chọn Tập Tin</label>
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
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name) }}">
                        </div>
                        @error('name')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Nút Lưu -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
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
