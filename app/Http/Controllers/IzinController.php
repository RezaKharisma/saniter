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

    public function create()
    {
        $user = User::whereNot('role_id',1)->get();
        return view('izin/create', compact('user'));
    }

    public function store(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
                'name' => 'required',
                'jenis_izin' => 'required',
                'tgl_mulai_izin' => 'required',
                'tgl_akhir_izin' => 'required',
                'foto' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $total_izin = count(CarbonPeriod::create(Carbon::parse($request->tgl_mulai_izin)->format('Y-d-m'), Carbon::parse($request->tgl_akhir_izin)->format('Y-d-m')));

        $data = [
            'user_id' => $request->name,
            'jenis_izin' => $request->jenis_izin,
            'tgl_mulai_izin' => Carbon::parse($request->tgl_mulai_izin)->format('Y-d-m'),
            'tgl_akhir_izin' => Carbon::parse($request->tgl_akhir_izin)->format('Y-d-m'),
            'total_izin' => $total_izin,
            'foto' => $this->fileStore($request->file('foto'))
        ];
        Izin::create($data);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('izin.index'); // Redirect kembali
    }

    public function edit($id)
    {
        $izin = Izin::select('izin.*','users.id as userId','users.name as userName')
            ->join('users','izin.user_id','=','users.id')
            ->find($id);
        $jumlahIzin = JumlahIzin::where('user_id', $izin->user_id)->first();
        return view('izin.edit', compact('izin','jumlahIzin'));
    }

    public function update(Request $request, $id)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
                'name' => 'required',
                'jenis_izin' => 'required',
                'tgl_mulai_izin' => 'required',
                'tgl_akhir_izin' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $total_izin = count(CarbonPeriod::create(Carbon::parse($request->tgl_mulai_izin)->format('Y-d-m'), Carbon::parse($request->tgl_akhir_izin)->format('Y-d-m')));

        $izin = Izin::find($id);
        $data = [
            'user_id' => $request->name,
            'jenis_izin' => $request->jenis_izin,
            'tgl_mulai_izin' => Carbon::parse($request->tgl_mulai_izin)->format('Y-d-m'),
            'tgl_akhir_izin' => Carbon::parse($request->tgl_akhir_izin)->format('Y-d-m'),
            'total_izin' => $total_izin,
            'foto' => $this->fileStore($request->file('foto'), $izin) ?? $request->oldFoto
        ];
        $izin->update($data);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('izin.index'); // Redirect kembali
    }

    public function updateValidasi(Request $request, $id)
    {
        $data = null;
        if (isset($request->validasi1)) {
            $data = [
                'validasi_1' => 1,
                'validasi_1_by' => $request->validasi1
            ];
        }

        if (isset($request->validasi2)) {
            $data = [
                'validasi_2' => 1,
                'validasi_2_by' => $request->validasi2
            ];
        }

        if ($data != null) {
            $izin = Izin::find($id);
            $izin->update($data);

            toast('Data berhasil tersimpan!', 'success');
            return Redirect::route('izin.index'); // Redirect kembali
        }

        toast('Tidak ada data yang disimpan!', 'info');
        return Redirect::route('izin.index');
    }

    public function delete($id){
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
            $file = Storage::disk('public')->put('dokumen-izin/'.Carbon::now()->format('Y-m-d'), $file);
            return $file;
        }
    }

    private function duaValidasiDisetujui($izinId)
    {
        $izin = Izin::find($izinId);
        $user = User::
            select(
                'user.id as userId',
                'lokasi.id as lokasiId',
                'shift.id as shiftId',
                'tgl_masuk'
            )
            ->where('id', $izin->user_id)
            ->join('lokasi','users.lokasi_id','=','lokasi.id')
            ->join('shift','users.shift_id','=','shift.id')
            ->get();

        // $data = [
        //     'user_id' => auth()->user()->id,
        //     'lokasi_id' => $request->lokasi_id,
        //     'shift_id' => $shiftYangDipilih->id,
        //     'tgl_masuk' => Carbon::now()->format('Y-m-d'),
        //     'jam_masuk' => Carbon::now()->format('H:i:s'),
        //     'foto_masuk' => $pathFoto,
        //     'lokasi_masuk' => $request->lokasi_proyek,
        //     'tgl_pulang' => '',
        //     'jam_pulang' => '',
        //     'foto_pulang' => 'Belum Dilakukan',
        //     'lokasi_pulang' => 'Belum Dilakukan',
        //     'terlambat' => $keterlambatan['time'],
        //     'keterangan' => $keterangan,
        //     'status' => $keterlambatan['status'],
        // ];
        Absen::create($data);
    }

    /*
    |----------------------------------------
    | Pengaturan Izin
    |----------------------------------------
    */

    public function indexPengaturan()
    {
        $regional = Regional::all();
        $jumlah = JumlahIzin::select('*','users.name as name_user', 'regional.nama  as regional_nama')
            ->leftjoin('users', 'users.id', '=', 'jumlah_izin.user_id')
            ->leftjoin('regional', 'regional.id', '=', 'users.regional_id')
            ->get();

        return view('pengaturan.izin.index', compact('regional','jumlah'));
    }

    public function createPengaturan()
    {
        $user = User::select('*','users.name as user_name', 'roles.name as role_name','users.id as user_id')
            ->from('users')->where('users.role_id', '=', '2')
            ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
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
