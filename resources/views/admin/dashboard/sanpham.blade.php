@extends('admin.layouts.master')
@section('content')
<section class="section">






    <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
            <div class="card-header">
                <h4>Top 5 sản phẩm bán chạy nhất</h4>
                <div class="card-header-action">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-primary"
                            data-toggle="dropdown">Filter</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i>
                                Electronic</a>
                            <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i>
                                T-shirt</a>
                            <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i>
                                Hat</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">View All</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="summary">
                    <div class="summary-info">
                        <h4>{{ number_format($totalRevenue, 2) }}</h4>
                        <div class="text-muted">Tổng số tiền các sản phẩm</div>
                        <div class="d-block mt-2">
                            <a href="#">View All</a>
                        </div>
                    </div>
                    <div class="summary-item">
                        {{-- <h6>Item List <span class="text-muted">(3 Items)</span></h6> --}}
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach ($topProducts as $product)
                            <li class="media">
                                <a href="#">
                                    <img class="mr-3 rounded" width="50"
                                        src="assets/img/products/product-1-50.png" alt="product">
                                </a>
                                <div class="media-body">
                                    <div class="media-right">{{ number_format($product->total_revenue, 2) }}</div>
                                    <div class="media-title"><a href="#">{{$product->product_name }}</a>
                                    </div>
                                    <div class="text-muted text-small"> <a href="#">Đã bán: {{ $product->total_sold }}</a>
                                        <div class="bullet"></div> 
                                    </div>
                                </div>
                            </li>
                            @endforeach
                            {{-- <li class="media">
                                <a href="#">
                                    <img class="mr-3 rounded" width="50"
                                        src="assets/img/products/product-2-50.png" alt="product">
                                </a>
                                <div class="media-body">
                                    <div class="media-right">$499</div>
                                    <div class="media-title"><a href="#">RocketZ</a></div>
                                    <div class="text-muted text-small">by <a href="#">Hasan
                                            Basri</a>
                                        <div class="bullet"></div> Sunday
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <a href="#">
                                    <img class="mr-3 rounded" width="50"
                                        src="assets/img/products/product-3-50.png" alt="product">
                                </a>
                                <div class="media-body">
                                    <div class="media-right">$149</div>
                                    <div class="media-title"><a href="#">Xiaomay Readme
                                            4.0</a></div>
                                    <div class="text-muted text-small">by <a href="#">Kusnaedi</a>
                                        <div class="bullet"></div> Tuesday
                                    </div>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="d-inline">Top 5 sản phẩm bán được ít nhất</h4>
                <div class="card-header-action">
                    <a href="#" class="btn btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled list-unstyled-border">
                    {{-- <li class="media">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cbx-1">
                            <label class="custom-control-label" for="cbx-1"></label>
                        </div>
                        <img class="mr-3 rounded-circle" width="50" src="assets/img/avatar/avatar-4.png"
                            alt="avatar">
                        <div class="media-body">
                            <div class="badge badge-pill badge-danger mb-1 float-right">Not
                                Finished</div>
                            <h6 class="media-title"><a href="#">Redesign header</a></h6>
                            <div class="text-small text-muted">Alfa Zulkarnain <div class="bullet"></div> <span
                                    class="text-primary">Now</span>
                            </div>
                        </div>
                    </li>
                    <li class="media">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cbx-2" checked="">
                            <label class="custom-control-label" for="cbx-2"></label>
                        </div>
                        <img class="mr-3 rounded-circle" width="50" src="assets/img/avatar/avatar-5.png"
                            alt="avatar">
                        <div class="media-body">
                            <div class="badge badge-pill badge-primary mb-1 float-right">Completed
                            </div>
                            <h6 class="media-title"><a href="#">Add a new component</a></h6>
                            <div class="text-small text-muted">Serj Tankian <div class="bullet">
                                </div> 4 Min</div>
                        </div>
                    </li>
                    <li class="media">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cbx-3">
                            <label class="custom-control-label" for="cbx-3"></label>
                        </div>
                        <img class="mr-3 rounded-circle" width="50" src="assets/img/avatar/avatar-2.png"
                            alt="avatar">
                        <div class="media-body">
                            <div class="badge badge-pill badge-warning mb-1 float-right">Progress
                            </div>
                            <h6 class="media-title"><a href="#">Fix modal window</a></h6>
                            <div class="text-small text-muted">Ujang Maman <div class="bullet">
                                </div> 8 Min</div>
                        </div>
                    </li> --}}
                    @foreach ( $banitnhat as $product )
                        
                    
                    <li class="media">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cbx-4">
                            <label class="custom-control-label" for="cbx-4"></label>
                        </div>
                        <img class="mr-3 rounded-circle" width="50" src="assets/img/avatar/avatar-1.png"
                            alt="avatar">
                        <div class="media-body">
                            <div class="badge badge-pill badge-danger mb-1 float-right">Not
                                Finished</div>
                            <h6 class="media-title"><a href="#">{{$product->product_name }}</a>
                            </h6>
                            <div class="text-small text-muted">Đã bán: {{ $product->total_sold }}<div class="bullet">
                                </div> {{ number_format($product->total_revenue, 2) }}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

   
   
@endsection