@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Account User</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách User</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.accountsUser.create') }}" class="btn btn-primary">
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
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td><a class="text-primary"
                                            href="{{ route('admin.accountsUser.show', $user->id) }}">{{ $user->name }}</a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <img src="{{ Storage::url($user->image) }}" alt="Ảnh quản trị viên" width="100px"
                                            height="60px">
                                    </td>

                                    <td>
                                        @if ($user->status)
                                            <span class="badge badge-success">Hoạt động</span>
                                        @else
                                            <span class="badge badge-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="mb-1 ga-bottom">{{ $user->ward->name_xaphuong ?? '' }}</p>
                                        <p class="mb-1 ga-bottom ">{{ $user->province->name_quanhuyen ?? '' }}</p>
                                        <p class="mb-1 ga-bottom ">{{ $user->city->name_thanhpho ?? '' }}</p>
                                        <p class="mb-0 ga-bottom ">{{ $user->address }}</p>
                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.accountsUser.edit', $user->id) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.accountsUser.destroy', $user->id) }}"
                                                method="POST" id="delete-user-{{ $user->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger ml-2 delete-btn"
                                                    data-user-id="{{ $user->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>

                                            @if ($user->status)
                                                <form action="{{ route('admin.accountsUser.deactivateUser', $user->id) }}"
                                                    method="POST" class="ml-2" id="activate-user-{{ $user->id }}">
                                                    @csrf
                                                    <button type="button" class="btn btn-success activate-btn"
                                                        data-user-id="{{ $user->id }}">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.accountsUser.activateUser', $user->id) }}"
                                                    method="POST" class="ml-2" id="deactivate-user-{{ $user->id }}">
                                                    @csrf
                                                    <button type="button" class="btn btn-danger deactivate-btn"
                                                        data-user-id="{{ $user->id }}">
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
                {{ $users->links() }}
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Success and Error messages
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

            // Confirm delete user
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.dataset.userId;
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
                            document.getElementById(`delete-user-${userId}`).submit();
                        }
                    });
                });
            });

            // Confirm deactivate user
            document.querySelectorAll('.deactivate-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.dataset.userId;
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
                            document.getElementById(`deactivate-user-${userId}`).submit();
                        }
                    });
                });
            });

            // Confirm activate user
            document.querySelectorAll('.activate-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.dataset.userId;
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
                            document.getElementById(`activate-user-${userId}`).submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
