@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Sửa Kích Thước</h1>
    </div>

    <div class="card card-primary">
        <div class="card-body">
            <form action="{{ route('admin.sizes.update', $size->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Tên Kích Thước</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $size->name }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </form>
        </div>
    </div>
</section>
@endsection
