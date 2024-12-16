        @foreach ($products as $product)
            <div class="card-product">
                <div class="card-product-wrapper">
                    <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product"
                            data-src="{{ asset('storage/' . $product['main_image_url']) }}"
                            src="{{ asset('storage/' . $product['main_image_url']) }}"
                            alt="image-product">
                        <img class="lazyload img-hover"
                            data-src="{{ asset('storage/' . $product['hover_main_image_url']) }}"
                            src="{{ asset('storage/' . $product['hover_main_image_url']) }}"
                            alt="image-product">
                    </a>
                    <div class="list-product-btn">
                        <a href="#quick_add" data-bs-toggle="modal"
                            data-product-id="{{ $product['id'] }}"
                            class="box-icon bg_white quick-add tf-btn-loading">
                            <span class="icon icon-bag"></span>
                            <span class="tooltip">Quick Add</span>
                        </a>
                        <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                            <span class="icon icon-heart"></span>
                            <span class="tooltip">Add to Wishlist</span>
                            <span class="icon icon-delete"></span>
                        </a>
                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                            class="box-icon bg_white compare btn-icon-action">
                            <span class="icon icon-compare"></span>
                            <span class="tooltip">Add to Compare</span>
                            <span class="icon icon-check"></span>
                        </a>
                        <a href="#quick_view" data-bs-toggle="modal"
                            class="box-icon bg_white quickview tf-btn-loading">
                            <span class="icon icon-view"></span>
                            <span class="tooltip">Quick View</span>
                        </a>
                    </div>
                    <div class="size-list">
                        <span>{{ $product['distinct_size_count'] }} sizes available</span>
                    </div>
                </div>
                <div class="card-product-info">
                    <a href="product-detail.html" class="title link">{{ $product['name'] }}</a>
                    <span class="price">${{ $product['price'] }}</span>
                    <ul class="list-color-product">
                        @foreach ($product['colors'] as $color)
                            <li class="list-color-item color-swatch active">
                                <span class="tooltip">{{ $color['name'] }}</span>
                                <span class="swatch-value"
                                    style="background-color: {{ $color['sku_color'] }}"></span>
                                <img class="lazyload image-product"
                                    data-src="{{ asset('storage/' . $color['main_image']) }}"
                                    src="{{ asset('storage/' . $color['main_image']) }}"
                                    alt="image-product">
                                <img class="lazyload hover-image-product"
                                    data-src="{{ asset('storage/' . $color['hover_image']) }}"
                                    src="{{ asset('storage/' . $color['hover_image']) }}"
                                    alt="image-product">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach