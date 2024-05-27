<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\User;
use App\Models\Pekerja;
use App\Models\AreaList;
use App\Models\TglKerja;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use App\Models\DetailPekerja;
use App\Models\FotoKerusakan;
use App\Models\ItemPekerjaan;
use App\Models\DetailTglKerja;
use App\Models\HistoryPekerja;
use App\Models\JenisKerusakan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Api\NamaMaterial;
use App\Models\DetailItemPekerjaan;
use App\Models\HistoryStokMaterial;
use App\Models\DetailJenisKerusakan;
use App\Models\HistoryPrestasiPhisik;
use Intervention\Image\Facades\Image;
use App\Models\LogHistoryStokMaterial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class JenisKerusakanController extends Controller
{
    public function index($id)
    {
        $detailKerja = DetailTglKerja::select('detail_tgl_kerja.id', 'detail_tgl_kerja.tgl_kerja_id', 'detail_tgl_kerja.list_area_id', 'tgl_kerja.created_at')->join('tgl_kerja', 'detail_tgl_kerja.tgl_kerja_id', '=', 'tgl_kerja.id')->find($id);

        $area = AreaList::select('list_area.id', 'lantai', 'list_area.nama as listNama', 'denah', 'area.nama as areaNama')
            ->join('area', 'list_area.area_id', '=', 'area.id')
            ->where('list_area.id', $detailKerja->list_area_id)
            ->first();

        $jenisKerusakan = JenisKerusakan::select('users.name', 'users.foto as userFoto', 'jenis_kerusakan.*')
            ->where('detail_tgl_kerja_id', $detailKerja->id)
            ->join('users', 'jenis_kerusakan.dikerjakan_oleh', '=', 'users.id')
            ->orderBy('id', 'DESC')
            ->get();

        $jenisKerusakan = $this->cekAdaItemPekerjaan($jenisKerusakan);

        return view('proyek.jenis-kerusakan.index', compact('detailKerja', 'area', 'jenisKerusakan'));
    }

    public function create($id)
    {
        $pekerja = Pekerja::all();

        $itemPekerjaan = ItemPekerjaan::all();

        $teknisi = User::select('users.id', 'users.name')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('regional_id', auth()->user()->regional_id)
            ->where('roles.name', 'Teknisi')
            ->get();

        $detailKerja = DetailTglKerja::select('detail_tgl_kerja.id', 'list_area.denah', 'list_area.lantai', 'list_area.nama')
            ->join('list_area', 'detail_tgl_kerja.list_area_id', '=', 'list_area.id')
            ->find($id);

        $stokMaterial = StokMaterial::select('id', 'kode_material', 'nama_material', 'harga', 'stok_update')
            ->where('diterima_som', 1)
            ->where('diterima_pm', 1)
            ->where('diterima_dir', 1)
            ->where('status_validasi_dir', 'ACC')
            ->where('status_validasi_som', '<>', 'Tolak')
            ->where('status_validasi_pm', '<>', 'Tolak')
            ->groupBy('kode_material')
            ->get();

        return view('proyek.jenis-kerusakan.create', compact('detailKerja', 'stokMaterial', 'teknisi', 'pekerja', 'itemPekerjaan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status_kerusakan' => 'required',
            'perbaikan' => 'required',
            'foto' => 'required|mimes:png,jpg,jpeg',
            'nomor_denah' => 'required'
        ]);

        if ($request->nama_material && $request->satuan && $request->volume) {
            $validator2 = Validator::make($request->all(), [
                'nama_material' => 'required',
                'satuan' => '',
                'volume' => 'required',
            ]);

            // Jika validasi gagal
            if ($validator2->fails()) {
                toast('Mohon periksa form kembali!', 'error'); // Toast
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput(); // Return kembali membawa error dan old input
            }
        }

        if ($request->nama_pekerja && $request->satuan_pekerja && $request->volume_pekerja) {
            $validator3 = Validator::make($request->all(), [
                'nama_pekerja' => 'required',
                'satuan_pekerja' => '',
                'volume_pekerja' => 'required',
            ]);

            // Jika validasi gagal
            if ($validator3->fails()) {
                toast('Mohon periksa form kembali!', 'error'); // Toast
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput(); // Return kembali membawa error dan old input
            }
        }

        if ($request->item_pekerjaan && $request->satuan_item_pekerjaan && $request->volume_item_pekerjaan) {
            $validator4 = Validator::make($request->all(), [
                'item_pekerjaan' => 'required',
                'satuan_item_pekerjaan' => '',
                'volume_item_pekerjaan' => 'required',
            ]);

            // Jika validasi gagal
            if ($validator4->fails()) {
                toast('Mohon periksa form kembali!', 'error'); // Toast
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput(); // Return kembali membawa error dan old input
            }
        }

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $jenisKerusakan = JenisKerusakan::create([
            'detail_tgl_kerja_id' => $request->detail_tgl_kerja_id,
            'foto' => $this->imageStore($request->file('foto'), $request->perbaikan),
            'nama_kerusakan' => $request->perbaikan,
            'deskripsi' => $request->deskripsi ?? '-',
            'nomor_denah' => $request->nomor_denah,
            'tgl_selesai_pekerjaan' => null,
            'status_kerusakan' => $request->status_kerusakan,
            'dikerjakan_oleh' => $request->dikerjakan_oleh,
            'created_by' => auth()->user()->id,
        ]);

        if ($request->nama_material != null) {
            foreach ($request->nama_material as $key => $item) {
                DetailJenisKerusakan::create([
                    'jenis_kerusakan_id' => $jenisKerusakan->id,
                    'kode_material' => $item,
                    'nama' => $request->perbaikan,
                    'harga' => floatval($this->getHargaStokMaterial($item)),
                    'volume' => $request->volume[$key] ?? '0',
                    'satuan' => $request->satuan[$key] ?? '0',
                    'total_harga' => floatval($this->getHargaStokMaterial($item)) * floatval($request->volume[$key]),
                ]);
            }
        }

        if ($request->nama_pekerja != null) {
            foreach ($request->nama_pekerja as $key => $item) {
                DetailPekerja::create([
                    'jenis_kerusakan_id' => $jenisKerusakan->id,
                    'pekerja_id' => $item,
                    'nama' => $request->perbaikan,
                    'upah' => floatval($this->getUpahPekerja($item)),
                    'volume' => $request->volume_pekerja[$key] ?? '0',
                    'satuan' => $request->satuan_pekerja[$key] ?? '0',
                    'total_harga' => floatval($this->getUpahPekerja($item)) * floatval($request->volume_pekerja[$key]),
                ]);
            }
        }

        if ($request->item_pekerjaan != null) {
            foreach ($request->item_pekerjaan as $key => $item) {
                DetailItemPekerjaan::create([
                    'jenis_kerusakan_id' => $jenisKerusakan->id,
                    'item_pekerjaan_id' => $item,
                    'nama' => $request->perbaikan,
                    'harga' => floatval($this->getHargaItemPekerjaan($item)),
                    'volume' => $request->volume_item_pekerjaan[$key] ?? '0',
                    'satuan' => $request->satuan_item_pekerjaan[$key] ?? '0',
                    'total_harga' => floatval($this->getHargaItemPekerjaan($item)) * floatval($request->volume_item_pekerjaan[$key]),
                ]);
            }
        }

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('jenis-kerusakan.detail', $jenisKerusakan->id);
    }

    public function detail($id)
    {
        $cekDetail = DetailJenisKerusakan::where('jenis_kerusakan_id', $id)->first();

        if ($cekDetail != null) {
            $detail = DetailJenisKerusakan::select('detail_jenis_kerusakan.*', 'jenis_kerusakan.detail_tgl_kerja_id as detailKerjaID', 'jenis_kerusakan.foto', 'jenis_kerusakan.nama_kerusakan', 'jenis_kerusakan.deskripsi', 'jenis_kerusakan.nomor_denah', 'jenis_kerusakan.tgl_selesai_pekerjaan', 'jenis_kerusakan.status_kerusakan', 'jenis_kerusakan.dikerjakan_oleh', 'jenis_kerusakan.created_at as jenisCreatedAt', 'users.name', 'users.foto as userFoto')
                ->join('jenis_kerusakan', 'detail_jenis_kerusakan.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                ->join('users', 'jenis_kerusakan.dikerjakan_oleh', '=', 'users.id')
                ->where('detail_jenis_kerusakan.jenis_kerusakan_id', $id)
                ->first();
        } else {
            $detail = JenisKerusakan::select('jenis_kerusakan.id as jenisKerusakanID', 'jenis_kerusakan.*', 'detail_tgl_kerja.id as detailKerjaID', 'list_area.denah')
                ->where('jenis_kerusakan.id', $id)
                ->join('detail_tgl_kerja', 'jenis_kerusakan.detail_tgl_kerja_id', '=', 'detail_tgl_kerja.id')
                ->join('list_area', 'detail_tgl_kerja.list_area_id', '=', 'list_area.id')
                ->first();
        }

        $detailMaterial = DetailJenisKerusakan::select('detail_jenis_kerusakan.*')
            ->where('jenis_kerusakan_id', $id)
            ->get();

        $detailPekerja = DetailPekerja::where('jenis_kerusakan_id', $id)->get();

        $detailItemPekerjaan = DetailItemPekerjaan::where('jenis_kerusakan_id', $id)->get();

        $pekerja = Pekerja::all();

        $itemPekerjaans = ItemPekerjaan::all();

        $teknisi = User::select('users.id', 'users.name')->join('roles', 'users.role_id', '=', 'roles.id')->where('roles.name', 'Teknisi')->get();

        $jenisKerusakan = JenisKerusakan::select('jenis_kerusakan.id as jenisKerusakanID', 'detail_tgl_kerja.id as detailKerjaID', 'list_area.lantai', 'list_area.nama', 'list_area.denah', 'jenis_kerusakan.tgl_selesai_pekerjaan')
            ->where('jenis_kerusakan.id', $id)
            ->join('detail_tgl_kerja', 'jenis_kerusakan.detail_tgl_kerja_id', '=', 'detail_tgl_kerja.id')
            ->join('list_area', 'detail_tgl_kerja.list_area_id', '=', 'list_area.id')
            ->first();

        $stokMaterial = StokMaterial::select('id', 'kode_material', 'nama_material', 'harga', 'stok_update')
            ->where('diterima_som', 1)
            ->where('diterima_pm', 1)
            ->where('diterima_dir', 1)
            ->where('status_validasi_dir', 'ACC')
            ->where('status_validasi_som', '<>', 'Tolak')
            ->where('status_validasi_pm', '<>', 'Tolak')
            ->groupBy('kode_material')
            ->get();

        return view('proyek.jenis-kerusakan.detail', compact('detail', 'detailPekerja', 'detailItemPekerjaan', 'detailMaterial', 'teknisi', 'stokMaterial', 'jenisKerusakan', 'pekerja', 'itemPekerjaans'));
    }

    public function edit($id)
    {
        $cekDetail = DetailJenisKerusakan::where('jenis_kerusakan_id', $id)->first();

        if ($cekDetail != null) {
            $detail = DetailJenisKerusakan::select('detail_jenis_kerusakan.*', 'jenis_kerusakan.detail_tgl_kerja_id as detailKerjaID', 'jenis_kerusakan.foto', 'jenis_kerusakan.nama_kerusakan', 'jenis_kerusakan.deskripsi', 'jenis_kerusakan.nomor_denah', 'jenis_kerusakan.tgl_selesai_pekerjaan', 'jenis_kerusakan.status_kerusakan', 'jenis_kerusakan.dikerjakan_oleh', 'jenis_kerusakan.created_at as jenisCreatedAt', 'users.name', 'users.foto as userFoto')
                ->join('jenis_kerusakan', 'detail_jenis_kerusakan.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                ->join('users', 'jenis_kerusakan.dikerjakan_oleh', '=', 'users.id')
                ->where('detail_jenis_kerusakan.jenis_kerusakan_id', $id)
                ->first();
        } else {
            $detail = JenisKerusakan::select('jenis_kerusakan.id as jenisKerusakanID', 'jenis_kerusakan.*', 'detail_tgl_kerja.id as detailKerjaID', 'list_area.denah')
                ->where('jenis_kerusakan.id', $id)
                ->join('detail_tgl_kerja', 'jenis_kerusakan.detail_tgl_kerja_id', '=', 'detail_tgl_kerja.id')
                ->join('list_area', 'detail_tgl_kerja.list_area_id', '=', 'list_area.id')
                ->first();
        }

        $detailMaterial = DetailJenisKerusakan::select('detail_jenis_kerusakan.*')
            ->where('jenis_kerusakan_id', $id)
            ->get();

        $detailPekerja = DetailPekerja::where('jenis_kerusakan_id', $id)->get();

        $detailItemPekerjaan = DetailItemPekerjaan::where('jenis_kerusakan_id', $id)->get();

        $pekerja = Pekerja::all();

        $itemPekerjaans = ItemPekerjaan::all();

        $teknisi = User::select('users.id', 'users.name')->join('roles', 'users.role_id', '=', 'roles.id')->where('roles.name', 'Teknisi')->get();

        $jenisKerusakan = JenisKerusakan::select('jenis_kerusakan.id as jenisKerusakanID', 'detail_tgl_kerja.id as detailKerjaID', 'list_area.lantai', 'list_area.nama', 'list_area.denah', 'jenis_kerusakan.tgl_selesai_pekerjaan')
            ->where('jenis_kerusakan.id', $id)
            ->join('detail_tgl_kerja', 'jenis_kerusakan.detail_tgl_kerja_id', '=', 'detail_tgl_kerja.id')
            ->join('list_area', 'detail_tgl_kerja.list_area_id', '=', 'list_area.id')
            ->first();

        $stokMaterial = StokMaterial::select('id', 'kode_material', 'nama_material', 'harga', 'stok_update')
            ->where('diterima_som', 1)
            ->where('diterima_pm', 1)
            ->where('diterima_dir', 1)
            ->where('status_validasi_dir', 'ACC')
            ->where('status_validasi_som', '<>', 'Tolak')
            ->where('status_validasi_pm', '<>', 'Tolak')
            ->groupBy('kode_material')
            ->get();

        return view('proyek.jenis-kerusakan.edit', compact('detail', 'detailPekerja', 'detailItemPekerjaan',  'detailMaterial', 'teknisi', 'stokMaterial', 'jenisKerusakan', 'pekerja', 'itemPekerjaans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status_kerusakan' => 'required',
            'perbaikan' => 'required',
            'foto' => 'mimes:png,jpg,jpeg',
            'nomor_denah' => 'required',
        ]);

        if ($request->nama_material && $request->satuan && $request->volume) {
            $validator2 = Validator::make($request->all(), [
                'nama_material' => 'required',
                'satuan' => '',
                'volume' => 'required',
            ]);

            // Jika validasi gagal
            if ($validator2->fails()) {
                toast('Mohon periksa form kembali!', 'error'); // Toast
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput(); // Return kembali membawa error dan old input
            }
        }

        if ($request->nama_pekerja && $request->satuan_pekerja && $request->volume_pekerja) {
            $validator3 = Validator::make($request->all(), [
                'nama_pekerja' => 'required',
                'satuan_pekerja' => '',
                'volume_pekerja' => 'required',
            ]);

            // Jika validasi gagal
            if ($validator3->fails()) {
                toast('Mohon periksa form kembali!', 'error'); // Toast
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput(); // Return kembali membawa error dan old input
            }
        }

        if ($request->item_pekerjaan && $request->satuan_item_pekerjaan && $request->volume_item_pekerjaan) {
            $validator4 = Validator::make($request->all(), [
                'item_pekerjaan' => 'required',
                'satuan_item_pekerjaan' => '',
                'volume_item_pekerjaan' => 'required',
            ]);

            // Jika validasi gagal
            if ($validator4->fails()) {
                toast('Mohon periksa form kembali!', 'error'); // Toast
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput(); // Return kembali membawa error dan old input
            }
        }

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        if ($request->cekFoto == "false") {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors(['foto_kerusakan' => 'foto kerusakan wajib diisi'])
                ->withInput(); // Return kembali membawa error dan old input
        }

        $jenisKerusakan = JenisKerusakan::find($id);

        $foto = $jenisKerusakan->foto;
        if ($request->file('foto') != null) {
            $foto = $this->imageStore($request->file('foto'), $request->perbaikan, $jenisKerusakan);
        }

        if ($request->btnStatus == "simpanPerubahan") {
            $data = [
                'dikerjakan_oleh' => $request->dikerjakan_oleh,
                'tgl_pengerjaan' => $request->tgl_pengerjaan,
                'nama_kerusakan' => $request->perbaikan,
                'deskripsi' => $request->deskripsi ?? '-',
                'nomor_denah' => $request->nomor_denah,
                'foto' => $foto,
            ];

            if ($request->nama_material != null) {
                DetailJenisKerusakan::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
                foreach ($request->nama_material as $key => $item) {
                    DetailJenisKerusakan::create([
                        'jenis_kerusakan_id' => $jenisKerusakan->id,
                        'kode_material' => $item,
                        'nama' => $request->perbaikan,
                        'harga' => $this->getHargaStokMaterial($item),
                        'volume' => $request->volume[$key] ?? '0',
                        'satuan' => $request->satuan[$key] ?? '0',
                        'total_harga' => floatval($this->getHargaStokMaterial($item)) * floatval($request->volume[$key]),
                    ]);
                }
                $data['status_kerusakan'] = $request->status_kerusakan;
            } else {
                DetailJenisKerusakan::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
                $data['status_kerusakan'] = 'Tanpa Material';
            }

            if ($request->nama_pekerja != null) {
                DetailPekerja::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
                foreach ($request->nama_pekerja as $key => $item) {
                    DetailPekerja::create([
                        'jenis_kerusakan_id' => $jenisKerusakan->id,
                        'pekerja_id' => $item,
                        'nama' => $request->perbaikan,
                        'upah' => floatval($this->getUpahPekerja($item)),
                        'volume' => $request->volume_pekerja[$key] ?? '0',
                        'satuan' => $request->satuan_pekerja[$key] ?? '0',
                        'total_harga' => floatval($this->getUpahPekerja($item)) * floatval($request->volume_pekerja[$key]),
                    ]);
                }
            } else {
                DetailPekerja::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
            }

            if ($request->item_pekerjaan != null) {
                DetailItemPekerjaan::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
                foreach ($request->item_pekerjaan as $key => $item) {
                    DetailItemPekerjaan::create([
                        'jenis_kerusakan_id' => $jenisKerusakan->id,
                        'item_pekerjaan_id' => $item,
                        'nama' => $request->perbaikan,
                        'harga' => floatval($this->getHargaItemPekerjaan($item)),
                        'volume' => $request->volume_item_pekerjaan[$key] ?? '0',
                        'satuan' => $request->satuan_item_pekerjaan[$key] ?? '0',
                        'total_harga' => floatval($this->getHargaItemPekerjaan($item)) * floatval($request->volume_item_pekerjaan[$key]),
                    ]);
                }
            } else {
                DetailItemPekerjaan::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
            }

            $jenisKerusakan->update($data);
        } else if ($request->btnStatus == "simpanPerubahanSOM") {
            $data = [
                'dikerjakan_oleh' => $request->dikerjakan_oleh,
                'tgl_pengerjaan' => $request->tgl_pengerjaan,
                'nama_kerusakan' => $request->perbaikan,
                'deskripsi' => $request->deskripsi ?? '-',
                'nomor_denah' => $request->nomor_denah,
                'foto' => $foto,
            ];

            if ($request->nama_material != null) {
                $this->kembalikanStokMaterial($jenisKerusakan->id);

                DetailJenisKerusakan::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
                foreach ($request->nama_material as $key => $item) {
                    $detailKerusakan = DetailJenisKerusakan::create([
                        'jenis_kerusakan_id' => $jenisKerusakan->id,
                        'kode_material' => $item,
                        'nama' => $request->perbaikan,
                        'harga' => $this->getHargaStokMaterial($item),
                        'volume' => $request->volume[$key] ?? '0',
                        'satuan' => $request->satuan[$key] ?? '0',
                        'total_harga' => floatval($this->getHargaStokMaterial($item)) * floatval($request->volume[$key])
                    ]);

                    HistoryStokMaterial::create([
                        'kode_material' => $item,
                        'detail_jenis_kerusakan_id' => $detailKerusakan->id,
                        'tanggal' => Carbon::now(),
                        'volume' => $request->volume[$key] ?? '0',
                        'satuan' => $request->satuan[$key] ?? '0',
                    ]);
                    $data['status_kerusakan'] = $request->status_kerusakan;
                    $this->setStokUpdate($item, $request->volume[$key]);
                }
            } else {
                $this->kembalikanStokMaterial($jenisKerusakan->id);
                DetailJenisKerusakan::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
                $data['status_kerusakan'] = 'Tanpa Material';
            }

            if ($request->nama_pekerja != null) {
                $getPekerja = DetailPekerja::where('jenis_kerusakan_id', $jenisKerusakan->id)->get();

                foreach ($getPekerja as $i) {
                    HistoryPekerja::where('detail_pekerja_id', $i->id)->delete();
                    DetailPekerja::find($i->id)->delete();
                }

                foreach ($request->nama_pekerja as $key => $item) {
                    $detailPekerja = DetailPekerja::create([
                        'jenis_kerusakan_id' => $jenisKerusakan->id,
                        'pekerja_id' => $item,
                        'nama' => $request->perbaikan,
                        'upah' => floatval($this->getUpahPekerja($item)),
                        'volume' => $request->volume_pekerja[$key] ?? '0',
                        'satuan' => $request->satuan_pekerja[$key] ?? '0',
                        'total_harga' => floatval($this->getUpahPekerja($item)) * floatval($request->volume_pekerja[$key]),
                    ]);

                    HistoryPekerja::create([
                        'pekerja_id' => $item,
                        'detail_pekerja_id' => $detailPekerja->id,
                        'tanggal' => Carbon::now(),
                        'volume' => $request->volume_pekerja[$key] ?? '0',
                        'satuan' => $request->satuan_pekerja[$key] ?? '0',
                    ]);
                }
            } else {
                $getPekerja = DetailPekerja::where('jenis_kerusakan_id', $jenisKerusakan->id)->get();

                foreach ($getPekerja as $i) {
                    HistoryPekerja::where('detail_pekerja_id', $i->id)->delete();
                    DetailPekerja::find($i->id)->delete();
                }
            }

            if ($request->item_pekerjaan != null) {
                $getItemPekerjaan = DetailItemPekerjaan::where('jenis_kerusakan_id', $jenisKerusakan->id)->get();

                foreach ($getItemPekerjaan as $i) {
                    HistoryPrestasiPhisik::where('detail_item_pekerjaan_id', $i->id)->delete();
                    DetailItemPekerjaan::find($i->id)->delete();
                }

                foreach ($request->item_pekerjaan as $key => $item) {
                    $detailItemPekerjaan = DetailItemPekerjaan::create([
                        'jenis_kerusakan_id' => $jenisKerusakan->id,
                        'item_pekerjaan_id' => $item,
                        'nama' => $request->perbaikan,
                        'harga' => floatval($this->getHargaItemPekerjaan($item)),
                        'volume' => $request->volume_item_pekerjaan[$key] ?? '0',
                        'satuan' => $request->satuan_item_pekerjaan[$key] ?? '0',
                        'total_harga' => floatval($this->getHargaItemPekerjaan($item)) * floatval($request->volume_item_pekerjaan[$key]),
                    ]);

                    HistoryPrestasiPhisik::create([
                        'item_pekerjaan_id' => $item,
                        'detail_item_pekerjaan_id' => $detailItemPekerjaan->id,
                        'tanggal' => Carbon::now(),
                        'volume' => $request->volume_item_pekerjaan[$key] ?? '0',
                        'satuan' => $request->satuan_item_pekerjaan[$key] ?? '0',
                    ]);
                }
            } else {
                $getItemPekerjaan = DetailItemPekerjaan::where('jenis_kerusakan_id', $jenisKerusakan->id)->get();

                foreach ($getItemPekerjaan as $i) {
                    HistoryPrestasiPhisik::where('detail_item_pekerjaan_id', $i->id)->delete();
                    DetailItemPekerjaan::find($i->id)->delete();
                }
            }

            $jenisKerusakan->update($data);
        } else {
            $jenisKerusakan->update([
                'dikerjakan_oleh' => $request->dikerjakan_oleh,
                'tgl_pengerjaan' => $request->tgl_pengerjaan,
                'nama_kerusakan' => $request->perbaikan,
                'status_kerusakan' => $request->status_kerusakan,
                'deskripsi' => $request->deskripsi ?? '-',
                'nomor_denah' => $request->nomor_denah,
                'foto' => $foto,
                'tgl_selesai_pekerjaan' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            if ($request->nama_material != null) {
                DetailJenisKerusakan::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
                foreach ($request->nama_material as $key => $item) {
                    $detailKerusakan = DetailJenisKerusakan::create([
                        'jenis_kerusakan_id' => $jenisKerusakan->id,
                        'kode_material' => $item,
                        'nama' => $request->perbaikan,
                        'harga' => $this->getHargaStokMaterial($item),
                        'volume' => $request->volume[$key] ?? '0',
                        'satuan' => $request->satuan[$key] ?? '0',
                        'total_harga' => floatval($this->getHargaStokMaterial($item)) * floatval($request->volume[$key])
                    ]);

                    HistoryStokMaterial::create([
                        'kode_material' => $item,
                        'detail_jenis_kerusakan_id' => $detailKerusakan->id,
                        'tanggal' => Carbon::now(),
                        'volume' => $request->volume[$key] ?? '0',
                        'satuan' => $request->satuan[$key] ?? '0',
                    ]);
                    $data['status_kerusakan'] = $request->status_kerusakan;
                    $this->setStokUpdate($item, $request->volume[$key]);
                }
            } else {
                DetailJenisKerusakan::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
                $data['status_kerusakan'] = 'Tanpa Material';
            }

            if ($request->nama_pekerja != null) {
                $getPekerja = DetailPekerja::where('jenis_kerusakan_id', $jenisKerusakan->id)->get();

                foreach ($getPekerja as $i) {
                    HistoryPekerja::where('detail_pekerja_id', $i->id)->delete();
                    DetailPekerja::find($i->id)->delete();
                }
                foreach ($request->nama_pekerja as $key => $item) {
                    $detailPekerja = DetailPekerja::create([
                        'jenis_kerusakan_id' => $jenisKerusakan->id,
                        'pekerja_id' => $item,
                        'nama' => $request->perbaikan,
                        'upah' => floatval($this->getUpahPekerja($item)),
                        'volume' => $request->volume_pekerja[$key] ?? '0',
                        'satuan' => $request->satuan_pekerja[$key] ?? '0',
                        'total_harga' => floatval($this->getUpahPekerja($item)) * floatval($request->volume_pekerja[$key]),
                    ]);

                    HistoryPekerja::create([
                        'pekerja_id' => $item,
                        'detail_pekerja_id' => $detailPekerja->id,
                        'tanggal' => Carbon::now(),
                        'volume' => $request->volume_pekerja[$key] ?? '0',
                        'satuan' => $request->satuan_pekerja[$key] ?? '0',
                    ]);
                }
            } else {
                $getPekerja = DetailPekerja::where('jenis_kerusakan_id', $jenisKerusakan->id)->get();

                foreach ($getPekerja as $i) {
                    HistoryPekerja::where('detail_pekerja_id', $i->id)->delete();
                    DetailPekerja::find($i->id)->delete();
                }
            }

            if ($request->item_pekerjaan != null) {
                $getItemPekerjaan = DetailItemPekerjaan::where('jenis_kerusakan_id', $jenisKerusakan->id)->get();

                foreach ($getItemPekerjaan as $i) {
                    HistoryPrestasiPhisik::where('detail_item_pekerjaan_id', $i->id)->delete();
                    DetailItemPekerjaan::find($i->id)->delete();
                }

                foreach ($request->item_pekerjaan as $key => $item) {
                    $detailItemPekerjaan = DetailItemPekerjaan::create([
                        'jenis_kerusakan_id' => $jenisKerusakan->id,
                        'item_pekerjaan_id' => $item,
                        'nama' => $request->perbaikan,
                        'harga' => floatval($this->getHargaItemPekerjaan($item)),
                        'volume' => $request->volume_item_pekerjaan[$key] ?? '0',
                        'satuan' => $request->satuan_item_pekerjaan[$key] ?? '0',
                        'total_harga' => floatval($this->getHargaItemPekerjaan($item)) * floatval($request->volume_item_pekerjaan[$key]),
                    ]);

                    HistoryPrestasiPhisik::create([
                        'item_pekerjaan_id' => $item,
                        'detail_item_pekerjaan_id' => $detailItemPekerjaan->id,
                        'tanggal' => Carbon::now(),
                        'volume' => $request->volume_item_pekerjaan[$key] ?? '0',
                        'satuan' => $request->satuan_item_pekerjaan[$key] ?? '0',
                    ]);
                }
            } else {
                $getItemPekerjaan = DetailItemPekerjaan::where('jenis_kerusakan_id', $jenisKerusakan->id)->get();

                foreach ($getItemPekerjaan as $i) {
                    HistoryPrestasiPhisik::where('detail_item_pekerjaan_id', $i->id)->delete();
                    DetailItemPekerjaan::find($i->id)->delete();
                }
            }
        }

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('jenis-kerusakan.detail', $id);
    }

    public function delete(Request $request, $id)
    {
        $jenisKerusakan = JenisKerusakan::findOrFail($id);
        $detailKerusakan = DetailJenisKerusakan::where('jenis_kerusakan_id', $jenisKerusakan->id);
        $detailPekerja = DetailPekerja::where('jenis_kerusakan_id', $jenisKerusakan->id);
        $detailItemPekerjaan = DetailItemPekerjaan::where('jenis_kerusakan_id', $jenisKerusakan->id);
        Storage::disk('public')->delete($jenisKerusakan->foto);
        $jenisKerusakan->delete();
        $detailKerusakan->delete();
        $detailPekerja->delete();
        $detailItemPekerjaan->delete();
        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('jenis-kerusakan.index', $request->detail_tgl_kerusakan_id); // Redirect kembali
    }

    private function setStokUpdate($kode_material, $volume)
    {
        $stokMaterial = StokMaterial::where('kode_material', $kode_material)
            ->where('diterima_som', 1)
            ->where('diterima_pm', 1)
            ->where('diterima_dir', 1)
            ->where('status_validasi_dir', 'ACC')
            ->where('status_validasi_som', '<>', 'Tolak')
            ->where('status_validasi_pm', '<>', 'Tolak')
            ->latest()
            ->first();
        $stokMaterial->update([
            'stok_update' => floatval($stokMaterial->stok_update) - floatval($volume)
        ]);
        return;
    }

    private function getHargaStokMaterial($idMaterial)
    {
        $stokMaterial = StokMaterial::select('harga')
            ->where('kode_material', $idMaterial)
            ->where('diterima_som', 1)
            ->where('diterima_pm', 1)
            ->where('diterima_dir', 1)
            ->where('status_validasi_dir', 'ACC')
            ->where('status_validasi_som', '<>', 'Tolak')
            ->where('status_validasi_pm', '<>', 'Tolak')
            ->groupBy('kode_material')
            ->latest()
            ->first();
        return $stokMaterial->harga;
    }

    private function getUpahPekerja($idPekerja)
    {
        $pekerja = Pekerja::find($idPekerja);
        return $pekerja->upah;
    }

    private function getHargaItemPekerjaan($idItemPekerjaan)
    {
        $itemPekerjaan = ItemPekerjaan::find($idItemPekerjaan);
        return $itemPekerjaan->harga;
    }

    // Fungsi simpan data ke folder
    private function imageStore($image, $perbaikan, $jenisKerusakan = null)
    {
        // Delete jika foto bukan default.jpg
        if (!empty($jenisKerusakan)) {
            if ($jenisKerusakan->foto != 'jenis-kerusakan/default.jpg') {
                Storage::disk('public')->delete($jenisKerusakan->foto);
            }
        }

        if (!empty($image)) {
            // Masukkan ke folder user-images dengan nama random dan extensi saat upload
            $compressedImage = Image::make($image)->orientate()->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = Storage::disk('public')->put('jenis-kerusakan/' . $perbaikan, $image);
            $compressedImage->save(public_path('storage/' . $path));
            $filePath = 'jenis-kerusakan/' . $perbaikan . '/' . $compressedImage->filename . "." . $compressedImage->extension;
            return $filePath;
        }
    }

    private function kembalikanStokMaterial($jenisKerusakanID)
    {
        $detailMaterials = DetailJenisKerusakan::select('id', 'jenis_kerusakan_id')->where('jenis_kerusakan_id', $jenisKerusakanID)->get();

        $histories = array();
        $jenis_kerusakan_id = "";
        foreach ($detailMaterials as $detailMaterial) {
            $jenis_kerusakan_id = $detailMaterial->jenis_kerusakan_id;
            $data = HistoryStokMaterial::where('detail_jenis_kerusakan_id', $detailMaterial->id)->first();
            array_push($histories, $data);
        }

        $materials = new StokMaterial();
        foreach ($histories as $histori) {
            $stok = $materials->where('kode_material', $histori->kode_material)
                ->where('diterima_som', 1)
                ->where('diterima_pm', 1)
                ->where('diterima_dir', 1)
                ->where('status_validasi_dir', 'ACC')
                ->where('status_validasi_som', '<>', 'Tolak')
                ->where('status_validasi_pm', '<>', 'Tolak')
                ->latest()
                ->first();
            $stok->update([
                'stok_update' => floatval($stok->stok_update) + floatval($histori->volume)
            ]);
            LogHistoryStokMaterial::create([
                'user_id' => auth()->user()->id,
                'kode_material' => $histori->kode_material,
                'jenis_kerusakan_id' => $jenis_kerusakan_id,
                'tanggal' => Carbon::now(),
                'volume' => $histori->volume,
                'satuan' => $histori->satuan,
            ]);
            HistoryStokMaterial::where('id', $histori->id)->delete();
        }
        return;
    }

    public function dokumentasi()
    {
        $area = Area::select('area.id', 'area.nama', 'regional.nama as regionalNama')->join('regional', 'area.regional_id', '=', 'regional.id')->get();
        return view('proyek.dokumentasi', compact('area'));
    }

    public function harian()
    {
        $area = Area::select('area.id', 'area.nama', 'regional.nama as regionalNama')->join('regional', 'area.regional_id', '=', 'regional.id')->get();
        return view('proyek.harian', compact('area'));
    }

    public function dokModel1(Request $request)
    {
        $start_date = $request->start_date . " 23:59:59";
        $end_date = $request->end_date . " 23:59:59";

        $list_area = AreaList::select('list_area.id', 'area.nama as areaNama', 'regional.nama as regionalNama')
            ->join('area', 'list_area.area_id', '=', 'area.id')
            ->join('regional', 'area.regional_id', '=', 'regional.id')
            ->where('list_area.area_id', $request->area_id)
            ->first();

        if (empty($list_area->id)) {
            toast('Dokumentasi pada area tersebut belum ada!', 'warning'); // Toast
            return Redirect::back();
        }

        $jenis_kerusakan = JenisKerusakan::select('jenis_kerusakan.id', 'users.name as namaKaryawan', 'nama_kerusakan', 'deskripsi', 'nomor_denah', 'tgl_selesai_pekerjaan', 'status_kerusakan', 'list_area.nama as listNama', 'nomor_denah', 'lantai')
            ->join('detail_tgl_kerja', 'jenis_kerusakan.detail_tgl_kerja_id', '=', 'detail_tgl_kerja.id')
            ->join('list_area', 'detail_tgl_kerja.list_area_id', '=', 'list_area.id')
            ->join('area', 'list_area.area_id', '=', 'area.id')
            ->join('users', 'jenis_kerusakan.dikerjakan_oleh', '=', 'users.id')
            ->where('area.id', $request->area_id)
            ->whereBetween('tgl_selesai_pekerjaan', [Carbon::createFromFormat('d/m/Y H:i:s', $start_date)->format('Y-m-d H:i:s'), Carbon::createFromFormat('d/m/Y H:i:s', $end_date)->format('Y-m-d H:i:s')])
            ->get();

        if (empty($jenis_kerusakan)) {
            toast('Belum ada dokumentasi pada tanggal tersebut!', 'warning'); // Toast
            return Redirect::back();
        }

        $foto = new FotoKerusakan();

        foreach ($jenis_kerusakan as $key => $item) {
            $data[$key]['data'] = $item;
            $data[$key]['foto'] = $foto->select('foto')->where('jenis_kerusakan_id', $item->id)->get();
        }

        if (empty($data)) {
            toast('Belum ada dokumentasi pada tanggal tersebut!', 'warning'); // Toast
            return Redirect::back();
        }

        $data = json_encode($data, true);

        $pdf = Pdf::loadView('components.print-layouts.dokumentasi.model1', ['jenis_kerusakan' => $data, 'start' => Carbon::createFromFormat('d/m/Y', $request->start_date)->isoFormat('D MMMM Y'), 'end' => Carbon::createFromFormat('d/m/Y', $request->end_date)->isoFormat('D MMMM Y'), 'area' => $list_area])->setPaper('a4');
        return $pdf->stream('dokumentasi_(' . Carbon::createFromFormat('d/m/Y', $request->start_date)->isoFormat('D MMMM Y') . ' - ' . Carbon::createFromFormat('d/m/Y', $request->end_date)->isoFormat('D MMMM Y') . ').pdf');
    }

    public function harianModel1(Request $request)
    {
        $start_date = $request->start_date . " 23:59:59";
        $end_date = $request->end_date . " 23:59:59";

        $list_area = AreaList::select('list_area.id', 'area.nama as areaNama', 'regional.nama as regionalNama')
            ->join('area', 'list_area.area_id', '=', 'area.id')
            ->join('regional', 'area.regional_id', '=', 'regional.id')
            ->where('list_area.area_id', $request->area_id)
            ->first();

        if (empty($list_area->id)) {
            toast('Pekerjaan pada area tersebut belum ada!', 'warning'); // Toast
            return Redirect::back();
        }

        $jenis_kerusakan = JenisKerusakan::select('list_area.nama as namaArea', 'tgl_kerja.tanggal as tglKerja', 'jenis_kerusakan.id', 'nama_kerusakan', 'deskripsi', 'nomor_denah', 'tgl_selesai_pekerjaan', 'status_kerusakan', 'list_area.nama as listNama', 'nomor_denah', 'lantai')
            ->join('detail_tgl_kerja', 'jenis_kerusakan.detail_tgl_kerja_id', '=', 'detail_tgl_kerja.id')
            ->join('tgl_kerja', 'detail_tgl_kerja.tgl_kerja_id', '=', 'tgl_kerja.id')
            ->join('list_area', 'detail_tgl_kerja.list_area_id', '=', 'list_area.id')
            ->join('area', 'list_area.area_id', '=', 'area.id')
            ->where('area.id', $request->area_id)
            ->whereBetween('tgl_kerja.tanggal', [Carbon::createFromFormat('d/m/Y H:i:s', $start_date)->format('Y-m-d H:i:s'), Carbon::createFromFormat('d/m/Y H:i:s', $end_date)->format('Y-m-d H:i:s')])
            ->get();

        if (empty($jenis_kerusakan)) {
            toast('Belum ada pekerjaan pada tanggal tersebut!', 'warning'); // Toast
            return Redirect::back();
        }

        $detail = array();
        $pekerja = array();
        $itemPekerjaan = array();
        foreach ($jenis_kerusakan as $key => $item) {
            $data[$item->tglKerja][$key]['jenis_kerusakan'] = $item;

            $detail_kerusakan = DetailJenisKerusakan::select('detail_jenis_kerusakan.nama', 'detail_jenis_kerusakan.volume', 'detail_jenis_kerusakan.satuan', 'stok_material.nama_material')
                ->where('jenis_kerusakan_id', $item->id)
                ->join('stok_material', 'detail_jenis_kerusakan.kode_material', '=', 'stok_material.kode_material')
                ->get();

            $detail_pekerja = DetailPekerja::where('jenis_kerusakan_id', $item->id)
                ->join('pekerja', 'detail_pekerja.pekerja_id', '=', 'pekerja.id')
                ->get();

            $detail_item_pekerjaan = DetailItemPekerjaan::select('detail_item_pekerjaan.volume', 'detail_item_pekerjaan.satuan', 'item_pekerjaan.nama')
                ->where('jenis_kerusakan_id', $item->id)
                ->join('item_pekerjaan', 'detail_item_pekerjaan.item_pekerjaan_id', '=', 'item_pekerjaan.id')
                ->get();

            foreach ($detail_kerusakan as $itemDetailKerusakan) {
                array_push($detail, $itemDetailKerusakan);
            }

            foreach ($detail_pekerja as $itemPekerja) {
                array_push($pekerja, $itemPekerja);
            }

            foreach ($detail_item_pekerjaan as $itemItemPekerjaan) {
                array_push($itemPekerjaan, $itemItemPekerjaan);
            }

            $data[$item->tglKerja][$key]['detail_kerusakan'] = $detail;
            $data[$item->tglKerja][$key]['detail_pekerja'] = $pekerja;
            $data[$item->tglKerja][$key]['detail_item_pekerjaan'] = $itemPekerjaan;
            $detail = array();
            $pekerja = array();
            $itemPekerjaan = array();
        }

        // dd($data);

        if (empty($jenis_kerusakan)) {
            toast('Belum ada dokumentasi pada tanggal tersebut!', 'warning'); // Toast
            return Redirect::back();
        }

        $pdf = Pdf::loadView('components.print-layouts.dokumentasi.harian', ['data' => $data])->setPaper('a4', 'landscape');
        return $pdf->stream('dokumentasi_(' . Carbon::createFromFormat('d/m/Y', $request->start_date)->isoFormat('D MMMM Y') . ' - ' . Carbon::createFromFormat('d/m/Y', $request->end_date)->isoFormat('D MMMM Y') . ').pdf');
    }

    protected function cekAdaItemPekerjaan($jenisKerusakan)
    {
        $detail['kerusakan'] = array();
        $detail['item_pekerjaan'][] = 0;
        foreach ($jenisKerusakan as $key => $value) {
            $pekerja = DetailPekerja::where('jenis_kerusakan_id', $value->id)->get();
            $itemPekerjaan = DetailItemPekerjaan::where('jenis_kerusakan_id', $value->id)->get();

            if (count($pekerja) > 0 || count($itemPekerjaan) > 0) {
                if (auth()->user()->can('tanggal kerja_all data')) {
                    $detail['item_pekerjaan'][$key] = true;
                    array_push($detail['kerusakan'], $value);
                }
            } else {
                $detail['item_pekerjaan'][$key] = false;
                array_push($detail['kerusakan'], $value);
            }
        }
        return $detail;
    }
}
