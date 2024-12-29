@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection
@section('content')
    <!-- danh mục -->
    <section class="flat-spacing-20">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="form-sign-in" id="login">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="header">
                                    <div class="demo-title">Đăng nhập</div>
                                </div>

                                <div class="tf-login-form">
                                    <form action="{{ route('account.login') }}" method="post">
                                        @csrf
                                        <div class="tf-field style-1">
                                            <input class="tf-field-input tf-input" placeholder=" Nhập Email" type="email"
                                                name="email" value="{{ old('email') }}">
                                            <label class="tf-field-label" for="">Email *</label>
                                            @error('email')
                                                <p style="color: red; font-size: 14px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="tf-field style-1">
                                            <input class="tf-field-input tf-input" placeholder=" " type="password"
                                                name="password" @error('password') is-invalid @enderror>
                                            <label class="tf-field-label" for="">Mật khẩu *</label>
                                            @error('password')
                                            <p style="color: red; font-size: 14px;">{{ $message }}</p>
                                        @enderror
                                        </div>
                                        <div>

                                            <a href="{{route('account.ResePassword')}}"  class="btn-link link">Forgot
                                                your
                                                password?</a>

                                        </div>
                                        <div class="bottom">
                                            <div class="w-100">
                                                <button type="submit"
                                                    class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Đăng nhập</span></button>
                                            </div>
                                            <div class="w-100">


                                                <a href="{{route('account.register')}}" class="btn-link fw-6 w-100 link">
                                                    Khách hàng mới? Tạo tài khoản


                                                    <i class="icon icon-arrow1-top-left"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                timer: 5000
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 5000
            });
        @endif



    });
</script>


