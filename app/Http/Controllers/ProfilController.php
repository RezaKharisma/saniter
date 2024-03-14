<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfilController extends Controller
{
    public function index()
    {
        $user = User::join('regional', 'users.id_regional', '=', 'regional.id')
            ->where('users.id', auth()->user()->id)
            ->select('users.*', 'regional.nama AS namaRegional')
            ->first(); // Select row table user, join (regional)
        return view('profil.index', compact('user')); // Kirim data compact sesuai variable
    }

    public function indexResetPassword()
    {
        $user = User::where('users.id', Auth()->user()->id)->first(); // Select row table user, join (user_role, regional)
        return view('profil.reset-password', compact('user')); // Kirim data compact sesuai variable
    }

    // Update profil user
    public function updateProfil(Request $request, $id)
    {
        // Mengambil request dari submit form
        $validator = Validator::make(
            $request->all(),
            [
                // Validasi & ambil semua request
                'name' => 'required', // Required == diperlukan
                'email' => 'required|unique:users,email,' . $id, // Unique email selain id sendiri
                'telp' => 'required',
                'nik' => 'required',
            ],
            ['telp.required' => 'Nomor Telepon wajib diisi.']
        ); // Custom error message

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $user = User::find($id); // Where user = $id
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'telp' => $request->telp,
            'nik' => $request->nik,
        ];
        $user->update($data); // Update data
        toast('Data berhasil tersimpan!', 'success');
        return Redirect::back(); // Redirect kembali
    }

    // Update Password
    public function updatePassword(Request $request, $id)
    {
        // Mengambil request dari submit form
        $validator = Validator::make(
            $request->all(),
            [
                // Validasi & ambil semua request
                'old_password' => 'required',
                'password' => 'required|min:5|same:confirmation_password',
            ],
            ['old_password.required' => 'Password lama wajib diisi.', 'password.same' => 'Password baru dan konfirmasi harus sama.']
        );

        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            // cek hash password input dengan password di database jika salah
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()->withErrors(['old_password' => 'Password anda tidak cocok!']); // flash message error old password tidak cocok
        }

        $user = User::find($id); // Where user = $id
        $data = [
            'password' => Hash::make($request->password), // Buat hash request password baru
        ];
        $user->update($data); // Update data
        toast('Password berhasil diperbarui!', 'success');
        return Redirect::back(); // Redirect kembali
    }

    // Update Image
    public function updateImage(Request $request, $id)
    {
        if ($request->file('foto')) {
            // Jika ada file
            $validator = Validator::make(
                $request->all(),
                [
                    'foto' => 'required|mimes:png,jpg,jpeg|max:2000',
                ],
                ['foto.max' => 'Foto maksimal berukuran 2 MB.']
            );

            if ($validator->fails()) {
                toast('Mohon periksa form kembali!', 'error'); // Toast
                return Redirect::back()->withErrors($validator);
            }

            $user = User::find($id); // Cari tabel user berdasarkan id
            $user->update([
                // Update data
                'path' => $this->imageStore($request->file('foto'), $user), // Pemanggilan fungsi imageStore
            ]);
            toast('Foto berhasil diperbarui!', 'success');
            return Redirect::back();
        }
        return Redirect::back();
    }

    // Fungsi simpan data ke folder
    private function imageStore($image, $user)
    {
        // Delete jika foto bukan default.jpg
        if ($user->path != 'user-images/default.jpg') {
            Storage::disk('public')->delete($user->path);
        }
        // Masukkan ke folder user-images dengan nama random dan extensi saat upload
        $image = Storage::disk('public')->put('user-images', $image);
        return $image;
    }
}
