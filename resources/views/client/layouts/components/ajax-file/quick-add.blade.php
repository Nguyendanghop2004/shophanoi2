<div class="tf-product-info-item">
    <div class="image">
        @foreach ($randomImages as $colorId => $image)
            @if ($image)
                <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $product->product_name }}"
                    class="product-image" data-color-id="{{ $colorId }}"
                    style="{{ $loop->first ? 'display: block;' : 'display: none;' }}">
            @endif
        @endforeach
    </div>

    <div class="content">
        <a href="product-detail.html">{{ $product->product_name }}</a>
        <div class="tf-product-info-price">
            <!-- <div class="price-on-sale">$8.00</div>
            <div class="compare-at-price">$10.00</div>
            <div class="badges-on-sale"><span>20</span>% OFF</div> -->
            <div class="price">${{ number_format($product->price, 2) }}</div>
        </div>
    </div>
</div>
<div class="tf-product-info-variant-picker mb_15">
    <div class="variant-picker-item">
        <div class="variant-picker-label">
            <div class="variant-picker-label">
                Color: <span class="fw-6 variant-picker-label-value" id="selected-color">Default Color</span>
            </div>
        </div>
        <div class="variant-picker-values">
            @foreach ($product->colors as $color)
                <input id="values-{{ $color->name }}" type="radio" name="color" class="btn-color"
                    data-color-id="{{ $color->id }}" data-color-name="{{ $color->name }}"
                    {{ $loop->first ? 'checked' : '' }}>
                <label class="hover-tooltip radius-60" for="values-{{ $color->name }}"
                    data-value="{{ $color->name }}">
                    <span class="btn-checkbox" style="background-color: {{ $color->sku_color }}"></span>
                    <span class="tooltip">{{ $color->name }}</span>
                </label>
            @endforeach
        </div>

    </div>

    <div class="variant-picker-item">
        <div class="variant-picker-label">
            Size: <span class="fw-6 variant-picker-label-value">S</span>
        </div>
        <div class="variant-picker-values" id="size-options-container">
            <!-- Các kích thước sẽ được thêm vào đây bằng JavaScript khi chọn màu -->
        </div>
    </div>

</div>
<div class="tf-product-info-quantity mb_15">
    <div class="quantity-title fw-6">Quantity</div>
    <div class="wg-quantity">
        <span class="btn-quantity minus-btn">-</span>
        <input type="text" name="quantity_product" value="1">
        <span class="btn-quantity plus-btn">+</span>
    </div>
</div>
<div class="tf-product-info-buy-button">
    <form class="">
        <a href="javascript:void(0);"
            class="tf-btn btn-fill justify-content-center fw-6 fs-16 flex-grow-1 animate-hover-btn btn-add-to-cart"><span>Add
                to cart -&nbsp;</span><span class="tf-qty-price">$18.00</span></a>
        <div class="tf-product-btn-wishlist btn-icon-action">
            <i class="icon-heart"></i>
            <i class="icon-delete"></i>
        </div>
        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
            class="tf-product-btn-wishlist box-icon bg_white compare btn-icon-action">
            <span class="icon icon-compare"></span>
            <span class="icon icon-check"></span>
        </a>
        <div class="w-100">
            <a href="#" class="btns-full">Buy with <img src="images/payments/paypal.png" alt=""></a>
            <a href="#" class="payment-more-option">More payment options</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Khi người dùng chọn màu
        $('.btn-color').click(function() {
            var colorName = $(this).data('color-name');
            $('#selected-color').text(colorName);

            var selectedColorId = $(this).data('color-id');

            // Ẩn tất cả ảnh và chỉ hiển thị ảnh của màu đã chọn
            $('.product-image').hide();
            $('.product-image[data-color-id="' + selectedColorId + '"]').show();

            // Cập nhật các kích thước tương ứng với màu được chọn
            updateSizeOptions(selectedColorId);
        });

        // Hiển thị màu và ảnh mặc định khi tải trang
        var defaultColorId = $('.btn-color:checked').data('color-id');
        $('#selected-color').text($('.btn-color:checked').data('color-name'));
        $('.product-image[data-color-id="' + defaultColorId + '"]').show();

        // Hiển thị kích thước mặc định của màu đầu tiên
        updateSizeOptions(defaultColorId);
    });

    // Hàm cập nhật các kích thước tương ứng với màu được chọn
    function updateSizeOptions(colorId) {
        var sizeOptions = @json($colorSizes); // Lấy dữ liệu từ server (size của các màu)
        var sizes = sizeOptions[colorId] || [];

        var sizeContainer = $('#size-options-container');
        sizeContainer.empty(); // Xóa các size cũ

        sizes.forEach(function(size) {
            var sizeElement = `
                <input type="radio" name="size" id="values-${size.name}-${colorId}" data-size-name="${size.name}">
                <label class="style-text" for="values-${size.name}-${colorId}" data-value="${size.name}">
                    <p>${size.name}</p>
                </label>
            `;
            sizeContainer.append(sizeElement); // Thêm các size vào container
        });
    }






