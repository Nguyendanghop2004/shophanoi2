@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Sản Phẩm Giảm Giá</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Sản Phẩm Được Giảm</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.sales.create') }}" class="btn btn-primary">Tạo Mới</a>
                </div>
            </div>

            <div class="card-body">
                <table id="sales-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sản phẩm</th>
                            <th>Loại giảm giá</th>
                            <th>Giá trị giảm</th>
                            <th>Thời gian</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Gắn DataTables vào biến table
            var table = $('#sales-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {!! json_encode(route('admin.sales.datatables')) !!}, // Gọi route vừa định nghĩa
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'product_name',
                        name: 'product.product_name'
                    },
                    {
                        data: 'discount_type',
                        name: 'discount_type'
                    },
                    {
                        data: 'discount_value',
                        name: 'discount_value'
                    },
                    {
                        data: 'time_range',
                        name: 'time_range',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return data; // Render HTML trong cột Action
                        }
                    },
                ],
            });

            // Lắng nghe sự kiện từ Laravel Echo
            Echo.channel('sales')
                .listen('SaleUpdated', function(e) {
                    const action = e.action;
                    const sale = e.sale;

                    // Hiển thị thông báo với toastr
                    toastr.success(
                        `Sản phẩm ID ${sale.id} đã được ${action === 'create' ? 'thêm' : action === 'update' ? 'cập nhật' : 'xóa'}.`
                    );

                    // Làm mới dữ liệu DataTables
                    table.ajax.reload(null, false); // false để giữ nguyên trang hiện tại
                });
            // Lắng nghe sự kiện từ Laravel Echo
            Echo.channel('sales')
                .listen('SaleUpdated', function(e) {
                    const action = e.action;
                    const sale = e.sale;

                    console.log('dasdasdasdasdsa');
                });
        });
    </script>
@endpush
