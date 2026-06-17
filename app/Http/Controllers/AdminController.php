<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
   public function index()
{
    // 1. Ambil hitungan kotak ringkasan di atas grafik
    $total = \App\Models\Pengaduan::count();
    $pending = \App\Models\Pengaduan::where('status', 'pending')->count();
    $proses = \App\Models\Pengaduan::where('status', 'proses')->count();
    $selesai = \App\Models\Pengaduan::where('status', 'selesai')->count();

    // 2. KUNCI GRAFIK: Membuat daftar 7 hari terakhir secara otomatis untuk label grafik
    $days = [];
    $totals = [];
    
    for ($i = 6; $i >= 0; $i--) {
        // Mengambil nama hari ke belakang (Senin, Selasa, dll)
        $date = now()->subDays($i);
        $days[] = $date->translatedFormat('l'); // Menghasilkan teks nama hari Indonesia
        
        // Menghitung berapa banyak pengaduan yang masuk di hari tersebut untuk titik grafik
        $totals[] = \App\Models\Pengaduan::whereDate('created_at', $date->toDateString())->count();
    }

    // 3. Lempar SEMUA data (termasuk $days dan $totals untuk grafik) ke file Blade Dashboard
    return view('dashboard', compact('total', 'pending', 'proses', 'selesai', 'days', 'totals'));
}

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => strtolower(str_replace(' ', '', $request->name)) . '@aspirasi.com',
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $admin = User::findOrFail($id);
        $admin->name = $request->name;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui!');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus!');
    }
}