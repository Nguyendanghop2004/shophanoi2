@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Danh Sách Nhân Viên Giao Hàng</h1>
        </div>



        <a href="{{ route('shippers.create') }}" class="btn btn-primary mb-3">Thêm Nhân Viên Giao Hàng</a>

        <div class="card card-primary">
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
                                    <td>
                                        <img src="{{ asset($shipper->profile_picture) }}" alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <a href="{{ route('shippers.edit', $shipper->id) }}" class="btn btn-icon btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('shippers.destroy', $shipper->id) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-body mx-auto">
                <div class="buttons">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ $shippers->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $shippers->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>

                            @foreach ($shippers->getUrlRange(1, $shippers->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $shippers->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="page-item {{ $shippers->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $shippers->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<script>
    $(document).ready(function () {
        toastr.options = {
            "closeButton": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });

   
</script>
@endsection
