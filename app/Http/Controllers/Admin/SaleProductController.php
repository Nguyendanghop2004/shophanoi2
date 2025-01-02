<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSale;
use Illuminate\Http\Request;

class SaleProductController extends Controller
{/**
     * Hiển thị danh sách sản phẩm giảm giá.
     */
    public function index()
    {
        $sales = ProductSale::with('product')->paginate(10);

        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Hiển thị form tạo giảm giá.
     */
    public function create()
    {
        $products = Product::all();

        return view('admin.sales.create', compact('products'));
    }

    /**
     * Lưu giảm giá mới vào bảng product_sales.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        ProductSale::create($validated);

        return redirect()->route('admin.sales.index')->with('success', 'Tạo giảm giá thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa giảm giá.
     */
    public function edit($id)
    {
        $sale = ProductSale::findOrFail($id);
        $products = Product::all();

        return view('admin.sales.edit', compact('sale', 'products'));
    }

    /**
     * Cập nhật giảm giá.
     */
    public function update(Request $request, $id)
    {
        $sale = ProductSale::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $sale->update($validated);

        return redirect()->route('admin.sales.index')->with('success', 'Cập nhật giảm giá thành công!');
    }

    /**
     * Xóa giảm giá.
     */
    public function destroy($id)
    {
        $sale = ProductSale::findOrFail($id);
        $sale->delete();

        return redirect()->route('admin.sales.index')->with('success', 'Xóa giảm giá thành công!');
    }
}
