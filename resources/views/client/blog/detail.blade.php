@extends('client.layouts.master')

@section('content')
    <div class="blog-detail">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="blog-detail-main">
                        <div class="blog-detail-main-heading">
                            <ul class="tags-lists justify-content-center">
                                <li>
                                    <a href="#" class="tags-item">ACCESSORIES</a>
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
