<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class AjaxRoleController extends Controller
{
    public function getRole(Request $request){
        if ($request->ajax()) {

            // Query menu join kategori
            $menu = Role::with('permissions')->get();

            // Return datatables
            return DataTables::of($menu)
                ->addIndexColumn()
                ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete
                    $btn = "<a class='btn btn-info btn-sm d-inline me-1' href='".route('pengaturan.role.edit', $row->id)."'>Info</a>";
                    $btn = $btn."<form action=".route('pengaturan.role.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // Ambil data menu untuk datatable
    public function getRoleEdit(Request $request){
        if ($request->ajax()) {
            $menu = Role::with('permissions')->find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $menu
            ]);
        }
    }

    public function getPermission(Request $request){
        if ($request->ajax()) {

            // Query menu join kategori
            $menu = Permission::orderBy('id', 'DESC')->get();

            // Return datatables
            return DataTables::of($menu)
                ->addIndexColumn()
                ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete
                    $btn = "<button data-bs-toggle='modal' data-bs-target='#modalEditRole' class='btn btn-primary btn-sm d-inline me-1' data-id='".$row->id."' onclick='editData(this)'>Ubah</button>";
                    $btn = $btn."<form action=".route('pengaturan.permission.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
