<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\CreateVariantProductRequest;
use App\Http\Requests\Admin\UpdateMainProductRequest;
use App\Http\Requests\Admin\UpdateVariantProductRequest;
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
            ->select('products.id', 'products.price', 'products.brand_id', 'products.slug', 'products.product_name', 'products.sku', 'products.description', 'products.status')
            ->addSelect([
                'image_url' => ProductImage::select('image_url')
                    ->whereColumn('product_images.product_id', 'products.id')
                    ->inRandomOrder()
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
    // Hàm xử lý lưu tag sản phẩm
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
                        'product_code' => $this->generateProductCode($productCode, $colorId, $sizeId),
                        'stock_quantity' => $sizeData['stock_quantity'],
                        'price' => $sizeData['price'] ?? 0,
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
            'colors' => function ($query) {
                $query->select('colors.id', 'colors.name') // Sử dụng tên bảng để tránh mơ hồ
                    ->whereHas('variants'); // Lọc màu sắc có ít nhất một biến thể
            },
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'color_id', 'size_id', 'product_code', 'status') // Đảm bảo không có xung đột cột
                    ->with(['color:id,name', 'size:id,name']); // Chỉ lấy các trường cần thiết
            },
            'images' => function ($query) {
                $query->select('color_id', 'image_url', 'product_id'); // Chỉ lấy các trường cần thiết
            },
            'brand:id,name,image_brand_url', // Lấy thông tin thương hiệu
            'categories:id,name' // Lấy danh sách danh mục
        ])->findOrFail($id);

        // Nhóm biến thể theo màu
        $variantsGroupedByColor = $product->variants->groupBy('color_id');

        // Nhóm ảnh theo màu
        $imagesGroupedByColor = $product->images->groupBy('color_id');

        return view('admin.product.show', compact('product', 'variantsGroupedByColor', 'imagesGroupedByColor'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();

        $categories = Category::whereNull('parent_id') // Lọc danh mục cha
            ->where('status', 1) // Chỉ lấy danh mục có status = 1
            ->with([
                'children' => function ($query) {
                    $query->where('status', 1); // Lọc danh mục con có status = 1
                }
            ])
            ->get();
        $tagCollection = Tag::where('type', 'collection')->get();
        $tagMaterial = Tag::where('type', 'material')->get();
        $product = Product::with([
            'colors' => function ($query) {
                $query->select('colors.id', 'colors.name', 'colors.sku_color') // Sử dụng tên bảng để tránh mơ hồ
                    ->whereHas('variants'); // Lọc màu sắc có ít nhất một biến thể
            },
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'color_id', 'size_id', 'product_code', 'status', 'price', 'stock_quantity') // Đảm bảo không có xung đột cột
                    ->with(['color:id,name', 'size:id,name']); // Chỉ lấy các trường cần thiết
            },
            'images' => function ($query) {
                $query->select('color_id', 'image_url', 'product_id'); // Chỉ lấy các trường cần thiết
            },
            'brand:id,name,image_brand_url', // Lấy thông tin thương hiệu
            'categories:id,name', // Lấy danh sách danh mục
            'tags:id,name,type'
        ])->findOrFail($id);
        $tagsCollectionEdit = $product->tags->where('type', 'collection')->values(); // Tags với type là collection
        $tagsMaterialEdit = $product->tags->where('type', 'material')->values(); // Tags với type là material

        // Nhóm biến thể theo màu
        $variantsGroupedByColor = $product->variants->groupBy('color_id');

        // Nhóm ảnh theo màu
        $imagesGroupedByColor = $product->images->groupBy('color_id');

        return view('admin.product.edit', compact('sizes', 'tagsCollectionEdit', 'tagsMaterialEdit', 'tagCollection', 'tagMaterial', 'product', 'variantsGroupedByColor', 'imagesGroupedByColor', 'brands', 'categories', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateMainProduct(UpdateMainProductRequest $request, string $id)
    {
        // Tìm sản phẩm theo ID
        $product = Product::findOrFail($id);

        // Cập nhật thông tin sản phẩm
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->status = $request->status;
        $product->slug = $request->slug;
        $product->sku = $request->product_code;
        $product->brand_id = $request->brand_id;
        $product->description = $this->processDescription($request->description);

        // Lưu sản phẩm
        $product->save();

        // Cập nhật tag và categories (nếu cần)
        $this->syncTags($product, $request->tagCollection, 'collection');
        $this->syncTags($product, $request->tagMaterial, 'material');
        $product->categories()->sync($request->categories);

        // Chuyển hướng hoặc trả về thông báo thành công
        return redirect()->route('admin.product.edit', $id)->with('success', 'Product updated successfully.');
    }
    public function updateVariantProduct(UpdateVariantProductRequest $request, string $id)
    {
        // Duyệt qua tất cả các variant_id trong mảng stock_update
        foreach ($request->input('variant')["'stock_update'"] as $variantId => $stock_update) {
            // Lấy giá trị price_update tương ứng với variantId
            $price_update = $request->input('variant')["'price_update'"][$variantId];

            // Tìm variant theo variantId
            $variant = ProductVariant::find($variantId);

            if ($variant) {
                // Cập nhật stock_quantity và price
                $variant->stock_quantity = $stock_update;
                $variant->price = $price_update;
                $variant->save();
            }
        }

        // Trả về trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Cập nhật thành công!');

    }


    public function createVariantProduct(CreateVariantProductRequest $request)
    {
        // Lấy các dữ liệu từ form
        $product_id = $request->input('product_id');
        $sizes = $request->input('sizes');
        $price = $request->input('price');
        $stock = $request->input('stock');
        $sku = $request->input('product_code');
        $images['images'][$request->input('colorVatiant')] = $request->file('imagesVatiant');
        // Lưu các biến thể sản phẩm vào bảng `product_variants`
        foreach ($sizes as $size) {
            $product_variant = new ProductVariant();
            $product_variant->product_id = $product_id;
            $product_variant->color_id = $request->input('colorVatiant');
            $product_variant->size_id = $size;
            $product_variant->price = $price[$size] ?? 0;
            $product_variant->stock_quantity = $stock[$size] ?? 0;
            $product_variant->product_code = $this->generateProductCode($sku, $request->input('colorVatiant'), $size);
            $product_variant->save();

            $this->storeProductImages($product_id, $images['images']);

        }

        return redirect()->back()->with('success', 'Sản phẩm đã được lưu thành công.');
    }
    // Hàm tạo mã sản phẩm dựa trên mã sản phẩm chung và tên màu, tên kích thước
    private function generateProductCode($sku, $color_id, $size_id)
    {
        // Lấy thông tin tên màu và kích thước từ bảng `colors` và `sizes`
        $colorName = Color::find($color_id)->name;  // Lấy tên màu từ bảng `colors`
        $sizeName = Size::find($size_id)->name;     // Lấy tên kích thước từ bảng `sizes`

        // Chuyển tên màu và tên kích thước thành chữ hoa
        $colorName = strtoupper($colorName);
        $sizeName = strtoupper($sizeName);

        // Tạo mã sản phẩm theo cấu trúc: product_code-COLOR_NAME-SIZE_NAME
        return $sku . '-' . $colorName . '-' . $sizeName;
    }

    public function createVariantColorProduct(Request $request)
    {
        // Lấy các dữ liệu từ form
        $product_id = $request->input('product_id');
        $color_id = $request->input('color_id');
        $sizes = $request->input('sizes');
        $price = $request->input('pricevariantcolor');
        $stock = $request->input('quantityvariantcolor');
        $sku = $request->input('product_code');

        // Lưu các biến thể sản phẩm vào bảng `product_variants`

        $product_variant = new ProductVariant();
        $product_variant->product_id = $product_id;
        $product_variant->color_id = $color_id;
        $product_variant->size_id = $sizes;
        $product_variant->price = $price ?? 0;
        $product_variant->stock_quantity = $stock ?? 0;
        $product_variant->product_code = $this->generateProductCode($sku, $color_id, $sizes);
        $product_variant->save();

        return redirect()->back()->with('success', 'Sản phẩm đã được lưu thành công.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroyVariant(Request $request, string $id)
    {

        if ($request->has('product_id')) {

            // Tìm tất cả các biến thể có `product_id` và `color_id` tương ứng
            $variants = ProductVariant::where('product_id', $request->input('product_id'))
                ->where('color_id', $id)
                ->get();

            if ($variants->isEmpty()) {
                return redirect()->back()->with('error', 'Không có biến thể nào với màu này trong sản phẩm được chọn.');
            }

            // Xóa mềm tất cả các biến thể tìm thấy
            foreach ($variants as $variant) {
                $variant->delete();
            }

            return redirect()->back()->with('success', 'Đã xóa mềm tất cả các biến thể có màu này cho sản phẩm thành công.');
        } else {
            $variant = ProductVariant::find($id);

            if ($variant) {
                $variant->delete(); // Xóa mềm biến thể
                return redirect()->back()->with('success', 'Đã xóa mềm biến thể thành công.');
            }

            return redirect()->back()->with('error', 'Biến thể không tồn tại.');
        }




    }

    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            // Tìm sản phẩm theo ID
            $product = Product::findOrFail($id);

            // Xóa mềm tất cả các biến thể của sản phẩm này
            $product->variants()->update(['deleted_at' => now()]);

            // Xóa mềm sản phẩm
            $product->delete();
        });

        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm và các biến thể liên quan đã được xóa mềm thành công.');

    }

}
