<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Order;
use App\Models\Wards;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

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
    
        // Tạo thư mục qr_codes nếu chưa tồn tại
        $qrCodesDir = storage_path('app/public/qr_codes');
        if (!File::exists($qrCodesDir)) {
            File::makeDirectory($qrCodesDir, 0777, true);
        }
    
        // Tạo mã QR và lưu vào tệp tạm thời
        $qrCode = QrCode::size(150)->generate($order->id);  // Thay đổi kích thước tùy theo nhu cầu
        $tempPath = $qrCodesDir . '/hoadon_' . $order->order_code . '.png';
        file_put_contents($tempPath, $qrCode);
    
        // Cấu hình DOMPDF để sử dụng font Unicode
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.order.hoadon', compact('order', 'orderitems', 'city', 'province', 'ward', 'tempPath'));
    
        // Cấu hình để DOMPDF hỗ trợ font Unicode
        $options = [
            'isHtml5ParserEnabled' => true,  
            'isPhpEnabled' => true,        
            'font_dir' => storage_path('fonts'),  
            'font_cache' => storage_path('fonts')
        ];
    
        $pdf->setOptions($options);
    
        // Xóa tệp mã QR tạm thời sau khi sử dụng
        unlink($tempPath);
    
        // Trả về file PDF
        return $pdf->download('hoa_don_' . 'HN CLOTHESSHOP' . '.pdf');
    }
    

    public function updateStatus(Request $request, $id)
{
    $order = Order::find($id);
    $order->status = $request->input('status');
    
    if ($order->status == 'hủy') {
        $order->reason = $request->input('reason');
    } else {
        $order->reason = null; 
    }
    $order->save();

    return redirect()->route('admin.order.getList')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
}

}
