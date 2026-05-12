<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

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
            $gambar     = $request->file('gambar');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('upload'), $namaGambar);
        }

        Pengaduan::create([
            'user_id'   => Auth::id(),
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $namaGambar,
            'status'    => 'Pending'
        ]);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dikirim');
    }


    public function saya()
    {
        $user = Auth::user();

        return view('pengaduan.saya', compact('user'));
    }
}