<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Admin;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\Wards;
use App\Models\Shipper;
use App\Models\Province;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;


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

    public function chitiet($encryptedId)
    {
        try {
         
            $id = Crypt::decryptString($encryptedId);
            
            
            $order = Order::findOrFail($id);
            
      
            $orderitems = OrderItem::where('order_id', $order->id)->get();
            $city = City::where('matp', $order->city_id)->first();
            $province = Province::where('maqh', $order->province_id)->first();
            $ward = Wards::where('xaid', $order->wards_id)->first();
            
           
            return view('admin.order.chitiet', compact('order', 'city', 'province', 'ward', 'orderitems'));
        } catch (DecryptException $e) {
           
            return redirect()->route('admin.error')->with('error', 'Dữ liệu không hợp lệ!');
        } catch (ModelNotFoundException $e) {
           
            return redirect()->route('admin.error')->with('error', 'Không tìm thấy đơn hàng!');
        }
    }
    

    public function inhoadon($encryptedOrderId)
    {
        try {
       
            $orderId = Crypt::decryptString($encryptedOrderId);
    
           
            $order = Order::findOrFail($orderId);
    
       
            $orderitems = OrderItem::where('order_id', $order->id)->get();
    
           
            $city = City::where('matp', $order->city_id)->first();
            $province = Province::where('maqh', $order->province_id)->first();
            $ward = Wards::where('xaid', $order->wards_id)->first();
    
        
            $pdf = Pdf::loadView('admin.order.hoadon', compact('order', 'orderitems', 'city', 'province', 'ward'));
    
            
            $options = [
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'font_dir' => storage_path('fonts'),
                'font_cache' => storage_path('fonts'),
            ];
    
            $pdf->setOptions($options);
    
    
            return $pdf->download('hoa_don_' . $order->order_code . '.pdf');
        } catch (DecryptException $e) {
           
            return redirect()->route('admin.error');
        } catch (ModelNotFoundException $e) {
          
            return redirect()->route('admin.error');
        } catch (\Exception $e) {
           
            return redirect()->route('admin.error');
        }
    }
    
    

    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = $request->input('status');
        
       
        if ($order->status == 'hủy') {
            $order->reason = $request->input('reason');
            
           
            foreach ($order->orderItems as $orderItem) {
               
                $variant = ProductVariant::where('product_id', $orderItem->product_id)
                    ->where('color_id', $orderItem->color_id) 
                    ->where('size_id', $orderItem->size_id)  
                    ->first();
        
             
                if ($variant) {
                    $variant->stock_quantity += $orderItem->quantity;  
                    $variant->save();  
                }
            }
        } else {
            $order->reason = null; 
        }
        
        $order->save();
    
        return redirect()->route('admin.order.getList')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }

public function showAssignShipperForm()
{
    $orders = Order::whereNull('assigned_shipper_id')
                   ->whereIn('status', ['đã xác nhận'])
                   ->get();

  
    $shippers = Admin::whereHas('roles', function ($query) {
        $query->where('name', 'Shipper');
    })->get();

    return view('admin.order.assign', compact('orders', 'shippers'));
}


public function assignShipper(Request $request, Order $order ,$id)
{
    $request->validate([
        'assigned_shipper_id' => 'required|exists:admins,id'
    ], [
        'assigned_shipper_id' => 'Vui lòng chọn shipper.',
    ]);
    $order = Order::find($id);
        $order->assigned_shipper_id = $request->assigned_shipper_id;
        $order->save();

        return redirect()->back()->with('success', 'Đã cấp đơn hàng cho shipper.');
}
public function danhsachgiaohang()
{
    $orders = Order::whereNotNull('assigned_shipper_id')->where('status', '!=', 'hủy')->get();
    $user = Auth::user(); 

    if ($user->hasRole('admin')) {
        $shippers = Admin::whereHas('roles', function ($query) {
            $query->where('name', 'Shipper');
        })->get();
    } else {
        $orders = Order::where('assigned_shipper_id', $user->id)->where('status', '!=', 'hủy')->get();
    }

    $shippers = Admin::whereHas('roles', function ($query) {
        $query->where('name', 'Shipper');
    })->get();
    return view('admin.order.danhsachgiaohang', compact('orders', 'shippers'));
}
public function removeShipper($orderId)
{
    $order = Order::findOrFail($orderId);

    if ($order->assigned_shipper_id) {
        $order->assigned_shipper_id = null;
        $order->save();

        return redirect()->route('admin.order.danhsachgiaohang')->with('success', 'Đã loại bỏ đơn hàng.');
    }

    return redirect()->route('admin.order.danhsachgiaohang')->with('error', 'Đơn hàng không có shipper.');
}
public function updateStatusShip(Request $request, $id)
{
    $order = Order::find($id);
    $order->status = $request->input('status');
    
    if ($order->status == 'hủy') {
        $order->reason = $request->input('reason');
    } else {
        $order->reason = null; 
    }
    if ($order->status == 'giao hàng thành công') {
        $order->payment_status = 'đã thanh toán'; 
    }
    $order->save();

    return redirect()->route('admin.order.danhsachgiaohang')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
}





}
