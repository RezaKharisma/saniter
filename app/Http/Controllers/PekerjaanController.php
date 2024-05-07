<?php

namespace App\Http\Controllers;

use App\Models\Pekerja;
use Illuminate\Http\Request;
use App\Models\ItemPekerjaan;
use App\Models\KategoriPekerjaan;
use Illuminate\Support\Facades\DB;
use App\Models\SubKategoriPekerjaan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
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
            'nama' => 'required|unique:pekerja,nama',
            'upah' => 'required',
            'satuan' => 'required',
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
            'nama' => $request->nama,
            'upah' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->upah)),
            'satuan' => $request->satuan,
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('jenis-pekerja.index'); // Redirect kembali
    }

    public function update_pekerja(Request $request, $id)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:pekerja,nama,' . $id,
            'upah' => 'required',
            'satuan' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::flash('modalEdit', 'error');
            Session::flash('editID', $id);
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $pekerja = Pekerja::find($id);
        $pekerja->update([
            'nama' => $request->nama,
            'upah' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->upah)),
            'satuan' => $request->satuan,
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('jenis-pekerja.index'); // Redirect kembali
    }

    public function delete_pekerja($id)
    {
        $pekerja = Pekerja::find($id);
        $pekerja->delete();

        toast('Data berhasil terhapus!', 'success');
        return Redirect::route('jenis-pekerja.index');
    }


    // KATEGORI PEKERJAAN


    public function index_kategori()
    {
        $pekerja = Pekerja::all();
        return view('pekerjaan.kategori-pekerjaan.index', compact('pekerja'));
    }

    public function create_kategori()
    {
        $pekerja = Pekerja::all();
        return view('pekerjaan.kategori-pekerjaan.create', compact('pekerja'));
    }

    public function store_kategori(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:kategori_pekerjaan,nama',
            // 'id_pekerja' => 'required',
        ], [
            'name.required' => 'nama kategori wajib diisi.',
            // 'id_pekerja.required' => 'pekerja wajib diisi.'
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
            'nama' => $request->name
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('kategori-pekerjaan.index'); // Redirect kembali
    }

    public function update_kategori(Request $request, $id)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:kategori_pekerjaan,nama,' . $id,
            // 'id_pekerja' => 'required',
        ], [
            'name.required' => 'nama kategori wajib diisi.',
            // 'id_pekerja.required' => 'pekerja wajib diisi.'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::flash('modalEdit', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $pekerja = KategoriPekerjaan::find($id);
        $pekerja->update([
            // 'id_pekerja' => $request->id_pekerja,
            'nama' => $request->name
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('kategori-pekerjaan.index'); // Redirect kembali
    }

    public function delete_kategori($id)
    {
        $kategori = KategoriPekerjaan::find($id);
        $kategori->delete();

        toast('Data berhasil terhapus!', 'success');
        return Redirect::route('kategori-pekerjaan.index');
    }


    // SUB KATEGORI
    public function index_sub_kategori()
    {
        $kategoriPekerjaan = KategoriPekerjaan::all();
        return view('pekerjaan.sub-kategori-pekerjaan.index', compact('kategoriPekerjaan'));
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
        ], ['name.required' => 'nama kategori wajib diisi.', 'id_kategori_pekerjaan.required' => 'pekerja wajib diisi.']);

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

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('sub-kategori-pekerjaan.index'); // Redirect kembali
    }

    public function update_sub_kategori(Request $request, $id)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'id_kategori_pekerjaan' => 'required',
            'name' => 'required',
        ], ['name.required' => 'nama kategori wajib diisi.', 'id_kategori_pekerjaan.required' => 'pekerja wajib diisi.']);

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::flash('modalEdit', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $subKategori = SubKategoriPekerjaan::find($id);
        $subKategori->update([
            'id_kategori_pekerjaan' => $request->id_kategori_pekerjaan,
            'nama' => $request->name
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('sub-kategori-pekerjaan.index'); // Redirect kembali
    }

    public function delete_sub_kategori($id)
    {
        $subkategori = SubKategoriPekerjaan::find($id);
        $subkategori->delete();

        toast('Data berhasil terhapus!', 'success');
        return Redirect::route('sub-kategori-pekerjaan.index');
    }


    // ITEM PEKERJAAN

    public function index_item_pekerjaan()
    {
        $sub_kategori = DB::table('sub_kategori_pekerjaan')->get();
        return view('pekerjaan.item-pekerjaan.index', compact('sub_kategori'));
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
            'id_sub_kategori_pekerjaan' => 'required|unique:item_pekerjaan,nama',
            'name' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
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
            'volume' => floatval($request->volume),
            'satuan' => $request->satuan,
            'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->harga)),
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('item-pekerjaan.index'); // Redirect kembali
    }

    public function update_item_pekerjaan(Request $request, $id)
    {
        dd(floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->harga)));
        // Validasi form
        $validator = Validator::make($request->all(), [
            'id_sub_kategori_pekerjaan' => 'required|unique:item_pekerjaan,nama,' . $id,
            'name' => 'required',
            'volume' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::flash('modalEdit', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $itemPekerjaan = ItemPekerjaan::find($id);
        // Insert data lokasi baru dari input form
        $itemPekerjaan->update([
            'id_sub_kategori_pekerjaan' => $request->id_sub_kategori_pekerjaan,
            'nama' => $request->name,
            'volume' => floatval($request->volume),
            'satuan' => $request->satuan,
            'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->harga)),
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('item-pekerjaan.index'); // Redirect kembali
    }

    public function delete_item_pekerjaan($id)
    {
        $itemPekerjaan = ItemPekerjaan::find($id);
        $itemPekerjaan->delete();

        toast('Data berhasil terhapus!', 'success');
        return Redirect::route('item-pekerjaan.index');
    }
}
