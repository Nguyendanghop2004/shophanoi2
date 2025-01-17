@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Sản Phẩm Giảm Giá </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Sản Phẩm Được Giảm </h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.sales.create') }}" class="btn btn-primary">
                        Tạo Mới
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="section-title mt-0"></div>
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="form-inline" method="GET" action="{{ route('admin.sales.index') }}">
                            <div class="search-element">
                                <input class="form-control" name="search" type="search" placeholder="Search"
                                    aria-label="Search" data-width="250" value="{{ request()->input('search') }}">
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
                                    <th>#</th>
                                    <th>Sản phẩm</th>
                                    <th>Loại giảm giá</th>
                                    <th>Giá trị giảm</th>
                                    <th>Thời gian</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->product->product_name }}</td>
                                        <td>
                                            @if ($sale->discount_type == 'fixed')
                                                Giá tiền
                                            @else
                                                Phần Trăm
                                            @endif
                                        </td>
                                        <td>
                                            @if ($sale->discount_type == 'fixed')
                                                {{ number_format($sale->discount_value, 0, ',', '.') }} VNĐ
                                            @else
                                                {{ number_format($sale->discount_value, 0, ',', '.') }} %
                                            @endif
                                        </td>
                                        <td>
                                            @if ($sale->start_date)
                                                {{ $sale->start_date }}
                                            @endif
                                        
                                            @if ($sale->end_date)
                                                 - {{ $sale->end_date }}
                                            @else
                                              -  Vô Hạn 
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.sales.edit', $sale->id) }}"
                                                class="btn btn-warning">Chỉnh
                                                sửa</a>
                                            <form action="{{ route('admin.sales.destroy', $sale->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
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
                            <li class="page-item {{ $sales->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $sales->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>

                            @foreach ($sales->getUrlRange(1, $sales->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $sales->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="page-item {{ $sales->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $sales->nextPageUrl() }}" aria-label="Next">
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
        $(document).ready(function() {
            toastr.options = {
                "closeButton": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
            };

            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        });
    </script>
@endsection
