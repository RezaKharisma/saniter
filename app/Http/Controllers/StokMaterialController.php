<?php

namespace App\Http\Controllers;

use App\Models\Api\NamaMaterial;
use App\Models\Retur;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Decimal;
use Spatie\Permission\Models\Role;

class StokMaterialController extends Controller
{
    /*
    |----------------------------------------
    | List Stok Material
    |----------------------------------------
    */

    public function indexList(){
        $stokMaterial = StokMaterial::all();
        return view('material.stok-material.list.index', compact('stokMaterial'));
    }

    /*
    |----------------------------------------
    | Pengajuan / Tambah Stok Material
    |----------------------------------------
    */

    public function indexPengajuan(){
        $stokMaterial = StokMaterial::all();
        return view('material.stok-material.pengajuan.index', compact('stokMaterial'));
    }

    public function createPengajuan()
    {
        $material = new NamaMaterial();
        $namaMaterial = $material->getAllMaterial();
        return view('material.stok-material.pengajuan.create',compact('namaMaterial'));
    }

    public function detailPengajuan($id)
    {
        $diterima = '';
        $stokMaterial = StokMaterial::where('id', $id)->first();

        if ($stokMaterial->diterima_pm != 0 && $stokMaterial->diterima_spv != 0 && $stokMaterial->status_validasi_pm != 'Tolak') {
            $diterima = StokMaterial::where('history_id', $stokMaterial->history_id)->first();
        }

        $retur = Retur::where('stok_material_id', $stokMaterial->id)->first();

        $material = new NamaMaterial();
        $namaMaterial = $material->getNamaMaterialById($stokMaterial->material_id);
        $namaMaterial['harga_beli'] = number_format(floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $namaMaterial['harga_beli'])), 0, ",", ".");

        return view('material.stok-material.pengajuan.detail',compact('namaMaterial', 'stokMaterial','retur','diterima'));
    }

    public function storePengajuan(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'material_id' => 'required',
            'masuk' => 'required',
        ],['masuk.required' => 'stok masuk wajib diisi.','material_id.required' => 'nama material wajib diisi.']);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $stok = StokMaterial::create([
            'material_id' => $request->material_id,
            'kode_material' => $this->cekKodeMaterial($request->kode_material),
            'nama_material' => $request->nama_material,
            'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->harga)),
            'masuk' => $request->masuk,
            'stok_update' => 0,
            'created_by' => auth()->user()->name
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('stok-material.pengajuan.detailPengajuan', $stok->id);
    }

    public function updatePengajuan(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'masuk' => 'required'
        ],['masuk.required' => 'stok masuk wajib diisi.']);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $stok = StokMaterial::where('id', $id)->first();

        if (auth()->user()->can('validasi_pm_stok_material')) {
            if (isset($request->diterima_pm) != null) {
                $validator = Validator::make($request->all(),[
                    'status_validasi_pm' => 'required',
                ],['status_validasi_pm.required' => 'status validasi wajib diisi.']);

                // Jika validasi gagal
                if ($validator->fails()) {
                    Session::flash('statusValidasi', 'error');
                    toast('Mohon periksa form kembali!', 'error'); // Toast
                    return Redirect::back()
                    ->withErrors($validator)
                    ->withInput(); // Return kembali membawa error dan old input
                }

                if ($request->status_validasi_pm == 'ACC') {
                    $stok->update([
                        'masuk' => $request->masuk,
                        'diterima_pm' => 1,
                        'diterima_pm_by' => auth()->user()->name,
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_pm' => 'ACC',
                        'keterangan' => $request->keterangan == null ? '-' : $request->keterangan,
                    ]);
                }

                if ($request->status_validasi_pm == 'ACC Sebagian') {

                    $validator = Validator::make($request->all(),[
                        'jumlahSebagian' => 'required',
                    ],['jumlahSebagian.required' => 'jumlah wajib diisi.']);

                    // Jika validasi gagal
                    if ($validator->fails()) {
                        Session::flash('jumlahSebagian', 'error');
                        toast('Mohon periksa form kembali!', 'error'); // Toast
                        return Redirect::back()
                        ->withErrors($validator)
                        ->withInput(); // Return kembali membawa error dan old input
                    }

                    $stok->update([
                        'masuk' => $request->masuk,
                        'sebagian' => $request->jumlahSebagian,
                        'diterima_pm' => 1,
                        'diterima_pm_by' => auth()->user()->name,
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_pm' => $request->status_validasi_pm,
                        'keterangan' => $request->keterangan == null ? '-' : $request->keterangan,
                    ]);
                }

                if($request->status_validasi_pm == 'Tolak'){
                    $stok->update([
                        'masuk' => $request->masuk,
                        'sebagian' => 0,
                        'diterima_pm' => 1,
                        'diterima_pm_by' => auth()->user()->name,
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_pm' => $request->status_validasi_pm,
                        'keterangan' => $request->keterangan == null ? '-' : $request->keterangan,
                    ]);
                }

                toast('Data berhasil disimpan!', 'success');
                return Redirect::route('stok-material.pengajuan.index');
            }else{
                toast('Data berhasil disimpan!', 'success');
                return Redirect::route('stok-material.pengajuan.index');
            }
        }

        if (auth()->user()->can('validasi_spv_stok_material') && $stok->diterima_pm == 1) {
            if(isset($request->diterima_spv) != null){

                if ($stok->status_validasi_pm == 'ACC') {
                    $stok->update([
                        'diterima_spv' => 1,
                        'diterima_spv_by' => auth()->user()->name,
                        'tanggal_diterima_spv' => Carbon::now()->format('Y-m-d'),
                        'stok_update' => $request->masuk,
                        'history' => 1,
                        'history_id' => $stok->id
                    ]);
                }

                if ($stok->status_validasi_pm == 'ACC Sebagian') {
                    $diterima = StokMaterial::create([
                        'material_id' => $stok->material_id,
                        'kode_material' => $stok->kode_material,
                        'nama_material' => $stok->nama_material,
                        'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $stok->harga)),
                        'masuk' => $stok->sebagian,
                        'created_by' => 'System',
                        'diterima_pm' => 1,
                        'diterima_pm_by' => $stok->diterima_pm_by,
                        'status_validasi_pm' => 'ACC',
                        'tanggal_diterima_pm' => $stok->tanggal_diterima_pm,
                        'keterangan' => $stok->keterangan,
                        'diterima_spv' => 1,
                        'diterima_spv_by' => auth()->user()->name,
                        'tanggal_diterima_spv' => Carbon::now()->format('Y-m-d'),
                        'stok_update' => $stok->stok_update,
                    ]);

                    Retur::create([
                        'stok_material_id' => $stok->id,
                        'diterima_id' => $diterima->id,
                        'kode_material' => $stok->kode_material,
                        'nama_material' => $stok->nama_material,
                        'tgl_retur' => null,
                        'status' => $stok->status_validasi_pm,
                        'keterangan' => $stok->keterangan,
                        'jumlah' => $stok->masuk - $stok->sebagian,
                        'created_by' => $stok->diterima_pm_by,
                        'hasil_retur' => 'Menunggu Validasi'
                    ]);

                    $stok->update([
                        'diterima_spv' => 1,
                        'diterima_spv_by' => auth()->user()->name,
                        'tanggal_diterima_spv' => Carbon::now()->format('Y-m-d'),
                        'stok_update' => $request->masuk,
                        'history' => 1,
                        'history_id' => $diterima->id
                    ]);
                }

                if ($stok->status_validasi_pm == 'Tolak') {
                    Retur::create([
                        'stok_material_id' => $stok->id,
                        'diterima_id' => $stok->id,
                        'kode_material' => $stok->kode_material,
                        'nama_material' => $stok->nama_material,
                        'tgl_retur' => null,
                        'status' => $stok->status_validasi_pm,
                        'keterangan' => $stok->keterangan,
                        'jumlah' => $stok->masuk,
                        'created_by' => $stok->diterima_pm_by,
                        'hasil_retur' => 'Menunggu Validasi'
                    ]);

                    $stok->update([
                        'diterima_spv' => 1,
                        'diterima_spv_by' => auth()->user()->name,
                        'tanggal_diterima_spv' => Carbon::now()->format('Y-m-d'),
                        'stok_update' => 0,
                        'history' => 1,
                        'history_id' => $stok->id
                    ]);
                }

                toast('Data berhasil disimpan!', 'success');
                return Redirect::route('stok-material.pengajuan.index'); // Redirect kembali
            }
        }else{
            toast('Data berhasil disimpan!', 'success');
            return Redirect::route('stok-material.pengajuan.index'); // Redirect kembali
        }
    }

    public function cekKodeMaterial($kode_material){
        $stokKode = StokMaterial::where('kode_material', 'LIKE', '%'.$kode_material.'%')->get();
        return $kode_material."-SNTR-".sprintf('%03d',count($stokKode)+1);
    }

    public function cekStokUpdateMaterial($kode_material){
        // $stokKode = StokMaterial::where('kode_material', 'LIKE', '%'.$kode_material.'%')->get();
        // return $kode_material."-SNTR-".sprintf('%03d',count($stokKode)+1);
    }

    public function deletePengajuan($id){
        $stok = StokMaterial::where('id', $id)->first();
        $stok->delete();

        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('stok-material.pengajuan.index'); // Redirect kembali
    }
}
