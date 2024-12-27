@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Danh Sách Shipper</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Shipper</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary">
                        Tạo Mới
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên Shipper</th>
                                <th scope="col">Email</th>
                                <th scope="col">Vai Trò</th>
                                <th scope="col">Trạng Thái</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <th scope="row">{{ $admin->id }}</th>
                                    <td><a class="text-primary"
                                           href="{{ route('admin.accounts.show', $admin->id) }}">{{ $admin->name }}</a>
                                    </td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @foreach ($admin->roles as $role)
                                            {{ $role->name }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($admin->status)
                                            <span class="badge badge-success">Hoạt động</span>
                                        @else
                                            <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <!-- Sửa -->
                                            <a href="{{ route('admin.accounts.edit', $admin->id) }}"
                                               class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Xóa -->
                                            {{-- <form action="{{ route('admin.accounts.destroy', $admin->id) }}" method="POST"
                                                onsubmit="return confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger ml-2">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form> --}}

                                            <!-- Vô hiệu hóa / Kích hoạt -->
                                            @if ($admin->status)
                                                <form action="{{ route('admin.accounts.deactivate', $admin->id) }}"
                                                    method="POST" class="ml-2" onsubmit="return confirmDeactivate(event)">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.accounts.activate', $admin->id) }}"
                                                    method="POST" class="ml-2" onsubmit="return confirmActivate(event)">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-unlock"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $admins->links() }}
            </div>
        </div>
    </section>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Xử lý sự kiện cho nút Vô hiệu hóa
        function confirmDeactivate(event) {
            event.preventDefault();  // Ngừng hành động mặc định của nút
            Swal.fire({
                title: 'Bạn có chắc chắn muốn vô hiệu hóa shipper này?',
                text: 'Shipper sẽ không thể hoạt động nữa!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Vô hiệu hóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu xác nhận, gửi form
                    event.target.closest('form').submit();
                }
            });
        }

        // Xử lý sự kiện cho nút Kích hoạt
        function confirmActivate(event) {
            event.preventDefault();  // Ngừng hành động mặc định của nút
            Swal.fire({
                title: 'Bạn có chắc chắn muốn kích hoạt shipper này?',
                text: 'Shipper sẽ có thể hoạt động lại!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Kích hoạt',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu xác nhận, gửi form
                    event.target.closest('form').submit();
                }
            });
        }

        // Xử lý sự kiện cho nút Xóa
        function confirmDelete(event) {
            event.preventDefault();  // Ngừng hành động mặc định của nút
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa shipper này?',
                text: 'Hành động này không thể hoàn tác!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Nếu xác nhận, gửi form
                    event.target.closest('form').submit();
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
