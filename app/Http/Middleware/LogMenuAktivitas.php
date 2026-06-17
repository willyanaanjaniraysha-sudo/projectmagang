<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogMenuAktivitas
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya rekam jika user sudah login dan sedang membuka halaman (GET)
        if (Auth::check() && $request->isMethod('GET')) {
            
            $urlPath = $request->path();
            $modul = 'navigasi';
            $deskripsi = 'Membuka halaman ' . $urlPath;

            // =================================================================
            // 🛠️ PEMETAAN MENU SUPER ADMIN, ADMIN, & USER
            // =================================================================
            
            // Jika URL dashboard Anda di laptop ternyata bernama 'home' atau 'admin'
            if ($urlPath === 'dashboard' || $urlPath === 'home' || $urlPath === 'admin' || str_contains($urlPath, 'dashboard')) {
                $modul = 'dashboard';
                $deskripsi = 'Membuka halaman utama Dashboard Ringkasan';
            }
            
            // 2. KELOLA PENGADUAN & RIWAYAT (Super Admin, Admin, User)
            elseif (str_contains($urlPath, 'pengaduan') || str_contains($urlPath, 'aspirasi')) {
                $modul = 'pengaduan';
                
                if (str_contains($urlPath, 'create') || str_contains($urlPath, 'tambah') || str_contains($urlPath, 'buat')) {
                    $deskripsi = 'Membuka halaman form Buat Pengaduan Baru';
                } elseif (str_contains($urlPath, 'saya') || str_contains($urlPath, 'riwayat')) {
                    $deskripsi = 'Membuka menu Riwayat Pengaduan Saya';
                } elseif (str_contains($urlPath, 'masuk')) {
                    $deskripsi = 'Membuka halaman daftar Laporan Masuk';
                } elseif (str_contains($urlPath, 'proses')) {
                    $deskripsi = 'Membuka halaman daftar Laporan Dalam Proses';
                } elseif (str_contains($urlPath, 'selesai')) {
                    $deskripsi = 'Membuka halaman daftar Riwayat Selesai';
                } else {
                    $deskripsi = 'Membuka menu utama Kelola Pengaduan';
                }
            } 
            
            // 3. DATA MASTER & KELOLA USER & PENGATURAN (Super Admin & Admin)
            elseif (str_contains($urlPath, 'user') || str_contains($urlPath, 'master') || str_contains($urlPath, 'sistem') || str_contains($urlPath, 'pengaturan')) {
                $modul = 'data master';
                
                if (str_contains($urlPath, 'create') || str_contains($urlPath, 'tambah')) {
                    $deskripsi = 'Membuka halaman Aktivitas Menambahkan User Baru';
                } elseif (str_contains($urlPath, 'sistem') || str_contains($urlPath, 'pengaturan')) {
                    $deskripsi = 'Membuka menu Pengaturan Sistem Utama';
                } else {
                    $deskripsi = 'Membuka menu utama Kelola User';
                }
            } 
            
            // 4. LAPORAN & CETAK (Super Admin & Admin)
            elseif (str_contains($urlPath, 'laporan') || str_contains($urlPath, 'cetak')) {
                $modul = 'laporan';
                
                if (str_contains($urlPath, 'cetak') || str_contains($urlPath, 'download')) {
                    $deskripsi = 'Mengakses halaman form Cetak/Download Laporan';
                } else {
                    $deskripsi = 'Membuka menu utama Laporan Pengaduan';
                }
            } 
            
            // 5. LOG AKTIVITAS (Super Admin & Admin)
            elseif (str_contains($urlPath, 'activity-logs') || str_contains($urlPath, 'log')) {
                $modul = 'log aktivitas';
                $deskripsi = 'Membuka halaman Log Jejak Audit Pengguna';
            }

            // =================================================================
            // 🚀 SIMPAN OTOMATIS KE DATABASE
            // =================================================================
            UserActivity::create([
                'user_id'     => Auth::id(),
                'role'        => Auth::user()->role ?? 'user',
                'action'      => 'VIEW', 
                'resource'    => $modul,
                'description' => $deskripsi,
                'ip_address'  => $request->ip(),
                'device_info' => $request->userAgent(),
            ]);
        }

        return $response;
    }
}
