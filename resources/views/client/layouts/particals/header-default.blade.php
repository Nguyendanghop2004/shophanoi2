
 <!-- Header -->
 
 <header id="header" class="header-default">

    
    <div class="px_15 lg-px_40">
        <div class="row wrapper-header align-items-center">
            <div class="col-md-4 col-3 tf-lg-hidden">
                <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16"
                        fill="none">
                        <path
                            d="M2.00056 2.28571H16.8577C17.1608 2.28571 17.4515 2.16531 17.6658 1.95098C17.8802 1.73665 18.0006 1.44596 18.0006 1.14286C18.0006 0.839753 17.8802 0.549063 17.6658 0.334735C17.4515 0.120408 17.1608 0 16.8577 0H2.00056C1.69745 0 1.40676 0.120408 1.19244 0.334735C0.978109 0.549063 0.857702 0.839753 0.857702 1.14286C0.857702 1.44596 0.978109 1.73665 1.19244 1.95098C1.40676 2.16531 1.69745 2.28571 2.00056 2.28571ZM0.857702 8C0.857702 7.6969 0.978109 7.40621 1.19244 7.19188C1.40676 6.97755 1.69745 6.85714 2.00056 6.85714H22.572C22.8751 6.85714 23.1658 6.97755 23.3801 7.19188C23.5944 7.40621 23.7148 7.6969 23.7148 8C23.7148 8.30311 23.5944 8.59379 23.3801 8.80812C23.1658 9.02245 22.8751 9.14286 22.572 9.14286H2.00056C1.69745 9.14286 1.40676 9.02245 1.19244 8.80812C0.978109 8.59379 0.857702 8.30311 0.857702 8ZM0.857702 14.8571C0.857702 14.554 0.978109 14.2633 1.19244 14.049C1.40676 13.8347 1.69745 13.7143 2.00056 13.7143H12.2863C12.5894 13.7143 12.8801 13.8347 13.0944 14.049C13.3087 14.2633 13.4291 14.554 13.4291 14.8571C13.4291 15.1602 13.3087 15.4509 13.0944 15.6653C12.8801 15.8796 12.5894 16 12.2863 16H2.00056C1.69745 16 1.40676 15.8796 1.19244 15.6653C0.978109 15.4509 0.857702 15.1602 0.857702 14.8571Z"
                            fill="currentColor"></path>
                    </svg>
                </a>
            </div>
            <div class="col-xl-3 col-md-4 col-6">
                <a href="index.html" class="logo-header">
                    <img src="{{ asset('client/assets/images/logo/logo.svg') }}" alt="logo" class="logo">
                </a>
            </div>
            
            <div class="col-xl-6 tf-md-hidden">
               <!-- list menu -->
               @include('client.layouts.particals.menu')
               <!-- list menu -->
            </div>
            <div class="col-xl-3 col-md-4 col-3">
                  <!-- chu y -->
                <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">
                    <li class="nav-search"><a href="#canvasSearch" data-bs-toggle="offcanvas"
                            aria-controls="offcanvasLeft" class="nav-icon-item"><i class="icon icon-search"></i></a>
                    </li>
                    <li class="nav-account"><a href="#login" data-bs-toggle="modal" class="nav-icon-item"><i
                                class="icon icon-account"></i></a></li>
                    <li class="nav-cart"><a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item"><i
                                class="icon icon-bag"></i><span class="count-box">0</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</header>



<!-- announcement-bar -->

<style>
    /* Custom search form styles */
    .search-form {
        position: relative;
    }

    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input {
        width: 100%;
        max-width: 400px;
        height: 40px;
        padding: 0 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .search-button {
        position: absolute;
        right: 30px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }

    .icon-search {
        font-size: 20px;
        color: #333;
    }

    #searchError {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 14px;
    }
