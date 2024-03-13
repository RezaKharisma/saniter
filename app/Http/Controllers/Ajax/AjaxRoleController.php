<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxRoleController extends Controller
{
    public function getRole(Request $request){
        if ($request->ajax()) {

            // Query menu join kategori
            $menu = Role::orderBy('id', 'DESC')->get();

            // Return datatables
            return DataTables::of($menu)
                ->addIndexColumn()
                ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete
                    $btn = "<button data-bs-toggle='modal' data-bs-target='#modalEditRole' class='btn btn-primary btn-sm d-inline me-1' data-id='".$row->id."' onclick='editData(this)'>Ubah</button>";
                    $btn = $btn."<form action=".route('pengaturan.menu.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // Ambil data menu untuk datatable
    public function getRoleEdit(Request $request){
        if ($request->ajax()) {
            $menu = Role::find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $menu
            ]);
        }
    }
}
