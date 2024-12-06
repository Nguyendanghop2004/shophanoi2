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
        // Kiểm tra xem đơn hàng có tồn tại và thuộc về người dùng hiện tại hay không
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        // Kiểm tra nếu đơn hàng có thể hủy
        if ($order->isCancellable()) {
            // Xử lý lý do hủy
            $request->validate([
                'reason' => 'required|string|max:255', // Kiểm tra lý do hủy
            ]);
            
            // Cập nhật lý do hủy và trạng thái của đơn hàng
            $order->reason = $request->input('reason');
            $order->status = 'hủy'; // Cập nhật trạng thái đơn hàng thành 'hủy'
            $order->save();
    
            // Redirect sau khi hủy đơn hàng thành công
            return redirect()->route('order.donhang')->with('success', 'Đơn hàng đã được hủy thành công.');
        }
    
        // Nếu đơn hàng không thể hủy, trả về thông báo lỗi
        return redirect()->route('order.donhang', ['status' => 'hủy'])->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
    }
    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->confirm();

        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận thành công.');
    }
    
   
    
}
