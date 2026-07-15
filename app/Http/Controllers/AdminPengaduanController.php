<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;

class AdminPengaduanController extends Controller
{
    /**
     * Sumber kebenaran tunggal untuk alur status pengaduan.
     * Dipakai juga oleh DashboardController supaya kartu & grafik statistik
     * selalu sinkron dengan status yang benar-benar ada di database.
     */
    public const STATUSES = ['Pending', 'Diproses', 'Disposisi', 'Selesai'];

    /**
     * Menampilkan semua pengaduan (lintas user) untuk dikelola admin.
     */
    public function index()
    {
        $pengaduan = Pengaduan::with('user')->latest()->get();

        return view('admin.pengaduan.index', [
            'pengaduan' => $pengaduan,
            'statuses'  => self::STATUSES,
        ]);
    }

    /**
     * Mengubah status satu pengaduan.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', self::STATUSES),
        ]);

        $pengaduan  = Pengaduan::findOrFail($id);
        $statusLama = $pengaduan->status;

        $pengaduan->status = $request->status;
        $pengaduan->save();

        UserActivity::create([
            'user_id'     => Auth::id(),
            'role'        => Auth::user()->role,
            'action'      => 'UPDATE_STATUS',
            'resource'    => 'pengaduan',
            'ip_address'  => $request->ip(),
            'device_info' => $request->userAgent(),
            'description' => "Mengubah status pengaduan '{$pengaduan->judul}' dari {$statusLama} menjadi {$pengaduan->status}",
        ]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}