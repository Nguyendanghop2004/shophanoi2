@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Sản Phẩm</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Sản Phẩm</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                        Tạo Mới Sản Phẩm
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="section-title mt-0">
                    </div>
                    <div class="card-header-action">
                        <form class="form-inline" method="GET" action="{{ route('admin.product.index') }}">
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
                                    <th scope="col">Mã sản phẩm</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Danh mục</th>
                                    <th scope="col">Biến thể màu</th>
                                    <th scope="col">Số lượng tồn kho</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Bộ sưu tập</th>
                                    <th scope="col">Chất liệu</th>
                                    <th scope="col">Trạng Thái</th>
                                    <th scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <th scope="row">{{ $product->sku }}</th>
                                        <td>
                                            <div style="padding: 5px;"><img
                                                    src="{{ asset('storage/' . $product->image_url) }}" alt=""
                                                    style="max-height: 100px"></div>
                                        </td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>
                                            <div class="row">
                                                @foreach ($product->categories as $category)
                                                    <a href="#"
                                                        class="badge badge-light m-1">{{ $category->name }}</a>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                @foreach ($product->colors as $color)
                                                    <span class="colorinput-color m-1 "
                                                        style="background-color: {{ $color->sku_color }};"></span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>{{ $product->total_stock_quantity }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            <div class="row">
                                                @foreach ($product->tags as $tag)
                                                    @if ($tag->type === 'collection')
                                                        <a href="#" class="badge badge-info m-1">
                                                            {{ $tag->name }}</a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                @foreach ($product->tags as $tag)
                                                    @if ($tag->type === 'material')
                                                        <a href="#" class="badge badge-success m-1">
                                                            {{ $tag->name }}</a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            @if ($product->status)
                                                <span class="badge badge-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-warning">Không hoạt động</span>
                                            @endif
                                        </td>

                                        <td scope="row">
                                            <div class="d-flex justify-content-start">
                                                <div> <a href="{{ route('admin.product.show', $product->id) }}"
                                                        class="btn btn-primary"><i class="fas fa-eye"
                                                            style="color: #ffffff;"></i></a></div>

                                                <div class="btn-group mb-2 ml-2">
                                                    <div> <a href="{{ route('admin.product.edit', $product->id) }}"
                                                            class="btn btn-warning"><i class="fas fa-edit"
                                                                style="color: #ffffff;"></i></a></div>
                                                </div>
                                                <div>
                                                    <form action="{{ route('admin.product.destroy', $product->id) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger ml-2"><i
                                                                class="fas fa-trash" style="color: #ffffff;"></i></button>
                                                    </form>
                                                </div>
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
                            <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($page = 1; $page <= $products->lastPage(); $page++)
                                <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $products->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
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

@push('scripts')
    <style>
        /* CSS */
        .colorinput-color {
            border-radius: 50%;
            display: inline-block;
            border: 2px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .colorinput-color:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3);
        }

        .colorinput-color.active {
            border: 3px solid rgba(0, 123, 255, 0.6);
            box-shadow: 0 10px 25px rgba(0, 123, 255, 0.4);
        }
    </style>
@endpush
