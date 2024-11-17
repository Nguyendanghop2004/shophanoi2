<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductVariantController extends Controller
{
    public function index(Request $request)
    {
        $products = ProductVariant::with(['product', 'color', 'size'])->get();

        if ($request->has('search')) {
            $search = $request->input('search');
            $products = ProductVariant::with(['product', 'color', 'size'])
                ->whereHas('product', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orWhereHas('color', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orWhereHas('size', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->get();
        }

        return view('admin.variants.index', compact('products'));
    }

    public function create()
{
    $products = Product::all();
    $colors = Color::all();
    $sizes = Size::all();

    return view('admin.variants.create', compact('products', 'colors', 'sizes'));
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'product_code' => 'required|unique:product_variants',
            'stock_quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ProductVariant::create($request->all());
        return redirect()->route('variants.index')->with('success', 'Variant created successfully.');
    }

    public function edit(ProductVariant $variant)
    {
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.variants.edit', compact('variant', 'colors', 'sizes'));
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'product_code' => 'required|unique:product_variants,product_code,' . $variant->id,
            'stock_quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $variant->update($request->all());
        return redirect()->route('variants.index')->with('success', 'Variant updated successfully.');
    }

    public function destroy(ProductVariant $variant)
    {
        $variant->delete();
        return redirect()->route('variants.index')->with('success', 'Variant deleted successfully.');
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $variants = ProductVariant::with(['product', 'color', 'size'])
            ->where('product_code', 'LIKE', "%{$searchTerm}%")
            ->orWhereHas('product', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%");
            })
            ->orWhereHas('color', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%");
            })
            ->orWhereHas('size', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%");
            })
            ->paginate(10);

        return view('admin.variants.index', compact('variants'));
    }

}
