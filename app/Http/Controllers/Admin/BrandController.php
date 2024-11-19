<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = 5;

        $brands = Brand::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate($perPage);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateBrand($request);

        $validatedData['image_brand_url'] = $this->handleImageUpload($request);

        Brand::create($validatedData);

        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu được tạo thành công.');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->route('admin.brands.index')->with('error', 'Thương hiệu không tồn tại.');
        }

        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->route('admin.brands.index')->with('error', 'Thương hiệu không tồn tại.');
        }

        $validatedData = $this->validateBrand($request, $brand);

        if ($request->hasFile('image_brand_url')) {
            $this->deleteOldImage($brand->image_brand_url);
            $validatedData['image_brand_url'] = $this->handleImageUpload($request);
        }

        $brand->update($validatedData);

        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu đã được cập nhật.');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if ($brand) {
            $this->deleteOldImage($brand->image_brand_url);
            $brand->delete();
            return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu đã được xóa.');
        }

        return redirect()->route('admin.brands.index')->with('error', 'Thương hiệu không tồn tại.');
    }

    private function validateBrand(Request $request, $brand = null)
    {
        return $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('brands')->ignore($brand?->id),
            ],
            'image_brand_url' => 'nullable|image',
        ], [
            'name.required' => 'Tên thương hiệu không được để trống.',
            'name.unique' => 'Tên thương hiệu đã tồn tại.',
            'name.max' => 'Tên thương hiệu không được vượt quá 255 ký tự.',
            'image_brand_url.image' => 'Ảnh thương hiệu phải là hình ảnh.',
        ]);
    }

    private function handleImageUpload(Request $request)
    {
        if ($request->hasFile('image_brand_url')) {
            return $request->file('image_brand_url')->store('brands', 'public');
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
