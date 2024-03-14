<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(){
        $roles = Role::select('name')->get();
        return view('pengaturan.permission.index', compact('roles'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions,name'
        ]);

        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            Session::flash('modalAdd', 'error');
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $permission = Permission::create(['name' => $request->name]);

        foreach ($request->role as $item) {
            $role = Role::findByName($item);
            $role->givePermissionTo($permission);
        }

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::back();
    }
}
