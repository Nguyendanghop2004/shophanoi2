<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogClient;
use App\Models\Category;
use App\Models\ProductImage;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Storage;
use Str;

class BlogController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.blog.index', compact('categories'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->except('image');
        $data  = [
            'content' => $request->content,
            'title' => $request->title,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('public/images/blog', $request->file('image'));
        }
        $title = Str::slug($request->title, '-');
        $data['slug'] = $title;
        $data['unique'] = Auth::user()->name;
        BlogClient::create($data);
        return redirect()->route('admin.blog.show')->with('success', 'Thêm mới thành công');
    }

    public function edit(string $encryptedId)
    {
        try {
         
            $id = Crypt::decryptString($encryptedId);
    

            $categories = Category::all();
            $data = BlogClient::findOrFail($id);
    
            return view('admin.blog.edit', compact('data', 'categories'));
        } catch (DecryptException $e) {
          
            return redirect()->route('admin.error');
        }
    }
    public function update(Request $request, string $id)
    {
        $blog = BlogClient::findOrFail($id);
        $data = $request->except('image');
        $data  = [
            'content' => $request->content,
            'title' => $request->title,
        ];
      

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('public/images/blog', $request->file('image'));
        }
        $title = Str::slug($request->title, '-');
        $data['slug'] = $title ;
        $data['unique'] = Auth::user()->name;
        $img =  $blog->image;

        $blog->update($data);
        if ($img && Storage::exists($img) && $request->hasFile('image')) {
            Storage::delete($img);
        }
        return redirect()->route('admin.blog.show')->with('success', 'sửa thành công');
    }

    public function destroy(string $id)
    {
        $dataUser = BlogClient::findOrFail($id);
        $dataUser->delete();
        if ($dataUser->image && Storage::exists($dataUser->image)) {
            Storage::delete($dataUser->image);
        }
        return back()->with('success', 'Xóa thành công');
    }


    public function show(Request $request)
    {
        $data = BlogClient::query()->latest('id')->paginate(10);
        return view('admin.blog.blog', compact('data'));
    }
    public function activateBlog($id)
    {
        $user = BlogClient::findOrFail($id);
        $user->status = true;
        $user->save();

        return redirect()->back()->with('success', 'Bài viết đã được kích hoạt.');
    }
    public function deactivateBlog($id)
    {
        $user = BlogClient::findOrFail($id);
        $user->status = false;
        $user->save();

        return redirect()->back()->with('success', 'Bài viết đã bị vô hiệu hóa.');
    }
  
}
