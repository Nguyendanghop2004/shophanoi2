<!-- resources/views/admin/discount_codes/edit.blade.php -->

@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Giảm Gía</h1>
    </div>
<div class="container">
        <h2>Chỉnh Sửa Mã Giảm Giá</h2>
        <form action="{{ route('admin.discount_codes.update', $discountCode->id) }}" method="POST">
            @csrf
            @method('PUT')

        
            <div class="form-group">
                <label for="code">Mã Giảm Giá</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ $discountCode->code }}" required>
            </div>

          
            <div class="form-group">
                <label for="discount_type">Loại Giảm Giá</label>
                <select name="discount_type" id="discount_type" class="form-control" required>
                    <option value="percentage" {{ $discountCode->discount_type == 'percentage' ? 'selected' : '' }}>Phần Trăm</option>
                    <option value="fixed" {{ $discountCode->discount_type == 'fixed' ? 'selected' : '' }}>Số Tiền Cố Định</option>
                </select>
            </div>

      
            <div class="form-group">
                <label for="discount_value">Giá Trị Giảm Giá</label>
                <input type="number" id="discount_value" name="discount_value" class="form-control" value="{{ $discountCode->discount_value }}" required>
            </div>

    
            <div class="form-group">
    <label for="start_date">Ngày Bắt Đầu</label>
    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $discountCode->start_date ? \Carbon\Carbon::parse($discountCode->start_date)->format('Y-m-d') : '') }}" required>
</div>

<div class="form-group">
    <label for="end_date">Ngày Kết Thúc</label>
    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $discountCode->end_date ? \Carbon\Carbon::parse($discountCode->end_date)->format('Y-m-d') : '') }}">
</div>

      
            <div class="form-group">
                <label for="user_ids">Chọn Người Dùng Áp Dụng Mã Giảm Giá</label>
                <select name="user_ids[]" id="user_ids" class="form-control" multiple required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ $discountCode->users->contains($user->id) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập Nhật Mã Giảm Giá</button>
        </form>
    </div>
    </section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
