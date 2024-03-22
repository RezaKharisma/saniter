<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\KategoriMenu;
use App\Models\Lokasi;
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

            // Menu::create([
            //     'id_kategori' => $i+1,
            //     'judul' => $menu[$i],
            //     'order' => $i,
            //     'url' => strtolower($kategori[$i]."/".$menu[$i]),
            //     'icon' => 'menu'
            // ]);
        }

        User::create([
            'regional_id' => 1,
            'role_id' => 1,
            'lokasi_id' => 1,
            'name' => 'Admin Saniter',
            'email' => 'admin@gmail.com',
            'nik' => '5171012103010002',
            'telp' => '0819034078903',
            'password' => Hash::make('admin'),
            'is_active' => 1
        ]);

        User::create([
            'regional_id' => 2,
            'role_id' => 2,
            'lokasi_id' => 1,
            'name' => 'Staff Saniter',
            'email' => 'staff@gmail.com',
            'nik' => '5171012103010002',
            'telp' => '0819034078902',
            'password' => Hash::make('staff'),
            'is_active' => 1
        ]);

        User::create([
            'regional_id' => 3,
            'role_id' => 3,
            'lokasi_id' => 1,
            'name' => 'Teknisi Saniter',
            'email' => 'teknisi@gmail.com',
            'nik' => '5171012103010002',
            'telp' => '0819034078901',
            'password' => Hash::make('teknisi'),
            'is_active' => 1
        ]);

        for ($i=1; $i <= 5; $i++) {
            Lokasi::create([
                'regional_id' => $i,
                'nama_bandara' => fake()->country(),
                'lokasi_proyek' => fake()->address(),
                'latitude' => rand(100000,500000),
                'longitude' => rand(100000,500000),
                'radius' => rand(10,200)
            ]);
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
