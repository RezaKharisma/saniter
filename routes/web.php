<?php

use App\Http\Controllers\Ajax\AjaxMenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfilController;
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
Route::get('/', function(){ return view('auth.login'); });
Fortify::loginView(function () {return view('auth.login');});

// Reset Password
Fortify::requestPasswordResetLinkView(function () { return view('auth.forgot-password'); });
Fortify::resetPasswordView(function () { return view('auth.reset-password'); });

// Verified Account
Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['role:Admin']], function () {
        // Pengaturan
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');

        // Menu
        Route::get('/pengaturan/menu', [MenuController::class, 'index'])->name('pengaturan.menu.index');
        Route::get('/pengaturan/menu/{id}/edit', [MenuController::class, 'edit'])->name('pengaturan.menu.edit');
        Route::post('/pengaturan/menu', [MenuController::class, 'store'])->name('pengaturan.menu.store');
        Route::delete('/pengaturan/menu/{id}', [MenuController::class, 'delete'])->name('pengaturan.menu.delete');
    });

    // Ajax Request
    Route::get('/ajax/menu', [AjaxMenuController::class, 'getMenu'])->name('ajax.getMenu');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profil', [ProfilController::class, 'index'])->name('profile.index');
    Route::get('/profil/reset-password', [ProfilController::class, 'indexResetPassword'])->name('profile.indexResetPassword');
    Route::put('/profil/{id}', [ProfilController::class, 'updateProfil'])->name('profile.updateProfil');
    Route::put('/profil/{id}/password', [ProfilController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::put('/profil/{id}/image', [ProfilController::class, 'updateImage'])->name('profile.updateImage');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');
});
