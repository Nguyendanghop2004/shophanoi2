@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Gán Shipper cho Đơn Hàng</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Đơn Hàng Cần Giao Shipper</h4>
            </div>
            <div class="card-body">


                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID Đơn Hàng</th>
                                <th scope="col">Tên Người Mua</th>
                                <th scope="col">Email</th>
                                <th scope="col">Trạng Thái</th>
                                <th scope="col">Giao cho Shipper</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        @if ($errors->has('assigned_shipper_id'))
                                            <span class="text-danger">{{ $errors->first('assigned_shipper_id') }}</span>
                                        @endif
                                        <form action="{{ route('admin.order.assignShipper', $order->id) }}" method="POST">
                                            @csrf
                                            <select name="assigned_shipper_id" class="form-control" required>
                                                <option value="">Chọn Shipper</option>
                                                @foreach ($shippers as $shipper)
                                                    <option value="{{ $shipper->id }}">{{ $shipper->name }}</option>
                                                @endforeach
                                            </select>

                                            <button type="button" class="btn btn-success btn-sm mt-2"
                                                onclick="confirmUpdateForm(this)">
                                                Giao cho Shipper
                                            </button>
                                        </form>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmUpdateForm(button) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?',
                text: "Bạn không thể hoàn tác thay đổi này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Cập nhật!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu xác nhận, gửi form
                    button.closest('form').submit();
                }
            });
        }
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        });
    </script>
@endsection
