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
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="form-group">
                                <div id="form-group">
                                    <label for="title">Tên Title</label>
                                    <input @error('title') style="border:2px dashed red"  @enderror type="text"
                                        name="title" class="form-control" value="{{ old('title') }}">
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
                                    style="width: 50%; height: 100px;" cols="30" rows="5"> </textarea>
                            </div>
                        </div>
                            <input type="submit" class="btn btn-primary" value="Tạo mới sản phẩm ở đây ">
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
    </script>
@endsection
