<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Ecomus - Ultimate HTML</title>

    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- font -->
    <link rel="stylesheet" href="{{ asset('client/assets/fonts/fonts.css') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('client/assets/fonts/font-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('client/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/assets/css/animate.css') }}">
    <link rel="stylesheet"type="text/css" href="{{ asset('client/assets/css/styles.css') }}" />

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{ asset('client/assets/images/logo/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('client/assets/images/logo/favicon.png') }}">

</head>

<body class="preload-wrapper">
    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div id="wrapper">
        @yield('topbar')
        @hasSection('header-home')
            @yield('header-home')
        @else
            <!-- Header mặc định cho các trang khác -->
            @include('client.layouts.particals.header-default')
        @endif

        @yield('content')
        <!-- /categories -->

        <!-- footer -->
        @include('client.layouts.particals.footer')
        <!-- /footer -->

    </div>
    @yield('product-detail')
    <!-- gotop -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;">
            </path>
        </svg>
    </div>
    <!-- /gotop -->

    <!-- toolbar-bottom mobile-->
    @include('client.layouts.components.mobile.tool-bar-bot-mobile')
    <!-- /toolbar-bottom -->

    <!-- mobile menu -->
    @include('client.layouts.components.mobile.menu-mobile')
    <!-- /mobile menu -->

    <!-- canvasSearch -->
    @include('client.layouts.components.modal.canvas-search')
    <!-- /canvasSearch -->

    <!-- toolbarShopmb mobile-->
    @include('client.layouts.components.mobile.tool-bar-mobile')
    <!-- /toolbarShopmb -->

    <!-- modal login -->
    @include('client.layouts.components.modal.modal-login')
    <!-- /modal login -->

    <!-- shoppingCart -->
    @include('client.layouts.components.modal.shopping-cart')
    <!-- /shoppingCart -->

    <!-- modal compare -->
    @include('client.layouts.components.modal.modal-compare')
    <!-- /modal compare -->

    <!-- modal quick_add -->
    @include('client.layouts.components.modal.modal-quick-add')
    <!-- /modal quick_add -->

    <!-- modal quick_view -->
    @include('client.layouts.components.modal.modal-quick-view')
    <!-- /modal quick_view -->

    <!-- modal find_size -->
    @include('client.layouts.components.modal.modal-fine-size')
    <!-- /modal find_size -->

    <!-- Javascript -->
    <script type="text/javascript" src="{{ asset('client/assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/lazysize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/count-down.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/multiple-modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
