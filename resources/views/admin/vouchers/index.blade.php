@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Danh Mục Sản Phẩm</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Danh Mục Sản Phẩm</h4>
                <div class="card-header-action">
                    <a href="{{ route('vouchers.create') }}" class="btn btn-primary">
                        Tạo Mới
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="section-title mt-0"></div>
                    <div class="card-header-action">
                        <form class="form-inline" method="GET" action="{{ route('vouchers.index') }}">
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
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Voucher</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Product Id</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($vouchers->isNotEmpty())
                                    @foreach ($vouchers as $voucher)
                                        <tr>
                                            <th scope="row">{{ $voucher->id }}</th>
                                            <td>{{ $voucher->title }}</td>
                                            <td>{{ $voucher->description }}</td>
                                            <td>{{ $voucher->vouchers }}</td>
                                            <td>{{ $voucher->start_date }}</td>
                                            <td>{{ $voucher->end_date }}</td>
                                            <td>{{ $voucher->products_id }}</td>
                                            <td scope="row">
                                                <div class="d-flex justify-content-start">
                                                    <div>
                                                        <a href="{{ route('vouchers.edit', $voucher) }}" class="btn btn-warning">
                                                            <i class="fas fa-edit" style="color: #ffffff;"></i>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <form action="{{ route('vouchers.destroy', $voucher) }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có muốn xoá không?')">
                                                                <i class="fas fa-trash" style="color: #ffffff;"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">Không tìm thấy kết quả nào!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-body mx-auto">
                <div class="buttons">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item {{ $vouchers->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $vouchers->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($page = 1; $page <= $vouchers->lastPage(); $page++)
                                <li class="page-item {{ $page == $vouchers->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $vouchers->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $vouchers->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $vouchers->nextPageUrl() }}" aria-label="Next">
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
   
@endsection 