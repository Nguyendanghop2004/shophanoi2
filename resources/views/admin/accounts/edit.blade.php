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
                <form action="{{ route('admin.accounts.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                        
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}">
                            </div>
                            
                            @if(!$isAdmin)
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" value="">
                            </div>
                        @endif
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-12">
                            <div id="image-preview" class="image-preview mx-auto"
                                @error('image_path') style="border:2px dashed red" @enderror>
                                <img id="image-preview-img" src="{{ Storage::url($admin['image_path']) }}" width="250px"
                                    height="250px" alt="">
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


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
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
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
        
    </script>
@endsection
