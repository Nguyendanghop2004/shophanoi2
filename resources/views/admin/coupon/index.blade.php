<!-- resources/views/admin/discount_codes/index.blade.php -->


@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Mục Mã Giảm Giá</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Danh Mục Mã Giảm Giá</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.discount_codes.create') }}" class="btn btn-primary">
                    Tạo Mới
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="section-title mt-0"></div>
                <div class="card-header-action">
                    <!-- Form tìm kiếm -->
                    <form class="form-inline" method="GET" action="{{ route('admin.discount_codes.index') }}">
                        <div class="search-element">
                            <input class="form-control" type="search" placeholder="Tìm kiếm..." aria-label="Search"
                                name="code" value="{{ old('code', $searchs) }}" data-width="250">  
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
                                <th scope="col">Mã Giảm Giá</th>
                                <th scope="col">Loại Giảm Giá</th>
                                <th scope="col">Giá Trị</th>
                                <th scope="col">Ngày Bắt Đầu</th>
                                <th scope="col">Ngày Kết Thúc</th>
                                <th scope="col">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($discountCodes->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-danger">Không có mã giảm giá nào.</td>
                                </tr>
                            @else
                                @foreach($discountCodes as $discountCode)
                                    <tr>
                                        <td>{{ $discountCode->id }}</td>
                                        <td>{{ $discountCode->code }}</td>
                                        <td>{{ ucfirst($discountCode->discount_type) }}</td>
                                        <td>{{ $discountCode->discount_value }}</td>
                                        <td>{{ $discountCode->start_date }}</td>
                                        <td>{{ $discountCode->end_date }}</td>
                                        <td>
                                            <a href="{{ route('admin.discount_codes.edit', $discountCode->id) }}" class="btn btn-warning"> <i class="fas fa-edit"></i></a>

                                            <form action="{{ route('admin.discount_codes.destroy', $discountCode->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger ml-2"><i
                                                class="fas fa-trash" style="color: #ffffff;"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Phân trang -->
        <div class="card-body mx-auto">
            <div class="buttons">
                {{ $discountCodes->links() }}  <!-- Phân trang tự động hiển thị -->
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
