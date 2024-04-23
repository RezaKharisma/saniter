<?php

namespace App\Http\Controllers;

use App\Models\Api\NamaMaterial;
use App\Models\AreaList;
use App\Models\DetailJenisKerusakan;
use App\Models\DetailTglKerja;
use App\Models\HistoryStokMaterial;
use App\Models\JenisKerusakan;
use App\Models\StokMaterial;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class JenisKerusakanController extends Controller
{
    public function index($id){
        $detailKerja = DetailTglKerja::select('detail_tgl_kerja.id','detail_tgl_kerja.tgl_kerja_id','detail_tgl_kerja.list_area_id','tgl_kerja.created_at')->join('tgl_kerja','detail_tgl_kerja.tgl_kerja_id','=','tgl_kerja.id')->find($id);

        $area = AreaList::select('list_area.id','lantai','list_area.nama as listNama','denah','area.nama as areaNama')
            ->join('area','list_area.area_id','=','area.id')
            ->where('list_area.id', $detailKerja->list_area_id)
            ->first();

        $jenisKerusakan = JenisKerusakan::select('users.name','users.foto as userFoto','jenis_kerusakan.*')
            ->where('detail_tgl_kerja_id',$detailKerja->id)
            ->join('users','jenis_kerusakan.dikerjakan_oleh','=','users.id')
            ->orderBy('id','DESC')
            ->get();

        return view('proyek.jenis-kerusakan.index', compact('detailKerja','area','jenisKerusakan'));
    }

    public function create($id){
        $teknisi = User::select('users.id','users.name')->join('roles','users.role_id','=','roles.id')->where('roles.name','Teknisi')->get();

        $detailKerja = DetailTglKerja::select('detail_tgl_kerja.id','list_area.denah','list_area.lantai','list_area.nama')
            ->join('list_area','detail_tgl_kerja.list_area_id','=','list_area.id')
            ->find($id);

        $stokMaterial = StokMaterial::select('id','kode_material','nama_material','harga','stok_update')
            ->where('diterima_pm', 1)
            ->where('diterima_spv', 1)
            ->where('status_validasi_pm', 'ACC')
            ->whereNot('status_validasi_pm', 'Tolak')
            ->groupBy('kode_material')
            ->get();

        return view('proyek.jenis-kerusakan.create', compact('detailKerja','stokMaterial','teknisi'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'status_kerusakan' => 'required',
            'perbaikan' => 'required',
            'foto' => 'required|mimes:png,jpg,jpeg',
            'nomor_denah' => 'required'
        ]);

        if ($request->nama_material && $request->satuan && $request->volume) {
            $validator2 = Validator::make($request->all(),[
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
            'created_by' => auth()->user()->name,
        ]);

        if ($request->nama_material != null) {
            foreach ($request->nama_material as $key => $item) {
                DetailJenisKerusakan::create([
                    'jenis_kerusakan_id' => $jenisKerusakan->id,
                    'stok_material_id' => $item,
                    'nama' => $request->perbaikan,
                    'harga' => $this->getHargaStokMaterial($item),
                    'volume' => $request->volume[$key] ?? '0',
                    'satuan' => $request->satuan[$key] ?? '0',
                    'total_harga' => $this->getHargaStokMaterial($item) * $request->volume[$key],
                ]);
            }
        }

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('jenis-kerusakan.index', $request->detail_tgl_kerja_id);
    }

    public function detail($id){
        $cekDetail = DetailJenisKerusakan::where('jenis_kerusakan_id', $id)->first();

        if ($cekDetail != null) {
            $detail = DetailJenisKerusakan::select('detail_jenis_kerusakan.*','jenis_kerusakan.detail_tgl_kerja_id as detailKerjaID','jenis_kerusakan.foto','jenis_kerusakan.nama_kerusakan','jenis_kerusakan.deskripsi','jenis_kerusakan.nomor_denah','jenis_kerusakan.tgl_selesai_pekerjaan','jenis_kerusakan.status_kerusakan','jenis_kerusakan.dikerjakan_oleh','jenis_kerusakan.created_at as jenisCreatedAt','users.name','users.foto as userFoto')
                ->join('jenis_kerusakan','detail_jenis_kerusakan.jenis_kerusakan_id','=','jenis_kerusakan.id')
                ->join('users','jenis_kerusakan.dikerjakan_oleh','=','users.id')
                ->where('detail_jenis_kerusakan.jenis_kerusakan_id', $id)
                ->first();
        }else{
            $detail = JenisKerusakan::select('jenis_kerusakan.id as jenisKerusakanID','jenis_kerusakan.*','detail_tgl_kerja.id as detailKerjaID','list_area.denah')
                ->where('jenis_kerusakan.id', $id)
                ->join('detail_tgl_kerja','jenis_kerusakan.detail_tgl_kerja_id','=','detail_tgl_kerja.id')
                ->join('list_area','detail_tgl_kerja.list_area_id','=','list_area.id')
                ->first();
        }

        $detailMaterial = DetailJenisKerusakan::select('detail_jenis_kerusakan.*')
            ->where('jenis_kerusakan_id', $id)
            ->get();

        $teknisi = User::select('users.id','users.name')->join('roles','users.role_id','=','roles.id')->where('roles.name','Teknisi')->get();

        $jenisKerusakan = JenisKerusakan::select('jenis_kerusakan.id as jenisKerusakanID','detail_tgl_kerja.id as detailKerjaID','list_area.lantai','list_area.nama','list_area.denah','jenis_kerusakan.tgl_selesai_pekerjaan')
            ->where('jenis_kerusakan.id', $id)
            ->join('detail_tgl_kerja','jenis_kerusakan.detail_tgl_kerja_id','=','detail_tgl_kerja.id')
            ->join('list_area','detail_tgl_kerja.list_area_id','=','list_area.id')
            ->first();

        $stokMaterial = StokMaterial::select('id','kode_material','nama_material','harga','stok_update')
            ->where('diterima_pm', 1)
            ->where('diterima_spv', 1)
            ->where('status_validasi_pm', 'ACC')
            ->whereNot('status_validasi_pm', 'Tolak')
            ->groupBy('kode_material')
            ->get();

        return view('proyek.jenis-kerusakan.detail', compact('detail','detailMaterial','teknisi','stokMaterial','jenisKerusakan'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'status_kerusakan' => 'required',
            'perbaikan' => 'required',
            'foto' => 'mimes:png,jpg,jpeg',
            'nomor_denah' => 'required',
        ]);

        if ($request->nama_material && $request->satuan && $request->volume) {
            $validator2 = Validator::make($request->all(),[
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

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
            ->withErrors($validator)
            ->withInput(); // Return kembali membawa error dan old input
        }

        if($request->cekFoto == "false"){
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
                $detailKerusakan = new DetailJenisKerusakan();
                foreach ($request->nama_material as $key => $item) {
                    DetailJenisKerusakan::create([
                        'jenis_kerusakan_id' => $jenisKerusakan->id,
                        'stok_material_id' => $item,
                        'nama' => $request->perbaikan,
                        'harga' => $this->getHargaStokMaterial($item),
                        'volume' => $request->volume[$key] ?? '0',
                        'satuan' => $request->satuan[$key] ?? '0',
                        'total_harga' => floatval($this->getHargaStokMaterial($item)) * floatval($request->volume[$key]),
                    ]);
                }
                $data['status_kerusakan'] = $request->status_kerusakan;
            }else{
                DetailJenisKerusakan::where('jenis_kerusakan_id', $jenisKerusakan->id)->delete();
                $data['status_kerusakan'] = 'Tanpa Material';
            }

            $jenisKerusakan->update($data);
        }else{
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
                        'stok_material_id' => $item,
                        'nama' => $request->perbaikan,
                        'harga' => $this->getHargaStokMaterial($item),
                        'volume' => $request->volume[$key] ?? '0',
                        'satuan' => $request->satuan[$key] ?? '0',
                        'total_harga' => floatval($this->getHargaStokMaterial($item)) * floatval($request->volume[$key])
                    ]);

                    HistoryStokMaterial::create([
                        'stok_material_id' => $item,
                        'detail_jenis_kerusakan_id' => $detailKerusakan->id,
                        'tanggal' => Carbon::now(),
                        'volume' => $request->volume[$key] ?? '0',
                        'satuan' => $request->satuan[$key] ?? '0',
                    ]);

                    $stokMaterial = StokMaterial::find($item);
                    $this->setStokUpdate($stokMaterial, $request->volume[$key]);
                }
            }
        }

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('jenis-kerusakan.index', $request->detail_tgl_kerja_id);
    }

    public function delete(Request $request, $id){
        $jenisKerusakan = JenisKerusakan::findOrFail($id);
        $detailKerusakan = DetailJenisKerusakan::where('jenis_kerusakan_id', $jenisKerusakan->id);
        Storage::disk('public')->delete($jenisKerusakan->foto);
        $jenisKerusakan->delete();
        $detailKerusakan->delete();
        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('jenis-kerusakan.index', $request->detail_tgl_kerusakan_id); // Redirect kembali
    }

    public function setStokUpdate($stokMaterial, $volume){
        $stokLatest = StokMaterial::where('kode_material', 'LIKE', '%'.$stokMaterial->kode_material.'%')->where('status_validasi_pm', 'ACC')->latest()->first();
        $stokLatest->update([
            'stok_update' => floatval($stokLatest->stok_update) - floatval($volume)
        ]);
        return;
    }

    private function getHargaStokMaterial($idMaterial)
    {
        $stokMaterial = StokMaterial::select('harga')
            ->where('diterima_pm', 1)
            ->where('diterima_spv', 1)
            ->where('status_validasi_pm', 'ACC')
            ->whereNot('status_validasi_pm', 'Tolak')
            ->find($idMaterial)
            ->first();
        return $stokMaterial->harga;
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
            $image = Storage::disk('public')->put('jenis-kerusakan/'.$perbaikan.'/', $image);
            return $image;
        }
    }
}
