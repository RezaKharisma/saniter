<?php

namespace App\Http\Controllers;

use App\Models\Retur;
use App\Models\Pekerja;
use Carbon\CarbonPeriod;
use App\Models\Peralatan;
use App\Models\NamaMaterial;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use App\Models\DetailPekerja;
use App\Models\ItemPekerjaan;
use Illuminate\Support\Carbon;
use App\Models\DetailPeralatan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KategoriPekerjaan;
use App\Models\DetailItemPekerjaan;
use App\Models\DetailJenisKerusakan;
use App\Models\SubKategoriPekerjaan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\NamaMaterial as NamaMaterialAPI;

class StokMaterialController extends Controller
{
    /*
    |----------------------------------------
    | List Stok Material
    |----------------------------------------
    */

    public function indexList()
    {
        $stokMaterial = StokMaterial::all();

        $stokMaterialList = StokMaterial::select('id', 'kode_material', 'nama_material', 'harga', 'stok_update')
            ->where('diterima_som', 1)
            ->where('diterima_pm', 1)
            ->where('diterima_dir', 1)
            ->where('status_validasi_dir', 'ACC')
            ->whereNot('status_validasi_dir', 'Tolak')
            ->groupBy('kode_material')
            ->get();

        return view('material.stok-material.list.index', compact('stokMaterial', 'stokMaterialList'));
    }


    /*
    |----------------------------------------
    | Histori Stok Material
    |----------------------------------------
    */

    public function indexHistori()
    {
        $stokMaterial = StokMaterial::all();
        return view('material.stok-material.histori.index', compact('stokMaterial'));
    }

    public function logHistori()
    {
        $stokMaterial = StokMaterial::all();
        return view('material.stok-material.histori.log', compact('stokMaterial'));
    }

    public function indexHistoriPengajuan()
    {
        $stokMaterial = StokMaterial::all();
        return view('material.stok-material.pengajuan.histori', compact('stokMaterial'));
    }


    /*
    |----------------------------------------
    | Pengajuan / Tambah Stok Material
    |----------------------------------------
    */

    public function indexPengajuan()
    {
        $stokMaterial = StokMaterial::all();
        return view('material.stok-material.pengajuan.index', compact('stokMaterial'));
    }

    public function createPengajuanQTech()
    {
        // Ambil API Q-tech
        $material = new NamaMaterialAPI();
        $namaMaterial = $material->getAllMaterial();
        return view('material.stok-material.pengajuan.create-qtech', compact('namaMaterial'));
    }

    public function createPengajuan()
    {
        // Ambil API Q-tech
        $namaMaterial = NamaMaterial::all();
        return view('material.stok-material.pengajuan.create', compact('namaMaterial'));
    }

