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
                    <select name="product_id" id="product_id" class="form-control" required>
                        <option value="">Chọn sản phẩm</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }} - Giá: {{ $product->price }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group mt-3">
                    <label for="discount_type">Loại giảm giá</label>
                    <select name="discount_type" id="discount_type" class="form-control" required>
                        <option value="percent">Giảm theo phần trăm</option>
                        <option value="fixed">Giảm theo số tiền cố định</option>
                    </select>
                </div>
            
                <div class="form-group mt-3">
                    <label for="discount_value">Giá trị giảm</label>
                    <input type="number" name="discount_value" id="discount_value" class="form-control" step="0.01" required>
                </div>
            
                <div class="form-group mt-3">
                    <label for="start_date">Ngày bắt đầu</label>
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
                </div>
            
                <div class="form-group mt-3">
                    <label for="end_date">Ngày kết thúc</label>
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control">
                </div>
            
                <button type="submit" class="btn btn-success mt-4">Lưu</button>
                <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary mt-4">Hủy</a>
            </form>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
    
        function convertToSlug(text) {
            const from = "áàảãạâấầẩẫậăắằẳẵặéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵđ";
            const to = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd";
            text = text.toLowerCase();
            for (let i = 0; i < from.length; i++) {
                text = text.replace(new RegExp(from[i], "g"), to[i]);
            }
            return text.replace(/[^a-z0-9\s-]/g, '') 
                        .replace(/\s+/g, '-')     
                        .replace(/-+/g, '-');      
        }
        $('input[name="name"]').on('input', function() {
            const name = $(this).val();
            const slug = convertToSlug(name);
            $('input[name="slug"]').val(slug);
        });

  
        $('#image-upload').change(function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    $('#image-preview img').attr('src', event.target.result).parent().show();
                    $('#image-label').text(file.name);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
