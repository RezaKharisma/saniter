<?php

use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Route;

// Ajax
use App\Http\Controllers\IzinController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\StokMaterialController;

// Settings
use App\Http\Controllers\Ajax\AjaxIzinController;
use App\Http\Controllers\Ajax\AjaxMenuController;
use App\Http\Controllers\Ajax\AjaxRoleController;
use App\Http\Controllers\Ajax\AjaxUserController;
use App\Http\Controllers\Settings\MenuController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Ajax\AjaxAbsenController;
use App\Http\Controllers\Ajax\AjaxShiftController;

// All
use App\Http\Controllers\Settings\ShiftController;
use App\Http\Controllers\Ajax\AjaxLokasiController;
use App\Http\Controllers\API\NamaMaterialController;
use App\Http\Controllers\Settings\SubMenuController;
use App\Http\Controllers\Ajax\AjaxRegionalController;
use App\Http\Controllers\Settings\RegionalController;
use App\Http\Controllers\Settings\PengaturanController;

// API
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Ajax\AjaxStokMaterialController;
use App\Http\Controllers\Settings\KategoriMenuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/guzzle', [GuzzleController::class, 'index']);

// Login
Route::get('/', function(){Fortify::loginView(function () {return view('auth.login');});});
Fortify::loginView(function () {return view('auth.login');});

// Reset Password
Fortify::requestPasswordResetLinkView(function () { return view('auth.forgot-password'); });
Fortify::resetPasswordView(function () { return view('auth.reset-password'); });

