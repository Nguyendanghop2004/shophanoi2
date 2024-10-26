<?php

namespace App\Http\Controllers\Admin;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // $vouchers = Voucher::query()->latest('id')->paginate(perPage: 8);
        
    //     return view('voucher.index',compact('vouchers'));
    // }
    public function index(Request $request)
    {
        $search = $request->input('search');// Lấy từ khóa tìm kiếm từ input form

        // Tìm kiếm trong các trường 'title', 'description', và các trường khác nếu cần
        $vouchers = Voucher::when($search, function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('products_id', 'like', "%{$search}%");
        })->paginate(10); // Phân trang kết quả, mỗi trang 10 bản ghi

        // Trả dữ liệu về view cùng với từ khóa tìm kiếm (nếu có)
        return view('admin.vouchers.index', compact('vouchers', 'search'));

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
   
       
        $data = $request->validate([
            'title' => 'required|max:255',
            'description'=>'required|max:255',
            'vouchers'=>'required|max:255',
            'start_date'=>'required|max:255',
            'end_date'=>'required|max:255',
            'products_id'=>'required|max:255',
        ], [
            'title.required' => 'Title không được để trống.',
            'title.max' => 'Title không được vượt quá 255 ký tự.',
            'description.required' => 'Description không được để trống.',
            'description.max' => 'Description không được vượt quá 255 ký tự.',
            'vouchers.required' => 'Vouchers không được để trống.',
            'vouchers.max' => 'Vouchers không được vượt quá 255 ký tự.',
            'vouchers.unique' => 'Vouchers này đã tồn tại.',
            'start_date.required' => 'Start Date không được để trống.',
            'end_date.required' => 'End Date không được để trống.',
            'products_id.required' => 'ID không được để trống.',
           
        ]);
        Voucher::query()->create($data);
        return redirect()->route('vouchers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit',compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voucher $voucher)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description'=>'required|max:255',
            'vouchers'=>'required|max:255',
            'start_date'=>'required|max:255',
            'end_date'=>'required|max:255',
            'products_id'=>'required|max:255',
        ], [
            'title.required' => 'Title không được để trống.',
            'title.max' => 'Title không được vượt quá 255 ký tự.',
            'description.required' => 'Description không được để trống.',
            'description.max' => 'Description không được vượt quá 255 ký tự.',
            'vouchers.required' => 'Vouchers không được để trống.',
            'vouchers.max' => 'Vouchers không được vượt quá 255 ký tự.',
            'vouchers.unique' => 'Vouchers này đã tồn tại.',
            'start_date.required' => 'Start Date không được để trống.',
            'end_date.required' => 'End Date không được để trống.',
            'products_id.required' => 'ID không được để trống.',
           
        ]);
        
        $voucher->update($data);
        return redirect()->route('vouchers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('vouchers.index');
    }
}
