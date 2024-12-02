<nav class="box-navigation text-center">
    <ul class="box-nav-ul d-flex align-items-center justify-content-center gap-30">
        <li class="menu-item">
            <a href="#" class="item-link">Trang Chủ</a>

        </li>
        <li class="menu-item">
            <a href="#" class="item-link">Sản Phẩm<i class="icon icon-arrow-down"></i></a>
            <div class="sub-menu mega-menu">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="mega-menu-item">
                                <div class="menu-heading">Theo Sản Phẩm</div>
                                <ul class="menu-list">
                                    <li><a href="product-detail.html" class="menu-link-text link">Product
                                            default</a></li>
                                    <li><a href="product-grid-1.html" class="menu-link-text link">Product grid 1</a>
                                    </li>
                                    <li><a href="product-grid-2.html" class="menu-link-text link">Product grid 2</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @foreach ($categories as $category)
                            <div class="col-lg-2">
                                <div class="mega-menu-item">
                                    <div class="menu-heading text-center fs-4">{{ $category->name }}</div>
                                    @if ($category->children->isNotEmpty())
                                        <ul class="menu-list">
                                            @foreach ($category->children as $child)
                                                @include('client.layouts.particals.child-categories', [
                                                    'child' => $child,
                                                    'index' => 1,
                                                ])
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-4">
                            <div class="menu-heading">Best seller</div>
                            <div class="hover-sw-nav hover-sw-2">
                                <div class="swiper tf-product-header">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide" lazy="true">
                                            <div class="card-product">
                                                <div class="card-product-wrapper">
                                                    <a href="#" class="product-img">
                                                        <img class="lazyload img-product"
                                                            data-src="images/products/orange-1.jpg"
                                                            src="images/products/orange-1.jpg" alt="image-product">
                                                        <img class="lazyload img-hover"
                                                            data-src="images/products/white-1.jpg"
                                                            src="images/products/white-1.jpg" alt="image-product">
                                                    </a>
                                                    <div class="list-product-btn absolute-2">
                                                        <a href="#quick_add" data-bs-toggle="modal"
                                                            class="box-icon bg_white quick-add tf-btn-loading">
                                                            <span class="icon icon-bag"></span>
                                                            <span class="tooltip">Quick Add</span>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="box-icon bg_white wishlist btn-icon-action">
                                                            <span class="icon icon-heart"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                            <span class="icon icon-delete"></span>
                                                        </a>
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            aria-controls="offcanvasLeft"
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
                                                </div>
                                                <div class="card-product-info">
                                                    <a href="#" class="title link">Ribbed Tank Top</a>
                                                    <span class="price">$16.95</span>
                                                    <ul class="list-color-product">
                                                        <li class="list-color-item color-swatch active">
                                                            <span class="tooltip">Orange</span>
                                                            <span class="swatch-value bg_orange-3"></span>
                                                            <img class="lazyload"
                                                                data-src="images/products/orange-1.jpg"
                                                                src="images/products/orange-1.jpg" alt="image-product">
                                                        </li>
                                                        <li class="list-color-item color-swatch">
                                                            <span class="tooltip">Black</span>
                                                            <span class="swatch-value bg_dark"></span>
                                                            <img class="lazyload" data-src="images/products/black-1.jpg"
                                                                src="images/products/black-1.jpg" alt="image-product">
                                                        </li>
                                                        <li class="list-color-item color-swatch">
                                                            <span class="tooltip">White</span>
                                                            <span class="swatch-value bg_white"></span>
                                                            <img class="lazyload" data-src="images/products/white-1.jpg"
                                                                src="images/products/white-1.jpg" alt="image-product">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide" lazy="true">
                                            <div class="card-product">
                                                <div class="card-product-wrapper">
                                                    <div class="product-img">
                                                        <img class="lazyload img-product"
                                                            data-src="images/products/white-3.jpg"
                                                            src="images/products/white-3.jpg" alt="image-product">
                                                        <img class="lazyload img-hover"
                                                            data-src="images/products/white-4.jpg"
                                                            src="images/products/white-4.jpg" alt="image-product">
                                                    </div>
                                                    <div class="list-product-btn absolute-2">
                                                        <a href="#shoppingCart" data-bs-toggle="modal"
                                                            class="box-icon bg_white quick-add tf-btn-loading">
                                                            <span class="icon icon-bag"></span>
                                                            <span class="tooltip">Add to cart</span>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="box-icon bg_white wishlist btn-icon-action">
                                                            <span class="icon icon-heart"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                            <span class="icon icon-delete"></span>
                                                        </a>
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            aria-controls="offcanvasLeft"
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
                                                </div>
                                                <div class="card-product-info">
                                                    <a href="#" class="title link">Oversized Printed T-shirt</a>
                                                    <span class="price">$10.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide" lazy="true">
                                            <div class="card-product">
                                                <div class="card-product-wrapper">
                                                    <div class="product-img">
                                                        <img class="lazyload img-product"
                                                            data-src="images/products/white-2.jpg"
                                                            src="images/products/white-2.jpg" alt="image-product">
                                                        <img class="lazyload img-hover"
                                                            data-src="images/products/pink-1.jpg"
                                                            src="images/products/pink-1.jpg" alt="image-product">
                                                    </div>
                                                    <div class="list-product-btn">
                                                        <a href="#quick_add" data-bs-toggle="modal"
                                                            class="box-icon bg_white quick-add tf-btn-loading">
                                                            <span class="icon icon-bag"></span>
                                                            <span class="tooltip">Quick Add</span>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="box-icon bg_white wishlist btn-icon-action">
                                                            <span class="icon icon-heart"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                            <span class="icon icon-delete"></span>
                                                        </a>
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            aria-controls="offcanvasLeft"
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
                                                        <span>S</span>
                                                        <span>M</span>
                                                        <span>L</span>
                                                        <span>XL</span>
                                                    </div>
                                                </div>
                                                <div class="card-product-info">
                                                    <a href="#" class="title">Oversized Printed T-shirt</a>
                                                    <span class="price">$16.95</span>
                                                    <ul class="list-color-product">
                                                        <li class="list-color-item color-swatch active">
                                                            <span class="tooltip">White</span>
                                                            <span class="swatch-value bg_white"></span>
                                                            <img class="lazyload"
                                                                data-src="images/products/white-2.jpg"
                                                                src="images/products/white-2.jpg" alt="image-product">
                                                        </li>
                                                        <li class="list-color-item color-swatch">
                                                            <span class="tooltip">Pink</span>
                                                            <span class="swatch-value bg_purple"></span>
                                                            <img class="lazyload"
                                                                data-src="images/products/pink-1.jpg"
                                                                src="images/products/pink-1.jpg" alt="image-product">
                                                        </li>
                                                        <li class="list-color-item color-swatch">
                                                            <span class="tooltip">Black</span>
                                                            <span class="swatch-value bg_dark"></span>
                                                            <img class="lazyload"
                                                                data-src="images/products/black-2.jpg"
                                                                src="images/products/black-2.jpg" alt="image-product">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide" lazy="true">
                                            <div class="card-product">
                                                <div class="card-product-wrapper">
                                                    <div class="product-img">
                                                        <img class="lazyload img-product"
                                                            data-src="images/products/brown-2.jpg"
                                                            src="images/products/brown-2.jpg" alt="image-product">
                                                        <img class="lazyload img-hover"
                                                            data-src="images/products/brown-3.jpg"
                                                            src="images/products/brown-3.jpg" alt="image-product">
                                                    </div>
                                                    <div class="size-list">
                                                        <span>S</span>
                                                        <span>M</span>
                                                        <span>L</span>
                                                        <span>XL</span>
                                                    </div>
                                                    <div class="list-product-btn">
                                                        <a href="#quick_add" data-bs-toggle="modal"
                                                            class="box-icon bg_white quick-add tf-btn-loading">
                                                            <span class="icon icon-bag"></span>
                                                            <span class="tooltip">Quick Add</span>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="box-icon bg_white wishlist btn-icon-action">
                                                            <span class="icon icon-heart"></span>
                                                            <span class="tooltip">Add to Wishlist</span>
                                                            <span class="icon icon-delete"></span>
                                                        </a>
                                                        <a href="#compare" data-bs-toggle="offcanvas"
                                                            aria-controls="offcanvasLeft"
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
                                                </div>
                                                <div class="card-product-info">
                                                    <a href="#" class="title link">V-neck linen T-shirt</a>
                                                    <span class="price">$114.95</span>
                                                    <ul class="list-color-product">
                                                        <li class="list-color-item color-swatch active">
                                                            <span class="tooltip">Brown</span>
                                                            <span class="swatch-value bg_brown"></span>
                                                            <img class="lazyload"
                                                                data-src="images/products/brown-2.jpg"
                                                                src="images/products/brown-2.jpg" alt="image-product">
                                                        </li>
                                                        <li class="list-color-item color-swatch">
                                                            <span class="tooltip">White</span>
                                                            <span class="swatch-value bg_white"></span>
                                                            <img class="lazyload"
                                                                data-src="images/products/white-5.jpg"
                                                                src="images/products/white-5.jpg" alt="image-product">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nav-sw nav-next-slider nav-next-product-header box-icon w_46 round"><span
                                        class="icon icon-arrow-left"></span></div>
                                <div class="nav-sw nav-prev-slider nav-prev-product-header box-icon w_46 round"><span
                                        class="icon icon-arrow-right"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>


        <li class="menu-item">

            <a href="#" class="item-link">Sản Phẩm<i class="icon icon-arrow-down"></i></a>
            <div class="sub-menu mega-menu">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="mega-menu-item">
                                <div class="menu-heading">Product layouts</div>
                                <ul class="menu-list">

                                    <li><a href="" class="menu-link-text link">Product description
                                            vertical</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
        </li>
        <li class="menu-item position-relative">
<<<<<<< HEAD
            <a href="{{route('blog.show')}}" class="item-link">Bài Viết</a>
=======
            <a href="#" class="item-link">Bài Viết</a>
>>>>>>> 7f926c59d41326b58d373776f9d349e12732c333
        </li>

        <li class="menu-item position-relative">
            <a href="" class="item-link">Giới Thiệu</a>

        </li>
        <li class="menu-item"><a href="https://themeforest.net/item/ecomus-ultimate-html5-template/53417990?s_rank=3"
                class="item-link">Buy now</a></li>
    </ul>
</nav>
