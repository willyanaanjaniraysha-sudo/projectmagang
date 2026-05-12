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
    } else {
        // User biasa: hanya miliknya sendiri
        $total   = \App\Models\Pengaduan::where('user_id', Auth::id())->count();
        $pending = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Pending')->count();
        $selesai = \App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Selesai')->count();
    }

    return view('dashboard', compact('user', 'total', 'pending', 'selesai'));
}

    public function prosesLogin(Request $request)
{
    $request->validate([
        'name'     => 'required',
        'password' => 'required',
        'role'     => 'required'
    ]);

    $credentials = $request->only('name', 'password');
    $selectedRole = $request->role;

    if (Auth::attempt($credentials)) {
        
        // 4. CEK ROLE: Apakah role di database sama dengan yang dipilih di form?
        if (Auth::user()->role !== $selectedRole) {
            Auth::logout(); // Keluar lagi kalau rolenya beda
            return back()->with('error', 'Role yang Anda pilih tidak sesuai dengan akun ini!')->withInput();
        }

        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->with('error', 'Nama Lengkap atau Password salah!')->withInput();
}

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}

}
