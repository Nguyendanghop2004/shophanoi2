@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Mục</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Sửa danh mục</h4>
        </div>
        <div class="card-body">
            <form id="category-form" action="{{ route('admin.categories.update', $categories->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Cột bên trái -->
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group">
                            <label>Ảnh Danh Mục</label>
                            <div class="image-preview mx-auto" style="width: 100%; height: 250px; border: 2px dashed #ddd; display: flex; justify-content: center; align-items: center;">
                                <label for="image-upload" id="image-label" style="cursor: pointer;">Chọn Tập Tin</label>
                                <input type="file" name="image_path" id="image-upload" accept="image/*" style="display: none;" />
                                <span id="image-preview">
                                    <img src="{{ Storage::url($categories->image_path) }}" alt="Preview Image" style="width: 100%; height: 100%; object-fit: cover;" />
                                </span>
                            </div>
                            @error('image_path')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                         
                        <div class="form-group">
                            <label>Trạng Thái</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $categories->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ $categories->status == 0 ? 'selected' : '' }}>Không hiển thị</option>
                            </select>
                        </div>
                    </div>

                    <!-- Cột bên phải -->
                    <div class="col-lg-9 col-md-6 col-12">
                        <div class="form-group">
                            <label>Tên Danh Mục</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $categories->name) }}">
                        </div>
                        @error('name')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        <div class="form-group">
                            <label>Đường Dẫn Thân Thiện</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $categories->slug) }}">
                        </div>
                        @error('slug')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        <div class="form-group">
                            <label>Mô Tả Danh Mục</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $categories->description) }}</textarea>
                        </div>
                        @error('description')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        <div class="form-group">
                            <label>Danh Mục Cha</label>
                            <select name="parent_id" class="form-control">
                                <option value="">Chọn danh mục cha</option>
                                @foreach ($categoryList as $cat)
                                    <option value="{{ $cat->id }}" {{ $cat->id == $categories->parent_id ? 'selected' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="button" id="submit-btn" class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Thư viện JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Thay đổi ảnh khi chọn file
        const imageUpload = document.getElementById('image-upload');
        const imagePreviewImg = document.querySelector('#image-preview img');

        imageUpload.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreviewImg.src = e.target.result; 
                };
                reader.readAsDataURL(file);
            }
        });

       
        const submitBtn = document.getElementById('submit-btn');
        const form = document.getElementById('category-form');

        submitBtn.addEventListener('click', function () {
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: 'Danh mục sẽ được cập nhật sau khi xác nhận!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, cập nhật!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
