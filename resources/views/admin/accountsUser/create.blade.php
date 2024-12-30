@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Thêm mới User</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Thêm mới User</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.accountsUser.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <div id="form-group">
                                    <label for="name">Tên</label>
                                    <input @error('name') style="border:2px dashed red"  @enderror type="text"
                                        name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">

                                <div class="">
                                    <label for="email">Email</label>
                                    <input @error('email') style="border:2px dashed red"  @enderror type="email"
                                        name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <label for="password">Mật khẩu</label>
                                    <input @error('password') style="border:2px dashed red"  @enderror type="password"
                                        name="password" class="form-control">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                                    <input @error('password') style="border:2px dashed red"  @enderror type="password"
                                        name="password_confirmation" class="form-control">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div id="image-preview" class="image-preview mx-auto @error('image') is-invalid @enderror">
                                <img id="image-preview-img" src="#" alt="Preview Image" style="display: none;" width="250px" height="250px">
                                <input type="file" name="image" id="image-upload" style="display: none;" accept="image/*">
                            </div>
                            <div class="form-group text-center mt-2">
                                <label for="image-upload" class="btn btn-secondary">Chọn ảnh</label>
                            </div>
                            @error('image')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="col-lg-6 col-md-6 col-12">
                            <div id="image-preview" class="image-preview mx-auto "
                                @error('image') style="border:2px dashed red"  @enderror>
                                <label for="image-upload" id="image-label">Chọn ảnh</label>
                                <input type="file" name="image" id="image-upload" />
                            </div>
                            @error('image')
                                <div class="invalid-feedback " style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div> --}}
                        {{-- <div class="">
                                <label for="image_path">Ảnh</label>
                                <input @error('image_path') style="border:2px dashed red"  @enderror type="file"
                                    name="image_path" class="form-control">
                            </div> --}}
                        {{-- @error('image_path')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror --}}

                        <div class="">
                            <button type="submit" class="btn btn-primary">Tạo mới</button>
                        </div>
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
