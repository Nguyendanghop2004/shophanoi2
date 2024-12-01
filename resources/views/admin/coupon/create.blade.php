


@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Giảm Gía</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Thêm Mới Danh Mục</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.discount_codes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">


                    <div class="col-lg-9 col-md-6 col-12">
                        <div class="form-group">
                            <label>Mã giảm giá</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid  @enderror"
                                value="{{ old('code') }}">
                        </div>
                        @error('code')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <label>loại giảm giá</label>
                            <select name="discount_type" id="discount_type" class="form-control" required>
                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>
                                    Phần Trăm</option>
                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Số Tiền
                                </option>
                            </select>
                        </div>
                        @error('discount_type')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">
                            <label>só tiền giảm</label>
                            <input type="text" name="discount_value" class="form-control @error('discount_value') is-invalid  @enderror"
                                value="{{ old('discount_value') }}">
                        </div>
                        @error('discount_value')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">
                            <label>ngày bắt đàu</label>
                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid  @enderror"
                                value="{{ old('start_date') }}">
                        </div>
                        @error('start_date')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">
                            <label>ngày kết thúc</label>
                            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid  @enderror"
                                value="{{ old('end_date') }}">
                        </div>
                        @error('end_date')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">
                            <label>Danh Mục Cha</label>
                            <select name="user_ids[]" id="user_ids" class="form-control" multiple required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ isset($discountCode) && $discountCode->users->contains($user->id) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection