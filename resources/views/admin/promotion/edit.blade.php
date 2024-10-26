@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Bài Viết</h1>
        </div>
        <form id="postForm" action="{{route('promotions.update',$promotion)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <!-- Phần chính -->
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Thêm khuyến mãi</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="{{$promotion->title}}">
                                    @error('title')
                                    <div class="" style="color: red";>{{ $message }}</div>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control summernote" cols="30" rows="5" >{{$promotion->description}}</textarea>
                                @error('description')
                                    <div class="" style="color: red";>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Discount Percentage</label>
                                <input type="number" name="discount_percentage" class="form-control" value="{{$promotion->discount_percentage}}">
                                @error('discount_percentage')
                                    <div class="" style="color: red";>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phần phụ -->
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="card mb-4">
                       

                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="datetime-local" name="start_date" class="form-control"
value="{{$promotion->start_date}}">
@error('start_date')
                                    <div class="" style="color: red";>{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="datetime-local" name="end_date" class="form-control"
value="{{$promotion->end_date}}">
@error('end_date')
                                    <div class="" style="color: red";>{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Cập nhật khuyến mãi</button>
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