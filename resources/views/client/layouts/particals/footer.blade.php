<footer id="footer" class="footer background-gray md-pb-70">
    <div class="footer-wrap">
        <div class="footer-body">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="footer-infor">
                            <div class="footer-logo">
                                <a href="index.html">
                                    <img src="images/logo/logo.svg" alt="">
                                </a>
                            </div>
                            <ul>
                                <li>
                                    <p>Địa chỉ: Trịnh Văn Bô, Nam Từ Niêm, Hà Nội <br></p>
                                </li>
                                <li>
                                    <p>Email: <a href="#">Hanoiclothesshop@gmail.com</a></p>
                                </li>
                                <li>
                                    <p>Điện thoại: <a href="#">03973525321</a></p>
                                </li>
                            </ul>
                            <a href="{{route('about-us')}}" class="tf-btn btn-line">Chỉ đường<i
                                    class="icon icon-arrow1-top-left"></i></a>
                            <ul class="tf-social-icon d-flex gap-10">
                                <li><a href="#"
                                        class="box-icon w_34 round social-facebook social-line"><i
                                            class="icon fs-14 icon-fb"></i></a></li>
                                <li><a href="#" class="box-icon w_34 round social-twiter social-line"><i
                                            class="icon fs-12 icon-Icon-x"></i></a></li>
                                <li><a href="#"
                                        class="box-icon w_34 round social-instagram social-line"><i
                                            class="icon fs-14 icon-instagram"></i></a></li>
                                <li><a href="#" class="box-icon w_34 round social-tiktok social-line"><i
                                            class="icon fs-14 icon-tiktok"></i></a></li>
                                <li><a href="#"
                                        class="box-icon w_34 round social-pinterest social-line"><i
                                            class="icon fs-14 icon-pinterest-1"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12 footer-col-block">
                        <div class="footer-heading footer-heading-desktop">
                            <h6>Hỗ trợ</h6>
                        </div>
                        <div class="footer-heading footer-heading-moblie">
                            <h6>Hỗ trợ</h6>
                        </div>
                        <ul class="footer-menu-list tf-collapse-content">
                            <li>
                                <a href="" class="footer-menu_item">Chính sách bảo mật</a>
                            </li>
                            <li>
                                <a href="" class="footer-menu_item">Đổi trả hàng</a>
                            </li>
                            <li>
                                <a href="" class="footer-menu_item">Vận chuyển</a>
                            </li>
                            <li>
                                <a href="" class="footer-menu_item">Điều khoản & Điều kiện</a>
                            </li>
                            <li>
                                <a href="" class="footer-menu_item">Câu hỏi thường gặp</a>
                            </li>
                            <li>
                                <a href="" class="footer-menu_item">So sánh</a>
                            </li>
                            <li>
                                <a href="" class="footer-menu_item">Danh sách yêu thích</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12 footer-col-block">
                        <div class="footer-heading footer-heading-desktop">
                            <h6>Về chúng tôi</h6>
                        </div>
                        <div class="footer-heading footer-heading-moblie">
                            <h6>Về chúng tôi</h6>
                        </div>
                        <ul class="footer-menu-list tf-collapse-content">
                            <li>
                                <a href="{{route('about-us')}}" class="footer-menu_item">Câu chuyện của chúng tôi</a>
                            </li>
                            <li>
                                <a href="{{route('home')}}" class="footer-menu_item">Thăm cửa hàng của chúng tôi</a>
                            </li>
                            <li>
                                <a href="{{route('contact')}}" class="footer-menu_item">Liên hệ</a>
                            </li>
                            <li>
                                <a href="{{route('accountUser.login')}}" class="footer-menu_item">Tài khoản</a>
                            </li>
                            <li class="nav-search footer-menu-list tf-collapse-content">
                                <form action="{{ route('order.search') }}" method="GET" class="search-form" onsubmit="return validateSearchForm()">
                                    <div class="search-input-wrapper">
                                        <input type="text" name="query" id="searchQuery" placeholder="Tra cứu đơn hàng....." class="search-input">
                                        <button class="nav-icon-item search-button" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </li>
                            <br>
                           
                            

                        </ul>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="footer-newsletter footer-col-block">
                            <div class="footer-heading footer-heading-desktop">
                                <h6>Đăng ký nhận email</h6>
                            </div>
                            <div class="footer-heading footer-heading-moblie">
                                <h6>Đăng ký nhận email</h6>
                            </div>
                            <div class="tf-collapse-content">
                                <div class="footer-menu_item">Đăng ký để nhận thông tin về các sản phẩm mới, giảm giá,
                                    nội dung độc quyền, sự kiện và nhiều hơn nữa!</div>
                                <form class="form-newsletter" id="subscribe-form" action="#"
                                    method="post" accept-charset="utf-8" data-mailchimp="true">
                                    <div id="subscribe-content">
                                        <fieldset class="email">
                                            <input type="email" name="email-form" id="subscribe-email"
                                                placeholder="Nhập email của bạn...." tabindex="0"
                                                aria-required="true">
                                        </fieldset>
                                        <div class="button-submit">
                                            <button id="subscribe-button"
                                                class="tf-btn btn-sm radius-3 btn-fill btn-icon animate-hover-btn"
                                                type="button">Đăng ký<i
                                                    class="icon icon-arrow1-top-left"></i></button>
                                        </div>
                                    </div>
                                    <div id="subscribe-msg"></div>
                                </form>
                                <div class="tf-cur">
                                    <div class="tf-currencies">
                                        <li class="categories-item footer-menu-list tf-collapse-content">
                                            <a href="{{ route('contact') }}" class="text-uppercase">
                                                <i class="fas fa-map-marker-alt"></i> Vị Trí Cửa Hàng
                                            </a>
                                        </li>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div
                            class="footer-bottom-wrap d-flex gap-20 flex-wrap justify-content-between align-items-center">
                            <div class="footer-menu_item">© 2024 HanoiClothesshop. Bảo lưu tất cả quyền</div>
                            <div class="tf-payment">
                                <img src="images/payments/visa.png" alt="">
                                <img src="images/payments/img-1.png" alt="">
                                <img src="images/payments/img-2.png" alt="">
                                <img src="images/payments/img-3.png" alt="">
                                <img src="images/payments/img-4.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
