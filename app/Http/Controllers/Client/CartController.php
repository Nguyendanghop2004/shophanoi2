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

class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng

    public function addToCart(Request $request)
    {
        if (Auth::guard('web')->check()) {
            // Lấy hoặc tạo giỏ hàng cho người dùng đã đăng nhập
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::guard('web')->id(),
            ]);

            // Dữ liệu sản phẩm thêm vào giỏ hàng
            $newItem = [
                'product_id' => $request['product_id'],
                'color_id' => $request['color_id'],
                'size_id' => $request['size_id'],
                'quantity' => $request['quantity'],
                'price' => floatval($request['price']),
            ];
            // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
            $cartItem = $cart->cartItems()->where([
                ['product_id', '=', $newItem['product_id']],
                ['color_id', '=', $newItem['color_id']],
                ['size_id', '=', $newItem['size_id']],
            ])->first();

            if ($cartItem) {
                // Nếu sản phẩm đã tồn tại, cập nhật số lượng
                $cartItem->quantity += $newItem['quantity'];
                $cartItem->save();
            } else {
                // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
                $cart->cartItems()->create($newItem);
            }
            // Trả về phản hồi với danh sách sản phẩm trong giỏ hàng
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'cart' => $cart->cartItems, // Danh sách sản phẩm trong giỏ hàng
            ]);
        } else {
            // Người dùng chưa đăng nhập, lưu giỏ hàng vào session
            $cart = Session::get('cart', []);

            // Dữ liệu sản phẩm thêm vào giỏ hàng
            $newItem = [
                'product_id' => $request['product_id'],
                'color_id' => $request['color_id'],
                'size_id' => $request['size_id'],
                'quantity' => $request['quantity'],
                'price' => floatval($request['price']),
            ];

            // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa (dựa vào product_id, color_id, size_id)
            $found = false;
            foreach ($cart as &$item) {
                if (
                    $item['product_id'] == $newItem['product_id'] &&
                    $item['color_id'] == $newItem['color_id'] &&
                    $item['size_id'] == $newItem['size_id']
                ) {
                    $item['quantity'] += $newItem['quantity']; // Cộng dồn số lượng
                    $found = true;
                    break;
                }
            }

            // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
            if (!$found) {
                $cart[] = $newItem;
            }

            // Lưu giỏ hàng vào session
            Session::put('cart', $cart);

            // Trả về phản hồi
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'cart' => $cart, // Gửi giỏ hàng hiện tại về để frontend xử lý
            ]);
        }
<<<<<<< HEAD
=======

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
>>>>>>> 696546089058e165075c0968a6c0b72b4a1e8092
    }
    public function viewCart()
    {
        $categories = Category::with(relations: [
            'children' => function ($query) {
                $query->where('status', 1);
            }
        ])->where('status', 1)
            ->whereNull('parent_id')->get();

        $cartDetails = [];

        if (Auth::guard('web')->check()) {
            // Người dùng đã đăng nhập: lấy giỏ hàng từ cơ sở dữ liệu
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
                $cartDetails = $cart->cartItems->map(function ($item) {
                    $product = $item->product;
                    $color = $item->color;
                    $size = $item->size;
                    $image = $product->images->firstWhere('color_id', $color->id);

                    return [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item->quantity,
                        'price' => $item->price ?? $product->price,
                        'image_url' => $image->image_url ?? '/default-image.jpg',
                        'subtotal' => ($item->price ?? $product->price) * $item->quantity,
                    ];
                })->toArray();
            }
        } else {
            // Người dùng chưa đăng nhập: lấy giỏ hàng từ session
            $cart = Session::get('cart', []);

            if (!empty($cart)) {
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

                $cartDetails = array_map(function ($item) use ($products, $colors, $sizes, $images) {
                    $product = $products[$item['product_id']] ?? null;
                    $color = $colors[$item['color_id']] ?? null;
                    $size = $sizes[$item['size_id']] ?? null;
                    $image = $images[$item['product_id']]->firstWhere('color_id', $item['color_id']) ?? null;

                    return [
                        'product_id' => $item['product_id'],
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item['quantity'],
                        'price' => $item['price'] ?? $product->price,
                        'image_url' => $image->image_url ?? '/default-image.jpg',
                        'subtotal' => ($product->price ?? 0) * $item['quantity'],
                    ];
                }, $cart);
            }
        }

        return view('client.shopping-cart', compact('cartDetails', 'categories'));
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
        }

    }

    // Hàm lấy giỏ hàng của người dùng từ cơ sở dữ liệu
    private function getUserCart($userId)
    {
        return DB::table('cart_items')
            ->where('user_id', $userId)
            ->get();
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

            // Tính tổng giá trị giỏ hàng
            $totalPrice = $cart->cartItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
                'total_price' => $totalPrice,
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

            // Tính tổng giá trị giỏ hàng
            $totalPrice = array_sum(array_map(function ($item) {
                return $item['quantity'] * $item['price'];
            }, $cart));

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
                'total_price' => $totalPrice,
            ]);
        }
    }






}
