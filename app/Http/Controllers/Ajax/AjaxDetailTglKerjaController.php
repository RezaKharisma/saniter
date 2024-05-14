<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\AreaList;
use App\Models\DetailItemPekerjaan;
use App\Models\DetailPekerja;
use App\Models\DetailTglKerja;
use App\Models\JenisKerusakan;
use App\Models\Lokasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxDetailTglKerjaController extends Controller
{
    public $tglKerjaId;
    public function getDetailTglKerja(Request $request)
    {
        if ($request->ajax()) {
            $this->tglKerjaId = $request->id;

            $tgl = DetailTglKerja::select('detail_tgl_kerja.*', 'regional.nama as regionalName')
                ->where('tgl_kerja_id', $this->tglKerjaId)
                ->join('list_area', 'detail_tgl_kerja.list_area_id', '=', 'list_area.id')
                ->join('area', 'list_area.area_id', '=', 'area.id')
                ->join('regional', 'area.regional_id', '=', 'regional.id')
                ->orderBy('detail_tgl_kerja.id', 'DESC');

            if (!auth()->user()->can('tanggal kerja_all data')) {
                $tgl->where('regional.id', auth()->user()->regional_id);
            }

            // Return datatables
            return DataTables::of($tgl->get())
                ->addIndexColumn()
                ->addColumn('total', function($row){
                    $jenisKerusakan = JenisKerusakan::where('detail_tgl_kerja_id', $row->id)->get();
                    return count($jenisKerusakan);
                })
                ->addColumn('jam', function ($row) {
                    return Carbon::parse($row->created_at)->isoFormat('LT') . " " . ucfirst(Carbon::parse($row->created_at)->isoFormat('A'));
                })
                ->addColumn('lokasi', function ($row) {
                    $listArea = AreaList::select('list_area.lantai', 'list_area.nama', 'list_area.nama as listNama', 'area.nama as areaNama')->join('area', 'list_area.area_id', '=', 'area.id')->where('list_area.id', $row->list_area_id)->first();
                    // $area = Area::where('id', $row->list_area_id)->first();
                    return "<p class='mb-0'>$listArea->areaNama</p><p class='mb-0'>$listArea->lantai - $listArea->nama</p>";
                })
                ->addColumn('tanggal', function ($row) {
                    return Carbon::parse($row->tanggal)->isoFormat('dddd, d MMMM Y');
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete.
                    $btn = '';
                    $btn = "<a class='btn btn-info btn-sm me-1' href='" . route('jenis-kerusakan.index', $row->id) . "'>Detail Kerusakan</a>";
                    // if (auth()->user()->can('detail tanggal kerja_update')) {
                    //     $btn = $btn."<a class='btn btn-warning btn-sm  me-1' href='".route('detail-data-proyek.delete', $row->id)."' >Ubah</a>";
                    // }

                    // $jenisKerusakan = JenisKerusakan::join('detail_tgl_kerja','jenis_kerusakan.detail_tgl_kerja_id','=','detail_tgl_kerja.id')
                    //     ->where('detail_tgl_kerja.tgl_kerja_id', $tglKerja->id)->get();

                    $jenisKerusakan = JenisKerusakan::where('detail_tgl_kerja_id', $row->id)->get();

                    if (count($jenisKerusakan) == 0) {
                        if (auth()->user()->can('detail tanggal kerja_update')) {
                            $btn = $btn . "<form action=" . route('detail-data-proyek.delete', $row->id) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . "<input type='hidden' value='$this->tglKerjaId' name='tgl_kerja_id'> <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'lokasi', 'tanggal', 'jam', 'total'])
                ->make(true);
        }
    }

    public function getLokasiKerusakan(Request $request)
    {
        if ($request->ajax()) {
            $area = Area::select('id')->where('regional_id', auth()->user()->regional_id)->get();

            $area_id = array();
            foreach ($area as $value) {
                array_push($area_id, $value->id);
            }

            $listArea = AreaList::select('list_area.id', 'list_area.nama', 'list_area.lantai', 'area.nama as areaNama')->whereIn('area_id', $area_id)->join('area', 'list_area.area_id', '=', 'area.id')->get();

            return response()->json([
                'status' => 'success',
                'data' => $listArea
            ]);
        }
    }

    public function getDenahLokasi(Request $request)
    {
        if ($request->ajax()) {
            $listArea = AreaList::select('list_area.denah')->where('id', $request->id)->first();
            return response()->json([
                'status' => 'success',
                'data' => $listArea
            ]);
        }
    }
}
