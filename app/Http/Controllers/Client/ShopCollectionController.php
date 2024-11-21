<?php 

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tag;

class ShopCollectionController extends Controller
{
    public function index()
    {
        $tags = Tag::whereNotNull('background_image')->get(); // Lấy tags có ảnh nền
        return view('client.shop-collection', compact('tags'));
    }
}
