<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmationMail;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Mail;
use Session;
use DB;

class CheckOutController extends Controller
{
    public function checkout()
    {
        // Biến chứa thông tin giỏ hàng
        $cartDetails = [];
        $totalPrice = 0;
    
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
    
                // Tính tổng giá trị đơn hàng
                $totalPrice = $cartDetails->sum('subtotal');
            }
        } else {
            // Nếu chưa đăng nhập, lấy giỏ hàng từ session
            $cart = session()->get('cart', []);
    
            if (!empty($cart)) {
                foreach ($cart as $item) {
                    $product = Product::find($item['product_id']);
                    $color = Color::find($item['color_id']);
                    $size = Size::find($item['size_id']);
                    $image = $product->images->firstWhere('color_id', $color->id);
    
                    // Lấy URL ảnh sản phẩm, nếu không có thì dùng ảnh mặc định
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
    
                // Tính tổng giá trị đơn hàng từ giỏ hàng trong session
                $totalPrice = array_sum(array_column($cartDetails, 'subtotal'));
            }
        }
    
        return view('client.check-out', compact('cartDetails', 'totalPrice'));
    }

    public function placeOrder(Request $request)
    {
        $paymentMethod = $request->input('payment'); 
        $cartDetails = $this->getCartDetails(); 
        $totalPrice = $cartDetails['totalPrice'];
        $orderCode = 'HN' . strtoupper(uniqid()); 

        if (empty($cartDetails['items'])) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn trống!');
        }

        $order = $this->createOrder($request, $cartDetails['items'], $totalPrice, $orderCode, $paymentMethod);

       
        if ($paymentMethod === 'cod') {
            return $this->handleCOD($order);
        } elseif ($paymentMethod === 'vnpay') {
            return $this->handleVNPay($order, $totalPrice);
        }

        return redirect()->route('home')->with('error', 'Phương thức thanh toán không hợp lệ.');
    }
    public function getCartDetails()
{
    
    $cartDetails = [];
    $totalPrice = 0;

    
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
        }
    }

    return ['items' => $cartDetails, 'totalPrice' => $totalPrice];
}

    private function createOrder(Request $request, $cartDetails, $totalPrice, $orderCode, $paymentMethod)
    {

        $order = Order::create([
            'user_id' => auth()->id() ?? null,  
            'order_code' => $orderCode,  
            'total_price' => $totalPrice, 
            'payment_method' => $paymentMethod,  
            'phone_number' => $request->phone_number,  
            'address' => $request->address,  
            'name' => $request->name, 
            'email' => $request->email, 
            'payment_status' => $paymentMethod === 'vnpay' ? 0 : 1,  
            'status' => 1, 
        ]);
    
      
        foreach ($cartDetails as $detail) {
            $order->OrderItems()->create([
                'product_id' => $detail['product_id'],  
                'color_name' => $detail['color_name'],  
                'size_name' => $detail['size_name'], 
                'quantity' => $detail['quantity'],  
                'price' => $detail['price'], 
            ]);
    
    
            $variant = ProductVariant::where('product_id', $detail['product_id'])
                ->where('color_id', $detail['color_id'])
                ->where('size_id', $detail['size_id'])
                ->first();
    
            if ($variant) {
              
                $variant->decrement('stock_quantity', $detail['quantity']);
            }
        }
    
        return $order;  
    }

    private function handleCOD(Order $order)
    {
    
        Mail::to($order->email)->send(new OrderConfirmationMail($order));

  
        if (auth()->check()) {
            Cart::where('user_id', auth()->id())->delete();
        } else {
            session()->forget('cart');
        }

        return redirect()->route('home')->with('success', 'Đặt hàng thành công');
    }

   // Hàm handle VNPay
private function handleVNPay(Order $order, $totalPrice)
{

    // Các tham số từ VNPAY
    $vnp_TmnCode = "D8TMOG8O"; // Mã website tại VNPAY
    $vnp_HashSecret = "QILK1HU3OIQHN2B6P9LKCZFL1RAEF0L4"; // Chuỗi bí mật
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL thanh toán
    $vnp_TxnRef = time(); // Mã đơn hàng
    $vnp_OrderInfo =  $order->order_code;
    $vnp_OrderType = "billpayment";
    $vnp_Amount = intval($totalPrice * 100); // Số tiền thanh toán
    $vnp_Locale = 'vn'; // Ngôn ngữ
    $vnp_BankCode = "NCB"; // Mã ngân hàng
    $vnp_Returnurl = route('thanhtoanthanhcong'); // URL trả về sau khi thanh toán
    $vnp_IpAddr = request()->ip(); // IP của khách hàng

    // Dữ liệu gửi đến VNPAY
    $inputData = array(

        "vnp_Version" => "2.0.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
    );

    // Nếu có ngân hàng thì thêm vào tham số
    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }

    // Sắp xếp tham số
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";

    // Tạo chuỗi để mã hóa
   
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . $key . "=" . $value;
        } else {
            $hashdata .= $key . "=" . $value;
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    // Thêm hash vào URL
    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); // Mã hóa SHA512
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }

    // Lưu thông tin vào cơ sở dữ liệu
    DB::table('payment_vnpay')->insert([
        'vnp_TmnCode' => $vnp_TmnCode,
        'vnp_TxnRef' => $vnp_TxnRef,
        'vnp_OrderInfo' => $vnp_OrderInfo,
        'vnp_OrderType' => $vnp_OrderType,
        'vnp_Amount' => $vnp_Amount / 100,
        'vnp_Locale' => $vnp_Locale,
        'vnp_BankCode' => $vnp_BankCode,
        'vnp_IpAddr' => $vnp_IpAddr,
        'vnp_SecureHash' => $vnpSecureHash,
        'status' => 'pending',
        'order_id' => $order->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $returnData = array('code' => '00'
    , 'message' => 'success'
    , 'data' => $vnp_Url);
    if (isset($_POST['redirect'])) {
        header('Location: ' . $vnp_Url);
        die();
    } else {
        echo json_encode($returnData);
    }
}
public function thanhtoanthanhcong(Request $request)
{
    $data = $request->all();
    return view('client.thanhtoansuccess', compact('data'));
}


}
