<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'user') {
            
            $total = \App\Models\Pengaduan::where('user_id', Auth::id())->count();
            $pending = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'pending')->count();
            $proses = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'proses')->count();
            $selesai = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'selesai')->count();

            $days = []; $chartPending = []; $chartProses = []; $chartSelesai = []; $chartDisposisi = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->endOfDay();
                $days[] = $date->translatedFormat('l'); 
                
                $chartPending[] = \App\Models\Pengaduan::where('user_id', Auth::id())->where('created_at', '<=', $date)->where('status', 'pending')->count();
                $chartProses[] = \App\Models\Pengaduan::where('user_id', Auth::id())->where('created_at', '<=', $date)->where('status', 'proses')->count();
                $chartSelesai[] = \App\Models\Pengaduan::where('user_id', Auth::id())->where('created_at', '<=', $date)->where('status', 'selesai')->count();
                
                // Menghitung disposisi dari status pengaduan (jika statusnya 'disposisi')
                $chartDisposisi[] = \App\Models\Pengaduan::where('user_id', Auth::id())->where('created_at', '<=', $date)->where('status', 'disposisi')->count();
            }

        } else {
            
            $total = \App\Models\Pengaduan::count();
            $pending = \App\Models\Pengaduan::where('status', 'pending')->count();
            $proses = \App\Models\Pengaduan::where('status', 'proses')->count();
            $selesai = \App\Models\Pengaduan::where('status', 'selesai')->count();

            $days = []; $chartPending = []; $chartProses = []; $chartSelesai = []; $chartDisposisi = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->endOfDay();
                $days[] = $date->translatedFormat('l'); 
                
                $chartPending[] = \App\Models\Pengaduan::where('created_at', '<=', $date)->where('status', 'pending')->count();
                $chartProses[] = \App\Models\Pengaduan::where('created_at', '<=', $date)->where('status', 'proses')->count();
                $chartSelesai[] = \App\Models\Pengaduan::where('created_at', '<=', $date)->where('status', 'selesai')->count();
                
                // Menghitung global disposisi dari status pengaduan
                $chartDisposisi[] = \App\Models\Pengaduan::where('created_at', '<=', $date)->where('status', 'disposisi')->count();
            }
        }

        return view('dashboard', compact(
            'total', 'pending', 'proses', 'selesai', 
            'days', 'chartPending', 'chartProses', 'chartSelesai', 'chartDisposisi'
        ));
    }

    public function pengaturan() { return view('pengaturan'); }
    public function profil() { return view('profil'); }
}
