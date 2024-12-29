<div class="col-xl-5 col-md-4 col-3">
    <!-- chu y -->
    {{-- @dd(Auth::user()->name) --}}
    <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">

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

    </ul>

</div>
