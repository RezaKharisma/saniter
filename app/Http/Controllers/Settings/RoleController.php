<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $permissions = Permission::select('name')->get();
        return view('pengaturan.role.index', compact('permissions'));
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

        foreach ($request->permissions as $item) {
            $permission = Permission::findByName($item);
            $role->givePermissionTo($permission);
        }

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::back();
    }

    public function edit($id){
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::select('name')->get();
        return view('pengaturan.role.edit', compact('role', 'permissions'));
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

        $role = Role::find($id); // Cari sub menu berdasarkan ID
        $role->update([
            'name' => $request->name,
        ]);

        $newPermission = array();

        foreach ($request->permissions as $item) {
            $permission = Permission::findByName($item);
            array_push($newPermission, $permission);
        }

        $role->syncPermissions($newPermission);

        toast('Data berhasil tersimpan!', 'success'); // Toast
        return Redirect::route('pengaturan.role.index'); // Return kembali
    }

    public function delete($id){
        $role = Role::findOrFail($id);
        $role->delete();

        toast('Data berhasil terhapus!', 'success'); // Toast
        return Redirect::back(); // Return kembali
    }
}
