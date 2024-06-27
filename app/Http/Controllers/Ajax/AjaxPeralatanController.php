<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Peralatan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxPeralatanController extends Controller
{
    public function getPeralatan(Request $request)
    {
        if ($request->ajax()) {
            $pekerja = Peralatan::orderBy('id', 'DESC')->get();

            // Return datatables
            return DataTables::of($pekerja)
                ->addIndexColumn()
                ->addColumn('harga', function ($row) {
                    return "Rp. " . number_format($row->harga, 0, '', '.') . " / " . $row->satuan;
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete
                    $btn = '';
                    if (auth()->user()->can('peralatan_update')) {
                        $btn = "<button class='btn btn-warning btn-sm' data-id='" . $row->id . "' onclick='editData(this)'><i class='bx bx-edit'></i></button></a>";
                    }
                    if (auth()->user()->can('peralatan_update')) {
                        if ($row->roles_name != 'Administrator') {
                            $btn = $btn . "<form action=" . route('peralatan.delete', $row->id) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . " <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'harga'])
                ->make(true);
        }
    }

    public function getEditPeralatan(Request $request)
    {
        if ($request->ajax()) {
            $pekerja = Peralatan::find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $pekerja
            ]);
        }
    }

    public function getListPeralatanHtml(Request $request)
    {
    }
}
