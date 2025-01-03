@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Mục</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Sửa danh mục</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sales.update', $sale->id) }}" method="POST">
                @csrf
                @method('PUT')
            
                <div class="form-group">
                    <label for="product_id">Sản phẩm</label>
                    <select name="product_id" id="product_id" class="form-control" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $sale->product_id == $product->id ? 'selected' : '' }}>
                                {{ $product->product_name }} - Giá: {{ $product->price }}
                            </option>
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group mt-3">
                    <label for="discount_type">Loại giảm giá</label>
                    <select name="discount_type" id="discount_type" class="form-control" required>
                        <option value="percent" {{ $sale->discount_type == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm</option>
                        <option value="fixed" {{ $sale->discount_type == 'fixed' ? 'selected' : '' }}>Giảm theo số tiền cố định</option>
                    </select>
                </div>
            
                <div class="form-group mt-3">
                    <label for="discount_value">Giá trị giảm</label>
                    <input type="number" name="discount_value" id="discount_value" class="form-control" step="0.01" value="{{ $sale->discount_value }}" required>
                </div>
            
                <div class="form-group mt-3">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="{{ $sale->start_date->format('Y-m-d\TH:i') }}" required>
                </div>
            
                <div class="form-group mt-3">
                    <label for="end_date">Ngày kết thúc</label>
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="{{ $sale->end_date ? $sale->end_date->format('Y-m-d\TH:i') : '' }}">
                </div>
            
                <button type="submit" class="btn btn-primary mt-4">Cập nhật</button>
                <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary mt-4">Hủy</a>
            </form>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

     
        $('#image-upload').change(function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    $('#image-preview img').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
