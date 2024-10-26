<div>
    <!-- He who is contented is rich. - Laozi -->
</div>

@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Danh Mục Bài Viết</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Bài Viết</h4>
                <div class="card-header-action">
                    <a href="{{route('news.create')}}" class="btn btn-primary">
                        Tạo Mới
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="section-title mt-0">
                    </div>
                    <div class="card-header-action">
                        <form class="form-inline" method="GET" action="{{ route('news.index') }}">
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
                                    <th scope="col">Content</th>
                                    <th scope="col">Image Path</th>
                                    <th scope="col">Published</th>
                                    <th scope="col">Category ID</th>
                                    <th scope="col">Product ID</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $new)
                                <tr>
                                    <th scope="row">{{$new->id}}</th>
                                    <td>{{$new->title}}</td>
                                    <td>{{$new->content}}</td>
                                    <td><img src="{{asset('storage/' . $new->image_path)}}" alt="" width="100" height="100"></td>
                                    <td>{{$new->published_at}}</td>
                                    <td>{{$new->category_id}}</td>
                                    <td>{{$new->product_id}}</td>
                                   
                                    <td scope="row">
                                        <div class="d-flex justify-content-start">
                                            <div> <a href="{{route('news.edit',$new)}}" class="btn btn-warning"><i class="fas fa-edit"
                                                        style="color: #ffffff;"></i></a></div>
                                            <div>
                                                
                                               
                                                <form action="{{route('news.destroy',$new)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có muốn xoá không?')"><i class="fas fa-trash"
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
                            <li class="page-item {{ $news->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $news->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($page = 1; $page <= $news->lastPage(); $page++)
                                <li class="page-item {{ $page == $news->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $news->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $news->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $news->nextPageUrl() }}" aria-label="Next">
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
