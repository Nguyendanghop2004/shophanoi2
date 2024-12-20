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
        return $cartItems->map(function ($item) {
            $product = $item->product;
            $color = $item->color;
            $size = $item->size;
            $image = $product->images->firstWhere('color_id', $color->id);
            $variant = $product->variants()
                ->where('color_id', $color->id ?? null)
                ->where('size_id', $size->id ?? null)
                ->first();

            return [
                'product_id' => $product->id,
                'color_id' => $color->id ?? null,
                'size_id' => $size->id ?? null,
                'product_name' => $product->product_name ?? 'N/A',
                'color_name' => $color->name ?? 'N/A',
                'size_name' => $size->name ?? 'N/A',
                'quantity' => $item->quantity,
                'price' => $product->price ?? 0,
                'pricebonus' => $variant->price ?? 0,
                'image_url' => $image->image_url ?? '/default-image.jpg',
                'subtotal' => ($product->price + $variant->price),
            ];
        })->toArray();
    }

    private function getCartDetailsFromSession($cart)
    {
        $productIds = array_column($cart, 'product_id');
        $colorIds = array_column($cart, 'color_id');
        $sizeIds = array_column($cart, 'size_id');

        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $colors = Color::whereIn('id', $colorIds)->get()->keyBy('id');
        $sizes = Size::whereIn('id', $sizeIds)->get()->keyBy('id');
        $images = ProductImage::whereIn('product_id', $productIds)
            ->whereIn('color_id', $colorIds)
            ->get()
            ->groupBy('product_id');

        // Lấy tất cả các variants tương ứng với sản phẩm, màu và kích thước
        $variants = ProductVariant::whereIn('product_id', $productIds)
            ->whereIn('color_id', $colorIds)
            ->whereIn('size_id', $sizeIds)
            ->get()
            ->keyBy(function ($variant) {
                return "{$variant->product_id}_{$variant->color_id}_{$variant->size_id}";
            });

        return array_map(function ($item) use ($products, $colors, $sizes, $images, $variants) {
            $product = $products[$item['product_id']] ?? null;
            $color = $colors[$item['color_id']] ?? null;
            $size = $sizes[$item['size_id']] ?? null;
            $image = $images[$item['product_id']]->firstWhere('color_id', $item['color_id']) ?? null;

            // Tạo key để tra cứu variant
            $variantKey = "{$item['product_id']}_{$item['color_id']}_{$item['size_id']}";
            $variant = $variants[$variantKey] ?? null;
            return [
                'product_id' => $item['product_id'],
                'color_id' => $color->id ?? null,
                'size_id' => $size->id ?? null,
                'product_name' => $product->product_name ?? 'N/A',
                'color_name' => $color->name ?? 'N/A',
                'size_name' => $size->name ?? 'N/A',
                'quantity' => $item['quantity'],
                'price' => $item['price'] ?? $product->price,
                'pricebonus' => $variant->price ?? 0,
                'image_url' => $image->image_url ?? '/default-image.jpg',
                'subtotal' => ($product->price + $variant->price ?? 0),
            ];
        }, $cart);
    }
    public function viewCart()
    {
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
        return view('client.shopping-cart', compact('cartDetails'));
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
                'message' => 'Product removed from cart',
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
                'message' => 'Product removed from cart',
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
                'message' => 'Unable to retrieve cart details.',
            ], 500);
        }
    }





}