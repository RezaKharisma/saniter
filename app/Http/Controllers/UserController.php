<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Regional;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('*', 'users.name','users.id','users.email','regional.nama as regional_name')
            ->leftjoin('regional', 'regional.id', '=', 'users.id_regional')
            ->get();

        $regional = Regional::select('*')
            ->get();
        return view('user.index', compact('users', 'regional'));
    }

    public function create()
    {   
        $regional = Regional::select('*')
            ->get();
        return view('user.create', compact('regional'));
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

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }
        
        // dd($request->all());
        $data = new User;
        $data->id_regional = $request->id_regional;
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
        // Mengambil request dari submit form
        $validator = Validator::make( 
            $request->all(),
            [
                // Validasi & ambil semua request
                'name' => 'required',
                'nik' => 'required',
                'email' => 'required|unique:users,email,'.$id,
                'telp' => 'required|unique:users,telp,'.$id,
                'path' => 'required',
                'id_regional' => 'required',
            ]
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $users = User::find($id); // Where user = $id
        $data = [
            'id_regional' => $request->id_regional,
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'telp' => $request->telp,
            'path' => $this->imageStore($request->file('path')),
        ];
        // dd($users);
        $users->update($data); // Update data

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::back(); // Redirect kembali
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
        $image = Storage::disk('public')->put('user-images', $image);
        return $image;
    }
}
