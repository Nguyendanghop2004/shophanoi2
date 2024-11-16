<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Hiển thị wishlist của người dùng
    // public function index()
    // {
    //     $wishlists = Wishlist::where('user_id', Auth::id())->with('product')->get();
    //     return view('wishlist.index', compact('wishlists'));
    // }

    // // Thêm sản phẩm vào wishlist
    // public function add($productId)
    // {
    //     $product = Product::findOrFail($productId);
        
    //     // Kiểm tra nếu sản phẩm đã có trong wishlist
    //     $exists = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->exists();
    //     if ($exists) {
    //         return redirect()->route('wishlist.index')->with('message', 'Product already in wishlist');
    //     }

    //     // Thêm sản phẩm vào wishlist
    //     Wishlist::create([
    //         'user_id' => Auth::id(),
    //         'product_id' => $productId,
    //     ]);

    //     return redirect()->route('wishlist.index')->with('message', 'Product added to wishlist');
    // }

    // // Xóa sản phẩm khỏi wishlist
    // public function remove($productId)
    // {
    //     $wishlist = Wishlist::where('user_id', Auth::id())->where('product_id', $productId)->first();

    //     if ($wishlist) {
    //         $wishlist->delete();
    //         return redirect()->route('wishlist.index')->with('message', 'Product removed from wishlist');
    //     }

    //     return redirect()->route('wishlist.index')->with('message', 'Product not found in wishlist');
    // }
    public function index(Request $request)
    {
        $session_id = $request->session()->getId();
        $wishlistItems = Wishlist::where('session_id', $session_id)->with('product')->get();
        return view('client.wishlist', compact('wishlistItems'));
    }

    public function add(Request $request, $id)
    {
        $session_id = $request->session()->getId();

        // Kiểm tra xem sản phẩm đã có trong wishlist chưa
        $exists = Wishlist::where('session_id', $session_id)->where('product_id', $id)->exists();

        if (!$exists) {
            Wishlist::create([
                'product_id' => $id,
                'session_id' => $session_id
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào danh sách yêu thích');
    }

    public function remove(Request $request, $id)
    {
        $session_id = $request->session()->getId();

        Wishlist::where('session_id', $session_id)->where('product_id', $id)->delete();

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi danh sách yêu thích');
    }
}
