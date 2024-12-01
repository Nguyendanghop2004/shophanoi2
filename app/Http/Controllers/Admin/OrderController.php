<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wards;
use App\Models\Province;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function getList(Request $request)
    {
        $query = Order::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('order_code', 'like', '%' . $search . '%')
                      ->orWhere('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->paginate(10);

        return view('admin.order.getList', compact('orders'));
    }

    public function chitiet($id)
    {
        $order = Order::findOrFail($id);
        $orderitems = OrderItem::where('order_id',$order->id)->get();
        $city = City::where('matp', $order->city_id)->first();
        $province = Province::where('maqh', $order->province_id)->first();
        $ward = Wards::where('xaid', $order->wards_id)->first();
      
        return view('admin.order.chitiet', compact('order', 'city', 'province', 'ward','orderitems'));
    }
    public function inhoadon($id)
    {
        $order = Order::findOrFail($id);
        $orderitems = OrderItem::where('order_id', $order->id)->get();
        $city = City::where('matp', $order->city_id)->first();
        $province = Province::where('maqh', $order->province_id)->first();
        $ward = Wards::where('xaid', $order->wards_id)->first();
    
        // Cấu hình DOMPDF để sử dụng font Unicode
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.order.hoadon', compact('order', 'orderitems', 'city', 'province', 'ward'));
    
        // Cấu hình để DOMPDF hỗ trợ font Unicode
        $options = [
            'isHtml5ParserEnabled' => true,  
            'isPhpEnabled' => true,        
            'font_dir' => storage_path('fonts'),  
            'font_cache' => storage_path('fonts')
        ];
    
       
        $pdf->setOptions($options);
    
        
        return $pdf->download('hoa_don_'.$order->order_code.'.pdf');
    }
    
    
    

    public function updateStatus(Request $request, $id)
{
    $order = Order::find($id);
    $order->status = $request->input('status');
    if ($order->status == 'hủy') {
        $order->reason = $request->input('reason');
    } else {
        $order->reason = null; // Đặt lại lý do hủy nếu trạng thái không phải là đã hủy
    }
    $order->save();

    return redirect()->route('admin.order.getList')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
}

}
