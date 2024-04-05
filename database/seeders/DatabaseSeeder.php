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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(PermissionSeeder::class);

        DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[1, 'Barat', '-6.299706065145467', '106.72254088949181', '2024-04-03 12:08:13', '2024-04-03 13:26:58', NULL]);
        DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[2, 'Tengah', '-7.245696806718458', '112.73892431229427', '2024-04-03 12:08:13', '2024-04-03 13:27:48', NULL]);
        DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[3, 'Pusat', '-8.661063', '115.214712', '2024-04-03 12:08:13', '2024-04-03 12:08:13', NULL]);
        DB::insert('insert into regional (id, nama, latitude, longitude, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?)',[5, 'Pusat-BSD', '0', '0', '2024-04-04 07:30:33', '2024-04-04 07:30:33', NULL]);

        DB::insert('insert into lokasi (id, regional_id, nama_bandara, lokasi_proyek, latitude, longitude, radius, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',[1, 3, 'Kantor Pusat', 'Kantor Pusat', '-8.661063', '115.214712', 150, '2024-04-03 13:33:21', '2024-04-03 13:33:21', NULL]);
        DB::insert('insert into lokasi (id, regional_id, nama_bandara, lokasi_proyek, latitude, longitude, radius, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',[2, 3, 'Bandara I Gusti Ngurah Rai', 'Terminal 1', '-8.743818514032556', '115.16517094178465', 100, '2024-04-03 13:34:33', '2024-04-03 13:34:33', NULL]);
        DB::insert('insert into lokasi (id, regional_id, nama_bandara, lokasi_proyek, latitude, longitude, radius, created_at, updated_at, deleted_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',[3, 3, 'Pemogan', 'Kubu Dukuh', '-8.70431439338925', '115.19760441686176', 150, '2024-04-03 13:52:00', '2024-04-03 13:52:00', NULL]);

        DB::insert('insert into menu_kategori (`id`, `nama_kategori`, `order`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 'Pengaturan', 3, 1, '2024-04-03 12:08:44', '2024-04-03 23:28:49']);
        DB::insert('insert into menu_kategori (`id`, `nama_kategori`, `order`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 'Administrasi', 1, 1, '2024-04-03 12:42:39', '2024-04-03 12:42:39']);
        DB::insert('insert into menu_kategori (`id`, `nama_kategori`, `order`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[3, 'Material', 2, 1, '2024-04-03 23:28:36', '2024-04-03 23:28:36']);

        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[1, 1, 'Manajemen Menu', 1, 'pengaturan/manajemen-menu', 'menu', 0, '2024-04-03 12:09:06', '2024-04-03 13:11:54']);
        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[2, 1, 'Manajemen Role', 2, 'pengaturan/manajemen-role', 'user-circle', 0, '2024-04-03 12:12:01', '2024-04-03 13:12:05']);
        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[3, 1, 'Manajemen Sistem', 3, 'pengaturan/manajemen-sistem', 'cog', 0, '2024-04-03 12:31:20', '2024-04-03 13:12:12']);
        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[4, 2, 'User', 1, 'administrasi/user', 'user', 1, '2024-04-03 12:43:28', '2024-04-03 12:43:28']);
        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[5, 2, 'Absen', 2, 'administrasi/absen', 'book-content', 1, '2024-04-03 12:52:45', '2024-04-03 12:52:45']);
        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[6, 2, 'Izin', 3, 'administrasi/izin', 'task-x', 1, '2024-04-03 12:53:12', '2024-04-03 13:12:25']);
        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[7, 1, 'Regional', 1, 'pengaturan/regional', 'map-pin', 1, '2024-04-03 13:12:48', '2024-04-03 13:12:48']);
        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[8, 1, 'Lokasi', 2, 'pengaturan/lokasi', 'map', 1, '2024-04-03 13:32:35', '2024-04-03 13:32:35']);
        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[9, 1, 'Jumlah Izin', 3, 'pengaturan/jumlah-izin', 'cog', 1, '2024-04-03 14:42:24', '2024-04-03 14:42:24']);
        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[10, 3, 'Nama Material', 1, 'material/nama-material', 'detail', 1, '2024-04-03 23:32:27', '2024-04-03 23:33:53']);
        DB::insert('insert into menu (`id`, `id_kategori`, `judul`, `order`, `url`, `icon`, `show`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)',[11, 3, 'Stok Material', 2, 'material/stok-material', 'layer-plus', 1, '2024-04-04 00:03:43', '2024-04-04 00:03:43']);

        DB::insert('insert into sub_menu (`id`, `id_menu`, `judul`, `order`, `url`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?)',[1, 1, 'Menu', 2, 'menu', '2024-04-03 12:10:00', '2024-04-03 12:10:00']);
        DB::insert('insert into sub_menu (`id`, `id_menu`, `judul`, `order`, `url`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?)',[2, 1, 'Kategori', 1, 'kategori', '2024-04-03 12:10:11', '2024-04-03 12:10:11']);
        DB::insert('insert into sub_menu (`id`, `id_menu`, `judul`, `order`, `url`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?, ?)',[3, 1, 'Sub Menu', 3, 'sub-menu', '2024-04-03 12:10:25', '2024-04-03 12:10:25']);

        DB::insert('insert into roles (`id`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?)',[1, 'Admin', 'web', '2024-04-03 12:08:14', '2024-04-03 12:08:14']);
        DB::insert('insert into roles (`id`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?)',[2, 'Teknisi', 'web', '2024-04-03 12:08:14', '2024-04-03 12:08:14']);
        DB::insert('insert into roles (`id`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?)',[3, 'Staff', 'web', '2024-04-03 12:08:14', '2024-04-03 12:08:14']);
        DB::insert('insert into roles (`id`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?)',[5, 'Administrator', 'web', '2024-04-04 07:10:46', '2024-04-04 07:10:46']);
        DB::insert('insert into roles (`id`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?)',[6, 'Staff IT', 'web', '2024-04-04 07:30:33', '2024-04-04 07:30:33']);

        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[1, 1, 'menu_create', 'web', '2024-04-03 12:09:25', '2024-04-03 12:09:25']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[2, 1, 'menu_read', 'web', '2024-04-03 12:09:25', '2024-04-03 12:09:25']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[3, 1, 'menu_update', 'web', '2024-04-03 12:09:25', '2024-04-03 12:09:25']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[4, 1, 'menu_delete', 'web', '2024-04-03 12:09:25', '2024-04-03 12:09:25']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[5, 1, 'ketegori_create', 'web', '2024-04-03 12:10:52', '2024-04-03 12:10:52']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[6, 1, 'ketegori_read', 'web', '2024-04-03 12:10:52', '2024-04-03 12:10:52']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[7, 1, 'ketegori_update', 'web', '2024-04-03 12:10:52', '2024-04-03 12:10:52']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[8, 1, 'ketegori_delete', 'web', '2024-04-03 12:10:52', '2024-04-03 12:10:52']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[9, 1, 'sub_menu_create', 'web', '2024-04-03 12:11:06', '2024-04-03 12:11:31']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[10, 1, 'sub_menu_read', 'web', '2024-04-03 12:11:06', '2024-04-03 12:11:26']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[11, 1, 'sub_menu_update', 'web', '2024-04-03 12:11:06', '2024-04-03 12:11:21']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[12, 1, 'sub_menu_delete', 'web', '2024-04-03 12:11:06', '2024-04-03 12:11:15']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[13, 4, 'user_create', 'web', '2024-04-03 12:43:39', '2024-04-03 12:43:39']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[14, 4, 'user_read', 'web', '2024-04-03 12:43:39', '2024-04-03 12:43:39']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[15, 4, 'user_update', 'web', '2024-04-03 12:43:39', '2024-04-03 12:43:39']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[16, 4, 'user_delete', 'web', '2024-04-03 12:43:39', '2024-04-03 12:43:39']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[17, 5, 'absen_create', 'web', '2024-04-03 12:54:45', '2024-04-03 12:54:45']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[18, 5, 'absen_read', 'web', '2024-04-03 12:54:45', '2024-04-03 12:54:45']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[19, 5, 'absen_update', 'web', '2024-04-03 12:54:46', '2024-04-03 12:54:46']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[20, 5, 'absen_delete', 'web', '2024-04-03 12:54:46', '2024-04-03 12:54:46']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[21, 6, 'izin_create', 'web', '2024-04-03 12:54:56', '2024-04-03 12:54:56']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[22, 6, 'izin_read', 'web', '2024-04-03 12:54:56', '2024-04-03 12:54:56']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[23, 6, 'izin_update', 'web', '2024-04-03 12:54:56', '2024-04-03 12:54:56']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[24, 6, 'izin_delete', 'web', '2024-04-03 12:54:56', '2024-04-03 12:54:56']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[25, 6, 'pengaturan_izin_create', 'web', '2024-04-03 13:06:31', '2024-04-03 13:06:31']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[26, 6, 'pengaturan_izin_read', 'web', '2024-04-03 13:06:31', '2024-04-03 13:06:31']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[27, 6, 'pengaturan_izin_update', 'web', '2024-04-03 13:06:31', '2024-04-03 13:06:31']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[28, 6, 'pengaturan_izin_delete', 'web', '2024-04-03 13:06:31', '2024-04-03 13:06:31']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[29, 7, 'regional_create', 'web', '2024-04-03 13:13:09', '2024-04-03 13:13:09']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[30, 7, 'regional_read', 'web', '2024-04-03 13:13:09', '2024-04-03 13:13:09']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[31, 7, 'regional_update', 'web', '2024-04-03 13:13:09', '2024-04-03 13:13:09']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[32, 7, 'regional_delete', 'web', '2024-04-03 13:13:09', '2024-04-03 13:13:09']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[33, 8, 'lokasi_create', 'web', '2024-04-03 13:32:43', '2024-04-03 13:32:43']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[34, 8, 'lokasi_read', 'web', '2024-04-03 13:32:43', '2024-04-03 13:32:43']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[35, 8, 'lokasi_update', 'web', '2024-04-03 13:32:43', '2024-04-03 13:32:43']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[36, 8, 'lokasi_delete', 'web', '2024-04-03 13:32:43', '2024-04-03 13:32:43']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[37, 9, 'jumlah izin_create', 'web', '2024-04-03 14:42:38', '2024-04-03 14:42:38']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[38, 9, 'jumlah izin_read', 'web', '2024-04-03 14:42:38', '2024-04-03 14:42:38']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[39, 9, 'jumlah izin_update', 'web', '2024-04-03 14:42:38', '2024-04-03 14:42:38']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[40, 9, 'jumlah izin_delete', 'web', '2024-04-03 14:42:38', '2024-04-03 14:42:38']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[41, 6, 'validasi2_izin', 'web', '2024-04-03 15:32:31', '2024-04-03 15:32:31']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[42, 6, 'validasi1_izin', 'web', '2024-04-03 15:32:49', '2024-04-03 15:32:49']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[43, 10, 'nama material_create', 'web', '2024-04-03 23:34:14', '2024-04-03 23:34:14']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[44, 10, 'nama material_read', 'web', '2024-04-03 23:34:14', '2024-04-03 23:34:14']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[45, 10, 'nama material_update', 'web', '2024-04-03 23:34:14', '2024-04-03 23:34:14']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[46, 10, 'nama material_delete', 'web', '2024-04-03 23:34:14', '2024-04-03 23:34:14']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[47, 11, 'stok material_create', 'web', '2024-04-04 00:04:01', '2024-04-04 00:04:01']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[48, 11, 'stok material_read', 'web', '2024-04-04 00:04:01', '2024-04-04 00:04:01']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[49, 11, 'stok material_update', 'web', '2024-04-04 00:04:01', '2024-04-04 00:04:01']);
        DB::insert('insert into permissions (`id`, `id_menu`, `name`, `guard_name`, `created_at`, `updated_at`) values (?, ?, ?, ?, ?, ?)',[50, 11, 'stok material_delete', 'web', '2024-04-04 00:04:01', '2024-04-04 00:04:01']);

        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[1, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[1, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[2, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[2, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[3, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[3, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[4, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[4, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[5, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[5, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[6, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[6, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[7, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[7, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[8, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[8, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[9, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[9, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[10, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[10, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[11, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[11, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[12, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[12, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[13, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[13, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[13, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[14, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[14, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[14, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[15, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[15, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[15, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[16, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[16, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[16, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[17, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[17, 2]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[17, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[17, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[18, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[18, 2]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[18, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[18, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[19, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[19, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[19, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[20, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[20, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[20, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[21, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[21, 2]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[21, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[21, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[22, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[22, 2]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[22, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[22, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[23, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[23, 2]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[23, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[23, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[24, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[24, 2]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[24, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[24, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[25, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[25, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[26, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[26, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[27, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[27, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[28, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[28, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[29, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[29, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[29, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[30, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[30, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[30, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[31, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[31, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[32, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[32, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[33, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[33, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[34, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[34, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[35, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[35, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[36, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[36, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[37, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[37, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[37, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[38, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[38, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[38, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[39, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[39, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[39, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[40, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[40, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[40, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[41, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[41, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[42, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[42, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[43, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[43, 2]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[43, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[43, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[44, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[44, 2]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[44, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[44, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[45, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[45, 2]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[45, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[45, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[46, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[46, 2]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[46, 3]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[46, 5]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[47, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[48, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[49, 1]);
        DB::insert('insert into role_has_permissions (`permission_id`, `role_id`) values (?, ?)',[50, 1]);

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

        Shift::create([
            'nama' => 'Pagi',
            'server_time' => 1,
            'jam_masuk' => "09:00:00",
            'jam_pulang' => "17:00:00"
        ]);

        Shift::create([
            'nama' => 'Sore',
            'server_time' => 1,
            'jam_masuk' => "15:00:00",
            'jam_pulang' => "23:00:00"
        ]);

        Shift::create([
            'nama' => 'Malam',
            'server_time' => 1,
            'jam_masuk' => "23:00:00",
            'jam_pulang' => "07:00:00"
        ]);

        $user = User::find(1);
        $user->assignRole(['Admin']);

        $user = User::find(2);
        $user->assignRole(['Staff']);

        $user = User::find(3);
        $user->assignRole(['Teknisi']);
    }
}
