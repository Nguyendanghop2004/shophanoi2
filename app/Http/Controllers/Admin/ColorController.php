<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Hiển thị danh sách màu sắc.
     */
    public function index(Request $request)
    {
        $colors = Color::when($request->input('searchColor'), function ($query, $searchColor) {
            return $query->where('name', 'like', '%' . $searchColor . '%');
        })->paginate(5);

        return view('admin.colors.index', compact('colors'));
    }

    /**
     * Hiển thị form tạo màu mới.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Lưu màu sắc mới vào cơ sở dữ liệu.
     */
    public function store(ColorRequest $request)
    {
        Color::create($request->validated());

        return redirect()->route('admin.colors.index')->with('success', 'Màu sắc đã được tạo thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa màu sắc.
     */
    public function edit($id)
    {
        $color = Color::findOrFail($id);

        return view('admin.colors.edit', compact('color'));
    }

    /**
     * Cập nhật màu sắc trong cơ sở dữ liệu.
     */
    public function update(ColorRequest $request, $id)
    {
        $color = Color::findOrFail($id);

        // Kiểm tra nếu màu sắc đang được sử dụng trong biến thể sản phẩm
        if ($color->productVariants()->count() > 0) {
            return redirect()->route('admin.colors.index')->with('error', 'Không thể sửa màu sắc này vì nó đang được sử dụng trong sản phẩm.');
        }

        $color->update($request->validated());

        return redirect()->route('admin.colors.index')->with('success', 'Màu sắc đã được cập nhật thành công.');
    }

    /**
     * Xóa màu sắc khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {
        $color = Color::findOrFail($id);

        // Kiểm tra nếu màu sắc đang được sử dụng trong sản phẩm
        if ($color->productVariants()->count() > 0) {
            return redirect()->route('admin.colors.index')->with('error', 'Không thể xóa màu sắc này vì nó đang được sử dụng trong nhiều sản phẩm. Bạn cần xử lí bên sản phẩm trước.');
        }

        $color->delete();

        return redirect()->route('admin.colors.index')->with('success', 'Màu sắc đã được xóa thành công.');
    }
}
