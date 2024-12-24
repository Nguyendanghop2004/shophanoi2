@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Thồng Kê</h1>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Tổng số Admin</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalAdmin }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Bài viết</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalNews }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Sản Phẩm</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalProducts }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Doanh thu hôm nay</h4>
                    </div>
                    <div class="card-body">
                        {{ number_format($totalStoreSales, 0, ',', '.') }} VNĐ
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Tổng đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        {{$toltalOrder}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Người dùng online</h4>
                    </div>
                    <div class="card-body">
                        {{ $onlineUsers }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Thống kê</h4>
                    <div class="card-header-action">
                        <div class="btn-group">
                            <a href="#" class="btn btn-primary">Tuần</a>
                            <a href="#" class="btn">Tháng</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart" height="182"></canvas> 
                    <div class="statistic-details mt-sm-4">
                        <div class="statistic-details-item">
                            <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>
                            <div class="detail-value">₫{{ number_format($todaySales, 0, ',', '.') }} VNĐ</div>
                            <div class="detail-name">Doanh thu hôm nay</div>
                        </div>
                        <div class="statistic-details-item">
                            <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
                            <div class="detail-value">{{ number_format($weekSales, 0, ',', '.') }} VNĐ</div>
                            <div class="detail-name">Doanh thu tuần này</div>
                        </div>
                        <div class="statistic-details-item">
                            <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span>
                            <div class="detail-value">₫{{ number_format($monthSales, 0, ',', '.') }} VNĐ</div>
                            <div class="detail-name">Doanh thu tháng này</div>
                        </div>
                        <div class="statistic-details-item">
                            <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span>
                            <div class="detail-value">₫{{ number_format($yearSales, 0, ',', '.') }} VNĐ</div>
                            <div class="detail-name">Doanh thu năm nay</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
