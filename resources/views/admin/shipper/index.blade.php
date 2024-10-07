@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <h1 class="mt-5">Danh Sách Nhân Viên Giao Hàng</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('shippers.create') }}" class="btn btn-primary mb-3">Thêm Nhân Viên Giao Hàng</a>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0">
                    Danh sách nhân viên giao hàng
                </div>
                <div class="card-header-action">
                    <form class="form-inline">
                        <div class="search-element">
                            <input class="form-control" type="search" placeholder="Tìm kiếm" aria-label="Search" data-width="250">
                            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Quê quán</th>
                                <th scope="col">Ngày sinh</th>
                                <th scope="col">Ảnh đại diện</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shippers as $shipper)
                                <tr>
                                    <td>{{ $shipper->name }}</td>
                                    <td>{{ $shipper->email }}</td>
                                    <td>{{ $shipper->phone }}</td>
                                    <td>{{ $shipper->hometown }}</td>
                                    <td>{{ $shipper->date_of_birth }}</td>
                                    <td><img src="{{ asset($shipper->profile_picture) }}" alt="{{ $shipper->name }}" width="50"></td>
                                    <td>
                                        <a href="{{ route('shippers.edit', $shipper->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                        <form action="{{ route('shippers.destroy', $shipper->id) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card-body mx-auto">
            <div class="buttons">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">»</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

@endsection
