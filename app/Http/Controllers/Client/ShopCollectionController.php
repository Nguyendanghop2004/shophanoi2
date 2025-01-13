<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Wishlist;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopCollectionController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        $categories = $this->getCategories();
        $brands = Brand::withCount('products')->get();
        $colors = Color::withCount('products')->get();

        $sizes = Size::withCount('productVariants')->get();

        $products = $this->getFilteredProducts($request);
        if ($request->ajax()) {
            return view('client.partials.product_list', compact('products'))->render();
        }
        
        $wishlist = [];

        if (Auth::check()) {
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray(); 
        }

        return view('client.shop-collection', compact('categories', 'brands', 'colors', 'sizes', 'products', 'wishlist'));
    }

    public function getFilteredProducts(Request $request)
    {
        $categoryId = $request->get('category');
        $priceMin = $request->get('price_min');
        $priceMax = $request->get('price_max');
        $brand = $request->get('brand');
        $colors = $request->get('color');
        $size = $request->get('size'); 

        $productsQuery = Product::query()
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
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
                DB::raw('(SELECT SUM(stock_quantity) FROM product_variants WHERE product_variants.product_id = products.id) as total_stock_quantity'),
            ])
            ->groupBy('products.id');

        if ($categoryId) {
            $productsQuery->where('category_product.category_id', $categoryId);
        }
        if (is_numeric($priceMin) && is_numeric($priceMax) && $priceMin <= $priceMax) {
            $productsQuery->whereBetween('products.price', [(int)$priceMin, (int)$priceMax]);
        }
        if ($brand) {
            $productsQuery->where('products.brand_id', $brand);
        }
        if ($colors) {
            $productsQuery->whereIn('product_variants.color_id', (array) $colors);
        }
        if ($size) {
            $productsQuery->whereHas('productVariants', function ($query) use ($size) {
                $query->where('size_id', $size);
            });
        }

        $products = $productsQuery->paginate(15)->appends($request->except('page'));

        $products->getCollection()->transform(function ($product) {
            $imagesByColor = $product->images->groupBy('color_id');
            $product->colors = $product->colors->map(function ($color) use ($imagesByColor) {
                $images = $imagesByColor->get($color->id, collect());
                return [
                    'id' => $color->id,
                    'name' => $color->name,
                    'sku_color' => $color->sku_color,
                    'main_image' => $images->first()?->image_url ?? null,
                    'hover_image' => $images->skip(1)->first()?->image_url ?? null,
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
      
        return $products;
    }

    private function getCategories()
    {
        return Category::with(['children' => fn($query) => $query->where('status', 1)])
            ->where('status', 1)
            ->whereNull('parent_id')
            ->get();
    }
}
