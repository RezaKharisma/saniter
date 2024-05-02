<?php

namespace App\Http\Controllers;

use App\Models\Api\KaryawanTetap;
use App\Models\Api\NamaMaterial;
use App\Models\Api\User;
use App\Models\Menu;
use App\Models\SubMenu;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use function App\Helpers\getUserRole;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }

    public function searchMenu(Request $request){
        $submenu = SubMenu::select('menu.icon','sub_menu.judul as judulSub','sub_menu.url as urlSub','menu.judul as judulMenu','menu.url as urlMenu')
            ->join('menu','sub_menu.id_menu','=','menu.id')
            ->where('menu.show', '1')
            ->where('sub_menu.judul', 'LIKE', '%'.$request->nama.'%')->get();

        $menu = Menu::select('judul','icon','id','url')->where('show', '1')->where('judul','LIKE','%'.$request->nama.'%')->get();

        return response()->json(['Menu' => $menu, 'SubMenu' => $submenu]);
    }
}
