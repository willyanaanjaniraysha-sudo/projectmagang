<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

//Route::get('/login', [LoginController::class, 'index'])->name('login');
//Route::post('/login', [LoginController::class, 'prosesLogin'])->name('proses.login');
//Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Route::get('/dashboard-admin', [DashboardAdminController::class, 'dashboard'])->name('admin.dashboard');
