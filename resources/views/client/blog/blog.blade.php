@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
    <!-- page-title -->
    <div class="flat-title wow fadeInUp" data-wow-delay="0s">
                <span class="title">Bài viết</span>
            
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
                                    <a href="{{route('blog.detail',$item->slug)  }}" class="tf-btn btn-line fw-6">Xem Thêm<i
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
