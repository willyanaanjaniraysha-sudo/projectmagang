<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\UserActivity; // Pastikan Model Log Aktivitas dipanggil di bagian atas
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

        $pdf = Pdf::loadView('laporan.pdf', compact('pengaduans', 'status'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengaduan-' . strtolower($status) . '.pdf');
    }

    

public function downloadLaporan($id)
{
    // 1. Proses ambil data laporannya terlebih dahulu
    // Contoh: $laporan = Laporan::findOrFail($id);

    // 2. KUNCI UTAMA: Masukkan catatan ke tabel log aktivitas sebelum file diunduh
    UserActivity::create([
        'user_id' => Auth::id(), // ID user yang sedang login dan mendownload
        'activity' => 'Mendownload Laporan Rekapitulasi Aspirasi', // Deskripsi aktivitas
        // Jika tabel log Anda punya kolom tambahan, silakan sesuaikan di bawah ini:
        // 'description' => 'User mendownload file laporan ID: ' . $id,
    ]);

    // 3. Kembalikan file unduhan ke browser pengguna
    // Contoh jika file disimpan di storage:
    return response()->download(storage_path('app/public/laporan/rekap-aspirasi.pdf'));
}

}