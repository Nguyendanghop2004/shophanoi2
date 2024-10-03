<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Slider;
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
            return view('client.home', compact('sliders'));
    }
}
