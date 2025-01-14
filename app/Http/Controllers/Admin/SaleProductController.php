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
    public function index(Request $request)
    {
        $search = $request->input('search');

        $sales = ProductSale::with('product')
            ->when($search, function ($query) use ($search) {
                // Tìm kiếm theo tên sản phẩm trong bảng `products`
                $query->whereHas('product', function ($productQuery) use ($search) {
                    $productQuery->where('product_name', 'like', "%{$search}%");
                });
            })
            ->paginate(10);

        return view('admin.sales.index', compact('sales'));
    }


    /**
     * Hiển thị form tạo giảm giá.
     */
    public function create()
    {
        // Lấy danh sách các product_id đã tồn tại trong bảng product_sales
        $salesProductIds = ProductSale::pluck('product_id')->toArray();

        // Lọc danh sách sản phẩm chưa tồn tại trong bảng product_sales
        $products = Product::whereNotIn('id', $salesProductIds)->get();

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
            'discount_value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percent' && $value > 80) {
                        $fail('Giảm giá theo phần trăm không được vượt quá 80%.');
                    }

                    if ($request->discount_type === 'fixed') {
                        $product = Product::find($request->product_id);
                        if ($product && $value > $product->price) {
                            $fail('Giảm giá cố định không được lớn hơn giá sản phẩm hiện tại (' . $product->price . ').');
                        }
                    }
                }
            ],
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ], [
            'product_id.required' => 'Bạn phải chọn sản phẩm.',
            'product_id.exists' => 'Sản phẩm bạn chọn không tồn tại.',
            'discount_type.required' => 'Bạn phải chọn loại giảm giá.',
            'discount_type.in' => 'Loại giảm giá không hợp lệ.',
            'discount_value.required' => 'Bạn phải nhập giá trị giảm.',
            'discount_value.numeric' => 'Giá trị giảm phải là số.',
            'discount_value.min' => 'Giá trị giảm không được nhỏ hơn 0.',
            'start_date.required' => 'Bạn phải nhập ngày bắt đầu.',
            'start_date.date' => 'Ngày bắt đầu không đúng định dạng.',
            'end_date.date' => 'Ngày kết thúc không đúng định dạng.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
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
        // Lấy danh sách các product_id đã tồn tại trong bảng product_sales
        $salesProductIds = ProductSale::pluck('product_id')->toArray();

        // Lọc danh sách sản phẩm chưa tồn tại trong bảng product_sales
        $products = Product::whereNotIn('id', $salesProductIds)->get();

        return view('admin.sales.edit', compact('sale', 'products'));
    }

    /**
     * Cập nhật giảm giá.
     */
    public function update(Request $request, $id)
    {
        $sale = ProductSale::findOrFail($id);

        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percent' && $value > 99) {
                        $fail('Giảm giá theo phần trăm không được vượt quá 99%.');
                    }

                    if ($request->discount_type === 'fixed') {
                        $product = Product::find($request->product_id);
                        if ($product && $value > $product->price) {
                            $fail('Giảm giá cố định không được lớn hơn giá sản phẩm hiện tại (' . $product->price . ').');
                        }
                    }
                },
            ],
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ], [
            'product_id.required' => 'Bạn phải chọn sản phẩm.',
            'product_id.exists' => 'Sản phẩm bạn chọn không tồn tại.',
            'discount_type.required' => 'Bạn phải chọn loại giảm giá.',
            'discount_type.in' => 'Loại giảm giá không hợp lệ.',
            'discount_value.required' => 'Bạn phải nhập giá trị giảm.',
            'discount_value.numeric' => 'Giá trị giảm phải là số.',
            'discount_value.min' => 'Giá trị giảm không được nhỏ hơn 0.',
            'start_date.required' => 'Bạn phải nhập ngày bắt đầu.',
            'start_date.date' => 'Ngày bắt đầu không đúng định dạng.',
            'end_date.date' => 'Ngày kết thúc không đúng định dạng.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);


        // Cập nhật giảm giá
        $sale->update($validated);

        // Điều hướng về trang danh sách giảm giá với thông báo thành công
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
