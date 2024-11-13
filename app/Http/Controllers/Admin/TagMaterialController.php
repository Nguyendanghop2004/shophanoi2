<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TagMaterial;
use Illuminate\Http\Request;

class TagMaterialController extends Controller
{
    // Hiển thị danh sách tag materials với tìm kiếm
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $tagMaterials = TagMaterial::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->paginate(10);

        return view('admin.tag_materials.index', compact('tagMaterials', 'search'));
    }

    // Form tạo mới tag material
    public function create()
    {
        return view('admin.tag_materials.create');
    }

    // Lưu tag material mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tag_materials,name',
        ]);

        TagMaterial::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('tag_materials.index')->with('success', 'Tag Material created successfully.');
    }

    // Form sửa tag material
    public function edit(TagMaterial $tagMaterial)
    {
        return view('admin.tag_materials.edit', compact('tagMaterial'));
    }

    // Cập nhật tag material
    public function update(Request $request, TagMaterial $tagMaterial)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tag_materials,name,' . $tagMaterial->id,
        ]);

        $tagMaterial->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('tag_materials.index')->with('success', 'Tag Material updated successfully.');
    }

    // Xóa tag material
    public function destroy(TagMaterial $tagMaterial)
    {
        $tagMaterial->delete();
        return redirect()->route('tag_materials.index')->with('success', 'Tag Material deleted successfully.');
    }
}
