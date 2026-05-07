<?php 

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\AuthController; 

Route::get('/', function () { 
    return redirect('/login'); 
}); 

// Halaman Form Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); 

// Proses Kirim Data Login (POST) - SESUAIKAN NAME DI SINI
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('proses.login'); 

// Halaman Dashboard
Route::get('/dashboard', [AuthController::class, 'index'])->middleware('auth')->name('dashboard');

// Tambahkan route logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
