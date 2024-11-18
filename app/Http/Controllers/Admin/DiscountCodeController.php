<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use App\Models\User;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
   
      public function index(Request $request)
      {
          $searchs = $request->input('code');
      
    
          if ($searchs) {
              $discountCodes = DiscountCode::where('code', 'like', '%' . $searchs . '%')
                                            ->paginate(10);
          } else {
              $discountCodes = DiscountCode::paginate(10);  
          }
      
      
      
          return view('admin.coupon.index', compact('discountCodes', 'searchs'));
      }
  

      public function create()
      {
   
          $users = User::all();
          return view('admin.coupon.create', compact('users'));
      }
  

      public function store(Request $request)
      {
      
            $request->validate([
                'code' => 'required|string|unique:discount_codes,code',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
                'user_ids' => 'required|array',
                'user_ids.*' => 'exists:users,id', 
            ]);
        
  
            $discountCode = DiscountCode::create([
                'code' => $request->code,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
        
       
            $discountCode->users()->attach($request->user_ids);
        
     
    
          return redirect()->route('admin.discount_codes.index')->with('success', 'Mã giảm giá đã được tạo thành công.');
      }
  
  
    
      public function edit($id)
      {
          $discountCode = DiscountCode::with('users')->findOrFail($id);
          $users = User::all();
          return view('admin.coupon.edit', compact('discountCode', 'users'));
      }
  
   
      public function update(Request $request, $id)
      {
          $request->validate([
              'code' => 'required|string|unique:discount_codes,code,' . $id,
              'discount_type' => 'required|in:percentage,fixed',
              'discount_value' => 'required|numeric',
              'start_date' => 'required|date',
              'end_date' => 'nullable|date',
              'user_ids' => 'required|array',
              'user_ids.*' => 'exists:users,id',
          ]);
      
          $discountCode = DiscountCode::findOrFail($id);
          $discountCode->update([
              'code' => $request->code,
              'discount_type' => $request->discount_type,
              'discount_value' => $request->discount_value,
              'start_date' => $request->start_date,
              'end_date' => $request->end_date,
          ]);
      
      
          $discountCode->users()->sync($request->user_ids);
      
          return redirect()->route('admin.discount_codes.index')->with('success', 'Mã giảm giá đã được cập nhật thành công.');
      }
  
 
      public function destroy($id)
      {
    
          $discountCode = DiscountCode::findOrFail($id);
          $discountCode->delete();
  
       
          return redirect()->route('admin.discount_codes.index')->with('success', 'Mã giảm giá đã được xóa.');
      }
}
