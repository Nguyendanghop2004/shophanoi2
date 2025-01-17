<div class="tf-toolbar-bottom type-1150">
    
    <div class="toolbar-item">
        <a href="{{route('wishlist')}}">
            <div class="toolbar-icon">
                <i class="icon-heart"></i>
                <div class="toolbar-count">{{$wishlistCount}}</div>
            </div>
            <div class="toolbar-label">Wishlist</div>
        </a>
    </div>
    <div class="toolbar-item">
        <a href="#shoppingCart" data-bs-toggle="modal">
            <div class="toolbar-icon">
                <i class="icon-bag"></i>
                <div class="toolbar-count">1</div>
            </div>
            <div class="toolbar-label">Cart</div>
        </a>
    </div>
</div>
