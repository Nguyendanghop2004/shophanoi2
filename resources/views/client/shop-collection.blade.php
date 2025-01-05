@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('topbar')
    {{-- <!-- top-bar -->
<div class="tf-top-bar bg_white line">
    <div class="px_15 lg-px_40">
        <div class="tf-top-bar_wrap grid-3 gap-30 align-items-center">
            <ul class="tf-top-bar_item tf-social-icon d-flex gap-10">
                <li><a href="#" class="box-icon w_28 round social-facebook bg_line"><i
                            class="icon fs-12 icon-fb"></i></a></li>
                <li><a href="#" class="box-icon w_28 round social-twiter bg_line"><i
                            class="icon fs-10 icon-Icon-x"></i></a></li>
                <li><a href="#" class="box-icon w_28 round social-instagram bg_line"><i
                            class="icon fs-12 icon-instagram"></i></a></li>
                <li><a href="#" class="box-icon w_28 round social-tiktok bg_line"><i
                            class="icon fs-12 icon-tiktok"></i></a></li>
                <li><a href="#" class="box-icon w_28 round social-pinterest bg_line"><i
                            class="icon fs-12 icon-pinterest-1"></i></a></li>
            </ul>
            <div class="text-center overflow-hidden">
                <div class="swiper tf-sw-top_bar" data-preview="1" data-space="0" data-loop="true" data-speed="1000"
                    data-delay="2000">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <p class="top-bar-text fw-5">Spring Fashion Sale <a href="shop-default.html"
                                    title="all collection" class="tf-btn btn-line">Shop now<i
                                        class="icon icon-arrow1-top-left"></i></a></p>
                        </div>
                        <div class="swiper-slide">
                            <p class="top-bar-text fw-5">Summer sale discount off 70%</p>
                        </div>
                        <div class="swiper-slide">
                            <p class="top-bar-text fw-5">Time to refresh your wardrobe.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="top-bar-language tf-cur justify-content-end">


                <div class="tf-currencies">
                    <select class="image-select center style-default type-currencies">
                        <option data-thumbnail="images/country/fr.svg">EUR <span>€ | France</span></option>
                        <option data-thumbnail="images/country/de.svg">EUR <span>€ | Germany</span></option>
                        <option selected data-thumbnail="images/country/us.svg">USD <span>$ | United States</span>
                        </option>
                        <option data-thumbnail="images/country/vn.svg">VND <span>₫ | Vietnam</span></option>
                    </select>
                </div>
                <div class="tf-languages">
                    <select class="image-select center style-default type-languages">
                        <option>English</option>
                        <option>العربية</option>
                        <option>简体中文</option>
                        <option>اردو</option>
                    </select>
                </div>

            </div>
        </div>


    </div>
</div>
<!-- /top-bar --> --}}
@endsection

