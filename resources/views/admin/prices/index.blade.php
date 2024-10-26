@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Giá Bán</h1>
    </div>

    <a href="{{ route('prices.create') }}" class="btn btn-primary mb-3">Thêm Giá Bán</a>

    <div class="card card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="section-title mt-0">
                Danh sách giá bán
            </div>
            <div class="card-header-action">
                <form action="{{ route('prices.search') }}" method="GET" class="form-inline">
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
                            <th scope="col">ID</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Giá bán</th>
                            <th scope="col">Ngày bắt đầu</th>
                            <th scope="col">Ngày kết thúc</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prices as $price)
                            <tr>
                                <td>{{ $price->id }}</td>
                                <td>{{ $price->product->product_name }}</td>
                                <td>{{ number_format($price->sale_price, 2) }} VNĐ</td>
                                <td>{{ $price->start_date }}</td>
                                <td>{{ $price->end_date }}</td>
                                <td>
                                    <a href="{{ route('prices.edit', $price->id) }}" class="btn btn-icon btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('prices.destroy', $price->id) }}" method="POST" style="display:inline-block">
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
