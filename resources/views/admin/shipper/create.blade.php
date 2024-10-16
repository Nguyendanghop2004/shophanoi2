@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <h1>Thêm Nhân Viên Giao Hàng</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('shippers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" name="name"  class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')
                <div class="text-danger">Bạn cần nhập tên</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="date_of_birth">Ngày sinh</label>
            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}">
            @error('date_of_birth')
                <div class="text-danger">Bạn cần nhận ngày sinh</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
            @error('phone')
                <div class="text-danger">Bạn cần nhập số điện thoại</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="hometown">Quê quán</label>
            <input type="text" name="hometown" class="form-control @error('hometown') is-invalid @enderror" value="{{ old('hometown') }}">
            @error('hometown')
                <div class="text-danger">Bạn cần nhập quê quán</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="profile_picture">Ảnh đại diện</label>
            <input type="file" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror">
            @error('profile_picture')
                <div class="text-danger">Bạn cần nhập ảnh</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
</div>
@endsection
