<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Hiển thị danh sách kích thước.
     */
    public function index(Request $request)
    {
        $sizes = Size::when($request->input('searchSize'), function ($query, $searchSize) {
            return $query->where('name', 'like', '%' . $searchSize . '%');
        })->paginate(5);

        $colors = Color::when($request->input('searchColor'), function ($query, $searchColor) {
            return $query->where('name', 'like', '%' . $searchColor . '%');
        })->paginate(5);

        return view('admin.sizes.index', compact('sizes', 'colors'));
    }

    /**
     * Hiển thị form tạo kích thước mới.
     */
    public function create()
    {
        return view('admin.sizes.create');
    }

    /**
     * Lưu kích thước mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name',
        ], [
            'name.required' => 'Tên kích thước là bắt buộc.',
            'name.unique' => 'Tên kích thước đã tồn tại.',
        ]);

        Size::create($request->only('name'));

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được tạo thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa kích thước.
     */
    public function edit($id)
    {
        $size = Size::findOrFail($id);

        return view('admin.sizes.edit', compact('size'));
    }

    /**
     * Cập nhật kích thước trong cơ sở dữ liệu.
     */
    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        // Kiểm tra nếu kích thước đang được sử dụng trong biến thể sản phẩm
        if ($size->productVariants()->count() > 0) {
            return redirect()->route('admin.sizes.index')->with('error', 'Không thể sửa kích thước này vì nó đang được sử dụng trong sản phẩm.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name,' . $id,
        ], [
            'name.required' => 'Tên kích thước là bắt buộc.',
            'name.unique' => 'Tên kích thước đã tồn tại.',
        ]);

        $size->update($request->only('name'));

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được cập nhật thành công.');
    }

    /**
     * Xóa kích thước khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {
        $size = Size::findOrFail($id);

        if ($size->productVariants()->count() > 0) {
            return redirect()->route('admin.sizes.index')->with('error', 'Không thể xóa kích thước này vì nó đang được sử dụng trong nhiều sản phẩm. Bạn cần xử lý bên sản phẩm trước.');
        }

        $size->delete();

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được xóa thành công.');
    }
}