</script>

<script>
  $('.btn-add-to-cart').click(function(e) {
    e.preventDefault();

    var productId = {{ $product->id }}; // ID sản phẩm
    var colorId = $('.btn-color:checked').data('color-id'); // ID màu sắc đã chọn
    var size = $('input[name="size"]:checked').data('size-name'); // Kích thước đã chọn
    var quantity = $('input[name="quantity_product"]').val(); // Số lượng

    // Kiểm tra xem tất cả thông tin có hợp lệ không
    if (!size) {
        alert('Please select a size.');
        return;
    }

    // In dữ liệu gửi đi vào Console
    console.log({
        product_id: productId,
        color_id: colorId,
        size: size,
        quantity: quantity
    });

    // Gửi yêu cầu Ajax đến route xử lý thêm vào giỏ hàng
    $.ajax({
        url: '/add-to-cart', // Route xử lý thêm sản phẩm vào giỏ hàng
        method: 'POST',
        data: {
            product_id: productId,
            color_id: colorId,
            size: size,
            quantity: quantity,
            _token: '{{ csrf_token() }}' // Thêm CSRF token để bảo mật yêu cầu
        },
        success: function(response) {
            if (response.success) {
                alert('Product added to cart successfully!');
                // Cập nhật giao diện nếu cần (ví dụ: số lượng sản phẩm trong giỏ hàng)
            } else {
                alert('Failed to add product to cart.');
            }
        },
        error: function() {
            alert('An error occurred. Please try again.');
        }
    });
});

</script>







