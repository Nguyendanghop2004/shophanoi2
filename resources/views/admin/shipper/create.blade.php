@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Thêm Nhân Viên Giao Hàng</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Thêm Mới Nhân Viên Giao Hàng</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shippers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group">
                            <label>Ảnh Đại Diện</label>
                            <div class="image-preview mx-auto" @error('profile_picture') style="border:2px dashed red" @enderror>
                                <label for="image-upload" id="image-label"> Chọn Tập Tin</label>
                                <input type="file" name="profile_picture" id="image-upload" accept="image/*" style="display: none;" />
                                <span id="image-preview" style="display: none;">
                                    <img src="" alt="Preview Image" style="width: 100%; height: 100%; object-fit: cover;" />
                                </span>
                            </div>
                            @error('profile_picture')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-6 col-12">
                        <div class="form-group">
                            <label>Tên Nhân Viên</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid  @enderror" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Ngày Sinh</label>
                            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid  @enderror" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Số Điện Thoại</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid  @enderror" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid  @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Quê Quán</label>
                            <input type="text" name="hometown" class="form-control @error('hometown') is-invalid  @enderror" value="{{ old('hometown') }}">
                            @error('hometown')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#image-upload').change(function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    $('#image-preview img').attr('src', event.target.result).parent().show();
                    $('#image-label').text(file.name);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
