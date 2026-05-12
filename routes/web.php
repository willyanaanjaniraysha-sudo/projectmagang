<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () { return redirect('/login'); });

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proses.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');
    
    // Menu Sidebar yang kamu foto:
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/admin', [UserController::class, 'adminIndex'])->name('admin.index');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/pengaturan', [DashboardController::class, 'pengaturan'])->name('pengaturan');
    Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');

    // Tambahan Resource & Post
    Route::resource('user', UserController::class);
    Route::post('/pengaturan', function() { return redirect()->back(); });

    // Pastikan ada di dalam group middleware auth
Route::middleware('auth')->group(function () {
    
    // Rute Index Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    // Rute Cetak Laporan (TAMBAHKAN INI)
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    Route::get('/role', [UserController::class, 'roleIndex'])->name('role.index');


});

});
