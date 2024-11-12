<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Hiển thị wishlist của người dùng
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->with('product')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    // Thêm sản phẩm vào wishlist
    public function add($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Kiểm tra nếu sản phẩm đã có trong wishlist
        $exists = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->exists();
        if ($exists) {
            return redirect()->route('wishlist.index')->with('message', 'Product already in wishlist');
        }

        // Thêm sản phẩm vào wishlist
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);

        return redirect()->route('wishlist.index')->with('message', 'Product added to wishlist');
    }

    // Xóa sản phẩm khỏi wishlist
    public function remove($productId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->first();

        if ($wishlist) {
            $wishlist->delete();
            return redirect()->route('wishlist.index')->with('message', 'Product removed from wishlist');
        }

        return redirect()->route('wishlist.index')->with('message', 'Product not found in wishlist');
    }
}
