@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Sách Màu Sắc</h1>
    </div>

    <a href="{{ route('colors.create') }}" class="btn btn-primary mb-3">Thêm Màu Sắc</a>

    <div class="card">
        <div class="card-header">
            <h4>Danh Sách Màu Sắc</h4>
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
                    @foreach ($colors as $color)
                        <tr>
                            <td>{{ $color->id }}</td>
                            <td>{{ $color->name }}</td>
                            <td>
                                <a href="{{ route('colors.edit', $color->id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('colors.destroy', $color->id) }}" method="POST" style="display:inline-block">
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
