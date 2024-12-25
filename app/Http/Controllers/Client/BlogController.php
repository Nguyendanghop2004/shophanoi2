<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BlogClient;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show()
    {
        
        $data = BlogClient::where('status', 1)->get();
        
        return view('client.blog.blog', compact('data'));
    }
    public function detail(string $slug)
    {
        $data = BlogClient::where('slug', $slug)->where('status', 1)->firstOrFail();
        return view('client.blog.detail', compact('data'));
    }
}
