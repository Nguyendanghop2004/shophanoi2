<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

use function Laravel\Prompts\alert;

class AccoutAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Show the form for creating a new resource.
     */
         
     public function __construct()
     {
        //  $this->middleware('permission:publish User|create User|edit User|delete User', ['only' => ['index', 'show']]);
        //  $this->middleware('permission:create User', ['only' => ['create']]);
        //  $this->middleware('permission:edit User', ['only' => ['edit', 'update']]);
        //  $this->middleware('permission:delete User', ['only' => ['destroy']]);
        //  $this->middleware('permission:insert_permission', ['only' => ['insert_permission']]);
        //  $this->middleware('permission:insert_roles', ['only' => ['insert_roles']]);
        //  $this->middleware('permission:phanvaitro', ['only' => ['phanvaitro']]);

         
     }
 
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
        return view('admin.permissions.phanvaitro', compact('admin', 'role', 'all_column_roles', 'permission'));
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
    // Cấp roles
    public function insert_roles(Request $request, $id)
{
    $data = $request->all();
    $admin = Admin::find($id);

    // Lấy role của người đang thực hiện yêu cầu
    $currentUser = auth()->user();
    $currentUserRole = $currentUser->roles->first();

    // Kiểm tra nếu người đang thực hiện có vai trò 'admin' và người được cấp quyền cũng có vai trò 'admin'
    if ($currentUserRole && $currentUserRole->name != 'admin' && $admin->hasRole('admin')) {
        return redirect()->back()->with('error', 'Bạn không thể cấp vai trò này.');
    }

    // Kiểm tra nếu vai trò mới là 'admin' và có bất kỳ người dùng nào khác đã là 'admin'
    if ($data['role'] === 'admin') {
        $existingAdmin = Admin::role('admin')->where('id', '!=', $id)->first();
        if ($existingAdmin) {
            return redirect()->back()->with('error', 'Chỉ có một người dùng được phép có vai trò admin.');
        }
    }

    $admin->syncRoles($data['role']);
    return redirect()->back()->with('success', 'Cấp vai trò thành công');
}

    // Cấp quyền
    public function insert_permission(Request $request, $id)
    {
        $data = $request->all();
        $admin = Admin::find($id);
    
        if (!$admin) {
            return redirect()->back()->with('error', 'Người dùng không tồn tại.');
        }
    
        $role_id = $admin->roles->first()->id;
    
        $currentAdmin = auth()->guard('admin')->user(); // Sử dụng guard admin
        $currentAdminRole = $currentAdmin->roles->first();
    
        if ($currentAdminRole && $currentAdminRole->name == 'admin' && $admin->hasRole('admin')) {
          
        }
    
        // Kiểm tra và thiết lập quyền
        $permissions = $data['permission'] ?? [];
    
        if (empty($permissions)) {
            $role = Role::find($role_id);
            $role->syncPermissions([]); 
    
            return redirect()->back()->with('cancel', 'Đã loại bỏ hết quyền của');
        }
    
        $role = Role::find($role_id);
        $role->syncPermissions($permissions);
    
        return redirect()->back()->with('success', 'Cấp quyền thành công');
    }
    
    // Thêm quyền
    
    public function  insertPermission(Request $request)
    {
        $data = $request->all();
        $permission = new Permission();
        $permission->name = $data['permission'] ;
        $permission->save();
        return redirect()->back()->with('thong bao', 'thêm thành công');
    }
    // thêm roles

    public function  insertRoles(Request $request)
    {
        $data = $request->all();
        $role = new Role();
        $role->name = $data['roles'];
        $role->save();
        return redirect()->back()->with('thong bao', 'thêm thành công');
    }
    // Trang thái người dùng
    public function activate($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->status = true;
        $admin->save();

        return redirect()->back()->with('success', 'Tài khoản đã được kích hoạt.');
    }

    public function deactivate($id)
    {
        $admin = Admin::findOrFail($id);
    
        // Kiểm tra xem tài khoản có vai trò admin không
        if ($admin->hasRole('admin')) {
            return redirect()->back()->with('error', 'Không thể vô hiệu hóa tài khoản có quyền admin.');
        }
    
        $admin->status = false;
        $admin->save();
    
        return redirect()->back()->with('success', 'Tài khoản đã bị vô hiệu hóa.');
    }
    
}