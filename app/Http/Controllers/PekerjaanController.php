<?php

namespace App\Http\Controllers;

use App\Models\Pekerja;
use Illuminate\Http\Request;
use App\Models\ItemPekerjaan;
use App\Models\KategoriPekerjaan;
use Illuminate\Support\Facades\DB;
use App\Models\SubKategoriPekerjaan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PekerjaanController extends Controller
{

    // JENIS PEKERJA


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


    // KATEGORI PEKERJAAN


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
        'nama' => $request->name,
    ]);

    toast('Data Kategori Pekerjaan berhasil tersimpan!', 'success');
    return Redirect::route('kategori-pekerjaan.index'); // Redirect kembali
    }


    // SUB KATEGORI


    public function index_sub_kategori()
    {
        $sub_kategori = SubKategoriPekerjaan::select('sub_kategori_pekerjaan.*','sub_kategori_pekerjaan.nama as subNama','kategori_pekerjaan.nama as kategoriNama')->join('kategori_pekerjaan','sub_kategori_pekerjaan.id_kategori_pekerjaan','=','kategori_pekerjaan.id')->get();
        // $sub_kategori = DB::table('sub_kategori_pekerjaan')->get();

        return view('pekerjaan.sub-kategori-pekerjaan.index', compact('sub_kategori'));
    }

    public function create_sub_kategori()
    {

        $kategori = DB::table('kategori_pekerjaan')->get();

        return view('pekerjaan.sub-kategori-pekerjaan.create', compact('kategori'));
    }

    public function store_sub_kategori(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'id_kategori_pekerjaan' => 'required',
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
    SubKategoriPekerjaan::create([
        'id_kategori_pekerjaan' => $request->id_kategori_pekerjaan,
        'nama' => $request->name,
    ]);

    toast('Data Sub Kategori Pekerjaan berhasil tersimpan!', 'success');
    return Redirect::route('sub-kategori-pekerjaan.index'); // Redirect kembali
    }


    // ITEM PEKERJAAN

    public function index_item_pekerjaan()
    {
        $item_pekerjaan = ItemPekerjaan::select('item_pekerjaan.*','item_pekerjaan.nama as itemNama','sub_kategori_pekerjaan.nama as subNama')->join('sub_kategori_pekerjaan','item_pekerjaan.id_sub_kategori_pekerjaan','=','sub_kategori_pekerjaan.id')->get();
        // $sub_kategori = DB::table('sub_kategori_pekerjaan')->get();

        return view('pekerjaan.item-pekerjaan.index', compact('item_pekerjaan'));
    }

    public function create_item_pekerjaan()
    {

        $sub_kategori = DB::table('sub_kategori_pekerjaan')->get();

        return view('pekerjaan.item-pekerjaan.create', compact('sub_kategori'));
    }

    public function store_item_pekerjaan(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'id_sub_kategori_pekerjaan' => 'required',
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
    ItemPekerjaan::create([
        'id_sub_kategori_pekerjaan' => $request->id_sub_kategori_pekerjaan,
        'nama' => $request->name,
    ]);

    toast('Data Item Pekerjaan berhasil tersimpan!', 'success');
    return Redirect::route('item-pekerjaan.index'); // Redirect kembali
    }
}
