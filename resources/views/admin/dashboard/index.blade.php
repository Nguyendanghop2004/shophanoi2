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
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Lọc và Thống Kê Doanh Thu</h4>
                        <div class="btn-group">
                            <a href="#" class="btn btn-light" id="show-week">Tuần</a>
                            <a href="#" class="btn btn-light" id="show-month">Tháng</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.dashboard.index.filter') }}" class="form-inline mb-4">
                            @csrf
                            <div class="form-group mr-3">
                                <label for="start-date" class="mr-2">Từ ngày:</label>
                                <input type="date" id="start-date" name="start_date" class="form-control"
                                    value="{{ $startDate->format('Y-m-d') }}"
                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            <div class="form-group mr-3">
                                <label for="end-date" class="mr-2">Đến ngày:</label>
                                <input type="date" id="end-date" name="end_date" class="form-control"
                                    value="{{ $endDate->format('Y-m-d') }}"
                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Lọc</button>
                        </form>
            
                        <canvas id="bieudo1" height="50" width="150"></canvas>
            
                        <div class="statistic-details mt-4">
                            <h6 class="text-primary font-weight-bold">
                                Tổng doanh thu (từ {{ $startDate->format('d-m-Y') }} đến {{ $endDate->format('d-m-Y') }}): 
                                <span class="text-danger">{{ number_format(array_sum($totals), 0, ',', '.') }} VND</span>
                            </h6>
                            <h6 class="text-primary font-weight-bold">
                                Tổng doanh thu tháng: 
                                <span class="text-danger">{{ number_format($totalGia, 0, ',', '.') }} VND</span>
                            </h6>
                            <h6 class="text-primary font-weight-bold">
                                Tổng doanh thu chờ thanh toán: 
                                <span class="text-danger">{{ number_format($totalUnpaidRevenue, 0, ',', '.') }} VND</span>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            

            {{-- biểu đồ tỉnh col-12 col-md-6 col-lg-6 --}}
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Doanh thu theo tỉnh</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="50" width="150"></canvas>
                    </div>
                </div>
            </div>
            


        </div>
        {{-- Biểu đồ thống kê đơn hàng theo trạng thái  --}}
        <div class="col-12 d-flex flex-wrap">
            <!-- Biểu đồ thống kê đơn hàng -->
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Biểu đồ thống kê đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart3" width="300px" height="400px"></canvas>
                    </div>
                </div>
            </div>
        
            <!-- Biểu đồ tồn kho -->
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Biểu đồ tồn kho</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart4"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container mt-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Số lượng tồn kho</h4>
                </div>
                <div class="card-body">
                    <h5 class="text-success mb-3"><i class="fas fa-boxes"></i> Danh sách sản phẩm</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col" class="text-center">Tồn kho</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td class="text-center font-weight-bold text-primary">{{ $product->total_stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination">
        {{ $products->links() }}
    </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="col-12 d-flex flex-wrap">
            <!-- Top 5 Sản phẩm bán chạy nhất -->
            <div class="card col-lg-6 col-md-12 mb-4 shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Top 5 Sản Phẩm Bán Chạy Nhất</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <p class="text-muted mb-1">Tổng số tiền từ các sản phẩm</p>
                        <h4 class="text-success font-weight-bold">{{ number_format($totalRevenue) }} VNĐ</h4>
                    </div>
                    <ul class="list-unstyled">
                        @foreach ($topProducts as $product)
                            <li class="media align-items-center mb-3 p-2 border-bottom">
                                <img class="mr-3 rounded" width="50" height="50" src="assets/img/products/product-1-50.png" alt="product">
                                <div class="media-body">
                                    <h6 class="font-weight-bold mb-1">
                                        <a href="#" class="text-dark">{{ $product->product_name }}</a>
                                    </h6>
                                    <div class="d-flex justify-content-between text-muted">
                                        <span>Đã bán: <strong>{{ $product->total_sold }}</strong></span>
                                        <span><strong>{{ number_format($product->total_revenue) }} VNĐ</strong></span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        
            <!-- Top 5 Sản phẩm bán ít nhất -->
            <div class="card col-lg-6 col-md-12 mb-4 shadow-sm border-0">
                <div class="card-header bg-warning text-dark text-center">
                    <h4 class="mb-0">Top 5 Sản Phẩm Bán Ít Nhất</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach ($banitnhat as $product)
                            <li class="media align-items-center mb-3 p-2 border-bottom">
                                <img class="mr-3 rounded-circle" width="50" height="50" src="assets/img/avatar/avatar-1.png" alt="avatar">
                                <div class="media-body">
                                    <h6 class="font-weight-bold mb-1">
                                        <a href="#" class="text-dark">{{ $product->product_name }}</a>
                                    </h6>
                                    <div class="d-flex justify-content-between text-muted">
                                        <span>Đã bán: <strong>{{ $product->total_sold }}</strong></span>
                                        <span><strong>{{ number_format($product->total_revenue) }} VNĐ</strong></span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
        

        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-center">Top 5 User Mua Hàng Nhiều Nhất</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach ($topUsers as $user)
                            <li class="media mb-4 align-items-center">
                                <img class="mr-3 rounded-circle border border-secondary" width="50" height="50"
                                    src="assets/img/avatar/avatar-1.png" alt="avatar">
                                <div class="media-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 font-weight-bold">{{ $user->user_name }}</h6>
                                        <span class="badge badge-success">Đã mua: {{ $user->total_items }}</span>
                                    </div>
                                    <small class="text-muted">{{ $user->user_email }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
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
