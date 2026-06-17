<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan; // 👈 PASTIKAN MODEL PENGADUAN/ASPIRASI ANDA DIPANGGIL DI SINI

class DashboardController extends Controller
{
    public function index()
{
    // 1. Ambil data hitungan statistik dari database Anda
    // (Jika nama model Anda bukan 'Pengaduan', ganti dengan nama model asli Anda seperti 'Aspirasi')
    $total = \App\Models\Pengaduan::count();
    $pending = \App\Models\Pengaduan::where('status', 'pending')->count();
    $proses = \App\Models\Pengaduan::where('status', 'proses')->count();
    $selesai = \App\Models\Pengaduan::where('status', 'selesai')->count();

    // 2. KUNCI UTAMA: Kembalikan ke file view 'dashboard' (halaman grafik Anda) beserta datanya
    return view('dashboard', compact('total', 'pending', 'proses', 'selesai'));
}


    public function pengaturan()
    {
        return view('pengaturan'); 
    }

    public function profil()
    {
        $user = Auth::user();
        return view('profil', compact('user'));
    }
}
