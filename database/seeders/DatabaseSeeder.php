<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $role = ['Administrator', 'Staff', 'Teknisi'];
        $regional = ['Timur', 'Tengah', 'Barat'];

        for ($i=0; $i < count($role); $i++) {
            UserRole::create([
                'role' => $role[$i]
            ]);

            Regional::create([
                'nama' => $regional[$i]
            ]);
        }

        User::create([
            'id_role' => 1,
            'id_regional' => 1,
            'name' => 'Admin Saniter',
            'email' => 'admin@gmail.com',
            'nik' => '5171012103010002',
            'telp' => '081903407890',
            'active' => 1,
            'password' => Hash::make('admin')
        ]);


    }
}
