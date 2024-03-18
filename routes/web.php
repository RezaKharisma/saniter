<?php

use App\Http\Controllers\Ajax\AjaxMenuController;
use App\Http\Controllers\Ajax\AjaxRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Settings\KategoriMenuController;
use App\Http\Controllers\Settings\MenuController;
use App\Http\Controllers\Settings\PengaturanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Settings\SubMenuController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;

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

// Login
Fortify::loginView('/', function(){ return view('auth.login'); });
Fortify::loginView(function () {return view('auth.login');});

// Reset Password
Fortify::requestPasswordResetLinkView(function () { return view('auth.forgot-password'); });
Fortify::resetPasswordView(function () { return view('auth.reset-password'); });

// Verified Account
Route::group(['middleware' => ['auth']], function () {

    // Admin Role
    Route::group(['middleware' => ['role:Admin']], function () {

        // Pengaturan
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');

        // Kategori Menu
        Route::controller(KategoriMenuController::class)->group(function(){
            Route::get('/pengaturan/kategori-menu','index')->name('pengaturan.kategorimenu.index');
            Route::post('/pengaturan/kategori-menu','store')->name('pengaturan.kategorimenu.store');
            Route::put('/pengaturan/kategori-menu/{id}','update')->name('pengaturan.kategorimenu.update');
            Route::delete('/pengaturan/kategori-menu/{id}','delete')->name('pengaturan.kategorimenu.delete');
        });

        // Menu
        Route::get('/pengaturan/menu', [MenuController::class, 'index'])->name('pengaturan.menu.index');
        Route::get('/pengaturan/menu/{id}/edit', [MenuController::class, 'edit'])->name('pengaturan.menu.edit');
        Route::post('/pengaturan/menu', [MenuController::class, 'store'])->name('pengaturan.menu.store');
        Route::delete('/pengaturan/menu/{id}', [MenuController::class, 'delete'])->name('pengaturan.menu.delete');

        // User
        Route::controller(UserController::class)->group(function()
        {
            Route::get('user', 'index')->name('user.index');
            Route::get('user/create', 'create')->name('user.create');
            Route::get('user/{id}/edit', 'edit')->name('user.edit');
            Route::put('user/{id}', 'update')->name('user.update');
            Route::post('user/add', 'user_add')->name('user.add');
            Route::delete('user/delete/{id}','delete')->name('user.delete');
        });

        // Regional
        Route::controller(RegionalController::class)->group(function()
        {
            Route::get('regional', 'index')->name('regional.index');
        });

        // Menu
        Route::controller(MenuController::class)->group(function(){
            Route::get('/pengaturan/menu','index')->name('pengaturan.menu.index');
            Route::post('/pengaturan/menu','store')->name('pengaturan.menu.store');
            Route::put('/pengaturan/menu/{id}','update')->name('pengaturan.menu.update');
            Route::delete('/pengaturan/menu/{id}','delete')->name('pengaturan.menu.delete');
        });

        // SubMenu
        Route::controller(SubMenuController::class)->group(function(){
            Route::get('/pengaturan/sub-menu','index')->name('pengaturan.submenu.index');
            Route::post('/pengaturan/sub-menu','store')->name('pengaturan.submenu.store');
            Route::put('/pengaturan/sub-menu/{id}','update')->name('pengaturan.submenu.update');
            Route::delete('/pengaturan/sub-menu/{id}','delete')->name('pengaturan.submenu.delete');
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

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::controller(ProfilController::class)->group(function(){
        Route::get('/profil', 'index')->name('profile.index');
        Route::get('/profil/reset-password', 'indexResetPassword')->name('profile.indexResetPassword');
        Route::put('/profil/{id}', 'updateProfil')->name('profile.updateProfil');
        Route::put('/profil/{id}/password', 'updatePassword')->name('profile.updatePassword');
        Route::put('/profil/{id}/image', 'updateImage')->name('profile.updateImage');
    });

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');
});
