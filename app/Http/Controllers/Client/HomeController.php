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
            $categories = Category::with(['children' => function ($query) {
                $query->where('status', 1); 
            }])->where('status', 1) 
            ->whereNull('parent_id')->get();
            return view('client.home', compact('sliders','categories'));
    }
    public function show($slug)
    {
        
        $slug = Category::where('slug', $slug)->first();

   
        if (!$slug) {
            return redirect()->route('home')->with('error', 'Bài viết không tồn tại.');
        }

      
        return view('client.home', compact('slug'));
    }
    

   
}
