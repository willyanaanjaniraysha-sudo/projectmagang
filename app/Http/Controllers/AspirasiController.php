<?php

namespace App\Http\Controllers;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

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

    // Tambahkan ini
    if ($request->status == 'Proses') {
        $pengaduan->tanggal_proses = now();
    }
    if ($request->status == 'Selesai') {
        $pengaduan->tanggal_selesai = now();
    }

    $pengaduan->save();

    return back()->with('success', 'Status berhasil diperbarui!');
}
    public function kelola(Request $request)
    {
    $query = Pengaduan::with('user')->latest();

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $pengaduans = $query->get();
    return view('aspirasi.kelola', compact('pengaduans'));
    }

    public function history()
    {
        $history = Activity::where('causer_id', Auth::id())
                            ->where('causer_type', 'App\Models\User')
                            ->where('subject_type', 'App\Models\Pengaduan')
                            ->where('description', 'Pengaduan telah deleted')
                            ->latest()
                            ->paginate(10);

        return view('aspirasi.history', compact('history'));
    }
}