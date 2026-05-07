<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. TAMBAHKAN INI (Untuk atasi error tadi)
    public function showLogin()
    {
        return view('login'); 
    }

    // 2. Fungsi Dashboard
    public function index()
    {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    }

    // 3. Fungsi Proses Login
    public function prosesLogin(Request $request)
{
    // 1. Validasi input (Pastikan 'name' bukan 'email')
    $request->validate([
        'name'     => 'required',
        'password' => 'required',
        'role'     => 'required'
    ]);

    // 2. Ambil data yang dikirim dari form
    $credentials = $request->only('name', 'password');
    $selectedRole = $request->role;

    // 3. Coba Login dengan Nama & Password
    if (Auth::attempt($credentials)) {
        
        // 4. CEK ROLE: Apakah role di database sama dengan yang dipilih di form?
        if (Auth::user()->role !== $selectedRole) {
            Auth::logout(); // Keluar lagi kalau rolenya beda
            return back()->with('error', 'Role yang Anda pilih tidak sesuai dengan akun ini!')->withInput();
        }

        // Jika sukses
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    // 5. Jika Nama atau Password salah
    return back()->with('error', 'Nama Lengkap atau Password salah!')->withInput();
}

public function logout(Request $request)
{
    Auth::logout();

    // Hapus session agar benar-benar keluar
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Balikkan ke halaman login
    return redirect('/login');
}

}
