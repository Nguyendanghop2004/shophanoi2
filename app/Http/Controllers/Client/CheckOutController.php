<?php

namespace App\Http\Controllers\Client;

use DB;
use Session;
use App\Models\Cart;
use App\Models\Size;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckOutController extends Controller
{
    public function checkout()
    {
        $cartDetails = [];
        $totalPrice = 0;
        $orderId = null;
     
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())
                ->with(['cartItems.product.images', 'cartItems.color', 'cartItems.size'])
                ->first();
     
            if ($cart && $cart->cartItems->isNotEmpty()) {
                $cartDetails = $cart->cartItems->map(function ($item) {
                    $product = $item->product;
                    $color = $item->color;
                    $size = $item->size;
                    $image = $product->images->firstWhere('color_id', $color->id);
     
                    $imageUrl = $image ? $image->image_url : '/default-image.jpg';
     
                    return [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item->quantity,
                        'price' => $item->price ?? $product->price,
                        'image_url' => $imageUrl,
                        'subtotal' => ($item->price ?? $product->price) * $item->quantity,
                    ];
                });
     
                $totalPrice = $cartDetails->sum('subtotal');
                
                // Tạo mã đơn hàng
                $orderId = 'ORDER-' . strtoupper(uniqid());
                
                // Lưu đơn hàng vào database
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_id' => $orderId,
                    'total_price' => $totalPrice,
                    'phone_number' => '1123123Vn', // Cung cấp giá trị cho phone_number
                    'address' => 'Địa chỉ người mua', // Cung cấp địa chỉ (cần chỉnh lại giá trị này)
                    'status' => 1, // Trạng thái đơn hàng
                ]);
                
                
                // Lưu chi tiết đơn hàng vào bảng order_items
                foreach ($cartDetails as $detail) {
                    $order->Orderitems()->create([
                        'product_id' => $detail['product_id'],
                        'color_name' => $detail['color_name'],
                        'size_name' => $detail['size_name'],
                        'quantity' => $detail['quantity'],
                        'price' => $detail['price'],
                    ]);
                }
            }
        } else {
            $cart = session()->get('cart', []);
     
            if (!empty($cart)) {
                foreach ($cart as $item) {
                    $product = Product::find($item['product_id']);
                    $color = Color::find($item['color_id']);
                    $size = Size::find($item['size_id']);
                    $image = $product->images->firstWhere('color_id', $color->id);
     
                    $imageUrl = $image ? $image->image_url : '/default-image.jpg';
     
                    $cartDetails[] = [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item['quantity'],
                        'price' => $item['price'] ?? $product->price,
                        'image_url' => $imageUrl,
                        'subtotal' => ($item['price'] ?? $product->price) * $item['quantity'],
                    ];
                }
     
                $totalPrice = array_sum(array_column($cartDetails, 'subtotal'));
                $orderId = 'ORDER-' . strtoupper(uniqid());
                
                // Tạo đơn hàng và lưu vào cơ sở dữ liệu
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_id' => $orderId,
                    'total_price' => $totalPrice,
                    'status' => 'chờ_xác_nhận',
                ]);
                
                foreach ($cartDetails as $detail) {
                    $order->items()->create([
                        'product_id' => $detail['product_id'],
                        'color_id' => $detail['color_id'],
                        'size_id' => $detail['size_id'],
                        'quantity' => $detail['quantity'],
                        'price' => $detail['price'],
                    ]);
                }
            }
        }
     
        return view('client.check-out', compact('cartDetails', 'totalPrice', 'orderId'));
    }
    

    public function vnpay_payment(Request $request)
    {
        $order = Order::find($request->order_id);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://shophanoi2.test/check-out";
        $vnp_TmnCode = "D8TMOG8O"; // Mã website tại VNPAY 
        $vnp_HashSecret = "QILK1HU3OIQHN2B6P9LKCZFL1RAEF0L4"; // Chuỗi bí mật
         
        $vnp_TxnRef = $order->order_id; // Mã đơn hàng
        $vnp_OrderInfo = 'Thanh toán đơn hàng ' . $order->order_id;
        $vnp_Amount = $order->total_price * 100; // Số tiền thanh toán, nhân với 100 để đổi sang VND (VNPAY yêu cầu tính bằng cent)
        $vnp_Locale = 'VN';
        $vnp_BankCode = 'NCB'; // Mã ngân hàng (có thể thay đổi tùy vào ngân hàng người dùng chọn)
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    
        // Thêm các tham số vào dữ liệu yêu cầu gửi đi
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );
    
        ksort($inputData);
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= urlencode($key) . "=" . urlencode($value) . "&";
        }
        
        $vnp_Url .= '?' . rtrim($hashdata, '&');
        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnp_SecureHash;
    
        return redirect($vnp_Url); // Redirect người dùng tới VNPAY
    }
    public function vnpay_return(Request $request)
    {
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $vnp_HashSecret = "QILK1HU3OIQHN2B6P9LKCZFL1RAEF0L4"; // Chuỗi bí mật
        unset($request['vnp_SecureHash']); // Xóa tham số SecureHash ra khỏi request
    
        ksort($request->all());
        $hashdata = "";
        foreach ($request->all() as $key => $value) {
            $hashdata .= urlencode($key) . "=" . urlencode($value) . "&";
        }
    
        $vnpSecureHashCheck = hash_hmac('sha512', rtrim($hashdata, '&'), $vnp_HashSecret);
    
        if ($vnp_SecureHash === $vnpSecureHashCheck) {
            $order = Order::where('order_id', $request->input('vnp_TxnRef'))->first();
            if ($order) {
                if ($request->input('vnp_ResponseCode') == '00') {
                    // Thanh toán thành công
                    $order->status = 'success';
                    $order->save();
                } else {
                    // Thanh toán thất bại
                    $order->status = 'failed';
                    $order->save();
                }
            }
        }
        return redirect()->route('order.complete');
    }
        
    
}
