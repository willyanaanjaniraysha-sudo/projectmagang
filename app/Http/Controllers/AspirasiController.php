<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class AspirasiController extends Controller
{
    public function masuk()
    {
        $pengaduans = Pengaduan::with('user')
                        ->where('status', 'Pending')
                        ->latest()
                        ->get();

        return view('aspirasi.masuk', compact('pengaduans'));
    }

    public function proses()
    {
        $pengaduans = Pengaduan::with('user')
                        ->where('status', 'Proses')
                        ->latest()
                        ->get();

        return view('aspirasi.proses', compact('pengaduans'));
    }

    public function selesai()
    {
        $pengaduans = Pengaduan::with('user')
                        ->where('status', 'Selesai')
                        ->latest()
                        ->get();

        return view('aspirasi.selesai', compact('pengaduans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = $request->status;
        $pengaduan->save();

        return back()->with('success', 'Status berhasil diperbarui!');
    }
}