<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\OrderRequest;
use App\Models\DiscountCode;
use App\Models\UserDiscountCode;
use Auth;
use DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
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
    
        if (auth()->check()) {
            $cart = Cart::where('user_id', $user->id)
                ->with(['cartItems.product.images', 'cartItems.color', 'cartItems.size'])
                ->first();
    
            if ($cart && $cart->cartItems->isNotEmpty()) {
                foreach ($cart->cartItems as $item) {
                    $variant = ProductVariant::where([
                        ['product_id', $item->product_id],
                        ['color_id', $item->color_id],
                        ['size_id', $item->size_id],
                    ])->first();
    
                    if (!$variant) {
                        return redirect()->route('cart')->with('error', "Không tìm thấy biến thể sản phẩm.");
                    }
    
                   
                    if ($item->quantity > $variant->stock_quantity) {
                        return redirect()->route('cart')->with(
                            'error',
                            "Sản phẩm '{$item->product->product_name}' chỉ còn lại {$variant->stock_quantity} trong kho."
                        );
                    }
    
                    $product = $item->product;
                    $color = $item->color;
                    $size = $item->size;
                    $image = $product->images->firstWhere('color_id', $color->id);
                    $imageUrl = $image ? $image->image_url : '/default-image.jpg';
    
                    $cartDetails[] = [
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
                }
    
                $totalPrice = collect($cartDetails)->sum('subtotal');
            } else {
                return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn hiện tại không có sản phẩm.');
            }
        } else {
            $cart = session()->get('cart', []);
    
            if (!empty($cart)) {
                foreach ($cart as $item) {
                    $variant = ProductVariant::where([
                        ['product_id', $item['product_id']],
                        ['color_id', $item['color_id']],
                        ['size_id', $item['size_id']],
                    ])->first();
    
                    if (!$variant) {
                        return redirect()->route('cart')->with('error', "Không tìm thấy biến thể sản phẩm.");
                    }
    
                    // Kiểm tra tồn kho
                    if ($item['quantity'] > $variant->stock_quantity) {
                        return redirect()->route('cart')->with(
                            'error',
                            "Sản phẩm '{$item['product_name']}' chỉ còn lại {$variant->stock_quantity} trong kho."
                        );
                    }
    
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
            } else {
                return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn hiện tại không có sản phẩm.');
            }
        }
    
        $cities = City::orderBy('name_thanhpho', 'ASC')->get();
        $provinces = collect();
        $wards = collect();
    
        if (auth()->check()) {
            $provinces = Province::where('matp', $user->city_id)->orderBy('name_quanhuyen', 'ASC')->get();
            $wards = Wards::where('maqh', $user->province_id)->orderBy('name_xaphuong', 'ASC')->get();
        }
    
        return view('client.check-out', compact('cartDetails', 'totalPrice', 'cities', 'provinces', 'wards', 'user'));
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
       
        $outOfStockItems = []; 
    
       
        DB::beginTransaction();
    
        try {
            foreach ($cartDetails['items'] as $item) {
                $productVariant = ProductVariant::where('product_id', $item['product_id'])
                    ->where('color_id', $item['color_id'])
                    ->where('size_id', $item['size_id'])
                    ->lockForUpdate()
                    ->first();
    
                if ($productVariant) {
                  
                    if ($productVariant->stock_quantity == 0) {
                        $outOfStockItems[] = [
                            'product_name' => $item['product_name'],
                            'requested_quantity' => $item['quantity'],
                            'remaining_quantity' => 0
                        ];
                    } elseif ($productVariant->stock_quantity < $item['quantity']) {
                        $outOfStockItems[] = [
                            'product_name' => $item['product_name'],
                            'requested_quantity' => $item['quantity'],
                            'remaining_quantity' => $productVariant->stock_quantity
                        ];
                    } else {
                     
                        $productVariant->decrement('stock_quantity', $item['quantity']);
                    }
                }
            }
    
     
            if (!empty($outOfStockItems)) {
                DB::rollBack();
                return redirect()->route('cart')
                  
                    ->with('error', 'Một số sản phẩm không đủ số lượng trong kho hoặc đã hết hàng.');
            }
    
           
            if (empty($cartDetails['items'])) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Giỏ hàng của bạn trống!');
            }
    
       
            $order = $this->createOrder($request, $cartDetails['items'], $totalPrice, $orderCode, $paymentMethod);
    
            
            if ($paymentMethod === 'cod') {
                DB::commit();
                return $this->handleCOD($order);
            } elseif ($paymentMethod === 'vnpay') {
                DB::commit();
                return $this->handleVNPay($order, $totalPrice);
            }
    
            DB::rollBack();
            return redirect()->route('home')->with('error', 'Phương thức thanh toán không hợp lệ.');
    
        } catch (\Exception $e) {
          
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra trong quá trình đặt hàng.');
        }
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

            'product_id' => $detail['product_id'],
            'color_id' => $detail['color_id'],
            'size_id' => $detail['size_id'],
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
        
        if ($variant->stock_quantity > 0) {
          
            $quantityToDecrement = min($variant->stock_quantity, $detail['quantity']);
            $variant->decrement('stock_quantity', $quantityToDecrement);
        }
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

        return redirect()->route('thanhtoanthanhcong',  ['id' => Crypt::encryptString($order->id)]);
    }

  
   private function handleVNPay(Order $order, $totalPrice)
   {
     
       $vnp_TmnCode = "E5WL6ON5";
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
   
               
                   return redirect()->route('thanhtoanthanhcong',  ['id' => Crypt::encryptString($order->id)]);
   
               } else {
                   return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng');
               }
           } else {
             
               $orderCode = $inputData['vnp_OrderInfo'];  
               $order = Order::where('order_code', $orderCode)->first();
   
               if ($order) {
                   $order->payment_status = 'Thất bại'; 
                   $order->save();
   
                   foreach ($order->orderItems as $orderItem) {
                       $productVariant = ProductVariant::where('product_id', $orderItem->product_id)
                           ->where('color_id', $orderItem->color_id)
                           ->where('size_id', $orderItem->size_id)
                           ->first();
   
                       if ($productVariant) {
                           $productVariant->stock_quantity += $orderItem->quantity; 
                           $productVariant->save(); 
                       }
                   }
   
                   $order->delete(); 
               }
   
               return redirect()->route('home')->with('error', 'Thanh toán thất bại, đơn hàng đã bị hủy và xóa');
           }
       } else {
           return redirect()->route('home')->with('error', 'Lỗi bảo mật, vui lòng thử lại');
       }
   }
   
 
   public function thanhtoanthanhcong($encryptedId)
   {
       try {
          
           $id = Crypt::decryptString($encryptedId);
           $order = Order::findOrFail($id);
           $city = City::where('matp', $order->city_id)->first();
           $province = Province::where('maqh', $order->province_id)->first();
           $ward = Wards::where('xaid', $order->wards_id)->first();
           $orderItems = OrderItem::where('order_id', $order->id)->get();
           return view('client.thanhtoansuccess', compact('order', 'orderItems', 'city', 'province', 'ward'));
       } catch (DecryptException $e) {
         
           return redirect()->route('error');
       } catch (ModelNotFoundException $e) {
          
           return redirect()->route('error');
       } catch (\Exception $e) {
          
           return redirect()->route('error');
       }
   }
   
   
public function outOfStock()
{
    $outOfStockItems = session('out_of_stock_items', []); 
    $error = session('error'); 

    return view('client.error', compact('outOfStockItems', 'error'));
}
 

}




