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
            <div class="tf-page-title">
                <div class="container-full">
                    <div class="heading text-center">Đơn hàng của {{auth()->user()->name}}</div>
                </div>
            </div>
            <!-- page-cart -->
            <section class="flat-spacing-11">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            @include('client.user.account-nav')
                        </div>
                        <div class="col-lg-9">
                            <div class="my-account-content account-order">
                                <div class="wrap-account-order">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="fw-6">Order</th>
                                                <th class="fw-6">Date</th>
                                                <th class="fw-6">Status</th>
                                                <th class="fw-6">Total</th>
                                                <th class="fw-6">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="tf-order-item">
                                                <td>
                                                    #123
                                                </td>
                                                <td>
                                                    August 1, 2024
                                                </td>
                                                <td>
                                                    On hold
                                                </td>
                                                <td>
                                                    $200.0 for 1 items
                                                </td>
                                                <td>
                                                    <a href="my-account-orders-details.html" class="tf-btn btn-fill animate-hover-btn rounded-0 justify-content-center">
                                                        <span>View</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="tf-order-item">
                                                <td>
                                                    #345
                                                </td>
                                                <td>
                                                    August 2, 2024
                                                </td>
                                                <td>
                                                    On hold
                                                </td>
                                                <td>
                                                    $300.0 for 1 items
                                                </td>
                                                <td>
                                                    <a href="my-account-orders-details.html" class="tf-btn btn-fill animate-hover-btn rounded-0 justify-content-center">
                                                        <span>View</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="tf-order-item">
                                                <td>
                                                    #567
                                                </td>
                                                <td>
                                                    August 3, 2024
                                                </td>
                                                <td>
                                                    On hold
                                                </td>
                                                <td>
                                                    $400.0 for 1 items
                                                </td>
                                                <td>
                                                    <a href="my-account-orders-details.html" class="tf-btn btn-fill animate-hover-btn rounded-0 justify-content-center">
                                                        <span>View</span>
                                                    </a>
                                                </td>
                                            </tr>
    
                                        </tbody>
                                    </table>
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
