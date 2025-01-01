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
                <!-- page-title -->
                <div class="tf-page-title">
                    <div class="container-full">
                        <div class="heading text-center">{{ auth()->user()->name }}</div>
                    </div>
                </div>
                <!-- /page-title -->

                <!-- page-cart -->
                <section class="flat-spacing-11">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3">
                                @include('client.user.account-nav')
                            </div>
                            <div class="col-lg-9">
                                <div class="my-account-content account-dashboard">
                                    <div class="mb_60">
                                        {{-- <h5 class="fw-5 ">Xin chào {{ auth()->user()->name }}</h5> --}}
                                        <section class="" style="">
                                            <div class="container">
                                                <div class="row d-flex justify-content-center align-items-center ">
                                                    <div class="">
                                                        <div class="card mb-3" style="border-radius: .5rem;">
                                                            <div class="row g-0">
                                                                <div class="col-md-4 gradient-custom text-center text-white"
                                                                    style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                                                    @if (auth()->user()->image)
                                                                        <img src="{{ Storage::url(auth()->user()->image) }}"
                                                                            alt="Ảnh" alt="Avatar"
                                                                            class="img-fluid my-5" style="width: 80px;" />
                                                                    @else
                                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                                            alt="Avatar" class="img-fluid my-5"
                                                                            style="width: 80px;" />
                                                                    @endif

                                                                    <h5>{{ auth()->user()->name }}</h5>
                                                                    <p>Web Designer</p>
                                                                    <i class="far fa-edit mb-5"></i>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="card-body p-4">
                                                                        <h6>Thông tin</h6>
                                                                        <hr class="mt-0 mb-4">
                                                                        <div class="row pt-1">
                                                                            <div class="col-6 mb-3">
                                                                                <h6>Email</h6>
                                                                                <p class="text-muted">
                                                                                    {{ auth()->user()->email }}</p>
                                                                            </div>
                                                                            <div class="col-6 mb-3">
                                                                                <h6>Phone</h6>
                                                                                <p class="text-muted">
                                                                                    {{ auth()->user()->phone_number }}</p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        
                                                                        <div class="d-flex justify-content-start">
                                                                            <a href="#!"><i
                                                                                    class="fab fa-facebook-f fa-lg me-3"></i></a>
                                                                            <a href="#!"><i
                                                                                    class="fab fa-twitter fa-lg me-3"></i></a>
                                                                            <a href="#!"><i
                                                                                    class="fab fa-instagram fa-lg"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="card mb-4">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <p class="mb-0">Thành phố</p>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <p class="text-muted mb-0">
                                                                        {{ $user->city->name_thanhpho ?? '' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <p class="mb-0">Quận huyện</p>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <p class="text-muted mb-0">
                                                                        {{ $user->province->name_quanhuyen ?? '' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <hr>

                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <p class="mb-0">Xã Phường</p>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <p class="text-muted mb-0">{{ $user->ward->name_xaphuong ?? '' }}</p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <p class="mb-0">Đỉa chỉ củ thể</p>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <p class="text-muted mb-0">{{$user->address}}</p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                        {{-- <button type="submit" class=" btn"> Cập nhật</button> --}}
                                                    </div>
                                                </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
