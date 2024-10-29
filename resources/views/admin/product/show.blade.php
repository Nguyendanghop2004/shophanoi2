@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Sản Phẩm {{ $product->product_name }} </h1>
        </div>
        @foreach ($product->colors as $color)
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Biến thể màu {{ $color->name }}</h4>
                    <div class="card-header-action">
                        <a href="" class="btn btn-primary">
                            Back
                        </a>
                    </div>
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
                                        <th scope="col">Danh mục</th>
                                        <th scope="col">Biến thể màu</th>
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
                                            <td></td>
                                            <td>{{ $color->name }}</td>
                                            <td>{{ $variant->size->name ?? 'Không có kích thước' }}</td>
                                            <td>{{ $variant->stock_quantity }}</td>
                                            <td>{{ $variant->price }}</td>
                                            <td>
                                                @if ($variant->status)
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
    <link rel="stylesheet" href="{{asset('admin/assets/modules/chocolat/dist/css/chocolat.css')}}">
    <script src="{{asset('admin/assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>
@endpush
