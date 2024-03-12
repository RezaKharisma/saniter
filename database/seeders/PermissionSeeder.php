<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleTeknisi = Role::create(['name' => 'Teknisi']);
        $roleStaff = Role::create(['name' => 'Staff']);
        $roleRegionalPusat = Role::create(['name' => 'Regional Pusat']);
        $roleRegionalTimur = Role::create(['name' => 'Regional Timur']);
        $roleRegionalBarat = Role::create(['name' => 'Regional Barat']);

        $view = Permission::create(['name' => 'view']);
        $create = Permission::create(['name' => 'create']);
        $update = Permission::create(['name' => 'update']);
        $delete = Permission::create(['name' => 'delete']);

        $roleAdmin->givePermissionTo($view, $create, $update, $delete);
        $roleTeknisi->givePermissionTo($view, $update);
        $roleStaff->givePermissionTo($view, $create, $update);
        $roleRegionalPusat->givePermissionTo($view, $create, $update);
        $roleRegionalTimur->givePermissionTo($view, $create, $update);
        $roleRegionalBarat->givePermissionTo($view, $create, $update);

        $user = User::find(1);
        $user->assignRole(['Admin','Regional Pusat']);
    }
}
