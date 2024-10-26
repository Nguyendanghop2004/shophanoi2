
@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> Khuyến Mãi</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Khuyến Mãi</h4>
                <div class="card-header-action">
                    <a href="{{route('promotions.create')}}" class="btn btn-primary">
                        Tạo Mới
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="section-title mt-0">
                    </div>
                    <div class="card-header-action">
                        <form class="form-inline" method="GET" action="{{ route('promotions.index') }}">
                            <div class="search-element">
                                <input class="form-control" name="search" type="search" placeholder="Search"
                                    aria-label="Search" data-width="250" value="{{ request()->input('search') }}">
                                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    {{-- danh mục cha con tự thiết kế  --}}
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Discount Percentage</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promotions as $promotion)
                                <tr>
                                    <th scope="row">{{$promotion->id}}</th>
                                    <td>{{$promotion->title}}</td>
                                    <td>{{$promotion->description}}</td>
                                    <td>{{$promotion->discount_percentage}}</td>
                                    <td>{{$promotion->start_date}}</td>
                                    <td>{{$promotion->end_date}}</td>
                                   
                                    <td scope="row">
                                        <div class="d-flex justify-content-start">
                                            <div> <a href="{{route('promotions.edit',$promotion)}}" class="btn btn-warning"><i class="fas fa-edit"
                                                        style="color: #ffffff;"></i></a></div>
                                            <div>
                                                
                                               
                                                <form action="{{route('promotions.destroy',$promotion)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('bạn có muốn xoá không?')"><i class="fas fa-trash"
                                                        style="color: #ffffff;"></i></button>
                                                   </form>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card-body mx-auto">
                <div class="buttons">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item {{ $promotions->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $promotions->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($page = 1; $page <= $promotions->lastPage(); $page++)
                                <li class="page-item {{ $page == $promotions->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $promotions->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $promotions->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $promotions->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </section>
@endsection
