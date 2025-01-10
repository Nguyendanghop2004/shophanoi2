@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <a href="{{ route('admin.accounts.account') }}">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                    </a>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tài khoản Admin</h4>
                        </div>
                        <div class="card-body">
                            {{ $CountAdmin }}
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <a href="{{ route('admin.categories.list') }}">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                    </a>
                    <div class="</a>card-wrap">
                        <div class="card-header">
                            <h4>Só danh mục</h4>
                        </div>
                        <div class="card-body">
                            {{ $allDanhmuc }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">

                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Só mã giảm giá</h4>
                        </div>
                        <div class="card-body">
                            {{ $allmgg }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <a href="{{ route('admin.product.index') }}">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Só sản phẩm</h4>
                            </div>
                            <div class="card-body">
                                {{ $allProduct }}
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                <div class="card card-statistic-1">
                    <a href="{{ route('admin.order.getList') }}">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>

                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Đơn hàng</h4>
                            </div>
                            <div class="card-body">
                                {{ $CountOrder }}
                            </div>
                        </div>
                </div>
            </div>

            {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <a href="{{ route('admin.accountsUser.accountUser') }}">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tài khoản User</h4>
                        </div>
                        <div class="card-body">
                            {{ $CountUser }}

                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
            <!-- User đang hoạt động -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <a href="{{ route('admin.accountsUser.accountUser') }}">
                        <div class="card-icon bg-success">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </a>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>User Đang Hoạt Động</h4>
                        </div>
                        <div class="card-body">
                            {{ $activeUsersCount }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- User bị khóa -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <a href="{{ route('admin.accountsUser.accountUser') }}">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-user-lock"></i>
                        </div>
                    </a>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>User Bị Khóa</h4>
                        </div>
                        <div class="card-body">
                            {{ $inactiveUsersCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>Biểu đồ doanh thu</h4>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">


                        <div class="card-header-action">
                            <div>

                            </div>
                            <div class="card-header-action ">
                                <form method="POST" action="{{ route('admin.dashboard.index.filter') }}">
                                    @csrf
                                    <div>
                                        <label for="start-date">Từ ngày:</label>

                                        {{-- <input type="date" id="start-date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" onchange="updateEndDate()" > --}}
                                        <input type="date" id="start-date" name="start_date"
                                            value="{{ $startDate->format('Y-m-d') }}"
                                            max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    </div>
                            </div>
                        </div>
                        <div>
                            <label for="end-date">Đến ngày:</label>
                            {{-- <input type="date" id="end-date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" disabled> --}}
                            <input type="date" id="end-date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Lọc</button>
                        </form>

                        <div class="btn-group ">
                            <a href="#" class="btn btn-primary" id="show-week">Week</a>
                            <a href="#" class="btn" id="show-month">Month</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="bieudo1" height="182"></canvas>
                    <div class="statistic-details mt-sm-4">
                        <h8>
                            Tổng doanh thu (từ {{ $startDate->format('d-m-Y') }} đến {{ $endDate->format('d-m-Y') }}):
                            {{ number_format(array_sum($totals), 0, ',', '.') }} VND
                        </h8>
                        <br>
                        <h8>
                            Tổng doanh thu tháng: {{ number_format($totalGia, 0, ',', '.') }} VND
                        </h8>
                        <br>
                        <h8>
                            Tổng doanh thu chờ thanh toán: {{ number_format($totalUnpaidRevenue, 0, ',', '.') }} VND
                        </h8>

                    </div>
                </div>

            </div>

            {{-- biểu đồ tỉnh col-12 col-md-6 col-lg-6 --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Doanh thu theo tỉnh</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Thống kê đơn hàng</h4>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <div>
                                <i class="fas fa-clipboard-list fa-3x" style="font-size: 60px;"></i>
                                <!-- Biểu tượng danh sách đơn hàng -->
                            </div>
                            <div class="mt-2 font-weight-bold">Tất cả đơn hàng</div>
                            <div class="text-muted text-small"><span class="text-primary"><i
                                        class="fas fa-caret-up"></i></span> {{ $allOrder }}</div>
                        </div>
                        <div class="col text-center">
                            <div>
                                <i class="fas fa-times-circle text-danger" style="font-size: 60px;"></i>
                            </div>
                            <div class="mt-2 font-weight-bold">Hủy</div>
                            <div class="text-muted text-small"><span class="text-primary"><i
                                        class="fas fa-caret-up"></i></span> {{ $huy }}</div>
                        </div>
                        <div class="col text-center">
                            <div>
                                <i class="fas fa-truck-loading fa-5x" style="font-size: 60px; color: #28a745;"></i>
                                <!-- Biểu tượng giao hàng không thành công -->
                            </div>
                            <div class="mt-2 font-weight-bold">Giao hàng không thành công</div>
                            <div class="text-muted text-small"><span class="text-danger"><i
                                        class="fas fa-caret-down"></i></span>{{ $giaoHangKhongTC }}</div>
                        </div>
                        <div class="col text-center">
                            <div>
                                <i class="fas fa-hourglass-half fa-5x text-warning" style="font-size: 60px;"></i>
                            </div>
                            <div class="mt-2 font-weight-bold">Chờ xác nhận</div>
                            <div class="text-muted text-small">{{ $choXacNhan }}</div>
                        </div>
                        <div class="col text-center">
                            <div>
                                <i class="fas fa-check-circle" style="font-size: 60px; color: blue;"></i>
                                <!-- Dấu kiểm lớn hơn -->
                            </div>
                            <div class="mt-2 font-weight-bold">Đã xác nhận</div>
                            <div class="text-muted text-small"><span class="text-primary"><i
                                        class="fas fa-caret-up"></i></span> {{ $daXacNhan }}</div>
                        </div>
                        <div class="col text-center">
                            <div>
                                <i class="fas fa-check-circle fa-5x text-success" style="font-size: 60px;"></i>

                            </div>
                            <div class="mt-2 font-weight-bold">Đã nhận hàng</div>
                            <div class="text-muted text-small"><span class="text-primary"><i
                                        class="fas fa-caret-up"></i></span> {{ $daNhanHang }}</div>
                        </div>
                        <div class="col text-center">
                            <div>
                                <i class="fas fa-shipping-fast fa-5x text-info" style="font-size: 60px;"></i>
                                <!-- Biểu tượng giao hàng nhanh -->
                            </div>
                            <div class="mt-2 font-weight-bold">Đang giao hàng</div>
                            <div class="text-muted text-small"><span class="text-primary"><i
                                        class="fas fa-caret-up"></i></span> {{ $dangGiaoHang }}</div>
                        </div>
                        <div class="col text-center">
                            <div>
                                <i class="fas fa-box fa-5x text-info" style="font-size: 60px;"></i>
                                <!-- Biểu tượng "Ship đã nhận" -->
                            </div>
                            <div class="mt-2 font-weight-bold">Ship đã nhận</div>
                            <div class="text-muted text-small"><span class="text-primary"><i
                                        class="fas fa-caret-up"></i></span> {{ $shipDaNhan }}</div>
                        </div>
                        <div class="col text-center">
                            <div>
                                <i class="fas fa-check fa-5x text-success" style="font-size: 60px;"></i>
                                <!-- Biểu tượng dấu kiểm -->
                            </div>
                            <div class="mt-2 font-weight-bold">Giao hàng thành công</div>
                            <div class="text-muted text-small"><span class="text-primary"><i
                                        class="fas fa-caret-up"></i></span> {{ $giaoHangTC }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- Biểu đồ thống kê đơn hàng theo trạng thái  --}}
        <div class="col-12 d-flex">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Biểu đồ thống kê đơn hàng </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart3" width="300px" height="400px"></canvas>
                    </div>
                </div>
            </div>
            {{-- KC bểu đồ tồn kho --}}

            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Biểu đồ tồn kho</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart4"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card ">
                <div class="card-header">
                    <h4>Thống kê tồn kho sản phẩm</h4>
                </div>
                <div class="card-body">
                    <div class="section-title mt-0">Danh sách sản phẩm</div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Số lượng tồn kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->total_stock }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 d-flex">
            <div class="card col-6">
                <div class="card-header">
                    <h4>Top 5 sản phẩm bán chạy nhất</h4>
                    <div class="card-header-action">
                        <div class="dropdown">
                            {{-- <a href="#" class="dropdown-toggle btn btn-primary"
                                    data-toggle="dropdown">Filter</a> --}}
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i>
                                    Electronic</a>
                                <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i>
                                    T-shirt</a>
                                <a href="#" class="dropdown-item has-icon"><i class="far fa-circle"></i>
                                    Hat</a>
                                <div class="dropdown-divider"></div>
                                {{-- <a href="#" class="dropdown-item">View All</a> --}}
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
                                            <div class="media-right">{{ number_format($product->total_revenue, 2) }}
                                            </div>
                                            <div class="media-title"><a href="#">{{ $product->product_name }}</a>
                                            </div>
                                            <div class="text-muted text-small"> <a href="#">Đã bán:
                                                    {{ $product->total_sold }}</a>
                                                <div class="bullet"></div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card col-6">
                <div class="card-header">
                    <h4 class="d-inline">Top 5 sản phẩm bán được ít nhất</h4>
                    {{-- <div class="card-header-action">
                            <a href="#" class="btn btn-primary">View All</a>
                        </div> --}}
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border">

                        @foreach ($banitnhat as $product)
                            <li class="media">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="cbx-4">
                                    {{-- <label class="custom-control-label" for="cbx-4"></label> --}}
                                </div>
                                <img class="mr-3 rounded-circle" width="50" src="assets/img/avatar/avatar-1.png"
                                    alt="avatar">
                                <div class="media-body">
                                    {{-- <div class="badge badge-pill badge-danger mb-1 float-right">Not
                                        Finished</div> --}}
                                    <h6 class="media-title"><a href="#">{{ $product->product_name }}</a>
                                    </h6>
                                    <div class="text-small text-muted">Đã bán: {{ $product->total_sold }}<div
                                            class="bullet">
                                            {{-- </div> {{ number_format($product->total_revenue, 2) }}</div> --}}
                                            <div class="media-right">{{ number_format($product->total_revenue, 2) }}
                                            </div>
                                        </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex">
            <div class="col-lg-5 col-md-12 col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="d-inline">Top 5 User Mua Hàng Nhiều Nhất</h4>

                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach ($topUsers as $user)
                                <li class="media mb-3">
                                    <img class="mr-3 rounded-circle" width="50" src="assets/img/avatar/avatar-1.png"
                                        alt="avatar">
                                    <div class="media-body">
                                        <div class="float-right text-primary">Đã mua:{{ $user->total_items }}</div>
                                        <div class="media-title">{{ $user->user_name }}</div>
                                        <span class="text-small text-muted">{{ $user->user_email }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Biểu đồ thống kê theo sản phẩm bán ít nhất</h4>
                    </div>

                    <div class="card-body">
                        @foreach ($banitnhat as $item)
                            <div class="mb-4">
                                <div class="text-small float-right font-weight-bold text-muted">{{ $item->total_sold }}
                                </div>
                                <div class="font-weight-bold mb-1">{{ $item->product_name }}</div>
                                <div class="progress" data-height="3">
                                    <div class="progress-bar" role="progressbar" data-width="{{ $item->total_sold }}"
                                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function updateEndDate() {
            let startDate = document.getElementById('start-date').value;
            if (startDate) {
                let startDateObj = new Date(startDate);
                startDateObj.setDate(startDateObj.getDate() + 6); // Thêm 10 ngày
                let endDate = startDateObj.toISOString().split('T')[0]; // Định dạng thành yyyy-mm-dd
                document.getElementById('end-date').value = endDate; // Cập nhật ô "Đến ngày"
            }
        }
        var ctx = document.getElementById("bieudo1").getContext('2d');





        // Biểu đồ đầu tiên (tuần)
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @JSON($dates), // Dữ liệu ngày
                datasets: [{
                    label: 'Danh thu (VND)',
                    data: @JSON($totals), // Dữ liệu doanh thu tuần
                    borderWidth: 2,
                    backgroundColor: '#6777ef',
                    borderColor: '#6777ef',
                    borderWidth: 3,
                    tension: 0,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 4
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                }).format(value);
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Biểu đồ thứ hai (tháng)
        var myChart2 = null; // Để chưa khởi tạo biểu đồ tháng

        // Chuyển đổi giữa biểu đồ tuần và tháng
        document.getElementById('show-week').addEventListener('click', function(e) {
            e.preventDefault();

            // Hủy biểu đồ tháng nếu tồn tại
            if (myChart2) {
                myChart2.destroy();
                myChart2 = null;
            }

            // Khởi tạo lại biểu đồ tuần nếu chưa tồn tại
            if (!myChart) {
                myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @JSON($dates),
                        datasets: [{
                            label: 'Danh thu (VND)',
                            data: @JSON($totals),
                            borderWidth: 2,
                            backgroundColor: '#6777ef',
                            borderColor: '#6777ef',
                            borderWidth: 3.5,
                            tension: 0.4,
                            pointBackgroundColor: '#ffffff',
                            pointRadius: 4
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN', {
                                            style: 'currency',
                                            currency: 'VND'
                                        }).format(value);
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Đổi nút trạng thái
            this.classList.add('btn-primary');
            document.getElementById('show-month').classList.remove('btn-primary');
        });

        document.getElementById('show-month').addEventListener('click', function(e) {
            e.preventDefault();

            // Hủy biểu đồ tuần nếu tồn tại
            if (myChart) {
                myChart.destroy();
                myChart = null;
            }

            // Khởi tạo biểu đồ tháng nếu chưa tồn tại
            if (!myChart2) {
                myChart2 = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @JSON($monthLabels),
                        datasets: [{
                            label: 'Danh thu (VND)',
                            data: @JSON($gia),
                            borderWidth: 2,
                            backgroundColor: '#6777ef',
                            borderColor: '#6777ef',
                            borderWidth: 3.5,
                            tension: 0,
                            pointBackgroundColor: '#ffffff',
                            pointRadius: 4
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN', {
                                            style: 'currency',
                                            currency: 'VND'
                                        }).format(value);
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Đổi nút trạng thái
            this.classList.add('btn-primary');
            document.getElementById('show-week').classList.remove('btn-primary');
        });




        // biểu đồ tragnj thai
        var oiu = document.getElementById("myChart3").getContext('2d');
        var myChart3 = new Chart(oiu, {
            type: 'doughnut',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($data),
                    backgroundColor: [
                        '#191d21',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                    ],

                }],

            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });
        // Biểu  đồ tồn kho 
        var abc = document.getElementById("myChart4").getContext('2d');
        var myChart4 = new Chart(abc, {
            type: 'pie',
            data: {
                labels: @json($tkSp),
                datasets: [{
                    data: @json($tkTonkho),
                    backgroundColor: [
                        '#191d21',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                    ]
                }],

            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });

        var edc = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(edc, {
            type: 'bar', // Biểu đồ cột
            data: {
                labels: @json($tenTinh), // Danh sách tên các tỉnh
                datasets: [{
                        label: 'Số lượng bán',
                        data: @json($SoluongBan), // Dữ liệu số lượng bán
                        backgroundColor: 'rgba(54, 162, 235, 0.7)', // Màu cột
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Doanh thu (VND)',
                        data: @json($donhthuTinh), // Dữ liệu doanh thu
                        backgroundColor: 'rgba(255, 99, 132, 0.7)', // Màu cột
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                if (context.dataset.label === 'Doanh thu (VND)') {
                                    value = new Intl.NumberFormat('vi-VN', {
                                        style: 'currency',
                                        currency: 'VND'
                                    }).format(value);
                                }
                                return `${context.dataset.label}: ${value}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN', {
                                    style: 'decimal'
                                }).format(value);
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
