<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
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

        })->paginate(5); 

        $searchSize = $request->input('searchSize');
        
        $sizes = Size::when($searchSize, function ($query, $searchSize) {
            return $query->where('name', 'like', '%' . $searchSize . '%');

        })->paginate(5); 
        

        return view('admin.colors.index', compact('colors','sizes'));
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
        Color::create($request->only('name', 'sku_color'));
    
        return redirect()->route('admin.colors_sizes.index')->with('success', 'Màu sắc đã được tạo thành công.');
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
    
        // Kiểm tra từng trường, nếu không có thay đổi thì giữ dữ liệu cũ
        $name = $request->filled('name') ? $request->input('name') : $color->name;
        $sku_color = $request->filled('sku_color') ? $request->input('sku_color') : $color->sku_color;
    
        // Cập nhật nếu có thay đổi
        $color->update([
            'name' => $name,
            'sku_color' => $sku_color,
        ]);
    
        return redirect()->route('admin.colors.index')->with('success', 'Màu sắc đã được cập nhật thành công.');
    }
    
    

    /**
     * Xóa màu sắc khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
{

  
    $color = Color::findOrFail($id);

    
    if ($color->productVariants()->count() > 0) {
       
        return redirect()->route('admin.colors.index')->with('error', 'Không thể xóa màu sắc này vì nó đang được sử dụng trong nhiều sản phẩm. Bạn cần xử lí bên sản phẩm trước.');
    }

  

    $color->delete();

    return redirect()->route('admin.colors.index')->with('success', 'Màu sắc đã được xóa thành công.');
}

}
