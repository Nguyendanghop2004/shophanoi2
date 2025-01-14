<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\CreateProductVariantColorRequest;
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
use Validator;

class ProductController extends Controller
{
    // okok
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with([
            'colors' => function ($query) {
                $query->select('colors.id', 'colors.name', 'colors.sku_color');
            },
            'variants',
            'tags' => function ($query) {
                $query->whereIn('type', ['collection', 'material']);
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
    // okok
    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->with([
                'children' => function ($query) {
                    $query->where('status', 1);
                }
            ])
            ->get();
        $brands = Brand::all();
        $colors = Color::all();
        $tagCollection = Tag::where('type', 'collection')->get();
        $tagMaterial = Tag::where('type', 'material')->get();
        return view('admin.product.create', compact('categories', 'brands', 'colors', 'tagCollection', 'tagMaterial'));
    }
    // okok
    public function getVariantCard($colorId)
    {
        $color = Color::find($colorId);
        $sizes = Size::all();

        return view('admin.product.variant-card', compact('color', 'sizes'));
    }
    // okok
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
            ]);

            $product->description = $this->processDescription($request->input('description'), $product->id);
            // Lưu sản phẩm
            $product->save();
            // Lưu tags cho tagCollection và tagMaterial
            $this->syncTags(
                $product,
                $request->input('tagCollection'),
                $request->input('tagMaterial')
            );


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
    // okok
    // Hàm xử lý lưu tag sản phẩm
    protected function syncTags($product, $tagCollection, $tagMaterial)
    {
        // Danh sách tag IDs cần đồng bộ
        $tagsToSync = [];

        // Lấy các tags của loại collection
        if (is_array($tagCollection) && !empty($tagCollection)) {
            $collectionTags = Tag::whereIn('id', $tagCollection)->where('type', 'collection')->pluck('id')->toArray();
            $tagsToSync = array_merge($tagsToSync, $collectionTags);
        }

        // Lấy các tags của loại material
        if (is_array($tagMaterial) && !empty($tagMaterial)) {
            $materialTags = Tag::whereIn('id', $tagMaterial)->where('type', 'material')->pluck('id')->toArray();
            $tagsToSync = array_merge($tagsToSync, $materialTags);
        }

        // Đồng bộ tất cả tags trong một lần
        if (!empty($tagsToSync)) {
            $product->tags()->sync($tagsToSync);
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

    // okok
    // Hàm xử lý lưu ảnh sản phẩm
    protected function storeProductImages($productId, $images)
    {
        if ($images) {
            foreach ($images as $colorId => $files) {
                foreach ($files as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('images/products', $filename, 'public');

                    ProductImage::create([
                        'product_id' => $productId,
                        'color_id' => $colorId,
                        'image_url' => $path,
                    ]);
                }
            }
        }
    }

    // okok
    private function processDescription($description, $productId)
    {
        if (empty(trim($description))) {
            // Nếu mô tả rỗng, chỉ xóa các ảnh có color_id = null (ảnh thuộc mô tả)
            ProductImage::where('product_id', $productId)
                ->whereNull('color_id') // Chỉ xóa ảnh mô tả
                ->get()
                ->each(function ($image) {
                    Storage::delete("public/" . $image->image_url); // Xóa file
                    $image->delete(); // Xóa bản ghi trong CSDL
                });
            return ''; // Trả về chuỗi rỗng
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Bỏ qua các lỗi HTML không hợp lệ
        $dom->loadHTML(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'));

        // Danh sách ảnh trong mô tả mới
        $newImages = [];

        foreach ($dom->getElementsByTagName('img') as $img) {
            /** @var \DOMElement $img */
            $src = $img->getAttribute('src');

            // Kiểm tra nếu ảnh được encode base64
            if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                $data = substr($src, strpos($src, ',') + 1);
                $data = base64_decode($data);

                // Tạo tên ảnh ngẫu nhiên
                $imageName = uniqid() . '.png';
                $filePath = "public/images/products/summernote/$imageName";
                Storage::put($filePath, $data);

                // Cập nhật đường dẫn của ảnh trong nội dung
                $img->setAttribute('src', asset("storage/images/products/summernote/$imageName"));

                // Lưu thông tin ảnh mới vào CSDL với color_id = null
                $imageUrl = "images/products/summernote/$imageName";
                ProductImage::create([
                    'product_id' => $productId,
                    'color_id' => null, // Đặt color_id = null để phân biệt ảnh mô tả
                    'image_url' => $imageUrl,
                ]);

                // Thêm vào danh sách ảnh mới
                $newImages[] = $imageUrl;
            } else {
                // Nếu ảnh đã tồn tại (không phải base64), thêm vào danh sách ảnh mới
                $existingPath = str_replace(asset('storage') . '/', '', $src); // Loại bỏ asset URL để lấy đường dẫn lưu trữ
                $newImages[] = $existingPath;
            }
        }

        // Lấy danh sách ảnh cũ từ CSDL (chỉ lấy ảnh mô tả với color_id = null)
        $oldImages = ProductImage::where('product_id', $productId)
            ->whereNull('color_id') // Chỉ lấy ảnh mô tả
            ->pluck('image_url')
            ->toArray();

        // Xóa các ảnh cũ không còn trong mô tả
        $imagesToDelete = array_diff($oldImages, $newImages);

        foreach ($imagesToDelete as $imagePath) {
            Storage::delete("public/" . $imagePath); // Xóa file khỏi storage
            ProductImage::where('product_id', $productId)
                ->where('image_url', $imagePath)
                ->whereNull('color_id') // Chỉ xóa ảnh mô tả
                ->delete();
        }

        // Chỉ lấy phần nội dung bên trong <body>
        $bodyContent = '';
        foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $child) {
            $bodyContent .= $dom->saveHTML($child);
        }

        return $bodyContent; // Trả về nội dung đã xử lý
    }

    // okok
    public function show(string $id)
    {
        $product = Product::with([
            'colors' => function ($query) {
                $query->select('colors.id', 'colors.name') // Sử dụng tên bảng để tránh mơ hồ
                    ->whereHas('variants'); // Lọc màu sắc có ít nhất một biến thể
            },
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'color_id', 'size_id', 'product_code', 'stock_quantity', 'price', 'status') // Đảm bảo không có xung đột cột
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

    // okok
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
                    ->whereHas('productvariants'); // Lọc màu sắc có ít nhất một biến thể
            },
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'color_id', 'size_id', 'product_code', 'status', 'price', 'stock_quantity') // Đảm bảo không có xung đột cột
                    ->with(['color:id,name', 'size:id,name']); // Chỉ lấy các trường cần thiết
            },
            'images' => function ($query) {
                $query->select('id', 'color_id', 'image_url', 'product_id'); // Chỉ lấy các trường cần thiết
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

    // okok
    public function updateMainProduct(UpdateMainProductRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            // Tìm sản phẩm theo ID
            $product = Product::findOrFail($id);

            // Cập nhật thông tin sản phẩm
            $product->product_name = $request->product_name;
            $product->price = $request->price;
            $product->status = $request->status;
            $product->slug = $request->slug;
            $product->sku = $request->product_code;
            $product->brand_id = $request->brand_id;
            $product->description = $this->processDescription($request->description, $id);

            // Lưu sản phẩm
            $product->save();

            // Cập nhật tag và categories
            $this->syncTags(
                $product,
                $request->tagCollection,
                $request->tagMaterial
            );

            $product->categories()->sync($request->categories);

            // Lấy tất cả biến thể sản phẩm
            $variants = ProductVariant::where('product_id', $product->id)->get();

            // Duyệt qua từng biến thể và cập nhật mã sản phẩm
            foreach ($variants as $variant) {
                $color_id = $variant->color_id;
                $size_id = $variant->size_id;

                // Tạo mã sản phẩm cho biến thể
                $productCode = $this->generateProductCode($product->sku, $color_id, $size_id);

                // Cập nhật mã sản phẩm cho biến thể
                $variant->product_code = $productCode;
                $variant->save(); // Lưu lại biến thể
            }

            // Commit transaction nếu mọi thứ thành công
            DB::commit();

            return redirect()->route('admin.product.edit', $id)->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi xảy ra
            DB::rollBack();

            return redirect()->route('admin.product.edit', $id)->withErrors('Error updating product: ' . $e->getMessage());
        }
    }
    //okok
    public function updateVariantProduct(UpdateVariantProductRequest $request, string $id)
    { // Bắt đầu DB Transaction



        DB::beginTransaction();

        try {
            // Duyệt qua tất cả các variant_id trong mảng stock_update
            foreach ($request->input('variant')["'stock_update'"] as $variantId => $stock_update) {
                if ($stock_update < 0 || $request->input("variant.price_update.$variantId") < 0) {
                    return redirect()->back()
                        ->withErrors("Số lượng hoặc giá không được nhỏ hơn 0 ")
                        ->with('active_tab', 'variantproduct')
                        ->with('colorIdUpdateVariantProduct', $id);
                }
                // Lấy giá trị price_update tương ứng với variantId
                $price_update = $request->input('variant')["'price_update'"][$variantId];

                // Tìm variant theo variantId
                $variant = ProductVariant::find($variantId);

                if ($variant) {
                    // Cập nhật stock_quantity và price
                    $variant->stock_quantity = $stock_update;
                    $variant->price = $price_update;
                    $variant->save();
                } else {
                    throw new \Exception("Không tìm thấy biến thể sản phẩm với ID: $variantId");
                }
            }

            // Commit transaction nếu mọi thứ thành công
            DB::commit();

            // Trả về trang trước với thông báo thành công
            return redirect()->back()->with('success', 'Cập nhật thành công!')->with('active_tab', 'variantproduct');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            // Trả về thông báo lỗi
            return redirect()->back()->withErrors('Đã xảy ra lỗi: ' . $e->getMessage());
        }


    }

    // okok
    public function createVariantProduct(CreateVariantProductRequest $request)
    {
        // Lấy dữ liệu từ form
        $product_id = $request->input('product_id');
        $sizes = $request->input('sizes');
        $price = $request->input('price');
        $stock = $request->input('stock');
        $sku = $request->input('product_code');
        $colorVariant = $request->input('colorVatiant');
        $uploadedFiles = $request->file('imagesVatiant');

        // Chuẩn bị hình ảnh theo cấu trúc
        $images = [];
        if ($uploadedFiles) {
            $images['images'][$colorVariant] = is_array($uploadedFiles) ? $uploadedFiles : [$uploadedFiles];
        }

        // Lấy danh sách kích thước từ database
        $sizesMap = Size::whereIn('id', $sizes)->pluck('name', 'id')->toArray(); // ['id' => 'name']

        DB::beginTransaction();

        try {
            foreach ($sizes as $sizeId) {
                if (!isset($sizesMap[$sizeId])) {
                    continue; // Bỏ qua nếu sizeId không tồn tại
                }

                $sizeName = $sizesMap[$sizeId];

                // Tạo biến thể sản phẩm
                $product_variant = new ProductVariant();
                $product_variant->product_id = $product_id;
                $product_variant->color_id = $colorVariant;
                $product_variant->size_id = $sizeId;
                $product_variant->price = $price[$sizeName] ?? 0; // Lấy giá theo size_id
                $product_variant->stock_quantity = $stock[$sizeName] ?? 0; // Lấy số lượng theo size_id
                $product_variant->product_code = $this->generateProductCode($sku, $colorVariant, $sizeId);
                $product_variant->save();
            }

            // Lưu hình ảnh sản phẩm
            $this->storeProductImages($product_id, $images['images']);

            DB::commit();

            return redirect()->back()->with('success', 'Sản phẩm đã được lưu thành công.')->with('active_tab', 'variantproduct');
        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác nếu có lỗi
            return redirect()->back()->withErrors('Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }
    // okok
    private function generateProductCode($sku, $color_id, $size_id)
    {
        // Lấy thông tin tên màu và kích thước từ cơ sở dữ liệu
        $color = Color::find($color_id);
        $size = Size::find($size_id);

        // Kiểm tra dữ liệu có tồn tại không
        $colorName = $color ? strtoupper($color->name) : 'UNKNOWN';
        $sizeName = $size ? strtoupper($size->name) : 'UNKNOWN';

        // Tạo mã sản phẩm với cấu trúc: SKU-COLOR_NAME-SIZE_NAME
        return "{$sku}-{$colorName}-{$sizeName}";
    }

    //okok
    public function createVariantColorProduct(CreateProductVariantColorRequest $request)
    {
        // Bắt đầu DB Transaction
        DB::beginTransaction();

        try {
            // Lấy các dữ liệu từ form
            $product_id = $request->input('product_id');
            $color_id = $request->input('color_id');
            $sizes = $request->input('sizes');
            $price = $request->input('pricevariantcolor');
            $stock = $request->input('quantityvariantcolor');
            $sku = $request->input('product_code');

            // Kiểm tra dữ liệu bắt buộc
            if (!$product_id || !$color_id || !$sizes) {
                throw new \Exception('Dữ liệu không hợp lệ. Vui lòng kiểm tra thông tin sản phẩm, màu sắc và kích thước.');
            }

            // Lưu biến thể sản phẩm vào bảng `product_variants`
            $product_variant = new ProductVariant();
            $product_variant->product_id = $product_id;
            $product_variant->color_id = $color_id;
            $product_variant->size_id = $sizes;
            $product_variant->price = $price ?? 0;
            $product_variant->stock_quantity = $stock ?? 0;
            $product_variant->product_code = $this->generateProductCode($sku, $color_id, $sizes);
            $product_variant->save();

            // Commit transaction nếu mọi thứ thành công
            DB::commit();

            return redirect()->back()->with('success', 'Biến thể của Sản phẩm đã được lưu thành công.')->with('active_tab', 'variantproduct');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            return redirect()->back()->withErrors('Đã xảy ra lỗi khi lưu sản phẩm: ' . $e->getMessage())->with('active_tab', 'variantproduct');
        }
    }
    //okok

    public function createVariantImageColorProduct(Request $request)
    {
        // Lấy dữ liệu đã được xác thực
        $productId = $request->input('product_id');
        $colorId = $request->input('color_id');
        $imageIds = $request->input('delete_images');
        // Tùy chỉnh thông báo lỗi tiếng Việt
        $messages = [
            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'product_code.required' => 'Mã sản phẩm không được để trống.',
            'color_id.required' => 'Mã màu không được để trống.',
            'color_id.exists' => 'Mã màu không hợp lệ.',
            'delete_images.array' => 'Danh sách hình ảnh cần xóa phải là mảng.',
            'delete_images.*.integer' => 'ID hình ảnh cần xóa phải là số nguyên.',
            'delete_images.*.exists' => 'Hình ảnh cần xóa không tồn tại.',
            'image_detail_color_' . $request->input('color_id') . '.array' => 'Danh sách hình ảnh phải là mảng.',
            'image_detail_color_' . $request->input('color_id') . '.*.file' => 'Mỗi tệp phải là một file hợp lệ.',
            'image_detail_color_' . $request->input('color_id') . '.*.mimes' => 'Tệp phải có định dạng jpg, jpeg, hoặc png.',
            'image_detail_color_' . $request->input('color_id') . '.*.max' => 'Dung lượng tệp không được vượt quá 2MB.',
        ];

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'product_code' => 'required|string',
            'color_id' => 'required|exists:colors,id',
            'delete_images' => 'array|nullable',
            'delete_images.*' => 'integer|exists:product_images,id',
            'image_detail_color_' . $request->input('color_id') => 'array|nullable',
            'image_detail_color_' . $request->input('color_id') . '.*' => 'file|mimes:jpg,jpeg,png|max:2048',
        ], $messages);

        // Kiểm tra lỗi xác thực
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('active_tab', 'variantproduct')->with('show_modal', 'createVariantImageColorProduct')->with('colorId', $colorId);
        }

        // Bắt đầu DB Transaction
        DB::beginTransaction();

        try {


            // Đếm số lượng ảnh hiện tại của sản phẩm
            $currentImages = ProductImage::where('product_id', $productId)
                ->where('color_id', $colorId)
                ->count();

            // Số lượng ảnh mới được upload
            $newImagesCount = $request->hasFile('image_detail_color_' . $colorId)
                ? count($request->file('image_detail_color_' . $colorId))
                : 0;

            // Kiểm tra nếu xóa ảnh sẽ để sản phẩm không còn ảnh nào
            if ($imageIds && ($currentImages - count($imageIds) + $newImagesCount) < 1) {
                return redirect()->back()->withErrors('Không thể xóa hết ảnh. Sản phẩm phải có ít nhất một ảnh.')->withInput()->with('active_tab', 'variantproduct')->with('show_modal', 'createVariantImageColorProduct')->with('colorId', $colorId);
            }

            // Xử lý xóa ảnh nếu có
            if ($imageIds) {
                $imagesToDelete = ProductImage::whereIn('id', $imageIds)->get();

                foreach ($imagesToDelete as $image) {
                    $imagePath = storage_path('app/public/' . $image->image_url);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $image->delete();
                }
            }

            // Xử lý upload ảnh mới nếu có
            if ($request->hasFile('image_detail_color_' . $colorId)) {
                $images = $request->file('image_detail_color_' . $colorId);

                $uploadPath = "images/products/{$colorId}/";

                foreach ($images as $image) {
                    $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs($uploadPath, $fileName, 'public');

                    ProductImage::create([
                        'product_id' => $productId,
                        'color_id' => $colorId,
                        'image_url' => $path,
                    ]);
                }
            }

            // Commit transaction nếu mọi thứ thành công
            DB::commit();

            return redirect()->back()->with('success', 'Cập nhật ảnh sản phẩm thành công.');
        } catch (\Exception $e) {
            // Rollback nếu có lỗi
            DB::rollBack();

            return redirect()->back()->withErrors('Đã xảy ra lỗi: ' . $e->getMessage())->with('active_tab', 'variantproduct');
        }
    }

    //okok
    public function destroyByColorAndProduct(Request $request)
    {
        $colorId = $request->color_id;
        $productId = $request->product_id;
    
        try {
            // Kiểm tra tổng số lượng biến thể của sản phẩm
            $totalVariants = ProductVariant::where('product_id', $productId)->count();
    
            if ($totalVariants <= 1) {
                return redirect()->back()->withErrors(['message' => 'Không thể xóa. Sản phẩm chỉ còn một biến thể.']);
            }
    
            // Lấy danh sách biến thể cần xóa
            $variants = ProductVariant::where('color_id', $colorId)
                ->where('product_id', $productId)
                ->get();
    
            if ($variants->isEmpty()) {
                return redirect()->back()->withErrors(['message' => 'Không tìm thấy biến thể nào phù hợp.']);
            }
    
            // Xóa mềm các ảnh liên quan trong bảng product_images
            ProductImage::where('color_id', $colorId)
                ->where('product_id', $productId)
                ->delete(); // Soft delete: không xóa vĩnh viễn, chỉ cập nhật deleted_at
    
            // Xóa các biến thể
            foreach ($variants as $variant) {
                $variant->product_code = $variant->product_code . '-DELETED-' . time();
                $variant->save();
                $variant->delete();
            }
    
            return redirect()->back()->with('success', 'Đã xóa tất cả biến thể và thực hiện xóa mềm ảnh liên quan thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }
    
        
    public function destroyVariant(string $id)
    {
        try {
            // Lấy biến thể cần xóa
            $variant = ProductVariant::findOrFail($id);

            // Kiểm tra tổng số lượng biến thể của sản phẩm
            $totalVariants = ProductVariant::where('product_id', $variant->product_id)->count();

            if ($totalVariants <= 1) {
                return response()->json(['success' => false, 'message' => 'Không thể xóa. Sản phẩm chỉ còn một biến thể.'], 400);
            }

            // Tạo mã mới để tránh lỗi unique
            $variant->product_code = $variant->product_code . '-DELETED-' . time();
            $variant->save();

            $variant->delete();

            return response()->json(['success' => true, 'message' => 'Biến thể đã được xóa thành công.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            // Tìm sản phẩm theo ID
            $product = Product::findOrFail($id);

            // Tạo mã SKU mới để tránh lỗi unique
            $newSku = $product->sku . '-DELETED-' . time();

            // Cập nhật mã SKU trước khi xóa
            $product->sku = $newSku;
            $product->save();

            // Xóa mềm tất cả các biến thể của sản phẩm này
            foreach ($product->variants as $variant) {
                // Tạo mã product_code mới cho biến thể
                $newProductCode = $variant->product_code . '-DELETED-' . time();

                // Cập nhật mã product_code trước khi xóa mềm
                $variant->product_code = $newProductCode;
                $variant->save();

                // Xóa mềm biến thể
                $variant->delete();
            }

            // Xóa mềm sản phẩm
            $product->delete();
        });

        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm và các biến thể liên quan đã được xóa mềm thành công.');
    }


}
