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

