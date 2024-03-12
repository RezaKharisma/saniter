<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\MenuDataTable;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AjaxMenuController extends Controller
{
    // Ambil data menu untuk datatable
    public function getMenu(Request $request){
        if ($request->ajax()) {

            // Query menu join kategori
            $menu = Menu::join('menu_kategori', 'menu.id_kategori', '=', 'menu_kategori.id')
                ->select('menu.*','menu_kategori.nama_kategori')
                ->orderBy('menu.id', 'DESC')
                ->get();

            // Return datatables
            return DataTables::of($menu)
                ->addIndexColumn()
                ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete
                    $btn = "<button data-bs-toggle='modal' data-bs-target='#modalMenu' class='btn btn-primary btn-sm d-inline me-1' data-id='".$row->id."' onclick='editData(this)'>Ubah</button>";
                    $btn = $btn."<form action=".route('pengaturan.menu.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Delete</button></form>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // Ambil data menu untuk datatable
    public function getMenuEdit(Request $request){
        if ($request->ajax()) {

            $menu = Menu::find($request->id);
            return response()->json($menu);
        }
    }

    public function getSubMenu(Request $request){
        if ($request->ajax()) {

            // Query menu join kategori
            $menu = SubMenu::join('menu', 'sub_menu.id_menu', '=', 'menu.id')
                ->select('sub_menu.*','menu.judul AS judul_menu')
                ->orderBy('sub_menu.id', 'DESC')
                ->get();

            // Return datatables
            return DataTables::of($menu)
                ->addIndexColumn()
                ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete
                    $btn = "<a href='".route('pengaturan.menu.edit', $row->id)."' class='btn btn-primary btn-sm d-inline me-1'>Ubah</a>";
                    $btn = $btn."<form action=".route('pengaturan.menu.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Delete</button></form>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
