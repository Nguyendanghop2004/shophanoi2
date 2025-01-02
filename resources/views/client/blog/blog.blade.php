@extends('client.layouts.master')

@section('content')
    <!-- page-title -->
    <div class="tf-page-title">
        <div class="container-full">
            <div class="row">
                <div class="col-12">
                    <div class="heading text-center">Bài viết</div>
                    {{-- <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a href="index.html">Home</a>
                            </li>
                            <li>
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li>
                                Fashion
                            </li>
                        </ul> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- /page-title -->

    <!-- blog-grid-main -->
    <div class="blog-grid-main">
        <div class="container">
            <div class="row">
                @foreach ($data as $item)
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="blog-article-item">
                            <div class="article-thumb">
                                <a href="{{route('blog.detail',$item->slug)  }}">
                                    <img class="lazyload" src="{{ Storage::url($item->image) }} "
                                        style="width: 366px; height: 235px;" alt="img-blog">
                                </a>
                                 
                                {{-- <div class="article-label">
                                    <a href="blog-detail.html"
                                        class="tf-btn btn-sm radius-3 btn-fill animate-hover-btn">{{$item->category->name}}</a>
                                </div> --}}
                            </div>
                            <div class="article-content">
                                <div class="article-title">
                                    <a href="{{route('blog.detail',$item->slug)  }}" class="">{{ $item->title }}</a>
                                </div>
                                <div class="article-btn">
                                    <a href="{{route('blog.detail',$item->slug)  }}" class="tf-btn btn-line fw-6">Xêm Thêm<i
                                            class="icon icon-arrow1-top-left"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

               
            </div>
        </div>
    </div>
    <!-- /blog-grid-main -->
@endsection
