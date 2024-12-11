<?php

namespace App\Http\Controllers\client;

use App\Models\City;
use App\Models\Order;
use App\Models\Wards;
use App\Models\Province;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $user = Auth::user();

    $status = $request->query('status', 'chờ_xác_nhận');

    $orders = Order::where('user_id', $user->id)
        ->where('status', $status)
        ->paginate(10);

    return view('client.orders.donhang', compact('orders', 'status'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $orderitems = $order->orderItems;
        $city = City::where('matp', $order->city_id)->first();
       $province = Province::where('maqh', $order->province_id)->first();
       $ward = Wards::where('xaid', $order->wards_id)->first();

        return view('client.orders.show', compact('order', 'orderitems', 'city', 'province', 'ward'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function cancel(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($order->isCancellable()) {
            $request->validate([
                'reason' => 'required|string|max:255', 
            ]);
            
            $order->reason = $request->input('reason');
            $order->status = 'hủy'; 
            
            $order->status_hủy_at = now(); 
            
            $order->save();
    
            return redirect()->route('order.donhang')->with('success', 'Đơn hàng đã được hủy thành công.');
        }
        
        return redirect()->route('order.donhang', ['status' => 'hủy'])->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
    }
    
    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->confirm();

        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // Tìm kiếm các đơn hàng dựa trên query
        $orders = Order::where('name', 'LIKE', "%{$query}%")
            ->orWhere('order_code', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('phone_number', 'LIKE', "%{$query}%")
            ->get();
    
        // Lấy thông tin thành phố, quận, phường cho từng đơn hàng
        foreach ($orders as $order) {
            $order->city = City::where('matp', $order->city_id)->first();
            $order->province = Province::where('maqh', $order->province_id)->first();
            $order->ward = Wards::where('xaid', $order->wards_id)->first();
        }
        
    
        // Trả về kết quả cho view
        return view('client.orders.search', compact('orders'));
    }
    

    
   
    
}
