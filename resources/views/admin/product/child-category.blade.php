@foreach ($categories as $category)
    <div class="custom-control custom-checkbox">
        {{-- Hiển thị checkbox cho danh mục con --}}
        <input type="checkbox" class="custom-control-input" id="customCheck{{ $category->id }}" name="categories[]"
            value="{{ $category->id }}">
        <label class="custom-control-label" for="customCheck{{ $category->id }}">{{ $category->name }}</label>

        {{-- Nếu danh mục có các danh mục con nữa, tiếp tục đệ quy --}}
        @if ($category->children && $category->children->count())
            @include('admin.product.child-category', ['categories' => $category->children])
        @endif
    </div>
@endforeach
