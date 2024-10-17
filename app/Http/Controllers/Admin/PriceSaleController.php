<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceSale;
use Illuminate\Http\Request;

class PriceSaleController extends Controller
{
    public function index()
    {
        $prices = PriceSale::with('product')->get();
        return view('admin.prices.index', compact('prices'));
    }

    public function create()
    {
        // Đưa danh sách sản phẩm để chọn
        return view('admin.prices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sale_price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        PriceSale::create($request->all());

        return redirect()->route('prices.index')->with('success', 'Price sale created successfully.');
    }

    public function edit(PriceSale $priceSale)
    {
        return view('admin.prices.edit', compact('priceSale'));
    }

    public function update(Request $request, PriceSale $priceSale)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sale_price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $priceSale->update($request->all());

        return redirect()->route('prices.index')->with('success', 'Price sale updated successfully.');
    }
    
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $pricesales = PriceSale::where('sale_price', 'LIKE', "%{$searchTerm}%")
            ->orWhereHas('product', function($query) use ($searchTerm) {
                $query->where('product_name', 'LIKE', "%{$searchTerm}%");
            })
            ->paginate(10);

        return view('admin.prices.index', compact('prices'));
    }

    public function destroy(PriceSale $priceSale)
    {
        $priceSale->delete();
        return redirect()->route('prices.index')->with('success', 'Price sale deleted successfully.');
    }
}
