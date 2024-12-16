<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class ColorSizeController extends Controller
{
    /**
     * Hiển thị danh sách màu sắc và kích thước.
     */
    public function index(Request $request)
    {
        // Lấy giá trị tìm kiếm màu sắc và kích thước từ URL
        $searchColor = $request->query('searchColor');
        $searchSize = $request->query('searchSize');

        // Truy vấn và phân trang cho màu sắc
        $colors = Color::when($searchColor, function ($query, $searchColor) {
            return $query->where('name', 'like', '%' . $searchColor . '%');
        })->paginate(5);

        // Truy vấn và phân trang cho kích thước
        $sizes = Size::when($searchSize, function ($query, $searchSize) {
            return $query->where('name', 'like', '%' . $searchSize . '%');
        })->paginate(5);

        // Trả về view với dữ liệu màu sắc và kích thước
        return view('admin.colors_sizes.index', compact('colors', 'sizes', 'searchColor', 'searchSize'));
    }
}