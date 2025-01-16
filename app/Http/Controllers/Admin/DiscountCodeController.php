<?php

namespace App\Http\Controllers\Admin;

use App\Events\DiscountCodeUpdated;
use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use DataTables;
use DB;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
    public function index()
    {
        return view('admin.discount_codes.index');
    }

    public function getDiscountCodesData(Request $request)
    {
        $discountCodes = DiscountCode::query();

        return DataTables::of($discountCodes)
            ->addColumn('discount_type', function ($discountCode) {
                return $discountCode->discount_type === 'percent' ? 'Phần trăm' : 'Cố định';
            })
            ->addColumn('discount_value', function ($discountCode) {
                if ($discountCode->discount_type === 'percent') {
                    return $discountCode->discount_value . '%';
                } else {
                    return number_format($discountCode->discount_value, 0, ',', '.') . ' VND';
                }
            })
            ->addColumn('start_date', function ($discountCode) {
                return $discountCode->start_date->format('d/m/Y H:i:s');
            })
            ->addColumn('end_date', function ($discountCode) {
                return $discountCode->end_date
                    ? $discountCode->end_date->format('d/m/Y H:i:s')
                    : 'Không giới hạn';
            })
            ->addColumn('status', function ($discountCode) {
                if ($discountCode->end_date && $discountCode->end_date->lt(now())) {
                    return '<span class="badge badge-danger">Hết hạn</span>';
                }
                return '<span class="badge badge-success">Còn hiệu lực</span>';
            })
            ->addColumn('usage_limit', function ($discountCode) {
                // Hiển thị dạng times_used / usage_limit
                $usageLimit = $discountCode->usage_limit ?? 'Không giới hạn';
                return "{$discountCode->times_used} / {$usageLimit}";
            })
            ->addColumn('action', function ($discountCode) {
                return '
                    <a href="' . route('admin.discount_codes.edit', $discountCode->id) . '" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="' . route('admin.discount_codes.destroy', $discountCode->id) . '" method="POST" style="display:inline-block;" onsubmit="return confirmDelete(event);">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        $users = \App\Models\User::all();
        $products = \App\Models\Product::all();
        $discountCodes = DiscountCode::all();
        return view('admin.discount_codes.create', compact('users', 'products', 'discountCodes'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:discount_codes',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ], [
            'code.required' => 'Bạn phải nhập mã giảm giá.',
            'code.unique' => 'Mã giảm giá đã tồn tại.',
            'discount_type.required' => 'Vui lòng chọn loại giảm giá.',
            'discount_type.in' => 'Loại giảm giá không hợp lệ.',
            'discount_value.required' => 'Vui lòng nhập giá trị giảm.',
            'discount_value.numeric' => 'Giá trị giảm phải là số.',
            'discount_value.min' => 'Giá trị giảm phải lớn hơn 0.',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        DB::transaction(function () use ($validated) {
            $discountCode = DiscountCode::create($validated);
            event(new DiscountCodeUpdated($discountCode, 'create'));
        });

        return redirect()->route('admin.discount_codes.index')->with('success', 'Mã giảm giá đã được tạo thành công.');
    }

    public function edit($id)
    {
        $discountCode = DiscountCode::with(['userLimits', 'products'])->findOrFail($id);
        $users = \App\Models\User::all();
        $products = \App\Models\Product::all();
        $discountCodes = DiscountCode::where('id', '!=', $id)->get();
        return view('admin.discount_codes.edit', compact('discountCode', 'users', 'products', 'discountCodes'));
    }

    public function update(Request $request, $id)
    {
        $discountCode = DiscountCode::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|unique:discount_codes,code,' . $id,
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ], [
            'code.required' => 'Bạn phải nhập mã giảm giá.',
            'code.unique' => 'Mã giảm giá đã tồn tại.',
            'discount_type.required' => 'Vui lòng chọn loại giảm giá.',
            'discount_type.in' => 'Loại giảm giá không hợp lệ.',
            'discount_value.required' => 'Vui lòng nhập giá trị giảm.',
            'discount_value.numeric' => 'Giá trị giảm phải là số.',
            'discount_value.min' => 'Giá trị giảm phải lớn hơn 0.',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        DB::transaction(function () use ($discountCode, $validated) {
            $discountCode->update($validated);
            event(new DiscountCodeUpdated($discountCode, 'update'));
        });

        return redirect()->route('admin.discount_codes.index')->with('success', 'Mã giảm giá đã được cập nhật.');
    }

    public function destroy($id)
    {
        $discountCode = DiscountCode::findOrFail($id);

        DB::transaction(function () use ($discountCode) {
            $discountCode->delete();
            event(new DiscountCodeUpdated($discountCode->id, 'delete'));
        });

        return redirect()->route('admin.discount_codes.index')->with('success', 'Mã giảm giá đã được xóa.');
    }
}
