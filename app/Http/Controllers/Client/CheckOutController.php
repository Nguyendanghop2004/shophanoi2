<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\OrderRequest;
use DB;
use Mail;
use Session;
use App\Models\Cart;
use App\Models\City;
use App\Models\Size;
use App\Models\Color;
use App\Models\Order;
use App\Models\Wards;
use App\Models\Product;
use App\Models\Province;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Mail\OrderConfirmationMail;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CheckOutController extends Controller
{
    public function checkout()
    {
        $cartDetails = [];
        $totalPrice = 0;
        $user = auth()->user();
        $categories = Category::with(relations: [
            'children' => function ($query) {
                $query->where('status', 1);
            }
        ])->where('status', 1)
            ->whereNull('parent_id')->get();
        if (auth()->check()) {
            $cart = Cart::where('user_id', $user->id)
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
        
        
            $cities = City::orderBy('name_thanhpho', 'ASC')->get();
            $provinces = collect();
            $wards = collect();
        
            if (auth()->check()) {
                $user = auth()->user();
                $provinces = Province::where('matp', $user->city_id)->orderBy('name_quanhuyen', 'ASC')->get();
                $wards = Wards::where('maqh', $user->province_id)->orderBy('name_xaphuong', 'ASC')->get();
            }
    
        return view('client.check-out', compact('cartDetails', 'totalPrice', 'cities', 'provinces', 'wards', 'user','categories'));
    }
    
     public function select_address(Request $request)
    {
        $data = $request->all();
        if (isset($data['action'])) {
            $output = '';
            if ($data['action'] == "city") {
                $select_province = Province::where('matp', $data['ma_id'])->orderBy('maqh', 'ASC')->get();
                $output .= '<option>--Chọn Quận Huyện---</option>';
                foreach ($select_province as $province) {
                    $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
                }
            } else {
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderBy('xaid', 'ASC')->get();
                $output .= '<option>--Chọn Xã Phường---</option>';
                foreach ($select_wards as $ward) {
                    $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
                }
            }
            echo $output;
        }
    }

    public function placeOrder(OrderRequest $request)
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

private function createOrder(OrderRequest $request, $cartDetails, $totalPrice, $orderCode, $paymentMethod)
{
    
    $order = Order::create([
        'user_id' => auth()->id() ?? null,
        'order_code' => $orderCode,
        'total_price' => $totalPrice,
        'payment_method' => $paymentMethod,
        'phone_number' => $request->phone_number,
        'address' => $request->address,
        'city_id' => $request->city_id,
        'wards_id' => $request->wards_id,
        'province_id' => $request->province_id,
        'name' => $request->name,
        'email' => $request->email,
        'note' => $request->note,
        'payment_status' => "chờ thanh toán",
        'status' => 1,
    ]);

    
    foreach ($cartDetails as $detail) {
       
        $order->OrderItems()->create([
            'product_name' => $detail['product_name'],
            'image_url' => $detail['image_url'],
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
       $vnp_TmnCode = "E5WL6ON5"; // Mã website tại VNPAY
       $vnp_HashSecret = "RJVBT58452T7DZK0UOOM0EY10SVH79VS"; // Chuỗi bí mật
       $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL thanh toán
       $vnp_TxnRef = time(); // Mã đơn hàng
       $vnp_OrderInfo =  $order->order_code;
       $vnp_OrderType = "billpayment";
       $vnp_Amount = intval($totalPrice * 100); // Số tiền thanh toán
       $vnp_Locale = 'vn'; // Ngôn ngữ
       $vnp_BankCode = "NCB"; // Mã ngân hàng
       $vnp_Returnurl = route('vnpay.return'); // URL trả về sau khi thanh toán
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
   
      
       if (isset($vnp_BankCode) && $vnp_BankCode != "") {
           $inputData['vnp_BankCode'] = $vnp_BankCode;
       }
   
     
       ksort($inputData);
       $query = "";
       $i = 0;
       $hashdata = "";
   
     
       foreach ($inputData as $key => $value) {
           if ($i == 1) {
               $hashdata .= '&' . $key . "=" . $value;
           } else {
               $hashdata .= $key . "=" . $value;
               $i = 1;
           }
           $query .= urlencode($key) . "=" . urlencode($value) . '&';
       }
   
    
       $vnp_Url = $vnp_Url . "?" . $query;
       if (isset($vnp_HashSecret)) {
           $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
           $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
       }
   
   
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
   
    
    
       $returnData = array('code' => '00', 'message' => 'success', 'data' => $vnp_Url);
       if (isset($_POST['redirect'])) {
           header('Location: ' . $vnp_Url);
           die();
       } else {
           echo json_encode($returnData);
       }
   }
   public function vnpayReturn(Request $request)
   {
       $vnp_HashSecret = "RJVBT58452T7DZK0UOOM0EY10SVH79VS"; 
       $inputData = $request->all();  
       $data = $request->all();
       
       $vnp_SecureHash = $inputData['vnp_SecureHash'];  
       unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']); 
   
      
       ksort($inputData);
       $hashData = urldecode(http_build_query($inputData));
       $checkHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
   
       
       if ($checkHash === $vnp_SecureHash) {
           
          
           if ($inputData['vnp_ResponseCode'] === '00') {
             
               $orderCode = $inputData['vnp_OrderInfo'];  
               $order = Order::where('order_code', $orderCode)->first();
   
               if ($order) {
                   $order->payment_status = 'Đã thanh toán'; 
                   $order->save(); 
                   Mail::to($order->email)->send(new OrderConfirmationMail($order));
                   if (auth()->check()) {  
                       Cart::where('user_id', auth()->id())->delete();
                   } else {
                     
                       session()->forget('cart');
                   }
                   return view('client.thanhtoansuccess', compact('data'));
               } else {
                   return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng');
               }
           } else {
               
               $orderCode = $inputData['vnp_OrderInfo'];  
               $order = Order::where('order_code', $orderCode)->first();
   
               if ($order) {
                   $order->payment_status = 'Thất bại'; 
                   $order->save();
                   $order->delete(); 
               }
   
               return redirect()->route('home')->with('error', 'Thanh toán thất bại, đơn hàng đã bị hủy và xóa');
           }
       } else {
         
           return redirect()->route('home')->with('error', 'Lỗi bảo mật, vui lòng thử lại');
       }
   }

public function thanhtoanthanhcong(Request $request)
{
    $categories = Category::with(relations: [
        'children' => function ($query) {
            $query->where('status', 1);
        }
    ])->where('status', 1)
        ->whereNull('parent_id')->get();
    $data = $request->all();
    return view('client.thanhtoansuccess', compact('data','categories'));
   
}
 

}
