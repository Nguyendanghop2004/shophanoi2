<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipper;
use Illuminate\Http\Request;

    class ShipperController extends Controller
{
    public function index()
    {
        $shippers = Shipper::paginate(10);
        return view('admin.shipper.index', compact('shippers'));
    }
    

    public function create()
    {
        return view('admin.shipper.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone' => 'required|numeric',
            'hometown' => 'required|string',
            'email' => 'required|email|unique:shippers,email',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Lưu hình ảnh vào thư mục 'public/images'
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('images', 'public');
        }

        Shipper::create([
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'hometown' => $request->hometown,
            'email' => $request->email,
            'profile_picture' => $profilePicturePath ? 'storage/' . $profilePicturePath : null,
        ]);

        return redirect()->route('shippers.index')->with('success', 'Thêm nhân viên giao hàng thành công!');
    }


    public function edit($id)
    {
        $shipper = Shipper::findOrFail($id);
        return view('admin.shipper.edit', compact('shipper'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'hometown' => 'required',
            'date_of_birth' => 'required|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $shipper = Shipper::findOrFail($id);

        // Update các thông tin shipper
        $shipper->name = $request->input('name');
        $shipper->email = $request->input('email');
        $shipper->phone = $request->input('phone');
        $shipper->hometown = $request->input('hometown');
        $shipper->date_of_birth = $request->input('date_of_birth');

        // Xử lý ảnh nếu có thay đổi
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('images', 'public');
            $shipper->profile_picture = 'storage/' . $profilePicturePath;
        }

        $shipper->save();

        return redirect()->route('shippers.index')->with('success', 'Cập nhật thông tin nhân viên giao hàng thành công!');
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $shippers = Shipper::where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%")
                            ->paginate(10);

        return view('admin.shipper.index', compact('shippers'));
    }


    public function destroy($id)
    {
        Shipper::destroy($id);
        return redirect()->route('shippers.index')->with('success', 'Xóa nhân viên giao hàng thành công!');
    }
}
