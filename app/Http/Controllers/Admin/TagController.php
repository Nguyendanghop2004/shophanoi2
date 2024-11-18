<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;
use Str;

class TagController extends Controller
{
    // Trong TagController.php
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = 5;

        
        $tags = Tag::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate($perPage);

        return view('admin.tags.index', compact('tags'));
    }


    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'max:255',
                'regex:/^[\pL\pN\s]+$/u',
                Rule::unique('tags')->where(function ($query) use ($request) {
                    return $query->where('type', $request->type);
                }),
            ],
            'type' => 'required|string',
            'description' => 'nullable|string',
            'background_image' => 'nullable|image',
        ], [
            'name.required' => 'Tên tag không được để trống.',
            'name.unique' => 'Tên tag đã tồn tại trong loại tag.',
            'name.max' => 'Tên tag không được vượt quá 255 ký tự.',
            'name.regex' => 'Tên tag chỉ được chứa chữ cái, số và khoảng trắng.',
            'description.required' => 'Mô tả không được để trống.',
            'background_image.image' => 'Ảnh nền phải là hình ảnh.',
        ]);

        $backgroundImage = null;
        if ($request->hasFile('background_image')) {
            $backgroundImage = $request->file('background_image')->store('tags', 'public');
        }

        Tag::create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'background_image' => $backgroundImage,
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Tag được tạo thành công.');
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $request->validate([
            'name' => [
                'required',
                'max:255',
                'regex:/^[\pL\pN\s]+$/u',
                Rule::unique('tags')->where(function ($query) use ($request, $tag) {
                    return $query->where('type', $request->type)->where('id', '!=', $tag->id);
                }),
            ],
            'type' => 'required|string',
            'description' => 'nullable|string',
            'background_image' => 'nullable|image',
        ], [
            'name.required' => 'Tên tag không được để trống.',
            'name.unique' => 'Tên tag đã tồn tại trong loại tag.',
            'name.max' => 'Tên tag không được vượt quá 255 ký tự.',
            'name.regex' => 'Tên tag chỉ được chứa chữ cái, số và khoảng trắng.',
            'description.required' => 'Mô tả không được để trống.',
            'background_image.image' => 'Ảnh nền phải là hình ảnh.',
        ]);

        if ($request->hasFile('background_image')) {
            if ($tag->background_image) {
                Storage::disk('public')->delete($tag->background_image);
            }

            $backgroundImage = $request->file('background_image')->store('tags', 'public');
            $tag->background_image = $backgroundImage;
        }

        $tag->name = $request->name;
        $tag->type = $request->type;
        $tag->description = $request->description;
        $tag->save();

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được cập nhật.');
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);
        
        if ($tag) {
            $tag->delete();
            return redirect()->route('admin.tags.index')->with('success', 'Tag đã được xóa.');
        }

        return redirect()->route('admin.tags.index')->with('error', 'Tag không tồn tại.');
    }
}
