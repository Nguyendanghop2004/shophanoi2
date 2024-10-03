@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Slider</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="form-group ">
                                <label>Image</label>
                                <div id="image-preview" class="image-preview mx-auto"
                                    @error('image_path') style="border:2px dashed red"  @enderror>
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="image_path" id="image-upload" />
                                </div>
                            </div>
                            @error('image_path')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror


                        </div>

                        <div class="col-lg-9 col-md-6 col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="is_active"
                                            class="form-control @error('is_active') is-invalid  @enderror">
                                            <option @selected($slider->is_active == true) value="1">Hiển thị</option>
                                            <option @selected($slider->is_active == false) value="0">Không hiển thị</option>
                                        </select>
                                        @error('is_active')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group ">
                                        <div class="d-flex justify-content-start"> <label>Danh Mục</label>
                                            <div class="text-danger ml-2">*</div>
                                        </div>
                                        <select class="form-control @error('category_id') is-invalid  @enderror"
                                            name="category_id">
                                            <option>Chọn Danh Mục</option>
                                            @foreach ($categories as $category)
                                                <option @selected($slider->category_id == $category->id) value="{{ $category->id }}">
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-start"> <label>Tiêu đề</label>
                                    <div class="text-danger ml-2">*</div>
                                </div>
                                <input type="text" name="title"
                                    class="form-control  @error('title') is-invalid  @enderror"
                                    value="{{ $slider->title }}">
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Mô tả ngắn</label>
                                <textarea name="short_description" class="form-control @error('short_description') is-invalid  @enderror">{{ $slider->short_description }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Đường dẫn thanh trượt</label>
                                <input type="text" class="form-control  @error('link_url') is-invalid  @enderror"
                                    value="{{ $slider->link_url }}" name="link_url">
                                @error('link_url')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>

    </section>
@endsection
@push('scripts')
    <script>
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url("{{ asset('storage/' . $slider->image_path) }}")',
                'background-size': 'cover',
                'background-position': 'center center'
            });
        });
    </script>
@endpush