@section('content')
 

    <section class="flat-spacing-1">
        <div class="container">
            <div class="tf-shop-control grid-3 align-items-center">
                <div></div>
                <ul class="tf-control-layout d-flex justify-content-center">
                    <li class="tf-view-layout-switch sw-layout-2" data-value-grid="grid-2">
                        <div class="item"><span class="icon icon-grid-2"></span></div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-3 active" data-value-grid="grid-3">
                        <div class="item"><span class="icon icon-grid-3"></span></div>
                    </li>
                    <li class="tf-view-layout-switch sw-layout-4" data-value-grid="grid-4">
                        <div class="item"><span class="icon icon-grid-4"></span></div>
                    </li>

                </ul>
            
            </div>
            <div class="tf-row-flex">
                <div class="tf-shop-sidebar wrap-sidebar-mobile">
                    <div class="widget-facet wd-categories">
                        <div class="facet-title d-flex justify-content-between align-items-center" 
                             data-bs-target="#categories" 
                             data-bs-toggle="collapse" 
                             aria-expanded="true" 
                             aria-controls="categories">
                            <span>Product categories</span>
                            <span class="icon">
                                <i class="fas fa-chevron-up"></i>
                            </span>
                        </div>
                        <div id="categories" class="collapse show">
                            <ul class="list-categories current-scrollbar mb_36">
                                @foreach ($categories as $category)
                                    <li class="cate-item {{ request('category') == $category->id ? 'current' : '' }}">
                                        <a href="{{ route('shop-collection.index', ['category' => $category->id]) }}">
                                            <span>{{ $category->name }}</span>
                                        </a>
                                    </li>
                                    @if ($category->children->isNotEmpty())
                                        <ul class="sub-categories">
                                            @foreach ($category->children as $child)
                                                <li class="cate-item {{ request('category') == $child->id ? 'current' : '' }}">
                                                    <a href="{{ route('shop-collection.index', ['category' => $child->id]) }}">
                                                        <span>{{ $child->name }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>                    
                    <form action="#" id="facet-filter-form" class="facet-filter-form">
                        {{-- <div class="widget-facet">
                            <div class="facet-title" data-bs-target="#availability" data-bs-toggle="collapse"
                                aria-expanded="true" aria-controls="availability">
                                <span>Availability</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="availability" class="collapse show">
                                <form id="availability-filter" method="GET" action="{{ route('shop-collection.index') }}">
                                    <ul class="tf-filter-group current-scrollbar mb_36">
                                        <li class="list-item d-flex gap-12 align-items-center">
                                            <input type="radio" name="availability" class="tf-check" id="availability-1" value="in-stock"
                                                {{ request('availability') === 'in-stock' ? 'checked' : '' }}>
                                            <label for="availability-1" class="label">
                                                <span>In stock</span>&nbsp;<span>({{ $inStockCount }})</span>
                                            </label>
                                        </li>
                                        <li class="list-item d-flex gap-12 align-items-center">
                                            <input type="radio" name="availability" class="tf-check" id="availability-2" value="out-of-stock"
                                                {{ request('availability') === 'out-of-stock' ? 'checked' : '' }}>
                                            <label for="availability-2" class="label">
                                                <span>Out of stock</span>&nbsp;<span>({{ $outOfStockCount }})</span>
                                            </label>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div> --}}
                                                
                        <div id="filter-price" class="widget-facet wrap-price">
                            <div class="facet-title">
                                <span>Price</span>
                            </div>
                            <div class="filter-price">
                                <div class="range-input">
                                    <input id="price-min" class="range-min" type="range" min="0" max="5000" value="0" />
                                    <input id="price-max" class="range-max" type="range" min="0" max="5000" value="5000" />
                                </div>
                                <div class="box-title-price">
                                    <span>Price:</span>
                                    <div>
                                        $<span id="display-min">0</span> - $<span id="display-max">5000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="widget-facet">
                            <div class="facet-title" data-bs-target="#brand" data-bs-toggle="collapse" aria-expanded="true" aria-controls="brand">
                                <span>Brand</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="brand" class="collapse show">
                                <ul class="tf-filter-group current-scrollbar mb_36">
                                    @foreach ($brands as $brand)
                                        <li class="list-item d-flex gap-12 align-items-center">
                                            <input type="radio" name="brand" class="tf-check" id="brand-{{ $brand->id }}" data-brand-id="{{ $brand->id }}">
                                            <label for="brand-{{ $brand->id }}" class="label">
                                                <span>{{ $brand->name }}</span>&nbsp;<span>({{ $brand->products_count }})</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        


                        <div class="widget-facet">
                            <div class="facet-title" data-bs-target="#color" data-bs-toggle="collapse" aria-expanded="true" aria-controls="color">
                                <span>Color</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="color" class="collapse show">
                                <ul class="tf-filter-group filter-color current-scrollbar mb_36">
                                    @foreach ($colors as $color)
                                        <li class="list-item d-flex gap-12 align-items-center">
                                            <input type="checkbox" name="color[]" class="tf-check-color bg_{{ strtolower($color->name) }}" id="color-{{ $color->id }}" value="{{ $color->id }}">
                                            <label for="color-{{ $color->id }}" class="label d-flex align-items-center">
                                                <!-- Hiển thị ô màu với màu nền từ sku_color -->
                                                <span class="color-swatch" style="background-color: {{ $color->sku_color }};"></span>
                                                <span>{{ $color->name }}</span>&nbsp;<span>({{ $color->products_count }})</span>
                                            </label> 
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        
                        
                        

                        
                        <div class="widget-facet">
                            <div class="facet-title" data-bs-target="#size" data-bs-toggle="collapse"
                                aria-expanded="true" aria-controls="size">
                                <span>Size</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="size" class="collapse show">
                                <ul class="tf-filter-group current-scrollbar">
                                    @foreach ($sizes as $size)
                                        <li class="list-item d-flex gap-12 align-items-center">
                                            <input type="radio" name="size" class="tf-check tf-check-size" value="{{ $size->id }}" id="size-{{ $size->id }}">
                                            <label for="size-{{ $size->id }}" class="label">
                                                <span>{{ $size->name }}</span> 
                                                &nbsp;<span>({{ $size->productVariants->count() }})</span> <!-- Số lượng sản phẩm liên quan -->
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        


                        <button type="button" id="reset-filters" class="btn btn-sm btn-secondary">Reset</button>

                    </form>
                </div>
                    <div class="tf-shop-content wrapper-control-shop">
                        <div class="meta-filter-shop">
                            <div class="grid-layout wrapper-shop" data-grid="grid-3">
                                    @include('client.partials.product_list', ['products' => $products])
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>

    <div class="btn-sidebar-mobile start-0">
        <a href="#filterShop" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft">
            <button class="type-hover">
                <i class="icon-open"></i>
                <span class="fw-5">Open sidebar</span>
            </button>
        </a>
    </div>

    <script>

document.addEventListener('DOMContentLoaded', function () {
    const elements = {
        rangeMin: document.getElementById('price-min'),
        rangeMax: document.getElementById('price-max'),
        displayMin: document.getElementById('display-min'),
        displayMax: document.getElementById('display-max'),
        productList: document.querySelector('.wrapper-shop'),
        brandFilters: document.querySelectorAll('input[name="brand"]'),
        colorFilters: document.querySelectorAll('input[name="color[]"]'),
        sizeFilters: document.querySelectorAll('input[name="size"]'), // Bộ lọc kích thước
    };

    // Cập nhật giá trị hiển thị
    const updatePrices = () => {
        elements.displayMin.textContent = elements.rangeMin.value;
        elements.displayMax.textContent = elements.rangeMax.value;
    };

    // Hàm gửi yêu cầu AJAX để lọc sản phẩm
    const filterProducts = debounce(() => {
        const url = new URL(window.location.href);

        // Lấy giá trị bộ lọc
        url.searchParams.set('price_min', elements.rangeMin.value);
        url.searchParams.set('price_max', elements.rangeMax.value);

        const selectedBrand = document.querySelector('input[name="brand"]:checked');
        if (selectedBrand) {
            url.searchParams.set('brand', selectedBrand.dataset.brandId);
        } else {
            url.searchParams.delete('brand');
        }

        const selectedColors = Array.from(elements.colorFilters)
            .filter(input => input.checked)
            .map(input => input.value);
        if (selectedColors.length > 0) {
            url.searchParams.set('color', selectedColors.join(','));
        } else {
            url.searchParams.delete('color');
        }

        const selectedSize = document.querySelector('input[name="size"]:checked');
        if (selectedSize) {
            url.searchParams.set('size', selectedSize.value);
        } else {
            url.searchParams.delete('size');
        }

        // Gửi yêu cầu AJAX
        fetch(url.toString(), {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
            .then(response => response.text())
            .then(html => {
                if (elements.productList) {
                    elements.productList.innerHTML = html;
                }
            })
            .catch(error => console.error('Lỗi:', error));
    }, 300);

    // Xử lý sự kiện thanh trượt
    const handleRangeInput = (isMin) => {
        const minValue = parseInt(elements.rangeMin.value);
        const maxValue = parseInt(elements.rangeMax.value);

        if (isMin && minValue > maxValue) {
            elements.rangeMin.value = maxValue;
        } else if (!isMin && maxValue < minValue) {
            elements.rangeMax.value = minValue;
        }

        updatePrices();
        filterProducts(); // Lọc sản phẩm sau khi thay đổi giá
    };

    // Gắn sự kiện cho các thanh trượt
    elements.rangeMin.addEventListener('input', () => handleRangeInput(true));
    elements.rangeMax.addEventListener('input', () => handleRangeInput(false));

    // Lọc sản phẩm theo thương hiệu
    elements.brandFilters.forEach(input => {
        input.addEventListener('change', filterProducts);
    });

    // Lọc sản phẩm theo màu sắc
    elements.colorFilters.forEach(input => {
        input.addEventListener('change', filterProducts);
    });

    // Lọc sản phẩm theo kích thước
    elements.sizeFilters.forEach(input => {
        input.addEventListener('change', filterProducts);
    });

    // Khởi tạo giá trị ban đầu
    updatePrices();
});

// Hàm debounce để giới hạn số lần gửi yêu cầu
function debounce(func, wait) {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), wait);
    };
}

