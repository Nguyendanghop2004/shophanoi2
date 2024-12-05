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
    public function cancel($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    
        if ($order->isCancellable()) {
            $order->status = 'hủy';
            $order->save();
            
            return redirect()->route('order.donhang')->with('success', 'Đơn hàng đã được hủy thành công.');
        }
    
        return redirect()->route('order.donhang')->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
    }
    
    
}
