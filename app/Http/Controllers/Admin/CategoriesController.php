<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;
use Str;

class CategoriesController extends Controller
{
    
    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $searchs = $request->input('name');
        
        $categories = Category::with('parent')
            ->when($searchs, function($query) use ($searchs) {
                return $query->where('name', 'like', '%' . $searchs . '%');
            })->paginate($perPage);
            
        $error = null;
        if ($searchs && $categories->isEmpty()) {
            $error = 'Không tìm thấy danh mục nào với tên: "' . $searchs . '"';
        }
    
        return view('admin.category.index', compact('categories', 'searchs', 'perPage', 'error'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.category.add', compact('categories'));
    }

  

    public function store(Request $request)
    {
      
        $request->validate([
            'name' => [
                'required',
                'max:255',
                'regex:/^[\pL\pN\s]+$/u',
                Rule::unique('categories')->where(function ($query) use ($request) {
                    return $query->where('parent_id', $request->parent_id);
                }),
            ],
            'slug' => 'nullable|unique:categories,slug',
            'description' => 'required',
            'image_path' => 'required|image',
            'parent_id' => 'nullable|exists:categories,id',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại trong danh mục cha.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'name.regex' => 'Tên danh mục chỉ được chứa chữ cái, số và khoảng trắng.',
            'slug.required' => 'Đường dẫn thân thiện không được để trống.',
            'slug.unique' => 'Đường dẫn thân thiện đã tồn tại.',
            'description.required' => 'Mô tả không được để trống.',
            'image_path.required' => 'Ảnh danh mục không được để trống.',
            'image_path.image' => 'File tải lên phải là ảnh.',
            'parent_id.exists' => 'Danh mục cha không tồn tại.',
        ]);
    
     
        $imagePath = $request->file('image_path')->store('categories', 'public');
    
       
        $slug = $request->input('slug') ?: Str::slug($request->input('name'));
    
     
        if ($request->parent_id) {
            $parentCategory = Category::find($request->parent_id);
            if ($parentCategory) {
              
                $slug = Str::slug($parentCategory->slug) . '/' . $slug;
            }
        }
    
    
        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'image_path' => $imagePath,
            'parent_id' => $request->parent_id,
        ]);
        return redirect()->route('categories.list')->with('success', 'Thêm mới thành công!');
    }


 
    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $newStatus = !$category->status;
        $category->status = $newStatus;
        $category->save();
        $this->updateChildCategoriesStatus($category, $newStatus);
        $message = $newStatus ? 'Danh mục và các danh mục con đã được kích hoạt.' : 'Danh mục và các danh mục con đã bị ẩn.';
        return redirect()->route('categories.list')->with('success', $message);
    }

    private function updateChildCategoriesStatus($category, $newStatus)
    {
    
        $children = Category::where('parent_id', $category->id)->get();

        foreach ($children as $child) {
            $child->status = $newStatus;
            $child->save();
            $this->updateChildCategoriesStatus($child, $newStatus);
        }
    }

 
    public function edit($id)
    {
        $categories = Category::findOrFail($id); 
        $categoryList = Category::all();
        return view('admin.category.edit', compact('categoryList', 'categories',));
    }

   
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => [
                'required',
                'unique:categories,name,' . $category->id, 
                'max:255',
                'regex:/^[\pL\pN\s]+$/u', 
            ],
            'slug' => 'required|unique:categories,slug,' . $category->id, 
            'description' => 'required',
            'image_path' => 'nullable|image',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|boolean', 
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'name.regex' => 'Tên danh mục chỉ được chứa chữ cái, số và khoảng trắng.',
            'slug.required' => 'Đường dẫn thân thiện không được để trống.',
            'slug.unique' => 'Đường dẫn thân thiện đã tồn tại.',
            'description.required' => 'Mô tả không được để trống.',
            'image_path.image' => 'File tải lên phải là ảnh.',
            'parent_id.exists' => 'Danh mục cha không tồn tại.',
            'status.required' => 'Trạng thái không được để trống.', 
        ]);
    
        if ($request->hasFile('image_path')) {
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path); 
            }
    
            $imagePath = $request->file('image_path')->store('categories', 'public');
            $category->image_path = $imagePath; 
        }
    
        
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->status = $request->status; 
        $category->save();
    
        return redirect()->route('categories.list')->with('success', 'Cập nhật danh mục thành công!');
    }
    public function destroy($id)
    {
        $category = Category::find($id);
        
        if ($category) {
            $category->delete(); 
            return redirect()->route('categories.list')->with('success', 'Danh mục đã được xóa.');
        }

        return redirect()->route('categories.list')->with('error', 'Danh mục không tồn tại.');
    }


   
    
}
