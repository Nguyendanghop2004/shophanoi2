<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Hiển thị danh sách màu sắc.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $colors = Color::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('admin.colors.index', compact('colors', 'search'));
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Color::create($request->only('name', 'color'));

        return redirect()->route('admin.colors.index')->with('success', 'Color created successfully.');
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $color = Color::findOrFail($id);

        $color->update($request->only('name', 'color'));

        return redirect()->route('admin.colors.index')->with('success', 'Color updated successfully.');
    }

    /**
     * Xóa màu sắc khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {
        $color = Color::findOrFail($id);

        $color->delete();

        return redirect()->route('admin.colors.index')->with('success', 'Color deleted successfully.');
    }
}
