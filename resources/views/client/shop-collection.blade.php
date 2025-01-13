@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('topbar')
    
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
                        <div id="filter-price" class="widget-facet wrap-price">
                            <div class="facet-title">
                                <span>Price</span>
                            </div>
                            <div class="filter-price">
                                <div class="range-input">
                                    <input id="price-min" class="range-min" type="range" min="0" max="2000000" value="0" />
                                    <input id="price-max" class="range-max" type="range" min="0" max="2000000" value="2000000" />
                                </div>
                                <div class="box-title-price">
                                    <span>Price:</span>
                                    <div>

                                        $<span id="display-min">0</span> - <span id="display-max">2.000.000 VNĐ</span>
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
                                            <label for="color-{{ $color->id }}" class="label d-flex align-items-center color-label">
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
                                                &nbsp;<span>({{ $size->productVariants->count() }})</span>
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
        sizeFilters: document.querySelectorAll('input[name="size"]'),
    };

    const updatePrices = () => {
        elements.displayMin.textContent = elements.rangeMin.value;
        elements.displayMax.textContent = elements.rangeMax.value;
    };

    const updateURL = () => {
        const url = new URL(window.location.href);

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

        history.pushState(null, '', url.toString());
    };

    const filterProducts = debounce(() => {
        updateURL();
        fetch(window.location.href, { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                if (elements.productList) {
                    elements.productList.innerHTML = html;
                }
            })
            .catch(error => console.error('Lỗi:', error));
    }, 300);

    elements.rangeMin.addEventListener('input', () => {
        updatePrices();
        filterProducts();
    });
    elements.rangeMax.addEventListener('input', () => {
        updatePrices();
        filterProducts();
    });

    elements.brandFilters.forEach(input => {
        input.addEventListener('change', filterProducts);
    });

    elements.colorFilters.forEach(input => {
        input.addEventListener('change', filterProducts);
    });

    elements.sizeFilters.forEach(input => {
        input.addEventListener('change', filterProducts);
    });

    updatePrices();
});

function debounce(func, wait) {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), wait);
    };
}

document.getElementById('reset-filters').addEventListener('click', function () {
    const radios = document.querySelectorAll('#facet-filter-form input[type="radio"], #facet-filter-form input[type="checkbox"]');
    radios.forEach(radio => radio.checked = false);

    const rangeInputs = document.querySelectorAll('#facet-filter-form input[type="range"]');
    rangeInputs.forEach(input => input.value = input.defaultValue);

    document.getElementById('display-min').innerText = document.getElementById('price-min').value;
    document.getElementById('display-max').innerText = document.getElementById('price-max').value;

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
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
}
input[type="checkbox"]:checked + label .color-swatch {
    border: 2px solid #000;
}

input[type="checkbox"]:hover + label .color-swatch {
    opacity: 0.8;
}
input[type="checkbox"]:checked + label .color-swatch {
    border: 2px solid #007bff; 
    transform: scale(1.1);
}

input[type="checkbox"]:checked + label {
    font-weight: bold; 
    color: #007bff;
}

label:hover .color-swatch {
    opacity: 0.8;
}

.color-swatch {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 1px solid #ccc;
    transition: all 0.3s ease;
}

label:hover {
    cursor: pointer;
}

label.checked .color-swatch {
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
}

    </style>
@endsection
