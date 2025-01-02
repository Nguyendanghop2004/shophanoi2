<ul class="nav-icon d-flex justify-content-end align-items-center gap-20">

    {{-- @dd(Auth::user()); --}}
    @if (Auth::user())
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <li class="nav-item dropdown">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Storage::url(auth()->user()->image) }}" alt="Ảnh" class="rounded-circle mr-1"
                            width="30px">
                    </a>


                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">{{ \Illuminate\Support\Str::words(auth()->user()->name,2,'...')}}</a></li>
                            <li> <a class="dropdown-item" href="{{ route('order.donhang') }}">Đơn hàng</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                          
                            
                            <li> <a class="dropdown-item" href="{{ route('accountUser.logout') }}">Đăng Xuất</a></li>
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


</ul>
