<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
  
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('accountUser.login')->with('error', 'Bạn cần đăng nhập để thêm vào danh sách yêu thích.');
        }
    
        $userId = Auth::id();
        $productId = $request->input('product_id');
    
      
        $exists = Wishlist::where('user_id', $userId)->where('product_id', $productId)->exists();
    
        if ($exists) {
            return redirect()->back()->with('error', 'Sản phẩm đã có trong danh sách yêu thích.');
        }
    
      
        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào danh sách yêu thích.');
    }
    


    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('accountUser.login')->with('error', 'Bạn cần đăng nhập để xóa khỏi danh sách yêu thích.');
        }
    
        $userId = Auth::id();
        $productId = $request->input('product_id');
    
        $wishlistItem = Wishlist::where('user_id', $userId)->where('product_id', $productId);
    
        if ($wishlistItem->exists()) {
            $wishlistItem->delete();
            return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi danh sách yêu thích.');
        }
    
        return redirect()->back()->with('error', 'Sản phẩm không có trong danh sách yêu thích.');
    }
    
    public function getWishlist()
    {
        if (!Auth::check()) {
            return redirect()->route('accountUser.login')->with('error', 'Bạn cần đăng nhập để xem danh sách yêu thích.');
        }

       
        $userId = Auth::id();

      
        $wishlistProductIds = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        if (empty($wishlistProductIds)) {
            return view('client.wishlist', ['message' => 'Danh sách yêu thích của bạn trống.']);
        }

      
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
                DB::raw('COUNT(DISTINCT product_variants.size_id) as distinct_size_count'), 
                DB::raw('(SELECT SUM(stock_quantity) FROM product_variants WHERE product_variants.product_id = products.id) as total_stock_quantity') 
            ])
            ->whereIn('products.id', $wishlistProductIds) 
            ->groupBy('products.id')
            ->get();

        $products = $products->map(function ($product) {
          
            $imagesByColor = $product->images->groupBy('color_id');

          
            $product->colors = $product->colors->map(function ($color) use ($imagesByColor) {
                $images = $imagesByColor->get($color->id, collect());
                $mainImage = $images->first()?->image_url ?? null; 
                $hoverImage = $images->skip(1)->first()?->image_url ?? null; 

                return [
                    'id' => $color->id,
                    'name' => $color->name,
                    'sku_color' => $color->sku_color,
                    'main_image' => $mainImage,
                    'hover_image' => $hoverImage,
                ];
            });

          
            $firstColor = $product->colors->first();
            $product->main_image_url = $firstColor ? $firstColor['main_image'] : null;
            $product->hover_main_image_url = $firstColor ? $firstColor['hover_image'] : null;

         
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
        $wishlist = [];

        if (Auth::check()) {
           
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray(); 
        }
        return view('client.wishlist', compact('products','wishlist'));
    }
    
    public function getCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }
        $userId = Auth::id();
        $count = Wishlist::where('user_id', $userId)->count();
        return response()->json(['count' => $count]);
    }

}

