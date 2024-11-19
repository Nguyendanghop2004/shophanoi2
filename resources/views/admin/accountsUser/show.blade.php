@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">{{ $user->name }}</h2>
            <p class="section-lead">
                Change information about yourself on this page.
            </p>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{ Storage::url($user->image) }}"
                                class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">

                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">{{ $user->name }} <div
                                    class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div>Vai trò
                                </div>
                            </div>
                            {{-- @foreach ($user->roles as $role)
                                {{ $role->name }}
                            @endforeach --}}
                        </div>
                        <div class="card-footer text-center">
                            <div class="font-weight-bold mb-2">Follow Ujang On</div>
                            <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-social-icon btn-twitter mr-1">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-social-icon btn-github mr-1">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="#" class="btn btn-social-icon btn-instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate="">
                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Name</label>
                                        <input type="text" class="form-control" value="{{ $user->name }}"
                                            required="" disabled>
                                        <div class="invalid-feedback">
                                            Please fill in the first name
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" value="{{ $user->email }}"
                                            required=""  disabled>
                                        <div class="invalid-feedback" >
                                            Please fill in the email
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Address</label>
                                        <input type="address" class="form-control" value="{{ $user->address }}"
                                            required=""  disabled>
                                        <div class="invalid-feedback" >
                                            Please fill in the address
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Phone_</label>
                                        <input type="address" class="form-control" value="{{ $user->phone_number }}"
                                            required=""  disabled>
                                        <div class="invalid-feedback" >
                                            Please fill in the address
                                        </div>
                                    </div>
                                </div>
                                <td>
                                    @if ($user->status)
                                        <span class="badge badge-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-danger">Không hoạt động</span>
                                    @endif
                                </td>

                            </div>
                            <div class="card-footer text-right">
                                <a class="btn btn-primary"
                                    href="{{ route('admin.accountsUser.change', $user->id) }}"> Đổi mật khẩu</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
            };

            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        });
    </script>
@endsection