    public function detailPengajuan($id)
    {
        $diterima = '';
        $stokMaterial = StokMaterial::where('id', $id)->first();

        // Get dimana stok tersebut diterima som dan pm, dan juga validasi pm bukan Tolak
        if ($stokMaterial->diterima_som != 0 && $stokMaterial->diterima_pm != 0 && $stokMaterial->diterima_dir != 0 && $stokMaterial->status_validasi_som != 'Tolak') {
            // select stok material yang merupakan history
            $diterima = StokMaterial::where('history_id', $stokMaterial->history_id)->first();
        }

        // Ambil retur sesuai dengan stok material
        $retur = Retur::where('stok_material_id', $stokMaterial->id)->first();

        if ($stokMaterial->kategori == 'QTECH') {
            // Ambil API dari Q-tech
            $material = new NamaMaterialAPI();
            $namaMaterial = $material->getNamaMaterialById($stokMaterial->material_id);
            $namaMaterial['harga_beli'] = number_format(floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $stokMaterial['harga'])), 0, ",", ".");
            return view('material.stok-material.pengajuan.detail-qtech', compact('namaMaterial', 'stokMaterial', 'retur', 'diterima'));
        }

        if ($stokMaterial->kategori == 'SANITER') {
            $namaMaterial = NamaMaterial::find($stokMaterial->material_id);
            $namaMaterial['harga_beli'] = number_format(floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $stokMaterial['harga'])), 0, ",", ".");
            return view('material.stok-material.pengajuan.detail', compact('namaMaterial', 'stokMaterial', 'retur', 'diterima'));
        }
    }

    public function storePengajuan(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'material_id' => 'required',
            'masuk' => 'required',
        ], ['masuk.required' => 'stok masuk wajib diisi.', 'material_id.required' => 'nama material wajib diisi.']); // Message

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error');
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->material_id as $key => $value) {
            // Insert data
            StokMaterial::create([
                'material_id' => $value,
                'kode_material' => $this->getKodeMaterialSaniter($request->kode_material[$key]),
                'nama_material' => $request->nama_material[$key],
                'kategori' => $request->typeForm,
                'satuan' => $request->satuan[$key] ?? '-',
                'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $request->harga[$key])), // hilangkan karakter dan ubah menjadi float
                'masuk' => $request->masuk[$key],
                'stok_update' => 0,
                'created_by' => auth()->user()->name
            ]);
        }

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('stok-material.pengajuan.index');
    }

    public function updatePengajuan(Request $request, $id)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'masuk' => 'required'
        ], ['masuk.required' => 'stok masuk wajib diisi.']);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error');
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $stok = StokMaterial::where('id', $id)->first();

        // Jika user memiliki permission validasi som saat update
        if (auth()->user()->can('validasi_som_stok_material')) {

            // Jika hanya update masuk saja
            $stok->update([
                'masuk' => $request->masuk,
            ]);

            // Jika update dengan check box validasi SOM
            if (isset($request->diterima_som) != null) {
                // Validasi
                $validator = Validator::make($request->all(), [
                    'status_validasi_som' => 'required',
                ], ['status_validasi_som.required' => 'status validasi wajib diisi.']);

                // Jika validasi gagal
                if ($validator->fails()) {
                    Session::flash('statusValidasiSOM', 'error');
                    toast('Mohon periksa form kembali!', 'error');
                    return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
                }

                // Jika status ACC
                if ($request->status_validasi_som == 'ACC') {
                    $stok->update([
                        'diterima_som' => 1,
                        'diterima_som_by' => auth()->user()->name,
                        'tanggal_diterima_som' => Carbon::now()->format('Y-m-d'),
                        'stok_update' => 0,
                        'status_validasi_som' => 'ACC',
                        'keterangan_som' => $request->keterangan_som ?? '-'
                    ]);
                }

                // Jika status ACC Sebagian
                if ($request->status_validasi_som == 'ACC Sebagian') {

                    $validator = Validator::make($request->all(), [
                        'jumlahSebagianSOM' => 'required',
                    ], ['jumlahSebagianSOM.required' => 'jumlah wajib diisi.']);

                    // Jika validasi gagal
                    if ($validator->fails()) {
                        Session::flash('jumlahSebagianSOM', 'error');
                        toast('Mohon periksa form kembali!', 'error'); // Toast
                        return Redirect::back()
                            ->withErrors($validator)
                            ->withInput(); // Return kembali membawa error dan old input
                    }

                    // Insert baru stok untuk List Stok Material dengan kolom history = 1
                    // $diterima = StokMaterial::create([
                    //     'material_id' => $stok->material_id,
                    //     'kode_material' => $stok->kode_material,
                    //     'nama_material' => $stok->nama_material,
                    //     'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $stok->harga)),
                    //     'masuk' => $request->jumlahSebagian,
                    //     'created_by' => 'System',
                    //     'diterima_som' => 1,
                    //     'diterima_som_by' => auth()->user()->name,
                    //     'status_validasi_som' => 'ACC',
                    //     'tanggal_diterima_som' => Carbon::now()->format('Y-m-d'),
                    //     'keterangan' => '-',
                    //     'diterima_spv' => 1,
                    //     'diterima_spv_by' => $stok->diterima_spv_by,
                    //     'tanggal_diterima_spv' => $stok->tanggal_diterima_som,
                    //     'stok_update' => $this->cekStokUpdateMaterial($request->kode_material) + $request->jumlahSebagian,
                    // ]);

                    // Insert retur
                    // Retur::create([
                    //     'stok_material_id' => $stok->id,
                    //     'diterima_id' => $diterima->id,
                    //     'kode_material' => $stok->kode_material,
                    //     'nama_material' => $stok->nama_material,
                    //     'tgl_retur' => null,
                    //     'status' => 'ACC Sebagian',
                    //     'keterangan' => $stok->keterangan,
                    //     'jumlah' => $stok->masuk - $diterima->masuk,
                    //     'created_by' => $stok->diterima_som_by,
                    //     'hasil_retur' => 'Menunggu Validasi'
                    // ]);

                    // Update stok sebelumnya menjadi history
                    $stok->update([
                        'keterangan_som' => $request->keterangan_som ?? '-',
                        'sebagian_som' => $request->jumlahSebagianSOM,
                        'diterima_som' => 1,
                        'diterima_som_by' => auth()->user()->name,
                        'tanggal_diterima_som' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_som' => 'ACC Sebagian',
                        'stok_update' => 0,
                    ]);
                }

                // Jika status Tolak
                if ($request->status_validasi_som == 'Tolak') {

                    // Insert retur
                    // Retur::create([
                    //     'stok_material_id' => $stok->id,
                    //     'diterima_id' => $stok->id,
                    //     'kode_material' => $stok->kode_material,
                    //     'nama_material' => $stok->nama_material,
                    //     'tgl_retur' => null,
                    //     'status' => 'Tolak',
                    //     'keterangan' => $stok->keterangan,
                    //     'jumlah' => $stok->masuk,
                    //     'created_by' => $stok->diterima_som_by,
                    //     'hasil_retur' => 'Menunggu Validasi'
                    // ]);

                    // Update stok sebelumnya menjadi history
                    $stok->update([
                        'keterangan_som' => $request->keterangan_som ?? '-',
                        'diterima_som' => 1,
                        'diterima_som_by' => auth()->user()->name,
                        'tanggal_diterima_som' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_som' => 'Tolak',
                        'keterangan_pm' => $request->keterangan_pm ?? '-',
                        'diterima_pm' => 1,
                        'diterima_pm_by' => '-',
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_pm' => 'Tolak',
                        'keterangan_dir' => $request->keterangan_dir ?? '-',
                        'diterima_dir' => 1,
                        'diterima_dir_by' => '-',
                        'tanggal_diterima_dir' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_dir' => 'Tolak',
                        'stok_update' => 0,
                        'history' => 1,
                        'history_id' => $stok->id
                    ]);
                }
            }

            toast('Data berhasil disimpan!', 'success');
            return Redirect::route('stok-material.pengajuan.index');
        }

        // Jika user memiliki permission validasi pm saat update
        if (auth()->user()->can('validasi_pm_stok_material') && $stok->diterima_som == 1) {

            // Jika update dengan check box validasi PM
            if (isset($request->diterima_pm) != null) {

                // Validasi
                $validator = Validator::make($request->all(), [
                    'status_validasi_pm' => 'required',
                ], ['status_validasi_pm.required' => 'status validasi wajib diisi.']);

                // Jika validasi gagal
                if ($validator->fails()) {
                    Session::flash('statusValidasiPM', 'error');
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
                        'stok_update' => 0,
                        'status_validasi_pm' => 'ACC',
                        'keterangan_pm' => $request->keterangan_pm ?? '-'
                    ]);
                }

                // Jika status ACC Sebagian
                if ($request->status_validasi_pm == 'ACC Sebagian') {

                    $validator = Validator::make($request->all(), [
                        'jumlahSebagianPM' => 'required',
                    ], ['jumlahSebagianPM.required' => 'jumlah wajib diisi.']);

                    // Jika validasi gagal
                    if ($validator->fails()) {
                        Session::flash('jumlahSebagianPM', 'error');
                        toast('Mohon periksa form kembali!', 'error'); // Toast
                        return Redirect::back()
                            ->withErrors($validator)
                            ->withInput(); // Return kembali membawa error dan old input
                    }

                    // Insert baru stok untuk List Stok Material dengan kolom history = 1
                    // $diterima = StokMaterial::create([
                    //     'material_id' => $stok->material_id,
                    //     'kode_material' => $stok->kode_material,
                    //     'nama_material' => $stok->nama_material,
                    //     'harga' => floatval(preg_replace('/[^\p{L}\p{N}\s]/u', '', $stok->harga)),
                    //     'masuk' => $request->jumlahSebagian,
                    //     'created_by' => 'System',
                    //     'diterima_pm' => 1,
                    //     'diterima_pm_by' => auth()->user()->name,
                    //     'status_validasi_pm' => 'ACC',
                    //     'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                    //     'keterangan' => '-',
                    //     'diterima_spv' => 1,
                    //     'diterima_spv_by' => $stok->diterima_spv_by,
                    //     'tanggal_diterima_spv' => $stok->tanggal_diterima_pm,
                    //     'stok_update' => $this->cekStokUpdateMaterial($request->kode_material) + $request->jumlahSebagian,
                    // ]);

                    // Insert retur
                    // Retur::create([
                    //     'stok_material_id' => $stok->id,
                    //     'diterima_id' => $diterima->id,
                    //     'kode_material' => $stok->kode_material,
                    //     'nama_material' => $stok->nama_material,
                    //     'tgl_retur' => null,
                    //     'status' => 'ACC Sebagian',
                    //     'keterangan' => $stok->keterangan,
                    //     'jumlah' => $stok->masuk - $diterima->masuk,
                    //     'created_by' => $stok->diterima_pm_by,
                    //     'hasil_retur' => 'Menunggu Validasi'
                    // ]);

                    // Update stok sebelumnya menjadi history
                    $stok->update([
                        'keterangan_pm' => $request->keterangan_pm ?? '-',
                        'sebagian_pm' => $request->jumlahSebagianPM,
                        'diterima_pm' => 1,
                        'diterima_pm_by' => auth()->user()->name,
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_pm' => 'ACC Sebagian',
                        'stok_update' => 0,
                    ]);
                }

                // Jika status Tolak
                if ($request->status_validasi_pm == 'Tolak') {

                    // Insert retur
                    // Retur::create([
                    //     'stok_material_id' => $stok->id,
                    //     'diterima_id' => $stok->id,
                    //     'kode_material' => $stok->kode_material,
                    //     'nama_material' => $stok->nama_material,
                    //     'tgl_retur' => null,
                    //     'status' => 'Tolak',
                    //     'keterangan' => $stok->keterangan,
                    //     'jumlah' => $stok->masuk,
                    //     'created_by' => $stok->diterima_pm_by,
                    //     'hasil_retur' => 'Menunggu Validasi'
                    // ]);

                    // Update stok sebelumnya menjadi history
                    $stok->update([
                        'keterangan_som' => $request->keterangan_som ?? '-',
                        'diterima_som' => 1,
                        'diterima_som_by' => $stok->diterima_som_by ?? '-',
                        'tanggal_diterima_som' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_som' => 'Tolak',
                        'keterangan_pm' => $request->keterangan_pm ?? '-',
                        'diterima_pm' => 1,
                        'diterima_pm_by' => auth()->user()->name,
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_pm' => 'Tolak',
                        'keterangan_dir' => $request->keterangan_dir ?? '-',
                        'diterima_dir' => 1,
                        'diterima_dir_by' => $stok->diterima_dir_by ?? '-',
                        'tanggal_diterima_dir' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_dir' => 'Tolak',
                        'stok_update' => 0,
                        'history' => 1,
                        'history_id' => $stok->id
                    ]);
                }

                toast('Data berhasil disimpan!', 'success');
                return Redirect::route('stok-material.pengajuan.index'); // Redirect kembali
            }
        }

        // Jika user memiliki permission validasi pm saat update
        if (auth()->user()->can('validasi_dir_stok_material') && $stok->diterima_pm == 1) {

            // Jika update dengan check box validasi DIR
            if (isset($request->diterima_dir) != null) {

                // Validasi
                $validator = Validator::make($request->all(), [
                    'status_validasi_dir' => 'required',
                ], ['status_validasi_dir.required' => 'status validasi wajib diisi.']);

                // Jika validasi gagal
                if ($validator->fails()) {
                    Session::flash('statusValidasiDIR', 'error');
                    toast('Mohon periksa form kembali!', 'error');
                    return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
                }

                // Jika status ACC
                if ($request->status_validasi_dir == 'ACC') {

                    if ($stok->sebagian_som != 0 && $stok->status_validasi_pm == "ACC") {
                        $stok->update([
                            'stok_update' => $this->cekStokUpdateMaterial($request->kode_material) + $stok->sebagian_som
                        ]);
                    } else if ($stok->sebagian_pm != 0 && $stok->status_validasi_pm == "ACC Sebagian") {
                        $stok->update([
                            'stok_update' => $this->cekStokUpdateMaterial($request->kode_material) + $stok->sebagian_pm
                        ]);
                    } else {
                        $stok->update([
                            'stok_update' => $this->cekStokUpdateMaterial($request->kode_material) + $request->masuk
                        ]);
                    }

                    $stok->update([
                        'keterangan_dir' => $request->keterangan_dir ?? '-',
                        'diterima_dir' => 1,
                        'diterima_dir_by' => auth()->user()->name,
                        'tanggal_diterima_dir' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_dir' => 'ACC',
                        'history' => 1,
                        'history_id' => $stok->id
                    ]);
                }

                // Jika status Tolak
                if ($request->status_validasi_dir == 'Tolak') {

                    // Insert retur
                    // Retur::create([
                    //     'stok_material_id' => $stok->id,
                    //     'diterima_id' => $stok->id,
                    //     'kode_material' => $stok->kode_material,
                    //     'nama_material' => $stok->nama_material,
                    //     'tgl_retur' => null,
                    //     'status' => 'Tolak',
                    //     'keterangan' => $stok->keterangan,
                    //     'jumlah' => $stok->masuk,
                    //     'created_by' => $stok->diterima_pm_by,
                    //     'hasil_retur' => 'Menunggu Validasi'
                    // ]);

                    // Update stok sebelumnya menjadi history
                    $stok->update([
                        'keterangan_som' => $request->keterangan_som ?? '-',
                        'diterima_som' => 1,
                        'diterima_som_by' => $stok->diterima_som_by ?? '-',
                        'tanggal_diterima_som' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_som' => 'Tolak',
                        'keterangan_pm' => $request->keterangan_pm ?? '-',
                        'diterima_pm' => 1,
                        'diterima_pm_by' => $stok->diterima_pm_by ?? '-',
                        'tanggal_diterima_pm' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_pm' => 'Tolak',
                        'keterangan_dir' => $request->keterangan_dir ?? '-',
                        'diterima_dir' => 1,
                        'diterima_dir_by' => auth()->user()->name,
                        'tanggal_diterima_dir' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_dir' => 'Tolak',
                        'stok_update' => 0,
                        'history' => 1,
                        'history_id' => $stok->id
                    ]);
                }

                toast('Data berhasil disimpan!', 'success');
                return Redirect::route('stok-material.pengajuan.index'); // Redirect kembali
            }
        } else {
            toast('Data berhasil disimpan!', 'success');
            return Redirect::route('stok-material.pengajuan.index'); // Redirect kembali
        }
    }

    public function cekStokUpdateMaterial($kode_material)
    {
        $stokLatest = StokMaterial::where('kode_material', $kode_material)
            ->where('status_validasi_dir', 'ACC')
            ->whereNot('diterima_pm', 0)
            ->whereNot('diterima_som', 0)
            ->whereNot('diterima_dir', 0)
            ->latest()
            ->first();

        if ($stokLatest == null) {
            return 0;
        }

        return $stokLatest->stok_update;
    }

    public function deletePengajuan($id)
    {
        $stok = StokMaterial::where('id', $id)->first();
        $stok->delete();

        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('stok-material.pengajuan.index'); // Redirect kembali
    }

    private function getKodeMaterialSaniter($kodeMaterial)
    {
        $count = StokMaterial::where('kode_material', 'like', '%' . $kodeMaterial . '%')->count();
        return $kodeMaterial . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    public function prestasiPhisik()
    {
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
        return view('material.prestasi-phisik', compact('bulan'));
    }

    public function laporanMaterial()
    {
        $stokMaterial = StokMaterial::select('id', 'kode_material', 'nama_material', 'harga', 'stok_update')
            ->where('diterima_som', 1)
            ->where('diterima_pm', 1)
            ->where('diterima_dir', 1)
            ->where('status_validasi_dir', 'ACC')
            ->whereNot('status_validasi_dir', 'Tolak')
            ->groupBy('kode_material')
            ->get();

        return view('material.material', compact('stokMaterial'));
    }

    public function printList(Request $request)
    {
        $stokMaterial = StokMaterial::select('material_id', 'kode_material', 'nama_material', 'harga', 'stok_update', 'masuk', 'diterima_pm', 'tanggal_diterima_pm', 'diterima_som', 'tanggal_diterima_som', 'diterima_dir', 'tanggal_diterima_dir')
            ->where('diterima_som', 1)
            ->where('diterima_pm', 1)
            ->where('diterima_dir', 1)
            ->where('status_validasi_dir', 'ACC')
            ->whereNot('status_validasi_dir', 'Tolak')
            ->orderBy('id', 'DESC');

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $stokMaterial->whereBetween('tanggal_diterima_dir', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')]);
        }

        if ($request->checkAll != "on" && !empty($request->kode_material)) {
            $stokMaterial->where('kode_material', $request->kode_material);
        }

        $data = $stokMaterial->latest()->get()->unique('kode_material');

        $pdf = Pdf::loadView('components.print-layouts.material.model1', ['list' => $data, 'start' => Carbon::createFromFormat('d/m/Y', $request->start_date)->isoFormat('D MMMM Y'), 'end' => Carbon::createFromFormat('d/m/Y', $request->end_date)->isoFormat('D MMMM Y')])->setPaper('a4');
        return $pdf->stream('list_material_(' . Carbon::createFromFormat('d/m/Y', $request->start_date)->isoFormat('D MMMM Y') . ' - ' . Carbon::createFromFormat('d/m/Y', $request->end_date)->isoFormat('D MMMM Y') . '.pdf');
    }

    public function prestasiPhisikModel1(Request $request)
    {
        $awalMinggu = Carbon::now()->month($request->bulan)->year($request->tahun)->startOfMonth()->addWeeks($request->mingguKe - 1)->startOfWeek(Carbon::MONDAY);
        $akhirMinggu = Carbon::now()->month($request->bulan)->year($request->tahun)->startOfMonth()->addWeeks($request->mingguKe - 1)->endOfWeek(Carbon::SUNDAY);

        $awalBulan = Carbon::now()->month($request->bulan)->year($request->tahun)->startOfMonth();
        $akhirBulan = Carbon::now()->month($request->bulan)->year($request->tahun)->endOfMonth();

        if ($awalMinggu->format('d') != '01') {
            $awalMinggu = $awalBulan;
        }

        if ($akhirMinggu->greaterThan($akhirBulan)) {
            $akhirMinggu = $akhirBulan;
        }

        $dataItemPekerjaan = array();

        $kategori_pekerjaan = KategoriPekerjaan::all();

        $dataKategori = array();
        foreach ($kategori_pekerjaan as $kategori) {
            $dataSubKategori = array();
            $sub_pekerjaan = SubKategoriPekerjaan::where('id_kategori_pekerjaan', $kategori->id)->get();

            foreach ($sub_pekerjaan as $sub) {
                $dataItemPekerjaan = array();
                $item_pekerjaan = ItemPekerjaan::where('id_sub_kategori_pekerjaan', $sub->id)->get();

                foreach ($item_pekerjaan as $item) {

                    $total = 0;

                    $itemPekerjaan = DetailItemPekerjaan::where('detail_item_pekerjaan.item_pekerjaan_id', $item->id)
                        ->join('jenis_kerusakan', 'detail_item_pekerjaan.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                        ->join('item_pekerjaan', 'detail_item_pekerjaan.item_pekerjaan_id', '=', 'item_pekerjaan.id')
                        ->whereBetween('jenis_kerusakan.tgl_selesai_pekerjaan', [$awalMinggu, $akhirMinggu])
                        ->get();

                    foreach ($itemPekerjaan as $ip) {
                        $total += floatval($total) + floatval($ip->volume);
                    }

                    $i['volume'] = str_replace(".", ",", $item->volume);
                    $i['satuan'] = $item->satuan;
                    $i['harga'] = number_format($item->harga, 0, '', '');
                    $i['totalMingguDipilih'] = str_replace(".", ",", floatval($total));
                    $i['totalHargaDipilih'] = floatval($i['totalMingguDipilih']) * $i['harga'];

                    $dataItemPekerjaan[$item->nama] = $i;
                }

                $dataSubKategori[$sub->nama] = $dataItemPekerjaan;
            }
            $dataKategori[$kategori->nama] = $dataSubKategori;
        }

        if ($request->sertakan_qtech == "on") {
            $stokMaterial = StokMaterial::select('material_id', 'kode_material', 'nama_material', 'harga', 'stok_update', 'masuk', 'diterima_pm', 'tanggal_diterima_pm', 'diterima_som', 'tanggal_diterima_som', 'diterima_dir', 'tanggal_diterima_dir')
                ->where('kategori', 'QTECH')
                ->where('diterima_som', 1)
                ->where('diterima_pm', 1)
                ->where('diterima_dir', 1)
                ->where('status_validasi_dir', 'ACC')
                ->whereNot('status_validasi_dir', 'Tolak')
                ->orderBy('id', 'DESC')
                ->get();

            foreach ($stokMaterial as $stok) {
                $total = 0;

                $detailJenisKerusakan = DetailJenisKerusakan::select('detail_jenis_kerusakan.volume', 'detail_jenis_kerusakan.satuan', 'detail_jenis_kerusakan.harga', 'stok_material.nama_material')
                    ->join('jenis_kerusakan', 'detail_jenis_kerusakan.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                    ->join('stok_material', 'detail_jenis_kerusakan.kode_material', '=', 'stok_material.kode_material')
                    ->whereBetween('jenis_kerusakan.tgl_selesai_pekerjaan', [$awalMinggu, $akhirMinggu])
                    ->where('detail_jenis_kerusakan.kode_material', $stok->kode_material)
                    ->get();

                foreach ($detailJenisKerusakan as $jenisKerusakan) {
                    $total += floatval($total) + floatval($jenisKerusakan->volume);
                }

                $i['volume'] = '1,00';
                $i['satuan'] = $stok->satuan;
                $i['harga'] = number_format($stok->harga, 0, '', '');
                $i['totalMingguDipilih'] = str_replace(".", ",", floatval($total));
                $i['totalHargaDipilih'] = floatval($i['totalMingguDipilih']) * $i['harga'];

                $dataKategori['Perlengkapan Material Q-TECH']['Material'][$stok->nama_material] = $i;
            }
        }

        $namaMaterial = NamaMaterial::all();

        foreach ($namaMaterial as $stok) {
            $total = 0;

            $detailJenisKerusakan = DetailJenisKerusakan::select('detail_jenis_kerusakan.volume', 'detail_jenis_kerusakan.satuan', 'detail_jenis_kerusakan.harga', 'detail_jenis_kerusakan.kode_material')
                ->join('jenis_kerusakan', 'detail_jenis_kerusakan.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                ->whereBetween('jenis_kerusakan.tgl_selesai_pekerjaan', [$awalMinggu, $akhirMinggu])
                ->get();

            foreach ($detailJenisKerusakan as $jenisKerusakan) {

                $kode_baru = preg_replace('/-\d+$/', '', $jenisKerusakan->kode_material);

                // array_push($kode_baru, $p);
                // dd($kode_baru);

                if ($kode_baru == $stok->kode_material) {
                    $total += floatval($total) + floatval($jenisKerusakan->volume);
                }
            }

            $i['volume'] = '1,00';
            $i['satuan'] = $stok->satuan;
            $i['harga'] = number_format($stok->harga, 0, '', '');
            $i['totalMingguDipilih'] = str_replace(".", ",", floatval($total));
            $i['totalHargaDipilih'] = floatval($i['totalMingguDipilih']) * $i['harga'];

            $dataKategori['Perlengkapan Material'][$stok->kategori_material][ucwords(strtolower($stok->nama_material))] = $i;
        }

        $peralatan = Peralatan::all();

        foreach ($peralatan as $prltn) {
            $total = 0;

            $detailPeralatan = DetailPeralatan::select('detail_peralatan.volume', 'detail_peralatan.satuan', 'detail_peralatan.harga', 'peralatan.nama_peralatan')
                ->join('jenis_kerusakan', 'detail_peralatan.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                ->join('peralatan', 'detail_peralatan.peralatan_id', '=', 'peralatan.id')
                ->whereBetween('jenis_kerusakan.tgl_selesai_pekerjaan', [$awalMinggu, $akhirMinggu])
                ->where('detail_peralatan.peralatan_id', $prltn->id)
                ->get();

            foreach ($detailPeralatan as $peralatan) {
                $total += floatval($total) + floatval($peralatan->volume);
            }

            $i['volume'] = '1,00';
            $i['satuan'] = $prltn->satuan;
            $i['harga'] = number_format($prltn->harga, 0, '', '');
            $i['totalMingguDipilih'] = str_replace(".", ",", floatval($total));
            $i['totalHargaDipilih'] = floatval($i['totalMingguDipilih']) * $i['harga'];

            $dataKategori['Peralatan']['Peralatan'][$prltn->nama_peralatan] = $i;
        }

        $pekerja = Pekerja::all();

        foreach ($pekerja as $pkj) {
            $total = 0;

            $detailPekerja = DetailPekerja::select('detail_pekerja.volume', 'detail_pekerja.satuan', 'detail_pekerja.upah', 'pekerja.nama')
                ->join('jenis_kerusakan', 'detail_pekerja.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                ->join('pekerja', 'detail_pekerja.pekerja_id', '=', 'pekerja.id')
                ->whereBetween('jenis_kerusakan.tgl_selesai_pekerjaan', [$awalMinggu, $akhirMinggu])
                ->where('detail_pekerja.pekerja_id', $pkj->id)
                ->get();

            foreach ($detailPekerja as $pekerja) {
                $total += floatval($total) + floatval($pekerja->volume);
            }

            $i['volume'] = '1,00';
            $i['satuan'] = $pkj->satuan;
            $i['harga'] = number_format($pkj->upah, 0, '', '');
            $i['totalMingguDipilih'] = str_replace(".", ",", floatval($total));
            $i['totalHargaDipilih'] = floatval($i['totalMingguDipilih']) * $i['harga'];

            $dataKategori['Upah']['Upah'][$pkj->nama] = $i;
        }

        $pdf = Pdf::loadView('components.print-layouts.material.prestasi-phisik', ['list' => $dataKategori, 'start' => $awalMinggu, 'end' => $akhirMinggu, 'mingguKe' => $request->mingguKe])->setPaper('a4');
        return $pdf->stream('prestasi-phisik(' . $awalMinggu . ' - ' . $akhirMinggu . '.pdf', array("Attachment" => true));
    }

    // public function printPengajuan(Request $request)
    // {
    //     $stokMaterial = StokMaterial::select('material_id', 'kode_material', 'nama_material', 'harga', 'masuk', 'diterima_pm', 'tanggal_diterima_pm', 'diterima_spv', 'tanggal_diterima_spv')
    //         ->where('diterima_pm', 0)
    //         ->orWhere('history', 1)
    //         ->orderBy('history', 'ASC')
    //         ->orderBy('id', 'DESC');

    //     if (!empty($request->start_date) && !empty($request->end_date)) {
    //         $stokMaterial->whereBetween('tanggal_diterima_pm', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')]);
    //     }

    //     $data = $stokMaterial->get();

    //     dd($data);

    //     $pdf = Pdf::loadView('components.print-layouts.material.model2', ['list' => $data, 'start' => Carbon::createFromFormat('d/m/Y', $request->start_date)->isoFormat('D MMMM Y'), 'end' => Carbon::createFromFormat('d/m/Y', $request->end_date)->isoFormat('D MMMM Y')])->setPaper('a4');
    //     return $pdf->stream('list_material_(' . Carbon::createFromFormat('d/m/Y', $request->start_date)->isoFormat('D MMMM Y') . ' - ' . Carbon::createFromFormat('d/m/Y', $request->end_date)->isoFormat('D MMMM Y') . '.pdf');
    // }
}
