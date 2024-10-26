<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $promotions = Promotion::query()->latest('id')->paginate(perPage: 8);
        $search = $request->input('search');// Lấy từ khóa tìm kiếm từ input form

        // Tìm kiếm trong các trường 'title', 'description', và các trường khác nếu cần
        $promotions = Promotion::when($search, function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('discount_percentage', 'like', "%{$search}%");
        })->paginate(10); // Phân trang kết quả, mỗi trang 10 bản ghi
        return view('admin.promotion.index',compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promotion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description'=>'required|max:255',
            'discount_percentage'=>'required|max:255',
            'start_date'=>'required|max:255',
            'end_date'=>'required|max:255',
          
           
        ], [
            'title.required' => 'Title không được để trống.',
            'title.max' => 'Title không được vượt quá 255 ký tự.',
            'description.required' => 'Description không được để trống.',
            'description.max' => 'Description không được vượt quá 255 ký tự.',
            'discount_percentage.required' => 'Discount Percentage không được để trống.',
            'discount_percentage.max' => 'Discount Percentage không được vượt quá 255 ký tự.',
            'discount_percentage.unique' => 'Discount Percentage này đã tồn tại.',
            'start_date.required' => 'Start Date không được để trống.',
            'end_date.required' => 'End Date không được để trống.',
           
           
        ]);
        Promotion::query()->create($data);
        return redirect()->route('promotions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        return view('admin.promotion.edit',compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description'=>'required|max:255',
            'discount_percentage'=>'required|max:255',
            'start_date'=>'required|max:255',
            'end_date'=>'required|max:255',
          
           
        ], [
            'title.required' => 'Title không được để trống.',
            'title.max' => 'Title không được vượt quá 255 ký tự.',
            'description.required' => 'Description không được để trống.',
            'description.max' => 'Description không được vượt quá 255 ký tự.',
            'discount_percentage.required' => 'Discount Percentage không được để trống.',
            'discount_percentage.max' => 'Discount Percentage không được vượt quá 255 ký tự.',
            'discount_percentage.unique' => 'Discount Percentage này đã tồn tại.',
            'start_date.required' => 'Start Date không được để trống.',
            'end_date.required' => 'End Date không được để trống.',
           
           
        ]);
        
        $promotion->update($data);
         return redirect()->route('promotions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotions.index');
    }
}
