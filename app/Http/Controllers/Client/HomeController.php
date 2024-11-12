<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Category;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home($category_id = 1)
    {
        $sliders = Slider::with('category')
            ->where('category_id', $category_id)
            ->where('is_active', true)
            ->orderBy('position', 'asc')
            ->get();
            $categories = Category::with(relations: ['children' => function ($query) {
                $query->where('status', 1); 
            }])->where('status', 1) 
            ->whereNull('parent_id')->get();
            return view('client.home', compact('sliders','categories'));
    }
    public function show($slug)
    {
        
        $category = Category::where('slug', $slug)->where('status',1 )->first();
        if (!$category) {
            return redirect()->route('home')->with('error', 'Danh mục không tồn tại hoặc đã bị ẩn.');
        }

      
        return view('client.home', compact('slug'));
    }
   

   
}
