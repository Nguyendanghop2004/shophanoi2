<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::all();
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|string',
            'color' => 'required|string',
            'sale_price' => 'nullable|numeric',
        ]);

        Attribute::create($request->all());

        return redirect()->route('attributes.index')->with('success', 'Attribute added successfully.');
    }
    public function edit(Attribute $attribute)
    {
        $products = Product::all();
        return view('attributes.edit', compact('attribute', 'products'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'color' => 'required|string',
            'sale_price' => 'nullable|numeric',
        ]);

        $attribute->update($request->all());
        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully.');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('attributes.index')->with('success', 'Attribute deleted successfully.');
    }
}
