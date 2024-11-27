<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\ChangeUserRequest;
use App\Models\Admin;
use Auth;
use Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(string $id)
    {
        $dataAdmin = Admin::query()->findOrFail($id);
        return view('admin.profile.index', compact('dataAdmin'));
    }
    public function changePassword(string $id)
    {
        $dataAdmin = Admin::query()->findOrFail($id);

        return view('admin.profile.change', compact('dataAdmin'));
    }
    public function change(ChangePasswordRequest $request, string $id)
    {
        if (Hash::check($request->old_password, Auth::user()->password)) {
            Auth::user()->update([
                'password' => Hash::make($request->password),
            ]);
            return back()->with('success', 'Đổi mật khẩu thành công');
        } else {
            return back()->with('error', 'Mật khẩu không trùng khớp');
        }
    }
 
}
