@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Sửa Màu Sắc</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.colors.update', $color->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Sử dụng PUT để cập nhật dữ liệu -->
                
                <div class="form-group">
                    <label for="name">Tên Màu Sắc</label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $color->name) }}" 
                        placeholder="Nhập tên màu sắc" 
                        required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sku_color">Chọn Màu</label>
                    <input 
                        type="color" 
                        class="form-control @error('sku_color') is-invalid @enderror" 
                        name="sku_color" 
                        id="sku_color" 
                        value="{{ old('sku_color', $color->sku_color) }}" 
                        required>
                    @error('sku_color')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                <a href="{{ route('admin.colors.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</section>
@endsection
