@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Chỉnh Sửa Tag</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Chỉnh Sửa Tag</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST" enctype="multipart/form-data" id="edit-form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Ảnh Tag -->
                        <div class="form-group">
                            <label>Ảnh Tag Hiện Tại</label>
                            <div class="mb-2">
                                @if ($tag->background_image)
                                    <img src="{{ asset('storage/' . $tag->background_image) }}" alt="Ảnh hiện tại" style="width: 100%; height: auto; object-fit: cover;">
                                @else
                                    <p class="text-muted">Không có ảnh</p>
                                @endif
                            </div>
                            <label>Cập Nhật Ảnh Tag</label>
                            <div class="image-preview mx-auto" @error('background_image') style="border:2px dashed red" @enderror>
                                <label for="image-upload" id="image-label"> Chọn Tập Tin</label>
                                <input type="file" name="background_image" id="image-upload" accept="image/*" style="display: none;" />
                                <span id="image-preview" style="display: none;">
                                    <img src="" alt="Preview Image" style="width: 100%; height: 100%; object-fit: cover;" />
                                </span>
                            </div>
                            @error('background_image')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Loại -->
                        <div class="form-group">
                            <label>Loại</label>
                            <select name="type" class="form-control">
                                <option value="collection" {{ $tag->type === 'collection' ? 'selected' : '' }}>Bộ sưu tập</option>
                                <option value="material" {{ $tag->type === 'material' ? 'selected' : '' }}>Chất liệu</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-6 col-12">
                        <!-- Tên Tag -->
                        <div class="form-group">
                            <label>Tên Tag</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $tag->name) }}">
                        </div>
                        @error('name')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Mô Tả -->
                        <div class="form-group">
                            <label>Mô Tả</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $tag->description) }}</textarea>
                        </div>
                        @error('description')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Nút Lưu -->
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" onclick="confirmUpdate()">Cập Nhật</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Hiển thị ảnh đã chọn
    $(document).ready(function () {
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

  
    function confirmUpdate() {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn cập nhật tag này?',
            text: "Các thay đổi sẽ được lưu lại!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Cập Nhật',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
              
                document.getElementById('edit-form').submit();
            }
        });
    }
</script>
@endsection
