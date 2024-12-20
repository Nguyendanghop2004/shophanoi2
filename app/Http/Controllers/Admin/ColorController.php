<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Hiển thị danh sách màu sắc.
     */
    public function index(Request $request)
    {
        $searchColor = $request->input('searchColor');
        
        $colors = Color::when($searchColor, function ($query, $searchColor) {
            return $query->where('name', 'like', '%' . $searchColor . '%');
        })->paginate(5); // Phân trang với 10 bản ghi mỗi trang
        $searchSize = $request->input('searchSize');
        
        $sizes = Size::when($searchSize, function ($query, $searchSize) {
            return $query->where('name', 'like', '%' . $searchSize . '%');
        })->paginate(5); // Phân trang với 10 bản ghi mỗi trang
        // Truyền $colors vào view
        return view('admin.colors_sizes.index', compact('colors','sizes'));
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
        // Thêm xác thực cho name và sku_color
        $request->validate([
            'name' => 'required|string|max:255',
            'sku_color' => 'required|string|max:255|unique:colors,sku_color',
        ]);

        // Lưu màu sắc mới vào cơ sở dữ liệu
        Color::create($request->only('name', 'sku_color'));

        return redirect()->route('admin.colors_sizes.index')->with('success', 'Color created successfully.');
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
    // Tìm màu sắc theo ID
    $color = Color::findOrFail($id);

    // Kiểm tra nếu màu sắc đang được sử dụng trong biến thể sản phẩm
    if ($color->productVariants()->count() > 0) {
        // Trả về thông báo lỗi nếu không thể sửa
        return redirect()->route('admin.colors_sizes.index')->with('error', 'Không thể sửa màu sắc này vì nó đang được sử dụng trong sản phẩm.');
    }

    // Nếu không bị ràng buộc, thực hiện cập nhật
    $request->validate([
        'name' => 'required|string|max:255',
        'sku_color' => 'required|string|max:255|unique:colors,sku_color,' . $id,
    ]);

    $color->update($request->only('name', 'sku_color'));

    return redirect()->route('admin.colors_sizes.index')->with('success', 'Color updated successfully.');
}



    /**
     * Xóa màu sắc khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
{
    // Lấy màu sắc theo ID
    $color = Color::findOrFail($id);

    // Kiểm tra xem màu sắc này có đang được sử dụng trong bất kỳ biến thể sản phẩm nào không
    if ($color->productVariants()->count() > 0) {
        // Nếu màu sắc được sử dụng trong ít nhất 1 biến thể sản phẩm
        return redirect()->route('admin.colors_sizes.index')->with('error', 'Không thể xóa màu sắc này vì nó đang được sử dụng trong nhiều sản phẩm. Bạn cần xử lí bên sản phẩm trước.');
    }

    // Nếu không có sản phẩm nào sử dụng màu này, tiến hành xóa
    $color->delete();

    return redirect()->route('admin.colors_sizes.index')->with('success', 'Màu sắc đã được xóa thành công.');
}

}
