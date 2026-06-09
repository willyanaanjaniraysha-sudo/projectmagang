<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ActivityLogger;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login'); 
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin' || $user->role == 'super admin') {
            $total   = \App\Models\Pengaduan::count();
            $pending = \App\Models\Pengaduan::where('status', 'Pending')->count();
            $selesai = \App\Models\Pengaduan::where('status', 'Selesai')->count();
            $proses  = \App\Models\Pengaduan::where('status', 'Proses')->count();
            $queryGrafik = \App\Models\Pengaduan::query();
        } else {
            $total   = \App\Models\Pengaduan::where('user_id', Auth::id())->count();
            $pending = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Pending')->count();
            $selesai = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Selesai')->count();
            $proses  = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Proses')->count();
            $queryGrafik = \App\Models\Pengaduan::where('user_id', Auth::id());
        }

        $days = [];
        $chartPending = [];
        $chartProses = [];
        $chartSelesai = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $days[] = now()->subDays($i)->format('d M');
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
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Catat log login
            ActivityLogger::log(
                'LOGIN',
                'auth',
                'User ' . Auth::user()->name . ' login ke sistem'
            );

            return redirect()->intended('/dashboard');
        }

        return back()
            ->with('error', 'Email atau Password salah!')
            ->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        // Catat log logout sebelum session dihapus
        ActivityLogger::log(
            'LOGOUT',
            'auth',
            'User ' . Auth::user()->name . ' logout dari sistem'
        );

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}