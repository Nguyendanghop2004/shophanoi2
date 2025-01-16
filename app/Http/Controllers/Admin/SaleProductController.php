<?php

namespace App\Http\Controllers\Admin;

use App\Events\SaleUpdated;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSale;
use Illuminate\Http\Request;
use Log;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class SaleProductController extends Controller
{
    public function index()
    {
        return view('admin.sales.index'); // Trả về view chính
    }

    /**
     * API cung cấp dữ liệu cho DataTables.
     */
    public function getSalesData()
    {
        try {
            $sales = ProductSale::with('product')->select('product_sales.*'); // Lấy dữ liệu từ bảng product_sales

            return DataTables::of($sales)
                ->addColumn('product_name', function ($sale) {
                    return $sale->product->product_name ?? 'Không xác định';
                })
                ->addColumn('discount_type', function ($sale) {
                    return $sale->discount_type === 'percent' ? 'Phần trăm' : 'Giá tiền';
                })
                ->addColumn('discount_value', function ($sale) {
                    return $sale->discount_type === 'percent'
                        ? $sale->discount_value . ' %'
                        : number_format($sale->discount_value, 0, ',', '.') . ' VNĐ';
                })
                ->addColumn('time_range', function ($sale) {
                    $start = $sale->start_date ? $sale->start_date->format('Y-m-d H:i:s') : 'Không xác định';
                    $end = $sale->end_date ? $sale->end_date->format('Y-m-d H:i:s') : 'Vô Hạn';
                    return "{$start} - {$end}";
                })
                ->addColumn('action', function ($sale) {
                    return '
                        <a href="' . route('admin.sales.edit', $sale->id) . '" class="btn btn-warning">Chỉnh sửa</a>
                        <form action="' . route('admin.sales.destroy', $sale->id) . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            // Ghi lỗi vào log Laravel
            \Log::error($e->getMessage());
            return response()->json([
                'error' => 'Đã xảy ra lỗi khi lấy dữ liệu!'
            ], 500);
        }
    }
    public function create()
    {
        // Lấy danh sách các product_id đã tồn tại trong bảng product_sales
        $salesProductIds = ProductSale::pluck('product_id')->toArray();

        // Lọc danh sách sản phẩm chưa tồn tại trong bảng product_sales
        $products = Product::whereNotIn('id', $salesProductIds)->get();

        return view('admin.sales.create', compact('products'));
    }
    /**
     * Xử lý tạo sản phẩm giảm giá.
     */
    public function store(Request $request)
    {
        // Bước 1: Validate cơ bản
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
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
    
        // Bước 2: Xử lý logic bổ sung
        $product = Product::find($request->product_id);
    
        $validator->after(function ($validator) use ($request, $product) {
            if ($request->discount_type === 'percent' && $request->discount_value > 60) {
                $validator->errors()->add('discount_value', 'Giảm giá theo phần trăm không được vượt quá 60%.');
            }
    
            if ($request->discount_type === 'fixed' && $product && $request->discount_value > ($product->price * 0.6)) {
                $validator->errors()->add('discount_value', 'Giảm giá không được vượt quá 60% giá của sản phẩm.');
            }
        });
    
        // Nếu có lỗi, trả về kèm dữ liệu lỗi và giữ lại giá trị form
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Bước 3: Lưu giảm giá
        $validated = $validator->validated();
        $sale = ProductSale::create($validated);
    
        // Phát sự kiện
        event(new SaleUpdated($sale->load('product'), 'create'));
    
        // Bước 4: Trả về với thông báo thành công
        return redirect()->route('admin.sales.index')->with('success', 'Tạo mã giảm giá thành công!');
    }


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
     * Xử lý cập nhật sản phẩm giảm giá.
     */

    public function update(Request $request, $id)
    {
        // Bước 1: Lấy bản ghi cần cập nhật
        $sale = ProductSale::findOrFail($id);
    
        // Bước 2: Validate cơ bản
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
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
    
        // Bước 3: Xử lý logic bổ sung
        $product = Product::find($request->product_id);
    
        $validator->after(function ($validator) use ($request, $product) {
            if ($request->discount_type === 'percent' && $request->discount_value > 60) {
                $validator->errors()->add('discount_value', 'Giảm giá theo phần trăm không được vượt quá 60%.');
            }
    
            if ($request->discount_type === 'fixed' && $product && $request->discount_value > ($product->price * 0.6)) {
                $validator->errors()->add('discount_value', 'Giảm giá không được vượt quá 60% giá của sản phẩm.');
            }
        });
    
        // Nếu có lỗi, trả về kèm dữ liệu lỗi và giữ lại giá trị form
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Bước 4: Cập nhật giảm giá
        $validated = $validator->validated();
        $sale->update($validated);
    
        // Phát sự kiện
        event(new SaleUpdated($sale->load('product'), 'update'));
    
        // Bước 5: Trả về với thông báo thành công
        return redirect()->route('admin.sales.index')->with('success', 'Cập nhật giảm giá thành công!');
    }
    
    /**
     * Xử lý xóa sản phẩm giảm giá.
     */
    public function destroy($id)
    {
        $sale = ProductSale::findOrFail($id);
        $sale->delete();

        event(new SaleUpdated($sale->id, 'delete'));
        return redirect()->route('admin.sales.index')->with('success', 'Xóa giảm giá thành công!');
    }
}