</style>
<div class="announcement-bar bg_dark">
    <div class="wrap-announcement-bar">
        <div class="box-sw-announcement-bar">
            <div class="announcement-bar-item">
                <p>MIỄN PHÍ VẬN CHUYỂN VÀ HOÀN TRẢ</p>
            </div>
            <div class="announcement-bar-item">
                <p>MÙA MỚI, KIỂU DÁNG MỚI: KHUYẾN MÃI THỜI TRANG KHÔNG THỂ BỎ LỠ</p>
            </div>
            <div class="announcement-bar-item">
                <p>ƯU ĐÃI CÓ THỜI GIAN GIỚI HẠN: KHUYẾN MÃI THỜI TRANG KHÔNG THỂ CƯỠNG LẠI</p>
            </div>
            <div class="announcement-bar-item">
                <p>MIỄN PHÍ VẬN CHUYỂN VÀ HOÀN TRẢ</p>
            </div>
            <div class="announcement-bar-item">
                <p>MÙA MỚI, KIỂU DÁNG MỚI: KHUYẾN MÃI THỜI TRANG KHÔNG THỂ BỎ LỠ</p>
            </div>
            <div class="announcement-bar-item">
                <p>ƯU ĐÃI CÓ THỜI GIAN GIỚI HẠN: KHUYẾN MÃI THỜI TRANG KHÔNG THỂ CƯỠNG LẠI</p>
            </div>
            <div class="announcement-bar-item">
                <p>MIỄN PHÍ VẬN CHUYỂN VÀ HOÀN TRẢ</p>
            </div>
            <div class="announcement-bar-item">
                <p>MÙA MỚI, KIỂU DÁNG MỚI: KHUYẾN MÃI THỜI TRANG KHÔNG THỂ BỎ LỠ</p>
            </div>
            <div class="announcement-bar-item">
                <p>ƯU ĐÃI CÓ THỜI GIAN GIỚI HẠN: KHUYẾN MÃI THỜI TRANG KHÔNG THỂ CƯỠNG LẠI</p>
            </div>
            <div class="announcement-bar-item">
                <p>MIỄN PHÍ VẬN CHUYỂN VÀ HOÀN TRẢ</p>
            </div>
            <div class="announcement-bar-item">
                <p>MÙA MỚI, KIỂU DÁNG MỚI: KHUYẾN MÃI THỜI TRANG KHÔNG THỂ BỎ LỠ</p>
            </div>
            <div class="announcement-bar-item">
                <p>ƯU ĐÃI CÓ THỜI GIAN GIỚI HẠN: KHUYẾN MÃI THỜI TRANG KHÔNG THỂ CƯỠNG LẠI</p>
            </div>
            <div class="announcement-bar-item">
                <p>MIỄN PHÍ VẬN CHUYỂN VÀ HOÀN TRẢ</p>
            </div>
            <div class="announcement-bar-item">
                <p>MÙA MỚI, KIỂU DÁNG MỚI: KHUYẾN MÃI THỜI TRANG KHÔNG THỂ BỎ LỠ</p>
            </div>
            <div class="announcement-bar-item">
                <p>ƯU ĐÃI CÓ THỜI GIAN GIỚI HẠN: KHUYẾN MÃI THỜI TRANG KHÔNG THỂ CƯỠNG LẠI</p>
            </div>
        </div>
    </div>

    <span class="icon-close close-announcement-bar"></span>

