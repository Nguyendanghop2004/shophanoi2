<div class="col-xl-5 col-md-4 col-3">
    <!-- chu y -->
    {{-- @dd(Auth::user()->name) --}}
    <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">
        <li class="nav-search"><a href="#canvasSearch" data-bs-toggle="offcanvas"
                aria-controls="offcanvasLeft" class="nav-icon-item"><i
                    class="icon icon-search"></i></a></li>
        {{-- @dd(Auth::user()); --}}
        @if (Auth::user())
            <a href="{{ route('accountUser.logout') }}">logout</a>
        @else
            <li class="nav-account">
                <a href="#login" data-bs-toggle="modal" class="nav-icon-item">
                    <i class="icon icon-account"></i>
                </a>
            </li>
        @endif

        <li class="nav-wishlist"><a href="wishlist.html" class="nav-icon-item"><i
                    class="icon icon-heart"></i><span class="count-box">0</span></a></li>
        <li class="nav-cart"><a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item"><i
                    class="icon icon-bag"></i><span class="count-box">0</span></a></li>
    </ul>

</div>
