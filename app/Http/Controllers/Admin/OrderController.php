<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Wards;
use App\Models\Shipper;
use App\Models\Province;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


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

    $query->where(function ($query) {
        $query->where('payment_method', '!=', 'vnpay')
              ->orWhere('payment_status', '!=', 'chờ thanh toán');
    });

    if ($request->has('payment_method') && !empty($request->payment_method)) {
        $query->where('payment_method', $request->payment_method);
    }

    // Lọc đơn hàng giao hàng thành công quá 7 ngày nếu filter_7_days được bật
    if ($request->has('filter_7_days')) {
        $loc7days = Carbon::now()->subDays(7);
        $query->where('status', 'giao hàng thành công')
              ->where('updated_at', '<', $loc7days);
    }

    $query->orderBy(DB::raw("status = 'chờ xác nhận'"), 'desc')
          ->orderBy('updated_at', 'desc');

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
            $shipper = Admin::where('id', $order->assigned_shipper_id)->first();
           
            return view('admin.order.chitiet', compact('order', 'city', 'province', 'ward', 'orderitems','shipper'));
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
        $currentStatus = $order->status;
        $newStatus = $request->input('status'); 
    
        if (
            ($currentStatus == 'chờ xác nhận' && !in_array($newStatus, ['chờ xác nhận', 'đã xác nhận', 'hủy'])) ||
            ($currentStatus == 'đã xác nhận' && !in_array($newStatus, ['đã xác nhận', 'hủy'])) ||
            ($currentStatus == 'ship đã nhận' && !in_array($newStatus, ['ship đã nhận', 'đang giao hàng'])) ||
            ($currentStatus == 'đang giao hàng' && !in_array($newStatus, ['đang giao hàng', 'giao hàng thành công', 'giao hàng không thành công'])) ||
            ($currentStatus == 'giao hàng thành công' && !in_array($newStatus, ['giao hàng thành công','đã nhận hàng'])) ||
            ($currentStatus == 'giao hàng không thành công' && !in_array($newStatus, ['giao hàng không thành công'])) ||
            ($currentStatus == 'đã nhận hàng' && !in_array($newStatus, ['đã nhận hàng'])) ||
            ($currentStatus == 'hủy' && !in_array($newStatus, ['hủy']))
        ) {
            return redirect()->route('admin.order.getList')->with('error', 'Trạng thái đã thay đổi.');
        }
    
      
        $order->status = $newStatus;
    
   
        if ($newStatus == 'hủy') {
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
    
        return redirect()->route('admin.order.getList')->with('success', 'Trạng thái đơn hàng đã được cập nhật từ ' . $currentStatus . ' sang ' . $newStatus . '.');
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


public function assignShipper(Request $request, $id)
{
    $request->validate([
        'assigned_shipper_id' => 'required|exists:admins,id'
    ], [
        'assigned_shipper_id.required' => 'Vui lòng chọn shipper.',
        'assigned_shipper_id.exists' => 'Shipper không hợp lệ.'
    ]);

    $order = Order::find($id);

    if ($order->assigned_shipper_id) {
        return redirect()->back()->with('error', 'Đơn hàng đã có shipper.');
    }

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

    $errship = [
        'ship đã nhận',
        'đang giao hàng',
        'giao hàng thành công',
        'đã nhận hàng',
        'giao hàng không thành công'
    ];

    if (in_array($order->status, $errship)) {
        return redirect()->route('admin.order.danhsachgiaohang')
            ->with('error', 'Không thể loại bỏ shipper vì đơn hàng đang ở trạng thái: ' . $order->status . '.');
    }

    if ($order->assigned_shipper_id) {
        $order->assigned_shipper_id = null;
        $order->save();

        return redirect()->route('admin.order.danhsachgiaohang')
            ->with('success', 'Đã loại bỏ shipper khỏi đơn hàng.');
    }

    return redirect()->route('admin.order.danhsachgiaohang')
        ->with('error', 'Đơn hàng không có shipper.');
}

public function updateStatusShip(Request $request, $id)
{
    $order = Order::find($id);

   
    if ($order->status == 'hủy') {
        return redirect()->route('admin.order.danhsachgiaohang')
            ->with('error', 'Đơn hàng đã bị hủy trước đó, không thể nhận đơn.');
    }
    $order->status = $request->input('status');
    if ($order->status == 'hủy') {
        $order->reason = $request->input('reason');
    } else {
        $order->reason = null; 
    }
    if ($order->status == 'giao hàng thành công') {
        $order->payment_status = 'đã thanh toán'; 
    }
    if ($order->status == 'giao hàng không thành công') {
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
    }
    $order->save();
    return redirect()->route('admin.order.danhsachgiaohang')
        ->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
}






}
