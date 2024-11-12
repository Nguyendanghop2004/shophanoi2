<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $colors = Color::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);

        return view('admin.colors.index', compact('colors', 'search'));
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Color::create($request->all());
        return redirect()->route('colors.index')->with('success', 'Color created successfully.');
    }

    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $color->update($request->all());
        return redirect()->route('colors.index')->with('success', 'Color updated successfully.');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('colors.index')->with('success', 'Color deleted successfully.');
    }
}
