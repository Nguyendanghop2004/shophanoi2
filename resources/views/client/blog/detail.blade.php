@extends('client.layouts.master')
@section('header-home')
    @include('client.layouts.particals.header-home')
@endsection

@section('content')
    <div class="blog-detail">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="blog-detail-main">
                        <div class="blog-detail-main-heading">
                            <ul class="tags-lists justify-content-center">
                                <li>
                               
                                </li>
                                {{-- <li>
                                    <a href="#" class="tags-item">{{$data->category->name}}</a>
                                </li> --}}
                            </ul>
                          
                            
                        </div>
                        {!! $data ->content!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
