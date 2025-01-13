<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\OrderRequest;
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
use App\Models\DiscountCode;

class CheckOutController extends Controller
{
    private $newTotal; 
    private $couponn = null;
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
                    if ($item->quantity == 0) {
                        return redirect()->route('cart')->with('error', "Số lượng sản phẩm không hợp lệ.");
                    }
    
                    $variant = ProductVariant::where([
                        ['product_id', $item->product_id],
                        ['color_id', $item->color_id],
                        ['size_id', $item->size_id],
                    ])->first();
                  
                    if (!$variant || $variant->deleted_at !== null) {
                     
                        $cart->cartItems()->where('id', $item->id)->delete();
                        return redirect()->route('cart')->with('error', "Biến thể không tồn tại hoặc đã bị xóa.");
                    }
    
                    if ($item->quantity > $variant->stock_quantity) {
                        return redirect()->route('cart')->with('error', "Sản phẩm trong kho không đủ số lượng.");
                    }
    
                    $product = $item->product;
                    if ($product && $product->deleted_at !== null) {
                        return redirect()->route('cart')->with('error', "Một số sản phẩm đã bị xóa.");
                    }
    
                    if ($product && $product->status == 0) {
                        return redirect()->route('cart')->with('error', "Một số sản phẩm không còn kinh doanh.");
                    }
                    if (!$variant || $variant->stock_quantity == 0) {
                       
                        $cart->cartItems()->where('id', $item->id)->delete();
                        return redirect()->route('cart');
                    }
                    $color = $item->color;
                    $size = $item->size;
                    $image = $product->images->firstWhere('color_id', $color->id);
                    $imageUrl = $image ? $image->image_url : '/default-image.jpg';
    
                    $pricebonus = $variant->price;
                    $basePrice = $product->price;
    
                    $sale = $product->sales()
                        ->where('start_date', '<=', now())
                        ->where(function ($query) {
                            $query->whereNull('end_date')
                                ->orWhere('end_date', '>=', now());
                        })
                        ->first();
    
                    if ($sale) {
                        if ($sale->discount_type === 'percent') {
                            $discount = ($basePrice * $sale->discount_value) / 100;
                        } elseif ($sale->discount_type === 'fixed') {
                            $discount = $sale->discount_value;
                        } else {
                            $discount = 0;
                        }
                        $finalPrice = max($basePrice - $discount, 0) + $pricebonus;
                    } else {
                        $finalPrice = $basePrice + $pricebonus;
                    }
    
