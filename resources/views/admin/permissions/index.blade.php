@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Permission Admin</h1>
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
                                <th scope="col">Permission</th>
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
                                            @foreach($admin->getAllPermissions() as $key => $per)
                                                <span class="badge bg-success">{{ $per->name }}</span> 
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/phanvaitro/'. $admin->id) }}" class="btn btn-success btn-sm mb-1">Vai trò</a>
                                            <a href="{{ url('admin/permissions/phanquyen/'. $admin->id) }}" class="btn btn-info btn-sm mb-1">Quyền</a>
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
