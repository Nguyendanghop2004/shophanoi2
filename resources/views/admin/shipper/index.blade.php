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
                                            <a href="{{ route('admin.accounts.edit', $admin->id) }}"
                                               class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.accounts.destroy', $admin->id) }}" method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger ml-2">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            @if ($admin->status)
                                                <form action="{{ route('admin.accounts.deactivate', $admin->id) }}"
                                                    method="POST" class="ml-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.accounts.activate', $admin->id) }}"
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

                {{ $admins->links() }}
            </div>
        </div>
    </section>
@endsection
