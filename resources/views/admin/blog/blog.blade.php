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
                                <th scope="col">title</th>
                                <th scope="col">unique</th>
                                <th scope="col">image</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $admin)
                                <tr>
                                    <th scope="row">{{ $admin->id }}</th>
                                    <td>{{ $admin->title }}</td>
                                    <td>{{ $admin->unique }}</td>
                                    <td>
                                        <img src="{{ Storage::url($admin->image) }}" alt="Ảnh quản trị viên"
                                            width="100px" height="60px">
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
                                            <a href="{{ route('admin.blog.edit', ['id' => Crypt::encryptString($admin->id)]) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.blog.destroy', $admin->id) }}" method="POST" id="delete-form-{{ $admin->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger ml-2" onclick="confirmDeleteForm({{ $admin->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @if ($admin->status)
                                                <form action="{{ route('admin.accountsUser.deactivateBlog', $admin->id) }}" method="POST" id="deactivate-form-{{ $admin->id }}" class="ml-2">
                                                    @csrf
                                                    <button type="button" class="btn btn-danger" onclick="confirmDeactivateForm({{ $admin->id }})">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.accountsUser.activateBlog', $admin->id) }}" method="POST" id="activate-form-{{ $admin->id }}" class="ml-2">
                                                    @csrf
                                                    <button type="button" class="btn btn-success" onclick="confirmActivateForm({{ $admin->id }})">
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
                {{ $data->links() }}
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        function confirmDeleteForm(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa?',
                text: "Bạn sẽ không thể hoàn tác thay đổi này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function confirmDeactivateForm(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn vô hiệu hóa?',
                text: "Bạn sẽ không thể hoàn tác thay đổi này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Vô hiệu hóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deactivate-form-' + id).submit();
                }
            });
        }

        function confirmActivateForm(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn kích hoạt?',
                text: "Bạn sẽ không thể hoàn tác thay đổi này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Kích hoạt',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('activate-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
