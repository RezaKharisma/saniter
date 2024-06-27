<?php

namespace App\Http\Controllers;

use App\Models\Peralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PeralatanController extends Controller
{
    public function index()
    {
        return view('peralatan.index');
    }

    public function create()
    {
        return view('peralatan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_peralatan' => 'required|unique:peralatan,nama_peralatan',
            'satuan' => 'required',
            'harga' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        Peralatan::create([
            'nama_peralatan' => ucwords(strtolower($request->nama_peralatan)),
            'satuan' => strtolower($request->satuan),
            'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->harga)),
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('peralatan.index'); // Redirect kembali
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_peralatan' => 'required|unique:peralatan,nama_peralatan,' . $id,
            'satuan' => 'required',
            'harga' => 'required'
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

        $pekerja = Peralatan::find($id);
        $pekerja->update([
            'nama_peralatan' => ucwords(strtolower($request->nama_peralatan)),
            'satuan' => strtolower($request->satuan),
            'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->harga)),
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('peralatan.index'); // Redirect kembali
    }

    public function delete($id)
    {
        $peralatan = Peralatan::find($id);
        $peralatan->delete();

        toast('Data berhasil terhapus!', 'success');
        return Redirect::route('peralatan.index');
    }
}
