@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Account Quản trị viên</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Quản Trị</h4>
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
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Image</th>
                                <th scope="col">Vai Trò</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <th scope="row">{{ $admin->id }}</th>
                                    <td> {{$admin->name}}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        <img src="{{ Storage::url($admin->image_path) }}" alt="Ảnh quản trị viên"
                                            width="100px" height="60px">
                                    </td>
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
                                            <a href="{{ route('admin.accounts.show', $admin->id) }}"
                                                class="btn btn-primary mx-2">
                                                <i class="fas fa-eye "></i>
                                            </a>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.accounts.edit', $admin->id) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
<<<<<<< HEAD
                                            
=======
                                          
>>>>>>> 5a6ee19b9729a054b484f6dd3f75ab8a2b83e543
                                            {{-- <!-- Xóa tài khoản -->
                                            <form action="{{ route('admin.accounts.destroy', $admin->id) }}" method="POST" class="ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form> --}}

                                            <!-- Vô hiệu hóa tài khoản -->
                                            @if ($admin->status)
                                                <form action="{{ route('admin.accounts.deactivate', $admin->id) }}" method="POST" class="ml-2">
                                                    @csrf
                                                    <button 
                                                        type="submit" 
                                                        class="btn btn-danger">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Kích hoạt tài khoản -->
                                                <form action="{{ route('admin.accounts.activate', $admin->id) }}" method="POST" class="ml-2">
                                                    @csrf
                                                    <button 
                                                        type="submit" 
                                                        class="btn btn-success">
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

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Success message
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

            // Confirmation for deleting an account
            document.querySelectorAll('form[action*="destroy"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xóa?',
                        text: "Dữ liệu sẽ không thể phục hồi!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Có, xóa!',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Confirmation for deactivating an account
            document.querySelectorAll('form[action*="deactivate"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn vô hiệu hóa tài khoản này?',
                        text: "Tài khoản sẽ không thể đăng nhập!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Có, vô hiệu hóa!',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Confirmation for activating an account
            document.querySelectorAll('form[action*="activate"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn kích hoạt tài khoản này?',
                        text: "Tài khoản sẽ có thể đăng nhập lại!",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Có, kích hoạt!',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
