{{-- <li class="categories-item active"><a href="home-multi-brand.html"
    class="text-uppercase">Women</a></li>
<li class="categories-item"><a href="home-men.html" class="text-uppercase">Men</a></li>
<li class="categories-item"><a href="home-kids.html" class="text-uppercase">Kids</a></li>
<li class="categories-item"><a href="store-locations.html" class="text-uppercase">Find a
    Store</a></li> --}}

  @foreach ($parentCategories as $item)
    <li class="categories-item"><a href="{{route('shop-collection',$item->id)}}" class="text-uppercase">{{$item->name}}</a></li>
  @endforeach

  



