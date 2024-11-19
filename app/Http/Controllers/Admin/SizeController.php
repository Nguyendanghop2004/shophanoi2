<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Hiển thị danh sách kích thước.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $sizes = Size::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('admin.sizes.index', compact('sizes', 'search'));
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
            'name' => 'required|string|max:255',
        ]);

        Size::create($request->only('name'));

        return redirect()->route('admin.sizes.index')->with('success', 'Size created successfully.');
    }

    /**
     * Hiển thị form chỉnh sửa kích thước.
     */
    public function edit($id)
    {
        $size = Size::findOrFail($id); // Tìm size theo ID

        return view('admin.sizes.edit', compact('size'));
    }

    /**
     * Cập nhật kích thước trong cơ sở dữ liệu.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $size = Size::findOrFail($id); // Tìm size theo ID

        $size->update($request->only('name'));

        return redirect()->route('admin.sizes.index')->with('success', 'Size updated successfully.');
    }

    /**
     * Xóa kích thước khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {
        $size = Size::findOrFail($id); // Tìm size theo ID

        $size->delete();

        return redirect()->route('admin.sizes.index')->with('success', 'Size deleted successfully.');
    }
}
