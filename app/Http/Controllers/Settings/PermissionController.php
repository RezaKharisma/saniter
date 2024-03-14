<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(){
        $menu = Menu::select('id','judul')->get();
        $roles = Role::select('name')->get();
        return view('pengaturan.permission.index', compact('roles', 'menu'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'id_menu' => 'required|unique:menu,id_role',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            Session::flash('modalAdd', 'error');
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $menu = Menu::find($request->id_menu);
        $permission = Permission::create(['name' => $menu->judul]);

        $menu->update([
            'id_role' => $permission->id
        ]);

        $newPermission = array();
        foreach ($request->role as $item) {
            $role = Role::findByName($item);
            array_push($newPermission, $role);
        }
        $permission->syncRoles($newPermission);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::back();
    }

    public function delete($id){
        $menu = Menu::where('id_role', $id);
        $menu->update([
            'id_role' => null
        ]);

        $permission = Permission::findOrFail($id);
        $permission->delete();

        toast('Data berhasil terhapus!', 'success'); // Toast
        return Redirect::back(); // Return kembali
    }
}
