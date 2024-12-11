<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin;
use App\Models\Order;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
   public function index(Request $request) {
    $CountAdmin=Admin::count();
    $allOrder=Order::count();
    $CountOrder = Order::where('status', 'giao_hàng_thành_công')->count();
    $CountUser = User::where('status', '1')->count();
    $huy = Order::where('status', 'hủy')->count();
    $choXacNhan = Order::where('status', 'chờ_xác_nhận')->count();
    $daXacNhan = Order::where('status', 'đã_xác_nhận')->count();
    $dongHang = Order::where('status', 'đóng_hàng')->count();
    $dangGiaoHang = Order::where('status', 'đang_giao_hang')->count();

    $year = $year ?? now()->year;  
    $month = $month ?? now()->month; 

    
    $salesData = Order::whereYear('created_at', $year) 
        ->whereMonth('created_at', $month)            
        ->where('status', 'giao_hàng_thành_công')             
        ->selectRaw('DATE(created_at) as date, SUM(total_price) as total') 
        ->groupBy('date')                            
        ->orderBy('date')                            
        ->get();

    // Chuyển đổi dữ liệu doanh thu thành định dạng cho Chart.js
    $dates = [];
    $totals = [];

    foreach ($salesData as $sale) {
        $dates[] = $sale->date;  // Lấy ngày
        $totals[] = $sale->total; // Lấy tổng doanh thu của ngày đó
    }




    //bieu do nam

    $sonam = Order::whereYear('created_at', $year)
    ->where('status', 'giao_hàng_thành_công')
    ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
    ->groupBy('month')
    ->orderBy('month')
    ->get();
    $nam = [];
$gia = [];

foreach ($sonam as $sale) {
    $nam[] = $sale->month;  // Lấy tháng (số)
    $gia[] = $sale->total; // Lấy tổng doanh thu của tháng
}

// Tạo tên tháng bằng tiếng Việt
$monthNames = [
    1 => 'Tháng 1',
    2 => 'Tháng 2',
    3 => 'Tháng 3',
    4 => 'Tháng 4',
    5 => 'Tháng 5',
    6 => 'Tháng 6',
    7 => 'Tháng 7',
    8 => 'Tháng 8',
    9 => 'Tháng 9',
    10 => 'Tháng 10',
    11 => 'Tháng 11',
    12 => 'Tháng 12',
];

$monthLabels = array_map(fn($month) => $monthNames[$month], $nam);


    


        return view('admin.dashboard.index',compact(
            'CountAdmin',
            'CountOrder',
            'CountUser','dates','totals'
       ,'monthLabels','gia','huy','dangGiaoHang','dongHang','daXacNhan','choXacNhan','allOrder'));
    }
}
