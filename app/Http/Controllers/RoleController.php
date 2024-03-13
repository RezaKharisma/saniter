<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(){
        return view('pengaturan.role.index');
    }

    public function store(Request $request){

        if ($request->IncludeCRUD) {
            dd("On");
        }else{
            dd("Off");
        }

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

        Role::create([ // Insert data baru pada database
            'name' => $request->name,
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::back();
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[ // Validasi request dari form tambah menu
            'name' => 'required|unique:roles,name,'.$id,
        ], ['name.required' => 'role wajib diisi.']);

        if ($validator->fails()) { // Jika validasi gagal
            Session::flash('modalEdit', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali
        }

        $menu = Role::find($id); // Cari sub menu berdasarkan ID
        $menu->update([
            'name' => $request->name,
        ]);

        toast('Data berhasil tersimpan!', 'success'); // Toast
        return Redirect::back(); // Return kembali
    }
}
