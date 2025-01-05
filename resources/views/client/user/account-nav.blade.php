<ul class="my-account-nav">
    <li><a href="{{ route('account.profile',auth()->user()->id) }}" class="my-account-nav-item">Trang chủ</a></li>
    <li><a href="{{route('account.profileOrders')}}" class="my-account-nav-item">Đơn hàng</a></li>
    <li><a href="{{route('account.profileAccountDetails',auth()->user()->id)}}" class="my-account-nav-item">Thay đổi đỉa chi</a></li>
    <li><a href="{{route('account.profileWishlist')}}" class="my-account-nav-item">Danh sách yêu thích</a></li>
    <li><a href="{{route('accountUser.logout')}}" class="my-account-nav-item">Đang xuất</a></li>
</ul>