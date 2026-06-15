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
use App\Http\Controllers\Admin\ActivityLogController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proses.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');

    // =========================
    // PENGADUAN
    // =========================
    Route::get('/pengaduan/saya', [PengaduanController::class, 'saya'])
        ->name('pengaduan.saya');

    Route::resource('pengaduan', PengaduanController::class);

    // =========================
    // ASPIRASI
    // =========================
    Route::get('/aspirasi', [AspirasiController::class, 'kelola'])
        ->name('aspirasi.kelola');

    Route::get('/aspirasi/masuk', [AspirasiController::class, 'masuk'])
        ->name('aspirasi.masuk');

    Route::get('/aspirasi/proses', [AspirasiController::class, 'proses'])
        ->name('aspirasi.proses');

    Route::get('/aspirasi/selesai', [AspirasiController::class, 'selesai'])
        ->name('aspirasi.selesai');

    Route::patch('/aspirasi/{id}/status', [AspirasiController::class, 'updateStatus'])
        ->name('aspirasi.updateStatus');

    Route::get('/aspirasi/history', [AspirasiController::class, 'history'])
        ->name('aspirasi.history');

    // =========================
    // USER
    // =========================
    Route::resource('user', UserController::class);

    Route::patch('/user/{id}/restore', [UserController::class, 'restore'])
        ->name('user.restore')
        ->withTrashed();

    // =========================
    // ADMIN
    // =========================
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');

    Route::get('/admin/create', [AdminController::class, 'create'])
        ->name('admin.create');

    Route::post('/admin', [AdminController::class, 'store'])
        ->name('admin.store');

    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])
        ->name('admin.edit');

    Route::patch('/admin/{id}', [AdminController::class, 'update'])
        ->name('admin.update');

    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])
        ->name('admin.destroy');

    // =========================
    // LAPORAN
    // =========================
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])
        ->name('laporan.cetak');

    // =========================
    // PENGATURAN
    // =========================
    Route::get('/pengaturan', [DashboardController::class, 'pengaturan'])
        ->name('pengaturan');

    // =========================
    // PROFIL
    // =========================
    Route::get('/profil', [ProfileController::class, 'show'])
        ->name('profil');

    Route::put('/profil/update', [ProfileController::class, 'update'])
        ->name('profil.update');

    Route::put('/profil/update-photo', [ProfileController::class, 'updatePhoto'])
        ->name('profil.update-photo');

    Route::delete('/profil/delete-photo', [ProfileController::class, 'deletePhoto'])
        ->name('profil.delete-photo');

    Route::delete('/profil/delete', [ProfileController::class, 'destroy'])
        ->name('profil.delete');

    // =========================
    // ACTIVITY LOG
    // =========================
    Route::get('/admin/activity-logs', [ActivityLogController::class, 'index'])
        ->name('admin.activity-logs.index');
});