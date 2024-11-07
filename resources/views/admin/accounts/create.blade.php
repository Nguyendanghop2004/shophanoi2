@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Thêm mới Admin</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Thêm mới Admin</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.accounts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Xác nhận mật khẩu</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div id="image-preview" class="image-preview mx-auto @error('image_path') is-invalid @enderror">
                                <img id="image-preview-img" src="#" alt="Preview Image" style="display: none;"
                                    width="250px" height="250px">
                                <input type="file" name="image_path" id="image-upload" style="display: none;"
                                    accept="image/*">
                            </div>
                            <div class="form-group text-center mt-2">
                                <label for="image-upload" class="btn btn-secondary">Chọn ảnh</label>
                                <input type="file" name="image_path" id="image-upload" style="display: none;" />
                            </div>
                            @error('image_path')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Tạo mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif

            // Thêm sự kiện thay đổi cho input file
            const imageUpload = document.getElementById('image-upload');
            const imagePreviewImg = document.getElementById('image-preview-img');

            imageUpload.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreviewImg.setAttribute('src', e.target.result);
                        imagePreviewImg.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreviewImg.style.display = 'none';
                }
            });
        });
    </script>
@endsection
