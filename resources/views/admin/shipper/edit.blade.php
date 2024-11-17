@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chỉnh Sửa Nhân Viên Giao Hàng</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Cập Nhật Thông Tin Giao Hàng</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('shippers.update', $shipper->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group">
                            <label>Ảnh Đại Diện</label>
                            <div class="image-preview mx-auto" style="width: 100%; height: 250px; border: 2px dashed #ddd; display: flex; justify-content: center; align-items: center;">
                                <label for="image-upload" id="image-label" style="cursor: pointer;">Chọn Tập Tin</label>
                                <input type="file" name="profile_picture" id="image-upload" accept="image/*" style="display: none;" />
                                <span id="image-preview" style="display: block;">
                                    @if($shipper->profile_picture)
                                        <img src="{{ Storage::url($shipper->profile_picture) }}" alt="Current Profile Picture" style="width: 100%; height: 100%; object-fit: cover;" />
                                    @else
                                        <span>Chưa có ảnh đại diện</span>
                                    @endif
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
                            <label>Tên</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $shipper->name) }}">
                            @error('name')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $shipper->email) }}">
                            @error('email')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Số Điện Thoại</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $shipper->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Quê Quán</label>
                            <input type="text" name="hometown" class="form-control @error('hometown') is-invalid @enderror" value="{{ old('hometown', $shipper->hometown) }}">
                            @error('hometown')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Ngày Sinh</label>
                            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $shipper->date_of_birth) }}">
                            @error('date_of_birth')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        $('#image-upload').change(function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    $('#image-preview img').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
