@extends('admin.layouts.master')
@section('content')
<section class="section">


<div class="row">
    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Doanh thu theo ngày trong tháng</h4>
                <div class="card-header-action">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary" id="show-week">Week</a>
                        <a href="#" class="btn" id="show-month">Month</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="bieudo1" height="182"></canvas>
                <div class="statistic-details mt-sm-4">

                    {{-- <div class="statistic-details-item">
                    <span class="text-muted"><span class="text-primary"><i
                                class="fas fa-caret-up"></i></span> 7%</span>
                    <div class="detail-value">{{$totals}}</div>
                    <div class="detail-name">Today's Sales</div>
                </div> --}}

                    {{-- <div class="statistic-details-item">
                    <span class="text-muted"><span class="text-danger"><i
                                class="fas fa-caret-down"></i></span> 23%</span>
                    <div class="detail-value">$2,902</div>
                    <div class="detail-name">This Week's Sales</div>
                </div>
                <div class="statistic-details-item">
                    <span class="text-muted"><span class="text-primary"><i
                                class="fas fa-caret-up"></i></span>9%</span>
                    <div class="detail-value">$12,821</div>
                    <div class="detail-name">This Month's Sales</div>
                </div>
                <div class="statistic-details-item">
                    <span class="text-muted"><span class="text-primary"><i
                                class="fas fa-caret-up"></i></span> 19%</span>
                    <div class="detail-value">$92,142</div>
                    <div class="detail-name">This Year's Sales</div>
                </div> --}}
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
    document.getElementById('show-week').classList.remove('btn-primary');
});

</script>


@endpush
