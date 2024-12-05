@extends('client.layouts.master')

@section('content')
    <!-- categories -->
    <section class="flat-spacing-20">
        <div class="container">
            <div class="row">
                <div class=" modalCentered  form-sign-in modal-part-content" id="register">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="header">
                                <div class="demo-title">Register</div>
                            </div>
                            <div class="tf-login-form">

                                <form action="{{ route('accountUser.register') }}" method="post">
                                    @csrf
                                    <div class="tf-field style-1">
                                        <label class="" for="">First name *</label>

                                        <input class="tf-input" placeholder=" " type="text" name="name"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="tf-field style-1">
                                        <label class="" for="">Email *</label>
                                        <input class="tf-field-input tf-input" placeholder=" " type="email" name="email"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tf-field style-1">
                                        <label class="" for="">Password *</label>
                                        <input class="tf-field-input tf-input" placeholder=" " type="password"
                                            name="password" value="{{ old('password') }}">

                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="tf-field style-1">
                                        <label class="" for="">Password *</label>
                                        <input class="tf-field-input tf-input" placeholder=" " type="password"
                                            name="password_confirmation" value="{{ old('password_confirmation') }}">
                                        @error('password_confirmation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="bottom">
                                        <button
                                            class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"
                                            type="submit">Register</button>

                                        <div class="w-100">
                                            <a href="{{route('accountUser.login')}}"  class="btn-link fw-6 w-100 link">
                                                Already have an account? Log in here
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
