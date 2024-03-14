<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('users.name','users.id','users.email','regional.nama as regional_name')
            ->leftjoin('regional', 'regional.id', '=', 'users.id_regional')
            ->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function user_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'name' => 'required',
                'nik' => 'required',
                'email' => 'required|unique:user,email',
                'telp' => 'required|unique:user,no_telp',
                'password' => 'required|same:confirm-password',
        ]);
        
        // dd($request->all());
        $data = new User;
        $data->id_regional = '1';
        $data->name = $request->name;
        $data->email = $request->email;
        $data->nik = $request->nik;
        $data->telp = $request->telp;
        $data->path = $this->imageStore($request->file('path'));
        $data->password = bcrypt(($request->password));
        $data->save();

        toast('Data berhasil tersimpan!', 'success');
        return Redirect()->to('/user'); // Redirect kembali
    }

    // Fungsi Update Data
    public function update(Request $request, $id)
    {
        //
    }

    // Fungsi Simpan Data
    public function store(Request $request)
    {
        //
    }

    // Fungsi View Edit Data
    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit', compact('user'));
    }

    // Fungsi Delete Data
    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        toast('Data berhasil dihapus!', 'success');
        return Redirect()->to('/user'); // Redirect kembali
    }

    // Fungsi simpan data ke folder
    private function imageStore($image)
    {
        // Masukkan ke folder user-images dengan nama random dan extensi saat upload
        $image = Storage::disk('public')->put('user-images/', $image);
        return $image;
    }
}
