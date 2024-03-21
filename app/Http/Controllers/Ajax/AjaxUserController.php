<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class AjaxUserController extends Controller
{
    public function getUser(Request $request){
        if ($request->ajax()) {
            $users = User::join('regional', 'users.regional_id', '=', 'regional.id')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.id','users.name', 'regional.nama as regional_name', 'email', 'is_active', 'roles.name as roles_name')
                ->get(); // Ambil semua user

            // Return datatables
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('is_active', function($row){ // Tambah kolom action untuk button edit dan delete
                    if ($row->is_active == 1) {
                        return "
                            <form action=".route('user.updateIsActive', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('PUT')."
                                <button type='button' class='btn btn-success btn-sm confirm-edit-is-active'>Aktif</button>
                            </form>
                        ";
                    }else{
                        return "
                        <form action=".route('user.updateIsActive', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('PUT')."
                            <button type='button' class='btn btn-danger btn-sm confirm-edit-is-active'>Tidak Aktif</button>
                        </form>
                        ";
                    }
                })
                ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete
                    $btn = "<button type='button' class='btn btn-info btn-sm me-1' data-id='".$row->id."' onclick='detailData(this)'> Detail </button>";
                    if ($row['name'] != 'Admin') {
                        $btn = $btn."<a href='".route('user.edit', $row->id)."' class='btn btn-warning btn-sm'>Ubah</button></a>";
                        $btn = $btn."<form action=".route('user.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                    }
                    return $btn;
                })
                ->rawColumns(['action','is_active'])
                ->make(true);
        }
    }

    public function getUserDetail(Request $request)
    {
        if ($request->ajax()) {
            $user = User::where('users.id', $request->id)
            ->join('regional', 'users.regional_id', '=', 'regional.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.name','users.nik','users.telp','users.foto','regional.nama as regional_name', 'email', 'is_active', 'roles.name as roles_name')
            ->first();

            $modal = view('modals.detail-user', compact('user'))->render();

            return response()->json([
                'status' => 'success',
                'data' => $user,
                'modal' => $modal
            ]);
        }
    }
}
