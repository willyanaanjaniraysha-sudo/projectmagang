<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserActivity; // Panggil model Log yang sudah dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data login user untuk memastikan hanya admin/super admin yang bisa lewat
        if (!in_array(Auth::user()->role, ['admin', 'super admin'])) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        $query = UserActivity::with('user');

        // ===========================
        // FILTER: Pencarian nama/email pengguna
        // ===========================
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // ===========================
        // FILTER: Jenis Aksi (LOGIN, CREATE, UPDATE, DELETE, dst)
        // ===========================
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // ===========================
        // FILTER: Rentang Tanggal
        // ===========================
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Ambil data log, urutkan dari yang terbaru (latest)
        // Gunakan paginate(25) agar per halaman hanya menampilkan 25 data
        $activities = $query->latest()
                        ->paginate(25)
                        ->withQueryString();

        // Daftar jenis aksi unik untuk dropdown filter
        $actionOptions = ['LOGIN', 'LOGOUT', 'CREATE', 'UPDATE', 'DELETE', 'DOWNLOAD', 'VIEW', 'RESTORE'];

        if(Auth::user()->role === 'super admin') {
            $layout = 'layouts.mainsuperadmin'; // Layout untuk super admin
        } else {
            $layout = 'layouts.mainadmin'; // Layout untuk admin biasa
        }

        // Lempar data ke halaman view di resources/views/admin/activity-log/index.blade.php
        return view('admin.userActivityLog.index', compact('activities', 'layout', 'actionOptions'));
    }
}