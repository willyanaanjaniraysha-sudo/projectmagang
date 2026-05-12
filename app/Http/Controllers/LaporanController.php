<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('user')->latest()->get();
        return view('laporan.index', compact('pengaduans'));
    }

    public function cetak(Request $request)
    {
        $status = $request->status ?? 'semua';

        if ($status == 'semua') {
            $pengaduans = Pengaduan::with('user')->latest()->get();
        } else {
            $pengaduans = Pengaduan::with('user')
                            ->where('status', $status)
                            ->latest()
                            ->get();
        }

        $pdf = Pdf::loadView('laporan.pdf', compact('pengaduans', 'status'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengaduan-' . strtolower($status) . '.pdf');
    }
}