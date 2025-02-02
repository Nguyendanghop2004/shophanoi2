<?php

namespace App\Http\Controllers\client;

use Mail;
use App\Models\City;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Wards;
use App\Models\Province;
use App\Models\OrderItem;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Mail\OrderConfirmationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if (!Auth::check()) {
        return redirect('/');
    }

    $user = Auth::user();
    
    $status = $request->query('status', '');
    
    $query = Order::where('user_id', $user->id);
    $query->where(function($query) {
        $query->where('payment_method', '!=', 'vnpay')
              ->orWhere('payment_status', '!=', 'chờ thanh toán');
    });
    if ($status !== '') {
        $query->where('status', $status);
    }
    
    $orders = $query->with('orderItems')  
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
    
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
    public function show($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
    
            $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    
            $orderitems = $order->orderItems->map(function ($item) {
                return $item;
            });
    
            $city = City::where('matp', $order->city_id)->first();
            $province = Province::where('maqh', $order->province_id)->first();
            $ward = Wards::where('xaid', $order->wards_id)->first();
            $shipper = Admin::where('id', $order->assigned_shipper_id)->first();

            return view('client.orders.show', compact('order', 'orderitems', 'city', 'province', 'ward','shipper'));
        } catch (DecryptException $e) {
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            return redirect()->back();
        }
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function cancel(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    
        $nonCancellableStatuses = [
            'ship đã nhận',
            'đang giao hàng',
            'giao hàng thành công',
            'giao hàng không thành công',
            'đã nhận hàng',
            'hủy'
        ];
    
        if (in_array($order->status, $nonCancellableStatuses)) {
            return redirect()->route('order.donhang')->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
        }
    
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);
    
        $order->reason = $request->input('reason');
        $order->status = 'hủy';
    
        foreach ($order->orderItems as $orderItem) {
            $productVariant = ProductVariant::withTrashed()
                ->where('product_id', $orderItem->product_id)
                ->where('color_id', $orderItem->color_id)
                ->where('size_id', $orderItem->size_id)
                ->first();
    
            if ($productVariant) {
                $productVariant->stock_quantity += $orderItem->quantity;
                $productVariant->save();
            }
        }
    
        // Lưu thay đổi
        $order->save();
    
        return redirect()->route('order.donhang')->with('success', 'Đơn hàng đã được hủy thành công.');
    }
    
    

    
    
    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status === 'đã nhận hàng') {
            return redirect()->back()->with('error', 'Đơn hàng đã được xác nhận trước đó.');
        }
        if ($order->status === 'chưa nhận được hàng') {
            return redirect()->back()->with('error', 'Đơn hàng đã báo chưa nhận được hàng cho shop vui lòng chờ xử lí .');
        }
        $order->confirm();

        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận thành công.');
    }
    public function notReceived(Request $request, $id)
{
    $order = Order::findOrFail($id);

    if ($order->status === 'đã nhận hàng') {
        return redirect()->back()->with('error', 'Không thể ghi nhận lý do vì đơn hàng đã được xác nhận là "Đã nhận hàng".');
    }
    if ($order->status === 'giao hàng thành công') {
        $reason = $request->input('reason');

        $order->update([
            'status' => 'chưa nhận được hàng',
            'reason_faile_order' => $reason,
        ]);

        return redirect()->back()->with('success', 'Đã ghi nhận lý do chưa nhận được hàng.');
    }

    return redirect()->back()->with('error', 'Không thể ghi nhận lý do cho đơn hàng này.');
}


    public function search(Request $request)

