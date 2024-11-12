@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chỉnh Sửa Chất Liệu</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Chỉnh Sửa Chất Liệu</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('materials.update', $material->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Tên Chất Liệu</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $material->name) }}">
                            @error('name')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Loại</label>
                            <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type', $material->type) }}">
                            @error('type')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Mô Tả</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $material->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
