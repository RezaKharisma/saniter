<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\ItemPekerjaan;
use App\Models\KategoriPekerjaan;
use App\Models\Pekerja;
use App\Models\SubKategoriPekerjaan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxPekerjaController extends Controller
{
    public function getPekerja(Request $request)
    {
        if ($request->ajax()) {
            $pekerja = Pekerja::orderBy('id', 'DESC')->get();

            // Return datatables
            return DataTables::of($pekerja)
                ->addIndexColumn()
                ->addColumn('upah', function ($row) {
                    return "Rp. " . number_format($row->upah, 0, '', '.') . " " . $row->satuan;
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete
                    $btn = '';
                    if (auth()->user()->can('pekerja_update')) {
                        $btn = "<button class='btn btn-warning btn-sm' data-id='" . $row->id . "' onclick='editData(this)'><i class='bx bx-edit'></i></button></a>";
                    }
                    if (auth()->user()->can('pekerja_delete')) {
                        if ($row->roles_name != 'Administrator') {
                            $btn = $btn . "<form action=" . route('jenis-pekerja.delete', $row->id) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . " <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'upah'])
                ->make(true);
        }
    }

    public function getEditPekerja(Request $request)
    {
        if ($request->ajax()) {
            $pekerja = Pekerja::find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $pekerja
            ]);
        }
    }

    public function getKategoriPekerja(Request $request)
    {
        if ($request->ajax()) {
            $kategori = KategoriPekerjaan::select('kategori_pekerjaan.*')
                // ->join('pekerja', 'kategori_pekerjaan.id_pekerja', '=', 'pekerja.id')
                ->orderBy('id', 'DESC')
                ->get();

            // Return datatables
            return DataTables::of($kategori)
                ->addIndexColumn()
                // ->addColumn('pekerja', function ($row) {
                //     return $row->namaPekerja;
                // })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete
                    $btn = '';
                    if (auth()->user()->can('kategori pekerjaan_update')) {
                        $btn = "<button class='btn btn-warning btn-sm' data-id='" . $row->id . "' onclick='editData(this)'><i class='bx bx-edit'></i></button></a>";
                    }
                    if (auth()->user()->can('kategori pekerjaan_delete')) {
                        if ($row->roles_name != 'Administrator') {
                            $btn = $btn . "<form action=" . route('kategori-pekerjaan.delete', $row->id) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . " <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'pekerja'])
                ->make(true);
        }
    }

    public function getEditKategoriPekerja(Request $request)
    {
        if ($request->ajax()) {
            $pekerja = KategoriPekerjaan::find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $pekerja
            ]);
        }
    }

    public function getSubKategoriPekerja(Request $request)
    {
        if ($request->ajax()) {
            $kategori = SubKategoriPekerjaan::select('sub_kategori_pekerjaan.*', 'sub_kategori_pekerjaan.id as subID', 'kategori_pekerjaan.nama as namaKategori')
                ->join('kategori_pekerjaan', 'sub_kategori_pekerjaan.id_kategori_pekerjaan', '=', 'kategori_pekerjaan.id')
                ->orderBy('id', 'DESC')
                ->get();

            // Return datatables
            return DataTables::of($kategori)
                ->addIndexColumn()
                ->addColumn('kategori', function ($row) {
                    return $row->namaKategori;
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete
                    $btn = '';
                    if (auth()->user()->can('sub kategori pekerjaan_update')) {
                        $btn = "<button class='btn btn-warning btn-sm' data-id='" . $row->subID . "' onclick='editData(this)'><i class='bx bx-edit'></i></button></a>";
                    }
                    if (auth()->user()->can('sub kategori pekerjaan_delete')) {
                        if ($row->roles_name != 'Administrator') {
                            $btn = $btn . "<form action=" . route('sub-kategori-pekerjaan.delete', $row->subID) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . " <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'kategori'])
                ->make(true);
        }
    }

    public function getEditSubKategoriPekerja(Request $request)
    {
        if ($request->ajax()) {
            $pekerja = SubKategoriPekerjaan::find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $pekerja
            ]);
        }
    }

    public function getItemPekerja(Request $request)
    {
        if ($request->ajax()) {
            $itemPekerjaan = ItemPekerjaan::select('item_pekerjaan.*', 'item_pekerjaan.id as itemID', 'sub_kategori_pekerjaan.nama as subNama')
                ->join('sub_kategori_pekerjaan', 'item_pekerjaan.id_sub_kategori_pekerjaan', '=', 'sub_kategori_pekerjaan.id')
                ->get();

            // Return datatables
            return DataTables::of($itemPekerjaan)
                ->addIndexColumn()
                ->addColumn('subKategori', function ($row) {
                    return $row->subNama;
                })
                ->addColumn('volume', function ($row) {
                    return $row->volume . " / " . $row->satuan;
                })
                ->addColumn('harga', function ($row) {
                    return "Rp. " . number_format($row->harga, 0, '', '.');
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete
                    $btn = '';
                    if (auth()->user()->can('item pekerjaan_update')) {
                        $btn = "<button class='btn btn-info btn-sm' data-id='" . $row->itemID . "' onclick='editData(this)'><i class='bx bx-detail'></i></button></a>";
                    }
                    if (auth()->user()->can('item pekerjaan_delete')) {
                        if ($row->roles_name != 'Administrator') {
                            $btn = $btn . "<form action=" . route('item-pekerjaan.delete', $row->itemID) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . " <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'subKategori', 'volume', 'harga'])
                ->make(true);
        }
    }

    public function getEditItemPekerja(Request $request)
    {
        if ($request->ajax()) {
            $itemPekerja = ItemPekerjaan::find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $itemPekerja
            ]);
        }
    }
}
