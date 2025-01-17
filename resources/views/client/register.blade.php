@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
    <!-- danh mục -->
    <section class="flat-spacing-20">
        <div class="container">
            <div class="row">
                <div class="modalCentered form-sign-in modal-part-content" id="register">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="header">
                                <div class="demo-title">Đăng ký</div>
                            </div>
                            <div class="tf-login-form">

                                <form action="{{ route('accountUser.register') }}" method="post">
                                    @csrf
                                    <div class="tf-field style-1">
                                        <label class="" for="">Họ và tên *</label>

                                        <input  class="form-control @error('name') is-invalid @enderror" placeholder=" " type="text" name="name"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="tf-field style-1">
                                        <label class="" for="">Email *</label>
                                        <input  class="form-control @error('email') is-invalid @enderror" placeholder=" " type="email" name="email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tf-field style-1">
                                        <label class="" for="">Mật khẩu *</label>
                                        <input class="form-control @error('password') is-invalid @enderror"  placeholder=" " type="password"
                                            name="password" value="{{ old('password') }}">

                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tf-field style-1">
                                        <label class="" for="">Xác nhận mật khẩu *</label>
                                        <input  class="form-control @error('password_confirmation') is-invalid @enderror"placeholder=" " type="password"
                                            name="password_confirmation" value="{{ old('password_confirmation') }}">

                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="bottom">
                                        <button
                                            class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"
                                            type="submit">Đăng ký</button>

                                        <div class="w-100">
                                            <a href="{{route('accountUser.login')}}"  class="btn-link fw-6 w-100 link">
                                                Đã có tài khoản? Đăng nhập tại đây
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
