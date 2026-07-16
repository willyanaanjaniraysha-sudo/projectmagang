<?php

namespace App\Http\Controllers;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    /**
     * Sumber kebenaran tunggal untuk alur status pengaduan.
     */
    public const STATUSES = ['Pending', 'Proses', 'Disposisi', 'Selesai'];

    public function masuk()
    {
        $pengaduans = Pengaduan::with('user')
                        ->where('status', 'Pending')
                        ->latest()
                        ->get();

        $layout = $this->getLayout();

        return view('aspirasi.masuk', compact('pengaduans', 'layout'));
    }

    public function proses()
    {
        $pengaduans = Pengaduan::with('user')
                        ->where('status', 'Proses')
                        ->latest()
                        ->get();

        $layout = $this->getLayout();

        return view('aspirasi.proses', compact('pengaduans', 'layout'));
    }

    public function disposisi()
    {
        $pengaduans = Pengaduan::with('user')
                        ->where('status', 'Disposisi')
                        ->latest()
                        ->get();

        $layout = $this->getLayout();

        return view('aspirasi.disposisi', compact('pengaduans', 'layout'));
    }

    public function selesai()
    {
        $pengaduans = Pengaduan::with('user')
                        ->where('status', 'Selesai')
                        ->latest()
                        ->get();

        $layout = $this->getLayout();

        return view('aspirasi.selesai', compact('pengaduans', 'layout'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', self::STATUSES),
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->status = $request->status;

        if ($request->status == 'Proses') {
            $pengaduan->tanggal_proses = now();
        }

        if ($request->status == 'Disposisi') {
            $pengaduan->tanggal_disposisi = now();
        }

        if ($request->status == 'Selesai') {
            $pengaduan->tanggal_selesai = now();
        }

        $pengaduan->save();

        $log = UserActivity::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'action' => 'UPDATE',
            'resource' => 'pengaduan',
            'ip_address' => $request->ip(),
            'device_info' => $request->userAgent(),
            'description' => "Status pengaduan ID {$pengaduan->id} diubah menjadi {$request->status}"
        ]);

        return back()->with('success', 'Status berhasil diperbarui');
    }

    public function kelola(Request $request)
    {
        $query = Pengaduan::with('user')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->get();

        $layout = $this->getLayout();

        return view('aspirasi.kelola', compact('pengaduans', 'layout'));
    }

    public function history()
    {
        $history = Activity::where('causer_id', Auth::id())
                            ->where('causer_type', 'App\Models\User')
                            ->where('subject_type', 'App\Models\Pengaduan')
                            ->where('description', 'Pengaduan telah deleted')
                            ->latest()
                            ->paginate(10);

        $layout = $this->getLayout();

        return view('aspirasi.history', compact('history', 'layout'));
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