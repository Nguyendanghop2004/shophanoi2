<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
{
    $query = Order::query();

    if ($request->filled('order_code')) {
        $query->where('order_code', 'like', '%' . $request->order_code . '%');
    }

    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    $orders = $query->orderBy('id', 'DESC')->paginate(10);

    return view('admin.order.getList', compact('orders'));
}

    public function getList(){
        $orders = Order::paginate(10);
        return view('admin.order.getList', compact('orders'));
    }

    public function chitiet($id)
    {
        $order = Order::findOrFail($id);
        $city = City::where('matp', $order->city_id)->first();
        $province = Province::where('maqh', $order->province_id)->first();
        $ward = Wards::where('xaid', $order->wards_id)->first();
        return view('admin.order.chitiet', compact('order', 'city', 'province', 'ward'));
    }
    public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $order->status = $request->input('status');
    $order->save();

    return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
}
}
