<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaduanController;
//use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController; 

Route::get('/', function () {
    return redirect('/login');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proses.login');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [AuthController::class, 'index'])->middleware('auth')->name('dashboard');

// Pengaduan
Route::get('/pengaduan', [PengaduanController::class, 'index'])->middleware('auth')->name('pengaduan.index');
Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->middleware('auth')->name('pengaduan.create');
Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->middleware('auth')->name('pengaduan.store');
Route::get('/pengaduan/saya', [PengaduanController::class, 'saya'])->middleware('auth')->name('pengaduan.saya');
// Tambahkan route logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//aspirasi
Route::get('/aspirasi/masuk',   [AspirasiController::class, 'masuk'])->name('aspirasi.masuk');
Route::get('/aspirasi/proses',  [AspirasiController::class, 'proses'])->name('aspirasi.proses');
Route::get('/aspirasi/selesai', [AspirasiController::class, 'selesai'])->name('aspirasi.selesai');
Route::patch('/aspirasi/{id}/status', [AspirasiController::class, 'updateStatus'])->name('aspirasi.updateStatus');

//user
Route::resource('user', UserController::class);

//laporan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');