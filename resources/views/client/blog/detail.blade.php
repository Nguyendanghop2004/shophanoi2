@extends('client.layouts.master')

@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
<style>
    .blog-detail-main {
    line-height: 1.8;
    font-size: 1rem;
    color: #333;
}

.blog-detail-main-heading h1 {
    font-size: 2rem;
    color: #212529;
}

.tags-lists .tags-item {
    padding: 5px 10px;
    border-radius: 5px;
    text-transform: capitalize;
    font-size: 0.85rem;
}

.blog-detail-content img {
    max-width: 100%;
    height: auto;
    margin: 20px 0;
    border-radius: 8px;
}
.text-right {
    text-align: right;
}

</style>
    <div class="blog-detail py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="blog-detail-main shadow rounded p-4 bg-white">
                        <!-- Heading -->
                        <div class="blog-detail-main-heading text-center mb-4">
                            <h1 class="font-weight-bold">{{ $data->title }}</h1>
                            <ul class="tags-lists d-inline-flex list-unstyled justify-content-center mt-2">
                                {{-- Uncomment if category is available --}}
                                {{-- <li>
                                    <a href="#" class="tags-item badge bg-primary text-white mx-1">
                                        {{ $data->category->name }}
                                    </a>
                                </li> --}}
                            </ul>
                            <p class="text-muted  text-right">
                             Ngày đăng: {{ $data->created_at->format('d/m/Y') }}
                            </p>
                        </div>

                        <!-- Blog Content -->
                        <div class="blog-detail-content mt-4">
                            {!! $data->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
