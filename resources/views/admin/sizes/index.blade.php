@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Kích Thước</h1>
    </div>

    <a href="{{ route('sizes.create') }}" class="btn btn-primary mb-3">Thêm Kích Thước</a>

    <div class="card">
        <div class="card-header">
            <h4>Danh Sách Kích Thước</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sizes as $size)
                        <tr>
                            <td>{{ $size->id }}</td>
                            <td>{{ $size->name }}</td>
                            <td>
                                <a href="{{ route('sizes.edit', $size->id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('sizes.destroy', $size->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
