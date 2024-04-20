<?php

namespace App\Http\Controllers;

use App\Models\Api\NamaMaterial;
use App\Models\Retur;
use App\Models\StokMaterial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReturController extends Controller
{
    public function index(){
        return view('material.stok-material.retur.index');
    }

    public function detail($kode_material){
        $retur = Retur::where('kode_material', $kode_material)->first();
        $stokMaterial = StokMaterial::where('id', $retur->stok_material_id)->first();

        $material = new NamaMaterial();
        $namaMaterial = $material->getNamaMaterialById($stokMaterial->material_id);

        return view('material.stok-material.retur.detail', compact('retur','namaMaterial'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'tgl_retur' => 'required',
            'retur_by' => 'required',
            'retur_to' => 'required',
            'hasil_retur' => 'required'
        ],[
            'tgl_retur.required'=>'tanggal retur wajib diisi.',
            'retur_by.required'=>'dikembalikan oleh wajib diisi.',
            'retur_to.required'=>'dikembalikan kepada wajib diisi.'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::flash('jumlahSebagian', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
            ->withErrors($validator)
            ->withInput(); // Return kembali membawa error dan old input
        }

        $retur = Retur::find($id);
        $retur->update([
            'tgl_retur' => Carbon::createFromFormat('d/m/Y', $request->tgl_retur)->format('Y-m-d'),
            'retur_by' => $request->retur_by,
            'validasi_by' => 1,
            'retur_to' => $request->retur_to,
            'validasi_to' => $request->retur_to,
            'hasil_retur' => $request->hasil_retur
        ]);

        toast('Data berhasil disimpan!', 'success');
        return Redirect::route('stok-material.retur.index');
    }
}
