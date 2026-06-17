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
use App\Http\Middleware\LogMenuAktivitas;

// =================================================================
// 🔑 GERBANG UTAMA (GUEST / SEBELUM LOGIN)
// =================================================================
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proses.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =================================================================
// 🛡️ GRUP UTAMA: WAJIB AUTH & DIOTOMATISASI REKAM LOG AKTIVITAS (VIEW)
// =================================================================
Route::middleware(['auth', LogMenuAktivitas::class])->group(function () {

    // 1. DASHBOARD (Cukup 1 rute ini saja, diarahkan ke AdminController yang valid)
   Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');


    // 2. LOG AKTIVITAS
    Route::get('/admin/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');

    // 3. PENGADUAN (Menu Navigasi Halaman)
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/saya', [PengaduanController::class, 'saya'])->name('pengaduan.saya');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');

    // 4. ASPIRASI (Menu Navigasi Halaman)
    Route::get('/aspirasi', [AspirasiController::class, 'kelola'])->name('aspirasi.kelola');
    Route::get('/aspirasi/masuk', [AspirasiController::class, 'masuk'])->name('aspirasi.masuk');
    Route::get('/aspirasi/proses', [AspirasiController::class, 'proses'])->name('aspirasi.proses');
    Route::get('/aspirasi/selesai', [AspirasiController::class, 'selesai'])->name('aspirasi.selesai');
    Route::get('/aspirasi/history', [AspirasiController::class, 'history'])->name('aspirasi.history');

    // 5. USER & MASTER (Menu Navigasi Halaman)
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');

    // 6. ADMIN (Menu Navigasi Halaman)
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');

    // 7. LAPORAN
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // 8. PENGATURAN SISTEM
    Route::get('/pengaturan', [DashboardController::class, 'pengaturan'])->name('pengaturan');

    // 9. PROFIL USER
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');

});


// =================================================================
// ⚡ GRUP PROSES DATA: HANYA PERLU AUTH (AGAR TIDAK OVERLAP LOG VIEW)
// =================================================================
Route::middleware(['auth'])->group(function () {

    // Aksi CRUD Pengaduan
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');
    Route::delete('/pengaduan/{pengaduan}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');

    // Aksi Update Status Aspirasi
    Route::patch('/aspirasi/{id}/status', [AspirasiController::class, 'updateStatus'])->name('aspirasi.updateStatus');

    // Aksi CRUD User Master
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::patch('/user/{id}/restore', [UserController::class, 'restore'])->name('user.restore')->withTrashed();

    // Aksi CRUD Admin
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::patch('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Aksi Perubahan Profil & Unggah Foto
    Route::put('/profil/update', [ProfileController::class, 'update'])->name('profil.update');
    Route::put('/profil/update-photo', [ProfileController::class, 'updatePhoto'])->name('profil.update-photo');
    Route::delete('/profil/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profil.delete-photo');
    Route::delete('/profil/delete', [ProfileController::class, 'destroy'])->name('profil.delete');

});
