<nav class="navbar navbar-expand-lg main-navbar">
    {{-- search --}}
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
    </form>
    {{-- end search --}}
    {{-- left search --}}
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

                <div class="d-sm-none d-lg-inline-block">
                    {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>

                <a href="{{ route('admin.profile.index', Auth::user()->id) }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="{{ route('admin.profile.changePassword', Auth::user()->id) }}"
                    class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Đổi mật khẩu
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.post-logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>

                <!-- Form Logout -->

            </div>
        </li>
    </ul>
    {{-- end left search --}}
</nav>
{{-- main sidebar --}}
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.trangchu') }}">Hanoiclothesshop</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="dropdown ">
                @can('account_admin')
            <li class="menu-header">Quản Lí</li>


            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-columns"></i> <span>Thanh Trượt</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.slider.index') }}">Danh sách Thanh Trượt</a></li>
                    <li><a class="nav-link" href="{{ route('admin.slider.trash') }}">Thùng
                            Rác<i class="fas fa-recycle"></i></a></li>

                </ul>
            </li>
        @endcan
            @can('blog')
                <li class="dropdown">
                    <a href="{{ route('admin.blog.index') }}" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-edit"></i>
                        <span>Bài Viết</span></a>
                    <ul class="dropdown-menu">


                        <li><a class="nav-link" href="{{ route('admin.blog.show') }}"><span>Danh Sách Bài viết</span></a>
                        </li>
                        <li><a class="nav-link" href="{{ route('admin.blog.index') }}"><span>Thêm Mới Bài viết</span></a>
                        </li>

                    </ul>
                </li>
            @endcan
            @can('dashboard')
                <li class="dropdown">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-chart-line"></i>
                        <span>Thống kê</span></a>
                    <ul class="dropdown-menu">


                        <li><a class="nav-link" href="{{ route('admin.dashboard') }}"><span>Tổng Quan</span></a></li>


                    </ul>
                </li>
            @endcan
            @can('account_admin')
            <li><a class="nav-link" href="blank.html"><i class="fas fa-comments"></i> <span>Bình Luận</span></a></li>
            @endcan

            @can('contact')
                <li><a class="nav-link" href="{{ route('admin.contact.index') }}"><i class="fas fa-envelope"></i>
                        <span>Liên Hệ</span></a></li>
            @endcan
            @can('coupoun')
                <li class="dropdown">
                    <a href="{{ route('admin.discount_codes.index') }}" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-folder"></i>
                        <span>Mã Giảm Giá</span></a>
                    <ul class="dropdown-menu">


                        <li><a class="nav-link" href="{{ route('admin.discount_codes.index') }}"><span>Danh sách mã giảm giá</span></a>
                        </li>
                        <li><a class="nav-link" href="{{ route('admin.discount_codes.create') }}"><span>Tạo mới</span></a>
                        </li>

                    </ul>
                </li>
            @endcan
            @can('manager_ship')
                <li class="menu-header">Quản Lí Shipper</li>
                <li class="dropdown">
                    <a href="" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-folder"></i>
                        <span>Quản Lí Shipper</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.shippers.index') }}"></i>
                                <span>Nhân viên giao hàng</span></a></li>
                        <li><a class="nav-link" href="{{ route('admin.order.assign') }}"><span>Đơn hàng chưa
                                    giao</span></a></li>
                    </ul>
                </li>
            @endcan
            @can('Shipper')
                <li class="menu-header">Shipper</li>
                <li class="dropdown">
                    <a href="" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-truck "></i>
                        <span>Shipper</span></a>
                    <ul class="dropdown-menu">

                        <li><a class="nav-link" href="{{ route('admin.order.danhsachgiaohang') }}"><span>Danh sách giao
                                    hàng</span></a></li>
                    </ul>
                </li>
            @endcan
            @can('categories')
                <li class="menu-header">Danh mục</li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-folder"></i>
                        <span>Danh mục sản phẩm</span></a>
                    <ul class="dropdown-menu">

                        <li><a class="nav-link" href="{{ route('admin.categories.list') }}"><span>Danh Sách Danh
                                    Mục</span></a></li>
                        <li><a class="nav-link" href="{{ route('admin.categories.add') }}"><span>Thêm Mới Danh
                                    Mục</span></a></li>

                    </ul>
                </li>
            @endcan

            @can('order')
                <li class="menu-header">Quản Lí Đơn Hàng</li>
                <li class="dropdown">
                    <a href="" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-receipt"></i>
                        <span>Đơn Hàng</span></a>
                    <ul class="dropdown-menu">

                        <li><a class="nav-link" href="{{ route('admin.order.getList') }}"><span>Danh Sách Đơn
                                    Hàng</span></a></li>
                    </ul>
                </li>
            @endcan
            @can('product')
                <li class="menu-header">Quản Lí Sản Phẩm</li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i>
                        <span>Sản Phẩm</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.product.index') }}"><span>Danh Sách</span></a></li>
                        <li><a class="nav-link" href="{{ route('admin.sales.index') }}"><span>Giảm Giá</span></a></li>
                        <li><a class="nav-link" href="{{ route('admin.product.create') }}"><span>Tạo Mới</span></a></li>
                        <li><a class="nav-link" href="{{ route('admin.permissions.index') }}"><span>Thùng Rác</span></a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i>
                        <span>Quản lí Biển Thể</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.colors.index') }}"><span>Quản Màu Sắc</span></a>
                        </li>

                        <li><a class="nav-link" href="{{ route('admin.sizes.index') }}"><span> Lí Số Đo</span></a></li>

                        <li><a class="nav-link" href="{{ route('admin.brands.index') }}"><span>Quản Lí Thương
                                    Hiệu</span></a></li>
                        <li><a class="nav-link" href="{{ route('admin.tags.index') }}"><span>Quản lí Thẻ</span></a></li>
                    </ul>
                </li>
            @endcan

            @canany(['account_admin', 'account_user'])
                <li class="menu-header">Quản Lí tài khoản</li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users "></i>
                        <span>Account</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.accounts.account') }}"><span>Tài khoản
                                    Admin</span></a></li>
                        <li><a class="nav-link" href="{{ route('admin.history') }}">
                                <span>Lịch sử Admin</span></a></li>
                        <li><a class="nav-link" href="{{ route('admin.historyUser') }}">
                                <span>Lịch sử User</span></a></li>
                        <li><a class="nav-link" href="{{ route('admin.accountsUser.accountUser') }}"><span>Tài khoản
                                    User</span></a></li>
                        <li><a class="nav-link" href="{{ route('admin.permissions.index') }}"><span>Phân quyền và vai
                                    trò</span></a></li>
                    </ul>
                </li>
            @endcan





    </aside>
</div>
