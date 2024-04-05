<?php

namespace App\Http\Controllers;

use App\Models\Api\NamaMaterial;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Decimal;

class StokMaterialController extends Controller
{
    public function index(){
        $stokMaterial = StokMaterial::all();
        return view('material.stok-material.index', compact('stokMaterial'));
    }

    public function create()
    {
        $material = new NamaMaterial();
        $namaMaterial = $material->getAllMaterial();
        return view('material.stok-material.create',compact('namaMaterial'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'material_id' => 'required',
            'masuk' => 'required'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        StokMaterial::create([
            'material_id' => $request->material_id,
            'kode_material' => $request->kode_material,
            'harga' => (float) $request->harga,
            'masuk' => $request->masuk,
            'created_by' => auth()->user()->name
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('stok-material.index');
    }
}
