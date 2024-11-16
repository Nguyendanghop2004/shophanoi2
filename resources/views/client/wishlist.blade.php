{{-- <h1>Danh sách yêu thích của bạn</h1>

@if ($wishlistItems->isEmpty())
    <p>Danh sách yêu thích của bạn đang trống.</p>
@else
    @foreach ($wishlistItems as $item)
        <div class="product">
            <h2>{{ $item->product->main_image_url }}</h2>
            
            <p>{{ $item->product->product_name }}</p>
            <p>{{ $item->product->price }}</p>
            <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST">
                @csrf
                <button type="submit">Xóa khỏi Yêu thích</button>
            </form>
        </div>
    @endforeach
@endif --}}
<div>
    <!-- He who is contented is rich. - Laozi -->
</div>

@extends('admin.layouts.master')

@section('content')
    <section class="section">
    

        <div class="card card-primary">
            <div class="card-header">
                <h4>Danh Sách Wishlist</h4>
               
            </div>
            <div class="card-body">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="section-title mt-0">
                    </div>
                    <div class="card-header-action">
                        <form class="form-inline" method="GET" action="{{ route('wishlist.index') }}">
                            
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
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if ($wishlistItems->isEmpty())
                                <p>Danh sách yêu thích của bạn đang trống.</p>
                            @else
                                @foreach ($wishlistItems as $item)
                                  <tr>
                                    <th scope="row">{{ $item->product->product_name }}</th>
                                    <td>{{ $item->product->price }}</td>
                                    <td scope="row">
                                        
                                                
                                               
                                                <form action="{{route('wishlist.remove', $item->product->id)}}" method="POST">
                                                    @csrf
                                                    {{-- @method('delete') --}}
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('bạn có muốn xoá không?')"><i class="fas fa-trash"
                                                        style="color: #ffffff;"></i></button>
                                                   </form>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                  </tr>
                                      
                                      
                                  
                                {{-- @endforeach --}}
                            @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            

        </div>
    </section>
   
@endsection
