@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chỉnh Sửa Chất Liệu</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tag_materials.update', $tagMaterial->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Method spoofing to indicate PUT request -->
                <div class="form-group">
                    <label for="name">Tên Chất Liệu</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name', $tagMaterial->name) }}" required>
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
