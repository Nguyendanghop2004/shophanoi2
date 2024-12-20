
    <!-- chu y -->
    {{-- @dd(Auth::user()->name) --}}
    <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">
        <li class="nav-search"><a href="#canvasSearch" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft"
                class="nav-icon-item"><i class="icon icon-search"></i></a></li>
        {{-- @dd(Auth::user()); --}}
        @if (Auth::user())
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <li class="nav-item dropdown">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon icon-account"></i>
                        </a>

                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">{{ \Illuminate\Support\Str::words(auth()->user()->name,2,'...')}}</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li> <a class="dropdown-item" href="{{ route('accountUser.logout') }}">logout</a></li>
                        </ul>
                    </li>
                </div>
            </nav>
        @else
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <li class="nav-item dropdown">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon icon-account"></i>
                        </a>

                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('accountUser.login') }}">Đăng Nhập</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('account.register') }}">Đăng ký</a></li>
                        </ul>
                    </li>
                </div>
            </nav>
        @endif
       
        <li class="nav-wishlist"><a href="wishlist.html" class="nav-icon-item"><i class="icon icon-heart"></i><span
                    class="count-box">0</span></a></li>
        <li class="nav-cart"><a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item"><i
                    class="icon icon-bag"></i><span class="count-box">0</span></a></li>
    </ul>


