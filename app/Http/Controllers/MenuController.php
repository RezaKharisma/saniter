<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuKategori;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index(){
        $kategori = MenuKategori::select('id','nama_kategori')->get(); // Select menu kategori
        return view('pengaturan.menu.index', compact('kategori')); // Passing data ke view
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[ // Validasi request dari form tambah menu
            'id_kategori' => 'required',
            'judul' => 'required|unique:menu,judul',
            'order' => 'required',
            'url' => 'required'
        ], ['id_kategori.required' => 'kategori wajib diisi.']);


        if ($validator->fails()) { // Jika validasi gagal
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        Menu::create([ // Insert data baru pada database
            'id_kategori' => $request->id_kategori, // Ambil request sesuai name input
            'judul' => $request->judul,
            'order' => $request->order,
            'url' => trim($request->url)
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::back();
    }

    public function edit($id){
        return "Edit";
    }

    public function delete($id){ // Id pada parameter url

        $menu = Menu::find($id); // Cari menu berdasarkan id
        $subMenu = SubMenu::where('id_menu', $id); // Cari sub menu berdasarkan id_menu FK

        // Delete menu tersebut dan sub menu
        $menu->delete();
        $subMenu->delete();

        // Redirect kembali
        toast('Data berhasil terhapus!', 'success');
        return Redirect::back();
    }
}
