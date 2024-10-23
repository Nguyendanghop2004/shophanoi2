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
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <th scope="row">{{ $admin->id }}</th>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        <img src="{{ Storage::url($admin->image_path) }}" alt="Ảnh quản trị viên" width="100px" height="60px">
                                    </td>
                                       
                                        <td>
                                            @foreach($admin->roles as $key => $role)
                                            {{$role->name}}
                                            @endforeach
                                        </td>
                                        <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.accounts.edit', $admin->id) }}" class="btn btn-warning">Sửa</a>
                                            <form action="{{ route('admin.accounts.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger ml-2">Xóa</button>
                                            </form>
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
@endsection
