<?php

namespace App\Http\Controllers;

use App\Models\Api\NamaMaterial;
use App\Models\AreaList;
use App\Models\DetailTglKerja;
use App\Models\JenisKerusakan;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class JenisKerusakanController extends Controller
{
    public function index($id){
        $detailKerja = DetailTglKerja::select('id','tgl_kerja_id','list_area_id')->find($id);

        $area = AreaList::select('list_area.id','lantai','list_area.nama as listNama','denah','area.nama as areaNama')
            ->join('area','list_area.area_id','=','area.id')
            ->where('list_area.id', $detailKerja->list_area_id)
            ->first();

        $jenisKerusakan = JenisKerusakan::where('detail_tgl_kerja_id',$detailKerja->id)->get();

        return view('proyek.jenis-kerusakan.index', compact('detailKerja','area','jenisKerusakan'));
    }

    public function create($id){
        $detailKerja = DetailTglKerja::select('detail_tgl_kerja.id','list_area.denah')
            ->join('list_area','detail_tgl_kerja.list_area_id','=','list_area.id')
            ->find($id);

        $stokMaterial = StokMaterial::select('id','nama_material')
            ->where('diterima_pm', 1)
            ->where('diterima_spv', 1)
            ->where('status_validasi_pm', 'ACC')
            ->whereNot('status_validasi_pm', 'Tolak')
            ->get();
        return view('proyek.jenis-kerusakan.create', compact('detailKerja','stokMaterial'));
    }

    public function store(Request $request){
        dd($request);
    }
}
