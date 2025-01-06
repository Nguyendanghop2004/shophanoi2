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
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $size->name) }}" 
                        placeholder="Nhập tên kích thước" 
                        required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</section>
@endsection
