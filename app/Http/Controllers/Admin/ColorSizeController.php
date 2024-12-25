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

     
        $searchColor = $request->query('searchColor');
        $searchSize = $request->query('searchSize');

      

        $colors = Color::when($searchColor, function ($query, $searchColor) {
            return $query->where('name', 'like', '%' . $searchColor . '%');
        })->paginate(5);


        $sizes = Size::when($searchSize, function ($query, $searchSize) {
            return $query->where('name', 'like', '%' . $searchSize . '%');
        })->paginate(5);


        return view('admin.colors_sizes.index', compact('colors', 'sizes', 'searchColor', 'searchSize'));
    }
}