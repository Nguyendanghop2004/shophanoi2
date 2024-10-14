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
                    <form action="{{ route('shippers.search') }}" method="GET" class="form-inline">
                        <div class="search-element">
                            <input class="form-control" name="search" type="text" placeholder="Tìm kiếm" aria-label="Search" data-width="250">
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
                                    <td><img src="{{ asset($shipper->profile_picture) }}" alt="{{ $shipper->name }}" width="150px"></td>
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
                    <ul class="pagination justify-content-center">
                        @if ($shippers->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $shippers->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        @endif
        
                        @for ($i = 1; $i <= $shippers->lastPage(); $i++)
                            <li class="page-item {{ $i == $shippers->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $shippers->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
        
                        @if ($shippers->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $shippers->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
        
    </div>

@endsection
