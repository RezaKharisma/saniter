<?php

use App\Models\Menu;
use App\Models\MenuKategori;
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
        $query = Menu::select('menu.*', 'menu_kategori.nama_kategori')
        ->leftJoin('menu_kategori', 'menu.id_kategori', '=', 'menu_kategori.id')
        ->orderBy('menu_kategori.order', 'ASC')
        ->get();

        return $query->groupBy(function ($item, $key) {
            return $item['nama_kategori'];
        });
    }
}

if (! function_exists('getSubMenu')) {
    function getSubMenu($id)
    {
        $query = SubMenu::select('sub_menu.*')
            ->where('id_menu', $id)
            ->orderBy('order', 'ASC')
            ->get();
        return $query;
    }
}


