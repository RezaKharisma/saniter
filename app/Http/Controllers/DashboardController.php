<?php

namespace App\Http\Controllers;

use App\Models\Api\KaryawanTetap;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use function App\Helpers\getUserRole;

class DashboardController extends Controller
{
    public function index(){
        // $user = new KaryawanTetap();
        // $arr = array();
        // foreach($user->getAllKaryawanTetap() as $item){
        //     array_push($arr, $item['regional']);
        // }
        // dd(array_unique($arr));
        return view('dashboard');
    }
}
