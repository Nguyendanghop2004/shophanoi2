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

                                                                    <h5>{{ auth()->user()->name }}
                                                                    </h5>

                                                                    <p>Web Designer</p>
                                                                    <i class="far fa-edit mb-5"></i>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="card-body p-4">
                                                                        <h6>Thông tin</h6>
                                                                        <hr class="mt-0 mb-4">
                                                                        <div class="row pt-1">
                                                                            <div class="col-7 mb-4">
                                                                                <h6>Email</h6>
                                                                                <p>
                                                                                    @php
                                                                                        $email = auth()->user()->email;
                                                                                        $hiddenEmail =
                                                                                            substr($email, 0, 1) .
                                                                                            '*****' .
                                                                                            strstr($email, '@');
                                                                                    @endphp
                                                                                    <span
                                                                                        id="email">{{ $hiddenEmail }}</span>
                                                                                    <a href="javascript:void(0);"
                                                                                        onclick="toggleEmail()">
                                                                                        <i id="toggleIcon"
                                                                                            class="fas fa-eye"></i>
                                                                                    </a>
                                                                                </p>
                                                                            </div>
                                                                            <!-- Hiển Thị Số Điện Thoại -->
                                                                            <div class="col-5 mb-3">
                                                                                <h6>Phone</h6>
                                                                                <p>
                                                                                    @php
                                                                                        $phone = auth()->user()
                                                                                            ->phone_number;
                                                                                        $hiddenPhone =
                                                                                            '******' .
                                                                                            substr($phone, -3); // Ẩn số điện thoại trừ 3 chữ số cuối
                                                                                    @endphp
                                                                                    <span
                                                                                        id="phone">{{ $hiddenPhone }}</span>
                                                                                    <a href="javascript:void(0);"
                                                                                        onclick="togglePhoneVisibility()">
                                                                                        <i id="toggleIconPhone"
                                                                                            class="fas fa-eye"></i>
                                                                                    </a>
                                                                                </p>
                                                                            </div>

                                                                            <!-- Modal Nhập Mật Khẩu -->
                                                                            <div id="passwordModal" style="display: none;">
                                                                                <div class="modal-overlay">
                                                                                    <div class="modal-content">
                                                                                        <h4>Nhập Mật Khẩu</h4>
                                                                                        <input type="password"
                                                                                            id="passwordInput"
                                                                                            placeholder="Nhập mật khẩu của bạn"
                                                                                            class="form-control mb-3">
                                                                                        <div
                                                                                            class="d-flex justify-content-end">
                                                                                            <button
                                                                                                onclick="closePasswordModal()"
                                                                                                class="btn btn-secondary me-2">Hủy</button>
                                                                                            <button
                                                                                                onclick="checkPassword()"
                                                                                                class="btn btn-primary">Xác
                                                                                                Nhận</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div id="passwordModalEmail" style="display: none;">
                                                                                <div class="modal-overlay">
                                                                                    <div class="modal-content">
                                                                                        <h4>Nhập Mật Khẩu</h4>
                                                                                        <input type="password"
                                                                                            id="passwordInputEmail"
                                                                                            placeholder="Nhập mật khẩu của bạn"
                                                                                            class="form-control mb-3">
                                                                                        <div
                                                                                            class="d-flex justify-content-end">
                                                                                            <button
                                                                                                onclick="closePasswordModalEmail()"
                                                                                                class="btn btn-secondary me-2">Hủy</button>
                                                                                            <button
                                                                                                onclick="checkPasswordEmail()"
                                                                                                class="btn btn-primary">Xác
                                                                                                Nhận</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- CSS cho Modal -->
                                                                            <style>
                                                                                .modal-overlay {
                                                                                    position: fixed;
                                                                                    top: 0;
                                                                                    left: 0;
                                                                                    width: 100%;
                                                                                    height: 100%;
                                                                                    background-color: rgba(0, 0, 0, 0.5);
                                                                                    display: flex;
                                                                                    align-items: center;
                                                                                    justify-content: center;
                                                                                    z-index: 9999;
                                                                                }

                                                                                .modal-content {
                                                                                    background-color: white;
                                                                                    padding: 20px;
                                                                                    border-radius: 8px;
                                                                                    width: 400px;
                                                                                    max-width: 90%;
                                                                                }
                                                                            </style>
                                                                            <!-- CSS cho Modal -->
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
                                                                    <p class="text-muted mb-0">
                                                                        {{ $user->ward->name_xaphuong ?? '' }}</p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <p class="mb-0">Đỉa chỉ củ thể</p>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <p class="text-muted mb-0">{{ $user->address }}</p>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" />
