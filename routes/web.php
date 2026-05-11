<?php 

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\AuthController;
//use App\Http\Controllers\DashboardController; 
//use App\Http\Controllers\AspirasiController;
//use App\Http\Controllers\UserController;
//use App\Http\Controllers\LaporanController; 

Route::get('/', function () { 
    return redirect('/login'); 
}); 

// Halaman Form Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); 

// Proses Kirim Data Login (POST)
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proses.login'); 

// Halaman Dashboard
Route::get('/dashboard', [AuthController::class, 'index'])->middleware('auth')->name('dashboard');

// Tambahkan route logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

   