document.getElementById('reset-filters').addEventListener('click', function() {
        // Reset tất cả các input radio, checkbox và range
        const radios = document.querySelectorAll('#facet-filter-form input[type="radio"], #facet-filter-form input[type="checkbox"]');
        radios.forEach(function(radio) {
            radio.checked = false;
        });

        const rangeInputs = document.querySelectorAll('#facet-filter-form input[type="range"]');
        rangeInputs.forEach(function(input) {
            input.value = input.defaultValue;
        });

        // Cập nhật lại hiển thị giá trị range (nếu có)
        document.getElementById('display-min').innerText = document.getElementById('price-min').value;
        document.getElementById('display-max').innerText = document.getElementById('price-max').value;

        // Gửi lại form để lọc lại kết quả sau khi reset
        document.getElementById('facet-filter-form').submit();
    });
    </script>
    
    
    
    
    <style>
        .widget-facet {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 15px;
    background-color: #f9f9f9;
}

.widget-facet .facet-title {
    font-weight: bold;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
}

.widget-facet .facet-title .icon i {
    transition: transform 0.3s ease;
}

.widget-facet .facet-title[aria-expanded="true"] .icon i {
    transform: rotate(180deg);
}

.list-categories {
    margin: 0;
    padding: 0;
    list-style: none;
}

.cate-item {
    margin: 5px 0;
    padding-left: 10px;
    font-size: 1rem;
    transition: all 0.2s ease;
}

.cate-item.current > a {
    color: #007bff;
    font-weight: bold;
}

.cate-item a {
    text-decoration: none;
    color: #333;
}

.cate-item:hover > a {
    color: #0056b3;
}

.sub-categories {
    margin-left: 20px;
    border-left: 2px solid #ddd;
    padding-left: 10px;
}

.sub-categories .cate-item {
    font-size: 0.9rem;
    color: #555;
}

.sub-categories .cate-item:hover > a {
    color: #007bff;
}
.color-swatch {
    width: 20px;
    height: 20px;
    border-radius: 50%; /* Tùy chọn nếu bạn muốn ô màu tròn */
    display: inline-block;
    margin-right: 8px;
}
/* Kiểu cho dấu tick */
input[type="checkbox"]:checked + label .color-swatch {
    border: 2px solid #000; /* Bạn có thể thay đổi màu sắc của đường viền để hiển thị dấu tick */
}

/* Tạo hiệu ứng khi hover */
input[type="checkbox"]:hover + label .color-swatch {
    opacity: 0.8;
}



    </style>
@endsection
