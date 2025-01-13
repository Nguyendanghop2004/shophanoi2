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
// use Request;
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
    $allDanhmuc=Category::count();
    $allmgg=DiscountCode::count();
    $allProduct=Product::count();
     $giaoHangTC = Order::where('status', 'giao hàng thành công')->count();
    $CountOrder = Order::count();
    // $CountUser = User::where('status', '1')->count();
   
$inactiveUsersCount = User::where('status', '1')->count(); // User bị khóa
$activeUsersCount = User::where('status', '0')->count(); // User đang hoạt động
    $huy = Order::where('status', 'hủy')->count();
    $choXacNhan = Order::where('status', 'chờ xác nhận')->count();
    $daXacNhan = Order::where('status', 'đã xác nhận')->count();
    $giaoHangKhongTC = Order::where('status', 'giao hàng không thành công')->count();
    $giaoHangTC = Order::where('status', 'giao hàng thành công')->count();
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
    ->where('o.status', 'đã nhận hàng') // Chỉ tính đơn hàng đã giao thành công
    ->selectRaw('
        oi.product_name,
        SUM(oi.quantity) as total_sold,
        SUM(oi.quantity * oi.price) as total_revenue
    ')
    ->groupBy('oi.product_name') // Gom nhóm theo sản phẩm
    ->orderByDesc('total_sold') // Sắp xếp giảm dần theo số lượng bán
    ->limit(5) // Lấy top 5 sản phẩm
    ->get();

    
    $currentYear = now()->year;
    $previousYear = $currentYear - 1;
    $nextYear = $currentYear + 1;
 
    // Lấy doanh thu từ năm trước và năm sau (bao gồm cả những tháng có doanh thu)
    $revenue = Order::whereIn(\DB::raw('YEAR(created_at)'), [$previousYear, $currentYear, $nextYear])
        ->where('payment_status', 'đã thanh toán')  // Lọc theo trạng thái thanh toán
        ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as total')
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();
 
    // Khởi tạo mảng chứa doanh thu theo tháng và năm
    $monthlyData = [];
 
    // Điền vào dữ liệu doanh thu của các tháng có doanh thu
    foreach ($revenue as $sale) {
        // Kết hợp tháng và năm
        $monthYear = 'Tháng ' . $sale->month . ', ' . $sale->year;
        $monthlyData[$monthYear] = $sale->total;
    }
 
    // Mảng chứa tất cả các tháng trong năm trước, năm hiện tại và năm sau
    $fullMonths = collect(range(1, 12));  // Các tháng từ 1 đến 12
    $years = [$previousYear, $currentYear, $nextYear];
 
    // Đảm bảo các tháng có doanh thu sẽ được thêm vào kết quả
    $resultData = collect();
 
    foreach ($years as $year) {
        foreach ($fullMonths as $month) {
            $monthYear = 'Tháng ' . $month . ', ' . $year;
            // Chỉ hiển thị những tháng có doanh thu
            if (isset($monthlyData[$monthYear]) && $monthlyData[$monthYear] > 0) {
                $resultData[$monthYear] = $monthlyData[$monthYear];
            }
        }
    }
 
    // Chuyển đổi Collection thành array
    $monthLabels = $resultData->keys()->toArray();
    $gia = $resultData->values()->toArray();
 
    // Tính tổng doanh thu
    $totalGia = array_sum($gia);



       
                // Ngày kết thúc mặc định là cuối ngày hiện tại
                $endDate = Carbon::now()->endOfDay();
        
                // Ngày bắt đầu: từ input hoặc mặc định 7 ngày trước ngày kết thúc
                $startDate = $request->input('start_date')
                    ? Carbon::parse($request->input('start_date'))->startOfDay()
                    : $endDate->copy()->subDays(6)->startOfDay();
        
                // Ngày kết thúc: từ input hoặc mặc định là hôm nay
                $endDate = $request->input('end_date')
                    ? Carbon::parse($request->input('end_date'))->endOfDay()
                    : $endDate;
        
                // Nếu không chọn ngày, tự động giới hạn trong 7 ngày hiện tại
                if (!$request->has('start_date') && !$request->has('end_date')) {
                    $startDate = $endDate->copy()->subDays(6)->startOfDay();
                }
        
                // Lấy dữ liệu doanh thu từ cơ sở dữ liệu
                $salesData = Order::where('payment_status', 'đã thanh toán')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
        
                // Tạo danh sách đầy đủ các ngày trong khoảng thời gian
                $allDates = [];
                $currentDate = $startDate->copy();
                while ($currentDate <= $endDate) {
                    $allDates[] = $currentDate->format('Y-m-d');
                    $currentDate->addDay();
                }
        
                // Đồng bộ dữ liệu doanh thu với danh sách ngày
                $dates = $allDates;
                $totals = [];
                foreach ($dates as $date) {
                    $sale = $salesData->firstWhere('date', $date);
                    $totals[] = $sale ? $sale->total : 0;
                }
        
                // Tính tổng doanh thu đã thanh toán
                $totalRevenue = array_sum($totals);
        
                // Tính tổng doanh thu chưa thanh toán
                $totalUnpaidRevenue = DB::table('orders')
                    ->where('payment_status', 'chờ thanh toán')
                    ->sum('total_price');
        
                // Trả về dữ liệu
              

                $topUsers = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->select(
                    'orders.user_id',
                    'orders.name as user_name',
                    'orders.email as user_email',
                    DB::raw('SUM(order_items.quantity) as total_items')
                )
                ->where('orders.status', 'đã nhận hàng')
                ->groupBy('orders.user_id', 'orders.name', 'orders.email')
                ->orderByDesc('total_items')
                ->limit(5)
                ->get();
    $totalRevenue = $topProducts->sum('total_revenue');

    $banitnhat = DB::table('orders as o')
    ->join('order_items as oi', 'o.id', '=', 'oi.order_id') // Liên kết bảng orders và order_items
    ->where('o.status', 'đã nhận hàng') // Chỉ tính đơn hàng đã giao thành công
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
       // Truy vấn dữ liệu từ bảng `product_stocks`
       $products = DB::table('products')
       ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
       ->select('products.product_name', DB::raw('SUM(product_variants.stock_quantity) as total_stock'))
       ->groupBy('products.id', 'products.product_name')
       ->get();



$salesData = DB::table('orders')
->join('order_items', 'orders.id', '=', 'order_items.order_id')
->join('tinhthanhpho', 'orders.city_id', '=', 'tinhthanhpho.matp')
->select(
    'orders.city_id',
    DB::raw('SUM(order_items.quantity) as total_quantity'),
    DB::raw('SUM(orders.total_price) as total_revenue'),
    'tinhthanhpho.name_thanhpho as city_name'
)
->where('orders.payment_status', 'đã thanh toán') 
->groupBy('orders.city_id', 'tinhthanhpho.name_thanhpho') 
->get();

// Dữ liệu cho biểu đồ
$tenTinh = $salesData->pluck('city_name'); // Tên tỉnh
$SoluongBan = $salesData->pluck('total_quantity'); // Số lượng bán
$donhthuTinh = $salesData->pluck('total_revenue'); // Doanh thu

        return view('admin.dashboard.index',compact(
            'CountAdmin',
            'CountOrder','giaoHangTC',
            'dates','totals'
       ,'monthLabels','gia','huy','dangGiaoHang','giaoHangKhongTC','usersBought','labels','shipDaNhan','daNhanHang',
       'daXacNhan','choXacNhan','allOrder','tenTinh','SoluongBan','topUsers','allProduct','allmgg',
       'donhthuTinh','tkSp','tkTonkho','allDanhmuc','topProducts','totalRevenue','data','banitnhat','activeUsersCount', 'inactiveUsersCount', 'startDate', 'endDate','totalRevenue', 'totalRevenue', 'year','totalGia','totalUnpaidRevenue','products' ));
    }
 

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

