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
            $total     = \App\Models\Pengaduan::count();
            $masuk     = \App\Models\Pengaduan::where('status', 'Pending')->count();
            $proses    = \App\Models\Pengaduan::where('status', 'Proses')->count();
            $disposisi = \App\Models\Pengaduan::where('status', 'Disposisi')->count();
            $selesai   = \App\Models\Pengaduan::where('status', 'Selesai')->count();
            $queryGrafik = \App\Models\Pengaduan::query();
        } else {
            $total     = \App\Models\Pengaduan::where('user_id', Auth::id())->count();
            $masuk     = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Pending')->count();
            $proses    = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Proses')->count();
            $disposisi = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Disposisi')->count();
            $selesai   = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Selesai')->count();
            $queryGrafik = \App\Models\Pengaduan::where('user_id', Auth::id());
        }

        $days = [];
        $chartMasuk = [];
        $chartProses = [];
        $chartDisposisi = [];
        $chartSelesai = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $days[] = now()->subDays($i)->format('d M');
            $chartMasuk[]     = (clone $queryGrafik)->whereDate('created_at', $date)->where('status', 'Pending')->count();
            $chartProses[]    = (clone $queryGrafik)->whereDate('tanggal_proses', $date)->where('status', 'Proses')->count();
            $chartDisposisi[] = (clone $queryGrafik)->whereDate('tanggal_disposisi', $date)->where('status', 'Disposisi')->count();
            $chartSelesai[]   = (clone $queryGrafik)->whereDate('tanggal_selesai', $date)->where('status', 'Selesai')->count();
        }

        $layout = $this->getLayout();

        return view('dashboard', compact(
            'user', 'total', 'masuk', 'proses', 'disposisi', 'selesai',
            'days', 'chartMasuk', 'chartProses', 'chartDisposisi', 'chartSelesai',
            'layout'
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