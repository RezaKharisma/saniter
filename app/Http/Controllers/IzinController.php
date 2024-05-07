<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Izin;
use App\Models\JumlahIzin;
use App\Models\Regional;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    /*
    |----------------------------------------
    | Izin User
    |----------------------------------------
    */

    public function index()
    {
        return view('izin.index');
    }

    public function indexAll()
    {
        return view('izin.all-index');
    }

    public function create()
    {
        $user = User::whereNot('role_id', 1)->get();
        $jumlahIzin = JumlahIzin::select('jumlah_izin')->where('tahun', Carbon::now()->format('Y'))->where('user_id', auth()->user()->id)->first();
        return view('izin/create', compact('user', 'jumlahIzin'));
    }

    public function store(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'jenis_izin' => 'required',
            'tgl_mulai_izin' => 'required',
            'tgl_akhir_izin' => 'required',
            'keterangan' => 'required',
            'foto' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        // Fungsi jika tanggal sudah dipilih pada izin sebelumnya, atau terdapat tanggal yang sama
        if ($this->cekTanggalSudahDipilihSebelumnya($request->name, $request->tgl_mulai_izin, $request->tgl_akhir_izin) == true) {
            toast('Tanggal tersebut sudah terpilih sebelumnya!', 'warning');
            return Redirect::route('izin.index');
        }

        $total_izin = count(CarbonPeriod::create(Carbon::createFromFormat('d/m/Y', $request->tgl_mulai_izin)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->tgl_akhir_izin)->format('Y-m-d')));

        if ($this->cekSisaCuti($request->name, $total_izin)) {
            toast('Sisa cuti telah habis / tidak mencukupi!', 'error');
            return Redirect::route('izin.index'); // Redirect kembali
        } else {
            $data = [
                'user_id' => $request->name,
                'jenis_izin' => $request->jenis_izin,
                'tgl_mulai_izin' => Carbon::createFromFormat('d/m/Y', $request->tgl_mulai_izin)->format('Y-m-d'),
                'tgl_akhir_izin' => Carbon::createFromFormat('d/m/Y', $request->tgl_akhir_izin)->format('Y-m-d'),
                'total_izin' => $total_izin,
                'keterangan' => $request->keterangan,
                'foto' => $this->fileStore($request->file('foto'))
            ];
            Izin::create($data);

            toast('Data berhasil tersimpan!', 'success');
            return Redirect::route('izin.index'); // Redirect kembali
        }
    }

    public function edit($id)
    {
        $izin = Izin::select('izin.*', 'users.id as userId', 'users.name as userName')
            ->join('users', 'izin.user_id', '=', 'users.id')
            ->find($id);
        $jumlahIzin = JumlahIzin::where('user_id', $izin->user_id)->where('tahun', Carbon::now()->format('Y'))->first();
        return view('izin.edit', compact('izin', 'jumlahIzin'));
    }

    public function update(Request $request, $id)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'jenis_izin' => 'required',
            'tgl_mulai_izin' => 'required',
            'tgl_akhir_izin' => 'required',
            'keterangan' => 'required'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        // Fungsi jika tanggal sudah dipilih pada izin sebelumnya, atau terdapat tanggal yang sama
        if ($this->cekTanggalSudahDipilihSebelumnya($request->name, $request->tgl_mulai_izin, $request->tgl_akhir_izin) == true) {
            toast('Tanggal tersebut sudah terpilih sebelumnya!', 'warning');
            return Redirect::route('izin.index');
        }

        $total_izin = count(CarbonPeriod::create(Carbon::createFromFormat('d/m/Y', $request->tgl_mulai_izin)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->tgl_akhir_izin)->format('Y-m-d')));

        if ($this->cekSisaCuti($request->name, $total_izin)) {
            toast('Sisa cuti telah habis / tidak mencukupi!', 'error');
            return Redirect::route('izin.index'); // Redirect kembali
        } else {
            $izin = Izin::find($id);
            $data = [
                'user_id' => $request->name,
                'jenis_izin' => $request->jenis_izin,
                'tgl_mulai_izin' => Carbon::createFromFormat('d/m/Y', $request->tgl_mulai_izin)->format('Y-m-d'),
                'tgl_akhir_izin' => Carbon::createFromFormat('d/m/Y', $request->tgl_akhir_izin)->format('Y-m-d'),
                'total_izin' => $total_izin,
                'keterangan' => $request->keterangan,
                'foto' => $this->fileStore($request->file('foto'), $izin) ?? $request->oldFoto
            ];
            $izin->update($data);

            toast('Data berhasil tersimpan!', 'success');
            return Redirect::route('izin.index'); // Redirect kembali
        }
    }

    public function updateValidasi(Request $request, $id)
    {
        $data = array();
        $update = array();
        if (isset($request->validasi1)) {
            $data = [
                'validasi_1' => 1,
                'validasi_1_by' => $request->validasi1,
                'tanggal_diterima_1' => Carbon::now(),
                'status_validasi_1' => $request->status_validasi_1,
                'keterangan_1' => $request->keterangan_1
            ];
            if ($request->status_validasi_1 == "Tolak") {
                $update = [
                    'validasi_2' => 1,
                    'validasi_2_by' => $request->validasi1,
                    'tanggal_diterima_2' => Carbon::now(),
                    'status_validasi_2' => $request->status_validasi_1,
                    'keterangan_2' => $request->keterangan_1
                ];
            }
        }

        if (isset($request->validasi2)) {
            $data = [
                'validasi_2' => 1,
                'validasi_2_by' => $request->validasi2,
                'tanggal_diterima_2' => Carbon::now(),
                'status_validasi_2' => $request->status_validasi_2,
                'keterangan_2' => $request->keterangan_2
            ];
            if ($request->status_validasi_2 == "Tolak") {
                $update = [
                    'validasi_1' => 1,
                    'validasi_1_by' => $request->validasi2,
                    'tanggal_diterima_1' => Carbon::now(),
                    'status_validasi_1' => $request->status_validasi_2,
                    'keterangan_1' => $request->keterangan_2
                ];
            }
        }

        if ($data != null) {
            $izin = Izin::find($id);
            $izin->update($data);
            if (!empty($update)) {
                $izin->update($update);
            }

            if ($izin->validasi_1 != 0 && $izin->validasi_2 != 0 && $izin->status_validasi_1 != "Tolak" && $izin->status_validasi_2 != "Tolak") {
                $this->duaValidasiDisetujui($id);
            }

            toast('Data berhasil tersimpan!', 'success');
            return Redirect::route('izin.index'); // Redirect kembali
        }

        toast('Tidak ada data yang disimpan!', 'info');
        return Redirect::route('izin.index');
    }

    public function delete($id)
    {
        // Cari lokasi berdasarkan ID
        $izin = Izin::findOrFail($id);

        // Delete lokasi tersebut
        $izin->delete();

        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('izin.index'); // Redirect kembali
    }

    private function fileStore($file, $izin = null)
    {
        if (!empty($izin)) {
            Storage::disk('public')->delete($izin->foto);
        }

        if (!empty($file)) {
            // Masukkan ke folder user-images dengan nama random dan extensi saat upload
            $file = Storage::disk('public')->put('dokumen-izin/' . Carbon::now()->format('Y-m-d'), $file);
            return $file;
        }
    }

    private function duaValidasiDisetujui($izinId)
    {
        $izin = Izin::find($izinId);

        $user = User::select('users.id as userId', 'lokasi.id as lokasiId',)
            ->where('users.id', $izin->user_id)
            ->join('lokasi', 'users.lokasi_id', '=', 'lokasi.id')
            ->first();

        $jumlahIzin = JumlahIzin::where('user_id', $user->userId)->where('tahun', Carbon::now()->format('Y'))->first();


        if ($jumlahIzin->jumlah_izin < $izin->total_izin) {
            toast('Sisa cuti telah habis / tidak mencukupi!', 'error');
            return Redirect::route('izin.index'); // Redirect kembali
        } else {
            $jumlahIzin->update([
                'jumlah_izin' => $jumlahIzin->jumlah_izin - $izin->total_izin
            ]);

            $periodeTanggal = CarbonPeriod::create(Carbon::parse($izin->tgl_mulai_izin), Carbon::parse($izin->tgl_akhir_izin));
            $keterangan = $izin->jenis_izin . " dari tanggal (" . Carbon::parse($izin->tgl_mulai_izin)->format('F') . " - " . Carbon::parse($izin->tgl_akhir_izin)->format('F') . ") selama " . $izin->total_izin . " hari.";

            foreach ($periodeTanggal as $item) {
                $data = [
                    'user_id' => $user->userId,
                    'lokasi_id' => $user->lokasiId,
                    'shift_id' => 1,
                    'tgl_masuk' => $item->format('Y-m-d'),
                    'jam_masuk' => Carbon::createFromTimeString('00:00:00')->format('H:i:s'),
                    'foto_masuk' => 'user-absen/default.jpg',
                    'lokasi_masuk' => '0',
                    'tgl_pulang' => $item->format('Y-m-d'),
                    'jam_pulang' => Carbon::createFromTimeString('00:00:00')->format('H:i:s'),
                    'foto_pulang' => 'user-absen/default.jpg',
                    'lokasi_pulang' => '0',
                    'terlambat' => Carbon::createFromTimeString('00:00:00')->format('H:i:s'),
                    'keterangan' => $keterangan,
                    'status' => $izin->jenis_izin,
                ];
                Absen::create($data);
            }
        }
    }

    private function cekSisaCuti($userId, $total_izin)
    {
        $jumlahIzin = JumlahIzin::where('user_id', $userId)->where('tahun', Carbon::now()->format('Y'))->first();

        if ($jumlahIzin == null) {
            return true;
        }

        if ($jumlahIzin->jumlah_izin < $total_izin) {
            return true;
        }
        return false;
    }

    private function cekTanggalSudahDipilihSebelumnya($userId, $tglMulai, $tglSelesai)
    {
        $izin = Izin::select('tgl_mulai_izin', 'tgl_akhir_izin')->where('user_id', $userId)->get();

        $periode = CarbonPeriod::create(Carbon::createFromFormat('d/m/Y', $tglMulai)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $tglSelesai)->format('Y-m-d'));

        $p = array();
        $pi = array();

        foreach ($periode as $i) {
            array_push($p, $i->format('Y-m-d'));
        }

        sort($p);

        foreach ($izin as $i) {
            $periodeIzin = CarbonPeriod::create(Carbon::parse($i->tgl_mulai_izin)->format('Y-m-d'), Carbon::parse($i->tgl_selesai_izin)->format('Y-m-d'));

            foreach ($periodeIzin as $ii) {
                array_push($pi, $ii->format('Y-m-d'));
            }
        }


        if (count(array_intersect($p, $pi)) > 0) {
            return true;
        }
        return false;
    }

    /*
    |----------------------------------------
    | Pengaturan Izin
    |----------------------------------------
    */

    public function indexPengaturan()
    {
        $regional = Regional::all();
        $jumlah = JumlahIzin::select('*', 'users.name as name_user', 'regional.nama  as regional_nama')
            ->leftjoin('users', 'users.id', '=', 'jumlah_izin.user_id')
            ->leftjoin('regional', 'regional.id', '=', 'users.regional_id')
            ->get();

        return view('pengaturan.izin.index', compact('regional', 'jumlah'));
    }

    public function createPengaturan()
    {
        $user = User::select('*', 'users.name as user_name', 'roles.name as role_name', 'users.id as user_id')
            ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
            ->where('roles.name', '=', 'Teknisi')
            ->get();
        return view('pengaturan.izin.create', compact('user'));
    }

    public function storePengaturan(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'tahun' => 'required',
            'jumlah_izin' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        // Insert data lokasi baru dari input form
        JumlahIzin::create([
            'user_id' => $request->user_id,
            'tahun' => $request->tahun,
            'jumlah_izin' => $request->jumlah_izin,
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('pengaturan.izin.index'); // Redirect kembali
    }

    public function updatePengaturan(Request $request, $id)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'jumlahIzinEdit' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::flash('modalEdit', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $jumlahIzin = JumlahIzin::find($id);
        // Insert data lokasi baru dari input form
        $jumlahIzin->update([
            'jumlah_izin' => $request->jumlahIzinEdit
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('pengaturan.izin.index');
    }

    public function deletePengaturan($id)
    {
        // Cari lokasi berdasarkan ID
        $jumlah = JumlahIzin::findOrFail($id);

        // Delete lokasi tersebut
        $jumlah->delete();

        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('pengaturan.izin.index'); // Redirect kembali
    }
}
