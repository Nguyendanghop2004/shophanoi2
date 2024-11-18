<nav class="box-navigation text-center">
    <ul class="box-nav-ul d-flex align-items-center justify-content-center gap-30">
        <li class="menu-item">
            <a href="#" class="item-link">Trang Chủ</a>
           
        </li>
        <li class="menu-item">
    <a href="#" class="item-link">Danh Mục<i class="icon icon-arrow-down"></i></a>
    <div class="sub-menu mega-menu">
        <div class="container">
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-lg-2">
                        <div class="mega-menu-item">
                            <div class="menu-heading">{{ $category->name }}</div>
                            @if($category->children->isNotEmpty())
                                <ul class="menu-list">
                                    @foreach($category->children as $child)
                                        <li>
                                        <a href="{{ route('shop-collection', $child->id) }}" class="menu-link-text link">{{ $child->name }}</a>
                                       
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
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
                                   
                                    <li><a href=""
                                            class="menu-link-text link">Product description
                                            vertical</a></li>
                                </ul>
                            </div>
                        </div>
                       
                </div>
            </div>
        </li>
        <li class="menu-item position-relative">
            <a href="#" class="item-link">Bài Viết</a>
          
        </li>
        <li class="menu-item position-relative">
            <a href="{{route('shop-collection')}}" class="item-link">Bài Viết</a>
          
        </li>
        <li class="menu-item position-relative">
            <a href="" class="item-link">Giới Thiệu</a>
           
        </li>
        <li class="menu-item"><a
                href="https://themeforest.net/item/ecomus-ultimate-html5-template/53417990?s_rank=3"
                class="item-link">Buy now</a></li>
    </ul>
</nav>
