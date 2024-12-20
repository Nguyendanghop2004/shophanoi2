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
                                    <td ><a class="text-primary" href="{{ route('admin.accountsUser.show', $user->id) }}">{{ $user->name }}</a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <img src="{{ Storage::url($user->image) }}" alt="Ảnh quản trị viên" width="100px"
                                            height="60px">
                                    </td>

                                    <td>
                                        @if (!$user->status)
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
                                                method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger ml-2">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>

                                            @if ($user->status)
                                                <form action="{{ route('admin.accountsUser.deactivateUser', $user->id) }}"
                                                    method="POST" class="ml-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.accountsUser.activateUser', $user->id) }}"
                                                    method="POST" class="ml-2">
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
                {{ $users->links() }}
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
    </script>
@endsection
