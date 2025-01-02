<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    // Hiển thị danh sách sản phẩm trong wishlist
    // public function index(Request $request)
    // {
    //     // Dùng session ID làm user_id nếu người dùng không đăng nhập
        
    //     // $userId = auth()->check() ? auth()->id() : $request->session()->getId();

    //     $wishlistItems = Wishlist::where('user_id')
    //         ->with('product')
    //         ->get();
    //         dd($wishlistItems); //
    //     return view('wishlist', compact('wishlistItems'));
//     // }
//     public function index(Request $request)
//     {
       
//         // Sử dụng session ID hoặc user ID nếu người dùng đăng nhập
//         $userId = auth()->check() ? auth()->id() : $request->session()->getId();
    
//         // Truy vấn danh sách wishlist theo user ID
//         $wishlistItems = Wishlist::where('user_id', $userId)
//             ->with('product') // Eager load sản phẩm
//             ->get();
//     // dd($wishlistItems);
//         // Trả về view cùng với dữ liệu wishlist
//         return view('wishlist', compact('wishlistItems'));
//     }
//     // Thêm sản phẩm vào wishlist
//     public function add(Request $request, $productId)
//     {
//         // if (!auth()->check()) {
//         //     // Lưu URL hiện tại để chuyển hướng lại sau khi đăng nhập
//         //     $request->session()->put('url.intended', url()->previous());
//         // $userId = auth()->check() ? auth()->id() : $request->session()->getId();

//         // // Kiểm tra nếu sản phẩm đã tồn tại trong wishlist
//         // if (!Wishlist::where('product_id', $productId)->where('user_id', $userId)->exists()) {
//         //     Wishlist::create([
//         //         'product_id' => $productId,
//         //         'user_id' => $userId,
//         //     ]);
//         // }

//         // return redirect()->back()->with('success', 'Product added to wishlist.');
//         if (!auth()->check()) {
//             // Lưu URL hiện tại để chuyển hướng lại sau khi đăng nhập
//             $request->session()->put('url.intended', url()->previous());

//             // Chuyển hướng đến trang đăng nhập
//             return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào wishlist.');
//         }

//         // Lấy ID người dùng đã đăng nhập
//         $userId = auth()->id();

//         // Kiểm tra nếu sản phẩm đã tồn tại trong wishlist
//         if (!Wishlist::where('product_id', $productId)->where('user_id', $userId)->exists()) {
//             Wishlist::create([
//                 'product_id' => $productId,
//                 'user_id' => $userId,
//             ]);
//         }

//         // Chuyển hướng lại với thông báo thành công
//         return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào wishlist.');
//     }
//     }


    

//     // Xóa sản phẩm khỏi wishlist
//     // public function remove(Request $request, $id)
//     // {
//     //     $userId = auth()->check() ? auth()->id() : $request->session()->getId();

//     //     Wishlist::where('id', $id)->where('user_id', $userId)->delete();

//     //     return response()->json(['message' => 'Product removed from wishlist'], 200);
//     // }
//     public function remove(Request $request, $id)
// {
//     $userId = auth()->check() ? auth()->id() : $request->session()->getId();

//     Wishlist::where('id', $id)->where('user_id', $userId)->delete();

//     return redirect()->back()->with('success', 'Product removed from wishlist.');
// }
// }
public function index(Request $request)
{
    $userId = auth()->check() ? auth()->id() : $request->session()->getId();
    $wishlistItems = Wishlist::where('user_id', $userId)->with('product')->get();

    return view('wishlist', compact('wishlistItems'));
}

public function add(Request $request, $productId)
{
    if (!auth()->check()) {
        $request->session()->put('url.intended', url()->previous());
        return redirect()->route('accountUser.login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào wishlist.');
    }

    $userId = auth()->id();
    if (!Wishlist::where('product_id', $productId)->where('user_id', $userId)->exists()) {
        Wishlist::create(['product_id' => $productId, 'user_id' => $userId]);
    }

    return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào wishlist.');
}

public function remove(Request $request, $id)
{
    $userId = auth()->check() ? auth()->id() : $request->session()->getId();
    Wishlist::where('id', $id)->where('user_id', $userId)->delete();

    return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi wishlist.');
}
}