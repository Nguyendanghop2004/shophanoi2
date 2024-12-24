<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BlogClient;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Tổng số admin
        $totalAdmin = Admin::count();
    
        // Tổng số bài viết
        $totalNews = BlogClient::count();
    
        // Tổng số sản phẩm
        $totalProducts = Product::count();
        $toltalOrder = Order::count();
    
        // Tổng số người dùng online
        $onlineUsers = User::where('status', 1)->count();
    
        // Doanh thu thống kê
        $todaySales = Order::whereDate('created_at', Carbon::today())
                           ->where('payment_status', 'đã thanh toán')  // Lọc theo trạng thái thanh toán
                           ->sum('total_price');

        $weekSales = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                          ->where('payment_status', 'đã thanh toán')  // Lọc theo trạng thái thanh toán
                          ->sum('total_price');  // Doanh thu tuần hiện tại
                          
        $monthSales = Order::whereMonth('created_at', Carbon::now()->month)
                           ->where('payment_status', 'đã thanh toán')  // Lọc theo trạng thái thanh toán
                           ->sum('total_price'); // Doanh thu tháng hiện tại
                           
        $yearSales = Order::whereYear('created_at', Carbon::now()->year)
                          ->where('payment_status', 'đã thanh toán')  // Lọc theo trạng thái thanh toán
                          ->sum('total_price');
    
        // Doanh thu của cả cửa hàng (tổng doanh thu từ tất cả các đơn hàng đã thanh toán)
        $totalStoreSales = Order::where('payment_status', 'đã thanh toán')  // Lọc theo trạng thái thanh toán
                                ->sum('total_price');  // Tổng doanh thu của cửa hàng
    
        // Doanh thu theo tuần gần nhất (4 tuần gần đây)
        $last4WeeksSales = [];
        for ($i = 0; $i < 4; $i++) {
            $last4WeeksSales[] = Order::whereBetween('created_at', [Carbon::now()->subWeeks($i+1)->startOfWeek(), Carbon::now()->subWeeks($i+1)->endOfWeek()])
                                      ->where('payment_status', 'đã thanh toán')  // Lọc theo trạng thái thanh toán
                                      ->sum('total_price');
        }
    
        // Doanh thu từng tháng trong năm
        $monthSalesData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthSalesData[] = Order::whereMonth('created_at', $month)
                                      ->whereYear('created_at', Carbon::now()->year)
                                      ->where('payment_status', 'đã thanh toán')  // Lọc theo trạng thái thanh toán
                                      ->sum('total_price');
        }
    
        // Truyền dữ liệu vào view
        return view('admin.dashboard.index', [
            'totalAdmin' => $totalAdmin,
            'totalNews' => $totalNews,
            'totalProducts' => $totalProducts,
            'onlineUsers' => $onlineUsers,
            'todaySales' => $todaySales,
            'weekSales' => $weekSales,  // Doanh thu tuần hiện tại
            'monthSales' => $monthSales,  // Doanh thu tháng hiện tại
            'yearSales' => $yearSales,
            'toltalOrder' => $toltalOrder,
            'totalStoreSales' => $totalStoreSales,  // Doanh thu của cả cửa hàng
            'last4WeeksSales' => $last4WeeksSales,
            'monthSalesData' => $monthSalesData  // Doanh thu theo từng tháng
        ]);
    }
}

