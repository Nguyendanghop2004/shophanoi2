<?php

namespace App\Http\Controllers\Client;

use DB;
use Session;
use App\Models\Cart;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DiscountCode;
use App\Models\ProductSale;
use Illuminate\Support\Facades\Auth;
use Log;

class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng

    public function addToCart(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'color_id' => 'nullable|exists:colors,id',
                'size_id' => 'nullable|exists:sizes,id',
                'quantity' => 'required|integer|min:1',
            ]);
            // Lấy biến thể sản phẩm từ database
            $productVariant = ProductVariant::where('product_id', $request->product_id)
                ->where('color_id', $request->color_id)
                ->where('size_id', $request->size_id)
                ->first(); // Dùng first() thay vì get()

            // Kiểm tra xem biến thể sản phẩm có tồn tại không
            if (!$productVariant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Biến thể sản phẩm không tồn tại.',
                ]);
            }

            // Kiểm tra xem số lượng người dùng muốn mua có vượt quá số lượng trong kho không
            if ($request->input('quantity') > $productVariant->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng sản phẩm trong kho không đủ. Số lượng còn lại: ' . $productVariant->stock_quantity,
                ]);
            }
            // Khởi tạo hoặc cập nhật giỏ hàng
            if (Auth::guard('web')->check()) {
                // User đã đăng nhập
                $this->updateCartForLoggedInUser($request);
                $cart = Cart::where('user_id', Auth::id())
                    ->with(['cartItems.product.images', 'cartItems.color', 'cartItems.size'])
                    ->first();
                $cartDetails = $this->getCartDetails($cart->cartItems);
            } else {
                // User chưa đăng nhập
                $this->updateCartForGuestUser($request);
                $cart = Session::get('cart', []);
                $cartDetails = $this->getCartDetailsFromSession($cart);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'cart_details' => $cartDetails,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in addToCart', [
                'user_id' => Auth::id() ?? 'Guest',
                'request_data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding to cart.',
            ], 500);
        }
    }

    private function updateCartForLoggedInUser(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $newItem = $request->only(['product_id', 'color_id', 'size_id', 'quantity']);

        $cartItem = $cart->cartItems()->where([
            ['product_id', '=', $newItem['product_id']],
            ['color_id', '=', $newItem['color_id']],
            ['size_id', '=', $newItem['size_id']],
        ])->first();

        if ($cartItem) {
            $cartItem->quantity += $newItem['quantity'];
            $cartItem->save();
        } else {
            $cart->cartItems()->create($newItem);
        }
    }

    private function updateCartForGuestUser(Request $request)
    {
        $cart = Session::get('cart', []);
        $newItem = $request->only(['product_id', 'color_id', 'size_id', 'quantity']);
        $found = false;

        foreach ($cart as &$item) {
            if (
                $item['product_id'] == $newItem['product_id'] &&
                $item['color_id'] == $newItem['color_id'] &&
                $item['size_id'] == $newItem['size_id']
            ) {
                $item['quantity'] += $newItem['quantity'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = $newItem;
        }

        Session::put('cart', $cart);
    }

    private function getCartDetails($cartItems)
    {
        $messages = [];

        // Xóa các mục không hợp lệ (số lượng = 0 hoặc tồn kho không đủ)
        $cartItems->each(function ($item) use (&$messages) {
            $variant = $item->product->variants()
                ->where('color_id', $item->color->id ?? null)
                ->where('size_id', $item->size->id ?? null)
                ->first();

            // Nếu biến thể không còn tồn kho hoặc số lượng <= 0, xóa mục này khỏi giỏ hàng
            if (!$variant || $variant->stock_quantity <= 0 || $item->quantity <= 0) {
                $messages[] = "Sản phẩm {$item->product->product_name} đã bị xóa do số lượng là 0 hoặc tồn kho không đủ."; // Thông báo xóa sản phẩm
                $item->delete();
            }
        });

        // Lấy chi tiết giỏ hàng còn lại
        return $cartItems->filter(function ($item) {
            return $item->quantity > 0; // Chỉ giữ các mục có số lượng > 0
        })->map(function ($item) use ($messages) {
            $product = $item->product;
            $color = $item->color;
            $size = $item->size;
            $image = $product->images->firstWhere('color_id', $color->id);
            $variant = $product->variants()
                ->where('color_id', $color->id ?? null)
                ->where('size_id', $size->id ?? null)
                ->first();

            // Giới hạn số lượng theo tồn kho
            if ($item->quantity > $variant->stock_quantity) {
                $messages[] = "Sản phẩm {$product->product_name} đã được giảm số lượng xuống còn {$variant->stock_quantity} do tồn kho không đủ."; // Thông báo giảm số lượng
                $item->quantity = $variant->stock_quantity;
                $item->save(); // Cập nhật trong cơ sở dữ liệu
            }

            // Tính toán giá cuối cùng (final_price)
            $variantPrice = $variant->price ?? 0; // Giá cộng thêm từ biến thể
            $basePrice = $product->price ?? 0;   // Giá gốc sản phẩm
            $price = $basePrice; // Tổng giá gốc + giá biến thể

            // Kiểm tra giảm giá
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
                $finalPrice = max($price - $discount, 0); // Giá không nhỏ hơn 0
            } else {
                $finalPrice = $price;
            }

            // Dữ liệu chi tiết giỏ hàng
            return [
                'product_id' => $product->id,
                'color_id' => $color->id ?? null,
                'size_id' => $size->id ?? null,
                'product_name' => $product->product_name ?? 'N/A',
                'slug' => $product->slug ?? 'N/A',
                'color_name' => $color->name ?? 'N/A',
                'size_name' => $size->name ?? 'N/A',
                'quantity' => $item->quantity,
                'price' => $product->price ?? 0,          // Giá gốc
                'pricebonus' => $variantPrice,           // Giá cộng thêm từ biến thể
                'final_price' => $finalPrice,            // Giá sau giảm giá
                'image_url' => $image->image_url ?? '/default-image.jpg',
                'subtotal' => $finalPrice * $item->quantity + $variantPrice * $item->quantity, // Tổng tiền
            ];
        })->toArray();
    }

    private function getCartDetailsFromSession($cart)
    {
        $messages = [];
        $productIds = array_column($cart, 'product_id');
        $colorIds = array_column($cart, 'color_id');
        $sizeIds = array_column($cart, 'size_id');

        // Truy vấn dữ liệu cần thiết
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $colors = Color::whereIn('id', $colorIds)->get()->keyBy('id');
        $sizes = Size::whereIn('id', $sizeIds)->get()->keyBy('id');
        $variants = ProductVariant::whereIn('product_id', $productIds)
            ->whereIn('color_id', $colorIds)
            ->whereIn('size_id', $sizeIds)
            ->get()
            ->keyBy(function ($variant) {
                return "{$variant->product_id}_{$variant->color_id}_{$variant->size_id}";
            });

        // Truy vấn giảm giá từ bảng product_sales
        $sales = ProductSale::whereIn('product_id', $productIds)
            ->where(function ($query) {
                $query->where('start_date', '<=', now())
                    ->where(function ($query) {
                        $query->whereNull('end_date')
                            ->orWhere('end_date', '>=', now());
                    });
            })
            ->get()
            ->keyBy('product_id');

        $updatedCart = array_map(function ($item) use ($products, $variants, $sales, &$messages) {
            $product = $products[$item['product_id']] ?? null;

            if (!$product) {
                return null;
            }

            $variantKey = "{$item['product_id']}_{$item['color_id']}_{$item['size_id']}";
            $variant = $variants[$variantKey] ?? null;

            if (!$variant || $variant->stock_quantity <= 0 || $item['quantity'] <= 0) {
                $messages[] = "Sản phẩm {$product->product_name} đã bị xóa do tồn kho không đủ.";
                return null;
            }

            if ($item['quantity'] > $variant->stock_quantity) {
                $messages[] = "Sản phẩm {$product->product_name} đã được giảm số lượng xuống còn {$variant->stock_quantity}.";
                $item['quantity'] = $variant->stock_quantity;
            }

            // Tính giá sau giảm giá
            $variantPrice = $variant->price; // Giá cộng thêm từ biến thể
            $basePrice = $product->price;   // Giá gốc sản phẩm
            $price = $basePrice; // Tổng giá gốc + giá biến thể

            $sale = $sales[$item['product_id']] ?? null;

            if ($sale) {
                if ($sale->discount_type === 'percent') {
                    $discount = ($price * $sale->discount_value) / 100;
                } elseif ($sale->discount_type === 'fixed') {
                    $discount = $sale->discount_value;
                } else {
                    $discount = 0;
                }
                $finalPrice = max($price - $discount, 0); // Giá không nhỏ hơn 0
            } else {
                $finalPrice = $price;
            }

            $item['variant_price'] = $variantPrice;
            $item['final_price'] = $finalPrice; // Cập nhật giá cuối cùng
            $item['subtotal'] = $finalPrice * $item['quantity'] + $variantPrice * $item['quantity'];

            return $item;
        }, $cart);

        $updatedCart = array_filter($updatedCart, fn($item) => $item !== null);
        Session::put('cart', array_values($updatedCart));

        return array_values(array_map(function ($item) use ($products, $colors, $sizes, $variants) {
            $product = $products[$item['product_id']];
            $variantKey = "{$item['product_id']}_{$item['color_id']}_{$item['size_id']}";
            $variant = $variants[$variantKey];
            $color = $colors[$item['color_id']] ?? null;
            $size = $sizes[$item['size_id']] ?? null;

            return [
                'product_id' => $item['product_id'],
                'color_id' => $item['color_id'],
                'size_id' => $item['size_id'],
                'product_name' => $product->product_name ?? 'N/A',
                'slug' => $product->slug ?? 'N/A',
                'color_name' => $color->name ?? 'N/A',
                'size_name' => $size->name ?? 'N/A',
                'quantity' => $item['quantity'],
                'price' => $product->price, // Giá gốc
                'pricebonus' => $variant->price, // Giá cộng thêm từ biến thể
                'final_price' => $item['final_price'], // Giá sau giảm giá
                'image_url' => $product->images->firstWhere('color_id', $item['color_id'])->image_url ?? '/default-image.jpg',
                'subtotal' => $item['subtotal'],
            ];
        }, $updatedCart));
    }



    public function viewCart()
    {
        $products = Product::query()
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->with([
                'colors' => fn($query) => $query->select('colors.id', 'colors.name', 'colors.sku_color'),
                'images' => fn($query) => $query->select('product_images.id', 'product_images.product_id', 'product_images.color_id', 'product_images.image_url'),
            ])
            ->select([
                'products.id',
                'products.product_name',
                'products.price',
                'products.slug',
                DB::raw('COUNT(DISTINCT product_variants.size_id) as distinct_size_count'), // Số size khác nhau
                DB::raw('(SELECT SUM(stock_quantity) FROM product_variants WHERE product_variants.product_id = products.id) as total_stock_quantity') // Tổng tồn kho chính xác
            ])
            ->groupBy('products.id')
            ->limit(10)
            ->get();

        $products = $products->map(function ($product) {
            // Nhóm ảnh theo color_id
            $imagesByColor = $product->images->groupBy('color_id');

            // Gắn main_image và hover_image vào từng màu
            $product->colors = $product->colors->map(function ($color) use ($imagesByColor) {
                $images = $imagesByColor->get($color->id, collect());
                $mainImage = $images->first()?->image_url ?? null; // Ảnh đầu tiên
                $hoverImage = $images->skip(1)->first()?->image_url ?? null; // Ảnh thứ hai

                return [
                    'id' => $color->id,
                    'name' => $color->name,
                    'sku_color' => $color->sku_color,
                    'main_image' => $mainImage,
                    'hover_image' => $hoverImage,
                ];
            });

            // Thiết lập main_image_url và hover_main_image_url cho sản phẩm
            $firstColor = $product->colors->first();
            $product->main_image_url = $firstColor ? $firstColor['main_image'] : null;
            $product->hover_main_image_url = $firstColor ? $firstColor['hover_image'] : null;

            // Chỉ giữ lại các trường cần thiết
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->price,
                'slug' => $product->slug,
                'distinct_size_count' => $product->distinct_size_count,
                'total_stock_quantity' => $product->total_stock_quantity,
                'main_image_url' => $product->main_image_url,
                'hover_main_image_url' => $product->hover_main_image_url,
                'colors' => $product->colors,
            ];
        });
        $cartDetails = [];

        if (Auth::guard('web')->check()) {
            // Lấy giỏ hàng từ cơ sở dữ liệu
            $cart = Cart::where('user_id', auth()->id())
                ->with([
                    'cartItems.product.images' => function ($query) {
                        $query->orderBy('color_id'); // Ưu tiên ảnh theo color_id
                    },
                    'cartItems.color',
                    'cartItems.size'
                ])
                ->first();

            if ($cart && $cart->cartItems->isNotEmpty()) {
                // Sử dụng hàm getCartDetails
                $cartDetails = $this->getCartDetails($cart->cartItems);
            }
        } else {
            // Lấy giỏ hàng từ session
            $cart = Session::get('cart', []);

            if (!empty($cart)) {
                // Sử dụng hàm getCartDetailsFromSession
                $cartDetails = $this->getCartDetailsFromSession($cart);
            }
        }

        // Trả về view với dữ liệu giỏ hàng
        return view('client.shopping-cart', compact('cartDetails', 'products'));
    }

    public function removeFromCart(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (auth()->check()) {
            // Lấy `cart_id` từ người dùng đã đăng nhập
            $cart = Cart::where('user_id', auth()->id())->first();

            // Xóa sản phẩm khỏi giỏ hàng dựa trên `cart_id`
            CartItem::where('cart_id', $cart->id)
                ->where('product_id', $request['product_id'])
                ->where('color_id', $request['color_id'])
                ->where('size_id', $request['size_id'])
                ->delete();
            // Trả về kết quả dưới dạng JSON
            return response()->json([
                'success' => true,
                'message' => 'Xóa sản phẩm thành công',
                'cart' => $cart->id,  // Trả về giỏ hàng đã được cập nhật
            ]);
        } else {
            // Lấy giỏ hàng từ session
            $cart = Session::get('cart', []);

            // Lọc bỏ sản phẩm muốn xóa dựa trên product_id, color_id, và size_id
            $cart = array_filter($cart, function ($item) use ($request) {
                return !(
                    $item['product_id'] == $request['product_id'] &&
                    $item['color_id'] == $request['color_id'] &&
                    $item['size_id'] == $request['size_id']
                );
            });

            // Reset lại chỉ số mảng để đảm bảo giỏ hàng có chỉ số liên tục
            $cart = array_values($cart);

            // Cập nhật lại giỏ hàng vào session
            Session::put('cart', $cart);

            // Trả về kết quả dưới dạng JSON
            return response()->json([
                'success' => true,
                'message' => 'Xóa sản phẩm thành công',
                'cart' => $cart
            ]);
        }

    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $colorId = $request->input('color_id');
        $sizeId = $request->input('size_id');
        $quantity = $request->input('quantity');

        $productVariant = ProductVariant::where('product_id', $request->product_id)
            ->where('color_id', $request->color_id)
            ->where('size_id', $request->size_id)
            ->first();
        if ($quantity < 1) {
            return response()->json(['success' => false, 'message' => 'Số lượng không hợp lệ']);
        }
        if ($request->input('quantity') > $productVariant->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng sản phẩm trong kho không đủ. Số lượng còn lại: ' . $productVariant->stock_quantity,
            ]);
        }
        if (Auth::check()) {
            // Người dùng đã đăng nhập
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id(),
            ]);

            // Tìm sản phẩm trong giỏ hàng
            $cartItem = $cart->cartItems()->where([
                ['product_id', '=', $productId],
                ['color_id', '=', $colorId],
                ['size_id', '=', $sizeId],
            ])->first();

            if ($cartItem) {
                // Cập nhật số lượng
                $cartItem->quantity = $quantity;
                $cartItem->save();
            } else {
                return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
            ]);
        } else {
            // Người dùng chưa đăng nhập: cập nhật session
            $cart = session()->get('cart', []);
            foreach ($cart as &$item) {
                if ($item['product_id'] == $productId && $item['color_id'] == $colorId && $item['size_id'] == $sizeId) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
            ]);
        }
    }
    public function getModalCart()
    {
        try {
            $cartDetails = [];

            if (Auth::guard('web')->check()) {
                // Người dùng đã đăng nhập: lấy giỏ hàng từ cơ sở dữ liệu
                $cart = Cart::where('user_id', auth()->id())
                    ->with([
                        'cartItems.product.images' => function ($query) {
                            $query->orderBy('color_id'); // Lấy ảnh ưu tiên theo color_id
                        },
                        'cartItems.color',
                        'cartItems.size'
                    ])
                    ->first();

                if ($cart && $cart->cartItems->isNotEmpty()) {
                    // Sử dụng hàm getCartDetails để định dạng dữ liệu
                    $cartDetails = $this->getCartDetails($cart->cartItems);
                }
            } else {
                // Người dùng chưa đăng nhập: lấy giỏ hàng từ session
                $cart = Session::get('cart', []);

                if (!empty($cart)) {
                    // Sử dụng hàm getCartDetailsFromSession
                    $cartDetails = $this->getCartDetailsFromSession($cart);
                }
            }

            return response()->json([
                'success' => true,
                'cart' => $cartDetails,
            ], 200);
        } catch (\Exception $e) {
            // Ghi log lỗi và trả về thông báo lỗi
            Log::error('Error in getModalCart', [
                'user_id' => Auth::id() ?? 'Guest',
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải giỏ hàng hãy thử tải lại trang!',
            ], 500);
        }
    }


    public function count(Request $request)
    {
        if (Auth::check()) {
            // Người dùng đã đăng nhập: tính số sản phẩm khác nhau từ database
            $distinctProducts = CartItem::whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
                ->select('product_id', 'color_id', 'size_id')
                ->distinct()
                ->count();
        } else {
            // Người dùng chưa đăng nhập: tính số sản phẩm khác nhau từ session
            $cart = $request->session()->get('cart', []);
            $distinctProducts = count(
                collect($cart)
                    ->map(fn($item) => [
                        'product_id' => $item['product_id'],
                        'color' => $item['color_id'],
                        'size' => $item['size_id']
                    ])
                    ->unique()
            );
        }

        return response()->json(['count' => $distinctProducts]);
    }
    public function applyCoupon(Request $request)
    {
        try {
            // Kiểm tra nếu người dùng chưa đăng nhập
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để áp dụng mã giảm giá.',
                ], 401);
            }
    
            // Kiểm tra mã giảm giá
            $couponCode = $request->input('coupon');
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
    
            // Lấy chi tiết giỏ hàng
            $cartDetails = $this->getCartDetails($cart->cartItems);
    
            $coupon = DiscountCode::where('code', $couponCode)
                ->where('start_date', '<=', now())
                ->where(function ($query) {
                    $query->whereNull('end_date')->orWhere('end_date', '>=', now());
                })
                ->first();
    
            if (!$coupon) {
                return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'], 400);
            }
    
            // Kiểm tra giới hạn sử dụng toàn cục
            if (!is_null($coupon->usage_limit) && $coupon->times_used >= $coupon->usage_limit) {
                return response()->json(['success' => false, 'message' => 'Mã giảm giá đã đạt giới hạn sử dụng.'], 400);
            }
    
            // Kiểm tra giới hạn người dùng cụ thể
            $userLimit = $coupon->userLimits()->where('user_id', auth()->id())->first();
            if ($userLimit) {
                if (!is_null($userLimit->usage_limit) && $userLimit->times_used >= $userLimit->usage_limit) {
                    return response()->json(['success' => false, 'message' => 'Bạn đã đạt giới hạn sử dụng mã giảm giá này.'], 400);
                }
            } elseif ($coupon->userLimits()->exists()) {
                return response()->json(['success' => false, 'message' => 'Mã giảm giá này không áp dụng cho bạn.'], 403);
            }
    
            // Tính tổng giá trị giỏ hàng từ `cartDetails`
            $totalPrice = collect($cartDetails)->sum('subtotal'); // Tổng giá trị hóa đơn
            $totalDiscount = 0;
    
            foreach ($cartDetails as $item) {
                // Kiểm tra nếu mã giảm giá chỉ áp dụng cho sản phẩm cụ thể
                $applicableProducts = $coupon->applicableProducts ?? collect();
                if (!$applicableProducts->isEmpty() && !$applicableProducts->pluck('product_id')->contains($item['product_id'])) {
                    continue; // Bỏ qua các sản phẩm không hợp lệ
                }
    
                // Tính giảm giá cho từng sản phẩm
                if ($coupon->discount_type === 'percent') {
                    $discount = ($item['final_price'] * $coupon->discount_value) / 100;
                } elseif ($coupon->discount_type === 'fixed') {
                    $discount = min($coupon->discount_value, $item['final_price']); // Đảm bảo giảm giá không vượt quá giá sản phẩm
                } else {
                    $discount = 0;
                }
    
                $totalDiscount += $discount;
            }
    
            // Nếu mã giảm giá áp dụng toàn bộ hóa đơn, tính giảm giá trên tổng hóa đơn
            if ($applicableProducts->isEmpty()) {
                if ($coupon->discount_type === 'percent') {
                    $totalDiscount = ($totalPrice * $coupon->discount_value) / 100;
                } elseif ($coupon->discount_type === 'fixed') {
                    $totalDiscount = $coupon->discount_value;
                }
            }
    
            $newTotal = max($totalPrice - $totalDiscount, 0); // Tổng giá trị mới sau giảm giá
    
            // Cập nhật số lần sử dụng mã giảm giá
            $coupon->increment('times_used');
            if ($userLimit) {
                $userLimit->increment('times_used');
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Mã giảm giá đã được áp dụng thành công!',
                'newTotal' => number_format($newTotal, 0, ',', '.'),
            ], 200);
    
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
