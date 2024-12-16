@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Thêm mới Blog</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Thêm mới Blog</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div id="image-preview" class="image-preview mx-auto @error('image') is-invalid @enderror">
                                <img id="image-preview-img" src="#" alt="Preview Image" style="display: none;"
                                    width="250px" height="250px">
                                <input type="file" name="image" id="image-upload" style="display: none;"
                                    accept="image/*">
                            </div>
                            <div class="form-group text-center mt-2">
                                <label for="image-upload" class="btn btn-secondary">Chọn ảnh</label>
                                {{-- <input type="file" name="image" id="image-upload" style="display: none;" /> --}}
                            </div>
                            @error('image')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="form-group">
                            <label for="title">Tên Title</label>
                            <input @error('title') style="border:2px dashed red"  @enderror type="text" name="title"
                                class="form-control" value="{{ old('title') }}">
                        </div>

                        @error('title')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Mô Tả</label>
                        @error('description')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <textarea name="content" class="form-control summernote  @error('brand_id') is-invalid  @enderror"
                            style="width: 50%; height: 100px;" cols="30" rows="5" {{ old('description') }}> </textarea>
                    </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Tạo mới bài viết ">
            </form>
        </div>
        </div>
        </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            const oldDescription = "{{ old('description') }}"; // Lấy dữ liệu cũ từ Laravel

            $('.summernote').summernote({
                height: 300, // Chiều cao của editor
                tabsize: 2,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Đặt nội dung cũ vào Summernote
            if (oldDescription) {
                $('.summernote').summernote(oldDescription);
            }

            // Cập nhật giá trị của textarea ẩn trước khi gửi form
            $('form').on('submit', function() {
                const summernoteContent = $('.summernote').summernote('code');
                $(this).find('textarea[name="description"]').val(summernoteContent);
            });
        });
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

            Thêm sự kiện thay đổi cho input file
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
