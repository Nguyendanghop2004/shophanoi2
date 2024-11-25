<li><a href="product-detail.html"
        class="menu-link-text link ms-1 @if ($index == 1) fw-bold @else ps-2 @endif">{{ $child->name }} </a></li>
@php
    $index++;
@endphp

@if ($child->children->isNotEmpty())
    @foreach ($child->children as $child)
        @include('client.layouts.particals.child-categories', ['child' => $child])
    @endforeach
@endif

