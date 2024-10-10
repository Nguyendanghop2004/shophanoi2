@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <h1>Chỉnh Sửa Nhân Viên Giao Hàng</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('shippers.update', $shipper->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $shipper->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $shipper->email }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Số Điện Thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $shipper->phone }}" required>
        </div>

        <div class="form-group">
            <label for="hometown">Quê Quán</label>
            <input type="text" class="form-control" id="hometown" name="hometown" value="{{ $shipper->hometown }}" required>
        </div>

        <div class="form-group">
            <label for="date_of_birth">Ngày Sinh</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $shipper->date_of_birth }}" required>
        </div>

        <div class="form-group">
            <label for="profile_picture">Ảnh Đại Diện</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
            <img src="{{ asset($shipper->profile_picture) }}" alt="Current Profile Picture" width="100" class="mt-2">
        </div>

        <button type="submit" class="btn btn-success">Cập Nhật</button>
    </form>
</div>
@endsection