</div>
<!-- /announcement-bar -->
<!-- header -->
<header id="header" class="header-default header-style-2">
    <div class="main-header line">
        <div class="container-full px_15 lg-px_40">
            <div class="row wrapper-header align-items-center">
                <div class="col-xl-5 tf-md-hidden">
                    <ul class="header-list-categories">
                        <!-- cate -->
                        @include('client.layouts.particals.navleft')
                        <!-- cate -->
                    </ul>
                </div>
                <div class="col-md-4 col-3 tf-lg-hidden">
                    <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16"
                            fill="none">
                            <path
                                d="M2.00056 2.28571H16.8577C17.1608 2.28571 17.4515 2.16531 17.6658 1.95098C17.8802 1.73665 18.0006 1.44596 18.0006 1.14286C18.0006 0.839753 17.8802 0.549063 17.6658 0.334735C17.4515 0.120408 17.1608 0 16.8577 0H2.00056C1.69745 0 1.40676 0.120408 1.19244 0.334735C0.978109 0.549063 0.857702 0.839753 0.857702 1.14286C0.857702 1.44596 0.978109 1.73665 1.19244 1.95098C1.40676 2.16531 1.69745 2.28571 2.00056 2.28571ZM0.857702 8C0.857702 7.6969 0.978109 7.40621 1.19244 7.19188C1.40676 6.97755 1.69745 6.85714 2.00056 6.85714H22.572C22.8751 6.85714 23.1658 6.97755 23.3801 7.19188C23.5944 7.40621 23.7148 7.6969 23.7148 8C23.7148 8.30311 23.5944 8.59379 23.3801 8.80812C23.1658 9.02245 22.8751 9.14286 22.572 9.14286H2.00056C1.69745 9.14286 1.40676 9.02245 1.19244 8.80812C0.978109 8.59379 0.857702 8.30311 0.857702 8ZM0.857702 14.8571C0.857702 14.554 0.978109 14.2633 1.19244 14.049C1.40676 13.8347 1.69745 13.7143 2.00056 13.7143H12.2863C12.5894 13.7143 12.8801 13.8347 13.0944 14.049C13.3087 14.2633 13.4291 14.554 13.4291 14.8571C13.4291 15.1602 13.3087 15.4509 13.0944 15.6653C12.8801 15.8796 12.5894 16 12.2863 16H2.00056C1.69745 16 1.40676 15.8796 1.19244 15.6653C0.978109 15.4509 0.857702 15.1602 0.857702 14.8571Z"
                                fill="currentColor"></path>
                        </svg>
                    </a>
                </div>
                <div class="col-xl-2 col-md-4 col-6 text-center" style="max-width:80%;">

                    <a href="home-multi-brand.html" class="logo-header">
                        <a href="{{ route('home') }}" class="logo-header">
                            <img src="{{ asset('client/assets/images/logo/logo4.png') }}" alt="logo" class="logo">
                        </a>
                </div>


                <div class="col-xl-5 col-md-4 col-3">


                    <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">
                        <li class="nav-search">
                            <form action="{{ route('order.search') }}" method="GET" class="search-form"
                                onsubmit="return validateSearchForm()">
                                <div class="search-input-wrapper">
                                    <input type="text" name="query" id="searchQuery" placeholder="Search orders..."
                                        class="search-input">
                                    <button class="nav-icon-item search-button" type="submit">
                                        <i class="icon icon-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>

                        <!-- Thông báo lỗi -->
                     
                        @include('client.layouts.particals.navright')
                       
                        <div id="searchError" class="alert alert-danger" style="display: none;">
                            Vui lòng nhập từ khóa tìm kiếm
                            @include('client.layouts.particals.navright')
                        </div>
                        <li class="nav-notify">
                            <div class="btn-group">
                                <a class="icon icon-notify" data-bs-toggle="dropdown" aria-expanded="false">
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="notification-icon">
                                                <i class="icon icon-notify"></i>
                                            </div>
                                            <div class="notification-content">
                                                <p class="notification-title">Thông báo 1</p>
                                                <span class="notification-time">1 phút trước</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="notification-icon">
                                                <i class="icon icon-notify"></i>
                                            </div>
                                            <div class="notification-content">
                                                <p class="notification-title">Thông báo 2</p>
                                                <span class="notification-time">10 phút trước</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="notification-icon">
                                                <i class="icon icon-notify"></i>
                                            </div>
                                            <div class="notification-content">
                                                <p class="notification-title">Thông báo 3</p>
                                                <span class="notification-time">30 phút trước</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li class="text-center">
                                        <a class="dropdown-item text-primary" href="#">Xem tất cả thông báo</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-wishlist">
                            <a href="{{ route('wishlist') }}" class="nav-icon-item">
                                <i class="icon icon-heart"></i>

                                <span class="count-box">{{$wishlistCount}}</span>
                            </a>
                        </li>
                        <li class="nav-cart">
                            <a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item">
                                <i class="icon icon-bag"></i>
                                <span class="count-box cart-count">0</span>
                            </a>
                        </li>
                    </ul>
                </div>




            </div>

        </div>


        <div class="header-bottom line">
            <div class="container-full px_15 lg-px_40">
                <div class="wrapper-header d-flex justify-content-center align-items-center">
                    <!-- list menu -->
                    @include('client.layouts.particals.menu')
                    <!-- list menu -->
                    <ul class="header-list-categories tf-lg-hidden">
                        <!-- cate -->
                        @include('client.layouts.particals.navleft')
                        <!-- cate -->
                    </ul>

                </div>
            </div>
        </div>

