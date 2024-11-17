@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chỉnh Sửa Bộ Sưu Tập</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tag_collections.update', $tagCollection->id) }}" method="POST">
                @csrf
                @method('PUT') 
                <div class="form-group">
                    <label for="name">Tên Bộ Sưu Tập</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $tagCollection->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </form>
        </div>
    </div>
</section>
@endsection
