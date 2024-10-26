<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $news = News::query()->latest('id')->paginate(10);
        $search = $request->input('search');// Lấy từ khóa tìm kiếm từ input form

        // Tìm kiếm trong các trường 'title', 'description', và các trường khác nếu cần
        $news = News::when($search, function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%");
            //   ->orWhere('content', 'like', "%{$search}%");
              
        })->paginate(10); // Phân trang kết quả, mỗi trang 10 bản ghi

        // Trả dữ liệu về view cùng với từ khóa tìm kiếm (nếu có)
        
        return view('admin.news.index',compact('news','search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'content'=>'required|max:255',
            'image_path'=>'required|max:255',
            'published_at'=>'required|max:255',
            'category_id'=>'required|max:255',
            'product_id'=>'required|max:255',
          
           
           
        ], [
            'title.required' => 'Title không được để trống.',
            'title.max' => 'Title không được vượt quá 255 ký tự.',
            'content.required' => 'Content không được để trống.',
            'image_path.required' => 'Image không được để trống.',
            'published_at.required' => 'Published at không được để trống.',
            'category_id.required' => 'Category ID không được để trống.',
            'product_id.required' => 'Product ID không được để trống.',
           
           
        ]);
        $path_image_path =$request->file('image_path')->store('image');
        $data['image_path'] = $path_image_path;
        News::query()->create($data);
        return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit',compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        {
            $data = $request->validate([
                'title' => 'required|max:255',
                'content'=>'required|max:255',
                'image_path'=>'required|max:255',
                'published_at'=>'required|max:255',
                'category_id'=>'required|max:255',
                'product_id'=>'required|max:255',
              
               
               
            ], [
                'title.required' => 'Title không được để trống.',
                'title.max' => 'Title không được vượt quá 255 ký tự.',
                'content.required' => 'Content không được để trống.',
                'image_path.required' => 'Image không được để trống.',
                'published_at.required' => 'Published at không được để trống.',
                'category_id.required' => 'Category ID không được để trống.',
                'product_id.required' => 'Product ID không được để trống.',
               
               
            ]);
    
            $data['image_path']= $news->image_path;
        if($request->hasFile('image_path')){
            if(file_exists('storage/' . $news->image_path)){
                unlink('storage/' . $news->image_path);
            }
            $path_image_path =$request->file('image_path')->store('image');
            $data['image_path'] = $path_image_path;
        }
            $news->update($data);
            return redirect()->route('news.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index');
    }
}
