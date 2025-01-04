@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Giảm giá sản phẩm </h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Thêm Mới giá giảm </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sales.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="product_id">Sản phẩm</label>
                    <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror">
                        <option value="">Chọn sản phẩm</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->product_name }} - Giá: {{ $product->price }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group mt-3">
                    <label for="discount_type">Loại giảm giá</label>
                    <select name="discount_type" id="discount_type" class="form-control @error('discount_type') is-invalid @enderror">
                        <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm</option>
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giảm theo số tiền cố định</option>
                    </select>
                    @error('discount_type')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group mt-3">
                    <label for="discount_value">Giá trị giảm</label>
                    <input type="number" name="discount_value" id="discount_value" 
                        class="form-control @error('discount_value') is-invalid @enderror" 
                        step="0.01" value="{{ old('discount_value') }}">
                    @error('discount_value')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group mt-3">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input type="datetime-local" name="start_date" id="start_date" 
                        class="form-control @error('start_date') is-invalid @enderror" 
                        value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group mt-3">
                    <label for="end_date">Ngày kết thúc</label>
                    <input type="datetime-local" name="end_date" id="end_date" 
                        class="form-control @error('end_date') is-invalid @enderror" 
                        value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <button type="submit" class="btn btn-success mt-4">Lưu</button>
                <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary mt-4">Hủy</a>
            </form>
        </div>
    </div>
</section>
<style>
    .is-invalid {
    border-color: #e3342f; /* Màu đỏ cho viền input */
}
.text-danger {
    font-size: 0.875rem; /* Kích thước chữ nhỏ hơn */
    color: #e3342f; /* Màu đỏ */
}

</style>
@endsection
