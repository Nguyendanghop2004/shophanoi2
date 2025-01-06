@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Thêm Kích Thước</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.sizes.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên Kích Thước</label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}" 
                        placeholder="Nhập tên kích thước" 
                        required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</section>
@endsection
