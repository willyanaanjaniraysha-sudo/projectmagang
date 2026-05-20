<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class PengaduanController extends Controller
{

    public function index()
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pengaduan.index', compact('pengaduan'));
    }
    public function create()
    {
        return view('pengaduan.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|max:255',
            'deskripsi' => 'required',
            'gambar'    => 'required|image|mimes:jpg,jpeg,png|max:10010'
        ]);

        $namaGambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            
            // 1. Mengambil nama asli file Anda (misal: "foto_rumah_rusak.jpg")
            $namaAsli = pathinfo($gambar->getClientOriginalName(), PATHINFO_FILENAME);
            
            // 2. Mengambil ekstensi file asli (misal: "jpg")
            $ekstensi = $gambar->getClientOriginalExtension();
            
            // 3. Menggabungkan Waktu + Nama Asli agar nama file unik dan tidak menimpa file lain di server [1]
            $namaGambar = time() . '_' . $namaAsli . '.' . $ekstensi;
            
            // 4. Memindahkan file ke folder 'public/upload' agar aman dan mudah diakses langsung [1]
            $gambar->move(public_path('upload'), $namaGambar);
        }

        Pengaduan::create([
            'user_id'   => Auth::id(),
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $namaGambar, // Menyimpan nama file asli ke database [1]
            'status'    => 'Pending'
        ]);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim');
    }
    public function saya()
    {
        $user = Auth::user();
        $history = Activity::where('causer_id', Auth::id())
                            ->where('causer_type', 'App\Models\User')
                            ->where('subject_type', 'App\Models\Pengaduan')
                            ->orWhere(function($query) {
                                $query->where('causer_id', Auth::id())
                                      ->where('subject_type', 'App\Models\Pengaduan')
                                      ->Where('description', 'Pengaduan telah deleted');
                            })
                            ->latest()
                            ->get();
        return view('pengaduan.saya', compact('user', 'history'));
    }
    public function history()
    {
        $history = Activity::where('causer_id', Auth::id())
            ->where('causer_type', 'App\Models\User')
            ->where('subject_type', 'App\Models\Pengaduan')
            ->where('description', 'Pengaduan telah deleted')
            ->latest()
            ->paginate(10);

        return view('pengaduan.history', compact('history')); // Kita arahkan ke folder pengaduan.history
    }
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
            if($pengaduan->user_id ==! Auth::id()) {
                abort(403, 'Aksi tidak diizinkan');
            }
        $pengaduan->delete();
        return back()->with('success', 'Pengaduan berhasil dihapus!');
    }
}