<script>
    /**
 * selectImages
 * preloader
 * Scroll process
 * Button Quantity
 * Delete file
 * Go Top
 * color swatch product
 * change value
 * footer accordion
 * close announcement bar
 * sidebar mobile
 * tabs
 * flatAccordion
 * button wishlist
 * button loading
 * variant picker
 * switch layout
 * item checkbox
 * infinite scroll
 * stagger wrap
 * filter
 * modal second
 * header sticky
 * header change background
 * img group
 * contact form
 * subscribe mailchimp
 * auto popup

 */


    (function($) {
        "use strict";

        var isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function() {
                return (
                    isMobile.Android() ||
                    isMobile.BlackBerry() ||
                    isMobile.iOS() ||
                    isMobile.Opera() ||
                    isMobile.Windows()
                );
            },
        };

        /* selectImages
        -------------------------------------------------------------------------------------*/
        var selectImages = function() {
            if ($(".image-select").length > 0) {
                const selectIMG = $(".image-select");
                selectIMG.find("option").each((idx, elem) => {
                    const selectOption = $(elem);
                    const imgURL = selectOption.attr("data-thumbnail");
                    if (imgURL) {
                        selectOption.attr(
                            "data-content",
                            "<img src='%i'/> %s"
                            .replace(/%i/, imgURL)
                            .replace(/%s/, selectOption.text())
                        );
                    }
                });
                selectIMG.selectpicker();
            }
        };

        /* preloader
        -------------------------------------------------------------------------------------*/
        const preloader = function() {
            if ($("body").hasClass("preload-wrapper")) {
                setTimeout(function() {
                    $(".preload").fadeOut("slow", function() {
                        $(this).remove();
                    });
                }, 100);
            }

        };

        /* Scroll process
        -------------------------------------------------------------------------------------*/
        var scrollProgress = function() {
            $(".scroll-snap").on("scroll", function() {
                var val = $(this).scrollLeft();
                $(".value-process").css("width", `max(30%,${val}%)`);
            });
        };

        /* Button Quantity
        -------------------------------------------------------------------------------------*/
        var btnQuantity = function() {
            $(".minus-btn").on("click", function(e) {
                e.preventDefault();
                var $this = $(this);
                var $input = $this.closest("div").find("input");
                var value = parseInt($input.val());

                if (value > 1) {
                    value = value - 1;
                }
                $input.val(value);
            });

            $(".plus-btn").on("click", function(e) {
                e.preventDefault();
                var $this = $(this);
                var $input = $this.closest("div").find("input");
                var value = parseInt($input.val());

                if (value > -1) {
                    value = value + 1;
                }
                $input.val(value);
            });
        };

        /* Delete file
        -------------------------------------------------------------------------------------*/
        var delete_file = function(e) {
            $(".remove").on("click", function(e) {
                e.preventDefault();
                var $this = $(this);
                $this.closest(".file-delete").remove();
            });
        };

        /* Go Top
        -------------------------------------------------------------------------------------*/
        var goTop = function() {
            if ($("div").hasClass("progress-wrap")) {
                var progressPath = document.querySelector(".progress-wrap path");
                var pathLength = progressPath.getTotalLength();
                progressPath.style.transition = progressPath.style.WebkitTransition =
                    "none";
                progressPath.style.strokeDasharray = pathLength + " " + pathLength;
                progressPath.style.strokeDashoffset = pathLength;
                progressPath.getBoundingClientRect();
                progressPath.style.transition = progressPath.style.WebkitTransition =
                    "stroke-dashoffset 10ms linear";
                var updateprogress = function() {
                    var scroll = $(window).scrollTop();
                    var height = $(document).height() - $(window).height();
                    var progress = pathLength - (scroll * pathLength) / height;
                    progressPath.style.strokeDashoffset = progress;
                };
                updateprogress();
                $(window).scroll(updateprogress);
                var offset = 200;
                var duration = 0;
                jQuery(window).on("scroll", function() {
                    if (jQuery(this).scrollTop() > offset) {
                        jQuery(".progress-wrap").addClass("active-progress");
                    } else {
                        jQuery(".progress-wrap").removeClass("active-progress");
                    }
                });
                jQuery(".progress-wrap").on("click", function(event) {
                    event.preventDefault();
                    jQuery("html, body").animate({
                        scrollTop: 0
                    }, duration);
                    return false;
                });
            }
        };

        /* color swatch product
        -------------------------------------------------------------------------*/
        var swatchColor = function() {
            if ($(".card-product").length > 0) {
                $(".color-swatch").on("click, mouseover", function() {
                    var swatchColor = $(this).find("img").attr("src");
                    var imgProduct = $(this).closest(".card-product").find(".img-product");
                    imgProduct.attr("src", swatchColor);
                    $(this)
                        .closest(".card-product")
                        .find(".color-swatch.active")
                        .removeClass("active");

                    $(this).addClass("active");
                });
            }
        };

        /* change value
        ------------------------------------------------------------------------------------- */
        var changeValue = function() {
            if ($(".tf-dropdown-sort").length > 0) {
                $(".select-item").click(function(event) {
                    $(this)
                        .closest(".tf-dropdown-sort")
                        .find(".text-sort-value")
                        .text($(this).find(".text-value-item").text());

                    $(this)
                        .closest(".dropdown-menu")
                        .find(".select-item.active")
                        .removeClass("active");

                    $(this).addClass("active");
                });
            }
        };

        /* footer accordion
        -------------------------------------------------------------------------*/
        var footer = function() {
            var args = {
                duration: 250
            };
            $(".footer-heading-moblie").on("click", function() {
                $(this).parent(".footer-col-block").toggleClass("open");
                if (!$(this).parent(".footer-col-block").is(".open")) {
                    $(this).next().slideUp(args);
                } else {
                    $(this).next().slideDown(args);
                }
            });
        };

        /* close announcement bar
        -------------------------------------------------------------------------*/
        var closeAnnouncement = function() {
            $(".close-announcement-bar").on("click", function(e) {
                e.preventDefault();
                var $this = $(this);
                var $height = $(".announcement-bar").height() + "px";
                $this.closest(".announcement-bar").css("margin-top", `-${$height}`);

                $(".announcement-bar").fadeOut("slow", function() {
                    $this.closest(".announcement-bar").remove();
                });
            });
        };

        /* range
        -------------------------------------------------------------------------*/
        var rangePrice = function() {
            const rangeInput = document.querySelectorAll('.range-input input')
            const progress = document.querySelector('.progress-price')
            const minPrice = document.querySelector('.min-price')
            const maxPrice = document.querySelector('.max-price')

            let priceGap = 10

            rangeInput.forEach(input => {
                input.addEventListener('input', e => {
                    let minValue = parseInt(rangeInput[0].value, 10)
                    let maxValue = parseInt(rangeInput[1].value, 10)

                    if (maxValue - minValue < priceGap) {
                        if (e.target.class === 'range-min') {
                            rangeInput[0].value = maxValue - priceGap
                        } else {
                            rangeInput[1].value = minValue + priceGap
                        }
                    } else {
                        progress.style.left = (minValue / rangeInput[0].max) * 100 + "%";
                        progress.style.right = 100 - (maxValue / rangeInput[1].max) * 100 + "%";
                    }

                    minPrice.innerHTML = minValue
                    maxPrice.innerHTML = maxValue

                    if (minValue >= 290) {
                        minPrice.innerHTML = 290
                    }

                    if (maxValue <= 10) {
                        maxPrice.innerHTML = 10
                    }
                })
            })

        }

        /* sidebar mobile
        -------------------------------------------------------------------------*/
        var sidebar_mb = function() {
            if ($(".wrap-sidebar-mobile").length > 0) {
                var sidebar = $(".wrap-sidebar-mobile").html();
                $(".sidebar-mobile-append").append(sidebar);
                // $(".wrap-sidebar-mobile").remove();
            }
        };

        /* tabs
        -------------------------------------------------------------------------*/
        var tabs = function() {
            $(".widget-tabs").each(function() {
                $(this)
                    .find(".widget-menu-tab")
                    .children(".item-title")
                    .on("click", function() {
                        var liActive = $(this).index();
                        var contentActive = $(this)
                            .siblings()
                            .removeClass("active")
                            .parents(".widget-tabs")
                            .find(".widget-content-tab")
                            .children()
                            .eq(liActive);
                        contentActive.addClass("active").fadeIn("slow");
                        contentActive.siblings().removeClass("active");
                        $(this)
                            .addClass("active")
                            .parents(".widget-tabs")
                            .find(".widget-content-tab")
                            .children()
                            .eq(liActive);
                    });
            });
        };

        /* flatAccordion
        -------------------------------------------------------------------------*/
        var flatAccordion = function(class1, class2) {
            var args = {
                duration: 200
            };

            $(class2 + " .toggle-title.active")
                .siblings(".toggle-content")
                .show();
            $(class1 + " .toggle-title").on("click", function() {
                $(class1 + " " + class2).removeClass("active");
                $(this).closest(class2).toggleClass("active");

                if (!$(this).is(".active")) {
                    // $(this)
                    //   .closest(class1)
                    //   .find(".toggle-title.active")
                    //   .toggleClass("active")
                    //   .next()
                    //   .slideToggle(args);
                    $(this).toggleClass("active");
                    $(this).next().slideToggle(args);
                } else {
                    $(class1 + " " + class2).removeClass("active");
                    $(this).toggleClass("active");
                    $(this).next().slideToggle(args);
                }
            });
        };

        /* button wishlist
        -------------------------------------------------------------------------*/
        var btn_wishlist = function() {
            if ($(".btn-icon-action").length) {
                $(".btn-icon-action").on("click", function(e) {
                    $(this).toggleClass("active");
                });
            }
        };

        /* button loading
        -------------------------------------------------------------------------*/
        var btn_loading = function() {
            if ($(".tf-btn-loading").length) {
                $(".tf-btn-loading").on("click", function(e) {
                    $(this).addClass("loading");
                    var $this = $(this);
                    setTimeout(function() {
                        $this.removeClass("loading");
                    }, 600);
                });
            }
        };

        /* variant picker
        -------------------------------------------------------------------------*/
        var variant_picker = function() {
            if ($(".variant-picker-item").length) {
                $(".variant-picker-item label").on("click", function(e) {
                    $(this)
                        .closest(".variant-picker-item")
                        .find(".variant-picker-label-value")
                        .text($(this).data("value"));
                });
            }
        };

        /* switch layout
        -------------------------------------------------------------------------*/
        var switchLayout = function() {
            if ($(".tf-control-layout").length > 0) {
                $(".tf-view-layout-switch").on("click", function() {
                    var value = $(this).data("value-grid");
                    $(".grid-layout").attr("data-grid", value);
                    $(this)
                        .closest(".tf-control-layout")
                        .find(".tf-view-layout-switch.active")
                        .removeClass("active");

                    $(this).addClass("active");
                });
                if (matchMedia("only screen and (max-width: 1150px)").matches) {
                    $(".tf-view-layout-switch.active").removeClass("active");
                    $(".sw-layout-3").addClass("active");
                }
                if (matchMedia("only screen and (max-width: 768px)").matches) {
                    $(".tf-view-layout-switch.active").removeClass("active");
                    $(".sw-layout-2").addClass("active");
                }
            }
        };

        /* item checkbox
        -------------------------------------------------------------------------*/
        var item_checkox = function() {
            if ($(".item-has-checkox").length) {
                $(".item-has-checkox input:checkbox").on("click", function(e) {
                    $(this).closest(".item-has-checkox").toggleClass("check");
                });
            }
        };

        /* infinite scroll
        -------------------------------------------------------------------------*/
        var infiniteScroll = function() {
            $(".fl-item").slice(0, 8).show();
            $(".fl-item2").slice(0, 8).show();
            $(".fl-item3").slice(0, 8).show();

            if ($(".scroll-loadmore").length > 0) {
                $(window).scroll(function() {
                    if (
                        $(window).scrollTop() >=
                        $(document).height() - $(window).height()
                    ) {
                        setTimeout(() => {
                            $(".fl-item:hidden").slice(0, 4).show();
                            if ($(".fl-item:hidden").length == 0) {
                                $(".view-more-button").hide();
                            }
                        }, 0);
                    }
                });
            }
            if ($(".loadmore-item").length > 0) {
                $(".btn-loadmore").on("click", function() {
                    setTimeout(() => {
                        $(".fl-item:hidden").slice(0, 4).show();
                        if ($(".fl-item:hidden").length == 0) {
                            $(".view-more-button").hide();
                        }
                    }, 600);
                });
            }
            if ($(".loadmore-item2").length > 0) {
                $(".btn-loadmore2").on("click", function() {
                    setTimeout(() => {
                        $(".fl-item2:hidden").slice(0, 4).show();
                        if ($(".fl-item2:hidden").length == 0) {
                            $(".view-more-button2").hide();
                        }
                    }, 600);
                });
            }
            if ($(".loadmore-item3").length > 0) {
                $(".btn-loadmore3").on("click", function() {
                    setTimeout(() => {
                        $(".fl-item3:hidden").slice(0, 4).show();
                        if ($(".fl-item3:hidden").length == 0) {
                            $(".view-more-button3").hide();
                        }
                    }, 600);
                });
            }
        };
        /* stagger wrap
        -------------------------------------------------------------------------*/
        var stagger_wrap = function() {
            if ($(".stagger-wrap").length) {
                var count = $(".stagger-item").length;
                // $(".stagger-item").addClass("stagger-finished");
                for (var i = 1, time = 0.2; i <= count; i++) {
                    $(".stagger-item:nth-child(" + i + ")")
                        .css("transition-delay", time * i + "s")
                        .addClass("stagger-finished");
                }
            }
        };

        /* filter
        -------------------------------------------------------------------------*/
        var filterTab = function() {
            var $btnFilter = $('.tf-btns-filter').click(function() {
                if (this.id == 'all') {
                    $('#parent > div').show();
                } else {
                    var $el = $('.' + this.id).show();
                    $('#parent > div').not($el).hide();
                }
                $btnFilter.removeClass('is--active');
                $(this).addClass('is--active');
            })
        };

        /* modal second
        -------------------------------------------------------------------------*/
        var clickModalSecond = function() {
            $(".btn-choose-size").click(function() {
                $("#find_size").modal("show");
            });
            $(".btn-show-quickview").click(function() {
                $("#quick_view").modal("show");
            });
            $(".btn-add-to-cart").click(function() {
                $("#shoppingCart").modal("show");
            });

            $(".btn-add-note").click(function() {
                $(".add-note").addClass("open");
            });
            $(".btn-add-gift").click(function() {
                $(".add-gift").addClass("open");
            });
            $(".btn-estimate-shipping").click(function() {
                $(".estimate-shipping").addClass("open");
            });
            $(".tf-mini-cart-tool-close ,.tf-mini-cart-tool-close .overplay").click(
                function() {
                    $(".tf-mini-cart-tool-openable").removeClass("open");
                }
            );
        };

        /* header sticky
        -------------------------------------------------------------------------*/
        var headerSticky = function() {
            let didScroll;
            let lastScrollTop = 0;
            let delta = 5;
            let navbarHeight = $("header").outerHeight();
            $(window).scroll(function(event) {
                didScroll = true;
            });

            setInterval(function() {
                if (didScroll) {
                    let st = $(this).scrollTop();

                    // Make scroll more than delta
                    if (Math.abs(lastScrollTop - st) <= delta) return;
                    // If scrolled down and past the navbar, add class .nav-up.
                    if (st > lastScrollTop && st > navbarHeight) {
                        // Scroll Down
                        $("header").css("top", `-${navbarHeight}px`)
                    } else {
                        // Scroll Up
                        if (st + $(window).height() < $(document).height()) {
                            $("header").css("top", "0px");
                        }
                    }
                    lastScrollTop = st;
                    didScroll = false;
                }
            }, 250);
        };

        /* header change background
        -------------------------------------------------------------------------*/
        var headerChangeBg = function() {
            $(window).on("scroll", function() {
                if ($(window).scrollTop() > 100) {
                    $("header").addClass("header-bg");
                } else {
                    $("header").removeClass("header-bg");
                }
            });
        }
        /* img group
  -------------------------------------------------------------------------*/
        var img_group = function() {
            if ($(".filter-images-group").length) {
                var number = $(".images-group-item").length;
                if ($(".filter-images-group").length)
                    var btn_first = $(".images-group-btn-first").data("images-group");
                for (let i = 1; i <= number; i++) {
                    var images_group_item = $(".filter-images-group").find(".images-group-item:nth-child(" + i +
                        ")").data("value");
                    if (images_group_item === btn_first) {
                        $(".filter-images-group").find(".images-group-item:nth-child(" + i + ")").addClass(
                            "active").removeClass("hidden")
                    } else(
                        $(".filter-images-group").find(".images-group-item:nth-child(" + i + ")").addClass(
                            "hidden").removeClass("active")
                    )
                }
                $(".images-group-btn").on("click", function() {
                    var images_group_btn = $(this).data("images-group");
                    for (let i = 1; i <= number; i++) {
                        var images_group_item = $(".filter-images-group").find(
                            ".images-group-item:nth-child(" + i + ")").data("value");
                        if (images_group_item === images_group_btn) {
                            $(".filter-images-group").find(".images-group-item:nth-child(" + i + ")")
                                .addClass("active").removeClass("hidden")
                        } else(
                            $(".filter-images-group").find(".images-group-item:nth-child(" + i +
                                ")").addClass("hidden").removeClass("active")
                        )
                    }
                });
            }

        };

        /* contact form
        ------------------------------------------------------------------------------------- */
        var ajaxContactForm = function() {
            $("#contactform").each(function() {
                $(this).validate({
                    submitHandler: function(form) {
                        var $form = $(form),
                            str = $form.serialize(),
                            loading = $("<div />", {
                                class: "loading"
                            });

                        $.ajax({
                            type: "POST",
                            url: $form.attr("action"),
                            data: str,
                            beforeSend: function() {
                                $form.find(".send-wrap").append(loading);
                            },
                            success: function(msg) {
                                var result, cls;
                                if (msg == "Success") {
                                    result =
                                        "Email Sent Successfully. Thank you, Your application is accepted - we will contact you shortly";
                                    cls = "msg-success";
                                } else {
                                    result = "Error sending email.";
                                    cls = "msg-error";
                                }
                                $form.prepend(
                                    $("<div />", {
                                        class: "flat-alert " + cls,
                                        text: result,
                                    }).append(
                                        $(
                                            '<a class="close" href="#"><i class="icon icon-close2"></i></a>'
                                        )
                                    )
                                );

                                $form.find(":input").not(".submit").val("");
                            },
                            complete: function(xhr, status, error_thrown) {
                                $form.find(".loading").remove();
                            },
                        });
                    },
                });
            }); // each contactform
        };

        /* subscribe mailchimp
        ------------------------------------------------------------------------------------- */
        var ajaxSubscribe = {
            obj: {
                subscribeEmail: $("#subscribe-email"),
                subscribeButton: $("#subscribe-button"),
                subscribeMsg: $("#subscribe-msg"),
                subscribeContent: $("#subscribe-content"),
                dataMailchimp: $("#subscribe-form").attr("data-mailchimp"),
                success_message: '<div class="notification_ok">Thank you for joining our mailing list!</div>',
                failure_message: '<div class="notification_error">Error! <strong>There was a problem processing your submission.</strong></div>',
                noticeError: '<div class="notification_error">{msg}</div>',
                noticeInfo: '<div class="notification_error">{msg}</div>',
                basicAction: "mail/subscribe.php",
                mailChimpAction: "mail/subscribe-mailchimp.php",
            },

            eventLoad: function() {
                var objUse = ajaxSubscribe.obj;

                $(objUse.subscribeButton).on("click", function() {
                    if (window.ajaxCalling) return;
                    var isMailchimp = objUse.dataMailchimp === "true";

                    // if (isMailchimp) {
                    //   ajaxSubscribe.ajaxCall(objUse.mailChimpAction);
                    // } else {
                    //   ajaxSubscribe.ajaxCall(objUse.basicAction);
                    // }
                    ajaxSubscribe.ajaxCall(objUse.basicAction);
                });
            },

            ajaxCall: function(action) {
                window.ajaxCalling = true;
                var objUse = ajaxSubscribe.obj;
                var messageDiv = objUse.subscribeMsg.html("").hide();
                $.ajax({
                    url: action,
                    type: "POST",
                    dataType: "json",
                    data: {
                        subscribeEmail: objUse.subscribeEmail.val(),
                    },
                    success: function(responseData, textStatus, jqXHR) {
                        if (responseData.status) {
                            objUse.subscribeContent.fadeOut(500, function() {
                                messageDiv.html(objUse.success_message).fadeIn(500);
                            });
                        } else {
                            switch (responseData.msg) {
                                case "email-required":
                                    messageDiv.html(
                                        objUse.noticeError.replace(
                                            "{msg}",
                                            "Error! <strong>Email is required.</strong>"
                                        )
                                    );
                                    break;
                                case "email-err":
                                    messageDiv.html(
                                        objUse.noticeError.replace(
                                            "{msg}",
                                            "Error! <strong>Email invalid.</strong>"
                                        )
                                    );
                                    break;
                                case "duplicate":
                                    messageDiv.html(
                                        objUse.noticeError.replace(
                                            "{msg}",
                                            "Error! <strong>Email is duplicate.</strong>"
                                        )
                                    );
                                    break;
                                case "filewrite":
                                    messageDiv.html(
                                        objUse.noticeInfo.replace(
                                            "{msg}",
                                            "Error! <strong>Mail list file is open.</strong>"
                                        )
                                    );
                                    break;
                                case "undefined":
                                    messageDiv.html(
                                        objUse.noticeInfo.replace(
                                            "{msg}",
                                            "Error! <strong>undefined error.</strong>"
                                        )
                                    );
                                    break;
                                case "api-error":
                                    objUse.subscribeContent.fadeOut(500, function() {
                                        messageDiv.html(objUse.failure_message);
                                    });
                            }
                            messageDiv.fadeIn(500);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Connection error");
                    },
                    complete: function(data) {
                        window.ajaxCalling = false;
                    },
                });
            },
        };

        /* auto popup
        ------------------------------------------------------------------------------------- */
        var autoPopup = function() {
            if ($("body").hasClass("popup-loader")) {
                if ($(".auto-popup").length > 0) {
                    let showPopup = sessionStorage.getItem("showPopup");
                    if (!JSON.parse(showPopup)) {
                        setTimeout(function() {
                            $(".auto-popup").modal('show');
                        }, 3000);
                    }
                }
                $(".btn-hide-popup").on("click", function() {
                    sessionStorage.setItem("showPopup", true);
                });
            };

        };
        /* toggle control
        ------------------------------------------------------------------------------------- */
        var clickControl = function() {
            // var args = { duration: 500 };

            $(".btn-address").click(function() {
                $(".show-form-address").toggle();
            });
            $(".btn-hide-address").click(function() {
                $(".show-form-address").hide();
            });
            $(".btn-edit-address").click(function() {
                $(".edit-form-address").toggle();
            });
            $(".btn-hide-edit-address").click(function() {
                $(".edit-form-address").hide();
            });
        };

        // Dom Ready
        $(function() {
            selectImages();
            btnQuantity();
            delete_file();
            goTop();
            closeAnnouncement();
            preloader();
            sidebar_mb();
            tabs();
            flatAccordion(".flat-accordion", ".flat-toggle");
            flatAccordion(".flat-accordion1", ".flat-toggle1");
            flatAccordion(".flat-accordion2", ".flat-toggle2");
            swatchColor();
            changeValue();
            footer();
            btn_wishlist();
            btn_loading();
            variant_picker();
            switchLayout();
            item_checkox();
            infiniteScroll();
            stagger_wrap();
            clickModalSecond();
            scrollProgress();
            headerSticky();
            headerChangeBg();
            img_group();
            filterTab();
            ajaxContactForm();
            ajaxSubscribe.eventLoad();
            autoPopup();
            rangePrice();
            clickControl();
            new WOW().init();
        });
    })(jQuery);
    btn - add - to - cart
</script>
