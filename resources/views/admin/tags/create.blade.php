@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Mục</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Thêm Mới Tag</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tags.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Ảnh Tag -->
                        <div class="form-group">
                            <label>Ảnh Tag</label>
                            <div class="image-preview mx-auto" @error('image_path') style="border:2px dashed red" @enderror>
                                <label for="image-upload" id="image-label"> Chọn Tập Tin</label>
                                <input type="file" name="background_image" id="image-upload" accept="image/*" style="display: none;" />
                                <span id="image-preview" style="display: none;">
                                    <img src="" alt="Preview Image" style="width: 100%; height: 100%; object-fit: cover;" />
                                </span>
                            </div>
                            @error('image_path')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Loại -->
                        <div class="form-group">
                            <label>Loại</label>
                            <select name="type" class="form-control">
                                <option value="collection">Bộ sưu tập</option>
                                <option value="material">Chất liệu</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-6 col-12">
                        <!-- Tên Tag -->
                        <div class="form-group">
                            <label>Tên Tag</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid  @enderror" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Mô Tả -->
                        <div class="form-group">
                            <label>Mô Tả</label>
                            <textarea name="description" class="form-control @error('description') is-invalid  @enderror">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
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
