<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
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
                ->select('users.id','users.name', 'regional.nama as regional_name', 'email', 'is_active', 'roles.name as roles_name','foto')
                ->orderBy('id', 'DESC')
                ->get(); // Ambil semua user

            // Return datatables
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    $return = "<div class='d-flex justify-content-start align-items-center user-name'>
                                <div class='avatar-wrapper'>
                                    <div class='avatar avatar-sm me-3'><img src='".asset('storage/'.$row->foto)."' class='rounded-circle' /></div>
                                </div>
                                <div class='d-flex flex-column'>
                                    <span class='fw-medium'>".$row->name."</span>
                                    <small class='text-muted'>".$row->email."</small>
                                </div>
                            </div>
                            ";
                    return $return;
                })
                ->addColumn('is_active', function($row){ // Tambah kolom action untuk button edit dan delete
                    if ($row->roles_name == 'Administrator') {
                        return "<button type='button' class='btn btn-success btn-sm' disabled >Aktif</button>";
                    }else{
                        if (auth()->user()->can('user_update')) {
                            if ($row->is_active == 1) {
                                return "
                                    <form action=".route('user.updateIsActive', $row->id)." method='POST'>".csrf_field().method_field('PUT')."
                                        <button type='button' class='btn btn-success btn-sm confirm-edit-is-active'>Aktif</button>
                                    </form>
                                ";
                            }else{
                                return "
                                <form action=".route('user.updateIsActive', $row->id)." method='POST'>".csrf_field().method_field('PUT')."
                                    <button type='button' class='btn btn-danger btn-sm confirm-edit-is-active'>Tidak Aktif</button>
                                </form>
                                ";
                            }
                        }else{
                            if ($row->is_active == 1) {
                                return "<button type='button' class='btn btn-success btn-sm' disabled >Aktif</button>";
                            }else{
                                return "<button type='button' class='btn btn-danger btn-sm' disabled >Tidak Aktif</button>";
                            }
                        }
                    }
                })
                ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete
                    $btn = "<button type='button' class='btn btn-info btn-sm me-1' data-id='".$row->id."' onclick='detailData(this)'><i class='bx bx-detail'></i></button>";
                    if (auth()->user()->can('user_update')) {
                        $btn = $btn."<a href='".route('user.edit', $row->id)."' class='btn btn-warning btn-sm'><i class='bx bx-edit'></i></button></a>";
                    }
                    if (auth()->user()->can('user_delete')) {
                        if($row->roles_name != 'Administrator'){
                            $btn = $btn."<form action=".route('user.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action','is_active','name'])
                ->make(true);
        }
    }

    public function getUserDetail(Request $request)
    {
        if ($request->ajax()) {
            $user = User::select('users.name','users.nik','users.telp','users.foto','users.ttd','users.alamat_ktp','users.alamat_dom','regional.nama as regional_name', 'email', 'is_active', 'roles.name as roles_name','lokasi.nama_bandara as bandara','lokasi.lokasi_proyek as lokasi')
            ->join('regional', 'users.regional_id', '=', 'regional.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('lokasi', 'users.lokasi_id', '=', 'lokasi.id')
            ->where('users.id', $request->id)
            ->first();

            $modal = view('components.modals.detail-user', compact('user'))->render();

            return response()->json([
                'status' => 'success',
                'data' => $user,
                'modal' => $modal
            ]);
        }
    }

    public function getLokasiKerja(Request $request){
        if ($request->ajax()) {
            $lokasi = Lokasi::select('id','nama_bandara','lokasi_proyek')->where('regional_id', $request->id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $lokasi,
            ]);
        }
    }
}
