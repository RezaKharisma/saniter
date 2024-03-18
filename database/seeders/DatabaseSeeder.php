<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\MenuKategori;
use App\Models\Regional;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $regional = ['Timur', 'Tengah', 'Barat', 'Pusat'];
        $kategori = ['Rekapan', 'Proyek', 'Administrasi', 'Pengaturan'];
        $menu = ['User', 'Absen', 'Laporan', 'Dokumen'];
        for ($i=0; $i < count($regional); $i++) {
            Regional::create([
                'nama' => $regional[$i]
            ]);

            KategoriMenu::create([
                'nama_kategori' => $kategori[$i],
                'order' => $i
            ]);

            Menu::create([
                'id_kategori' => $i+1,
                'judul' => $menu[$i],
                'order' => $i,
                'url' => strtolower($kategori[$i]."/".$menu[$i]),
                'icon' => 'menu'
            ]);
        }

        User::create([
            'id_regional' => 1,
            'name' => 'Admin Saniter',
            'email' => 'admin@gmail.com',
            'nik' => '5171012103010002',
            'telp' => '081903407890',
            'password' => Hash::make('admin')
        ]);

        User::create([
            'id_regional' => 2,
            'name' => 'Staff Saniter',
            'email' => 'staff@gmail.com',
            'nik' => '5171012103010002',
            'telp' => '081903407890',
            'password' => Hash::make('staff')
        ]);

        User::create([
            'id_regional' => 3,
            'name' => 'Teknisi Saniter',
            'email' => 'teknisi@gmail.com',
            'nik' => '5171012103010002',
            'telp' => '081903407890',
            'password' => Hash::make('teknisi')
        ]);

        for ($i=1; $i <= 5; $i++) {

        }

        $this->call(PermissionSeeder::class);

        $user = User::find(1);
        $user->assignRole(['Admin']);

        $user = User::find(2);
        $user->assignRole(['Staff']);

        $user = User::find(3);
        $user->assignRole(['Teknisi']);
    }
}
