<?php

namespace App\Http\Controllers;

use App\Models\KategoriPekerjaan;
use App\Models\Pekerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PekerjaanController extends Controller
{
    public function index_pekerja()
    {
        $users = DB::table('pekerja')->get();

        return view('pekerjaan.jenis-pekerja.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_pekerja()
    {
        return view('pekerjaan.jenis-pekerja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_pekerja(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'name' => 'required',
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        toast('Mohon periksa form kembali!', 'error'); // Toast
        return Redirect::back()
            ->withErrors($validator)
            ->withInput(); // Return kembali membawa error dan old input
    }

    // Insert data lokasi baru dari input form
    Pekerja::create([
        'nama' => $request->name,
    ]);

    toast('Data Jenis Pekerja berhasil tersimpan!', 'success');
    return Redirect::route('jenis-pekerja.index'); // Redirect kembali
    }

    public function index_kategori()
    {
        $kategori = DB::table('kategori_pekerjaan')->get();

        return view('pekerjaan.kategori-pekerjaan.index', compact('kategori'));
    }

    public function create_kategori()
    {

        $pekerja = DB::table('pekerja')->get();

        return view('pekerjaan.kategori-pekerjaan.create', compact('pekerja'));
    }

    public function store_kategori(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'name' => 'required',
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        toast('Mohon periksa form kembali!', 'error'); // Toast
        return Redirect::back()
            ->withErrors($validator)
            ->withInput(); // Return kembali membawa error dan old input
    }

    // Insert data lokasi baru dari input form
    KategoriPekerjaan::create([
        // 'id_pekerja' => $request->id_pekerja,
        'nama' => $request->name,
    ]);

    toast('Data Kategori Pekerja berhasil tersimpan!', 'success');
    return Redirect::route('kategori-pekerjaan.index'); // Redirect kembali
    }
}
