<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;

class TagController extends Controller
{
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
        $validatedData = $this->validateTag($request);

        $validatedData['background_image'] = $this->handleImageUpload($request);

        Tag::create($validatedData);

        return redirect()->route('admin.tags.index')->with('success', 'Tag được tạo thành công.');
    }

    public function edit($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return redirect()->route('admin.tags.index')->with('error', 'Tag không tồn tại.');
        }

        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return redirect()->route('admin.tags.index')->with('error', 'Tag không tồn tại.');
        }

        $validatedData = $this->validateTag($request, $tag);

        if ($request->hasFile('background_image')) {
            $this->deleteOldImage($tag->background_image);
            $validatedData['background_image'] = $this->handleImageUpload($request);
        }

        $tag->update($validatedData);

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được cập nhật.');
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);

        if ($tag) {
            $this->deleteOldImage($tag->background_image);
            
            $tag->delete();

            return redirect()->route('admin.tags.index')->with('success', 'Tag đã được xóa.');
        }

        return redirect()->route('admin.tags.index')->with('error', 'Tag không tồn tại.');
    }

    private function validateTag(Request $request, $tag = null)
    {
        return $request->validate([
            'name' => [
                'required',
                'max:255',
                'regex:/^[\pL\pN\s]+$/u',
                Rule::unique('tags')->where(function ($query) use ($request, $tag) {
                    return $query->where('type', $request->type)
                        ->when($tag, function ($query) use ($tag) {
                            return $query->where('id', '!=', $tag->id);
                        });
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
            'background_image.image' => 'Ảnh nền phải là hình ảnh.',
        ]);
    }

    private function handleImageUpload(Request $request)
    {
        if ($request->hasFile('background_image')) {
            return $request->file('background_image')->store('tags', 'public');
        }
        return null;
    }

    private function deleteOldImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
