<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login'); 
    }

    // 2. Fungsi Dashboard
    public function index()
{
    $user = Auth::user();

    if ($user->role == 'admin' || $user->role == 'super admin') {
        // Admin: lihat SEMUA pengaduan
        $total   = \App\Models\Pengaduan::count();
        $pending = \App\Models\Pengaduan::where('status', 'Pending')->count();
        $selesai = \App\Models\Pengaduan::where('status', 'Selesai')->count();
        $proses  = \App\Models\Pengaduan::where('status', 'Proses')->count();
    } else {
        // User biasa: hanya miliknya sendiri
        $total   = \App\Models\Pengaduan::where('user_id', Auth::id())->count();
        $pending = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Pending')->count();
        $selesai = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Selesai')->count();
        $proses  = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Proses')->count();
    }

    return view('dashboard', compact('user', 'total', 'pending', 'selesai','proses'));
}

    public function prosesLogin(Request $request)
{
    // 1. Validasi input: wajib diisi dan harus berformat email
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // 2. Ambil data kredensial untuk dicocokkan ke database
    $credentials = $request->only('email', 'password');

    // 3. Proses autentikasi (Pengecekan role sudah dihapus)
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    // 4. Kembalikan ke halaman login jika email atau password salah
    return back()
        ->with('error', 'Email atau Password salah!')
        ->withInput($request->except('password')); // Input email tetap terisi, password dikosongkan demi keamanan
}

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}
};