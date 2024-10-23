<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class AccoutAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Show the form for creating a new resource.
     */
 
    public function account(Admin $admin)
    {   


        // $role = Role::create(['name' => 'admin']);
        // $role = Role::find(4);
        // $permission = Permission::find(1);
        // auth()->guard('admin')->user()->assignRole('admin');
        // $user->assignRole('Super Admin');
        $admins = Admin::paginate(5);
        return view(('admin.accounts.account'),compact('admins'));
    }
    public function permissionAdmin(Admin $admin)
    {   


        // $role = Role::create(['name' => 'admin']);
        // $role = Role::find(4);
        // $permission = Permission::find(1);
        // auth()->guard('admin')->user()->assignRole('admin');
        // $user->assignRole('Super Admin');
        $admins = Admin::paginate(5);
        return view(('admin.permissions.index'),compact('admins'));
    }
    public function create()
    {   
        return view(('admin.accounts.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function phanvaitro($id)
    {
        $admin = Admin::find($id);
        $all_column_roles = $admin->roles->first();
        $permission = Permission::orderBy('id', 'DESC')->get();
        $role = Role::orderBy('id', 'DESC')->get();
        return view('admin.permissions.index', compact('user', 'role', 'all_column_roles', 'permission'));
    }
    public function phanquyen($id)
    {
        
        $admin = Admin::find($id);
        $permission = Permission::orderBy('id', 'DESC')->get();

        $name_roles = $admin->roles->first()->name;

        $get_permission_viaroles = $admin->getPermissionsViaRoles();
        // dd(  $get_permission_viaroles);
        return view('admin.permissions.phanquyen', compact('admin', 'name_roles', 'permission', 'get_permission_viaroles'));
    }
    public function insert_roles(Request $request, $id)
    {
        $data = $request->all();
        $admin = Admin::find($id);
    
        // Lấy role của người đang thực hiện yêu cầu
        $currentUser = auth()->user();
        $currentUserRole = $currentUser->roles->first();
    
        // Kiểm tra nếu người đang thực hiện có vai trò 'admin' và người được cấp quyền cũng có vai trò 'admin'
        if ($currentUserRole && $currentUserRole->name == 'admin' && $admin->hasRole('admin')) {
            return redirect()->back()->with('error', 'Không thể cấp vai trò cho tài khoản có cùng vai trò admin.');
        }
    
        $admin->syncRoles($data['role']);
        return redirect()->back()->with('thong bao', 'Thêm thành công');
    }
    
    public function insert_permission(Request $request, $id)
    {
        $data = $request->all();
        $admin = Admin::find($id);
        $role_id = $admin->roles->first()->id;
    
        // Lấy role của người đang thực hiện yêu cầu
        $currentAdmin = auth()->guard('admin');
        $currentAdminRole = $currentAdmin->roles->first();
    
        // Kiểm tra nếu người đang thực hiện có vai trò 'admin' và người được cấp quyền cũng có vai trò 'admin'
        if ($currentAdminRole && $currentAdminRole->name == 'admin' && $admin->hasRole('admin')) {
            return redirect()->back()->with('error', 'Không thể cấp quyền cho tài khoản có cùng vai trò admin.');
        }
    
        $role = Role::find($role_id);
        $role->syncPermissions($data['permission']);
    
        return redirect()->route('admin.users.index');
    }
    public function  insertPermission(Request $request)
    {
        $data = $request->all();
        $permission = new Permission();
        $permission->name = $data['permission'];
        $permission->save();
        return redirect()->back()->with('thong bao', 'thêm thành công');
    }
}
