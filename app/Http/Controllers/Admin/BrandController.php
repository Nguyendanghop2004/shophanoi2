<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
{
    $query = Brand::query();

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $brands = $query->paginate(10);
    return view('admin.brands.index', compact('brands'));
}


    public function create()
    {
        return view('admin.brands.create'); 
    }

    public function store(Request $request){
    $request->validate([
        'name' => 'required|unique:brands,name|max:255',
        'image_brand_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Xử lý upload ảnh
    if ($request->hasFile('image_brand_url')) {
        $image = $request->file('image_brand_url');
        $imagePath = $image->store('brands', 'public');
    }

    Brand::create([
        'name' => $request->name,
        'image_brand_url' => $imagePath,
    ]);

    return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
}


    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand')); 
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,' . $brand->id,
            'image_brand_url' => 'required|url',
        ]);

        $brand->update($request->all()); 

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete(); 
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }
}
