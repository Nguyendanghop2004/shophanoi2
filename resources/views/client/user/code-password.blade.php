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
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="header">
                            <div class="demo-title">Nhập code</div>
                            {{-- <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span> --}}
                        </div>
                        <div class="tf-login-form">
                            <form class="" action="{{ route('account.checkcode') }}" method="POST">
                                @csrf


                                <div class="tf-field style-1">
                                    <div class="input-group mb-3">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Code"
                                                aria-label="Recipient's username" aria-describedby="basic-addon2"
                                                name="reset_code" value="{{ old('reset_code') }}">
                                            <a href="{{ route('account.resetCode', $resetRequest->token) }}"
                                                class="btn btn-outline-secondary">gửi lại</a>
                                            @error('reset-code')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                        </div>
                        <input class="tf-field-input tf-input" placeholder=" " type="hidden" name="token"
                            value="{{ $resetRequest->token }}">
                        <input class="tf-field-input tf-input" placeholder=" " type="hidden" name="email"
                            value="{{ $resetRequest->email }}">
                        <div class="w-100">
                            <button type="submit"
                                class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Nhập</span></button>

                        </div>
                    </div>
                    </form>
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
