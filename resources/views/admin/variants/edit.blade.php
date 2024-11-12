@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chỉnh Sửa Biến Thể Sản Phẩm</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Chỉnh Sửa Biến Thể Sản Phẩm</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('variants.update', $variant->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Sản Phẩm</label>
                    <select name="product_id" class="form-control @error('product_id') is-invalid @enderror">
                        <option value="">Chọn sản phẩm</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $variant->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Màu Sắc</label>
                    <select name="color_id" class="form-control @error('color_id') is-invalid @enderror">
                        <option value="">Chọn màu sắc</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}" {{ $variant->color_id == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                        @endforeach
                    </select>
                    @error('color_id')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Kích Thước</label>
                    <select name="size_id" class="form-control @error('size_id') is-invalid @enderror">
                        <option value="">Chọn kích thước</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}" {{ $variant->size_id == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                        @endforeach
                    </select>
                    @error('size_id')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Số Lượng Tồn Kho</label>
                    <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ $variant->stock_quantity }}">
                    @error('stock_quantity')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Giá</label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" step="0.01" value="{{ $variant->price }}">
                    @error('price')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                <a href="{{ route('variants.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</section>
@endsection
