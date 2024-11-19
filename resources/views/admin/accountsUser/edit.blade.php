@extends('admin.layouts.master')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                                <label for="city">Chọn thành phố</label>
                                <select name="city_id" id="city" class="form-control choose city">
                                    <option value="" disabled selected>Chọn thành phố</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->matp }}" {{ $user->city_id == $city->matp ? 'selected' : '' }}>{{ $city->name_thanhpho }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="province">Chọn quận/huyện</label>
                                <select name="province_id" id="province" class="form-control province choose">
                                    <option value="" >Chọn quận/huyện</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->maqh }}" {{ $user->province_id == $province->maqh ? 'selected' : '' }}>{{ $province->name_quanhuyen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="wards">Chọn xã/phường</label>
                                <select name="wards_id" id="wards" class="form-control wards">
                                    <option value="" >Chọn xã/phường</option>
                                    @foreach($wards as $ward)
                                        <option value="{{ $ward->xaid }}" {{ $user->wards_id == $ward->xaid ? 'selected' : '' }}>{{ $ward->name_xaphuong }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ cụ thể</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', $user->address) }}" placeholder="Nhập vào địa chỉ cụ thể">
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Số điện thoại</label>
                                <input type="text" name="phone_number" class="form-control"
                                    value="{{ old('phone_number', $user->phone_number) }}" placeholder="Nhập vào số điện thoại">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div id="image-preview" class="image-preview mx-auto" 
                                 @error('image') style="border:2px dashed red" @enderror>
                                <img id="image-preview-img" src="{{ Storage::url($user['image']) }}" width="250px" height="250px" alt="Ảnh xem trước">
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
                        <div class="form-group">
                            <button type="submit" name="edit_user" class="btn btn-primary edit_user">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
<div id="form-container"></div>
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

        $(document).ready(function(){
    $('.choose').on('change', function(){
        var action = $(this).attr('id');
        var ma_id = $(this).val();
        var _token = $('input[name="_token"]').val();
        var result = '';

        if (action === 'city') {
            result = 'province';
            $('#province').html('<option value="">Chọn quận/huyện</option>');
            $('#wards').html('<option value="">Chọn xã/phường</option>');
        } else if (action === 'province') {
            result = 'wards';
            $('#wards').html('<option value="">Chọn xã/phường</option>');
        }

        $.ajax({
            url: '{{ url('admin/accountsUser/select-address') }}',
            method: 'POST',
            data: {
                action: action,
                ma_id: ma_id,
                _token: _token
            },
            success: function(data) {
                $('#' + result).html(data);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        if (action === 'city') {
            $('#province').html('<option value="">Chọn quận/huyện</option>');
            $('#wards').html('<option value="">Chọn xã/phường</option>');
        } else if (action === 'province') {
            $('#wards').html('<option value="">Chọn xã/phường</option>');
        }
    });
});



    </script>
@endsection
