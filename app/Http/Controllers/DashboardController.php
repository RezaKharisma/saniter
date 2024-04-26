<?php

namespace App\Http\Controllers;

use App\Models\Api\KaryawanTetap;
use App\Models\Api\NamaMaterial;
use App\Models\Menu;
use App\Models\SubMenu;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use function App\Helpers\getUserRole;

class DashboardController extends Controller
{
    public function index(){
        // $nama = new NamaMaterial();
        // dd($nama->getAllMaterial());
        return view('dashboard');
    }

    public function searchMenu(Request $request){
        // $query = Menu::select('menu.icon','sub_menu.judul as judulSub','sub_menu.url as urlSub','menu.judul as judulMenu','menu.url as urlMenu')
        // ->leftJoin('menu_kategori', 'menu.id_kategori', '=', 'menu_kategori.id')
        // ->orderBy('menu_kategori.order', 'ASC')
        // ->orderBy('menu.order', 'ASC')
        // ->where('menu_kategori.show', '1')
        // ->where('menu.show', '1')
        // ->where('sub_menu.judul', 'LIKE', '%'.$request->nama.'%')
        // ->where('menu.judul', 'LIKE', '%'.$request->nama.'%')
        // ->get();

        // return response()->json($query->groupBy(function ($item, $key) {
        //     return $item['nama_kategori'];
        // }));

        $submenu = SubMenu::select('menu.icon','sub_menu.judul as judulSub','sub_menu.url as urlSub','menu.judul as judulMenu','menu.url as urlMenu')
            ->join('menu','sub_menu.id_menu','=','menu.id')
            ->where('menu.show', '1')
            ->where('sub_menu.judul', 'LIKE', '%'.$request->nama.'%')->get();

        $menu = Menu::select('judul','icon','id','url')->where('show', '1')->where('judul','LIKE','%'.$request->nama.'%')->get();

        return response()->json(['Menu' => $menu, 'SubMenu' => $submenu]);
    }
}
