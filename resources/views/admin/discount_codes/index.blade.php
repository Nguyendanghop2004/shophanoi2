@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Danh sách mã giảm giá</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh sách mã giảm giá </h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.discount_codes.create') }}" class="btn btn-primary">
                        Tạo Mới
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="section-title mt-0">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="discount-codes-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mã</th>
                                    <th>Loại</th>
                                    <th>Giá trị</th>
                                    <th>Đã sử dụng</th>
                                    <th>Bắt đầu</th>
                                    <th>Kết thúc</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Ngăn form gửi đi ngay lập tức
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa mã giảm giá này?',
                text: 'Hành động này không thể hoàn tác!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Gửi form khi người dùng xác nhận
                }
            });
            return false; // Ngăn gửi form mặc định
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = $('#discount-codes-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: {!! json_encode(route('admin.discount_codes.data')) !!},
                    type: 'GET',
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'discount_type',
                        name: 'discount_type'
                    },
                    {
                        data: 'discount_value',
                        name: 'discount_value'
                    },
                    { data: 'usage_limit', name: 'usage_limit' }, // Thêm cột giới hạn sử dụng

                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            // Lắng nghe sự kiện real-time từ Laravel Echo
            Echo.channel('discount-codes')
                .listen('.DiscountCodeUpdated', (e) => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Mã giảm giá đã được cập nhật!',
                        text: `Hành động: ${e.action}`,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    table.ajax.reload(null, false); // Làm mới DataTable
                });
        });
    </script>
@endpush
