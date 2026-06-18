<?php

namespace App\Http\Controllers; // Tambahkan \User di sini

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
{
    // 1. CEK ROLE USER YANG SEDANG LOGIN
    if (Auth::user()->role === 'user') {
        
        // 🟢 JIKA YANG LOGIN ADALAH USER BISA / MASYARAKAT:
        // Filter semua hitungan HANYA untuk ID user ini saja (misal: Yuni)
        $total = \App\Models\Pengaduan::where('user_id', Auth::id())->count();
        $pending = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'pending')->count();
        $proses = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'proses')->count();
        $selesai = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'selesai')->count();

        // Data grafik khusus untuk user ini saja
        $days = []; $chartPending = []; $chartProses = []; $chartSelesai = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->endOfDay();
            $days[] = $date->translatedFormat('l'); 
            
            $chartPending[] = \App\Models\Pengaduan::where('user_id', Auth::id())->where('created_at', '<=', $date)->where('status', 'pending')->count();
            $chartProses[] = \App\Models\Pengaduan::where('user_id', Auth::id())->where('created_at', '<=', $date)->where('status', 'proses')->count();
            $chartSelesai[] = \App\Models\Pengaduan::where('user_id', Auth::id())->where('created_at', '<=', $date)->where('status', 'selesai')->count();
        }

    } else {
        
        // 🔵 JIKA YANG LOGIN ADALAH ADMIN ATAU SUPER ADMIN:
        // Hitung total keseluruhan data dari semua masyarakat (Global)
        $total = \App\Models\Pengaduan::count();
        $pending = \App\Models\Pengaduan::where('status', 'pending')->count();
        $proses = \App\Models\Pengaduan::where('status', 'proses')->count();
        $selesai = \App\Models\Pengaduan::where('status', 'selesai')->count();

        // Data grafik global untuk admin
        $days = []; $chartPending = []; $chartProses = []; $chartSelesai = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->endOfDay();
            $days[] = $date->translatedFormat('l'); 
            
            $chartPending[] = \App\Models\Pengaduan::where('created_at', '<=', $date)->where('status', 'pending')->count();
            $chartProses[] = \App\Models\Pengaduan::where('created_at', '<=', $date)->where('status', 'proses')->count();
            $chartSelesai[] = \App\Models\Pengaduan::where('created_at', '<=', $date)->where('status', 'selesai')->count();
        }
    }

    // 2. Lempar data yang sudah terpisah rapi ke file Blade yang sama
    return view('dashboard', compact(
        'total', 'pending', 'proses', 'selesai', 
        'days', 'chartPending', 'chartProses', 'chartSelesai'
    ));
}




    public function pengaturan()
    {
        return view('pengaturan');
    }
 
    public function profil()
{
    return view('profil');
}
}
