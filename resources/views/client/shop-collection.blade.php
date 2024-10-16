@extends('client.layouts.master')
@section('topbar')
    <!-- top-bar -->
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
    <!-- /top-bar -->
@endsection

@section('content')
@include('client.layouts.particals.page-title')

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
                <div class="tf-control-sorting d-flex justify-content-end">
                    <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                        <div class="btn-select">
                            <span class="text-sort-value">Featured</span>
                            <span class="icon icon-arrow-down"></span>
                        </div>
                        <div class="dropdown-menu">
                            <div class="select-item active">
                                <span class="text-value-item">Featured</span>
                            </div>
                            <div class="select-item">
                                <span class="text-value-item">Best selling</span>
                            </div>
                            <div class="select-item">
                                <span class="text-value-item">Alphabetically, A-Z</span>
                            </div>
                            <div class="select-item">
                                <span class="text-value-item">Alphabetically, Z-A</span>
                            </div>
                            <div class="select-item">
                                <span class="text-value-item">Price, low to high</span>
                            </div>
                            <div class="select-item">
                                <span class="text-value-item">Price, high to low</span>
                            </div>
                            <div class="select-item">
                                <span class="text-value-item">Date, old to new</span>
                            </div>
                            <div class="select-item">
                                <span class="text-value-item">Date, new to old</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tf-row-flex">
                <div class="tf-shop-sidebar wrap-sidebar-mobile">
                    <div class="widget-facet wd-categories">
                        <div class="facet-title" data-bs-target="#categories" data-bs-toggle="collapse" aria-expanded="true"
                            aria-controls="categories">
                            <span>Product categories</span>
                            <span class="icon icon-arrow-up"></span>
                        </div>
                        <div id="categories" class="collapse show">
                            <ul class="list-categoris current-scrollbar mb_36">
                                <li class="cate-item current"><a href="#"><span>Fashion</span></a></li>
                                <li class="cate-item"><a href="#"><span>Men</span></a></li>
                                <li class="cate-item"><a href="#"><span>Women</span></a></li>
                                <li class="cate-item"><a href="#"><span>Denim</span></a></li>
                                <li class="cate-item"><a href="#"><span>Dress</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <form action="#" id="facet-filter-form" class="facet-filter-form">
                        <div class="widget-facet">
                            <div class="facet-title" data-bs-target="#availability" data-bs-toggle="collapse"
                                aria-expanded="true" aria-controls="availability">
                                <span>Availability</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="availability" class="collapse show">
                                <ul class="tf-filter-group current-scrollbar mb_36">
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="radio" name="availability" class="tf-check" id="availability-1">
                                        <label for="availability-1" class="label"><span>In
                                                stock</span>&nbsp;<span>(14)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="radio" name="availability" class="tf-check" id="availability-2">
                                        <label for="availability-2" class="label"><span>Out of
                                                stock</span>&nbsp;<span>(2)</span></label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="widget-facet wrap-price">
                            <div class="facet-title" data-bs-target="#price" data-bs-toggle="collapse"
                                aria-expanded="true" aria-controls="price">
                                <span>Price</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="price" class="collapse show">
                                <div class="widget-price filter-price">
                                    <div class="tow-bar-block">
                                        <div class="progress-price"></div>
                                    </div>
                                    <div class="range-input">
                                        <input class="range-min" type="range" min="0" max="300"
                                            value="0" />
                                        <input class="range-max" type="range" min="0" max="300"
                                            value="300" />
                                    </div>
                                    <div class="box-title-price">
                                        <span class="title-price">Price :</span>
                                        <div class="caption-price">
                                            <div>
                                                <span>$</span>
                                                <span class="min-price">0</span>
                                            </div>
                                            <span>-</span>
                                            <div>
                                                <span>$</span>
                                                <span class="max-price">300</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="widget-facet">
                            <div class="facet-title" data-bs-target="#brand" data-bs-toggle="collapse"
                                aria-expanded="true" aria-controls="brand">
                                <span>Brand</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="brand" class="collapse show">
                                <ul class="tf-filter-group current-scrollbar mb_36">
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="radio" name="brand" class="tf-check" id="brand-1">
                                        <label for="brand-1"
                                            class="label"><span>Ecomus</span>&nbsp;<span>(8)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="radio" name="brand" class="tf-check" id="brand-2">
                                        <label for="brand-2"
                                            class="label"><span>M&H</span>&nbsp;<span>(8)</span></label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="widget-facet">
                            <div class="facet-title" data-bs-target="#color" data-bs-toggle="collapse"
                                aria-expanded="true" aria-controls="color">
                                <span>Color</span>
                                <span class="icon icon-arrow-up"></span>
                            </div>
                            <div id="color" class="collapse show">
                                <ul class="tf-filter-group filter-color current-scrollbar mb_36">
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_beige"
                                            id="beige" value="beige">
                                        <label for="beige"
                                            class="label"><span>Beige</span>&nbsp;<span>(3)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_dark"
                                            id="black" value="black">
                                        <label for="black"
                                            class="label"><span>Black</span>&nbsp;<span>(18)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_blue-2"
                                            id="blue" value="blue">
                                        <label for="blue"
                                            class="label"><span>Blue</span>&nbsp;<span>(3)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_brown"
                                            id="brown" value="brown">
                                        <label for="brown"
                                            class="label"><span>Brown</span>&nbsp;<span>(3)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_cream"
                                            id="cream" value="cream">
                                        <label for="cream"
                                            class="label"><span>Cream</span>&nbsp;<span>(1)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_dark-beige"
                                            id="dark-beige" value="dark-beige">
                                        <label for="dark-beige" class="label"><span>Dark
                                                Beige</span>&nbsp;<span>(1)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_dark-blue"
                                            id="dark-blue" value="dark-blue">
                                        <label for="dark-blue" class="label"><span>Dark
                                                Blue</span>&nbsp;<span>(3)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_dark-green"
                                            id="dark-green" value="dark-green">
                                        <label for="dark-green" class="label"><span>Dark
                                                Green</span>&nbsp;<span>(1)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_dark-grey"
                                            id="dark-grey" value="dark-grey">
                                        <label for="dark-grey" class="label"><span>Dark
                                                Grey</span>&nbsp;<span>(1)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_grey"
                                            id="grey" value="grey">
                                        <label for="grey"
                                            class="label"><span>Grey</span>&nbsp;<span>(2)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_light-blue"
                                            id="light-blue" value="light-blue">
                                        <label for="light-blue" class="label"><span>Light
                                                Blue</span>&nbsp;<span>(5)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_light-green"
                                            id="light-green" value="light-green">
                                        <label for="light-green" class="label"><span>Light
                                                Green</span>&nbsp;<span>(3)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_light-grey"
                                            id="light-grey" value="light-grey">
                                        <label for="light-grey" class="label"><span>Light
                                                Grey</span>&nbsp;<span>(1)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_light-pink"
                                            id="light-pink" value="light-pink">
                                        <label for="light-pink" class="label"><span>Light
                                                Pink</span>&nbsp;<span>(2)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_purple"
                                            id="light-purple" value="light-purple">
                                        <label for="light-purple" class="label"><span>Light
                                                Purple</span>&nbsp;<span>(2)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_light-yellow"
                                            id="light-yellow" value="light-yellow">
                                        <label for="light-yellow" class="label"><span>Light
                                                Yellow</span>&nbsp;<span>(1)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_orange"
                                            id="orange" value="orange">
                                        <label for="orange"
                                            class="label"><span>Orange</span>&nbsp;<span>(1)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_pink"
                                            id="pink" value="pink">
                                        <label for="pink"
                                            class="label"><span>Pink</span>&nbsp;<span>(2)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_taupe"
                                            id="taupe" value="taupe">
                                        <label for="taupe"
                                            class="label"><span>Taupe</span>&nbsp;<span>(1)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_white"
                                            id="white" value="white">
                                        <label for="white"
                                            class="label"><span>White</span>&nbsp;<span>(14)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="checkbox" name="color" class="tf-check-color bg_yellow"
                                            id="yellow" value="yellow">
                                        <label for="yellow"
                                            class="label"><span>Yellow</span>&nbsp;<span>(1)</span></label>
                                    </li>
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
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="radio" name="size" class="tf-check tf-check-size"
                                            value="s" id="s">
                                        <label for="s" class="label"><span>S</span>&nbsp;<span>(7)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="radio" name="size" class="tf-check tf-check-size"
                                            value="m" id="m">
                                        <label for="m" class="label"><span>M</span>&nbsp;<span>(8)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="radio" name="size" class="tf-check tf-check-size"
                                            value="l" id="l">
                                        <label for="l" class="label"><span>L</span>&nbsp;<span>(8)</span></label>
                                    </li>
                                    <li class="list-item d-flex gap-12 align-items-center">
                                        <input type="radio" name="size" class="tf-check tf-check-size"
                                            value="xl" id="xl">
                                        <label for="xl" class="label"><span>XL</span>&nbsp;<span>(6)</span></label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tf-shop-content wrapper-control-shop">
                    <div class="meta-filter-shop"></div>
                    <div class="grid-layout wrapper-shop" data-grid="grid-3">
                        <!-- card product 1 -->
                        <div class="card-product" data-price="16.95" data-color="orange black white">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/orange-1.jpg"
                                        src="images/products/orange-1.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/white-1.jpg"
                                        src="images/products/white-1.jpg" alt="image-product">
                                </a>
                                <div class="list-product-btn absolute-2">
                                    <a href="#quick_add" data-bs-toggle="modal"
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
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">Ribbed Tank Top</a>
                                <span class="price">$16.95</span>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch active">
                                        <span class="tooltip">Orange</span>
                                        <span class="swatch-value bg_orange-3"></span>
                                        <img class="lazyload" data-src="images/products/orange-1.jpg"
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
                        <!-- card product 2 -->
                        <div class="card-product" data-price="18.95" data-size="m l xl"
                            data-color="brown light-purple light-green">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/brown.jpg"
                                        src="images/products/brown.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/purple.jpg"
                                        src="images/products/purple.jpg" alt="image-product">
                                </a>
                                <div class="list-product-btn">
                                    <a href="#quick_add" data-bs-toggle="modal"
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
                                    <span>M</span>
                                    <span>L</span>
                                    <span>XL</span>
                                </div>
                                <div class="countdown-box">
                                    <div class="js-countdown" data-timer="1007500" data-labels="d :,h :,m :,s"></div>
                                </div>
                                <div class="on-sale-wrap text-end">
                                    <div class="on-sale-item">-33%</div>
                                </div>
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">Ribbed modal T-shirt</a>
                                <span class="price">From $18.95</span>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch active">
                                        <span class="tooltip">Brown</span>
                                        <span class="swatch-value bg_brown"></span>
                                        <img class="lazyload" data-src="images/products/brown.jpg"
                                            src="images/products/brown.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Light Purple</span>
                                        <span class="swatch-value bg_purple"></span>
                                        <img class="lazyload" data-src="images/products/purple.jpg"
                                            src="images/products/purple.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Light Green</span>
                                        <span class="swatch-value bg_light-green"></span>
                                        <img class="lazyload" data-src="images/products/green.jpg"
                                            src="images/products/green.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- card product 3 -->
                        <div class="card-product" data-price="10">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/white-3.jpg"
                                        src="images/products/white-3.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/white-4.jpg"
                                        src="images/products/white-4.jpg" alt="image-product">
                                </a>
                                <div class="list-product-btn absolute-2">
                                    <a href="#shoppingCart" data-bs-toggle="modal"
                                        class="box-icon bg_white quick-add tf-btn-loading">
                                        <span class="icon icon-bag"></span>
                                        <span class="tooltip">Add to cart</span>
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
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">Oversized Printed T-shirt</a>
                                <span class="price">$10.00</span>
                            </div>
                        </div>
                        <!-- card product 4 -->
                        <div class="card-product" data-price="16.95" data-size="s m l xl"
                            data-color="white purple black">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/white-2.jpg"
                                        src="images/products/white-2.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/pink-1.jpg"
                                        src="images/products/pink-1.jpg" alt="image-product">
                                </a>
                                <div class="list-product-btn">
                                    <a href="#quick_add" data-bs-toggle="modal"
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
                                    <span>S</span>
                                    <span>M</span>
                                    <span>L</span>
                                    <span>XL</span>
                                </div>
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title">Oversized Printed T-shirt</a>
                                <span class="price">$16.95</span>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch active">
                                        <span class="tooltip">White</span>
                                        <span class="swatch-value bg_white"></span>
                                        <img class="lazyload" data-src="images/products/white-2.jpg"
                                            src="images/products/white-2.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Pink</span>
                                        <span class="swatch-value bg_purple"></span>
                                        <img class="lazyload" data-src="images/products/pink-1.jpg"
                                            src="images/products/pink-1.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg_dark"></span>
                                        <img class="lazyload" data-src="images/products/black-2.jpg"
                                            src="images/products/black-2.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- card product 5 -->
                        <div class="card-product" data-price="114.95" data-size="s m l xl" data-color="brown white">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/brown-2.jpg"
                                        src="images/products/brown-2.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/brown-3.jpg"
                                        src="images/products/brown-3.jpg" alt="image-product">
                                </a>
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
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">V-neck linen T-shirt</a>
                                <span class="price">$114.95</span>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch active">
                                        <span class="tooltip">Brown</span>
                                        <span class="swatch-value bg_brown"></span>
                                        <img class="lazyload" data-src="images/products/brown-2.jpg"
                                            src="images/products/brown-2.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">White</span>
                                        <span class="swatch-value bg_white"></span>
                                        <img class="lazyload" data-src="images/products/white-5.jpg"
                                            src="images/products/white-5.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- card product 6 -->
                        <div class="card-product" data-price="10.00"
                            data-color="light-green black blue dark-blue white light-grey">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/light-green-1.jpg"
                                        src="images/products/light-green-1.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/light-green-2.jpg"
                                        src="images/products/light-green-2.jpg" alt="image-product">
                                </a>
                                <div class="list-product-btn absolute-2">
                                    <a href="#quick_add" data-bs-toggle="modal"
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
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">Loose Fit Sweatshirt</a>
                                <span class="price">$10.00</span>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch active">
                                        <span class="tooltip">Light Green</span>
                                        <span class="swatch-value bg_light-green"></span>
                                        <img class="lazyload" data-src="images/products/light-green-1.jpg"
                                            src="images/products/light-green-1.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg_dark"></span>
                                        <img class="lazyload" data-src="images/products/black-3.jpg"
                                            src="images/products/black-3.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Blue</span>
                                        <span class="swatch-value bg_blue-2"></span>
                                        <img class="lazyload" data-src="images/products/blue.jpg"
                                            src="images/products/blue.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Dark Blue</span>
                                        <span class="swatch-value bg_dark-blue"></span>
                                        <img class="lazyload" data-src="images/products/dark-blue.jpg"
                                            src="images/products/dark-blue.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">White</span>
                                        <span class="swatch-value bg_white"></span>
                                        <img class="lazyload" data-src="images/products/white-6.jpg"
                                            src="images/products/white-6.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Light Grey</span>
                                        <span class="swatch-value bg_light-grey"></span>
                                        <img class="lazyload" data-src="images/products/light-grey.jpg"
                                            src="images/products/light-grey.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- card product 7 -->
                        <div class="card-product" data-price="10.00" data-size="s m l"
                            data-color="black dark-blue beige light-blue white">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/black-4.jpg"
                                        src="images/products/black-4.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/black-5.jpg"
                                        src="images/products/black-5.jpg" alt="image-product">
                                </a>
                                <div class="size-list">
                                    <span>S</span>
                                    <span>M</span>
                                    <span>L</span>
                                </div>
                                <div class="list-product-btn">
                                    <a href="#quick_add" data-bs-toggle="modal"
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
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">Regular Fit Oxford Shirt</a>
                                <span class="price">$10.00</span>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch active">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg_dark"></span>
                                        <img class="lazyload" data-src="images/products/black-4.jpg"
                                            src="images/products/black-4.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Dark Blue</span>
                                        <span class="swatch-value bg_dark-blue"></span>
                                        <img class="lazyload" data-src="images/products/dark-blue-2.jpg"
                                            src="images/products/dark-blue-2.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Beige</span>
                                        <span class="swatch-value bg_beige"></span>
                                        <img class="lazyload" data-src="images/products/beige.jpg"
                                            src="images/products/beige.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Light Blue</span>
                                        <span class="swatch-value bg_light-blue"></span>
                                        <img class="lazyload" data-src="images/products/light-blue.jpg"
                                            src="images/products/light-blue.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">White</span>
                                        <span class="swatch-value bg_white"></span>
                                        <img class="lazyload" data-src="images/products/white-7.jpg"
                                            src="images/products/white-7.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- card product 8 -->
                        <div class="card-product" data-price="9.95" data-size="s m l xl" data-color="white black blue">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/white-8.jpg"
                                        src="images/products/white-8.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/black-6.jpg"
                                        src="images/products/black-6.jpg" alt="image-product">
                                </a>
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
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">Loose Fit Hoodie</a>
                                <span class="price">$9.95</span>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch active">
                                        <span class="tooltip">White</span>
                                        <span class="swatch-value bg_white"></span>
                                        <img class="lazyload" data-src="images/products/white-8.jpg"
                                            src="images/products/white-8.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg_dark"></span>
                                        <img class="lazyload" data-src="images/products/black-7.jpg"
                                            src="images/products/black-7.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Blue</span>
                                        <span class="swatch-value bg_blue-2"></span>
                                        <img class="lazyload" data-src="images/products/blue-2.jpg"
                                            src="images/products/blue-2.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- card product 9 -->
                        <div class="card-product" data-price="14.95" data-size="m l xl" data-color="brown black">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/brown-4.jpg"
                                        src="images/products/brown-4.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/black-8.jpg"
                                        src="images/products/black-8.jpg" alt="image-product">
                                </a>
                                <div class="size-list">
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
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">Patterned scarf</a>
                                <span class="price">$14.95</span>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch active">
                                        <span class="tooltip">Brown</span>
                                        <span class="swatch-value bg_brown"></span>
                                        <img class="lazyload" data-src="images/products/brown-4.jpg"
                                            src="images/products/brown-4.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg_dark"></span>
                                        <img class="lazyload" data-src="images/products/black-8.jpg"
                                            src="images/products/black-8.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- card product 10 -->
                        <div class="card-product" data-price="18.95" data-size="s m l" data-color="black white">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/black-9.jpg"
                                        src="images/products/black-9.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/black-10.jpg"
                                        src="images/products/black-10.jpg" alt="image-product">
                                </a>
                                <div class="size-list">
                                    <span>S</span>
                                    <span>M</span>
                                    <span>L</span>
                                </div>
                                <div class="list-product-btn">
                                    <a href="#quick_add" data-bs-toggle="modal"
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
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">Slim Fit Fine-knit Turtleneck
                                    Sweater</a>
                                <span class="price">$18.95</span>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch active">
                                        <span class="tooltip">Black</span>
                                        <span class="swatch-value bg_dark"></span>
                                        <img class="lazyload" data-src="images/products/black-9.jpg"
                                            src="images/products/black-9.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">White</span>
                                        <span class="swatch-value bg_white"></span>
                                        <img class="lazyload" data-src="images/products/white-9.jpg"
                                            src="images/products/white-9.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- card product 11 -->
                        <div class="card-product" data-price="18.95" data-size="s m l"
                            data-color="grey pink light-pink">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/grey-2.jpg"
                                        src="images/products/grey-2.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/grey.jpg"
                                        src="images/products/grey.jpg" alt="image-product">
                                </a>
                                <div class="size-list">
                                    <span>S</span>
                                    <span>M</span>
                                    <span>L</span>
                                </div>
                                <div class="list-product-btn">
                                    <a href="#quick_add" data-bs-toggle="modal"
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
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">Slim Fit Fine-knit Turtleneck
                                    Sweater</a>
                                <span class="price">$18.95</span>
                                <ul class="list-color-product">
                                    <li class="list-color-item color-swatch active">
                                        <span class="tooltip">Grey</span>
                                        <span class="swatch-value bg_grey"></span>
                                        <img class="lazyload" data-src="images/products/grey-2.jpg"
                                            src="images/products/grey-2.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Pink</span>
                                        <span class="swatch-value bg_pink"></span>
                                        <img class="lazyload" data-src="images/products/pink-2.jpg"
                                            src="images/products/pink-2.jpg" alt="image-product">
                                    </li>
                                    <li class="list-color-item color-swatch">
                                        <span class="tooltip">Light Pink</span>
                                        <span class="swatch-value bg_light-pink"></span>
                                        <img class="lazyload" data-src="images/products/light-pink.jpg"
                                            src="images/products/light-pink.jpg" alt="image-product">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- card product 12 -->
                        <div class="card-product" data-price="18.95" data-size="s m l">
                            <div class="card-product-wrapper">
                                <a href="product-detail.html" class="product-img">
                                    <img class="lazyload img-product" data-src="images/products/black-11.jpg"
                                        src="images/products/black-11.jpg" alt="image-product">
                                    <img class="lazyload img-hover" data-src="images/products/black-12.jpg"
                                        src="images/products/black-12.jpg" alt="image-product">
                                </a>
                                <div class="size-list">
                                    <span>S</span>
                                    <span>M</span>
                                    <span>L</span>
                                </div>
                                <div class="list-product-btn">
                                    <a href="#quick_add" data-bs-toggle="modal"
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
                            </div>
                            <div class="card-product-info">
                                <a href="product-detail.html" class="title link">Slim Fit Fine-knit Turtleneck
                                    Sweater</a>
                                <span class="price">$18.95</span>

                            </div>
                        </div>
                    </div>
                    <!-- pagination -->
                    <ul class="tf-pagination-wrap tf-pagination-list tf-pagination-btn">
                        <li class="active">
                            <a href="#" class="pagination-link">1</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-link animate-hover-btn">2</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-link animate-hover-btn">3</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-link animate-hover-btn">4</a>
                        </li>
                        <li>
                            <a href="#" class="pagination-link animate-hover-btn">
                                <span class="icon icon-arrow-right"></span>
                            </a>
                        </li>
                    </ul>
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
@endsection