{
    $query = $request->input('query');

    if (empty($query)) {
        return redirect()->back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm.');
    }

    $orders = Order::where('name', 'LIKE', "%{$query}%")
        ->orWhere('order_code', 'LIKE', "%{$query}%")
        ->orWhere('email', 'LIKE', "%{$query}%")
        ->orWhere('phone_number', 'LIKE', "%{$query}%")
        ->get();

    foreach ($orders as $order) {
        $order->city = City::where('matp', $order->city_id)->first();
        $order->province = Province::where('maqh', $order->province_id)->first();
        $order->ward = Wards::where('xaid', $order->wards_id)->first();
    }

    return view('client.orders.search', compact('orders'));
}

    
   
    public function showCancelReasonForm($order_code = null)
    {
       
        if (!$order_code) {
            return redirect()->route('cart')->with('error', 'Mã đơn hàng không hợp lệ.');
        }


        
        $decodedOrderCode = Crypt::decryptString($order_code);
        if (!$decodedOrderCode) {
            return redirect()->route('cart')->with('error', 'Mã đơn hàng không hợp lệ.');
        }
       
        $order = Order::where('order_code', $decodedOrderCode)->first();

      
        if (!$order) {
            return redirect()->route('cart')->with('error', 'Không thể hủy đơn hàng này vì không tồn tại.');
        }

        
        $nonCancelableStatuses = ['đã xác nhận', 'đang giao hàng', 'giao hàng thành công', 'đã nhận hàng', 'hủy'];
    
     
        if (in_array($order->status, $nonCancelableStatuses)) {
            return redirect()->route('home')->with('error', 'Không thể hủy đơn hàng này vì đã chuyển sang trạng thái khác.');
        }

      
        return view('emails.cancel_order', compact('order'));
    }

   
    public function createCancelOrderUrl($order_code)
    {
        
        $encodedOrderCode = Crypt::encryptString($order_code);
        
        
        return route('cancel.order.page', ['order_code' => $encodedOrderCode]);
    }
    public function cancelOrder(Request $request)
    {
        $order_code = $request->order_code;
        $reason = $request->reason;
    
        
        $order = Order::where('order_code', $order_code)->first();
    
        if (!$order) {
            return redirect()->route('home')->with('error', 'Không thể hủy đơn hàng này vì đã chuyển sang trạng thái khác.');
        }
    
       
        $nonCancelableStatuses = ['ship đã nhận', 'đang giao hàng', 'giao hàng thành công','giao hàng không thành công','đã nhận hàng'];
    
        if (in_array($order->status, $nonCancelableStatuses)) {
            return redirect()->route('home')->with('error', 'Không thể hủy đơn hàng này vì đã chuyển sang trạng thái khác.'.$order->status);
        }
    
     
        $order->status = 'hủy';
        $order->reason = $reason;
        $order->save();
    
       
        foreach ($order->orderItems as $item) {
         
            $variant = ProductVariant::where('product_id', $item->product_id)
                ->where('size_id', $item->size_id)  
                ->where('color_id', $item->color_id) 
                ->first();
    
          
            if ($variant) {
                $variant->stock_quantity += $item->quantity;  
                $variant->save(); 
            }
        }
    
        return redirect()->route('home')->with('success', 'Đơn hàng đã được hủy thành công.');
    }
    
    public function showOrderDetail($encryptedOrderCode)
    {
        try {
          
            $order_code = Crypt::decryptString($encryptedOrderCode);
    
           
            $order = Order::where('order_code', $order_code)->firstOrFail();
    
           
            $city = City::where('matp', $order->city_id)->first();
            $province = Province::where('maqh', $order->province_id)->first();
            $ward = Wards::where('xaid', $order->wards_id)->first();
    
           
            $orderitems = $order->orderItems;
    
           
            return view('client.orders.detail', compact('order', 'city', 'province', 'ward', 'orderitems'));
        } catch (DecryptException $e) {
          
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
          
            return redirect()->back();
        } catch (\Exception $e) {
           
            return redirect()->back();
        }
    }
  public function confirm($orderId)
{
    $order = Order::findOrFail($orderId);


    if ($order->status === 'giao hàng thành công') {
      
        $order->status = 'đã nhận hàng';
        $order->save();

      
        return redirect()->route('home')->with('success', 'Cảm ơn bạn đã nhận hàng!');
    }

  
    if ($order->status === 'đã nhận hàng') {
        return redirect()->route('home')->with('error', 'Đơn hàng đã được nhận hàng, không thể thay đổi trạng thái.');
    }

   
    return redirect()->route('home')->with('error', 'Trạng thái đơn hàng không hợp lệ.');
}



}