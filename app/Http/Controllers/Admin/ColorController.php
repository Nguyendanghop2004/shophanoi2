<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $colors = Color::when($request->input('searchColor'), function ($query, $searchColor) {
            return $query->where('name', 'like', '%' . $searchColor . '%');
        })->paginate(5);

        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(ColorRequest $request)
    {
        Color::create($request->validated());

        return redirect()->route('admin.colors.index')->with('success', 'Màu sắc đã được tạo thành công.');
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);

        return view('admin.colors.edit', compact('color'));
    }

    public function update(ColorRequest $request, $id)
    {
        $color = Color::findOrFail($id);

        if ($color->productVariants()->count() > 0) {
            return redirect()->route('admin.colors.index')->with('error', 'Không thể sửa màu sắc này vì nó đang được sử dụng trong sản phẩm.');
        }

        $color->update($request->validated());

        return redirect()->route('admin.colors.index')->with('success', 'Màu sắc đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);

        // Kiểm tra nếu màu sắc này đang được sử dụng trong sản phẩm, không cho phép xóa
        if ($color->productVariants()->count() > 0) {
            return redirect()->route('admin.colors.index')->with('error', 'Không thể xóa màu sắc này vì nó đang được sử dụng trong nhiều sản phẩm. Bạn cần xử lý bên sản phẩm trước.');
        }

        // Xóa mềm thay vì xóa vĩnh viễn
        $color->delete();

        return redirect()->route('admin.colors.index')->with('success', 'Màu sắc đã được xóa thành công.');
    }
}
