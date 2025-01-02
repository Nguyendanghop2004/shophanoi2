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
                                    <div class="demo-title">Reset your password</div>
                                </div>

                                <div class="tf-login-form">
                                    <form action="{{ route('password.email') }}" method="post">
                                        @csrf
                                        <div class="tf-field style-1">
                                            <input class="tf-field-input tf-input" placeholder=" Nhập Email" type="email"
                                                name="email" value="{{ old('email') }}">
                                            <label class="tf-field-label" for="">Email *</label>
                                            @error('email')
                                                <p style="color: red; font-size: 14px;">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                       
                                        <div class="bottom">
                                            <div class="w-100">
                                                <button type="submit"
                                                    class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span> Change Password</span></button>
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
