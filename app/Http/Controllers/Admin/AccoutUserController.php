<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeUserRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\City;
use App\Models\History;
use App\Models\Province;
use App\Models\Wards;
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

        return redirect()->back()->with('error', 'Tài khoản đã bị vô hiệu hóa.');
    }
    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->status = false;
        $user->save();

        return redirect()->back()->with('success', 'Tài khoản đã được kích hoạt.');
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
            "image" => $request->image,
        ];
     
        if ($request->hasFile('image')) {
            $data['image']  =  Storage::put('public/images/admin', $request->file('image'));
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
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $cities = City::orderBy('name_thanhpho', 'ASC')->get();
        $provinces = Province::where('matp', $user->city_id)->orderBy('name_quanhuyen', 'ASC')->get();
        $wards = Wards::where('maqh', $user->province_id)->orderBy('name_xaphuong', 'ASC')->get();


        return view('admin.accountsUser.edit', compact('user', 'cities', 'provinces', 'wards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $dataUser = User::findOrFail($id);


        $data = $request->only('name', 'email', 'phone_number', 'address', 'city_id', 'province_id', 'wards_id');


        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password'] = $dataUser->password;
        }



       
        if ($request->hasFile('image')) {
           
            if ($dataUser->image && Storage::exists($dataUser->image)) {
                Storage::delete($dataUser->image);
            }
         
            $data['image'] = Storage::put('public/images/User', $request->file('image'));
        }


        
        $dataUser->update($data);
        History::create([
            'user_id' => auth()->id(), 
            'action' => 'update', 
            'model_type' => 'User', 
            'model_id' => $dataUser->id, 
            'changes' => array_diff($dataUser->getAttributes(), $data),
        ]);
    



       
        $dataUser->update($data);
 
        return redirect()->route('admin.accountsUser.accountUser')->with('success', 'Cập nhật thành công!');
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
    public function changeUser(ChangeUserRequest $request, string $id)
    {

        $user = User::findOrFail($id);
        $data = [
            'password' => Hash::make($request->password),
        ];
        $user->update($data);
        return back()->with('success', 'Đổi mới thành công',);
    }

    public function select_address(Request $request)
    {
        $data = $request->all();

        if (isset($data['action'])) {
            $output = '';

            if ($data['action'] == "city") {
                $select_province = Province::where('matp', $data['ma_id'])->orderBy('maqh', 'ASC')->get();
                $output .= '<option>--Chọn Quận Huyện---</option>';
                foreach ($select_province as $province) {
                    $output .= '<option value="' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
                }
            } else {
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderBy('xaid', 'ASC')->get();
                $output .= '<option>--Chọn Xã Phường---</option>';
                foreach ($select_wards as $ward) {
                    $output .= '<option value="' . $ward->xaid . '">' . $ward->name_xaphuong . '</option>';
                }
            }
            echo $output;
        }
    }
    
}
