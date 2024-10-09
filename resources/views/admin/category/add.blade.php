@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Danh Mục</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Thêm Mới Danh Mục</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group">
                            <label>Ảnh Danh Mục</label>
                            <div class="image-preview mx-auto" @error('image_path') style="border:2px dashed red" @enderror>
                                <label for="image-upload" id="image-label"> Chọn Tập Tin</label>
                                <input type="file" name="image_path" id="image-upload" accept="image/*" style="display: none;" />
                                <span id="image-preview" style="display: none;">
                                    <img src="" alt="Preview Image" style="width: 100%; height: 100%; object-fit: cover;" />
                                </span>
                            </div>
                            @error('image_path')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Trạng Thái</label>
                            <select name="status" class="form-control">
                                <option value="1">Hiển thị</option>
                                <option value="0">Không hiển thị</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-6 col-12">
                        <div class="form-group">
                            <label>Tên Danh Mục</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid  @enderror" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <label>Đường Dẫn Thân Thiện</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid  @enderror" value="{{ old('slug') }}">
                        </div>
                        @error('slug')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <label>Mô Tả</label>
                            <textarea name="description" class="form-control @error('description') is-invalid  @enderror">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <div class="invalid-feedback" style="display: block;">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <label>Danh Mục Cha</label>
                            <select name="parent_id" class="form-control">
                                <option value="">Chọn danh mục cha</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
    
        function convertToSlug(text) {
            const from = "áàảãạâấầẩẫậăắằẳẵặéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵđ";
            const to = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd";
            text = text.toLowerCase();
            for (let i = 0; i < from.length; i++) {
                text = text.replace(new RegExp(from[i], "g"), to[i]);
            }
            return text.replace(/[^a-z0-9\s-]/g, '') 
                        .replace(/\s+/g, '-')     
                        .replace(/-+/g, '-');      
        }
        $('input[name="name"]').on('input', function() {
            const name = $(this).val();
            const slug = convertToSlug(name);
            $('input[name="slug"]').val(slug);
        });

  
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