<!-- font awesome 5.13.1 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" />
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
{{-- start email --}}
<script>
    let isEmailHidden = true; // Trạng thái ban đầu là ẩn
    function openPasswordModalEmail() {
        document.getElementById('passwordModalEmail').style.display = 'flex'; // Hiển thị modal
    }

    // Đóng modal
    function closePasswordModalEmail() {
        document.getElementById('passwordModalEmail').style.display = 'none'; // Ẩn modal
    }

    function checkPasswordEmail() {
        const password = document.getElementById('passwordInputEmail').value;

        // Gửi mật khẩu đến server để xác minh
        fetch("{{ route('check-checkPasswordProfile') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị số điện thoại đầy đủ nếu mật khẩu đúng
                    document.getElementById('email').textContent = "{{ auth()->user()->email }}";

                    // Thay đổi icon mắt thành "fa-eye-slash" khi mật khẩu đúng
                    document.getElementById('toggleIcon').classList.remove('fa-eye');
                    document.getElementById('toggleIcon').classList.add('fa-eye-slash');

                    closePasswordModalEmail(); // Đóng modal
                } else {
                    alert("Mật khẩu không chính xác!");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Đã xảy ra lỗi!");
            });
    }


    function toggleEmail() {
        const emailSpan = document.getElementById('email');
        const toggleIcon = document.getElementById('toggleIcon');

        if (isEmailHidden) {
            // Hiển thị email
            openPasswordModalEmail() ;
        } else {
            // Ẩn email
            emailSpan.textContent =
                "{{ substr(auth()->user()->email, 0, 1) . '*****' . strstr(auth()->user()->email, '@') }}";
            toggleIcon.classList.remove('fa-eye-slash'); // Đổi biểu tượng thành "mắt mở"
            toggleIcon.classList.add('fa-eye');
        }
        isEmailHidden = !isEmailHidden; // Đảo trạng thái
    }
</script>
{{-- end email --}}

{{-- start phone --}}
<script>
    // Mở modal nhập mật khẩu
    function openPasswordModal() {
        document.getElementById('passwordModal').style.display = 'flex'; // Hiển thị modal
    }

    // Đóng modal
    function closePasswordModal() {
        document.getElementById('passwordModal').style.display = 'none'; // Ẩn modal
    }

    // Kiểm tra mật khẩu
    function checkPassword() {
        const password = document.getElementById('passwordInput').value;

        // Gửi mật khẩu đến server để xác minh
        fetch("{{ route('check-checkPasswordProfile') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị số điện thoại đầy đủ nếu mật khẩu đúng
                    document.getElementById('phone').textContent = "{{ auth()->user()->phone_number }}";

                    // Thay đổi icon mắt thành "fa-eye-slash" khi mật khẩu đúng
                    document.getElementById('toggleIconPhone').classList.remove('fa-eye');
                    document.getElementById('toggleIconPhone').classList.add('fa-eye-slash');

                    closePasswordModal(); // Đóng modal
                } else {
                    alert("Mật khẩu không chính xác!");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Đã xảy ra lỗi!");
            });
    }

    // Hàm để ẩn/hiện số điện thoại
    function togglePhoneVisibility() {
        const phoneElement = document.getElementById('phone');
        const toggleIcon = document.getElementById('toggleIconPhone');

        if (phoneElement.textContent === "{{ auth()->user()->phone_number }}") {
            // Nếu số điện thoại hiện tại là số đầy đủ, ẩn lại
            const hiddenPhone = '******' +
                "{{ substr(auth()->user()->phone_number, -3) }}"; // Ẩn số điện thoại trừ 3 chữ số cuối
            phoneElement.textContent = hiddenPhone;

            // Thay đổi icon về mắt mở
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        } else {
            openPasswordModal();
        }
    }
</script>
{{-- end phone --}}