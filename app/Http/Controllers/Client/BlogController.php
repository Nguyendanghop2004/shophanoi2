<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BlogClient;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show()
    {
        $data = BlogClient::get();
        return view('client.blog.blog', compact('data'));
    }
    public function detail(string $id)
    {
      
        $data = BlogClient::query()->findOrFail($id );
        return view('client.blog.detail', compact('data'));
    }
}
