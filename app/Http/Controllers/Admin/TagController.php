<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Storage;

class TagController extends Controller
{
    /**
     * Display a listing of tags.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $tags = Tag::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('admin.tags.index', compact('tags', 'search'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created tag in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255|unique:tags,name',
        'type' => 'required|string|max:50',
        'description' => 'nullable|string|max:500',
        'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('background_image')) {
        $data['background_image'] = $request->file('background_image')->store('background_images', 'public');
    }

    Tag::create($data);

    return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }


    public function edit(Tag $tag)
{
    return view('admin.tags.edit', compact('tag'));
}

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'type' => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('background_image')) {
            if ($tag->background_image) {
                Storage::disk('public')->delete($tag->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('background_images', 'public');
        }

        $tag->update($data);

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }
}
