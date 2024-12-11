<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopCollectionController extends Controller
{
    /**
     * Hiển thị trang bộ sưu tập.
     */
    public function index(Request $request, $slug = null)
    {
        // Lấy danh sách danh mục, thương hiệu, màu sắc
        $categories = $this->getCategories();
        $brands = Brand::withCount('products')->get();
        $colors = Color::withCount('products')->get();
    
        // Lấy danh sách kích thước
        $sizes = Size::withCount('productVariants')->get();
    
        // Lấy sản phẩm đã lọc từ request
        $products = $this->getFilteredProducts($request);
    
        // Kiểm tra nếu yêu cầu là AJAX, trả về danh sách sản phẩm dưới dạng HTML
        if ($request->ajax()) {
            return view('client.partials.product_list', compact('products'))->render();
        }
    
        // Trả về view với tất cả các dữ liệu cần thiết
        return view('client.shop-collection', compact('categories', 'brands', 'colors', 'sizes', 'products'));
    }



    /**
     * Lọc và lấy danh sách sản phẩm theo các tham số từ request.
     */
    public function getFilteredProducts(Request $request)
{
    // Lấy các tham số lọc từ request
    $categoryId = $request->get('category');
    $priceMin = $request->get('price_min');
    $priceMax = $request->get('price_max');
    $brand = $request->get('brand');
    $colors = $request->get('color'); // Màu sắc từ request
    $size = $request->get('size'); // Kích thước từ request

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
        $productsQuery->where('products.brand_id', $brand);
    }
    if ($colors) {
        // Lọc theo các màu sắc đã chọn
        $productsQuery->whereIn('product_variants.color_id', (array) $colors);
    }
    if ($size) {
        // Lọc theo kích thước đã chọn
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