</header>
<!-- /header -->
<script>
    function validateSearchForm() {
        var query = document.getElementById('searchQuery').value.trim();
        if (query === '') {
            showError('Vui lòng nhập từ khóa tìm kiếm');
            return false;
        }
        return true;
    }

    function showError(message) {
        var errorDiv = document.getElementById('searchError');
        errorDiv.innerHTML = message;
        errorDiv.style.display = 'block';

        // Tự động ẩn thông báo sau 3 giây
        setTimeout(function() {
            errorDiv.style.display = 'none';
        }, 3000);
    }
</script>


     <div class="px_15 lg-px_40">
         <div class="row wrapper-header align-items-center">
             <div class="col-md-4 col-3 tf-lg-hidden">
                 <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16"
                         fill="none">
                         <path
                             d="M2.00056 2.28571H16.8577C17.1608 2.28571 17.4515 2.16531 17.6658 1.95098C17.8802 1.73665 18.0006 1.44596 18.0006 1.14286C18.0006 0.839753 17.8802 0.549063 17.6658 0.334735C17.4515 0.120408 17.1608 0 16.8577 0H2.00056C1.69745 0 1.40676 0.120408 1.19244 0.334735C0.978109 0.549063 0.857702 0.839753 0.857702 1.14286C0.857702 1.44596 0.978109 1.73665 1.19244 1.95098C1.40676 2.16531 1.69745 2.28571 2.00056 2.28571ZM0.857702 8C0.857702 7.6969 0.978109 7.40621 1.19244 7.19188C1.40676 6.97755 1.69745 6.85714 2.00056 6.85714H22.572C22.8751 6.85714 23.1658 6.97755 23.3801 7.19188C23.5944 7.40621 23.7148 7.6969 23.7148 8C23.7148 8.30311 23.5944 8.59379 23.3801 8.80812C23.1658 9.02245 22.8751 9.14286 22.572 9.14286H2.00056C1.69745 9.14286 1.40676 9.02245 1.19244 8.80812C0.978109 8.59379 0.857702 8.30311 0.857702 8ZM0.857702 14.8571C0.857702 14.554 0.978109 14.2633 1.19244 14.049C1.40676 13.8347 1.69745 13.7143 2.00056 13.7143H12.2863C12.5894 13.7143 12.8801 13.8347 13.0944 14.049C13.3087 14.2633 13.4291 14.554 13.4291 14.8571C13.4291 15.1602 13.3087 15.4509 13.0944 15.6653C12.8801 15.8796 12.5894 16 12.2863 16H2.00056C1.69745 16 1.40676 15.8796 1.19244 15.6653C0.978109 15.4509 0.857702 15.1602 0.857702 14.8571Z"
                             fill="currentColor"></path>
                     </svg>
                 </a>
             </div>
             <div class="col-xl-3 col-md-4 col-6">
                 <a href="index.html" class="logo-header">
                     <img src="{{ asset('client/assets/images/logo/logo.svg') }}" alt="logo" class="logo">
                 </a>
             </div>

             <div class="col-xl-6 tf-md-hidden">
                 <!-- list menu -->
                 @include('client.layouts.particals.menu')
                 <!-- list menu --> 
             </div>
             <div class="col-xl-3 col-md-4 col-3">
                 <!-- chu y -->
                 <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">
                     <li class="nav-search"><a href="#canvasSearch" data-bs-toggle="offcanvas"
                             aria-controls="offcanvasLeft" class="nav-icon-item"><i class="icon icon-search"></i></a>
                     </li>
                     
                     <li class="nav-account"><a href="#login" data-bs-toggle="modal" class="nav-icon-item"><i
                                 class="icon icon-account"></i></a></li>
                     <li class="nav-wishlist"><a href="wishlist.html" class="nav-icon-item"><i
                                 class="icon icon-heart"></i><span class="count-box">0</span></a></li>
                     <li class="nav-cart"><a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item"><i
                                 class="icon icon-bag"></i><span class="count-box cart-count">0</span></a></li>
                 </ul>
             </div>
         </div>
     </div>
 </header>
