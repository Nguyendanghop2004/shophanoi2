@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Thêm Giá Bán</h1>
    </div>

    <form action="{{ route('prices.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="product_id">Sản phẩm</label>
                    <select class="form-control" id="product_id" name="product_id">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sale_price">Giá bán</label>
                    <input type="text" class="form-control" id="sale_price" name="sale_price" required>
                </div>
                <div class="form-group">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="form-group">
                    <label for="end_date">Ngày kết thúc</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{ route('prices.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </form>
</section>
@endsection
