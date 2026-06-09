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

        // Ambil data log, urutkan dari yang terbaru (latest)
        // Gunakan paginate(25) agar per halaman hanya menampilkan 25 data
        $activities = UserActivity::with('user')
                        ->latest()
                        ->paginate(25);

        if(Auth::user()->role === 'super admin') {
            $layout = 'layouts.mainsuperadmin'; // Layout untuk super admin
        } else {
            $layout = 'layouts.mainadmin'; // Layout untuk admin biasa
        }

        // Lempar data ke halaman view di resources/views/admin/activity-log/index.blade.php
        return view('admin.userActivityLog.index', compact('activities', 'layout'));
    }
}