@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Chỉnh Sửa Sản Phẩm {{ $product->product_name }} </h1>
        </div>

        <div class="card card-warning">
            <div class="card-header">
                <ul class="nav nav-pills justify-content-between" id="myTab3" role="tablist" style="width: 100%;">
                    <li class="nav-item flex-fill text-center">
                        <a class="nav-link {{ session('active_tab', 'mainproduct') === 'mainproduct' ? 'active' : '' }}"
                            id="mainproduct-tab3" data-toggle="tab" href="#mainproduct3" role="tab"
                            aria-controls="mainproduct" aria-selected="true"><strong> Sửa thông tin sản phẩm
                                chính</strong></a>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <a class="nav-link {{ session('active_tab') === 'variantproduct' ? 'active' : '' }}"
                            id="variant-tab3" data-toggle="tab" href="#variantproduct3" role="tab"
                            aria-controls="variant" aria-selected="false">
                            <strong>Sửa biến thể</strong></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content" id="myTabContent2">

            {{-- tab san pham --}}

            <div class="tab-pane fade {{ session('active_tab', 'mainproduct') === 'mainproduct' ? 'show active' : '' }}"
                id="mainproduct3" role="tabpanel" aria-labelledby="home-tab3">
                <form action="{{ route('admin.product.updateMainProduct', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="card card-primary">
                                <div class="card-header d-flex justify-content-between">
                                    <input type="submit" class="btn btn-success" value="Sửa sản phẩm chính">
                                    <a href="javascript:history.back()" class="btn btn-secondary">Quay lại</a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="section-title">Bộ sưu tập</div>
                                    <div class="form-group">
                                        <select name="tagCollection[]" class="form-control select2" multiple="">
                                            @foreach ($tagCollection as $tag)
                                                <option @selected($tagsCollectionEdit->contains('id', $tag->id)) value="{{ $tag->id }}">
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="section-title mt-0">Chất liệu</div>
                                    <div class="form-group">
                                        <select name="tagMaterial[]" class="form-control select2" multiple="">
                                            @foreach ($tagMaterial as $tag)
                                                <option @selected($tagsMaterialEdit->contains('id', $tag->id)) value="{{ $tag->id }}">
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="section-title mt-0 d-flex justify-content-start">Danh mục<div
                                            class="text-danger ml-2">*
                                        </div>
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
                                                value="{{ $category->id }}"
                                                @if ($product->categories->contains('id', $category->id)) checked @endif>
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
                            </div>


                        </div>
                        <div class="col-lg-9 col-md-6 col-12">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h4>Thông tin chung sản phẩm chính </h4>
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
                                                    value="{{ $product->product_name }}">
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
                                                    value="{{ $product->price }}">
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
                                                <select name="status"
                                                    class="form-control  @error('status') is-invalid  @enderror">
                                                    <option @selected($product->status == true) value="1">Hiển Thị</option>
                                                    <option @selected($product->status == false) value="0">Không Hiển Thị
                                                    </option>
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
                                                <div class="d-flex justify-content-start"><label>Đường Dẫn Thân
                                                        Thiện</label>
                                                    <div class="text-danger ml-2">*</div>
                                                </div>
                                                <input type="text" name="slug"
                                                    class="form-control  @error('slug') is-invalid  @enderror"
                                                    value="{{ $product->slug }}">
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
                                                        value="{{ $product->sku }}">
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
                                                    @foreach ($brands as $brand)
                                                        <option @selected($brand->id == $product->brand_id) value="{{ $brand->id }}"
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
                                            style="width: 50%; height: 100px;" cols="30" rows="5"> {{ $product->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>

            {{-- tab bien the --}}

            <div class="tab-pane fade {{ session('active_tab') === 'variantproduct' ? 'show active' : '' }}"
                id="variantproduct3" role="tabpanel" aria-labelledby="profile-tab3">

                <p> <button class="btn btn-primary" id="openModal">Tạo biến thể mới</button> </p>

                @foreach ($product->colors as $color)
                    <div class="card card-info">
                        <div class="card-header">
                            <h4>Biến thể màu {{ $color->name }}</h4>
                        </div>

                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group d-flex">
                                    <button class="btn btn-primary open-variant-image-modal"
                                        data-color-id="{{ $color->id }}">Chỉnh sửa ảnh</button>
                                    <button class="btn btn-primary open-variant-modal ml-2"
                                        data-color-id="{{ $color->id }}">Tạo biến thể của màu
                                        {{ $color->name }}</button>
                                    <form action="{{ route('admin.product-variants.destroyByColor') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="color_id" value="{{ $color->id }}">

                                        <button type="submit" class="btn btn-danger ml-2">
                                            <i class="fas fa-trash" style="color: #ffffff;"></i>
                                        </button>
                                    </form>

                                </div>
                                <div class="gallery gallery-md">
                                    @if (isset($imagesGroupedByColor[$color->id]))
                                        @foreach ($imagesGroupedByColor[$color->id] as $image)
                                            <div style=" width:200px;" class="gallery-item"
                                                data-image="{{ asset('storage/' . $image->image_url) }}"
                                                data-title="Image 1" href="{{ asset('storage/' . $image->image_url) }}"
                                                title="Image 1"
                                                style="background-image: url(&quot;{{ asset('storage/' . $image->image_url) }}&quot;);">
                                            </div>
                                        @endforeach
                                    @else
                                        <p>Không có ảnh cho màu này.</p>
                                    @endif
                                </div>
                                <div class="table-responsive">
                                    <form action="{{ route('admin.product.updateVariantProduct', $color->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Mã biến thể</th>
                                                    <th scope="col">Tên sản phẩm</th>
                                                    <th scope="col">Biến thể màu</th>
                                                    <th scope="col">Biến thể size</th>
                                                    <th scope="col">Số lượng tồn kho</th>
                                                    <th scope="col">Giá cộng thêm</th>
                                                    <th scope="col">Trạng Thái</th>
                                                    <th scope="col">Hành động</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($variantsGroupedByColor[$color->id] as $variant)
                                                    <tr>
                                                        <td>{{ $variant->product_code }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td> <span class="colorinput-color m-1 "
                                                                style="background-color: {{ $color->sku_color }};"></span>
                                                        </td>
                                                        <td>{{ $variant->size->name ?? 'Không có kích thước' }}</td>
                                                        <td> <input class="form-control"
                                                                name="variant['stock_update'][{{ $variant->id }}]"
                                                                type="number" value="{{ $variant->stock_quantity }}">
                                                        </td>
                                                        <td><input class="form-control"
                                                                name="variant['price_update'][{{ $variant->id }}]"
                                                                type="number" value="{{ $variant->price }}"></td>
                                                        <td>
                                                            @if ($variant->status)
                                                                <span class="badge badge-success">Hoạt động</span>
                                                            @else
                                                                <span class="badge badge-warning">Không hoạt động</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger ml-2"
                                                                onclick="deleteVariant({{ $variant->id }})">
                                                                <i class="fas fa-trash" style="color: #ffffff;"></i>
                                                            </button>

                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        @if (session('colorIdUpdateVariantProduct') == $color->id)
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        @endif
                                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>


    </section>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tạo biến thể mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @php
                    $productColorIds = $product->colors->pluck('id')->toArray();

                    $colorVariantCount = count($productColorIds);

                    $availableColors =
                        $colorVariantCount < 5
                            ? $colors->filter(fn($color) => !in_array($color->id, $productColorIds))
                            : collect();
                @endphp

                <form action="{{ route('admin.product.createVariantProduct') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_code" value="{{ $product->sku }}">

                    <div class="modal-body">
                        @if ($colorVariantCount >= 5)
                            <div class="alert alert-warning">
                                Sản phẩm này đã có tối đa 5 biến thể màu. Bạn không thể tạo thêm biến thể màu mới.
                            </div>
                        @else
                            <div class="form-group">
                                <label for="color">Chọn Màu</label>
                                <select class="form-control" id="color" name="colorVatiant">
                                    @foreach ($availableColors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                                @error('colorVatiant')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                @error('imagesVatiant')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="file-upload rounded p-4 text-center">
                                    <input type="file" id="imageUpload" name="imagesVatiant[]" multiple
                                        accept="image/*">
                                    <div class="file-upload-label font-weight-bold">
                                        Kéo và thả tập tin vào đây hoặc nhấn để chọn nhiều Ảnh
                                        <div class="text-danger ml-2">*</div>
                                    </div>
                                </div>
                                <div class="image-preview-container mt-3 d-flex flex-wrap">
                                    <!-- Các ảnh được chọn sẽ hiển thị ở đây -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="size">Chọn Kích thước</label>
                                <div class="row">
                                    <div class="col-lg-8 col-md-6 col-12">
                                        <select id="sizeSelect" name="sizes[]" class="form-control select2"
                                            multiple="">
                                            @foreach ($sizes as $size)
                                                <option data-name="{{ $size->name }}" value="{{ $size->id }}">
                                                    {{ $size->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <button class="btn btn-primary" id="createSizeBtn" type="button">Tạo Kích
                                            thước</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="ff">
                                <div class="selectgroup w-100" id="sizeRadios">
                                    <!-- Các radio button sẽ được tạo ra ở đây -->
                                </div>
                            </div>

                            <div id="sizeDetailsContainer">
                                <!-- Các cụm nhập liệu giá và số lượng sẽ được hiển thị ở đây -->
                            </div>

                            @if (session('show_modal') === 'variantproductcolor')
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        @endif

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        @if ($colorVariantCount >= 5)
                        @else
                            <button type="submit" class="btn btn-success" id="saveBtn">Lưu</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($product->colors as $color)
        <!-- Modal variant color-->
        <div class="modal fade" id="exampleModalvariantcolor{{ $color->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tạo biến thể mới cuả màu {{ $color->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.product.createVariantColorProduct') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_code" value="{{ $product->sku }}">
                        <input type="hidden" name="color_id" value="{{ $color->id }}">

                        @php
                            $currentSizeCount = count($variantsGroupedByColor[$color->id]);
                        @endphp

                        <div class="modal-body">
                            @if ($currentSizeCount >= 5)
                                <div class="alert alert-warning">
                                    Màu {{ $color->name }} đã đạt tối đa 5 kích thước. Không thể thêm kích thước mới.
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="color">Chọn Màu</label>
                                    <select class="form-control" id="color" name="colorVatiant" disabled>
                                        @foreach ($product->colors as $colorrr)
                                            <option @selected($color->id == $colorrr->id) value="{{ $colorrr->id }}">
                                                {{ $colorrr->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('colorVatiant')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="size">Chọn Kích thước</label>


                                    <select name="sizes" class="form-control">
                                        @foreach ($sizes as $size)
                                            @php
                                                // Kiểm tra xem size này đã có trong variants của color hiện tại chưa
                                                $sizeExists = false;
                                                foreach ($variantsGroupedByColor[$color->id] as $variant) {
                                                    if ($variant->size->id === $size->id) {
                                                        $sizeExists = true;
                                                        break;
                                                    }
                                                }
                                            @endphp

                                            @if (!$sizeExists)
                                                <option data-name="{{ $size->name }}" value="{{ $size->id }}">
                                                    {{ $size->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-start"> <label>Giá cộng thêm của kích thước</label>
                                        <div class="text-danger ml-2">*</div>
                                    </div>
                                    <input type="text" name="pricevariantcolor" class="form-control">
                                    @error('pricevariantcolor')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-start"> <label>Số lượng biến thể</label>
                                        <div class="text-danger ml-2">*</div>
                                    </div>
                                    <input type="text" name="quantityvariantcolor" class="form-control">
                                    @error('quantityvariantcolor')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                @if (session('show_modal') === 'createVariantColorProduct')
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            @if ($currentSizeCount >= 5)
                            @else
                                <button type="submit" class="btn btn-primary" id="saveBtn">Lưu</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal variant image color-->
        <div class="modal fade" id="exampleModalvariantImagecolor{{ $color->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tạo biến thể mới cuả màu {{ $color->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.product.createVariantImageColorProduct') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_code" value="{{ $product->sku }}">
                        <input type="hidden" name="color_id" value="{{ $color->id }}">

                        <div class="modal-body">

                            <div class="form-group">
                                <label for="color">Chọn Màu</label>
                                <select class="form-control" id="color" name="colorVatiant" disabled>
                                    @foreach ($product->colors as $colorrr)
                                        <option @selected($color->id == $colorrr->id) value="{{ $colorrr->id }}">
                                            {{ $colorrr->name }}</option>
                                    @endforeach
                                </select>
                                @error('colorVatiant')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="color">Thêm ảnh mới</label>
                                @error('imagesVatiant')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div
                                    class="file-upload-image-detail-color-{{ $color->id }} file-upload-image-color rounded p-4 text-center">
                                    <input type="file" id="imageUpload-image-detail-color-{{ $color->id }}"
                                        name="image_detail_color_{{ $color->id }}[]" multiple accept="image/*">
                                    <div class="file-upload-label font-weight-bold">
                                        Kéo và thả tập tin vào đây hoặc nhấn để chọn nhiều Ảnh
                                        <div class="text-danger ml-2">*</div>
                                    </div>
                                </div>
                                <div
                                    class="image-preview-container-image-detail-color-{{ $color->id }} image-preview-container-image-detail-color mt-3 d-flex flex-wrap">
                                    <!-- Các ảnh được chọn sẽ hiển thị ở đây -->
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="color">Chọn ảnh cũ cần xóa</label>
                                <div class="image-preview-container-image-detail-color mt-3 d-flex flex-wrap">
                                    @if (isset($imagesGroupedByColor[$color->id]))
                                        @foreach ($imagesGroupedByColor[$color->id] as $image)
                                            <div class="image-preview-color">
                                                <!-- Ảnh -->
                                                <img class="w-100 h-100"
                                                    src="{{ asset('storage/' . $image->image_url) }}" alt="">

                                                <!-- Checkbox ở góc trên bên phải -->
                                                <input type="checkbox" name="delete_images[]"
                                                    value="{{ $image->id }}" class="checkbox-top-right">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>


                            </div>
                            @if (session('show_modal') === 'createVariantImageColorProduct')
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-success" id="saveBtn">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/chocolat/dist/css/chocolat.css') }}">
    <script src="{{ asset('admin/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script>
        function deleteVariant(variantId) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa?',
                text: "Thao tác này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/product-variants/${variantId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Đã xóa!', data.message || 'Xóa thành công!', 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Lỗi!', data.message || 'Có lỗi xảy ra. Vui lòng thử lại!', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Lỗi!', 'Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại!',
                                'error');
                            console.error('Error:', error);
                        });
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizeSelect = document.getElementById('sizeSelect');
            const sizeRadioGroup = document.getElementById('sizeRadios');

            // Kiểm tra nếu không có lựa chọn nào được chọn
            const selectedSizes = Array.from(sizeSelect.selectedOptions).map(option => option.getAttribute(
                'data-name'));
            if (selectedSizes.length === 0) {
                sizeRadioGroup.innerHTML = '<p class="text-warning">Vui lòng chọn ít nhất một kích thước.</p>';
            }

            // Xử lý sự kiện khi người dùng nhấn nút "Tạo kích thước"
            document.getElementById('createSizeBtn').addEventListener('click', function() {
                const selectedSizes = Array.from(sizeSelect.selectedOptions).map(option => option
                    .getAttribute('data-name'));

                // Xóa tất cả radio button cũ nếu có
                sizeRadioGroup.innerHTML = '';

                // Kiểm tra nếu không có lựa chọn nào được chọn
                if (selectedSizes.length === 0) {
                    sizeRadioGroup.innerHTML =
                        '<p class="text-danger">Vui lòng chọn ít nhất một kích thước.</p>';
                    return;
                }

                // Duyệt qua từng lựa chọn đã chọn và tạo radio button
                selectedSizes.forEach(size => {
                    const radioLabel = document.createElement('label');
                    radioLabel.classList.add('selectgroup-item');

                    const radioInput = document.createElement('input');
                    radioInput.type = 'radio';
                    radioInput.name = 'size';
                    radioInput.value = size;
                    radioInput.classList.add('selectgroup-input');

                    const radioSpan = document.createElement('span');
                    radioSpan.classList.add('selectgroup-button');
                    radioSpan.textContent = size;

                    // Append radio input and label
                    radioLabel.appendChild(radioInput);
                    radioLabel.appendChild(radioSpan);

                    sizeRadioGroup.appendChild(radioLabel);
                });

                // Sau khi tạo các radio button, hiển thị các cụm nhập liệu (giá và số lượng)
                const sizeDetailsContainer = document.getElementById('sizeDetailsContainer');
                sizeDetailsContainer.innerHTML = ''; // Xóa các cụm nhập liệu cũ

                selectedSizes.forEach(size => {
                    const sizeDetailsDiv = document.createElement('div');
                    sizeDetailsDiv.classList.add('size-details');
                    sizeDetailsDiv.setAttribute('data-size', size);
                    sizeDetailsDiv.classList.add('collapse'); // Collapse mặc định

                    const priceGroup = document.createElement('div');
                    priceGroup.classList.add('form-group');
                    const priceLabel = document.createElement('label');
                    priceLabel.setAttribute('for', `price-${size}`);
                    priceLabel.textContent = `Giá cộng thêm của kích thước (${size})`;
                    const priceInput = document.createElement('input');
                    priceInput.type = 'number';
                    priceInput.classList.add('form-control');
                    priceInput.id = `price-${size}`;
                    priceInput.name = `price[${size}]`;
                    priceInput.placeholder = `Nhập giá cộng thêm của biến thể kích thước (${size})`;
                    priceGroup.appendChild(priceLabel);
                    priceGroup.appendChild(priceInput);

                    const stockGroup = document.createElement('div');
                    stockGroup.classList.add('form-group');
                    const stockLabel = document.createElement('label');
                    stockLabel.setAttribute('for', `stock-${size} `);
                    stockLabel.textContent = `Số lượng trong kho (${size})`;
                    const stockAsterisk = document.createElement('span');
                    stockAsterisk.classList.add('text-danger', 'ml-2');
                    stockAsterisk.textContent = '*';
                    stockLabel.appendChild(stockAsterisk);
                    const stockInput = document.createElement('input');
                    stockInput.type = 'number';
                    stockInput.classList.add('form-control');
                    stockInput.id = `stock-${size}`;
                    stockInput.name = `stock[${size}]`;
                    stockInput.placeholder = 'Nhập số lượng';
                    stockGroup.appendChild(stockLabel);
                    stockGroup.appendChild(stockInput);

                    sizeDetailsDiv.appendChild(priceGroup);
                    sizeDetailsDiv.appendChild(stockGroup);

                    sizeDetailsContainer.appendChild(sizeDetailsDiv);
                });

                // Thêm sự kiện click cho radio button để bật/tắt collapse
                const radioButtons = document.querySelectorAll('input[name="size"]');
                radioButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const allDetails = document.querySelectorAll('.size-details');
                        allDetails.forEach(detail => {
                            $(detail).collapse('hide'); // Ẩn tất cả
                        });

                        const selectedDetail = document.querySelector(
                            `.size-details[data-size="${this.value}"]`);
                        $(selectedDetail).collapse(
                            'show'); // Hiển thị phần tử của kích thước được chọn
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Xử lý tất cả phần tử có class 'file-upload-image-detail-color-'
            const fileUploads = document.querySelectorAll('[class^="file-upload-image-detail-color-"]');

            fileUploads.forEach((fileUpload) => {
                // Lấy ID động của fileUpload và imagePreviewContainer
                const colorId = fileUpload.classList[0].split('-').pop(); // Lấy color id từ class
                const imageUpload = document.getElementById(`imageUpload-image-detail-color-${colorId}`);
                const imagePreviewContainer = document.querySelector(
                    `.image-preview-container-image-detail-color-${colorId}`);

                let selectedFiles_image_color = [];

                // Khi người dùng nhấn vào khu vực upload, kích hoạt input file
                fileUpload.addEventListener('click', () => {
                    imageUpload.click();
                });

                // Khi người dùng chọn ảnh, xử lý sự kiện thay đổi
                imageUpload.addEventListener('change', (event) => {
                    const files_image_color = Array.from(event.target.files);

                    // Lọc bỏ các ảnh đã có trong mảng selectedFiles_image_color
                    const newFiles_image_color = files_image_color.filter(file => !
                        selectedFiles_image_color.some(selectedFile =>
                            selectedFile.name === file.name));

                    // Cập nhật mảng selectedFiles_image_color với các tệp mới
                    selectedFiles_image_color = selectedFiles_image_color.concat(
                        newFiles_image_color);

                    // Xóa tất cả các ảnh đã có trong preview trước khi thêm ảnh mới
                    imagePreviewContainer.innerHTML = '';

                    // Hiển thị tất cả các ảnh đã chọn
                    selectedFiles_image_color.forEach(file => {
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
                            removeButton.textContent = '×';
                            removeButton.addEventListener('click', () => {
                                imagePreviewContainer.removeChild(imgContainer);

                                // Cập nhật selectedFiles_image_color để loại bỏ ảnh đã xóa
                                selectedFiles_image_color =
                                    selectedFiles_image_color.filter(
                                        selectedFile => selectedFile.name !==
                                        file.name);

                                // Cập nhật lại giá trị của input file
                                const dataTransfer = new DataTransfer();
                                selectedFiles_image_color.forEach(
                                    selectedFile => {
                                        dataTransfer.items.add(
                                            selectedFile);
                                    });
                                imageUpload.files = dataTransfer.files;
                            });

                            imgContainer.appendChild(removeButton);
                            imagePreviewContainer.appendChild(imgContainer);
                        };
                        reader.readAsDataURL(file);
                    });
                });

                // Xử lý kéo và thả ảnh vào vùng upload
                fileUpload.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    fileUpload.classList.add('dragover');
                });

                fileUpload.addEventListener('dragleave', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    fileUpload.classList.remove('dragover');
                });

                fileUpload.addEventListener('drop', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    fileUpload.classList.remove('dragover');

                    const files_image_color = Array.from(e.dataTransfer.files);

                    // Lọc bỏ các ảnh đã có trong mảng selectedFiles_image_color
                    const newFiles_image_color = files_image_color.filter(file => !
                        selectedFiles_image_color.some(selectedFile =>
                            selectedFile.name === file.name));

                    // Cập nhật mảng selectedFiles_image_color với các tệp mới
                    selectedFiles_image_color = selectedFiles_image_color.concat(
                        newFiles_image_color);

                    // Xóa tất cả các ảnh đã có trong preview trước khi thêm ảnh mới
                    imagePreviewContainer.innerHTML = '';

                    // Hiển thị tất cả các ảnh đã chọn
                    selectedFiles_image_color.forEach(file => {
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
                            removeButton.textContent = '×';
                            removeButton.addEventListener('click', () => {
                                imagePreviewContainer.removeChild(imgContainer);

                                // Cập nhật selectedFiles_image_color để loại bỏ ảnh đã xóa
                                selectedFiles_image_color =
                                    selectedFiles_image_color.filter(
                                        selectedFile => selectedFile.name !==
                                        file.name);

                                // Cập nhật lại giá trị của input file
                                const dataTransfer = new DataTransfer();
                                selectedFiles_image_color.forEach(
                                    selectedFile => {
                                        dataTransfer.items.add(
                                            selectedFile);
                                    });
                                imageUpload.files = dataTransfer.files;
                            });

                            imgContainer.appendChild(removeButton);
                            imagePreviewContainer.appendChild(imgContainer);
                        };
                        reader.readAsDataURL(file);
                    });
                });
            });
        });
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileUpload = document.querySelector(".file-upload");
            const imageUpload = document.getElementById("imageUpload");
            const imagePreviewContainer = document.querySelector(".image-preview-container");

            // Mảng để lưu trữ các tệp đã chọn
            let selectedFiles = [];

            // Khi người dùng nhấn vào khu vực viền nét đứt, sẽ kích hoạt input file
            fileUpload.addEventListener('click', () => {
                imageUpload.click(); // Kích hoạt input file khi click vào vùng upload
            });

            // Khi người dùng chọn ảnh, xử lý sự kiện thay đổi
            imageUpload.addEventListener('change', (event) => {
                const files = Array.from(event.target.files);

                // Lọc bỏ các ảnh đã có trong mảng selectedFiles
                const newFiles = files.filter(file => !selectedFiles.some(selectedFile => selectedFile
                    .name === file.name));

                // Cập nhật mảng selectedFiles với các tệp mới
                selectedFiles = selectedFiles.concat(newFiles); // Thêm tệp mới vào mảng

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
                        removeButton.textContent = '×';
                        removeButton.addEventListener('click', () => {
                            imagePreviewContainer.removeChild(imgContainer);

                            // Cập nhật selectedFiles để loại bỏ ảnh đã xóa
                            selectedFiles = selectedFiles.filter(selectedFile =>
                                selectedFile.name !== file.name);

                            // Cập nhật lại giá trị của input file
                            const dataTransfer = new DataTransfer();
                            selectedFiles.forEach(selectedFile => {
                                dataTransfer.items.add(
                                    selectedFile
                                ); // Thêm lại các tệp còn lại vào DataTransfer
                            });
                            imageUpload.files = dataTransfer
                                .files; // Cập nhật lại input file
                        });
                        imgContainer.appendChild(removeButton);
                        imagePreviewContainer.appendChild(imgContainer);
                    };
                    reader.readAsDataURL(file);
                });
            });

            // Xử lý kéo và thả ảnh vào vùng upload
            fileUpload.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.stopPropagation();
                fileUpload.classList.add('dragover'); // Thêm lớp khi kéo thả vào
            });

            fileUpload.addEventListener('dragleave', (e) => {
                e.preventDefault();
                e.stopPropagation();
                fileUpload.classList.remove('dragover'); // Xóa lớp khi không kéo thả vào nữa
            });

            fileUpload.addEventListener('drop', (e) => {
                e.preventDefault();
                e.stopPropagation();
                fileUpload.classList.remove('dragover'); // Bỏ lớp dragover khi thả ảnh

                const files = Array.from(e.dataTransfer.files); // Lấy các tệp đã thả vào

                // Lọc bỏ các ảnh đã có trong mảng selectedFiles
                const newFiles = files.filter(file => !selectedFiles.some(selectedFile => selectedFile
                    .name === file.name));

                // Cập nhật mảng selectedFiles với các tệp mới
                selectedFiles = selectedFiles.concat(newFiles); // Thêm tệp mới vào mảng

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
                        removeButton.textContent = '×';
                        removeButton.addEventListener('click', () => {
                            imagePreviewContainer.removeChild(imgContainer);

                            // Cập nhật selectedFiles để loại bỏ ảnh đã xóa
                            selectedFiles = selectedFiles.filter(selectedFile =>
                                selectedFile.name !== file.name);

                            // Cập nhật lại giá trị của input file
                            const dataTransfer = new DataTransfer();
                            selectedFiles.forEach(selectedFile => {
                                dataTransfer.items.add(
                                    selectedFile
                                ); // Thêm lại các tệp còn lại vào DataTransfer
                            });
                            imageUpload.files = dataTransfer
                                .files; // Cập nhật lại input file
                        });
                        imgContainer.appendChild(removeButton);
                        imagePreviewContainer.appendChild(imgContainer);
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Khi nhấn nút "Mở Modal"
            $("#openModal").on("click", function() {
                $("#exampleModal").modal("show"); // Mở modal
            });


            $(".open-variant-modal").on("click", function() {
                const colorId = $(this).data("color-id"); // Lấy id màu từ thuộc tính data
                $(`#exampleModalvariantcolor${colorId}`).modal("show"); // Mở modal tương ứng
            });

            $(".open-variant-image-modal").on("click", function() {
                const colorId = $(this).data("color-id"); // Lấy id màu từ thuộc tính data
                $(`#exampleModalvariantImagecolor${colorId}`).modal("show"); // Mở modal tương ứng
            });
        });
    </script>
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
        $(document).ready(function() {
            // Kiểm tra xem có session 'success' không
            @if (session('show_modal') === 'variantproductcolor')
                // Hiển thị modal nếu session 'success' tồn tại
                $('#exampleModal').modal('show');
            @endif
            @if (session('show_modal') === 'createVariantColorProduct')
                // Hiển thị modal nếu session 'success' tồn tại
                $('#exampleModalvariantcolor{{ session('colorId') }}').modal('show');
            @endif
            // Kiểm tra xem có session 'success' không
            @if (session('show_modal') === 'createVariantImageColorProduct')
                // Hiển thị modal nếu session 'success' tồn tại
                $('#exampleModalvariantImagecolor{{ session('colorId') }}').modal('show');
            @endif
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @endif
        });
    </script>

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
    <style>
        .file-upload,
        .file-upload-image-color {
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

        .file-upload-image-color input[type="file"] {
            display: none;
        }

        .image-preview {
            display: inline-block;
            /* Hiển thị ảnh theo dạng ngang */
            margin: 10px;
            /* Khoảng cách giữa các ảnh */
            max-width: 92px;
            /* Đảm bảo ảnh không tràn container */
            overflow: hidden;
            /* Ẩn phần ảnh vượt ra ngoài */
            position: relative;
            /* Để vị trí của nút xóa dễ quản lý */
        }

        .image-preview-color {
            display: inline-block;
            margin: 10px;
            max-width: 92px;
            position: relative;
            /* Để cho checkbox có thể được đặt tuyệt đối trong ảnh */
        }

        .checkbox-top-right {
            position: absolute;
            top: 5px;
            /* Cách từ trên xuống */
            right: 5px;
            /* Cách từ bên phải sang */
            z-index: 999;
            /* Đảm bảo checkbox nằm trên cùng */
            width: 20px;
            /* Kích thước checkbox */
            height: 20px;
            cursor: pointer;
        }

        .image-preview img {
            width: 100px;
            /* Giữ tỷ lệ ảnh phù hợp với container */
            height: auto;
            /* Đảm bảo tỷ lệ khung hình của ảnh không bị méo */
            object-fit: cover;
            /* Cắt ảnh sao cho vừa với container mà không bị kéo dãn */
        }

        .image-preview button {
            position: absolute;
            top: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.7);
            /* Nền bán trong cho nút xóa */
            border: none;
            padding: 5px;
            font-size: 20px;
            cursor: pointer;
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
@endpush
