@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Sản Phẩm {{ $product->product_name }} </h1>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-8 col-12">
                <div class="card card-warning">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Chi tiết sản phẩm </h4>
                        <a href="javascript:history.back()" class="btn btn-primary">Quay lại</a>
                    </div>
                </div>
                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Thông tin chung sản phẩm chính </h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Tên Sản Phẩm:</strong> {{ $product->product_name }}</p>
                        <p><strong>Mã Sản Phẩm:</strong> {{ $product->sku }}</p>
                        <p><strong>Giá Sản Phẩm:</strong> {{ $product->price }}</p>
                        <p><strong>Đường dẫn thân thiện:</strong> {{ $product->slug }}</p>
                        <p><strong>Thương hiệu:</strong> {{ $product->brand->name }}</p>
                        <div class="form-group d-flex align-items-center">
                            <img id="brandImage" src="{{ asset('storage/' . $product->brand->image_brand_url) }}"
                                alt="" style="height: 80px;">
                        </div>
                    </div>
                </div>
                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Danh mục</h4>
                    </div>
                    <div class="card-body">
                        <ul style="list-style-type: none; padding: 0;">
                            @foreach($product->categories as $category)
                                <li><strong>{{ $category->name }}</strong></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Mô tả</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group pl-5 pr-5">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($product->colors as $color)
            <div class="card card-info">
                <div class="card-header">
                    <h4>Biến thể màu {{ $color->name }}</h4>
                </div>

                <div class="card-body">
                    <div class="card-body">
                        <div class="gallery gallery-md">
                            @if (isset($imagesGroupedByColor[$color->id]))
                                @foreach ($imagesGroupedByColor[$color->id] as $image)
                                    <div style="height:200px; width:200px;" class="gallery-item"
                                        data-image="{{ asset('storage/' . $image->image_url) }}" data-title="Image 1"
                                        href="{{ asset('storage/' . $image->image_url) }}" title="Image 1"
                                        style="background-image: url(&quot;{{ asset('storage/' . $image->image_url) }}&quot;);">
                                    </div>
                                @endforeach
                            @else
                                <p>Không có ảnh cho màu này.</p>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã biến thể</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Biến thể size</th>
                                        <th scope="col">Số lượng tồn kho</th>
                                        <th scope="col">Giá cộng thêm</th>
                                        <th scope="col">Trạng Thái</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($variantsGroupedByColor[$color->id] as $variant)
                                        <tr>
                                            <td>{{ $variant->product_code }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $variant->size->name ?? 'Không có kích thước' }}</td>
                                            <td>{{ $variant->stock_quantity }}</td>
                                            <td>{{ $variant->price }}</td>
                                            <td>
                                                @if($variant->status)
                                                    <span class="badge badge-success">Hoạt động</span>
                                                @else
                                                    <span class="badge badge-warning">Không hoạt động</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </section>
@endsection

@push('scripts')
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/chocolat/dist/css/chocolat.css') }}">
    <script src="{{ asset('admin/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
@endpush
