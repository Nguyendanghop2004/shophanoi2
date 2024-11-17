@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chỉnh Sửa Thuộc Tính</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Chỉnh Sửa Thuộc Tính</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Tên Thuộc Tính</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $attribute->name) }}">
                    @error('name')
                        <div class="invalid-feedback" style="display: block;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </form>
        </div>
    </div>
</section>
@endsection
