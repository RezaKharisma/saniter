<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        // Masukkan ke dalam collection agar bisa group by, permission join menu
        $permissions = new Collection(Permission::select('name','menu.judul','menu.id')
        ->with('roles')
        ->join('menu', 'permissions.id_menu', '=', 'menu.id')
        ->get());
        $permissions = $permissions->groupBy('judul');

        return view('pengaturan.role.index', compact('permissions'));
    }

    public function indexAssign(){
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();
        $menu = Menu::all();
        return view('pengaturan.role.assign-role', compact('users','roles','permissions','menu'));
    }

    public function create(){
        $permissions = new Collection(Permission::select('name','menu.judul','menu.id')
        ->with('roles')
        ->join('menu', 'permissions.id_menu', '=', 'menu.id')
        ->get());
        $permissions = $permissions->groupBy('judul');
        return view('pengaturan.role.create', compact('permissions'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[ // Validasi request dari form tambah menu
            'name' => 'required|unique:roles,name',
        ], ['name.required' => 'role wajib diisi.']);

        if ($validator->fails()) { // Jika validasi gagal
            toast('Mohon periksa form kembali!', 'error'); // Toast
            Session::flash('modalAdd', 'error');
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $role = Role::create(['name' => $request->name]);

        if (!empty($request->checkBox)) {
            if (count($request->checkBox) > 0) {
                foreach ($request->checkBox as $item) {
                    $permission = Permission::findByName($item);
                    $menu = Menu::find($permission->id_menu);
                    $accessRoles = json_decode($menu->access_roles);

                    array_push($accessRoles, $role->name);

                    $menu->update([
                        'access_roles' => json_encode(array_unique($accessRoles))
                    ]);

                    $role->givePermissionTo($permission);
                }
            }
        }

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('pengaturan.role.index');
    }

    public function edit($id){
        $role = Role::with('permissions')->findOrFail($id);

        $permissionsAll = new Collection(Permission::select('name','menu.judul','menu.id')
        ->join('menu', 'permissions.id_menu', '=', 'menu.id')
        ->get());
        $permissionsAll = $permissionsAll->groupBy('judul');

        return view('pengaturan.role.edit', compact('role', 'permissionsAll'));
    }

    public function editAssign($id)
    {
        $role = Role::select('id','name')->get();
        $user = User::with('roles')->select('users.id','users.name')->find($id);
        $permissionsAll = new Collection(Permission::select('name','menu.judul','menu.id')
        ->join('menu', 'permissions.id_menu', '=', 'menu.id')
        ->get());
        $permissionsAll = $permissionsAll->groupBy('judul');

        return view('pengaturan.role.assign-role-edit', compact('role','user','permissionsAll'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[ // Validasi request dari form tambah menu
            'name' => 'required|unique:roles,name,'.$id,
        ], ['name.required' => 'role wajib diisi.']);

        if ($validator->fails()) { // Jika validasi gagal
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali
        }

        $role = Role::with('permissions')->find($id);
        $role->update([
            'name' => $request->name,
        ]);

        $newPermission = array();
        $oldAccessRoles = array();
        $permissionOld = json_decode($request->oldPermission, true);

        foreach($permissionOld as $key => $itemOld)
        {
            $permission = Permission::findByName($itemOld['name']);
            $oldAccessRoles[$itemOld['name']] = $permission->roles;
        }

        if ($request->checkBox != null) {
            foreach ($request->checkBox as $item) { // Ambil value checkbox berdasarkan nama itemnya
                $permission = Permission::findByName($item); // Kemudian cari nama item tersebut dan sesuaikan dengan nama permission yg ada
                array_push($newPermission, $permission);
            }
        }else{
            $newAccessRoles = array();
            foreach ($role->permissions as $item) { // Role memiliki berapa permission
                $menu = Menu::find($item->id_menu); // Cari menu berdasar id menu pada permission
                // Ambil value nya saja dari array yang tidak termasuk di access_roles dengan nama role
                $newAccessRoles = array_values(array_diff(json_decode($menu->access_roles), array($role->name)));
                $menu->update([
                    'access_roles' => json_encode(array_unique($newAccessRoles))
                ]);
            }
        }

        $role->syncPermissions($newPermission);

        foreach ($request->checkBox as $item)
        {
            $accessRoles = array();
            $newAccessRoles = array();
            $permission = Permission::findByName($item);
            $menu = Menu::find($permission->id_menu);
            $accessRoles[$item] = $permission->roles;

            dd( $accessRoles);

            if (count($oldAccessRoles) > count($accessRoles)) {
                foreach($permission->roles as $itemRoles){
                    array_push($newAccessRoles, $itemRoles->name);
                }
            }else{
                dd('berkurang');
            }

            $menu->update([
                'access_roles' => json_encode(array_unique($newAccessRoles))
            ]);
        }

        toast('Data berhasil tersimpan!', 'success'); // Toast
        return Redirect::route('pengaturan.role.index'); // Return kembali
    }

    public function updateAssign(Request $request, $id){
        $validator = Validator::make($request->all(),[ // Validasi request dari form tambah menu
            'user_name' => 'required|unique:roles,name,'.$id,
            'role_name' => 'required',
        ], ['user_name.required' => 'nama user wajib diisi.', 'role_name.required' => 'role wajib diisi.']);

        if ($validator->fails()) { // Jika validasi gagal
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali
        }

        $user = User::find($id);
        $role = Role::find($id); // Cari sub menu berdasarkan ID

        $user->syncRoles($role);

        $newPermission = array();
        if ($request->checkBox != null) {
            foreach ($request->checkBox as $item) {
                $permission = Permission::findByName($item);
                array_push($newPermission, $permission);
            }
        }

        $user->syncPermissions($newPermission);

        toast('Data berhasil tersimpan!', 'success'); // Toast
        return Redirect::route('pengaturan.assign-role.index'); // Return kembali
    }

    public function delete($id){
        $role = Role::with('permissions')->findOrFail($id);

        $newAccessRoles = array();
        foreach ($role->permissions as $item) {
            $menu = Menu::find($item->id_menu);
            $newAccessRoles = array_values(array_diff(json_decode($menu->access_roles), array($role->name)));

            $menu->update([
                'access_roles' => json_encode(array_unique($newAccessRoles))
            ]);
        }

        $role->delete();

        toast('Data berhasil terhapus!', 'success'); // Toast
        return Redirect::back(); // Return kembali
    }

    public function updateUnssign($id){
        $user = User::find($id);
        $user->syncRoles([]);
        $user->syncPermissions([]);

        toast('Data berhasil terimpan!', 'success'); // Toast
        return Redirect::back(); // Return kembali
    }
}
