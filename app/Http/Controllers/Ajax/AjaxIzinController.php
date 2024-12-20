<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Izin;
use App\Models\JumlahIzin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class AjaxIzinController extends Controller
{
    // Ambil data izin untuk datatable
    public function getIzin(Request $request)
    {
        if ($request->ajax()) {

            $izin = Izin::select('izin.*', 'users.foto as userFoto', 'users.name as userName')
                ->join('users', 'izin.user_id', '=', 'users.id')
                ->where('users.id', auth()->user()->id)
                ->orderBy('created_at', 'DESC')
                ->get();

            // Return datatables
            return DataTables::of($izin)
                ->addIndexColumn()
                ->addColumn('file', function ($row) {
                    if ($row->foto === 0) {
                        $button = "<button class='btn btn-secondary' disabled >Tidak Ada File</button>";
                    } else {
                        $button = "<a href='" . asset('storage/' . $row->foto) . "' class='btn btn-secondary btn-sm' target='_blank'><span class='tf-icons bx bx-download'></span> Download</a>";
                    }
                    return $button;
                })
                ->addColumn('tanggal', function ($row) {
                    $result = "
                    <div class='me-2'>
                        <small class='text-muted d-block mb-1'>Total Hari : " . $row->total_izin . "</small>
                        <h6 class='mb-0'>(" . Carbon::parse($row->tgl_mulai_izin)->isoFormat('D MMMM Y') . " - " . Carbon::parse($row->tgl_akhir_izin)->isoFormat('D MMMM Y') . ")</h6>
                    </div>
                    ";
                    return $result;
                })
                ->addColumn('tanggal-pengajuan', function ($row) {
                    $result = Carbon::parse($row->created_at)->isoFormat('D MMMM Y');
                    return $result;
                })
                ->addColumn('jenis', function ($row) {
                    if ($row->jenis_izin == "Cuti") {
                        $result = "<span class='badge bg-danger'>" . $row->jenis_izin . "</span>";
                    } else {
                        $result = "<span class='badge bg-warning'>" . $row->jenis_izin . "</span>";
                    }
                    return $result;
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete.
                    $btn = '';

                    // Menampilkan tombol validasi icon alert
                    if (auth()->user()->can('validasi1_izin')) {
                        $warn = $row->validasi_1 == 0 ? "<span class='tf-icons bx bx-error me-2 text-danger'></span>" : '';
                    }

                    // Menampilkan tombol validasi icon alert
                    if (auth()->user()->can('validasi2_izin')) {
                        $warn = $row->validasi_2 == 0 ? "<span class='tf-icons bx bx-error me-2 text-danger'></span>" : '';
                    }

                    if (auth()->user()->hasRole('Teknisi') && ($row->validasi_1 != 1 || $row->validasi_2 != 1)) {
                        $btn = "<button class='btn btn-secondary btn-sm d-inline me-1' disabled>Menunggu Validasi</button>";
                    }

                    // Jika sudah tervalidasi semua tampilkan tombol sukses
                    if ($row->validasi_1 == 1 && $row->validasi_2 == 1) {
                        if ($row->status_validasi_1 == "ACC" && $row->status_validasi_2 == "ACC") {
                            $btn = "<button class='btn btn-success btn-sm d-inline' data-bs-toggle='modal' data-bs-target='#modalValid' data-id='" . $row->id . "' onclick='validasiData(this)'>Diterima</button>";
                        }

                        if ($row->status_validasi_1 == "Tolak" && $row->status_validasi_2 == "Tolak") {
                            $btn = "<button class='btn btn-danger btn-sm d-inline' data-bs-toggle='modal' data-bs-target='#modalValid' data-id='" . $row->id . "' onclick='validasiData(this)'>Tolak</button>";
                        }
                    } else {
                        if (auth()->user()->can('validasi1_izin') || auth()->user()->can('validasi2_izin')) {
                            $btn = "<button data-bs-toggle='modal' data-bs-target='#modalValid' class='btn btn-info btn-sm d-inline me-1' data-id='" . $row->id . "' onclick='validasiData(this)'>" . $warn . " Validasi</button>";
                        }

                        if (auth()->user()->can('izin_update')) {
                            if (auth()->user()->hasRole('Teknisi') && ($row->validasi_1 == 1 || $row->validasi_2 == 1)) {
                                $btn = $btn . "<a class='btn btn-warning btn-sm d-inline disabled' href='" . route('izin.edit', $row->id) . "' style='padding: 7px;padding-top: 5.5px; padding-left: 10px;padding-right: 10px' ><i class='bx bx-edit'></i></a>";
                            } else {
                                $btn = $btn . "<a class='btn btn-warning btn-sm d-inline' href='" . route('izin.edit', $row->id) . "' style='padding: 7px;padding-top: 5.5px; padding-left: 10px;padding-right: 10px' ><i class='bx bx-edit'></i></a>";
                            }
                        }
                    }

                    if (auth()->user()->can('izin_delete') && ($row->validasi_1 != 1 || $row->validasi_2 != 1)) {
                        $btn = $btn . "<form action=" . route('izin.delete', $row->id) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . " <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'tanggal', 'tanggal-pengajuan', 'file', 'jenis'])
                ->make(true);
        }
    }

    // Ambil data menu untuk datatable
    public function getValidIzin(Request $request)
    {
        if ($request->ajax()) {
            $izin = Izin::find($request->id);
            return response()->json([
                'status' => 'success',
                'id' => $izin->id,
                'validasi1' => $izin->validasi_1,
                'validasi1nama' => $izin->validasi_1_by,
                'validasi1status' => $izin->status_validasi_1,
                'validasi1keterangan' => $izin->keterangan_1,
                'validasi2' => $izin->validasi_2,
                'validasi2nama' => $izin->validasi_2_by,
                'validasi2status' => $izin->status_validasi_2,
                'validasi2keterangan' => $izin->keterangan_2
            ]);
        }
    }

    // Ambil data menu untuk datatable
    public function getJumlahIzin(Request $request)
    {
        if ($request->ajax()) {

            // Mengambil user sesuai regional
            $userSesuaiRegional = User::select('users.id', 'users.name')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->where('regional_id', $request->id)
                ->where('roles.name', 'Teknisi')
                ->get();

            // Variable array
            $jumlahIzin = array();

            // Foreach data user sesuai regional
            foreach ($userSesuaiRegional as $item) {

                // ambil data jumlah izin dimana sesuai dengan $userSesuaiRegional id
                $data = JumlahIzin::select('jumlah_izin.id as jumlahIzin_id', 'users.name', 'users.id', 'jumlah_izin.*')
                    ->where('user_id', $item->id)
                    ->where('tahun', Carbon::now()->format('Y'))
                    ->join('users', 'jumlah_izin.user_id', '=', 'users.id')
                    ->first();

                if ($data) {
                    array_push($jumlahIzin, $data);
                }
            }

            // return response()->json($jumlahIzin);

            // Return datatables
            return DataTables::of(Collection::make($jumlahIzin))
                ->addIndexColumn()
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete.
                    $btn = '';
                    if (auth()->user()->can('jumlah izin_update')) {
                        $btn = "<button data-bs-toggle='modal' data-bs-target='#modalIzinEdit' class='btn btn-warning btn-sm d-inline me-1' data-id='" . $row->jumlahIzin_id . "' onclick='editData(this)'><i class='bx bx-edit'></i></button>";
                    }
                    if (auth()->user()->can('jumlah izin_delete')) {
                        $btn = $btn . "<form action=" . route('pengaturan.izin.delete', $row->jumlahIzin_id) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . " <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // Ambil data menu untuk datatable
    public function getJumlahIzinEdit(Request $request)
    {
        if ($request->ajax()) {
            $jumlahIzin = JumlahIzin::find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $jumlahIzin
            ]);
        }
    }

    // Ambil data menu untuk datatable
    public function getJumlahIzinUser(Request $request)
    {
        if ($request->ajax()) {
            $jumlahIzin = JumlahIzin::select('jumlah_izin')->where('user_id', $request->id)->where('tahun', Carbon::now()->format('Y'))->first();
            if ($jumlahIzin != null) {
                return response()->json([
                    'status' => 'success',
                    'data' => $jumlahIzin
                ]);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'data' => 'Belum Mendapatkan Hak'
                ]);
            }
        }
    }

    public function getAllIzin(Request $request)
    {
        if ($request->ajax()) {

            $izin = Izin::select('izin.*', 'users.foto as userFoto', 'users.name as userName')
                ->join('users', 'izin.user_id', '=', 'users.id')
                ->orderBy('created_at', 'DESC')
                ->get();

            // Return datatables
            return DataTables::of($izin)
                ->addIndexColumn()
                ->addColumn('file', function ($row) {
                    if ($row->foto === "0") {
                        $button = "<button class='btn btn-secondary btn-sm ' disabled >Tidak Ada File</button>";
                    } else {
                        $button = "<a href='" . asset('storage/' . $row->foto) . "' class='btn btn-secondary btn-sm' target='_blank'><span class='tf-icons bx bx-download'></span> Download</a>";
                    }
                    return $button;
                })
                ->addColumn('tanggal', function ($row) {
                    $result = "
                    <div class='me-2'>
                        <small class='text-muted d-block mb-1'>Total Hari : " . $row->total_izin . "</small>
                        <h6 class='mb-0'>(" . Carbon::parse($row->tgl_mulai_izin)->isoFormat('D MMMM Y') . " - " . Carbon::parse($row->tgl_akhir_izin)->isoFormat('D MMMM Y') . ")</h6>
                    </div>
                    ";
                    return $result;
                })
                ->addColumn('tanggal-pengajuan', function ($row) {
                    $result = Carbon::parse($row->created_at)->isoFormat('D MMMM Y');
                    return $result;
                })
                ->addColumn('jenis', function ($row) {
                    if ($row->jenis_izin == "Cuti") {
                        $result = "<span class='badge bg-danger'>" . $row->jenis_izin . "</span>";
                    } else {
                        $result = "<span class='badge bg-warning'>" . $row->jenis_izin . "</span>";
                    }
                    return $result;
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete.
                    $btn = '';

                    // Menampilkan tombol validasi icon alert
                    if (auth()->user()->can('validasi1_izin')) {
                        $warn = $row->validasi_1 == 0 ? "<span class='tf-icons bx bx-error me-2 text-danger'></span>" : '';
                    }

                    // Menampilkan tombol validasi icon alert
                    if (auth()->user()->can('validasi2_izin')) {
                        $warn = $row->validasi_2 == 0 ? "<span class='tf-icons bx bx-error me-2 text-danger'></span>" : '';
                    }

                    if (auth()->user()->hasRole('Teknisi') && ($row->validasi_1 != 1 || $row->validasi_2 != 1)) {
                        $btn = "<button class='btn btn-secondary btn-sm d-inline me-1' disabled>Menunggu Validasi</button>";
                    }

                    // Jika sudah tervalidasi semua tampilkan tombol sukses
                    if ($row->validasi_1 == 1 && $row->validasi_2 == 1) {
                        if ($row->status_validasi_1 == "ACC" && $row->status_validasi_2 == "ACC") {
                            $btn = "<button class='btn btn-success btn-sm d-inline' data-bs-toggle='modal' data-bs-target='#modalValid' data-id='" . $row->id . "' onclick='validasiData(this)'>Diterima</button>";
                        }

                        if ($row->status_validasi_1 == "Tolak" && $row->status_validasi_2 == "Tolak") {
                            $btn = "<button class='btn btn-danger btn-sm d-inline' data-bs-toggle='modal' data-bs-target='#modalValid' data-id='" . $row->id . "' onclick='validasiData(this)'>Tolak</button>";
                        }
                    } else {
                        if (auth()->user()->can('validasi1_izin') || auth()->user()->can('validasi2_izin')) {
                            $btn = "<button data-bs-toggle='modal' data-bs-target='#modalValid' class='btn btn-info btn-sm d-inline me-1' data-id='" . $row->id . "' onclick='validasiData(this)'>" . $warn . " Validasi</button>";
                        }

                        if (auth()->user()->can('izin_update')) {
                            if (auth()->user()->hasRole('Teknisi') && ($row->validasi_1 == 1 || $row->validasi_2 == 1)) {
                                $btn = $btn . "<a class='btn btn-warning btn-sm d-inline disabled' href='" . route('izin.edit', $row->id) . "' style='padding: 7px;padding-top: 5.5px; padding-left: 10px;padding-right: 10px' ><i class='bx bx-edit'></i></a>";
                            } else {
                                $btn = $btn . "<a class='btn btn-warning btn-sm d-inline' href='" . route('izin.edit', $row->id) . "' style='padding: 7px;padding-top: 5.5px; padding-left: 10px;padding-right: 10px' ><i class='bx bx-edit'></i></a>";
                            }
                        }
                    }

                    if (auth()->user()->can('izin_delete') && ($row->validasi_1 != 1 || $row->validasi_2 != 1)) {
                        $btn = $btn . "<form action=" . route('izin.delete', $row->id) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . " <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'tanggal', 'tanggal-pengajuan', 'file', 'jenis'])
                ->make(true);
        }
    }
}
