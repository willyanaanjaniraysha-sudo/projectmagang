<?php

namespace App\Http\Controllers; // Tambahkan \User di sini

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    // 1. Ambil hitungan angka untuk 4 kotak ringkasan di atas grafik
    $total = \App\Models\Pengaduan::count();
    $pending = \App\Models\Pengaduan::where('status', 'pending')->count();
    $proses = \App\Models\Pengaduan::where('status', 'proses')->count();
    $selesai = \App\Models\Pengaduan::where('status', 'selesai')->count();

    // 2. Siapkan wadah array kosong untuk data grafik 7 hari terakhir
    $days = [];
    $chartPending = [];
    $chartProses = [];
    $chartSelesai = [];
    
    // Looping untuk menarik data statistik dari 7 hari ke belakang secara mundur
    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i);
        
        // Simpan nama hari Indonesia untuk bagian bawah grafik
        $days[] = $date->translatedFormat('l'); 
        
        // Hitung pengaduan masuk khusus status PENDING di tanggal tersebut
        $chartPending[] = \App\Models\Pengaduan::whereDate('created_at', $date->toDateString())
                            ->where('status', 'pending')
                            ->count();
                            
        // Hitung pengaduan masuk khusus status PROSES di tanggal tersebut
        $chartProses[] = \App\Models\Pengaduan::whereDate('created_at', $date->toDateString())
                            ->where('status', 'proses')
                            ->count();
                            
        // Hitung pengaduan masuk khusus status SELESAI di tanggal tersebut
        $chartSelesai[] = \App\Models\Pengaduan::whereDate('created_at', $date->toDateString())
                            ->where('status', 'selesai')
                            ->count();
    }

    // 3. KUNCI UTAMA: Lempar semua variabel yang diminta oleh file Blade dashboard Anda
    return view('dashboard', compact(
        'total', 
        'pending', 
        'proses', 
        'selesai', 
        'days', 
        'chartPending', 
        'chartProses', 
        'chartSelesai'
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
