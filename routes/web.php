<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;
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
Fortify::loginView(function () {
    return view('auth.login');
});

// Reset Password
Fortify::requestPasswordResetLinkView(function () {
    return view('auth.forgot-password');
});

// Verified Account
Route::group(['middleware' => 'auth'], function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profil', [ProfilController::class, 'index'])->name('profile.index');
    Route::get('/profil/reset-password', [ProfilController::class, 'indexResetPassword'])->name('profile.indexResetPassword');
    Route::put('/profil/{id}', [ProfilController::class, 'updateProfil'])->name('profile.updateProfil');
    Route::put('/profil/{id}/password', [ProfilController::class, 'updatePassword'])->name('profile.updatePassword');
});
