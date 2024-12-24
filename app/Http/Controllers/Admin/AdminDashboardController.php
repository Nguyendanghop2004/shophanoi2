<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
   public function index(Request $request) {
    $CountAdmin=Admin::count();
    // Lấy số lượng user đã mua hàng
$usersBought = DB::table('orders')
->distinct('user_id') // Lấy các user_id không trùng lặp
->whereNotNull('user_id') // Loại bỏ các đơn hàng không có user_id (nếu có)
->count('user_id'); // Đếm số lượng user

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
    $topProducts = DB::table('orders as o')
    ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
    ->where('o.status', 'giao_hàng_thành_công') // Chỉ tính đơn hàng đã giao thành công
    ->selectRaw('
        oi.product_name,
        SUM(oi.quantity) as total_sold,
        SUM(oi.quantity * oi.price) as total_revenue
    ')
    ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
    ->orderByDesc('total_sold') // Sắp xếp giảm dần theo số lượng bán
    ->limit(5) // Lấy top 5 sản phẩm
    ->get();

    
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


$topUsers = Order::where('status', 'giao_hàng_thành_công') // Chỉ tính đơn hàng đã giao thành công
    ->selectRaw('user_id, name, email, SUM(total_price) as total_spent, COUNT(id) as total_orders')
    ->groupBy('user_id', 'name', 'email') // Nhóm theo người dùng
    ->orderByDesc('total_spent') // Sắp xếp theo tổng tiền đã chi tiêu
    ->limit(5) // Lấy top 5 người dùng
    ->get();
    $totalRevenue = $topProducts->sum('total_revenue');

    $banitnhat = DB::table('orders as o')
    ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
    ->where('o.status', 'giao_hàng_thành_công') // Chỉ tính đơn hàng đã giao thành công
    ->selectRaw('
        oi.product_name,
        SUM(oi.quantity) as total_sold,
        SUM(oi.quantity * oi.price) as total_revenue
    ')
    ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
    ->orderBy('total_sold') // Sắp xếp giảm dần theo số lượng bán
    ->limit(5) // Lấy top 5 sản phẩm
    ->get();


        return view('admin.dashboard.index',compact(
            'CountAdmin',
            'CountOrder',
            'CountUser','dates','totals'
       ,'monthLabels','gia','huy','dangGiaoHang','dongHang','usersBought','daXacNhan','choXacNhan','allOrder','topUsers','topProducts','totalRevenue','banitnhat'));
    }
    public function tksanpham(Request $request) {
        $CountAdmin=Admin::count();
        // Lấy số lượng user đã mua hàng
    $usersBought = DB::table('orders')
    ->distinct('user_id') // Lấy các user_id không trùng lặp
    ->whereNotNull('user_id') // Loại bỏ các đơn hàng không có user_id (nếu có)
    ->count('user_id'); // Đếm số lượng user
    
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
        $topProducts = DB::table('orders as o')
        ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
        ->where('o.status', 'giao_hàng_thành_công') // Chỉ tính đơn hàng đã giao thành công
        ->selectRaw('
            oi.product_name,
            SUM(oi.quantity) as total_sold,
            SUM(oi.quantity * oi.price) as total_revenue
        ')
        ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
        ->orderByDesc('total_sold') // Sắp xếp giảm dần theo số lượng bán
        ->limit(5) // Lấy top 5 sản phẩm
        ->get();
    
        
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
    
    
    $topUsers = Order::where('status', 'giao_hàng_thành_công') // Chỉ tính đơn hàng đã giao thành công
        ->selectRaw('user_id, name, email, SUM(total_price) as total_spent, COUNT(id) as total_orders')
        ->groupBy('user_id', 'name', 'email') // Nhóm theo người dùng
        ->orderByDesc('total_spent') // Sắp xếp theo tổng tiền đã chi tiêu
        ->limit(5) // Lấy top 5 người dùng
        ->get();
        $totalRevenue = $topProducts->sum('total_revenue');
    
        $banitnhat = DB::table('orders as o')
        ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
        ->where('o.status', 'giao_hàng_thành_công') // Chỉ tính đơn hàng đã giao thành công
        ->selectRaw('
            oi.product_name,
            SUM(oi.quantity) as total_sold,
            SUM(oi.quantity * oi.price) as total_revenue
        ')
        ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
        ->orderBy('total_sold') // Sắp xếp giảm dần theo số lượng bán
        ->limit(5) // Lấy top 5 sản phẩm
        ->get();
    
    
            return view('admin.dashboard.sanpham',compact(
                'CountAdmin',
                'CountOrder',
                'CountUser','dates','totals'
           ,'monthLabels','gia','huy','dangGiaoHang','dongHang','usersBought','daXacNhan','choXacNhan','allOrder','topUsers','topProducts','totalRevenue','banitnhat'));
        }
    public function tkadmin(){
        return view('admin.dashboard.account');
    }
    public function doanhthu(Request $request) {
        $CountAdmin=Admin::count();
        // Lấy số lượng user đã mua hàng
    $usersBought = DB::table('orders')
    ->distinct('user_id') // Lấy các user_id không trùng lặp
    ->whereNotNull('user_id') // Loại bỏ các đơn hàng không có user_id (nếu có)
    ->count('user_id'); // Đếm số lượng user
    
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
        $topProducts = DB::table('orders as o')
        ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
        ->where('o.status', 'giao_hàng_thành_công') // Chỉ tính đơn hàng đã giao thành công
        ->selectRaw('
            oi.product_name,
            SUM(oi.quantity) as total_sold,
            SUM(oi.quantity * oi.price) as total_revenue
        ')
        ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
        ->orderByDesc('total_sold') // Sắp xếp giảm dần theo số lượng bán
        ->limit(5) // Lấy top 5 sản phẩm
        ->get();
    
        
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
    
    
    $topUsers = Order::where('status', 'giao_hàng_thành_công') // Chỉ tính đơn hàng đã giao thành công
        ->selectRaw('user_id, name, email, SUM(total_price) as total_spent, COUNT(id) as total_orders')
        ->groupBy('user_id', 'name', 'email') // Nhóm theo người dùng
        ->orderByDesc('total_spent') // Sắp xếp theo tổng tiền đã chi tiêu
        ->limit(5) // Lấy top 5 người dùng
        ->get();
        $totalRevenue = $topProducts->sum('total_revenue');
    
        $banitnhat = DB::table('orders as o')
        ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
        ->where('o.status', 'giao_hàng_thành_công') // Chỉ tính đơn hàng đã giao thành công
        ->selectRaw('
            oi.product_name,
            SUM(oi.quantity) as total_sold,
            SUM(oi.quantity * oi.price) as total_revenue
        ')
        ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
        ->orderBy('total_sold') // Sắp xếp giảm dần theo số lượng bán
        ->limit(5) // Lấy top 5 sản phẩm
        ->get();
    
    
            return view('admin.dashboard.doanhthu',compact(
                'CountAdmin',
                'CountOrder',
                'CountUser','dates','totals'
           ,'monthLabels','gia','huy','dangGiaoHang','dongHang','usersBought','daXacNhan','choXacNhan','allOrder','topUsers','topProducts','totalRevenue','banitnhat'));
        }

}
