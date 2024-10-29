<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Tag;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with([
            'colors' => function ($query) {
                $query->select('colors.id', 'colors.name', 'colors.sku_color'); // Chỉ lấy cột cần thiết từ bảng colors
            },
            'variants',
            'tags' => function ($query) {
                $query->whereIn('type', ['collection', 'material']); // Lấy các tag thuộc loại collection và material
            }
        ])
            ->select('products.id','products.price', 'products.brand_id', 'products.slug', 'products.product_name', 'products.sku', 'products.description', 'products.status')
            ->addSelect([
                'image_url' => ProductImage::select('image_url')
                    ->whereColumn('product_images.product_id', 'products.id')
                    ->limit(1),
                'total_stock_quantity' => ProductVariant::select(DB::raw('SUM(stock_quantity)'))
                    ->whereColumn('product_variants.product_id', 'products.id')
            ])->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('product_name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->paginate(10);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id') // Lọc danh mục cha
            ->where('status', 1) // Chỉ lấy danh mục có status = 1
            ->with([
                'children' => function ($query) {
                    $query->where('status', 1); // Lọc danh mục con có status = 1
                }
            ])
            ->get();
        $brands = Brand::all();
        $colors = Color::all();
        $tagCollection = Tag::where('type', 'collection')->get();
        $tagMaterial = Tag::where('type', 'material')->get();
        return view('admin.product.create', compact('categories', 'brands', 'colors', 'tagCollection', 'tagMaterial'));
    }
    public function getVariantCard($colorId)
    {
        $color = Color::find($colorId);
        $sizes = Size::all();
        // Trả về view phụ chứa thẻ card, truyền thêm dữ liệu nếu cần
        return view('admin.product.variant-card', compact('color', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {

        DB::transaction(function () use ($request) {
            // 1. Lưu thông tin sản phẩm chính
            $product = Product::create([
                'brand_id' => $request->input('brand_id'),
                'product_name' => $request->input('product_name'),
                'sku' => $request->input('product_code'),
                'slug' => $request->input('slug'),
                'price' => $request->input('price'),
                'status' => $request->input('status'),
                'description' => $this->processDescription($request->input('description')),
            ]);
            // Lưu tags cho tagCollection và tagMaterial
            if ($request->has('tagCollection')) {
                $this->syncTags($product, $request->input('tagCollection'), 'collection');
            }

            if ($request->has('tagMaterial')) {
                $this->syncTags($product, $request->input('tagMaterial'), 'material');
            }

            // 2. Đồng bộ danh mục sản phẩm với bảng `category_product`
            if ($request->has('categories')) {
                $product->categories()->sync($request->input('categories'));
            }

            // 3. Lưu các biến thể sản phẩm
            $variantIds = $this->storeProductVariants($product, $request->input('variants'), $request->input('product_code'));

            // 4. Lưu ảnh sản phẩm
            $this->storeProductImages($product->id, $request->file('images'));
        });

        return redirect()->route('admin.product.create')->with('success', 'Sản phẩm đã được thêm thành công');
    }
    protected function syncTags($product, $tagIds, $type = null)
    {
        foreach ($tagIds as $tagId) {
            $tag = Tag::find($tagId);
            if ($tag && $tag->type === $type) {
                $product->tags()->syncWithoutDetaching([$tagId]);
            }
        }
    }

    // Hàm xử lý lưu biến thể sản phẩm
    protected function storeProductVariants($product, $variants, $productCode)
    {
        $variantIds = [];
        if ($variants) {
            foreach ($variants as $colorId => $variantData) {
                foreach ($variantData['sizes'] as $sizeId => $sizeData) {
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id' => $colorId,
                        'size_id' => $sizeId,
                        'product_code' => $productCode . '-' . strtoupper($colorId) . '-' . strtoupper($sizeId),
                        'stock_quantity' => $sizeData['stock_quantity'],
                        'price' => $sizeData['price']?? 0,
                    ]);

                    $variantIds["$colorId-$sizeId"] = $variant->id;
                }
            }
        }
        return $variantIds;
    }

    // Hàm xử lý lưu ảnh sản phẩm
    protected function storeProductImages($productId, $images)
    {
        if ($images) {
            foreach ($images as $colorId => $files) {
                foreach ($files as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('product', $filename, 'public');

                    ProductImage::create([
                        'product_id' => $productId,
                        'color_id' => $colorId,
                        'image_url' => $path,
                    ]);
                }
            }
        }
    }

    private function processDescription($description)
    {
        if (empty(trim($description))) {
            return ''; // Trả về chuỗi rỗng nếu không có nội dung
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Bỏ qua các lỗi HTML không hợp lệ
        $dom->loadHTML(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'));

        foreach ($dom->getElementsByTagName('img') as $img) {
            /** @var \DOMElement $img */
            $src = $img->getAttribute('src');

            // Kiểm tra nếu ảnh được encode base64
            if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                $data = substr($src, strpos($src, ',') + 1);
                $data = base64_decode($data);

                // Tạo tên ảnh ngẫu nhiên
                $imageName = uniqid() . '.png';
                $filePath = "public/summernote/$imageName";
                Storage::put($filePath, $data);

                // Cập nhật đường dẫn của ảnh trong nội dung
                $img->setAttribute('src', asset("storage/summernote/$imageName"));
            }
        }

        // Chỉ lấy phần nội dung bên trong <body>
        $bodyContent = '';
        foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $child) {
            $bodyContent .= $dom->saveHTML($child);
        }

        return $bodyContent; // Trả về nội dung đã xử lý
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with([
            'colors' => function ($query) use ($id) {
                // Lọc màu sắc có ít nhất một biến thể thuộc sản phẩm này
                $query->whereHas('variants', function ($subQuery) use ($id) {
                    $subQuery->where('product_id', $id);
                })->select('colors.id', 'colors.name');
            }
        ])->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Lấy ID các màu thuộc sản phẩm
        $colorIds = $product->colors->pluck('id')->toArray();

        // Lấy biến thể theo danh sách màu và sản phẩm ID, đồng thời nhóm theo màu
        $variantsGroupedByColor = ProductVariant::whereIn('color_id', $colorIds)
            ->where('product_id', $id)
            ->with(['color:id,name', 'size:id,name']) // Chỉ lấy các trường cần thiết từ color và size
            ->get()
            ->groupBy('color_id');
        // Lấy ảnh của sản phẩm theo từng màu và nhóm theo màu
        $imagesGroupedByColor = ProductImage::where('product_id', $id)
            ->whereIn('color_id', $colorIds)
            ->select('color_id', 'image_url')
            ->get()
            ->groupBy('color_id');
        return view('admin.product.show', compact('product', 'variantsGroupedByColor','imagesGroupedByColor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