<div class="px_15 lg-px_40">
    <div class="row wrapper-header align-items-center">
        <div class="col-md-4 col-3 tf-lg-hidden">
            <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16"
                    fill="none">
                    <path
                        d="M2.00056 2.28571H16.8577C17.1608 2.28571 17.4515 2.16531 17.6658 1.95098C17.8802 1.73665 18.0006 1.44596 18.0006 1.14286C18.0006 0.839753 17.8802 0.549063 17.6658 0.334735C17.4515 0.120408 17.1608 0 16.8577 0H2.00056C1.69745 0 1.40676 0.120408 1.19244 0.334735C0.978109 0.549063 0.857702 0.839753 0.857702 1.14286C0.857702 1.44596 0.978109 1.73665 1.19244 1.95098C1.40676 2.16531 1.69745 2.28571 2.00056 2.28571ZM0.857702 8C0.857702 7.6969 0.978109 7.40621 1.19244 7.19188C1.40676 6.97755 1.69745 6.85714 2.00056 6.85714H22.572C22.8751 6.85714 23.1658 6.97755 23.3801 7.19188C23.5944 7.40621 23.7148 7.6969 23.7148 8C23.7148 8.30311 23.5944 8.59379 23.3801 8.80812C23.1658 9.02245 22.8751 9.14286 22.572 9.14286H2.00056C1.69745 9.14286 1.40676 9.02245 1.19244 8.80812C0.978109 8.59379 0.857702 8.30311 0.857702 8ZM0.857702 14.8571C0.857702 14.554 0.978109 14.2633 1.19244 14.049C1.40676 13.8347 1.69745 13.7143 2.00056 13.7143H12.2863C12.5894 13.7143 12.8801 13.8347 13.0944 14.049C13.3087 14.2633 13.4291 14.554 13.4291 14.8571C13.4291 15.1602 13.3087 15.4509 13.0944 15.6653C12.8801 15.8796 12.5894 16 12.2863 16H2.00056C1.69745 16 1.40676 15.8796 1.19244 15.6653C0.978109 15.4509 0.857702 15.1602 0.857702 14.8571Z"
                        fill="currentColor"></path>
                </svg>
            </a>
        </div>
        <div class="col-xl-3 col-md-4 col-6">
            <a href="index.html" class="logo-header">
                <img src="{{ asset('client/assets/images/logo/logo.svg') }}" alt="logo" class="logo">
            </a>
        </div>

        <div class="col-xl-6 tf-md-hidden">
            <!-- list menu -->
            @include('client.layouts.particals.menu')
            <!-- list menu -->
        </div>
        <div class="col-xl-3 col-md-4 col-3">
            <!-- chu y -->
            <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">
                <li class="nav-search"><a href="#canvasSearch" data-bs-toggle="offcanvas"
                        aria-controls="offcanvasLeft" class="nav-icon-item"><i class="icon icon-search"></i></a>
                </li>

                <li class="nav-account"><a href="#login" data-bs-toggle="modal" class="nav-icon-item"><i
                            class="icon icon-account"></i></a></li>
                <li class="nav-wishlist"><a href="wishlist.html" class="nav-icon-item"><i
                            class="icon icon-heart"></i><span class="count-box">0</span></a></li>
                <li class="nav-cart"><a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item"><i
                            class="icon icon-bag"></i><span class="count-box cart-count">0</span></a></li>
            </ul>
        </div>
    </div>
</div>
</header>
<!-- /Header -->
