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
        $searchSize = $request->input('searchSize');
        
        $sizes = Size::when($searchSize, function ($query, $searchSize) {
            return $query->where('name', 'like', '%' . $searchSize . '%');
        })->paginate(5); // Phân trang với 10 bản ghi mỗi trang
    
        $searchColor = $request->input('searchColor');
        
        $colors = Color::when($searchColor, function ($query, $searchColor) {
            return $query->where('name', 'like', '%' . $searchColor . '%');
        })->paginate(5); // Phân trang với 10 bản ghi mỗi trang
        // Truyền cả $colors và $sizes vào view
        return view('admin.sizes.index', compact( 'sizes', 'colors'));
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
        // Lấy kích thước theo ID
        $size = Size::findOrFail($id);

        // Kiểm tra xem kích thước này có đang được sử dụng trong bất kỳ biến thể sản phẩm nào không
        if ($size->productVariants()->count() > 0) {
            // Nếu kích thước được sử dụng trong ít nhất 1 biến thể sản phẩm
            return redirect()->route('admin.colors_sizes.index')->with('error', 'Không thể xóa kích thước này vì nó đang được sử dụng trong nhiều sản phẩm. Bạn cần lí bên sản phẩm trước.');
        }

        // Nếu không có sản phẩm nào sử dụng kích thước này, tiến hành xóa
        $size->delete();

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được xóa thành công.');
    }

}