// Verified Account
Route::group(['middleware' => ['auth']], function () {

    /*
    |--------------------------------------------------------------------------
    | Middleware Admin
    |--------------------------------------------------------------------------
    |
    | Berikan untuk admin saja, seperti pengaturan dan yg berhubungan dengan inti website
    |
    */
    Route::group(['middleware' => ['role:Admin|Administrator']], function () {

        // Pengaturan
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');

        // Kategori Menu
        Route::controller(KategoriMenuController::class)->group(function(){
            Route::get('/pengaturan/kategori-menu','index')->name('pengaturan.kategorimenu.index');
            Route::post('/pengaturan/kategori-menu','store')->name('pengaturan.kategorimenu.store');
            Route::put('/pengaturan/kategori-menu/{id}','update')->name('pengaturan.kategorimenu.update');
            Route::put('/pengaturan/kategori-menu/{id}/show','updateShow')->name('pengaturan.kategorimenu.updateShow');
            Route::delete('/pengaturan/kategori-menu/{id}','delete')->name('pengaturan.kategorimenu.delete');
        });

        // Menu
        Route::controller(MenuController::class)->group(function(){
            Route::get('/pengaturan/menu','index')->name('pengaturan.menu.index');
            Route::post('/pengaturan/menu','store')->name('pengaturan.menu.store');
            Route::put('/pengaturan/menu/{id}','update')->name('pengaturan.menu.update');
            Route::put('/pengaturan/menu/{id}/show','updateShow')->name('pengaturan.menu.updateShow');
            Route::delete('/pengaturan/menu/{id}','delete')->name('pengaturan.menu.delete');
        });

        // Ajax Menu Request
        Route::controller(AjaxMenuController::class)->group(function(){
            Route::get('/ajax/menu','getMenu')->name('ajax.getMenu');
            Route::post('/ajax/menu/edit','getMenuEdit')->name('ajax.getMenuEdit');
            Route::get('/ajax/sub-menu','getSubMenu')->name('ajax.getSubMenu');
            Route::post('/ajax/sub-menu/edit','getSubMenuEdit')->name('ajax.getSubMenuEdit');
            Route::get('/ajax/kategori-menu','getKategoriMenu')->name('ajax.getKategoriMenu');
            Route::post('/ajax/kategori-menu/edit','getKategoriMenuEdit')->name('ajax.getKategoriMenuEdit');
        });

        // SubMenu
        Route::controller(SubMenuController::class)->group(function(){
            Route::get('/pengaturan/sub-menu','index')->name('pengaturan.submenu.index');
            Route::post('/pengaturan/sub-menu','store')->name('pengaturan.submenu.store');
            Route::put('/pengaturan/sub-menu/{id}','update')->name('pengaturan.submenu.update');
            Route::delete('/pengaturan/sub-menu/{id}','delete')->name('pengaturan.submenu.delete');
        });

        // Role
        Route::controller(RoleController::class)->group(function(){
            Route::get('/pengaturan/role', 'index')->name('pengaturan.role.index');
            Route::get('/pengaturan/role/create', 'create')->name('pengaturan.role.create');
            Route::post('/pengaturan/role','store')->name('pengaturan.role.store');
            Route::get('/pengaturan/role/{id}/edit','edit')->name('pengaturan.role.edit');
            Route::put('/pengaturan/role/{id}','update')->name('pengaturan.role.update');
            Route::delete('/pengaturan/role/{id}','delete')->name('pengaturan.role.delete');

            Route::get('/pengaturan/assign-role', 'indexAssign')->name('pengaturan.assign-role.index');
            Route::get('/pengaturan/assign-role/{id}/edit', 'editAssign')->name('pengaturan.assign-role.edit');
            Route::put('/pengaturan/assign-role/{id}/update', 'updateAssign')->name('pengaturan.assign-role.update');
            Route::put('/pengaturan/assign-role/{id}/unssign', 'updateUnssign')->name('pengaturan.assign-role.unssign');
        });

        // Permission
        Route::controller(PermissionController::class)->group(function(){
            Route::get('/pengaturan/permission', 'index')->name('pengaturan.permission.index');
            Route::post('/pengaturan/permission','store')->name('pengaturan.permission.store');
            Route::get('/pengaturan/permission/{id}/edit','edit')->name('pengaturan.permission.edit');
            Route::put('/pengaturan/permission/{id}','update')->name('pengaturan.permission.update');
            Route::delete('/pengaturan/permission/{id}','delete')->name('pengaturan.permission.delete');
        });

        // Ajax Role Request
        Route::controller(AjaxRoleController::class)->group(function(){
            Route::get('/ajax/role','getRole')->name('ajax.getRole');
            Route::get('/ajax/permission','getPermission')->name('ajax.getPermission');
            Route::get('/ajax/assign-role','getUser')->name('ajax.getUser');
            Route::post('/ajax/tabel-add-role-user','getTabelRoleUser')->name('ajax.getTabelRoleUser');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Middleware Untuk Siapa Saja Yang Memiliki Role & Sudah Login
    |--------------------------------------------------------------------------
    */

    /*
    | Route Dashboard
    | ----------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    | Route Profile
    | ----------------------
    */
    Route::controller(ProfilController::class)->group(function(){
        Route::get('/profil', 'index')->name('profile.index');
        Route::get('/profil/reset-password', 'indexResetPassword')->name('profile.indexResetPassword');
        Route::put('/profil/{id}', 'updateProfil')->name('profile.updateProfil');
        Route::put('/profil/{id}/password', 'updatePassword')->name('profile.updatePassword');
        Route::put('/profil/{id}/image', 'updateImage')->name('profile.updateImage');
        Route::put('/profil/{id}/ttd', 'updateTtd')->name('profile.updateTtd');
    });

    /*
    | Route Izin
    | ----------------------
    */
    Route::controller(IzinController::class)->group(function()
    {
        // Izin untuk tampilan Teknisi
        Route::get('administrasi/izin', 'index')->name('izin.index')->middleware('permission:izin_read');
        Route::get('administrasi/izin/create', 'create')->name('izin.create')->middleware('permission:izin_create');
        Route::post('administrasi/izin', 'store')->name('izin.store')->middleware('permission:izin_create');
        Route::get('administrasi/izin/{id}/edit', 'edit')->name('izin.edit')->middleware('permission:izin_update');
        Route::put('administrasi/izin/{id}', 'update')->name('izin.update')->middleware('permission:izin_update');
        Route::put('administrasi/izin/{id}/validasi', 'updateValidasi')->name('izin.updateValidasi')->middleware('permission:izin_update');
        Route::delete('administrasi/izin/{id}', 'delete')->name('izin.delete')->middleware('permission:izin_delete');

        // Izin untuk admin (setting)
        Route::get('pengaturan/jumlah-izin', 'indexPengaturan')->name('pengaturan.izin.index')->middleware('permission:pengaturan_izin_read');;
        Route::get('pengaturan/jumlah-izin/create', 'createPengaturan')->name('pengaturan.izin.create')->middleware('permission:pengaturan_izin_create');;
        Route::post('pengaturan/jumlah-izin', 'storePengaturan')->name('pengaturan.izin.store')->middleware('permission:pengaturan_izin_create');;
        Route::put('pengaturan/jumlah-izin/{id}', 'updatePengaturan')->name('pengaturan.izin.update')->middleware('permission:pengaturan_izin_update');;
        Route::delete('pengaturan/jumlah-izin/{id}','deletePengaturan')->name('pengaturan.izin.delete')->middleware('permission:pengaturan_izin_delete');;
    });

    /*
    | Route Ajax Izin
    | ----------------------
    */
    Route::controller(AjaxIzinController::class)->group(function(){
        Route::get('ajax/izin', 'getIzin')->name('ajax.getIzin');
        Route::post('ajax/izin-valid', 'getValidIzin')->name('ajax.getValidIzin');
        Route::post('ajax/jumlah-izin', 'getJumlahIzin')->name('ajax.getJumlahIzin');
        Route::post('ajax/jumlah-izin-user', 'getJumlahIzinUser')->name('ajax.getJumlahIzinUser');
        Route::post('ajax/jumlah-izin/edit', 'getJumlahIzinEdit')->name('ajax.getJumlahIzinEdit');
    });

    /*
    | Route Regional
    | ----------------------
    */
    Route::controller(RegionalController::class)->group(function()
    {
        Route::get('/pengaturan/regional', 'index')->name('regional.index')->middleware('permission:regional_read');
        Route::get('/pengaturan/regional/create', 'create')->name('regional.create')->middleware('permission:regional_create');
        Route::post('/pengaturan/regional/add', 'store')->name('regional.add')->middleware('permission:regional_create');
        Route::delete('/pengaturan/regional/delete/{id}','delete')->name('regional.delete')->middleware('permission:regional_delete');
        Route::get('/pengaturan/regional/{id}/edit', 'edit')->name('regional.edit')->middleware('permission:regional_update');
        Route::put('/pengaturan/regional/{id}', 'update')->name('regional.update')->middleware('permission:regional_update');
    });

    /*
    | Route Ajax Regional
    | ----------------------
    */
    Route::controller(AjaxRegionalController::class)->group(function(){
        Route::get('/ajax/regional','getRegional')->name('ajax.getRegional')->middleware('permission:regional_read');
        Route::post('/ajax/regional/map','getRegionalMap')->name('ajax.getRegionalMap')->middleware('permission:regional_read');
        Route::post('/ajax/regional/all-map','getAllRegionalMap')->name('ajax.getAllRegionalMap')->middleware('permission:regional_read');
        Route::post('/ajax/regional/edit','getRegionalEdit')->name('ajax.getRegionalEdit')->middleware('permission:user_update');
    });

    /*
    | Route Pekerjaan
    | ----------------------
    */
    Route::controller(PekerjaanController::class)->group(function()
    {
        Route::get('/pengaturan/pekerjaan', 'index')->name('pengaturan.pekerjaan.index')->middleware('permission:pengaturan_pekerjaan_read');
        Route::get('/pengaturan/pekerjaan/create', 'create')->name('pengaturan.pekerjaan.create')->middleware('permission:pengaturan_pekerjaan_create');
    });

    /*
    | Route Ajax Pekerjaan (develop)
    | ----------------------
    */
    // Route::controller(PekerjaanController::class)->group(function(){
         
    // });

    /*
    | Route Shift
    | ----------------------
    */
    Route::resource('/pengaturan/shift',ShiftController::class);

    /*
    | Route Ajax Shift
    | ----------------------
    */
    Route::controller(AjaxShiftController::class)->group(function(){
        Route::get('/ajax/shift','getShift')->name('ajax.getShift')->middleware('permission:shift_read');
        Route::post('/ajax/shift/edit','getShiftEdit')->name('ajax.getShiftEdit')->middleware('permission:shift_update');
    });

    /*
    | Route Lokasi
    | ----------------------
    */
    Route::controller(LokasiController::class)->group(function()
    {
        Route::get('/pengaturan/lokasi', 'index')->name('lokasi.index')->middleware('permission:lokasi_read');
        Route::get('/pengaturan/lokasi/create', 'create')->name('lokasi.create')->middleware('permission:lokasi_create');
        Route::post('/pengaturan/lokasi/add', 'store')->name('lokasi.add')->middleware('permission:lokasi_create');
        Route::delete('/pengaturan/lokasi/{id}/delete','delete')->name('lokasi.delete')->middleware('permission:lokasi_delete');
        Route::get('/pengaturan/lokasi/{id}/edit', 'edit')->name('lokasi.edit')->middleware('permission:lokasi_update');
        Route::put('/pengaturan/lokasi/{id}', 'update')->name('lokasi.update')->middleware('permission:lokasi_update');
    });

    /*
    | Route Ajax Lokasi
    | ----------------------
    */
    Route::controller(AjaxLokasiController::class)->group(function(){
        Route::get('/ajax/lokasi','getLokasi')->name('ajax.getLokasi')->middleware('permission:lokasi_read');
        Route::get('/ajax/lokasi/all-map','getAllLokasiMap')->name('ajax.getAllLokasiMap')->middleware('permission:lokasi_read');
    });

    /*
    | Route User
    | ----------------------
    */
    Route::controller(UserController::class)->group(function()
    {
        Route::get('administrasi/user', 'index')->name('user.index')->middleware('permission:user_read');
        Route::get('administrasi/user/create', 'create')->name('user.create')->middleware('permission:user_create');
        Route::post('administrasi/user', 'store')->name('user.store')->middleware('permission:user_create');
        Route::get('administrasi/user/{id}/edit', 'edit')->name('user.edit')->middleware('permission:user_update');
        Route::put('administrasi/user/{id}', 'update')->name('user.update')->middleware('permission:user_update');
        Route::put('administrasi/user/{id}/update-is-active', 'updateIsActive')->name('user.updateIsActive')->middleware('permission:user_update');
        Route::delete('administrasi/user/{id}','delete')->name('user.delete')->middleware('permission:user_delete');
    });

    /*
    | Route Ajax User
    | ----------------------
    */
    Route::controller(AjaxUserController::class)->group(function(){
        Route::get('/ajax/user','getUser')->name('ajax.getUser')->middleware('permission:user_read');
        Route::post('/ajax/user/detail','getUserDetail')->name('ajax.getUserDetail')->middleware('permission:user_read');
    });

    /*
    | Route Absen
    | ----------------------
    */
    Route::controller(AbsenController::class)->group(function(){
        Route::get('/administrasi/absen', 'index')->name('absen.index')->middleware('permission:absen_read');
        Route::get('/administrasi/absen/detail', 'detail')->name('absen.detail')->middleware('permission:absen_read');
        Route::get('/administrasi/absen/create', 'create')->name('absen.create')->middleware('permission:absen_create');
        Route::post('/administrasi/absen', 'store')->name('absen.store')->middleware('permission:absen_create');
    });

    /*
    | Route Ajax Absen
    | ----------------------
    */
    Route::controller(AjaxAbsenController::class)->group(function(){
        Route::post('/ajax/absen-shift','getAbsenShift')->name('ajax.getAbsenShift');
        Route::get('/ajax/absen-log','getAbsenLog')->name('ajax.getAbsenLog');
        Route::get('/ajax/absen-detail','getAbsenDetail')->name('ajax.getAbsenDetail');
    });

    /*
    | Route Stok Material
    | ----------------------
    */
    Route::controller(StokMaterialController::class)->group(function(){
        Route::get('/material/stok-material', 'index')->name('stok-material.index')->middleware('permission:stok material_read');
        Route::get('/material/stok-material/create', 'create')->name('stok-material.create')->middleware('permission:stok material_create');
        Route::post('/material/stok-material/store', 'store')->name('stok-material.store')->middleware('permission:stok material_create');
        // Route::get('/administrasi/absen/detail', 'detail')->name('absen.detail')->middleware('permission:absen_read');
        // Route::get('/administrasi/absen/create', 'create')->name('absen.create')->middleware('permission:absen_create');
        // Route::post('/administrasi/absen', 'store')->name('absen.store')->middleware('permission:absen_create');
    });

    /*
    | Route Ajax Stok Material
    | ----------------------
    */
    Route::controller(AjaxStokMaterialController::class)->group(function(){
        Route::get('/ajax/getStokMaterial','getStokMaterial')->name('ajax.getStokMaterial');
    });

    /*
    |--------------------------------------------------------------------------
    | API Request Q-Tech
    |--------------------------------------------------------------------------
    |
    */

    /*
    | Route Nama Material API
    | ----------------------
    */
    Route::controller(NamaMaterialController::class)->group(function(){
        Route::get('/material/nama-material', 'index')->name('material.nama_material.index')->middleware('permission:nama material_read');
        Route::get('/material/user', 'user')->name('material.user')->middleware('permission:nama material_read');
        Route::post('/material/getNamaMaterial', 'getNamaMaterial')->name('material.getNamaMaterial')->middleware('permission:nama material_read');
    });
});