                    $cartDetails[] = [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'slug' => $product->slug ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item->quantity,
                        'price' => $basePrice,
                        'pricebonus' => $pricebonus,
                        'final_price' => $finalPrice,
                        'image_url' => $imageUrl,
                        'subtotal' => $finalPrice * $item->quantity,
                    ];
                }
    
                $totalPrice = collect($cartDetails)->sum('subtotal');
            } else {
                return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn hiện tại không có sản phẩm.');
            }
        } else {
       
            $cart = session()->get('cart', []);
    
            if (!empty($cart)) {
                foreach ($cart as $key => $item) {
                    if ($item['quantity'] == 0) {
                        return redirect()->route('cart')->with('error', "Số lượng sản phẩm không hợp lệ. Vui lòng kiểm tra lại giỏ hàng.");
                    }
    
                    $variant = ProductVariant::where([
                        ['product_id', $item['product_id']],
                        ['color_id', $item['color_id']],
                        ['size_id', $item['size_id']],
                    ])->first();
                    
                    if (!$variant) {
                      
                        unset($cart[$key]);
                        session()->put('cart', $cart);
                        return redirect()->route('cart')->with('error', "Biến thể không tồn tại hoặc đã bị xóa.");
                    }
    
                    if ($item['quantity'] > $variant->stock_quantity) {
                        return redirect()->route('cart')->with('error', "Sản phẩm trong kho không đủ số lượng.");
                    }
    
                    $product = Product::find($item['product_id']);
                    if ($product && $product->deleted_at !== null) {
                        return redirect()->route('cart')->with('error', "Một số sản phẩm đã bị xóa.");
                    }
    
                    if ($product && $product->status == 0) {
                        return redirect()->route('cart')->with('error', "Một số sản phẩm không còn kinh doanh.");
                    }
                    if (!$variant || $variant->stock_quantity == 0) {
                     
                        unset($cart[$key]);
                        session()->put('cart', $cart);
                        return redirect()->route('cart');
                    }
                    $color = Color::find($item['color_id']);
                    $size = Size::find($item['size_id']);
                    $image = $product->images->firstWhere('color_id', $color->id);
                    $imageUrl = $image ? $image->image_url : '/default-image.jpg';
    
                    $pricebonus = $variant->price;
                    $basePrice = $product->price;
    
                    $sale = $product->sales()
                        ->where('start_date', '<=', now())
                        ->where(function ($query) {
                            $query->whereNull('end_date')
                                ->orWhere('end_date', '>=', now());
                        })
                        ->first();
    
                    if ($sale) {
                        if ($sale->discount_type === 'percent') {
                            $discount = ($basePrice * $sale->discount_value) / 100;
                        } elseif ($sale->discount_type === 'fixed') {
                            $discount = $sale->discount_value;
                        } else {
                            $discount = 0;
                        }
                        $finalPrice = max($basePrice - $discount, 0) + $pricebonus;
                    } else {
                        $finalPrice = $basePrice + $pricebonus;
                    }
    
                    $cartDetails[] = [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'slug' => $product->slug ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item['quantity'],
                        'price' => $basePrice,
                        'pricebonus' => $pricebonus,
                        'final_price' => $finalPrice,
                        'image_url' => $imageUrl,
                        'subtotal' => $finalPrice * $item['quantity'],
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
        
        $this->applyCoupon(new \Illuminate\Http\Request([]), $code = $request->input('coupon-code'));
        
        $paymentMethod = $request->input('payment');
        $cartDetails = $this->getCartDetails();
        
        
        if (!empty($this->couponn)) {
            $totalPrice = $this->newTotal; 
        } else {
            $totalPrice = $cartDetails['totalPrice']; 
        }
    
       
        $orderCode = 'HN' . strtoupper(uniqid());
    
        $outOfStockItems = [];
        $deletedItems = [];
        $notAvailableItems = []; 
        $productVariantDeletedItems = [];
    
       
        DB::beginTransaction();
    
        try {
           
            foreach ($cartDetails['items'] as $item) {
    
               
                $productVariant = ProductVariant::where('product_id', $item['product_id'])
                    ->where('color_id', $item['color_id'])
                    ->where('size_id', $item['size_id'])
                    ->lockForUpdate()
                    ->first();
                    if ($productVariant->deleted_at !== null) {
                        $productVariantDeletedItems[] = $item;
                        continue; 
                    }
                if (!$productVariant) {
                   
                    $outOfStockItems[] = [
                        'product_name' => $item['product_name'],
                        'requested_quantity' => $item['quantity'],
                        'remaining_quantity' => 0
                    ];
                    continue;
                }
               
    
               
                $product = Product::find($item['product_id']);
                if ($product && $product->deleted_at !== null) {
                    $deletedItems[] = $item; 
                    continue;
                }
    
                if ($product && $product->status == 0) {
                    $notAvailableItems[] = $item; 
                    continue;
                }
    
                
                if ($productVariant->stock_quantity < $item['quantity']) {
                   
                    $outOfStockItems[] = [
                        'product_name' => $item['product_name'],
                        'requested_quantity' => $item['quantity'],
                        'remaining_quantity' => $productVariant->stock_quantity
                    ];
                    continue; 
                }
    
              
                $productVariant->stock_quantity -= $item['quantity'];
                $productVariant->save();
            }
            if (!empty($productVariantDeletedItems)) {
                DB::rollBack();
                return redirect()->route('cart')
                    ->with('error', 'biến thể không tồn tại.');
            }
          
            if (!empty($deletedItems)) {
                DB::rollBack();
                return redirect()->route('cart')
                    ->with('error', 'Một số sản phẩm đã bị xóa.');
            }
    
           
            if (!empty($outOfStockItems)) {
                DB::rollBack();
                return redirect()->route('cart')
                    ->with('error', 'Một số sản phẩm không đủ số lượng.');
            }
    
           
            if (!empty($notAvailableItems)) {
                DB::rollBack();
                return redirect()->route('cart')
                    ->with('error', 'Một số sản phẩm không còn kinh doanh.');
            }
    
          
            if (empty($cartDetails['items'])) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Giỏ hàng của bạn trống!');
            }
    
           
            $order = $this->createOrder($request, $cartDetails['items'], $totalPrice, $orderCode, $paymentMethod);
    
          
            if ($paymentMethod === 'cod') {
                DB::commit();
                return $this->handleCOD($order);
            } 
           
            elseif ($paymentMethod === 'vnpay') {
                DB::commit();
                return $this->handleVNPay($order, $totalPrice);
            }
    
         
            DB::rollBack();
            return redirect()->route('home')->with('error', 'Phương thức thanh toán không hợp lệ.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order Placement Error: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra trong quá trình đặt hàng.');
        }
    }
    
    public function getCartDetails()
    {
        $cartDetails = [];
        $totalPrice = 0;
        $messages = []; 

        if (auth()->check()) {
           
            $cart = Cart::where('user_id', auth()->id())
                ->with(['cartItems.product.images', 'cartItems.color', 'cartItems.size', 'cartItems.product.variants'])
                ->first();

            if ($cart && $cart->cartItems->isNotEmpty()) {
                $cartDetails = $cart->cartItems->map(function ($item) use (&$messages) {
                    $product = $item->product;
                    $color = $item->color;
                    $size = $item->size;
                    $image = $product->images->firstWhere('color_id', $color->id);
                    $variant = $product->variants()
                        ->where('color_id', $color->id ?? null)
                        ->where('size_id', $size->id ?? null)
                        ->first();


                    $variantPrice = $variant->price ?? 0; 
                    $basePrice = $product->price ?? 0;  
                    $price = $basePrice;                

                 
                    $sale = $product->sales()
                        ->where('start_date', '<=', now())
                        ->where(function ($query) {
                            $query->whereNull('end_date')
                                ->orWhere('end_date', '>=', now());
                        })
                        ->first();

                    if ($sale) {
                        if ($sale->discount_type === 'percent') {
                            $discount = ($price * $sale->discount_value) / 100;
                        } elseif ($sale->discount_type === 'fixed') {
                            $discount = $sale->discount_value;
                        } else {
                            $discount = 0;
                        }
                        $finalPrice = max($price - $discount, 0); 
                    } else {
                        $finalPrice = $price;
                    }

                    // Tổng tiền (subtotal)
                    $subtotal = $finalPrice * $item->quantity + $variantPrice * $item->quantity;

                    // Trả về chi tiết giỏ hàng
                    return [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item->quantity,
                        'price' => $product->price ?? 0,          
                        'pricebonus' => $variantPrice,           
                        'final_price' => $finalPrice,           
                        'image_url' => $image->image_url ?? '/default-image.jpg',
                        'subtotal' => $subtotal,               
                    ];
                })->filter()->toArray(); 

                $totalPrice = array_sum(array_column($cartDetails, 'subtotal')); 
            }
        } else {
          
            $cart = session()->get('cart', []);

            if (!empty($cart)) {
                foreach ($cart as $item) {
                    $product = Product::find($item['product_id']);
                    $color = Color::find($item['color_id']);
                    $size = Size::find($item['size_id']);
                    $image = $product->images->firstWhere('color_id', $color->id);
                    $variant = $product->variants()
                        ->where('color_id', $color->id ?? null)
                        ->where('size_id', $size->id ?? null)
                        ->first();

                    $variantPrice = $variant->price ?? 0; 
                    $basePrice = $product->price ?? 0;  
                    $price = $basePrice;

                  
                    $sale = $product->sales()
                        ->where('start_date', '<=', now())
                        ->where(function ($query) {
                            $query->whereNull('end_date')
                                ->orWhere('end_date', '>=', now());
                        })
                        ->first();

                    if ($sale) {
                        if ($sale->discount_type === 'percent') {
                            $discount = ($price * $sale->discount_value) / 100;
                        } elseif ($sale->discount_type === 'fixed') {
                            $discount = $sale->discount_value;
                        } else {
                            $discount = 0;
                        }
                        $finalPrice = max($price - $discount, 0); 
                    } else {
                        $finalPrice = $price;
                    }

                    $subtotal = $finalPrice * $item['quantity'] + $variantPrice * $item['quantity'];

                    $cartDetails[] = [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item['quantity'],
                        'price' => $product->price ?? 0,        
                        'pricebonus' => $variantPrice,        
                        'final_price' => $finalPrice,          
                        'image_url' => $image->image_url ?? '/default-image.jpg',
                        'subtotal' => $subtotal,                 
                    ];
                }

                $totalPrice = array_sum(array_column($cartDetails, 'subtotal')); 
            }
        }

        return ['items' => $cartDetails, 'totalPrice' => $totalPrice, 'messages' => $messages];
    }

    private function getCartDetailss($cartItems)
    {
        $messages = [];

        
        return $cartItems->filter(function ($item) {
            return $item->quantity > 0; 
        })->map(function ($item) use ($messages) {
            $product = $item->product;
            $color = $item->color;
            $size = $item->size;
            $image = $product->images->firstWhere('color_id', $color->id);
            $variant = $product->variants()
                ->where('color_id', $color->id ?? null)
                ->where('size_id', $size->id ?? null)
                ->first();

            
            if ($item->quantity > $variant->stock_quantity) {
                $messages[] = "Sản phẩm {$product->product_name} đã được giảm số lượng xuống còn {$variant->stock_quantity} do tồn kho không đủ."; 
                $item->quantity = $variant->stock_quantity;
                $item->save();
            }

         
            $variantPrice = $variant->price ?? 0; 
            $basePrice = $product->price ?? 0;   
            $price = $basePrice; 

      
            $sale = $product->sales()
                ->where('start_date', '<=', now())
                ->where(function ($query) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                })
                ->first();

            if ($sale) {
                if ($sale->discount_type === 'percent') {
                    $discount = ($price * $sale->discount_value) / 100;
                } elseif ($sale->discount_type === 'fixed') {
                    $discount = $sale->discount_value;
                } else {
                    $discount = 0;
                }
                $finalPrice = max($price - $discount, 0); 
            } else {
                $finalPrice = $price;
            }

           
            return [
                'product_id' => $product->id,
                'color_id' => $color->id ?? null,
                'size_id' => $size->id ?? null,
                'product_name' => $product->product_name ?? 'N/A',
                'slug' => $product->slug ?? 'N/A',
                'color_name' => $color->name ?? 'N/A',
                'size_name' => $size->name ?? 'N/A',
                'quantity' => $item->quantity,
                'price' => $product->price ?? 0,         
                'pricebonus' => $variantPrice,           
                'final_price' => $finalPrice,       
                'image_url' => $image->image_url ?? '/default-image.jpg',
                'subtotal' => $finalPrice * $item->quantity + $variantPrice * $item->quantity, 
            ];
        })->toArray();
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
                'price' => (int) $detail['final_price'] + (int) $detail['pricebonus'],
                
            ]);


            $variant = ProductVariant::where('product_id', $detail['product_id'])
                ->where('color_id', $detail['color_id'])
                ->where('size_id', $detail['size_id'])
                ->first();

           
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
        $vnp_HashSecret = "RJVBT58452T7DZK0UOOM0EY10SVH79VS"; 
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_TxnRef = time(); 
        $vnp_OrderInfo = $order->order_code;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = intval($totalPrice * 100); 
        $vnp_Locale = 'vn'; 
        $vnp_BankCode = "NCB"; 
        $vnp_Returnurl = route('vnpay.return'); 
        $vnp_IpAddr = request()->ip();

        
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

                return redirect()->route('home')->with('error', 'Thanh toán thất bại');
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
         
        return redirect()->back();
       } catch (ModelNotFoundException $e) {
          
        return redirect()->back();
       } catch (\Exception $e) {
          
        return redirect()->back();
       }
   }

    public function outOfStock()
    {
        $outOfStockItems = session('out_of_stock_items', []);
        $error = session('error');

        return view('client.error', compact('outOfStockItems', 'error'));
    }
    public function applyCoupon(Request $request, $code = null)
    {
        try {

            
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để áp dụng mã giảm giá.',
                ], 401);
            }

          
            if ($code) {
                $couponCode = $code;
            } else {
                $couponCode = $request->input('coupon');
            }

            if (empty($couponCode)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng nhập mã giảm giá.',
                ], 400);
            }

            $cart = Cart::where('user_id', auth()->id())->with('cartItems.product')->first();
            if (!$cart || $cart->cartItems->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Giỏ hàng của bạn đang trống.'], 400);
            }

         
            $cartDetails = $this->getCartDetailss($cart->cartItems);

            $coupon = DiscountCode::where('code', $couponCode)
                ->where('start_date', '<=', now())
                ->where(function ($query) {
                    $query->whereNull('end_date')->orWhere('end_date', '>=', now());
                })
                ->first();

            if (!$coupon) {
                return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'], 400);
            }

       
            if (!is_null($coupon->usage_limit) && $coupon->times_used >= $coupon->usage_limit) {
                return response()->json(['success' => false, 'message' => 'Mã giảm giá đã đạt giới hạn sử dụng.'], 400);
            }

          
            $userLimit = $coupon->userLimits()->where('user_id', auth()->id())->first();
            if ($userLimit) {
                if (!is_null($userLimit->usage_limit) && $userLimit->times_used >= $userLimit->usage_limit) {
                    return response()->json(['success' => false, 'message' => 'Bạn đã đạt giới hạn sử dụng mã giảm giá này.'], 400);
                }
            } elseif ($coupon->userLimits()->exists()) {
                return response()->json(['success' => false, 'message' => 'Mã giảm giá này không áp dụng cho bạn.'], 403);
            }

            
            $totalPrice = collect($cartDetails)->sum('subtotal');
            $totalDiscount = 0;

            foreach ($cartDetails as $item) {
            
                $applicableProducts = $coupon->applicableProducts ?? collect();
                if (!$applicableProducts->isEmpty() && !$applicableProducts->pluck('product_id')->contains($item['product_id'])) {
                    continue;
                }

               
                if ($coupon->discount_type === 'percent') {
                    $discount = ($item['final_price'] * $coupon->discount_value) / 100;
                } elseif ($coupon->discount_type === 'fixed') {
                    $discount = min($coupon->discount_value, $item['final_price']); 
                } else {
                    $discount = 0;
                }

                $totalDiscount += $discount;
            }

           
            if ($applicableProducts->isEmpty()) {
                if ($coupon->discount_type === 'percent') {
                    $totalDiscount = ($totalPrice * $coupon->discount_value) / 100;
                } elseif ($coupon->discount_type === 'fixed') {
                    $totalDiscount = $coupon->discount_value;
                }
            }
          

            $newTotal = max($totalPrice - $totalDiscount, 0); 
            $this->newTotal = $newTotal;
            $this->couponn = $couponCode;
         
            $coupon->increment('times_used');
            if ($userLimit) {
                $userLimit->increment('times_used');
            }
            if ($code) {
                return;
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Mã giảm giá đã được áp dụng thành công!',
                    'newTotal' => number_format($newTotal, 0, ',', '.'),
                ], 200);
            }


        } catch (\Exception $e) {
            \Log::error('Lỗi khi áp dụng mã giảm giá:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi không xác định. Vui lòng thử lại sau.',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null,
            ], 500);
        }
    }


}
