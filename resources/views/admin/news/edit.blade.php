@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Bài Viết</h1>
        </div>
        <form id="postForm" action="{{route('news.update',$news)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <!-- Phần chính -->
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Thêm bài viết</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="{{$news->title}}">
                                    @error('title')
                                    <div class="" style="color: red";>{{ $message }}</div>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Content</label>
                                <textarea name="content" class="form-control summernote" cols="30" rows="5">{{$news->content}}</textarea>
                                @error('content')
                                <div class="" style="color: red";>{{ $message }}</div>
                            @enderror
                            </div>

                            <div class="form-group">
                                <label>Category ID</label>
                                    <input type="text" name="category_id" class="form-control" value="{{$news->category_id}}">
                                    @error('category_id')
                                    <div class="" style="color: red";>{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Product ID</label>
                                    <input type="text" name="product_id" class="form-control" value="{{$news->product_id}}">
                                    @error('product_id')
                                    <div class="" style="color: red";>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phần phụ -->
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Ảnh bài viết</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Upload Image</label>
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="image_path" id="image-upload" class="form-control" value="{{$news->image_path}}"/>
                                    @error('image_path')
                                    <div class="" style="color: red";>{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Thông tin bài viết</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label>Ngày xuất bản</label>
                                <input type="datetime-local" name="published_at" class="form-control"
value="{{$news->published_at}}">
@error('published_at')
<div class="" style="color: red";>{{ $message }}</div>
@enderror
                            </div>

                           




                           


                            <button type="submit" class="btn btn-primary btn-block">Đăng bài viết</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let isFormEdited = false;
            const form = document.getElementById('postForm');
            form.addEventListener('input', function() {
                isFormEdited = true;
            });
            window.addEventListener('beforeunload', function(e) {
                if (isFormEdited) {
                    const confirmationMessage =
                        'Bạn có thay đổi chưa được lưu. Bạn có chắc chắn muốn rời khỏi trang?';
                    e.returnValue = confirmationMessage;
                    return confirmationMessage;
                }
            });
            form.addEventListener('submit', function() {
                isFormEdited = false;
            });
        });
    </script>
@endsection