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
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</section>
@endsection
