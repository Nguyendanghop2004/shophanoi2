@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chỉnh Sửa Thương Hiệu</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Chỉnh Sửa Thương Hiệu</h4>
        </div>
        <div class="card-body">

            <form id="brand-update-form" action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Ảnh Thương Hiệu -->
                        <div class="form-group">
                            <label>Ảnh Hiện Tại</label>
                            <div class="mb-2">
                                @if ($brand->image_brand_url)
                                    <img src="{{ asset('storage/' . $brand->image_brand_url) }}" alt="Ảnh hiện tại" style="width: 100%; height: auto; object-fit: cover;">
                                @else
                                    <p class="text-muted">Không có ảnh</p>
                                @endif
                            </div>
                            <label>Cập Nhật Ảnh</label>
                            <div class="image-preview mx-auto @error('image_brand_url') border-danger @enderror" style="border: 2px dashed #ccc; padding: 20px;">
                                <label for="image-upload" id="image-label" style="cursor: pointer;">Chọn Tập Tin</label>
                                <input type="file" name="image_brand_url" id="image-upload" accept="image/*" style="display: none;" />
                                <span id="image-preview" style="display: none;">
                                    <img src="" alt="Preview Image" style="width: 100%; height: 100%; object-fit: cover;" />
                                </span>
                            </div>
                            @error('image_brand_url')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-6 col-12">
                        <!-- Tên Thương Hiệu -->
                        <div class="form-group">
                            <label for="name">Tên Thương Hiệu</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name) }}" placeholder="Nhập tên thương hiệu">
                            @error('name')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Nút Lưu -->
                        <div class="form-group">
                            <button type="button" id="update-btn" class="btn btn-primary">Cập Nhật</button>
                            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Thêm thư viện SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Khi nhấn nút cập nhật
        const updateBtn = document.getElementById('update-btn');

        if (updateBtn) {
            updateBtn.addEventListener('click', function () {
                // Hiển thị SweetAlert confirm
                Swal.fire({
                    title: 'Bạn có chắc chắn muốn cập nhật thương hiệu này?',
                    text: "Các thay đổi sẽ được lưu lại!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Cập Nhật',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Nếu người dùng chọn "Cập Nhật", gửi form
                        document.getElementById('brand-update-form').submit();
                    }
                });
            });
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Hiển thị ảnh đã chọn
        $('#image-upload').change(function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    $('#image-preview img').attr('src', event.target.result).parent().show();
                    $('#image-label').text(file.name);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
