<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use App\Models\Pengaduan;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login'); 
    }

    // 2. Fungsi Dashboard
       // 2. Fungsi Dashboard
    public function index()
    {
        $user = Auth::user();

        // --- A. FILTER UNTUK KOTAK INDIKATOR ATAS ---
        if ($user->role == 'admin' || $user->role == 'super admin') {
            // Admin & Super Admin: lihat SEMUA pengaduan
            $total   = \App\Models\Pengaduan::count();
            $pending = \App\Models\Pengaduan::where('status', 'Pending')->count();
            $selesai = \App\Models\Pengaduan::where('status', 'Selesai')->count();
            $proses  = \App\Models\Pengaduan::where('status', 'Proses')->count();
            
            // Query dasar grafik (Mengambil data semua orang)
            $queryGrafik = \App\Models\Pengaduan::query();
        } else {
            // User biasa: hanya laporan miliknya sendiri
            $total   = \App\Models\Pengaduan::where('user_id', Auth::id())->count();
            $pending = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Pending')->count();
            $selesai = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Selesai')->count();
            $proses  = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Proses')->count();
            
            // Query dasar grafik (DI-FILTER hanya data miliknya sendiri)
            $queryGrafik = \App\Models\Pengaduan::where('user_id', Auth::id());
        }

        // --- B. FILTER DINAMIS UNTUK KOORDINAT DIAGRAM (7 Hari Terakhir) ---
        $days = [];
        $chartPending = [];
        $chartProses = [];
        $chartSelesai = [];

        // Looping untuk membuat label 7 hari terakhir secara urut
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $days[] = now()->subDays($i)->format('d M'); // Label Tanggal (Contoh: 27 Mei)

            // Meng kloning query agar kondisi filter role di atas tidak saling tabrakan
           $chartPending[]  = (clone $queryGrafik)->whereDate('created_at', $date)->where('status', 'Pending')->count();
           $chartProses[]   = (clone $queryGrafik)->whereDate('tanggal_proses', $date)->where('status', 'Proses')->count();
           $chartSelesai[]  = (clone $queryGrafik)->whereDate('tanggal_selesai', $date)->where('status', 'Selesai')->count();
        }

        return view('dashboard', compact(
            'user', 'total', 'pending', 'selesai', 'proses', 
            'days', 'chartPending', 'chartProses', 'chartSelesai'
        ));
    }

    
    public function prosesLogin(Request $request)
    {
    // 1. Validasi input: wajib diisi dan harus berformat email
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // 2. Ambil data kredensial untuk dicocokkan ke database
    $credentials = $request->only('email', 'password');

    // 3. Proses autentikasi 
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // --- TAMBAHAN BARU: MENANGKAP DATA PERANGKAT & BROWSER USER ---
        $browser  = \Jenssegers\Agent\Facades\Agent::browser();  // Contoh hasil: Chrome, Safari, Edge
        $platform = \Jenssegers\Agent\Facades\Agent::platform(); // Contoh hasil: Windows, OS X, Android

        // Logika Penggunaan: Anda bisa menyimpan info ini ke tabel log jika ada.
        // Sebagai contoh awal, kita simpan info ini ke file Log bawaan Laravel untuk pembuktian:
        Log::info("User dengan email " . $request->email . " berhasil login menggunakan browser {$browser} pada OS {$platform}");
        // -------------------------------------------------------------

        return redirect()->intended('/dashboard');
    }

    // 4. Kembalikan ke halaman login jika email atau password salah
    return back()
        ->with('error', 'Email atau Password salah!')
        ->withInput($request->except('password')); // Input email tetap terisi, password dikosongkan demi keamanan
    }

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}
};