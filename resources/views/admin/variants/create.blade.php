@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Thêm Biến Thể Sản Phẩm</h1>
        </div>

        <form action="{{ route('variants.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="product_code">Mã sản phẩm</label>
                        <input type="text" class="form-control" id="product_code" name="product_code" required>
                    </div>
                    <div class="form-group">
                        <label for="product_id">Sản phẩm</label>
                        <select class="form-control" id="product_id" name="product_id" required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="color_id">Màu sắc</label>
                        <select class="form-control" id="color_id" name="color_id" required>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="size_id">Kích thước</label>
                        <select class="form-control" id="size_id" name="size_id" required>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="stock_quantity">Số lượng tồn kho</label>
                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a href="{{ route('variants.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </div>
        </form>
    </section>
@endsection
