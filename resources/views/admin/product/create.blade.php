@extends('admin.layouts.master')

@section('content')
    <section class="section">

        <div class="section-header">
            <h1>Tạo Mới Sản Phẩm</h1>
        </div>

        <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-9 col-md-6 col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Thêm Mới Sản Phẩm</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-6 col-md-8 col-12">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-start"> <label>Tên Sản Phẩm</label>
                                            <div class="text-danger ml-2">*</div>
                                        </div>
                                        <input type="text" name="product_name"
                                            class="form-control @error('product_name') is-invalid  @enderror"
                                            value="{{ old('product_name') }}">
                                        @error('product_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-start"> <label>Giá</label>
                                            <div class="text-danger ml-2">*</div>
                                        </div>
                                        <input type="text" name="price"
                                            class="form-control @error('price') is-invalid  @enderror"
                                            value="{{ old('price') }}">
                                        @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select name="status" class="form-control  @error('status') is-invalid  @enderror">
                                            <option selected value="1">Hiển Thị</option>
                                            <option value="0">Không Hiển Thị</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-start"><label>Đường Dẫn Thân Thiện</label>
                                            <div class="text-danger ml-2">*</div>
                                        </div>
                                        <input type="text" name="slug"
                                            class="form-control  @error('slug') is-invalid  @enderror"
                                            value="{{ old('slug') }}">
                                        @error('slug')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-start"> <label>Mã Sản Phẩm</label>
                                                <div class="text-danger ml-2">*</div>
                                            </div>
                                            <input type="text" name="product_code"
                                                class="form-control  @error('product_code') is-invalid  @enderror"
                                                value="{{ old('product_code') }}">
                                            @error('product_code')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-start"> <label>Thương Hiệu</label>
                                            <div class="text-danger ml-2">*</div>
                                        </div>
                                        <select name="brand_id" id="brandSelect"
                                            class="form-control  @error('brand_id') is-invalid  @enderror">
                                            <option selected value="">Chọn Thương Hiệu</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    data-image-url="{{ asset('storage/' . $brand->image_brand_url) }}">
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group d-flex align-items-center">
                                        <img id="brandImage"
                                            src="https://th.bing.com/th/id/OIP.8IYoJILsODWH2R7lXN8IcwHaEK?rs=1&pid=ImgDetMain"
                                            alt="" style="height: 80px;">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label>Mô Tả</label>
                                @error('description')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <textarea name="description" class="form-control summernote  @error('brand_id') is-invalid  @enderror"
                                    style="width: 50%; height: 100px;" cols="30" rows="5"> {{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-start"> <label>Chọn biến thể màu sắc sản
                                                phẩm</label>
                                            <div class="text-danger ml-2">*</div>
                                        </div>
                                        <select id="colorSelect" class="form-control select2 " multiple>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('variants')
                                            <div class="invalid-feedback" style="display: block;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="row gutters-xs">
                                            @foreach ($colors as $color)
                                                <div class="col-auto">
                                                    <label class="colorinput">
                                                        <input type="checkbox" class="colorinput-input"
                                                            value="{{ $color->id }}">
                                                        <span class="colorinput-color"
                                                            style="background-color: {{ $color->sku_color }};"></span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <button id="createVariants" type="button" class="btn btn-primary">Tạo biến thể
                                    màu</button>
                            </div>

                        </div>
                    </div>

                    <div id="variantCardsContainer"></div>

                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary">Quay trở lại</button>
                        </div>
                        <div class="card-body">
                            <div class="section-title mt-0 d-flex justify-content-start">Danh mục<div
                                    class="text-danger ml-2">*</div>
                            </div>
                            @error('categories')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                            @foreach ($categories as $category)
                                <div class="custom-control custom-checkbox">
                                    {{-- Hiển thị checkbox cho danh mục cha --}}
                                    <input type="checkbox" class="custom-control-input"
                                        id="customCheck{{ $category->id }}" name="categories[]"
                                        value="{{ $category->id }}">
                                    <label class="custom-control-label"
                                        for="customCheck{{ $category->id }}">{{ $category->name }}</label>

                                    {{-- Kiểm tra nếu danh mục có con --}}
                                    @if ($category->children && $category->children->count())
                                        {{-- Gọi hàm đệ quy để hiển thị các danh mục con --}}
                                        @include('admin.product.child-category', [
                                            'categories' => $category->children,
                                        ])
                                    @endif
                                </div>
                            @endforeach

                        </div>
                        <div class="card-body">
                            <div class="section-title mt1">Bộ sưu tập</div>
                            <div class="form-group">
                                <select name="tagCollection[]" class="form-control select2" multiple="">
                                    @foreach ($tagCollection as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="section-title mt-0">Chất liệu</div>
                            <div class="form-group">
                                <select name="tagMaterial[]" class="form-control select2" multiple="">
                                    @foreach ($tagMaterial as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Tạo mới sản phẩm ở đây ">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const oldDescription = "{{ old('description') }}"; // Lấy dữ liệu cũ từ Laravel

            $('.summernote').summernote({
                height: 300, // Chiều cao của editor
                tabsize: 2,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Đặt nội dung cũ vào Summernote
            if (oldDescription) {
                $('.summernote').summernote(oldDescription);
            }

            // Cập nhật giá trị của textarea ẩn trước khi gửi form
            $('form').on('submit', function() {
                const summernoteContent = $('.summernote').summernote('code');
                $(this).find('textarea[name="description"]').val(summernoteContent);
            });
        });
    </script>

    <script>
        // Hàm async để tải động các thẻ biến thể qua AJAX
        async function loadVariantCard(colorId) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `{{ url('/admin/product/get-variant-card') }}/${colorId}`,
                    method: 'GET',
                    success: function(response) {
                        resolve(response); // Trả về mã HTML của thẻ biến thể
                    },
                    error: function(xhr, status, error) {
                        console.error(`Có lỗi xảy ra khi tải thẻ biến thể cho ID màu: ${colorId}`);
                        reject(error);
                    }
                });
            });
        }

        // Xử lý khi nhấn nút "Tạo biến thể màu"
        document.getElementById('createVariants').addEventListener('click', async function() {
            var selectedColorIds = $('#colorSelect').val();
            var container = document.getElementById('variantCardsContainer');

            container.innerHTML = ''; // Xóa các thẻ biến thể hiện tại

            if (selectedColorIds.length === 0) {
                alert('Vui lòng chọn ít nhất một màu để tạo biến thể!');
                return;
            }

            for (let colorId of selectedColorIds) {
                try {
                    const cardHtml = await loadVariantCard(colorId);
                    container.insertAdjacentHTML('beforeend', cardHtml);
                    initCollapsable();
                    initDropzone(colorId); // Khởi tạo Dropzone với `colorId` riêng biệt
                    // Khởi tạo Select2 cho các phần tử trong thẻ biến thể mới
                    $('#variantCardsContainer .select2').select2();
                    initSizeChoose();
                } catch (error) {
                    console.error(error);
                }
            }
        });

        function initSizeChoose() {
            // Xóa sự kiện cũ trước khi gán lại
            $(document).off('click', '.create-variants-size').on('click', '.create-variants-size', function(e) {
                e.preventDefault();

                const colorId = $(this).data('color-id');
                const selectedSizes = $(`#sizeSelect-${colorId}`).val();
                const container = $(`#sizeVariantsContainer-${colorId}`);

                container.empty(); // Xóa các biến thể kích thước cũ

                if (selectedSizes.length === 0) {
                    alert('Vui lòng chọn ít nhất một kích thước của ' + colorId + ' để tạo biến thể!');
                    return;
                }

                // Bọc tất cả các nút radio trong một div `.selectgroup`
                let sizeVariantHtml = `<div class="selectgroup w-100 d-flex">`;

                selectedSizes.forEach(sizeId => {
                    const sizeText = $(`#sizeSelect-${colorId} option[value="${sizeId}"]`).text();

                    // Thêm mỗi nút radio vào nhóm
                    sizeVariantHtml += `
                <label class="selectgroup-item">
                    <input type="radio" name="size_variant_${colorId}" value="${sizeId}" class="selectgroup-input" data-size-id="${sizeId}">
                    <span class="selectgroup-button">${sizeText}</span>
                </label>
            `;
                });
 
                sizeVariantHtml += `</div>`;

                // Thêm các trường quantity collapsible cho mỗi kích thước và ẩn mặc định
                selectedSizes.forEach(sizeId => {
                    sizeVariantHtml += `
    <div id="quantityCollapse-${colorId}-${sizeId}" class="quantity-collapse mt-2" style="display: none;">
        <div class="form-group">
            <input type="hidden" name="variants[${colorId}][color_id]" value="${colorId}">
            <input type="hidden" name="variants[${colorId}][sizes][${sizeId}][size_id]" value="${sizeId}">
            <div class="d-flex justify-content-start">
                <label for="quantity-${colorId}-${sizeId}">Số lượng ${sizeId}</label>
                <div class="text-danger ml-2">*</div>
            </div>
            <input type="number" name="variants[${colorId}][sizes][${sizeId}][stock_quantity]" class="form-control" id="quantity-${colorId}-${sizeId}" min="0" placeholder="Nhập số lượng">
        </div>
        <div class="form-group">
            <div class="d-flex justify-content-start">
                <label for="price-${colorId}-${sizeId}">Giá ${sizeId}</label>
                <div class="text-danger ml-2">*</div>
            </div>
            <input type="number" name="variants[${colorId}][sizes][${sizeId}][price]" class="form-control" id="price-${colorId}-${sizeId}" min="0" placeholder="Nhập giá">
        </div>
    </div>`;

                });

                container.append(sizeVariantHtml);

                $(`input[name="size_variant_${colorId}"]`).prop('checked', false);

                // Xóa sự kiện cũ trước khi gán lại để tránh nhiều lần gọi alert
                $(`input[name="size_variant_${colorId}"]`).off('change').on('change', function() {
                    const sizeId = $(this).val();
                    $(`#sizeVariantsContainer-${colorId} .quantity-collapse`).hide();
                    $(`#quantityCollapse-${colorId}-${sizeId}`).show();
                });
            });
        }

        // Khởi tạo tính năng collapse
        function initCollapsable() {
            $("[data-collapse]").each(function() {
                var me = $(this),
                    target = me.data('collapse');

                me.off('click').on('click', function() {
                    $(target).collapse('toggle');
                    $(target).on('shown.bs.collapse', function() {
                        me.html('<i class="fas fa-minus"></i>');
                    });
                    $(target).on('hidden.bs.collapse', function() {
                        me.html('<i class="fas fa-plus"></i>');
                    });
                    return false;
                });
            });
        }

        function initDropzone(colorId) {
            const fileUpload = document.querySelector(`.file-upload[data-color-id="${colorId}"]`);
            const imageUpload = document.getElementById(`imageUpload-${colorId}`);
            const imagePreviewContainer = document.querySelector(`.image-preview-container[data-color-id="${colorId}"]`);

            // Mảng để lưu trữ các tệp đã chọn
            let selectedFiles = [];

            fileUpload.addEventListener('click', () => {
                imageUpload.click(); // Kích hoạt input file khi click vào vùng upload
            });

            imageUpload.addEventListener('change', (event) => {
                const files = Array.from(event.target.files);

                // Cập nhật mảng selectedFiles với các tệp mới
                selectedFiles = selectedFiles.concat(files); // Thêm tệp mới vào mảng

                // Xóa tất cả các ảnh đã có trong preview trước khi thêm ảnh mới
                imagePreviewContainer.innerHTML = '';

                // Hiển thị tất cả các ảnh đã chọn
                selectedFiles.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const imgContainer = document.createElement('div');
                        imgContainer.classList.add('image-preview');

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-100', 'h-100');
                        imgContainer.appendChild(img);

                        const removeButton = document.createElement('button');
                        removeButton.classList.add('remove-button');
                        removeButton.textContent = 'X';
                        removeButton.addEventListener('click', () => {
                            imagePreviewContainer.removeChild(imgContainer);
                            // Cập nhật selectedFiles để loại bỏ ảnh đã xóa
                            selectedFiles = selectedFiles.filter(selectedFile => selectedFile
                                .name !== file.name);

                            // Cập nhật lại giá trị của input file
                            const dataTransfer = new DataTransfer();
                            selectedFiles.forEach(selectedFile => {
                                dataTransfer.items.add(
                                    selectedFile
                                ); // Thêm lại các tệp còn lại vào DataTransfer
                            });
                            imageUpload.files = dataTransfer.files; // Cập nhật lại input file
                        });
                        imgContainer.appendChild(removeButton);
                        imagePreviewContainer.appendChild(imgContainer);
                    };
                    reader.readAsDataURL(file);
                });
            });
        }




        // Đảm bảo khởi tạo lại các thành phần khi trang được tải
        $(document).ready(function() {
            $('.select2').select2(); // Khởi tạo lại Select2 khi trang được tải
        });
    </script>


    <script>
        // Khi có sự thay đổi trong thẻ select (select2)
        $('#colorSelect').on('change', function() {
            // Lấy danh sách tất cả các lựa chọn đã được chọn (dựa trên ID)
            var selectedColorIds = $(this).val(); // Sử dụng select2 để lấy danh sách ID

            // Lấy tất cả các checkbox
            var checkboxes = document.querySelectorAll('.colorinput-input');

            // Lặp qua từng checkbox và đồng bộ hóa với lựa chọn trong select
            checkboxes.forEach(function(checkbox) {
                if (selectedColorIds.includes(checkbox.value)) {
                    checkbox.checked = true; // Chọn checkbox nếu ID màu đã được chọn
                } else {
                    checkbox.checked = false; // Bỏ chọn nếu không có trong select
                }
            });
        });

        // Khi có sự thay đổi trong các checkbox
        document.querySelectorAll('.colorinput-input').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var colorSelect = $('#colorSelect'); // Sử dụng jQuery để tương tác với select2
                var selectedOptions = colorSelect.val() || []; // Lấy danh sách các ID đã chọn

                if (checkbox.checked) {
                    // Thêm ID của checkbox vào select nếu được chọn
                    if (!selectedOptions.includes(checkbox.value)) {
                        selectedOptions.push(checkbox.value);
                    }
                } else {
                    // Loại bỏ ID của checkbox khỏi select nếu bỏ chọn
                    selectedOptions = selectedOptions.filter(function(value) {
                        return value !== checkbox.value;
                    });
                }

                // Cập nhật lại giá trị cho select2
                colorSelect.val(selectedOptions).trigger('change');
            });
        });
    </script>


    <script>
        document.getElementById('brandSelect').addEventListener('change', function() {
            // Lấy option đang được chọn
            var selectedOption = this.options[this.selectedIndex];

            // Lấy URL của hình ảnh từ thuộc tính data-image-url
            var imageUrl = selectedOption.getAttribute('data-image-url');

            // Cập nhật src cho thẻ img
            document.getElementById('brandImage').src = imageUrl;
        });
    </script>

    <script>
        $(document).ready(function() {
            // Khi người dùng thay đổi lựa chọn radio button
            $('input[name="tabOption"]').on('change', function() {
                var selectedTab = $(this).val(); // Lấy giá trị được chọn (home, profile, contact)

                // Ẩn tất cả các tab với hiệu ứng fade
                $('.tab-pane').removeClass('show active');

                // Hiển thị tab được chọn với hiệu ứng mờ dần
                $('#' + selectedTab).addClass('show active fade');
            });
        });
    </script>
    <!-- CSS tùy chỉnh -->
    <style>
        .select2-container {
            width: 100% !important;

        }

        .nav-pills .nav-item {
            flex: 1;
            margin: 0;
            /* Loại bỏ khoảng cách giữa các tab */
        }

        .nav-pills .nav-link {
            padding: 10px;
            width: 100%;
            margin: 0;
            /* Không thêm khoảng cách giữa các tab */
            border-radius: 0;
            /* Giữ bo góc đều */
            text-align: center;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            color: #000;
            transition: background-color 0.3s ease, color 0.3s ease;
            box-sizing: border-box;
            /* Đảm bảo border không làm tăng kích thước của tab */
        }

        /* Khi tab được chọn */
        .nav-pills .nav-link.active {
            background-color: #5a73ff;
            /* Màu nền xanh cho tab được chọn */
            color: white;
            /* Chữ màu trắng cho tab được chọn */

        }

        /* Hiệu ứng hover */
        .nav-pills .nav-link:hover {
            background-color: #e0e0e0;
            /* Màu nền khi hover */
        }

        /* Đồng đều chiều rộng giữa các tab */
        .nav-pills .nav-item .nav-link {
            flex-grow: 1;
        }
    </style>
    <script>
        // Hàm chuyển đổi tên sản phẩm thành slug
        function generateSlug(str) {
            str = str.trim().toLowerCase(); // Chuyển về chữ thường và bỏ khoảng trắng thừa
            str = str.normalize('NFD').replace(/[\u0300-\u036f]/g, ""); // Loại bỏ dấu tiếng Việt
            str = str.replace(/[^a-z0-9\s-]/g, '') // Loại bỏ ký tự đặc biệt
                .replace(/\s+/g, '-') // Thay khoảng trắng bằng dấu gạch ngang
                .replace(/-+/g, '-'); // Loại bỏ gạch ngang thừa
            return str;
        }

        // Sử dụng jQuery để lắng nghe sự kiện 'input' trên ô nhập tên sản phẩm
        $(document).ready(function() {
            $('input[name="product_name"]').on('input', function() {
                var productName = $(this).val(); // Lấy giá trị từ ô Tên Sản Phẩm
                var slug = generateSlug(productName); // Gọi hàm tạo slug
                $('input[name="slug"]').val(slug); // Gán slug vào ô Đường Dẫn Thân Thiện
            });
        });
    </script>
@endpush
