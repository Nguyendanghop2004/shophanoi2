<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use DB;
use Illuminate\Http\Request;
use Str;

class DiscountCodeController extends Controller
{
    // 1. Hiển thị danh sách mã giảm giá
    public function index(Request $request)
    {
        $query = DiscountCode::query();

        // 7. Bộ lọc và tìm kiếm
        if ($request->has('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }
        if ($request->has('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }
        if ($request->has('status')) {
            $query->where(function ($q) use ($request) {
                if ($request->status == 'active') {
                    $q->where('start_date', '<=', now())->where('end_date', '>=', now());
                } elseif ($request->status == 'expired') {
                    $q->where('end_date', '<', now());
                }
            });
        }

        $discountCodes = $query->with([ 'userLimits', 'products'])->paginate(10);
        return view('admin.discount_codes.index', compact('discountCodes'));
    }

    // 2. Hiển thị form tạo mã giảm giá
    public function create()
    {
        $users = \App\Models\User::all();
        $products = \App\Models\Product::all();
        $discountCodes = DiscountCode::all();
        return view('admin.discount_codes.create', compact('users', 'products', 'discountCodes'));
    }

    // 3. Lưu mã giảm giá
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:discount_codes',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'usage_limit' => 'nullable|numeric',
            'user_ids' => 'array',
            'product_ids' => 'array',
        ], [
            'code.required' => 'Bạn phải nhập mã giảm giá.',
            'code.unique' => 'Mã giảm giá đã tồn tại.',
            'discount_type.required' => 'Vui lòng chọn loại giảm giá.',
            'discount_type.in' => 'Loại giảm giá chỉ được là percent hoặc fixed.',
            'discount_value.required' => 'Vui lòng nhập giá trị giảm giá.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là số.',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        // Kiểm tra giá trị giảm giá với giá sản phẩm nếu có sản phẩm được chỉ định
        if (!empty($request->product_ids)) {
            $products = \App\Models\Product::whereIn('id', $request->product_ids)->get();
            foreach ($products as $product) {
                if ($request->discount_type === 'fixed' && $request->discount_value > $product->price) {
                    return back()->withErrors([
                        'discount_value' => "Giá trị giảm giá không được lớn hơn giá sản phẩm '{$product->name}' ({$product->price} VNĐ).",
                    ]);
                }
            }
        }

        // Kiểm tra giá trị giảm giá phần trăm
        if ($request->discount_type === 'percent' && ($request->discount_value < 1 || $request->discount_value > 100)) {
            return back()->withErrors([
                'discount_value' => 'Giá trị giảm giá phần trăm phải nằm trong khoảng từ 1% đến 100%.',
            ]);
        }

        DB::transaction(function () use ($validated, $request) {
            $discountCode = DiscountCode::create($validated);

            // Gán người dùng
            if (!empty($request->user_ids)) {
                foreach ($request->user_ids as $userId) {
                    $discountCode->userLimits()->create([
                        'user_id' => $userId,
                        'usage_limit' => $request->usage_limit,
                    ]);
                }
            }

            // Gán sản phẩm
            if (!empty($request->product_ids)) {
                foreach ($request->product_ids as $productId) {
                    $discountCode->products()->create(['product_id' => $productId]);
                }
            }
         
        });

        return redirect()->route('admin.discount_codes.index')->with('success', 'Mã giảm giá đã được tạo.');
    }


    // 4. Hiển thị form chỉnh sửa mã giảm giá
    public function edit($id)
    {
        $discountCode = DiscountCode::with(['userLimits', 'products'])->findOrFail($id);
        $users = \App\Models\User::all();
        $products = \App\Models\Product::all();
        $discountCodes = DiscountCode::where('id', '!=', $id)->get();
        return view('admin.discount_codes.edit', compact('discountCode', 'users', 'products', 'discountCodes'));
    }

    // 5. Cập nhật mã giảm giá
    public function update(Request $request, $id)
    {
        $discountCode = DiscountCode::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|unique:discount_codes,code,' . $id,
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'usage_limit' => 'nullable|numeric',
            'user_ids' => 'array',
            'product_ids' => 'array',
        ], [
            'code.required' => 'Bạn phải nhập mã giảm giá.',
            'code.unique' => 'Mã giảm giá đã tồn tại.',
            'discount_type.required' => 'Vui lòng chọn loại giảm giá.',
            'discount_type.in' => 'Loại giảm giá chỉ được là percent hoặc fixed.',
            'discount_value.required' => 'Vui lòng nhập giá trị giảm giá.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là số.',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        // Kiểm tra giá trị giảm giá với giá sản phẩm nếu có sản phẩm được chỉ định
        if (!empty($request->product_ids)) {
            $products = \App\Models\Product::whereIn('id', $request->product_ids)->get();
            foreach ($products as $product) {
                if ($request->discount_type === 'fixed' && $request->discount_value > $product->price) {
                    return back()->withErrors([
                        'discount_value' => "Giá trị giảm giá không được lớn hơn giá sản phẩm '{$product->name}' ({$product->price} VNĐ).",
                    ]);
                }
            }
        }

        // Kiểm tra giá trị giảm giá phần trăm
        if ($request->discount_type === 'percent' && ($request->discount_value < 1 || $request->discount_value > 100)) {
            return back()->withErrors([
                'discount_value' => 'Giá trị giảm giá phần trăm phải nằm trong khoảng từ 1% đến 100%.',
            ]);
        }

        DB::transaction(function () use ($discountCode, $validated, $request) {
            $discountCode->update($validated);

            // Cập nhật người dùng
            $discountCode->userLimits()->delete();
            if (!empty($request->user_ids)) {
                foreach ($request->user_ids as $userId) {
                    $discountCode->userLimits()->create([
                        'user_id' => $userId,
                        'usage_limit' => $request->usage_limit,
                    ]);
                }
            }

            // Cập nhật sản phẩm
            $discountCode->products()->delete();
            if (!empty($request->product_ids)) {
                foreach ($request->product_ids as $productId) {
                    $discountCode->products()->create(['product_id' => $productId]);
                }
            }

           
        });

        return redirect()->route('admin.discount_codes.index')->with('success', 'Mã giảm giá đã được cập nhật.');
    }


    // 6. Xóa mã giảm giá
    public function destroy($id)
    {
        $discountCode = DiscountCode::findOrFail($id);
        $discountCode->delete();
        return redirect()->route('admin.discount_codes.index')->with('success', 'Mã giảm giá đã được xóa.');
    }


}