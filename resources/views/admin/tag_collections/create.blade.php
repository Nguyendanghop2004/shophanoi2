@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Thêm Bộ Sưu Tập</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tag_collections.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên Bộ Sưu Tập</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</section>
@endsection
