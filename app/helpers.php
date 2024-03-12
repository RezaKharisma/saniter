<?php

use App\Models\Regional;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;

if (! function_exists('getRegional')) {
    function getRegional($id)
    {
        $query = Regional::where('id', $id)->first();
        return $query->nama;
    }
}

if (! function_exists('getMenu')) {
    function getMenu()
    {
        $query = SubMenu::select('sub_menu.*','menu.judul')
            ->join('menu', 'sub_menu.id_menu', '=', 'menu.id')
            ->join('menu_kategori', 'menu.id_kategori', '=', 'menu_kategori.id')
            ->get();
        return $query;
    }
}
