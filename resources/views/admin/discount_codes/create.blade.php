@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Giảm Giá</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Tạo mã giảm giá mới</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.discount_codes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Mã giảm giá -->
                            <div class="form-group">
                                <label for="code">Mã giảm giá</label>
                                <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" 
                                    value="{{ old('code') }}" placeholder="Nhập mã giảm giá">
                                @error('code')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Loại giảm giá -->
                            <div class="form-group">
                                <label for="discount_type">Loại giảm giá</label>
                                <select name="discount_type" id="discount_type" class="form-control @error('discount_type') is-invalid @enderror">
                                    <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Phần trăm</option>
                                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Cố định</option>
                                </select>
                                @error('discount_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Giá trị giảm giá -->
                            <div class="form-group">
                                <label for="discount_value">Giá trị giảm giá</label>
                                <input type="number" name="discount_value" id="discount_value" class="form-control @error('discount_value') is-invalid @enderror" 
                                    value="{{ old('discount_value') }}" placeholder="Nhập giá trị giảm giá">
                                @error('discount_value')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Giới hạn sử dụng -->
                            <div class="form-group">
                                <label for="usage_limit">Giới hạn số lần sử dụng</label>
                                <input type="number" name="usage_limit" id="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" 
                                    value="{{ old('usage_limit') }}" placeholder="Không giới hạn nếu để trống">
                                @error('usage_limit')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Ngày bắt đầu -->
                            <div class="form-group">
                                <label for="start_date">Ngày bắt đầu</label>
                                <input type="text" name="start_date" id="start_date" class="form-control datetimepicker @error('start_date') is-invalid @enderror" 
                                    value="{{ old('start_date') }}">
                                @error('start_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div> 

                            <!-- Ngày kết thúc -->
                            <div class="form-group">
                                <label for="end_date">Ngày kết thúc</label>
                                <input type="text" name="end_date" id="end_date" class="form-control datetimepicker @error('end_date') is-invalid @enderror" 
                                    value="{{ old('end_date') }}">
                                @error('end_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Người dùng áp dụng -->
                            <div class="form-group">
                                <label for="user_ids">Người dùng áp dụng</label>
                                <select name="user_ids[]" id="user_ids" class="form-control select2 @error('user_ids') is-invalid @enderror" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ collect(old('user_ids'))->contains($user->id) ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_ids')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Sản phẩm áp dụng -->
                            <div class="form-group">
                                <label for="product_ids">Sản phẩm áp dụng</label>
                                <select name="product_ids[]" id="product_ids" class="form-control select2 @error('product_ids') is-invalid @enderror" multiple>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ collect(old('product_ids'))->contains($product->id) ? 'selected' : '' }}>
                                            {{ $product->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_ids')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>                     
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <button type="submit" class="btn btn-success">Tạo mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
