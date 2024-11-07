<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeUserRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AccoutUserController extends Controller
{
    public function activateUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = true;
        $user->save();

        return redirect()->back()->with('success', 'Tài khoản đã được kích hoạt.');
    }
    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = false;
        $user->save();

        return redirect()->back()->with('success', 'Tài khoản đã bị vô hiệu hóa.');
    }
    public function accountUser(User $user)
    {


        // $role = Role::create(['name' => 'admin']);
        // $role = Role::find(4);
        // $permission = Permission::find(1);
        // auth()->guard('admin')->user()->assignRole('admin');
        // $user->assignRole('Super Admin');
        $users = User::query()->latest('id')->paginate(5);
        return view(('admin.accountsUser.accountUser'), compact('users'));
    }
    public function create()
    {
        return view(('admin.accountsUser.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {

        $request->except('image');
        $data =
            [
                'name' => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ];
        if ($request->hasFile('image')) {
            $data['image']  =  Storage::put('public/images/admin', $request->file('image_path'));
        }
        User::create($data);
        return redirect()->route('admin.accountsUser.accountUser')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.accountsUser.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view(('admin.accountsUser.edit'), compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $dataUser = User::query()->findOrFail($id);
        $data = $request->except('image');
        $data = [
            'name' => $request->name,
            "email" => $request->email,
            "address" => $request->address,
            "phone_number" =>  $request->phone_number,
        ];
        if ($request->password == '') {
            $data['password'] = $dataUser->password;
        } else {
            // dd(21);
            $data['password'] =  Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('public/images/User', $request->file('image'));
        }
        $img =  $dataUser->image;
        $dataUser->update($data);

        if ($img &&  Storage::exists($img) && $request->hasFile('image')) {
            Storage::delete($img);
        }
        return back()->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataUser = User::query()->findOrFail($id);
        $dataUser->delete();
        if (Storage::exists($dataUser->image) && $dataUser->image) {
            Storage::delete($dataUser->image);
        }
        return back()->with('error', 'Xóa thành công');
    }
    public function change(string $id)
    {
        $dataUser = User::query()->findOrFail($id);

        return view('admin.accountsUser.change', compact('dataUser'));
    }
    public function changeUser(ChangeUserRequest $request)
    {
        try {
            Auth::user()->update([
                'password' => Hash::make($request->password),
            ]);
            return back()->with('success', 'Đổi mới thành công');
        } catch (\Throwable $th) {
            dd(404);
        }
    }
}
