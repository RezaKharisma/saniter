<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\KategoriMenu;
use App\Models\Lokasi;
use App\Models\Menu;
use App\Models\MenuKategori;
use App\Models\Regional;
use App\Models\Shift;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BackupSeeder::class);

        // DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[1, 'Barat', '-6.299706065145467', '106.72254088949181', '2024-04-03 12:08:13', '2024-04-03 13:26:58', NULL]);
        // DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[2, 'Tengah', '-7.245696806718458', '112.73892431229427', '2024-04-03 12:08:13', '2024-04-03 13:27:48', NULL]);
        // DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[3, 'Pusat', '-8.661063', '115.214712', '2024-04-03 12:08:13', '2024-04-03 12:08:13', NULL]);
        // DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[5, 'Pusat-BSD', '0', '0', '2024-04-04 07:30:33', '2024-04-04 07:30:33', NULL]);
        // DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[6, 'Pusat-Finance', '0', '0', '2024-04-04 07:30:33', '2024-04-04 07:30:33', NULL]);
        // DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[7, 'Pusat-Teknik', '0', '0', '2024-04-04 07:30:33', '2024-04-04 07:30:33', NULL]);
        // DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[8, 'Jakarta', '0', '0', '2024-04-04 07:30:33', '2024-04-04 07:30:33', NULL]);
        // DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[9, 'Dirtek', '0', '0', '2024-04-04 07:30:33', '2024-04-04 07:30:33', NULL]);

        // DB::insert('insert into lokasi (id, regional_id, nama_bandara, lokasi_proyek, latitude, longitude, radius, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',[1, 3, 'Kantor Pusat', 'Kantor Pusat', '-8.661063', '115.214712', 150, '2024-04-03 13:33:21', '2024-04-03 13:33:21', NULL]);
        // DB::insert('insert into lokasi (id, regional_id, nama_bandara, lokasi_proyek, latitude, longitude, radius, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',[2, 3, 'Bandara I Gusti Ngurah Rai', 'Terminal 1', '-8.743818514032556', '115.16517094178465', 100, '2024-04-03 13:34:33', '2024-04-03 13:34:33', NULL]);
        // DB::insert('insert into lokasi (id, regional_id, nama_bandara, lokasi_proyek, latitude, longitude, radius, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',[3, 3, 'Pemogan', 'Kubu Dukuh', '-8.70431439338925', '115.19760441686176', 150, '2024-04-03 13:52:00', '2024-04-03 13:52:00', NULL]);

        // DB::insert('insert into menu_kategori (`id`, `nama_kategori`, `order`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Pengaturan', 3, 1, '2024-04-03 12:08:44', '2024-04-03 23:28:49']);
        // DB::insert('insert into menu_kategori (`id`, `nama_kategori`, `order`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Administrasi', 1, 1, '2024-04-03 12:42:39', '2024-04-03 12:42:39']);
        // DB::insert('insert into menu_kategori (`id`, `nama_kategori`, `order`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[3, 'Material', 2, 1, '2024-04-03 23:28:36', '2024-04-03 23:28:36']);
        // DB::insert('insert into menu_kategori (`id`, `nama_kategori`, `order`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[4, 'Proyek', 2, 1, '2024-04-09 05:27:03', '2024-04-09 05:27:03']);

        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[1, 1, 'Manajemen Menu', 1, 'pengaturan/manajemen-menu', 'menu', 0, '2024-04-03 12:09:06', '2024-04-03 13:11:54']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[2, 1, 'Manajemen Role', 2, 'pengaturan/manajemen-role', 'user-circle', 0, '2024-04-03 12:12:01', '2024-04-03 13:12:05']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[3, 1, 'Manajemen Sistem', 3, 'pengaturan/manajemen-sistem', 'cog', 0, '2024-04-03 12:31:20', '2024-04-03 13:12:12']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[4, 2, 'User', 1, 'administrasi/user', 'user', 1, '2024-04-03 12:43:28', '2024-04-03 12:43:28']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[5, 2, 'Absen', 2, 'administrasi/absen', 'book-content', 1, '2024-04-03 12:52:45', '2024-04-03 12:52:45']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[6, 2, 'Izin', 3, 'administrasi/izin', 'task-x', 1, '2024-04-03 12:53:12', '2024-04-03 13:12:25']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[7, 1, 'Regional', 1, 'pengaturan/regional', 'map-pin', 1, '2024-04-03 13:12:48', '2024-04-03 13:12:48']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[8, 1, 'Lokasi', 2, 'pengaturan/lokasi', 'map', 1, '2024-04-03 13:32:35', '2024-04-03 13:32:35']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[9, 1, 'Jumlah Izin', 3, 'pengaturan/jumlah-izin', 'cog', 1, '2024-04-03 14:42:24', '2024-04-03 14:42:24']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[10, 3, 'Nama Material', 1, 'material/nama-material', 'detail', 1, '2024-04-03 23:32:27', '2024-04-03 23:33:53']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[11, 3, 'Stok Material', 2, 'material/stok-material', 'layer-plus', 1, '2024-04-04 00:03:43', '2024-04-04 00:03:43']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[12, 4, 'Data Proyek', 1, 'proyek/data-proyek', 'briefcase-alt-2', 1, '2024-04-09 05:49:02', '2024-04-09 05:49:02']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[13, 1, 'Area', 4, 'pengaturan/area', 'map-alt', 1, '2024-04-09 06:02:04', '2024-04-09 06:02:04']);
        // DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[14, 1, 'Area List', 5, 'pengaturan/list-area', 'sitemap', 1, '2024-04-09 07:22:21', '2024-04-09 08:07:49']);


        // DB::insert('insert into sub_menu (`id`, `id_menu`, `judul`, `order`, `url`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?)',[1, 1, 'Menu', 2, 'menu', '2024-04-03 12:10:00', '2024-04-03 12:10:00']);
        // DB::insert('insert into sub_menu (`id`, `id_menu`, `judul`, `order`, `url`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?)',[2, 1, 'Kategori', 1, 'kategori', '2024-04-03 12:10:11', '2024-04-03 12:10:11']);
        // DB::insert('insert into sub_menu (`id`, `id_menu`, `judul`, `order`, `url`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?)',[3, 1, 'Sub Menu', 3, 'sub-menu', '2024-04-03 12:10:25', '2024-04-03 12:10:25']);
        // DB::insert('insert into sub_menu (`id`, `id_menu`, `judul`, `order`, `url`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?)',[4, 11, 'List', 1, 'list', '2024-04-07 00:57:23', '2024-04-07 00:57:23']);
        // DB::insert('insert into sub_menu (`id`, `id_menu`, `judul`, `order`, `url`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?)',[5, 11, 'Tambah Stok', 2, 'tambah-stok', '2024-04-07 00:57:36', '2024-04-07 00:57:36']);
        // DB::insert('insert into sub_menu (`id`, `id_menu`, `judul`, `order`, `url`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?)',[6, 11, 'Retur', 3, 'retur', '2024-04-07 00:57:46', '2024-04-07 00:57:46']);

        // User::create([
        //     'regional_id' => 1,
        //     'role_id' => 1,
        //     'lokasi_id' => 1,
        //     'name' => 'Admin Saniter',
        //     'email' => 'admin@gmail.com',
        //     'nik' => '5171012103010002',
        //     'telp' => '0819034078903',
        //     'password' => Hash::make('admin'),
        //     'is_active' => 1
        // ]);

        // User::create([
        //     'regional_id' => 3,
        //     'role_id' => 3,
        //     'lokasi_id' => 1,
        //     'name' => 'Teknisi Saniter',
        //     'email' => 'teknisi@gmail.com',
        //     'nik' => '5171012103010002',
        //     'telp' => '0819034078901',
        //     'password' => Hash::make('teknisi'),
        //     'is_active' => 1
        // ]);

        // User::create([
        //     'regional_id' => 2,
        //     'role_id' => 2,
        //     'lokasi_id' => 1,
        //     'name' => 'Staff Saniter',
        //     'email' => 'staff@gmail.com',
        //     'nik' => '5171012103010002',
        //     'telp' => '0819034078902',
        //     'password' => Hash::make('staff'),
        //     'is_active' => 1
        // ]);

        // Shift::create([
        //     'nama' => 'Pagi',
        //     'server_time' => 1,
        //     'jam_masuk' => "09:00:00",
        //     'jam_pulang' => "17:00:00"
        // ]);

        // Shift::create([
        //     'nama' => 'Sore',
        //     'server_time' => 1,
        //     'jam_masuk' => "15:00:00",
        //     'jam_pulang' => "23:00:00"
        // ]);

        // Shift::create([
        //     'nama' => 'Malam',
        //     'server_time' => 1,
        //     'jam_masuk' => "23:00:00",
        //     'jam_pulang' => "07:00:00"
        // ]);

        // $role = [
        //     0 => "Administrator",
        //     1 => "Direktur Utama",
        //     2 => "CO GM Reg.Barat",
        //     3 => "GM. Reg.Barat",
        //     4 => "Dir. Keuangan",
        //     5 => "GM. Reg.Timur",
        //     6 => "Dir. Teknik",
        //     7 => "Project Manager (Reg.Timur)",
        //     8 => "TA Dir. Keuangan",
        //     9 => "Manajer IT",
        //     10 => "Site Engineering Manager (Reg.Timur)",
        //     11 => "TA. Dirtek",
        //     12 => "Site Oprational Manager (Reg.Barat)",
        //     13 => "Project Manager (Reg.Barat)",
        //     14 => "Resign/PHK",
        //     17 => "Manager Finance (Reg.Barat)",
        //     18 => "Staff Finance (Reg.Timur)",
        //     19 => "Manajer Logistik (Pusat)",
        //     21 => "Site Engineering Manager (Reg.Barat)",
        //     22 => "Site Oprational Manager (Reg.Timur)",
        //     24 => "Driver (Reg.Timur)",
        //     25 => "Logistik (Reg.Timur)",
        //     28 => "Dir. Business Development",
        //     32 => "Konsultan",
        //     33 => "Staff Logistik (Reg.Timur)",
        //     35 => "Staff Logistik (Reg.Barat)",
        //     36 => "Manager Legal",
        //     38 => "Staff HRD",
        //     43 => "Staff Akunting (Reg.Timur)",
        //     44 => "Staff Teknik (Reg.Timur)",
        //     46 => "Intern Logistik",
        //     47 => "Intern Finance",
        //     48 => "Intern Teknik",
        //     49 => "Cleaning Service",
        //     55 => "Admin Project (Reg.Timur)",
        //     56 => "Staff Sales (Reg.Barat)",
        //     57 => "Admin Project (Reg.Barat)",
        //     63 => "Project Manager (Reg.Tengah)",
        //     64 => "Staff Sales (Reg.Timur)",
        //     70 => "Staff Finance (Reg.Tengah)",
        //     71 => "Supervisor (Reg.Timur)",
        //     87 => "Staff IT",
        //     89 => "Masa Orientasi Calon Karyawan"
        // ];

        // foreach($role as $item){
        //     Role::create(['name' => $item]);
        // }

        // $user = User::find(1);
        // $user->assignRole(['Administrator']);

        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 1, 'menu_create', 'web', '2024-04-03 12:09:25', '2024-04-03 12:09:25']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 1, 'menu_read', 'web', '2024-04-03 12:09:25', '2024-04-03 12:09:25']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[3, 1, 'menu_update', 'web', '2024-04-03 12:09:25', '2024-04-03 12:09:25']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[4, 1, 'menu_delete', 'web', '2024-04-03 12:09:25', '2024-04-03 12:09:25']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[5, 1, 'ketegori_create', 'web', '2024-04-03 12:10:52', '2024-04-03 12:10:52']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[6, 1, 'ketegori_read', 'web', '2024-04-03 12:10:52', '2024-04-03 12:10:52']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[7, 1, 'ketegori_update', 'web', '2024-04-03 12:10:52', '2024-04-03 12:10:52']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[8, 1, 'ketegori_delete', 'web', '2024-04-03 12:10:52', '2024-04-03 12:10:52']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[9, 1, 'sub_menu_create', 'web', '2024-04-03 12:11:06', '2024-04-03 12:11:31']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[10, 1, 'sub_menu_read', 'web', '2024-04-03 12:11:06', '2024-04-03 12:11:26']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[11, 1, 'sub_menu_update', 'web', '2024-04-03 12:11:06', '2024-04-03 12:11:21']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[12, 1, 'sub_menu_delete', 'web', '2024-04-03 12:11:06', '2024-04-03 12:11:15']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[13, 4, 'user_create', 'web', '2024-04-03 12:43:39', '2024-04-03 12:43:39']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[14, 4, 'user_read', 'web', '2024-04-03 12:43:39', '2024-04-03 12:43:39']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[15, 4, 'user_update', 'web', '2024-04-03 12:43:39', '2024-04-03 12:43:39']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[16, 4, 'user_delete', 'web', '2024-04-03 12:43:39', '2024-04-03 12:43:39']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[17, 5, 'absen_create', 'web', '2024-04-03 12:54:45', '2024-04-03 12:54:45']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[18, 5, 'absen_read', 'web', '2024-04-03 12:54:45', '2024-04-03 12:54:45']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[19, 5, 'absen_update', 'web', '2024-04-03 12:54:46', '2024-04-03 12:54:46']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[20, 5, 'absen_delete', 'web', '2024-04-03 12:54:46', '2024-04-03 12:54:46']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[21, 6, 'izin_create', 'web', '2024-04-03 12:54:56', '2024-04-03 12:54:56']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[22, 6, 'izin_read', 'web', '2024-04-03 12:54:56', '2024-04-03 12:54:56']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[23, 6, 'izin_update', 'web', '2024-04-03 12:54:56', '2024-04-03 12:54:56']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[24, 6, 'izin_delete', 'web', '2024-04-03 12:54:56', '2024-04-03 12:54:56']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[25, 6, 'pengaturan_izin_create', 'web', '2024-04-03 13:06:31', '2024-04-03 13:06:31']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[26, 6, 'pengaturan_izin_read', 'web', '2024-04-03 13:06:31', '2024-04-03 13:06:31']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[27, 6, 'pengaturan_izin_update', 'web', '2024-04-03 13:06:31', '2024-04-03 13:06:31']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[28, 6, 'pengaturan_izin_delete', 'web', '2024-04-03 13:06:31', '2024-04-03 13:06:31']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[29, 7, 'regional_create', 'web', '2024-04-03 13:13:09', '2024-04-03 13:13:09']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[30, 7, 'regional_read', 'web', '2024-04-03 13:13:09', '2024-04-03 13:13:09']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[31, 7, 'regional_update', 'web', '2024-04-03 13:13:09', '2024-04-03 13:13:09']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[32, 7, 'regional_delete', 'web', '2024-04-03 13:13:09', '2024-04-03 13:13:09']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[33, 8, 'lokasi_create', 'web', '2024-04-03 13:32:43', '2024-04-03 13:32:43']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[34, 8, 'lokasi_read', 'web', '2024-04-03 13:32:43', '2024-04-03 13:32:43']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[35, 8, 'lokasi_update', 'web', '2024-04-03 13:32:43', '2024-04-03 13:32:43']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[36, 8, 'lokasi_delete', 'web', '2024-04-03 13:32:43', '2024-04-03 13:32:43']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[37, 9, 'jumlah izin_create', 'web', '2024-04-03 14:42:38', '2024-04-03 14:42:38']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[38, 9, 'jumlah izin_read', 'web', '2024-04-03 14:42:38', '2024-04-03 14:42:38']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[39, 9, 'jumlah izin_update', 'web', '2024-04-03 14:42:38', '2024-04-03 14:42:38']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[40, 9, 'jumlah izin_delete', 'web', '2024-04-03 14:42:38', '2024-04-03 14:42:38']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[41, 6, 'validasi2_izin', 'web', '2024-04-03 15:32:31', '2024-04-03 15:32:31']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[42, 6, 'validasi1_izin', 'web', '2024-04-03 15:32:49', '2024-04-03 15:32:49']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[43, 10, 'nama material_create', 'web', '2024-04-03 23:34:14', '2024-04-03 23:34:14']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[44, 10, 'nama material_read', 'web', '2024-04-03 23:34:14', '2024-04-03 23:34:14']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[45, 10, 'nama material_update', 'web', '2024-04-03 23:34:14', '2024-04-03 23:34:14']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[46, 10, 'nama material_delete', 'web', '2024-04-03 23:34:14', '2024-04-03 23:34:14']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[47, 11, 'stok material_create', 'web', '2024-04-04 00:04:01', '2024-04-04 00:04:01']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[48, 11, 'stok material_read', 'web', '2024-04-04 00:04:01', '2024-04-04 00:04:01']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[49, 11, 'stok material_update', 'web', '2024-04-04 00:04:01', '2024-04-04 00:04:01']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[50, 11, 'stok material_delete', 'web', '2024-04-04 00:04:01', '2024-04-04 00:04:01']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[55, 11, 'stok material pengajuan_create', 'web', '2024-04-07 00:59:13', '2024-04-07 00:59:13']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[56, 11, 'stok material pengajuan_read', 'web', '2024-04-07 00:59:13', '2024-04-07 00:59:13']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[57, 11, 'stok material pengajuan_update', 'web', '2024-04-07 00:59:13', '2024-04-07 00:59:13']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[58, 11, 'stok material pengajuan_delete', 'web', '2024-04-07 00:59:13', '2024-04-07 00:59:13']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[59, 11, 'validasi_pm_stok_material', 'web', '2024-04-07 01:00:35', '2024-04-07 01:00:35']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[60, 11, 'validasi_spv_stok_material', 'web', '2024-04-07 01:00:46', '2024-04-07 01:00:46']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[61, 11, 'stok material list_create', 'web', '2024-04-07 01:33:49', '2024-04-07 01:33:49']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[62, 11, 'stok material list_read', 'web', '2024-04-07 01:33:49', '2024-04-07 01:33:49']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[63, 11, 'stok material list_update', 'web', '2024-04-07 01:33:49', '2024-04-07 01:33:49']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[64, 11, 'stok material list_delete', 'web', '2024-04-07 01:33:49', '2024-04-07 01:33:49']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[65, 11, 'stok material retur_create', 'web', '2024-04-07 23:50:39', '2024-04-07 23:50:39']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[66, 11, 'stok material retur_read', 'web', '2024-04-07 23:50:39', '2024-04-07 23:50:39']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[67, 11, 'stok material retur_update', 'web', '2024-04-07 23:50:39', '2024-04-07 23:50:39']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[68, 11, 'stok material retur_delete', 'web', '2024-04-07 23:50:39', '2024-04-07 23:50:39']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[69, 5, 'absen_detail_all', 'web', '2024-04-08 07:40:38', '2024-04-08 07:40:38']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[70, 6, 'all_izin', 'web', '2024-04-08 08:07:58', '2024-04-08 08:07:58']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[71, 12, 'data proyek_create', 'web', '2024-04-09 05:49:49', '2024-04-09 05:49:49']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[72, 12, 'data proyek_read', 'web', '2024-04-09 05:49:49', '2024-04-09 05:49:49']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[73, 12, 'data proyek_update', 'web', '2024-04-09 05:49:49', '2024-04-09 05:49:49']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[74, 12, 'data proyek_delete', 'web', '2024-04-09 05:49:49', '2024-04-09 05:49:49']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[75, 13, 'area_create', 'web', '2024-04-09 06:11:17', '2024-04-09 06:11:17']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[76, 13, 'area_read', 'web', '2024-04-09 06:11:17', '2024-04-09 06:11:17']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[77, 13, 'area_update', 'web', '2024-04-09 06:11:17', '2024-04-09 06:11:17']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[78, 13, 'area_delete', 'web', '2024-04-09 06:11:17', '2024-04-09 06:11:17']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[79, 14, 'area list_create', 'web', '2024-04-09 07:24:23', '2024-04-09 07:24:23']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[80, 14, 'area list_read', 'web', '2024-04-09 07:24:23', '2024-04-09 07:24:23']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[81, 14, 'area list_update', 'web', '2024-04-09 07:24:23', '2024-04-09 07:24:23']);
        // DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[82, 14, 'area list_delete', 'web', '2024-04-09 07:24:23', '2024-04-09 07:24:23']);

        // DB::insert('insert into area (`id`, `regional_id`, `nama`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?)',[2, 3, 'Domestik', '2024-04-09 06:49:59', '2024-04-09 07:19:23']);
        // DB::insert('insert into area (`id`, `regional_id`, `nama`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?)',[3, 3, 'International', '2024-04-09 06:55:44', '2024-04-09 06:55:44']);
        // DB::insert('insert into area (`id`, `regional_id`, `nama`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?)',[4, 1, 'Domestik', '2024-04-09 08:32:57', '2024-04-09 08:32:57']);

        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[1, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[2, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[3, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[4, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[5, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[6, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[7, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[8, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[9, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[10, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[11, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[12, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[13, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[14, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[15, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[16, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[17, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[18, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[19, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[20, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[21, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[22, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[23, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[24, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[25, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[26, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[27, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[28, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[29, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[30, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[31, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[32, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[33, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[34, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[35, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[36, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[37, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[38, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[39, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[40, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[41, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[44, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[45, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[46, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[55, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[55, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[56, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[56, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[57, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[57, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[58, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[58, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[59, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[60, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[61, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[61, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[62, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[62, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[63, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[63, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[64, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[64, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[65, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[65, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[66, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[66, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[67, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[67, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[68, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[68, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[69, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[70, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[71, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[71, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[72, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[72, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[73, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[73, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[74, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[74, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[75, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[76, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[77, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[78, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[79, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[79, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[80, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[80, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[81, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[81, 26]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[82, 1]);
        // DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[82, 26]);

        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 AD 01 Pria', 'denah/cuyFKkLzVdKV5i3KrzpVWxfKttCF1url83vjSobR.jpg', '2022-06-23 11:42:49', '2022-12-07 09:56:56']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 AD 01 Wanita', 'denah/BoyfMDmXt7AoCbeOSG0KFfrxchgD48fxjju1pN1U.jpg', '2022-06-23 11:43:09', '2022-12-07 09:57:03']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 AD 02 Pria', 'denah/i3wXWTfbKomnEw1VEgpvKk3AFzCUnl1e1bS9y7Dq.jpg', '2022-06-23 11:43:28', '2022-12-07 09:57:12']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 AD 02 Wanita', 'denah/hV150vw0wOWRbYlG0W55bdkuP7c53t3W27DDssRQ.jpg', '2022-06-23 11:43:45', '2022-12-07 09:58:49']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 AD 03 Pria', 'denah/SyhieU4I4RHJyHAkZkzFSA76ce2kvIdyZX3L3IH5.jpg', '2022-06-23 11:43:59', '2022-11-19 11:47:41']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 AD 03 Wanita', 'denah/prkynMA1itH9tIXv5Hfq1WzeqSehHAVD3JIhou3u.jpg', '2022-06-23 11:44:08', '2022-11-19 11:47:56']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 AD 04 Pria', 'denah/ALIPox4OWCxrPgKGDSivYXv6DXeNHq8LrKx5kdTJ.jpg', '2022-06-23 11:44:21', '2022-11-19 11:49:34']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 AD 04 Wanita', 'denah/m8KGKvir2AB7btkBlWipq1YT6HTnNllP8aqT0IH3.jpg', '2022-06-23 11:44:32', '2022-11-19 11:50:02']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 Check In Barat Pria', 'denah/RzSTRr2yMPxHpbu0XLzPNwnDUPv9GDCXA3TEfMgv.jpg', '2022-06-23 11:45:42', '2022-11-19 11:50:22']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 Check In Barat Wanita', 'denah/ErVUyMNQsaMlswLiPIaMx0koCr0AH1XQjKHqVQ9g.jpg', '2022-06-23 11:46:07', '2022-11-19 11:50:38']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 Check In Timur Pria', 'denah/5KypWRZWftVIhQfsbxeP04GUj00H8Ft50h7tiLKS.jpg', '2022-06-23 11:46:16', '2022-11-19 11:50:54']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 Check In Timur Wanita', 'denah/JWOmyOT2Blq18OgllNA2uNVV0wgYzuuAFmPJZTZR.jpg', '2022-06-23 11:46:33', '2022-11-19 11:51:12']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 DD 03 Pria', 'denah/A7ajNTDi9uMEtzhlwAb5Xfq8ek0u0l6kQr4HwTTh.png', '2022-06-23 11:46:44', '2022-11-19 14:48:13']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 DD 03 Wanita', 'denah/ClZAOieyKu0PDar7gbjZMd98CMz2GNWfoL6mf7WV.png', '2022-06-23 11:47:04', '2022-11-19 14:48:30']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 DD 02 Pria', 'denah/uDVwnDy5eOgM1Z27I2wqIjmZAdIjcYW6wMo7grsB.jpg', '2022-06-23 11:47:30', '2022-11-19 11:54:17']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 DD 02 Wanita', 'denah/iL3o5iWL7p7sLI1nVp1GxbyHcGE9K8svDsK5CatI.jpg', '2022-06-23 11:47:41', '2022-11-19 11:54:34']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 DS 01 Pria', 'denah/pjC9mt0S4EsMVUfZe5XisGIby5cVyLHWUipKebsj.jpg', '2022-06-23 11:47:57', '2022-11-19 11:55:03']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 DS 01 Wanita', 'denah/l8kqyl9Faikj3A8N5gC2ncBO2hcR7VYgpn0rTogM.jpg', '2022-06-23 11:48:06', '2022-11-19 11:55:19']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 DS 02 Pria', 'denah/FWpe90gzIdHRmJuIgalBfJqBuTYtpdqcCyeotdZ7.jpg', '2022-06-23 11:48:18', '2022-11-21 09:42:56']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 DS 02 Wanita', 'denah/SlrnHXfYLVMb2jOtl2FM6FlYpRxjroWTNCFOs5Np.jpg', '2022-06-23 11:48:33', '2022-11-21 09:43:54']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 GHD 01 Pria', 'denah/bixea5tw6f0HEInsqYxoeb4CT6ZmMrNVruhZ0hA8.jpg', '2022-06-23 11:48:41', '2022-11-19 11:56:30']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 GHD 01 Wanita', 'denah/02xr4zH4RqoDqwfxQY0lyyqW3kzDBQBhPZU8WQCX.jpg', '2022-06-23 11:48:51', '2022-11-19 11:56:55']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 GHD 02 Pria', 'denah/sHGvTMmYRfereLs61WfUNzZ9KgoDDywE0GNPdyz8.jpg', '2022-06-23 11:49:00', '2022-11-19 11:57:17']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 GHD 02 Wanita', 'denah/qiXq8f9e9MLS1UQaHpFJ3EbLmHHjeAjzS6fp7cOj.jpg', '2022-06-23 11:49:07', '2022-11-19 11:57:35']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 GHD 03 Pria', 'denah/CvqtODSc5Vn2e2WOjaogBCinjSVVpS4QNNvG863O.jpg', '2022-06-23 11:49:17', '2022-11-19 14:48:57']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 GHD 03 Wanita', 'denah/EdOWUXltNhn2o0wJ1cv4r3qKl0owzzoOJIO8eoPV.jpg', '2022-06-23 11:49:33', '2022-11-21 09:44:26']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 GHD 04 Pria', 'denah/qdE36H1fp0VGWibg5fDQAo5W4bRkdE1SVTM8wseC.jpg', '2022-06-23 11:49:43', '2022-11-21 09:44:58']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 GHD 04 Wanita', 'denah/NStdSu0ryrg4xZrPLzk67U34Cl6buV3cn9d4IxhD.jpg', '2022-06-23 11:49:54', '2022-11-21 09:45:16']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 TD 01 Pria', 'denah/Ib816786Uv0dE4GOQFs8xZ6BGndRrmoqWHpnsNSU.jpg', '2022-06-23 11:50:23', '2022-11-19 11:58:41']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 1', 'Toilet 1 TD 01 Wanita', 'denah/2FqZ9k6erKzASfWUukv3xTgoB1jcdZMx3KpqM87S.jpg', '2022-06-23 12:17:27', '2022-11-19 11:58:56']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 DD 04 Pria', 'denah/YhNyC9wpp7zohV7k88tR1aYM8tB1LkwNTfsiJvSq.jpg', '2022-06-23 12:17:40', '2022-11-19 12:01:29']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 DD 04 Wanita', 'denah/pB19f3FP9LO6HwB4dXlqKc8s2Ya0V6DRRFxxib5U.jpg', '2022-06-23 12:17:49', '2022-11-19 12:01:51']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 DD 05 Pria', 'denah/4kdwEwJJp09emdpoZNfGzuGbTyKv9BGMj92vDFoF.jpg', '2022-06-23 12:18:33', '2022-11-19 13:01:46']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 DD 05 Wanita', 'denah/GZCO2zHuYQPa2BCEIamg47uCKemrlLlfG18jVdDP.jpg', '2022-06-23 12:18:42', '2022-11-19 13:02:08']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 DD 06 Pria', 'denah/GLBhcH3Hzfr1DN9apmfMfmf74eCx7oxQIqK6v5OP.jpg', '2022-06-23 12:18:53', '2022-11-19 13:03:19']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 DD 06 Wanita', 'denah/Q3kQY2PHZD61ccgqCNabOsElJX2yh4j6z82z6YT8.jpg', '2022-06-23 12:19:14', '2022-11-19 13:03:41']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 DD 07 Pria', 'denah/6zabdmfCTxzQsz0DReAgEiuVmgqDxbEaZWHDJBmm.jpg', '2022-06-23 12:19:26', '2022-11-19 13:04:12']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 DD 07 Wanita', 'denah/OxmWT6Ol7PXkoI25bCDaal1aSfOgx0rDkWAqsUKx.jpg', '2022-06-23 12:19:39', '2022-11-19 13:04:35']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 DS 02 Pria', 'denah/sQRnUxoKi6kPo3tGYwDABUrekuexEFJdsHwJJ5v3.jpg', '2022-06-23 12:19:47', '2022-11-21 09:45:45']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 DS 02 Wanita', 'denah/95ecOYQNKsUUrGeyxA0RxM4dL7FLwGv60gNMXXeQ.jpg', '2022-06-23 12:19:55', '2022-11-21 09:46:01']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 Toilet Gate 1 A Pria', 'denah/6oKJeIZZ9IJW1vlEmaihPrainNUuD6M3t3s2XQb4.jpg', '2022-06-23 12:20:05', '2022-11-19 13:05:21']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 2', 'Toilet 2 Toilet Gate 1 A Wanita', 'denah/j0l8sV1ATPzOOWB2nXs5Z179j0Aij3QWoFZuqfbS.jpg', '2022-06-23 12:20:12', '2022-11-19 13:05:40']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 3', 'Toilet 3 DS 01 Pria', 'denah/hpuFRUX58jlXllavF6SL23biPCVlqyUVX8X9fBuW.jpg', '2022-06-23 12:20:22', '2022-11-21 09:46:24']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 3', 'Toilet 3 DS 01 Wanita', 'denah/Aqa0Uxpd8NrkeoNmZNCUQiPfJVci0lV0nKOmH6MT.jpg', '2022-06-23 12:20:31', '2022-11-21 09:46:39']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 3', 'Toilet 3 DS 02 Pria', 'denah/B2lUe9WS4ujrnqCvoLnsRdwBivKO4ndaBt2lOP2Q.jpg', '2022-06-23 12:20:39', '2022-11-21 09:48:13']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 3', 'Toilet 3 DS 02 Wanita', 'denah/uBxXP8gZdvDCc0We3A8tcowYnIdYBjAXJDfKKkij.jpg', '2022-06-23 12:20:58', '2022-11-21 09:48:39']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 3', 'Toilet 3 DS 04 Pria', 'denah/54InW6wz3TjUIE6qPYut7HMfAeUiOrQKMUoklAPH.jpg', '2022-06-23 12:21:07', '2022-11-21 09:48:59']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Lantai 3', 'Toilet 3 DS 04 Wanita', 'denah/IIS90OLUULsGubfkrm8OginljpUzGFwKda8EqH7b.jpg', '2022-06-23 12:21:14', '2022-11-21 09:49:34']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 A Pria', 'denah/B7oB4L2IcmQyR3bs6EXWzB62hzaWYnd4stDuCCa0.jpg', '2022-06-23 12:21:38', '2022-12-07 09:59:03']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 A Wanita', 'denah/nqbXXhdwgmm14ryWrMSbP4P72RFmp0riSWL31hxH.jpg', '2022-06-23 12:21:51', '2022-12-07 09:59:12']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 B Pria', 'denah/1AXbE1JPYCJuwOdT5i7pehsZV4w08WrzbUcBGPW3.jpg', '2022-06-23 12:22:00', '2022-12-07 09:59:26']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 B Wanita', 'denah/vH5zqatzPerDPDxqsCUC3mYhEwEv8xHun8QZcCul.jpg', '2022-06-23 12:22:08', '2022-12-07 09:59:33']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 C Pria', 'denah/dG8vPlvsLB6O9CEOKpMznyxo4GKAW65NtsgUmDfB.jpg', '2022-06-23 12:22:26', '2022-11-19 13:20:16']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 C Wanita', 'denah/z5Y5EQ4jSd9diF9rRJ3AIudujBshnq8EfAfraaxl.jpg', '2022-06-23 12:22:35', '2022-11-19 13:20:41']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 D Pria', 'denah/Zq8pcasodHG2k613o6cjmajpUVvJuAUdQT33gIWM.jpg', '2022-06-23 12:22:44', '2022-11-19 13:38:04']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 D Wanita', 'denah/46XYoc366MKglqT4b9GlfFUbFfqms7JUMcqtT6ef.jpg', '2022-06-23 12:22:51', '2022-11-19 13:38:22']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 E Pria', 'denah/wj5Fdn2yVgUS4UBvTDCuoaRtd93cnQhODWdNcpsQ.jpg', '2022-06-23 12:22:58', '2022-11-19 13:38:39']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 E Wanita', 'denah/8BJzwlV2zzhRcfmRX6soV8tETNf9luOkSnr00fX2.jpg', '2022-06-23 12:23:07', '2022-11-19 13:39:16']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 F Pria', 'denah/G0yTQyGQKAuRgaYRf2FkJ8w2PY60M17L1MlVZzdH.jpg', '2022-06-23 12:23:13', '2022-11-19 13:39:55']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 F Wanita', 'denah/LC8lFhxIUCG6NDCCCMMtJI6Bgj5CQ22cRqQJorh7.jpg', '2022-06-23 12:23:21', '2022-11-19 13:40:12']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 G Pria', 'denah/FY9wgPngtR9sNNFZKX0bc3WMZy4CdxanA9iRvweV.jpg', '2022-06-23 12:23:28', '2022-11-19 13:40:29']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 G Wanita', 'denah/s4wbdDEArNQXk5iHns3Bb521rr3whTyVCcmLRDHm.jpg', '2022-06-23 12:23:37', '2022-11-19 13:40:51']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 H Pria', 'denah/hUFXesed3SZX3w7i2EEcT5D0zQYBpH6Yww84KHCj.jpg', '2022-06-23 12:23:50', '2022-11-19 13:41:10']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 H Wanita', 'denah/qaHgp4Cc9gkrkQBGnExMjQmvBe2m3DOBhplGDNGr.jpg', '2022-06-23 12:23:58', '2022-11-19 13:41:53']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 I Pria', 'denah/j8aRKZ8Fddt9slktbQNCG1r4kTOifgUpRl6ef4UH.jpg', '2022-06-23 12:24:08', '2022-11-19 13:42:12']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 I Wanita', 'denah/TThp7F69n2f0WW1UcHPRnyK5TGVVS5p3IeDrDSDI.jpg', '2022-06-23 12:24:16', '2022-11-19 13:42:50']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 J Pria', 'denah/dCLczT6kUFI5epAClsEI0uwtlSZRru4RReGRM2Nw.jpg', '2022-06-23 12:24:30', '2022-11-19 13:42:31']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 J Wanita', 'denah/at4JNAeYhcMn93zz8BnAunQP5LMkawSXjgoYFUSz.jpg', '2022-06-23 12:24:41', '2022-11-19 13:43:08']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 K Pria', 'denah/HCAlXPRmBf6UOcJvleJSDzOvO0z3XmbqwOWcwvs9.jpg', '2022-06-23 12:24:51', '2022-11-19 13:43:29']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 K Wanita', 'denah/vHDJLU2ws8KcfZKK37HlvsFXxNxMLmDmEjPGjpUo.jpg', '2022-06-23 12:27:14', '2022-11-19 13:43:52']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 L Pria', 'denah/UhvQ3AD6qDdiH7c0NNWiV2iAhe5YuKJC6PrNLMzH.jpg', '2022-06-23 12:30:54', '2022-11-19 13:44:17']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 L Wanita', 'denah/qjTd9Qub5FYPyn97CeryDlfntCvqA1xLvIrEmRr6.jpg', '2022-06-23 12:31:06', '2022-11-19 13:44:40']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 M Pria', 'denah/QEswuGMnIsbqnogs3QE0NnXCccMvN5KCPvGIxzvG.jpg', '2022-06-23 12:31:17', '2022-11-19 13:44:59']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 M Wanita', 'denah/YyZrot3j6ARypWuVJt50UDfUfF5ZzpmeClzgFUSe.jpg', '2022-06-23 12:31:25', '2022-11-19 13:45:18']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 N Pria', 'denah/1IdA1lmmNzBNSHGYiTFFo61EelrIVIJBevYp8OqJ.jpg', '2022-06-23 12:31:37', '2022-11-19 13:45:41']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 N Wanita', 'denah/Ou6intYxihYfbA6M7lwnkQFHpvR6uudfUpaxnHqG.jpg', '2022-06-23 12:32:41', '2022-11-19 13:46:05']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 O Pria', 'denah/7qyVJwFaW2ldfrgljUboNR6kOSYo7LISvRzK89OE.jpg', '2022-06-23 12:32:49', '2022-11-19 13:46:30']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 O Wanita', 'denah/G0Jj3j6lP34HLI4aKgkyeEc9aYUZsaiFJjH8I4Nq.jpg', '2022-06-23 12:32:57', '2022-11-19 13:47:05']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 P Pria', 'denah/q27GgOT9AP1cfj9K5bjWJUk3LPPiFY52RGDCp6tU.jpg', '2022-06-23 12:33:05', '2022-11-19 13:47:33']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 1', 'Toilet 1 P Wanita', 'denah/RmnBkV3XHJJ61PtUjffSDFJ5o7bVPZWGx84QOohk.jpg', '2022-06-23 12:33:12', '2022-11-19 13:47:54']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 A Pria', 'denah/2ouwZZeuIyJtKZlukb3FNlwjBzZhhodpZErY0SJX.jpg', '2022-06-23 12:33:25', '2022-11-19 13:48:17']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 A Wanita', 'denah/pus6IrsE9P2Jq2yXbKh0rQ3Rw4TA7cfaoHwPgaT2.jpg', '2022-06-23 12:33:32', '2022-11-19 13:48:39']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 B Pria', 'denah/k3lcNwAuXjnNcy55lYv21afklj5EXUT6MwWEj26o.jpg', '2022-06-23 12:33:40', '2022-11-19 13:49:01']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 B Wanita', 'denah/FF3UJsRrZdYXCI3ZuT5mAm11N5x7DRPloNnpJg6f.jpg', '2022-06-23 12:33:48', '2022-11-19 13:49:41']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 C Pria', 'denah/1OI5MToZ6GK9LFhT2p39WePSLRfdMfLqvkpDkIKD.jpg', '2022-06-23 12:33:55', '2022-11-19 13:50:08']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 C Wanita', 'denah/KiQiGQ22QcLAx6lnaGNhsGUVZ6IgcbVwue9vck28.jpg', '2022-06-23 12:34:02', '2022-11-19 13:50:38']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 D Pria', 'denah/4IeOKjXn8xWBmmlXCXz1K7UIfyQFMDiDpwbameJc.jpg', '2022-06-23 12:34:14', '2022-11-19 13:51:08']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 D Wanita', 'denah/XRs1Puc5byVEX1icJlAEWKvI4a6RRc75bXISKj9s.jpg', '2022-06-23 12:34:32', '2022-11-19 13:51:29']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 D1 Pria', 'denah/FobBedGRYGIApLgYivNAtV9daTvXSXtzVWyDVZIN.jpg', '2022-06-23 12:34:40', '2022-11-19 13:51:51']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 D1 Wanita', 'denah/uhJTOi0NKmVL3DHSJVD90y6LfLNdHyyvFSt253c7.jpg', '2022-06-23 12:34:49', '2022-11-19 13:52:11']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 E Pria', 'denah/g1lMv8qqBntL5UEgl058Spi9CddK1Mn4VrVXMMhC.jpg', '2022-06-23 12:34:57', '2022-11-19 13:52:39']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 E Wanita', 'denah/CSfAXTlAhvEK7FJnCEf5FlWjynukCNEvKyQh62P2.jpg', '2022-06-23 12:35:05', '2022-12-07 10:08:51']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Lantai 2', 'Toilet 2 F Pria', 'denah/b0SLJEuGScHxBbn8FyShGRc9IJriTvBtZM9TdqYM.jpg', '2022-06-23 12:35:11', '2022-12-07 10:08:27']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet 2 F Wanita', 'denah/cMU2ifiz0Y5IporvNugxl5pcgmXlWIXZTNuIdOAX.jpg', '2022-06-23 12:35:19', '2022-12-07 10:08:17']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet 2 G Pria', 'denah/3FN3SyVnbpvFgTMuQ0kXxHNaOUoZ3KKcTL0iXcBY.jpg', '2022-06-23 12:35:29', '2022-12-07 10:08:01']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet 2 G Wanita', 'denah/6z5gmZPgqxdaB2NBq1ZSYUIsD8dtZ3iGFyHdARNo.jpg', '2022-06-23 12:35:36', '2022-12-07 10:07:49']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet 2 H Pria', 'denah/x60ePcJEMjfaRFZxqwMbPsbvOlQWUTmNf16J28te.jpg', '2022-06-23 12:35:46', '2022-12-07 10:07:40']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet 2 H Wanita', 'denah/jumsEgZsMIilpLbUrOMj1r6t2f2TrhhEvRoHYDu6.jpg', '2022-06-23 12:35:53', '2022-12-07 10:07:31']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet 2 DD08 Pria', 'denah/eNLEnUOz8tcjvhZ6CoKxOmvBxZkMQHl6kjWhNtAq.jpg', '2022-06-23 12:36:00', '2022-12-07 10:07:23']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet 2 DD08 Wanita', 'denah/mr9KWv7bQyW6c70clxTg1ZyocYZUhk5ttTQ1o0If.jpg', '2022-06-23 12:36:10', '2022-12-07 10:07:13']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 A Pria', 'denah/bGFzTOjBfuuzMPy3Qp1KDj7liY8Z9mJkGaoDmcaG.jpg', '2022-06-23 12:36:31', '2022-12-07 10:07:04']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 A Wanita', 'denah/EFjpmVLQuA41DEIeeJA3PLWz706pZEgha3L3aGur.jpg', '2022-06-23 12:36:38', '2022-12-07 10:06:50']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 B Pria', 'denah/FRuARv197omUQ6cIglcZQmkoW0i7Xeuj4pb3b7J2.jpg', '2022-06-23 12:36:48', '2022-12-07 10:06:32']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 B Wanita', 'denah/iA2lc8AGkIxlD1AROvI4R9yEYnTuaKMjiYppT2ge.jpg', '2022-06-23 12:36:58', '2022-12-07 10:06:20']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 C Pria', 'denah/YA2v1x2QMaVaj0DA8P11BdZi8wpHTXnfEJ7dRzqA.jpg', '2022-06-23 12:37:05', '2022-12-07 10:06:09']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 C Wanita', 'denah/UajBGm2BBw21i33vsIpQNGY3qVfp1pwxyzuVyEfF.jpg', '2022-06-23 12:37:13', '2022-12-07 10:05:58']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 D Pria', 'denah/PJHbQviRMzNldU8UrnXTsKOQm7IzaTxTcC3KAYB0.jpg', '2022-06-23 12:37:21', '2022-12-07 10:05:45']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 D Wanita', 'denah/bgwhuXGVRk9mD3ma8fFxIhijdNZnTT1M1Aa1qVaK.jpg', '2022-06-23 12:37:31', '2022-12-07 10:05:32']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 E Pria', 'denah/DhGvvHULDuETdWvBlCl6CBhHTwjCzJLmlnBBp0Ud.jpg', '2022-06-23 12:37:37', '2022-12-07 10:05:19']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 E Wanita', 'denah/N9XG38qTG8WWzIhciVkJnchwnlCXM0VTbESiSfkS.jpg', '2022-06-23 12:37:46', '2022-12-07 10:05:06']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 F Pria', 'denah/uFfPzj4S7n8osCmICDN7TLfQsSfllzuzBhumrXEs.jpg', '2022-06-23 12:37:52', '2022-12-07 10:04:57']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 F Wanita', 'denah/LaHRZf6mZZDw2Ekher9WHEMQYUQSPk1SfYCNuTjb.jpg', '2022-06-23 12:37:59', '2022-12-07 10:04:48']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 G Pria', 'denah/N7rdm3RSBlaFM25SVSxvP9D8nKqU0IRKVHRsfQms.jpg', '2022-06-23 12:38:05', '2022-12-07 10:04:35']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 G Wanita', 'denah/IiCzhCEb6NYWduVGQihem7tmThSC6QzjzROw5HfO.jpg', '2022-06-23 12:38:14', '2022-12-07 10:04:15']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 H Pria', 'denah/OFoUBfbdx3VaFnhgtqPHM3U2otgHCxWMMRu8hrYv.jpg', '2022-06-23 12:38:33', '2022-12-07 10:04:03']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 H Wanita', 'denah/IUSuxSL7eJ2VUJIyiEDxfcoNWhc4Q4P0bnXaHK7M.jpg', '2022-06-23 12:38:42', '2022-12-07 10:03:44']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 I Pria', 'denah/Uh4lnvdHPDnUivg4DmKwPAd5v8kkrOJE1kOvkgWA.jpg', '2022-06-23 12:38:54', '2022-12-07 10:03:31']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 I Wanita', 'denah/TPR1KJZZTypXhEsvNVhPAz47dg7MilGiNqMTfKYI.jpg', '2022-06-23 12:39:02', '2022-12-07 10:03:17']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 J Pria', 'denah/LJVN1K9qZs9aVjtFumRgtbgSdzJOHXaxekKFbldC.jpg', '2022-06-23 12:39:10', '2022-12-07 10:03:03']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 J Wanita', 'denah/1u4A14RchrMSnqplUn4oxwEzHUs1SJlWa4GxZCJ8.jpg', '2022-06-23 12:39:19', '2022-12-07 10:02:50']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 K Pria', 'denah/V26I1oQcHvL6kqOd3LNM5BEfNUX4cDHfhMqr6utx.jpg', '2022-06-23 12:39:29', '2022-12-07 10:02:20']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 K Wanita', 'denah/4qgtZ9lsiLELGdB3Hilzvw87FnOefGPtMIA4XIQW.jpg', '2022-06-23 12:39:40', '2022-12-07 10:02:07']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 L Pria', 'denah/WJttNBchc0G5PPsddUhe2RTEuSzf2cRFvCRgdeGo.jpg', '2022-06-23 12:39:49', '2022-12-07 10:01:50']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 L Wanita', 'denah/NnT612knt8ExC3jpboIqvcHWnb5AB5u1AF6Bjh7Q.jpg', '2022-06-23 12:39:57', '2022-12-07 10:01:36']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 M Pria', 'denah/k100L0z3kgM8KFYdYMQ0UXY4B8AWOqcBKuppnIw9.jpg', '2022-06-23 12:40:04', '2022-12-07 10:01:20']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 M Wanita', 'denah/FumKW0vmHNweFB8C6lCPIENrg2wgTImTZxkzKOYG.jpg', '2022-06-23 12:40:12', '2022-12-07 10:01:05']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 N Pria', 'denah/xeyA43vzxJ3IjTIidV0xoBTMOjoMiWD0bUFZbi7X.jpg', '2022-06-23 12:40:19', '2022-12-07 10:00:49']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet 3 N Wanita', 'denah/QpiOpPNDSfp8UdCx0DIXzhT3J9Cd5JRTQskY5J8x.jpg', '2022-06-23 12:40:28', '2022-12-07 10:00:27']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet Esland E Timur Pria', 'denah/Zp1nRHKNuafJbUIUxm69PdbrHFamCFuNFOu6p2OE.jpg', '2022-12-05 10:32:06', '2022-12-05 11:29:01']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet Esland E Timur Wanita', 'denah/4heCpczoSz08kBRYreAjedadcnoIPbfNgKGrVHeV.jpg', '2022-12-05 10:32:17', '2022-12-05 11:29:16']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet Esland E Barat Pria', 'denah/ogaAlQkOBH2QuzixtPrleTAjOavkyvUZeD2Q3chO.jpg', '2022-12-05 10:32:29', '2022-12-05 11:29:40']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet Esland E Barat Wanita', 'denah/fguEixWB0HsQy6OKrdhpSVK9bLIUgL4ZE8xV6KUv.jpg', '2022-12-05 10:32:45', '2022-12-07 10:00:04']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 1, 'Lantai 1', 'Toilet Transit Pria', 'denah/Y92fhtraFMJ3LXcxXlMaje2cnOUSNB9GeVgajUbw.jpg', '2023-01-27 20:39:41', '2023-01-27 20:39:41']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 1, 'Lantai 1', 'Toilet Transit Wanita', 'denah/k6QIcgfsxurBtm32XtZJ8smMPbEcNtPd1C4fa3DI.jpg', '2023-01-27 20:39:50', '2023-01-27 20:39:50']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 1', 'Toilet MLCP Pria', 'denah/erIN1FGVN84N8nSBczrKt3WPKxggPPXQuKmmHDTN.jpg', '2023-05-19 11:15:52', '2023-05-19 11:15:52']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 1', 'Toilet MLCP Wanita', 'denah/MAQZUbnLmuGagkLjwAoObe92JZmEBl3UKaBXpRtQ.jpg', '2023-05-19 11:16:08', '2023-05-19 11:16:08']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet MLCP Pria', 'denah/JM4cVLUolPbbUxtyzbAzmgCDVQoiJ0SPNeKN9GA4.jpg', '2023-05-19 11:16:24', '2023-05-19 11:16:24']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 2', 'Toilet MLCP Wanita', 'denah/Aj1a5GMb1zZgP0fmAqadFlbOYpdUQjQSfVQEhJlI.jpg', '2023-05-19 11:20:43', '2023-05-19 11:20:43']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet MLCP Pria', 'denah/1yFradQWyzgauoIA1kCstJVDtbxlbqlZw30hJ3sL.jpg', '2023-05-19 11:21:03', '2023-05-19 11:21:03']);
        // DB::insert('insert into list_area (`area_id`, `lantai`, `nama`, `denah`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[ 2, 'Lantai 3', 'Toilet MLCP Wanita', 'denah/AJlYd1syxNxEpA5fIUfWMRg1kAjPBnvYYpJUNxZy.jpg', '2023-05-19 11:21:16', '2023-05-19 11:21:16']);
    }
}
