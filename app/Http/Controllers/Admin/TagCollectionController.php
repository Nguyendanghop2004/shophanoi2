<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TagCollection;
use Illuminate\Http\Request;

class TagCollectionController extends Controller
{
    // Hiển thị danh sách tag collections với tìm kiếm
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $tagCollections = TagCollection::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->paginate(10);

        return view('admin.tag_collections.index', compact('tagCollections', 'search'));
    }

    // Form tạo mới tag collection
    public function create()
    {
        return view('admin.tag_collections.create');
    }

    // Lưu tag collection mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tag_collections,name',
        ]);

        TagCollection::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('tag_collections.index')->with('success', 'Tag Collection created successfully.');
    }

    // Form sửa tag collection
    public function edit(TagCollection $tagCollection)
    {
        return view('admin.tag_collections.edit', compact('tagCollection'));
    }

    // Cập nhật tag collection
    public function update(Request $request, TagCollection $tagCollection)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tag_collections,name,' . $tagCollection->id,
        ]);

        $tagCollection->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('tag_collections.index')->with('success', 'Tag Collection updated successfully.');
    }

    // Xóa tag collection
    public function destroy(TagCollection $tagCollection)
    {
        $tagCollection->delete();
        return redirect()->route('tag_collections.index')->with('success', 'Tag Collection deleted successfully.');
    }
}
