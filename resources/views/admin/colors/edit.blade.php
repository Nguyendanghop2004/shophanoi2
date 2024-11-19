@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Sửa Màu Sắc</h1>
    </div>

    <div class="card card-primary">
        <div class="card-body">
            <form action="{{ route('admin.colors.update', $color->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Tên Màu Sắc</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $color->name }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </form>
        </div>
    </div>
</section>
@endsection
