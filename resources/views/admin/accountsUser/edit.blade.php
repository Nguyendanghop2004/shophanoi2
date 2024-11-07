@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Cập nhật quản trị viên</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Cập nhật quản trị viên</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.accountsUser.update', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="form-group">
                                <label for="address">Đỉa chỉ</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', $user->address) }}" placeholder="Nhập đỉa chỉ củ thể">
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Tên</label>
                                <input type="text" name="phone_number" class="form-control"
                                    value="{{ old('phone_number', $user->phone_number) }}"
                                    placeholder="Nhập vào số điện thoại">
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div id="image-preview" class="image-preview mx-auto"
                                @error('image') style="border:2px dashed red" @enderror>
                                <img id="image-preview-img" src="{{ Storage::url($user->image) }}" width="250px"
                                    height="250px" alt="">
                            </div>
                            <div class="form-group text-center mt-2">
                                <label for="image-upload" class="btn btn-secondary">Chọn ảnh</label>
                                <input type="file" name="image" id="image-upload" style="display: none;" />
                            </div>
                            @error('image')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>

                        <div class="form-group ml-5">
                            <a class="btn btn-primary" href="{{ route('admin.accountsUser.change', $user->id) }}"> Đổi mật khẩu</a>
                        </div>
                    </div>

                </form>
            </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
