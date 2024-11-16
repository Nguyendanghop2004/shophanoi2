<!-- partials/variant-card.blade.php -->
<div class="card">
    <div class="card-header">
        <h4>Biến thể cho màu: {{ $color->name }}</h4>
        <div class="card-header-action">
            <a data-collapse="#mycard-collapse-{{ $color->id }}" class="btn btn-icon btn-info" href="#"><i
                    class="fas fa-minus"></i></a>
        </div>
    </div>
    <div class="collapse hide" id="mycard-collapse-{{ $color->id }}">
        <div class="card-body">
            <div class="form-group">
                <div class="file-upload rounded p-4 text-center" data-color-id="{{ $color->id }}">
                    <input type="file" id="imageUpload-{{ $color->id }}" name="images[{{ $color->id }}][]"
                        multiple accept="image/*">
                    <div class="file-upload-label font-weight-bold">
                        Kéo và thả tập tin vào đây hoặc nhấn để chọn nhiều Ảnh
                        <div class="text-danger ml-2">*</div>

                    </div>
                </div>
                <div class="image-preview-container mt-3 d-flex flex-wrap" data-color-id="{{ $color->id }}">
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-start"> <label>Chọn biến thể kích thước sản phẩm</label>
                    <div class="text-danger ml-2">*</div>
                </div>
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-12">
                        <select id="sizeSelect-{{ $color->id }}" class="form-control select2" multiple>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12">
                        <button type="button" id="createVariantsSize-{{ $color->id }}"
                            data-color-id="{{ $color->id }}" class="btn btn-primary create-variants-size">
                            Tạo biến thể kích thước
                        </button>
                    </div>
                </div>

            </div>

            <div id="sizeVariantsContainer-{{ $color->id }}" class="mt-3">
                <!-- Các nút chọn kích thước sẽ được thêm vào đây -->
            </div>

        </div>
    </div>
    <div class="card-footer">
        Thẻ biến thể cho màu {{ $color->name }}
    </div>
</div>
<style>
    .file-upload {
        border: 2px dashed #ccc;
        /* Viền nét đứt */
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        /* Hiển thị con trỏ dạng bàn tay khi di chuột qua */
    }

    .file-upload input[type="file"] {
        display: none;
    }

    .image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-right: 10px;
        margin-bottom: 10px;
        position: relative;
        /* Để định vị nút "Xóa" */
    }

    .remove-button {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: #ccc;
        /* Nền xám */
        color: black;
        border: none;
        width: 20px;
        height: 20px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        /* Căn giữa nội dung nút */
        align-items: center;
        justify-content: center;
    }

    .quantity-collapse {
        transition: all 0.3s ease;
    }

    .select2-container {
        width: 100% !important;
        /* Đảm bảo Select2 chiếm toàn bộ chiều rộng */
    }

    .form-control {
        width: 100%;
        /* Đảm bảo các trường input chiếm đủ chiều rộng của thẻ form */
    }

    .nav-pills .nav-link {
        width: 100%;
        /* Đảm bảo các link trong nav-pills chiếm toàn bộ chiều rộng */
    }
</style>
