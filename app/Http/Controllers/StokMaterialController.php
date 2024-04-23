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
    | Histori Stok Material
    |----------------------------------------
    */

    public function indexHistori(){
        $stokMaterial = StokMaterial::all();
        return view('material.stok-material.histori.index', compact('stokMaterial'));
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
        // Ambil API Q-tech
        $material = new NamaMaterial();
        $namaMaterial = $material->getAllMaterial();
        return view('material.stok-material.pengajuan.create',compact('namaMaterial'));
    }

    public function detailPengajuan($id)
    {
        $diterima = '';
        $stokMaterial = StokMaterial::where('id', $id)->first();

        // Get dimana stok tersebut diterima spv dan pm, dan juga validasi pm bukan Tolak
        if ($stokMaterial->diterima_spv != 0 && $stokMaterial->diterima_pm != 0 && $stokMaterial->status_validasi_pm != 'Tolak') {
            // select stok material yang merupakan history
            $diterima = StokMaterial::where('history_id', $stokMaterial->history_id)->first();
        }

        // Ambil retur sesuai dengan stok material
        $retur = Retur::where('stok_material_id', $stokMaterial->id)->first();

        // Ambil API dari Q-tech
        $material = new NamaMaterial();
        $namaMaterial = $material->getNamaMaterialById($stokMaterial->material_id);
        $namaMaterial['harga_beli'] = number_format(floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $namaMaterial['harga_beli'])), 0, ",", ".");

        return view('material.stok-material.pengajuan.detail',compact('namaMaterial', 'stokMaterial','retur','diterima'));
    }

    public function storePengajuan(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(),[
            'material_id' => 'required',
            'masuk' => 'required',
        ],['masuk.required' => 'stok masuk wajib diisi.','material_id.required' => 'nama material wajib diisi.']); // Message

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error');
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        // Insert data
        $stok = StokMaterial::create([
            'material_id' => $request->material_id,
            'kode_material' => $request->kode_material,
            'nama_material' => $request->nama_material,
            'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->harga)), // hilangkan karakter dan ubah menjadi float
            'masuk' => $request->masuk,
            'stok_update' => 0,
            'created_by' => auth()->user()->name
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('stok-material.pengajuan.detailPengajuan', $stok->id);
    }

    public function updatePengajuan(Request $request, $id){
        // Validasi
        $validator = Validator::make($request->all(),[
            'masuk' => 'required'
        ],['masuk.required' => 'stok masuk wajib diisi.']);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error');
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $stok = StokMaterial::where('id', $id)->first();

        // Jika user memiliki permission validasi spv saat update
        if (auth()->user()->can('validasi_spv_stok_material')) {

            // Jika hanya update masuk saja
            $stok->update([
                'masuk' => $request->masuk,
            ]);

            // Jika update dengan check box validasi SPV
            if (isset($request->diterima_spv) != null) {
                $stok->update([
                    'masuk' => $request->masuk,
                    'diterima_spv' => 1,
                    'diterima_spv_by' => auth()->user()->name,
                    'tanggal_diterima_spv' => Carbon::now()->format('Y-m-d'),
                ]);
            }

            toast('Data berhasil disimpan!', 'success');
            return Redirect::route('stok-material.pengajuan.index');
        }

        // Jika user memiliki permission validasi pm saat update
        if (auth()->user()->can('validasi_pm_stok_material') && $stok->diterima_spv == 1) {

            // Jika update dengan check box validasi PM
            if(isset($request->diterima_pm) != null){

                // Validasi
                $validator = Validator::make($request->all(),[
                    'status_validasi_pm' => 'required',
                ],['status_validasi_pm.required' => 'status validasi wajib diisi.']);

                // Jika validasi gagal
                if ($validator->fails()) {
                    Session::flash('statusValidasi', 'error');
                    toast('Mohon periksa form kembali!', 'error');
                    return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
                }

                // Jika status ACC
                if ($request->status_validasi_pm == 'ACC') {
                    $stok->update([
                        'diterima_pm' => 1,
                        'diterima_pm_by' => auth()->user()->name,
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'stok_update' => $this->cekStokUpdateMaterial($request->kode_material) + $request->masuk,
                        'status_validasi_pm' => 'ACC',
                        'history' => 1,
                        'history_id' => $stok->id
                    ]);
                }

                // Jika status ACC Sebagian
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

                    // Insert baru stok untuk List Stok Material dengan kolom history = 1
                    $diterima = StokMaterial::create([
                        'material_id' => $stok->material_id,
                        'kode_material' => $stok->kode_material,
                        'nama_material' => $stok->nama_material,
                        'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $stok->harga)),
                        'masuk' => $request->jumlahSebagian,
                        'created_by' => 'System',
                        'diterima_pm' => 1,
                        'diterima_pm_by' => auth()->user()->name,
                        'status_validasi_pm' => 'ACC',
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'keterangan' => '-',
                        'diterima_spv' => 1,
                        'diterima_spv_by' => $stok->diterima_spv_by,
                        'tanggal_diterima_spv' => $stok->tanggal_diterima_pm,
                        'stok_update' => $this->cekStokUpdateMaterial($request->kode_material) + $request->jumlahSebagian,
                    ]);

                    // Insert retur
                    Retur::create([
                        'stok_material_id' => $stok->id,
                        'diterima_id' => $diterima->id,
                        'kode_material' => $stok->kode_material,
                        'nama_material' => $stok->nama_material,
                        'tgl_retur' => null,
                        'status' => 'ACC Sebagian',
                        'keterangan' => $stok->keterangan,
                        'jumlah' => $stok->masuk - $diterima->masuk,
                        'created_by' => $stok->diterima_pm_by,
                        'hasil_retur' => 'Menunggu Validasi'
                    ]);

                    // Update stok sebelumnya menjadi history
                    $stok->update([
                        'deskripsi' => $request->deskripsi,
                        'sebagian' => $request->jumlahSebagian,
                        'diterima_pm' => 1,
                        'diterima_pm_by' => auth()->user()->name,
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_pm' => 'ACC Sebagian',
                        'stok_update' => 0,
                        'history' => 1,
                        'history_id' => $diterima->id
                    ]);
                }

                // Jika status Tolak
                if ($request->status_validasi_pm == 'Tolak') {

                    // Insert retur
                    Retur::create([
                        'stok_material_id' => $stok->id,
                        'diterima_id' => $stok->id,
                        'kode_material' => $stok->kode_material,
                        'nama_material' => $stok->nama_material,
                        'tgl_retur' => null,
                        'status' => 'Tolak',
                        'keterangan' => $stok->keterangan,
                        'jumlah' => $stok->masuk,
                        'created_by' => $stok->diterima_pm_by,
                        'hasil_retur' => 'Menunggu Validasi'
                    ]);

                    // Update stok sebelumnya menjadi history
                    $stok->update([
                        'deskripsi' => $request->deskripsi,
                        'diterima_pm' => 1,
                        'diterima_pm_by' => auth()->user()->name,
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_pm' => 'Tolak',
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

    // public function cekKodeMaterial($kode_material){
    //     $stokKode = StokMaterial::where('kode_material', 'LIKE', '%'.$kode_material.'%')->where('history', 1)->get();
    //     return $kode_material."-SNTR-".sprintf('%03d',count($stokKode)+1);
    // }

    public function cekStokUpdateMaterial($kode_material){
        $stokLatest = StokMaterial::where('kode_material', 'LIKE', '%'.$kode_material.'%')->where('status_validasi_pm', 'ACC')->latest()->first();

        if ($stokLatest == null) {
            return 0;
        }

        return $stokLatest->stok_update;
    }

    public function deletePengajuan($id){
        $stok = StokMaterial::where('id', $id)->first();
        $stok->delete();

        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('stok-material.pengajuan.index'); // Redirect kembali
    }
}
