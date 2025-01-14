<!-- partials/variant-card.blade.php -->
<div class="card">
    <div class="card-header">
        <h4> Biến thể cho màu: {{ $color->name }}</h4>
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
                            data-color-id="{{ $color->id }}" data-color-name="{{ $color->name }}" class="btn btn-primary create-variants-size">
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
        <span class="colorinput-color" style="background-color: {{ $color->sku_color }};"></span>
    </div>
</div>
<style>
    .file-upload {
        border: 2px dashed #ccc;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
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
    }

    .remove-button {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: #ccc;
        color: black;
        border: none;
        width: 20px;
        height: 20px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-collapse {
        transition: all 0.3s ease;
    }

    .select2-container {
        width: 100% !important;
    }

    .form-control {
        width: 100%;
    }

    .nav-pills .nav-link {
        width: 100%;
    }
</style>
