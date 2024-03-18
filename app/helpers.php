<?php

use App\Models\Menu;
use App\Models\MenuKategori;
use App\Models\Regional;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

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

if (! function_exists('getCheckedMenu')) {
    function getCheckedMenu($rolePermission, $judulMenu)
    {
        $group = 0;
        foreach ($rolePermission as $value) {
            $menu = Menu::select('judul')->find($value->id_menu);

            if ($menu->judul == $judulMenu) {
                $group += 1;
            }
        }
        return $group;
    }
}

if (! function_exists('getCheckedUserMenu')) {
    function getCheckedUserMenu($userPermissions, $judulMenu = null)
    {
        $group = 0;
        foreach ($userPermissions as $value) {
            // return $value;
            $permission = Permission::findByName($value);
            $menu = Menu::select('judul')->find($permission->id_menu);

            if ($menu->judul == $judulMenu) {
                $group += 1;
            }
        }
        return $group;
    }
}


