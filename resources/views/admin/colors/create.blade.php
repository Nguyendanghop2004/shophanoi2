@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Thêm Màu Sắc</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('colors.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên Màu Sắc</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="color">Chọn Màu</label>
                    <input type="text" class="form-control" name="color" id="color" required>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</section>

@push('scripts')
    <!-- Thêm CSS và JavaScript cho Bootstrap Colorpicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Khởi tạo colorpicker
            $('#color').colorpicker();
        });
    </script>
@endpush
@endsection
