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
                <div class="col-12">
                    <div class="form-sign-in" id="login">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="header">
                                    <div class="demo-title">Mã Code</div>
                                </div>

                                <div class="tf-login-form">
                                    <form action="{{ route('account.checkcode') }}" method="post">
                                        @csrf
                                        <div class="tf-field style-1">
                                            <input class="form-control @error('reset_code') is-invalid @enderror "
                                                type="text" placeholder="nhập mã code" name="reset_code"
                                                @error('reset_code') is-invalid @enderror>
                                            @error('reset_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                        <a class="mt-2" href="{{ route('account.resetCode', $resetRequest->token) }}">Gửi lại mã code</a>

                                        <input class="tf-field-input tf-input" placeholder=" " type="hidden" name="token"
                                            value="{{ $resetRequest->token }}">
                                        <input class="tf-field-input tf-input" placeholder=" " type="hidden" name="email"
                                            value="{{ $resetRequest->email }}">
                                        <div class="w-100">
                                            <div class="bottom">
                                                <div class="w-100">
                                                    <button type="submit"
                                                        class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Thay
                                                            đổi mật khẩu
                                                        </span></button>
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
    {{-- <h1>hop</h1> --}}
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
    q
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.add('fade');
                alert.classList.remove('show');
            }, 5000); // 5 giây
        });
    });
    
</script>
<style>
    
</style>
