@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection
@section('content')
    <!-- categories -->
    <section class="flat-spacing-20">
        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <!-- page-cart -->
                <section class="flat-spacing-11">
                    <!-- page-title -->
                    <div class="tf-page-title">
                        <div class="container-full">
                            <div class="heading text-center">Thay đổi mật khâu</div>
                        </div>
                    </div>
                    <!-- /page-title -->

                    <!-- page-cart -->
                    <section class="flat-spacing-11">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-3">
                                    <ul class="my-account-nav">
                                        @include('client.user.account-nav')
                                    </ul>
                                </div>
                                <div class="col-lg-9">
                                    <div class="my-account-content account-edit">
                                        <div class="">
                                            <form id="update-admin-form"
                                                action="{{ route('account.updatePassword', auth()->user()->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-12"> <!-- Địa chỉ cụ thể -->
                                                        <!-- Mật khẩu cũ -->
                                                        <div class="form-group">
                                                            <label for="old_password">Nhập mật khẩu cũ </label>
                                                            <input
                                                                class="form-control @error('old_password') is-invalid @enderror"
                                                                placeholder=" Nhập mật khẩu cũ " type="password"
                                                                name="old_password" value="{{ old('old_password') }}">
                                                            {{-- <label  for="tf-field-label">Email *</label> --}}
                                                            @error('old_password')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="password">Nhập mật khẩu mới </label>
                                                        <input
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            placeholder=" Nhập mật khẩu mới" type="password"
                                                            name="password" value="{{ old('password') }}">
                                                        {{-- <label  for="tf-field-label">Email *</label> --}}
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="password_confirmation">Nhập lại mật khẩu </label>
                                                        <input
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            placeholder="Nhập lại mật khẩu " type="password"
                                                            name="password_confirmation" value="{{ old('password_confirmation') }}">
                                                        {{-- <label  for="tf-field-label">Email *</label> --}}
                                                        @error('password_confirmation')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Nút cập nhật -->
                                                    <div class="form-group mt-2">
                                                        <button type="submit" name="edit_user" id="submit-btn"
                                                            class="btn btn-primary edit_user">Thay đổi </button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- page-cart -->
                </section>
                <!-- page-cart -->
            </div>
        </div>
        </div>

        </div>
    </section>
@endsection

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

        const submitButton = document.querySelector('.edit_user');
        const form = document.querySelector('#update-admin-form'); // Thêm ID cho form
        submitButton.addEventListener('click', function(e) {
            e.preventDefault(); // Ngăn gửi mặc định
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: "Thông tin sẽ được cập nhật sau khi xác nhận!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, cập nhật!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Gửi biểu mẫu
                }
            });
        });

        $('.choose').on('change', function() {
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
        });
    });
</script>
