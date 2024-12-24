@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Sửa </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Sửa Blog</h4>
            </div>
            <div class="card-body">
                <form id="blog-form" action="{{ route('admin.blog.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="col-lg-6 col-md-6 col-12">
                        <div id="image-preview" class="image-preview mx-auto"
                            @error('image') style="border:2px dashed red" @enderror>
                            <img id="image-preview-img" src="{{ Storage::url($data['image']) }}" width="250px"
                                height="250px" alt="Ảnh xem trước">
                        </div>
                        <div class="form-group text-center mt-2">
                            <label for="image-upload" id="image-label">Chọn ảnh</label>
                            <input type="file" name="image" id="image-upload" />
                        </div>
                        @error('image')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <div id="form-group">
                                    <label for="title">Tên Title</label>
                                    <input @error('title') style="border:2px dashed red"  @enderror type="text"
                                        name="title" class="form-control" value="{{ old('title', $data->title) }}">
                                </div>

                                @error('title')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div id="form-group">
                                    <label for="slug">slug</label>
                                    <input @error('slug') style="border:2px dashed red"  @enderror type="text"
                                        name="slug" class="form-control" value="{{ old('slug', $data->slug) }}">
                                </div>

                                @error('slug')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Mô Tả </label>
                                @error('content')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <textarea name="content" class="form-control summernote  @error('brand_id') is-invalid  @enderror"
                                    style="width: 50%; height: 100px;" cols="30" rows="5"> {{ old('content') }} {{ $data->content }}</textarea>
                            </div>
                        </div>
                        <input type="submit" id="submit-btn" class="btn btn-primary" value="Cập nhật">
                </form>
            </div>
        </div>
        </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            const oldDescription = "{{ old('content') }}"; // Lấy dữ liệu cũ từ Laravel

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
                $('.summernote').summernote('code', oldDescription);
            }

            // Cập nhật giá trị của textarea ẩn trước khi gửi form
            $('form').on('submit', function() {
                const summernoteContent = $('.summernote').summernote('code');
                $(this).find('textarea[name="content"]').val(summernoteContent);
            });

            // Thêm sự kiện xác nhận khi nhấn nút Cập Nhật
            $('#submit-btn').click(function(e) {
                e.preventDefault(); // Ngừng việc gửi form mặc định

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn cập nhật blog này?',
                    text: "Blog sẽ được cập nhật ngay sau khi bạn xác nhận!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có, cập nhật!',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Nếu người dùng xác nhận, gửi form
                        $('#blog-form').submit();
                    }
                });
            });
        });
    </script>
@endsection
