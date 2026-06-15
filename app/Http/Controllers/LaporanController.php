<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\UserActivity; 
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('user')->latest()->get();
        return view('laporan.index', compact('pengaduans'));
    }

    public function cetak(Request $request)
    {
        $status = $request->status ?? 'semua';

        if ($status == 'semua') {
            $pengaduans = Pengaduan::with('user')->latest()->get();
        } else {
            $pengaduans = Pengaduan::with('user')
                            ->where('status', $status)
                            ->latest()
                            ->get();
        }

        // 🛠️ KUNCI UTAMA: Masukkan log aktivitas di sini sebelum file PDF di-download browser
        UserActivity::create([
            'user_id'     => Auth::id(),
            'role'        => Auth::user()->role ?? 'user', 
            'action'      => 'DOWNLOAD',               
            'resource'    => 'laporan',                
            'description' => 'Mendownload file laporan pengaduan dengan status: ' . $status, 
            'ip_address'  => $request->ip(),          
            'device_info' => $request->userAgent(),   
        ]);

        // Proses pembuatan PDF bawaan aplikasi Anda
        $pdf = Pdf::loadView('laporan.pdf', compact('pengaduans', 'status'))
                  ->setPaper('a4', 'landscape');

        // Mengirimkan file cetak unduhan ke browser
        return $pdf->download('laporan-pengaduan-' . strtolower($status) . '.pdf');
    }
}
