<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SubMenuController extends Controller
{
    public function index(){
        $menu = Menu::select('menu.id', 'menu.judul')->orderBy('id', 'DESC')->get();
        return view('pengaturan.sub-menu.index', compact('menu'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[ // Validasi request dari form tambah menu
            'id_menu' => 'required',
            'judul' => 'required|unique:sub_menu,judul',
            'order' => 'required',
            'url' => 'required'
        ], ['id_menu.required' => 'menu wajib diisi.']);


        if ($validator->fails()) { // Jika validasi gagal
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        SubMenu::create([ // Insert data baru pada database
            'id_menu' => $request->id_menu, // Ambil request sesuai name input
            'judul' => $request->judul,
            'order' => $request->order,
            'url' => trim($request->url)
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::back();
    }
}
