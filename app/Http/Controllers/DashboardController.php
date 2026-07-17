<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function index()
    {
        $isUser = Auth::user()->role === 'user';

        // Query dasar: khusus milik user yang login, atau semua data untuk admin/super admin
        $baseQuery = fn () => $isUser
            ? Pengaduan::where('user_id', Auth::id())
            : Pengaduan::query();

        // ===========================
        // STAT CARDS
        // Status di bawah ini SAMA PERSIS dengan yang dipakai di Kelola Pengaduan
        // (lihat AdminPengaduanController::STATUSES) — termasuk huruf besar/kecilnya.
        // ===========================
        $total     = $baseQuery()->count();
        $masuk     = $baseQuery()->where('status', 'Pending')->count();
        $proses    = $baseQuery()->where('status', 'Proses')->count();
        $disposisi = $baseQuery()->where('status', 'Disposisi')->count();
        $selesai   = $baseQuery()->where('status', 'Selesai')->count();

        // ===========================
        // GRAFIK 7 HARI TERAKHIR
        // ===========================
        $days = [];
        $chartMasuk = [];
        $chartProses = [];
        $chartDisposisi = [];
        $chartSelesai = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->translatedFormat('l');

            $chartMasuk[]     = $baseQuery()->whereDate('created_at', '<=', $date->toDateString())->where('status', 'Pending')->count();
            $chartProses[]    = $baseQuery()->whereDate('created_at', '<=', $date->toDateString())->where('status', 'Proses')->count();
            $chartDisposisi[] = $baseQuery()->whereDate('created_at', '<=', $date->toDateString())->where('status', 'Disposisi')->count();
            $chartSelesai[]   = $baseQuery()->whereDate('created_at', '<=', $date->toDateString())->where('status', 'Selesai')->count();
        }

        $layout = $this->getLayout();

        return view('dashboard', compact(
            'total', 'masuk', 'proses', 'disposisi', 'selesai',
            'days', 'chartMasuk', 'chartProses', 'chartDisposisi', 'chartSelesai',
            'layout'
        ));
    }

    public function pengaturan()
    {
        $layout = $this->getLayout();

        return view('pengaturan', compact('layout'));
    }

    public function profil()
    {
        $layout = $this->getLayout();

        return view('profil', compact('layout'));
    }

    /**
     * Tentukan layout berdasarkan role user yang login.
     */
    private function getLayout()
    {
        if (Auth::user()->role === 'super admin') {
            return 'layouts.mainsuperadmin';
        } elseif (Auth::user()->role === 'admin') {
            return 'layouts.mainadmin';
        }

        return 'layouts.mainuser';
    }
}