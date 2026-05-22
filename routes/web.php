<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () { return redirect('/login'); });

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proses.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');

    // Pengaduan (user)
    Route::get('/pengaduan/saya',   [PengaduanController::class, 'saya'])->name('pengaduan.saya');
    Route::resource('pengaduan', PengaduanController::class);
    
    // Aspirasi (admin)
    Route::get('/aspirasi',         [AspirasiController::class, 'kelola'])->name('aspirasi.kelola');
    Route::get('/aspirasi/masuk',   [AspirasiController::class, 'masuk'])->name('aspirasi.masuk');
    Route::get('/aspirasi/proses',  [AspirasiController::class, 'proses'])->name('aspirasi.proses');
    Route::get('/aspirasi/selesai', [AspirasiController::class, 'selesai'])->name('aspirasi.selesai');
    Route::patch('/aspirasi/{id}/status', [AspirasiController::class, 'updateStatus'])->name('aspirasi.updateStatus');

    // Kelola User
    Route::resource('user', UserController::class);

    // Kelola Admin
    Route::get('/admin',           [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create',    [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin',          [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::patch('/admin/{id}',    [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{id}',   [AdminController::class, 'destroy'])->name('admin.destroy');

    // Laporan
    Route::get('/laporan',       [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // Pengaturan & Profil
    Route::get('/pengaturan', [DashboardController::class, 'pengaturan'])->name('pengaturan');
    Route::get('/profil',     [DashboardController::class, 'profil'])->name('profil');
    // Pastikan user sudah login (opsional, tergantung sistem Anda)
    Route::middleware(['auth'])->group(function () {    // Tautkan URL /profile ke ProfileController fungsi 'show' atau 'index'
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');
    Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');   
    Route::put('/profil/update-photo', [ProfileController::class, 'updatePhoto'])->name('profil.update-photo');
    });

    Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');
    Route::put('/profil/update-photo', [ProfileController::class, 'updatePhoto'])->name('profil.update-photo');
    
    // Tambahkan baris rute baru ini:
    Route::delete('/profil/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profil.delete-photo');
});



    });

    //Activity Log
    Route::middleware(['auth'])->group(function () {
    Route::delete('/aspirasi/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    Route::get('/aspirasi/history', [AspirasiController::class, 'history'])->name('aspirasi.history');
    });
});