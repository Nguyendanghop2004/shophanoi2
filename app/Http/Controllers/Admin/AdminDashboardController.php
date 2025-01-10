<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BlogClient;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\DiscountCode;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Request;

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
    $allDanhmuc=Category::count();
    $allmgg=DiscountCode::count();
    $allProduct=Product::count();
    $CountOrder = Order::count();
    // $CountUser = User::where('status', '1')->count();
    $activeUsersCount = User::where('status', '1')->count(); // User đang hoạt động
$inactiveUsersCount = User::where('status', '0')->count(); // User bị khóa
    $huy = Order::where('status', 'hủy')->count();
    $choXacNhan = Order::where('status', 'chờ xác nhận')->count();
    $daXacNhan = Order::where('status', 'đã xác nhận')->count();
    $giaoHangKhongTC = Order::where('status', 'giao hàng không thành công')->count();
    $dangGiaoHang = Order::where('status', 'đang giao hang')->count();
    $shipDaNhan = Order::where('status', 'ship đã nhận')->count();
    $daNhanHang = Order::where('status', 'đã nhận hàng')->count();
    $orderStatus=Order::distinct()->pluck('status');
    $orderStatusCounts = Order::select('status', \DB::raw('COUNT(*) as count'))
    ->groupBy('status')
    ->get();

    $labels = $orderStatusCounts->pluck('status'); // Lấy danh sách trạng thái
    $data = $orderStatusCounts->pluck('count'); // Lấy số lượng theo trạng thá

    $year = $year ?? now()->year;  
    $month = $month ?? now()->month; 
    $topProducts = DB::table('orders as o')
    ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
    ->where('o.status', 'giao hàng thành công') // Chỉ tính đơn hàng đã giao thành công
    ->selectRaw('
        oi.product_name,
        SUM(oi.quantity) as total_sold,
        SUM(oi.quantity * oi.price) as total_revenue
    ')
    ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
    ->orderByDesc('total_sold') // Sắp xếp giảm dần theo số lượng bán
    ->limit(5) // Lấy top 5 sản phẩm
    ->get();

    
//     $salesData = Order::whereYear('created_at', $year) 
//         ->whereMonth('created_at', $month)            
//         ->where('status', 'giao hàng thành công')             
//         ->selectRaw('DATE(created_at) as date, SUM(total_price) as total') 
//         ->groupBy('date')                            
//         ->orderBy('date')                            
//         ->get();

//     // Chuyển đổi dữ liệu doanh thu thành định dạng cho Chart.js
//     $dates = [];
//     $totals = [];

//     foreach ($salesData as $sale) {
//         $dates[] = $sale->date;  // Lấy ngày
//         $totals[] = $sale->total; // Lấy tổng doanh thu của ngày đó
//     }




    //bieu do nam

//     $sonam = Order::whereYear('created_at', $year)
//     ->where('status', 'giao hàng thành công')
//     ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
//     ->groupBy('month')
//     ->orderBy('month')
//     ->get();
//     $nam = [];
// $gia = [];

// foreach ($sonam as $sale) {
//     $nam[] = $sale->month;  // Lấy tháng (số)
//     $gia[] = $sale->total; // Lấy tổng doanh thu của tháng
// }

// // Tạo tên tháng bằng tiếng Việt
// $monthNames = [
//     1 => 'Tháng 1',
//     2 => 'Tháng 2',
//     3 => 'Tháng 3',
//     4 => 'Tháng 4',
//     5 => 'Tháng 5',
//     6 => 'Tháng 6',
//     7 => 'Tháng 7',
//     8 => 'Tháng 8',
//     9 => 'Tháng 9',
//     10 => 'Tháng 10',
//     11 => 'Tháng 11',
//     12 => 'Tháng 12',
// ];

// $monthLabels = array_map(fn($month) => $monthNames[$month], $nam);

//Biểu đồ doanh thu tháng trong năm
$sonam = Order::whereYear('created_at', $year)
    ->where('status', 'giao hàng thành công')
    ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
    ->groupBy('month')
    ->orderBy('month')
    ->get();

// Khởi tạo mảng dữ liệu đầy đủ
$firstMonth = $sonam->min('month') ?? 1; // Lấy tháng đầu tiên có dữ liệu
$lastMonth = $sonam->max('month') ?? 12; // Lấy tháng cuối cùng có dữ liệu

$fullMonths = collect(range($firstMonth, $lastMonth));

// Đảm bảo các tháng không có doanh thu được thêm vào với giá trị 0
$monthlyData = $fullMonths->mapWithKeys(function ($month) use ($sonam) {
    $sale = $sonam->firstWhere('month', $month);
    return [$month => $sale->total ?? 0];
});

// Tạo tên tháng bằng tiếng Việt
$monthNames = [
    1 => 'Tháng 1', 2 => 'Tháng 2', 3 => 'Tháng 3', 4 => 'Tháng 4',
    5 => 'Tháng 5', 6 => 'Tháng 6', 7 => 'Tháng 7', 8 => 'Tháng 8',
    9 => 'Tháng 9', 10 => 'Tháng 10', 11 => 'Tháng 11', 12 => 'Tháng 12',
];

$monthLabels = $monthlyData->keys()->map(fn($month) => $monthNames[$month])->toArray();
$gia = $monthlyData->values()->toArray();


//Biểu đồ doanh thu các ngày

// $salesData = Order::whereYear('created_at', $year)
//     ->whereMonth('created_at', $month)
//     ->where('status', 'giao hàng thành công')
//     ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
//     ->groupBy('date')
//     ->orderBy('date')
//     ->get();

// // Kiểm tra nếu $salesData không có dữ liệu
// if ($salesData->isEmpty()) {
//     $dates = [];
//     $totals = [];
// } else {
//     // Xác định ngày đầu tiên và cuối cùng
//     $firstDate = Carbon::parse($salesData->first()->date);
//     $lastDate = Carbon::parse($salesData->last()->date);

//     // Tạo danh sách tất cả các ngày từ ngày đầu tiên đến ngày cuối cùng
//     $allDates = [];
//     $currentDate = $firstDate->copy();
//     while ($currentDate <= $lastDate) {
//         $allDates[] = $currentDate->format('Y-m-d');
//         $currentDate->addDay();
//     }

//     // Đồng bộ dữ liệu doanh thu với danh sách ngày đầy đủ
//     $dates = $allDates;
//     $totals = [];
//     foreach ($dates as $date) {
//         $sale = $salesData->firstWhere('date', $date);
//         $totals[] = $sale ? $sale->total : 0; // Nếu không có doanh thu, gán giá trị 0
//     }
// }

// Lấy ngày đầu tiên có doanh thu
$firstSaleDate = Order::where('status', 'giao hàng thành công')
    ->orderBy('created_at', 'asc')
    ->value('created_at');

// Lấy ngày cuối cùng có doanh thu trong tháng sau
$lastSaleDate = Order::where('status', 'giao hàng thành công')
    ->where('created_at', '<=', Carbon::now()->addMonth()->endOfMonth())
    ->orderBy('created_at', 'desc')
    ->value('created_at');

// Kiểm tra nếu không có đơn hàng
if (!$firstSaleDate || !$lastSaleDate) {
    return [
        'dates' => [],
        'totals' => [],
    ];
}

// Tính khoảng thời gian
$firstDate = Carbon::parse($firstSaleDate)->startOfDay();
$lastDate = Carbon::parse($lastSaleDate)->endOfDay();

// Lấy dữ liệu doanh thu theo ngày
$salesData = Order::where('status', 'giao hàng thành công')
    ->whereBetween('created_at', [$firstDate, $lastDate])
    ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
    ->groupBy('date')
    ->orderBy('date')
    ->get();

// Tạo danh sách đầy đủ các ngày từ ngày bắt đầu đến ngày cuối cùng có doanh thu
$allDates = [];
$currentDate = $firstDate->copy();
while ($currentDate <= $lastDate) {
    $allDates[] = $currentDate->format('Y-m-d');
    $currentDate->addDay();
}

// Đồng bộ doanh thu với danh sách ngày đầy đủ
$dates = $allDates;
$totals = [];
foreach ($dates as $date) {
    $sale = $salesData->firstWhere('date', $date);
    $totals[] = $sale ? $sale->total : 0; // Nếu không có doanh thu, gán giá trị 0
}

$topUsers = Order::where('status', 'giao hàng thành công') // Chỉ tính đơn hàng đã giao thành công
    ->selectRaw('user_id, name, email, SUM(total_price) as total_spent, COUNT(id) as total_orders')
    ->groupBy('user_id', 'name', 'email') // Nhóm theo người dùng
    ->orderByDesc('total_spent') // Sắp xếp theo tổng tiền đã chi tiêu
    ->limit(5) // Lấy top 5 người dùng
    ->get();
    $totalRevenue = $topProducts->sum('total_revenue');

    $banitnhat = DB::table('orders as o')
    ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
    ->where('o.status', 'giao hàng thành công') // Chỉ tính đơn hàng đã giao thành công
    ->selectRaw('
        oi.product_name,
        SUM(oi.quantity) as total_sold,
        SUM(oi.quantity * oi.price) as total_revenue
    ')
    ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
    ->orderBy('total_sold') // Sắp xếp giảm dần theo số lượng bán
    ->limit(5) // Lấy top 5 sản phẩm
    ->get();
    $productsStock = DB::table('products')
    ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
    ->select('products.product_name as product_name', DB::raw('SUM(product_variants.stock_quantity) as total_stock'))
    ->groupBy('products.product_name')
    ->get(); 
     $tkSp = $productsStock->pluck('product_name'); // Tên sản phẩm
    $tkTonkho = $productsStock->pluck('total_stock'); 
// tỉnh
//     $salesData = DB::table('orders')
//     ->join('order_items', 'orders.id', '=', 'order_items.order_id')
//     ->join('tinhthanhpho', 'orders.province_id', '=', 'tinhthanhpho.matp')
//     ->select(
//         'orders.province_id',
//         DB::raw('SUM(order_items.quantity) as total_quantity'),
//         DB::raw('SUM(orders.total_price) as total_revenue'),
//         'tinhthanhpho.name_thanhpho as province_name'
//     )
//     ->where('orders.status', 'giao hàng thành công') // Lọc trạng thái đơn hàng
//     ->groupBy('orders.province_id', 'tinhthanhpho.name_thanhpho') // Group thêm theo tên tỉnh
//     ->get();

// // Dữ liệu cho biểu đồ
// $tenTinh = $salesData->pluck('province_name'); // Tên tỉnh
// $SoluongBan = $salesData->pluck('total_quantity'); // Số lượng bán
// $donhthuTinh = $salesData->pluck('total_revenue'); // Doanh thu




$salesData = DB::table('orders')
->join('order_items', 'orders.id', '=', 'order_items.order_id')
->join('tinhthanhpho', 'orders.city_id', '=', 'tinhthanhpho.matp')
->select(
    'orders.city_id',
    DB::raw('SUM(order_items.quantity) as total_quantity'),
    DB::raw('SUM(orders.total_price) as total_revenue'),
    'tinhthanhpho.name_thanhpho as city_name'
)
->where('orders.status', 'giao hàng thành công') // Lọc trạng thái đơn hàng
->groupBy('orders.city_id', 'tinhthanhpho.name_thanhpho') // Group thêm theo tên tỉnh
->get();

// Dữ liệu cho biểu đồ
$tenTinh = $salesData->pluck('city_name'); // Tên tỉnh
$SoluongBan = $salesData->pluck('total_quantity'); // Số lượng bán
$donhthuTinh = $salesData->pluck('total_revenue'); // Doanh thu

        return view('admin.dashboard.index',compact(
            'CountAdmin',
            'CountOrder',
            'dates','totals'
       ,'monthLabels','gia','huy','dangGiaoHang','giaoHangKhongTC','usersBought','labels','shipDaNhan','daNhanHang',
       'daXacNhan','choXacNhan','allOrder','tenTinh','SoluongBan','topUsers','allProduct','allmgg',
       'donhthuTinh','tkSp','tkTonkho','allDanhmuc','topProducts','totalRevenue','data','banitnhat','activeUsersCount', 'inactiveUsersCount'));
    }
    // public function tksanpham(Request $request) {
    //     $CountAdmin=Admin::count();
    //     // Lấy số lượng user đã mua hàng
    // $usersBought = DB::table('orders')
    // ->distinct('user_id') // Lấy các user_id không trùng lặp
    // ->whereNotNull('user_id') // Loại bỏ các đơn hàng không có user_id (nếu có)
    // ->count('user_id'); // Đếm số lượng user
    
    //     $allOrder=Order::count();
    //     $CountOrder = Order::where('status', 'giao hàng thành công')->count();
    //     $CountUser = User::where('status', '1')->count();
    //     $huy = Order::where('status', 'hủy')->count();
    //     $choXacNhan = Order::where('status', 'chờ_xác_nhận')->count();
    //     $daXacNhan = Order::where('status', 'đã_xác_nhận')->count();
    //     $dongHang = Order::where('status', 'đóng_hàng')->count();
    //     $dangGiaoHang = Order::where('status', 'đang_giao_hang')->count();
    
    //     $year = $year ?? now()->year;  
    //     $month = $month ?? now()->month; 
    //     $topProducts = DB::table('orders as o')
    //     ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
    //     ->where('o.status', 'giao hàng thành công') // Chỉ tính đơn hàng đã giao thành công
    //     ->selectRaw('
    //         oi.product_name,
    //         SUM(oi.quantity) as total_sold,
    //         SUM(oi.quantity * oi.price) as total_revenue
    //     ')
    //     ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
    //     ->orderByDesc('total_sold') // Sắp xếp giảm dần theo số lượng bán
    //     ->limit(5) // Lấy top 5 sản phẩm
    //     ->get();
    
        
    //     $salesData = Order::whereYear('created_at', $year) 
    //         ->whereMonth('created_at', $month)            
    //         ->where('status', 'giao hàng thành công')             
    //         ->selectRaw('DATE(created_at) as date, SUM(total_price) as total') 
    //         ->groupBy('date')                            
    //         ->orderBy('date')                            
    //         ->get();
    
    //     // Chuyển đổi dữ liệu doanh thu thành định dạng cho Chart.js
    //     $dates = [];
    //     $totals = [];
    
    //     foreach ($salesData as $sale) {
    //         $dates[] = $sale->date;  // Lấy ngày
    //         $totals[] = $sale->total; // Lấy tổng doanh thu của ngày đó
    //     }
    
    
    
    
    //     //bieu do nam
    
    //     $sonam = Order::whereYear('created_at', $year)
    //     ->where('status', 'giao hàng thành công')
    //     ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
    //     ->groupBy('month')
    //     ->orderBy('month')
    //     ->get();
    //     $nam = [];
    // $gia = [];
    
    // foreach ($sonam as $sale) {
    //     $nam[] = $sale->month;  // Lấy tháng (số)
    //     $gia[] = $sale->total; // Lấy tổng doanh thu của tháng
    // }
    
    // // Tạo tên tháng bằng tiếng Việt
    // $monthNames = [
    //     1 => 'Tháng 1',
    //     2 => 'Tháng 2',
    //     3 => 'Tháng 3',
    //     4 => 'Tháng 4',
    //     5 => 'Tháng 5',
    //     6 => 'Tháng 6',
    //     7 => 'Tháng 7',
    //     8 => 'Tháng 8',
    //     9 => 'Tháng 9',
    //     10 => 'Tháng 10',
    //     11 => 'Tháng 11',
    //     12 => 'Tháng 12',
    // ];
    
    // $monthLabels = array_map(fn($month) => $monthNames[$month], $nam);
    
    
    // $topUsers = Order::where('status', 'giao hàng thành công') // Chỉ tính đơn hàng đã giao thành công
    //     ->selectRaw('user_id, name, email, SUM(total_price) as total_spent, COUNT(id) as total_orders')
    //     ->groupBy('user_id', 'name', 'email') // Nhóm theo người dùng
    //     ->orderByDesc('total_spent') // Sắp xếp theo tổng tiền đã chi tiêu
    //     ->limit(5) // Lấy top 5 người dùng
    //     ->get();
    //     $totalRevenue = $topProducts->sum('total_revenue');
    
    //     $banitnhat = DB::table('orders as o')
    //     ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
    //     ->where('o.status', 'giao_hàng thành công') // Chỉ tính đơn hàng đã giao thành công
    //     ->selectRaw('
    //         oi.product_name,
    //         SUM(oi.quantity) as total_sold,
    //         SUM(oi.quantity * oi.price) as total_revenue
    //     ')
    //     ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
    //     ->orderBy('total_sold') // Sắp xếp giảm dần theo số lượng bán
    //     ->limit(5) // Lấy top 5 sản phẩm
    //     ->get();
    
    
    //         return view('admin.dashboard.sanpham',compact(
    //             'CountAdmin',
    //             'CountOrder',
    //             'CountUser','dates','totals'
    //        ,'monthLabels','gia','huy','dangGiaoHang','dongHang','usersBought','daXacNhan','choXacNhan','allOrder','topUsers','topProducts','totalRevenue','banitnhat'));
    //     }
    // public function tkadmin(){
    //     return view('admin.dashboard.account');
    // }
    // public function doanhthu(Request $request) {
    //     $CountAdmin=Admin::count();
    //     // Lấy số lượng user đã mua hàng
    // $usersBought = DB::table('orders')
    // ->distinct('user_id') // Lấy các user_id không trùng lặp
    // ->whereNotNull('user_id') // Loại bỏ các đơn hàng không có user_id (nếu có)
    // ->count('user_id'); // Đếm số lượng user
    
    //     $allOrder=Order::count();
    //     $CountOrder = Order::where('status', 'giao hàng thành công')->count();
    //     $CountUser = User::where('status', '1')->count();
    //     $huy = Order::where('status', 'hủy')->count();
    //     $choXacNhan = Order::where('status', 'chờ xác nhận')->count();
    //     $daXacNhan = Order::where('status', 'đã xác nhận')->count();
    //     $dongHang = Order::where('status', 'đóng hàng')->count();
    //     $dangGiaoHang = Order::where('status', 'đang giao hang')->count();
    
    //     $year = $year ?? now()->year;  
    //     $month = $month ?? now()->month; 
    //     $topProducts = DB::table('orders as o')
    //     ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
    //     ->where('o.status', 'giao hàng thành công') // Chỉ tính đơn hàng đã giao thành công
    //     ->selectRaw('
    //         oi.product_name,
    //         SUM(oi.quantity) as total_sold,
    //         SUM(oi.quantity * oi.price) as total_revenue
    //     ')
    //     ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
    //     ->orderByDesc('total_sold') // Sắp xếp giảm dần theo số lượng bán
    //     ->limit(5) // Lấy top 5 sản phẩm
    //     ->get();
    
        
    //     $salesData = Order::whereYear('created_at', $year) 
    //         ->whereMonth('created_at', $month)            
    //         ->where('status', 'giao hàng thành công')             
    //         ->selectRaw('DATE(created_at) as date, SUM(total_price) as total') 
    //         ->groupBy('date')                            
    //         ->orderBy('date')                            
    //         ->get();
    
    //     // Chuyển đổi dữ liệu doanh thu thành định dạng cho Chart.js
    //     $dates = [];
    //     $totals = [];
    
    //     foreach ($salesData as $sale) {
    //         $dates[] = $sale->date;  // Lấy ngày
    //         $totals[] = $sale->total; // Lấy tổng doanh thu của ngày đó
    //     }
    
    
    
    
    //     //bieu do nam
    
    //     $sonam = Order::whereYear('created_at', $year)
    //     ->where('status', 'giao hàng thành công')
    //     ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
    //     ->groupBy('month')
    //     ->orderBy('month')
    //     ->get();
    //     $nam = [];
    // $gia = [];
    
    // foreach ($sonam as $sale) {
    //     $nam[] = $sale->month;  // Lấy tháng (số)
    //     $gia[] = $sale->total; // Lấy tổng doanh thu của tháng
    // }
    
    // // Tạo tên tháng bằng tiếng Việt
    // $monthNames = [
    //     1 => 'Tháng 1',
    //     2 => 'Tháng 2',
    //     3 => 'Tháng 3',
    //     4 => 'Tháng 4',
    //     5 => 'Tháng 5',
    //     6 => 'Tháng 6',
    //     7 => 'Tháng 7',
    //     8 => 'Tháng 8',
    //     9 => 'Tháng 9',
    //     10 => 'Tháng 10',
    //     11 => 'Tháng 11',
    //     12 => 'Tháng 12',
    // ];
    
    // $monthLabels = array_map(fn($month) => $monthNames[$month], $nam);
    
    
    // $topUsers = Order::where('status', 'giao hàng thành công') // Chỉ tính đơn hàng đã giao thành công
    //     ->selectRaw('user_id, name, email, SUM(total_price) as total_spent, COUNT(id) as total_orders')
    //     ->groupBy('user_id', 'name', 'email') // Nhóm theo người dùng
    //     ->orderByDesc('total_spent') // Sắp xếp theo tổng tiền đã chi tiêu
    //     ->limit(5) // Lấy top 5 người dùng
    //     ->get();
    //     $totalRevenue = $topProducts->sum('total_revenue');
    
    //     $banitnhat = DB::table('orders as o')
    //     ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
    //     ->where('o.status', 'giao hàng thành công') // Chỉ tính đơn hàng đã giao thành công
    //     ->selectRaw('
    //         oi.product_name,
    //         SUM(oi.quantity) as total_sold,
    //         SUM(oi.quantity * oi.price) as total_revenue
    //     ')
    //     ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
    //     ->orderBy('total_sold') // Sắp xếp giảm dần theo số lượng bán
    //     ->limit(5) // Lấy top 5 sản phẩm
    //     ->get();
    
    
    //         return view('admin.dashboard.doanhthu',compact(
    //             'CountAdmin',
    //             'CountOrder',
    //             'CountUser','dates','totals'
    //        ,'monthLabels','gia','huy','dangGiaoHang','dongHang','usersBought','daXacNhan','choXacNhan','allOrder','topUsers','topProducts','totalRevenue','banitnhat'));
    //     }

    public function index1()
    {
        
        $totalAdmin = Admin::count();
    
      
        $totalNews = BlogClient::count();
    
        
        $totalProducts = Product::count();
        $toltalOrder = Order::count();
    
      
        $onlineUsers = User::where('status', 1)->count();


        $todaySales = Order::whereDate('created_at', Carbon::today())
                           ->where('payment_status', 'đã thanh toán')  
                           ->sum('total_price');

        $weekSales = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                          ->where('payment_status', 'đã thanh toán') 
                          ->sum('total_price');
                          
        $monthSales = Order::whereMonth('created_at', Carbon::now()->month)
                           ->where('payment_status', 'đã thanh toán') 
                           ->sum('total_price'); 
                           
        $yearSales = Order::whereYear('created_at', Carbon::now()->year)
                          ->where('payment_status', 'đã thanh toán')  
                          ->sum('total_price');
    
       
        $totalStoreSales = Order::where('payment_status', 'đã thanh toán')  
                                ->sum('total_price'); 
    
   
        $last4WeeksSales = [];
        for ($i = 0; $i < 4; $i++) {
            $last4WeeksSales[] = Order::whereBetween('created_at', [Carbon::now()->subWeeks($i+1)->startOfWeek(), Carbon::now()->subWeeks($i+1)->endOfWeek()])
                                      ->where('payment_status', 'đã thanh toán') 
                                      ->sum('total_price');
        }
    
     
        $monthSalesData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthSalesData[] = Order::whereMonth('created_at', $month)
                                      ->whereYear('created_at', Carbon::now()->year)
                                      ->where('payment_status', 'đã thanh toán')
                                      ->sum('total_price');
        }
    
   
        return view('admin.dashboard.index', [
            'totalAdmin' => $totalAdmin,
            'totalNews' => $totalNews,
            'totalProducts' => $totalProducts,
            'onlineUsers' => $onlineUsers,
            'todaySales' => $todaySales,
            'weekSales' => $weekSales,  
            'monthSales' => $monthSales,  
            'yearSales' => $yearSales,
            'toltalOrder' => $toltalOrder,
            'totalStoreSales' => $totalStoreSales,
            'last4WeeksSales' => $last4WeeksSales,
            'monthSalesData' => $monthSalesData  
        ]);
    }
}

