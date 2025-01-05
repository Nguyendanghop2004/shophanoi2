<div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
    <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
    <div class="mb-canvas-content">
        <div class="mb-body">
            <ul class="nav-ul-mb" id="wrapper-menu-navigation">
            <li class="nav-mb-item">
    <a href="{{ route('home') }}" class="mb-menu-link current">
        <span>Trang Chủ</span>
    </a>
</li>

<li class="nav-mb-item">
    <a href="{{ route('shop-collection.index') }}" class="mb-menu-link current">
        <span>Sản Phẩm</span>
    </a>
</li>

<li class="nav-mb-item">
    <a href="{{ route('blog.show') }}" class="mb-menu-link current">
        <span>Bài Viết</span>
    </a>
</li>
<li class="nav-mb-item">
    <a href="{{ route('about-us') }}" class="mb-menu-link current">
        <span>Giới Thiệu</span>
    </a>
</li>
<li class="nav-mb-item">
    <a href="{{ route('contact') }}" class="mb-menu-link current">
        <span>Liên Hệ</span>
    </a>
</li>
              
            </ul>
          
        </div>
        <div class="mb-bottom">
            <a href="{{route('accountUser.logout')}}" class="site-nav-icon"><i class="icon icon-account"></i>Đăng Xuất</a>
            <div class="bottom-bar-language">
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
