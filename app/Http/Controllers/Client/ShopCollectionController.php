<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopCollectionController extends Controller
{
    /**
     * Hiển thị trang bộ sưu tập.
     */
    public function index(Request $request, $slug = null)
    {
        // Lấy danh sách danh mục và các thương hiệu
        $categories = $this->getCategories();
        $brands = Brand::withCount('products')->get();

        // Lấy sản phẩm theo các tham số lọc
        $products = $this->getFilteredProducts($request);

        // Trả về HTML nếu yêu cầu AJAX
        if ($request->ajax()) {
            return view('client.partials.product_list', compact('products'))->render();
        }

        return view('client.shop-collection', compact('categories', 'brands', 'products'));
    }

    /**
     * Lọc và lấy danh sách sản phẩm theo các tham số từ request.
     */
    private function getFilteredProducts(Request $request)
{
    // Lấy các tham số lọc từ request
    $categoryId = $request->get('category');
    $priceMin = $request->get('price_min');
    $priceMax = $request->get('price_max');
    $brand = $request->get('brand');
    $colors = $request->get('color'); // Mảng màu sắc được chọn
    $size = $request->get('size');

    // Khởi tạo truy vấn sản phẩm
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

    // Áp dụng các bộ lọc
    if ($categoryId) {
        $productsQuery->where('category_product.category_id', $categoryId);
    }
    if (is_numeric($priceMin) && is_numeric($priceMax) && $priceMin <= $priceMax) {
        $productsQuery->whereBetween('products.price', [(int)$priceMin, (int)$priceMax]);
    }
    if ($brand) {
        $productsQuery->whereIn('products.brand', (array) $brand); // Lọc theo brand
    }
    if ($colors) {
        $productsQuery->whereIn('product_variants.color_id', (array) $colors); // Lọc theo màu sắc
    }
    if ($size) {
        $productsQuery->whereHas('productVariants', function ($query) use ($size) {
            $query->where('size_id', $size);
        });
    }

    // Phân trang kết quả sản phẩm
    $products = $productsQuery->paginate(15)->appends($request->except('page'));

    // Xử lý sản phẩm để tạo thêm thông tin màu sắc, hình ảnh
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
            'colors' => $product->colors, // Danh sách màu sắc của sản phẩm
        ];
    });

    return $products;
}


    /**
     * Lấy danh sách danh mục
     */
    private function getCategories()
    {
        return Category::with(['children' => fn($query) => $query->where('status', 1)])
            ->where('status', 1)
            ->whereNull('parent_id')
            ->get();
    }

    /**
     * Lấy danh sách sản phẩm theo các tham số lọc từ request (dành cho fetchProducts).
     */
    public function fetchProducts(Request $request)
    {
        $products = $this->getFilteredProducts($request);
        return view('client.partials.product_list', compact('products'))->render();
    }
}
