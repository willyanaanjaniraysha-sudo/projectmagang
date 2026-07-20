<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\UserActivity; 
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('user')->latest()->get();

        if (Auth::user()->role === 'super admin') {
            $layout = 'layouts.mainsuperadmin'; // Layout untuk super admin
        } else {
            $layout = 'layouts.mainadmin'; // Layout untuk admin biasa
        }

        return view('laporan.index', compact('pengaduans', 'layout'));
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

        // 🛠️ KUNCI UTAMA: Masukkan log aktivitas di sini sebelum file PDF di-download browser
        UserActivity::create([
            'user_id'     => Auth::id(),
            'role'        => Auth::user()->role ?? 'user', 
            'action'      => 'DOWNLOAD',               
            'resource'    => 'laporan',                
            'description' => 'Mendownload file laporan pengaduan dengan status: ' . $status, 
            'ip_address'  => $request->ip(),          
            'device_info' => $request->userAgent(),   
        ]);

        // Proses pembuatan PDF bawaan aplikasi Anda
        $pdf = Pdf::loadView('laporan.pdf', compact('pengaduans', 'status'))
                  ->setPaper('a4', 'landscape');

        // Mengirimkan file cetak unduhan ke browser
        return $pdf->download('laporan-pengaduan-' . strtolower($status) . '.pdf');
    }

    /**
     * Export laporan pengaduan ke file Excel (.xlsx).
     * Memakai library PhpSpreadsheet.
     */
    public function exportExcel(Request $request)
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

        // Catat log aktivitas, sama seperti export PDF
        UserActivity::create([
            'user_id'     => Auth::id(),
            'role'        => Auth::user()->role ?? 'user',
            'action'      => 'DOWNLOAD',
            'resource'    => 'laporan',
            'description' => 'Mendownload file laporan pengaduan (Excel) dengan status: ' . $status,
            'ip_address'  => $request->ip(),
            'device_info' => $request->userAgent(),
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pengaduan');

        // ===========================
        // HEADER TABEL
        // ===========================
        $headers = ['No', 'Pelapor', 'Judul', 'Deskripsi', 'Status', 'Tanggal'];
        $sheet->fromArray($headers, null, 'A1');

        // Styling header: background hijau tema, teks putih tebal
        $headerRange = 'A1:F1';
        $sheet->getStyle($headerRange)->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($headerRange)->getFill()
              ->setFillType(Fill::FILL_SOLID)
              ->getStartColor()->setRGB('2F5D50');
        $sheet->getStyle($headerRange)->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER)
              ->setVertical(Alignment::VERTICAL_CENTER);

        // ===========================
        // ISI DATA
        // ===========================
        $row = 2;
        foreach ($pengaduans as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->user->name ?? '-');
            $sheet->setCellValue('C' . $row, $item->judul);
            $sheet->setCellValue('D' . $row, $item->deskripsi);
            $sheet->setCellValue('E' . $row, $item->status);
            $sheet->setCellValue('F' . $row, $item->created_at->format('d M Y'));
            $row++;
        }

        // Lebar kolom otomatis menyesuaikan isi
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Bikin border tipis buat semua sel yang berisi data
        $lastRow = $row - 1;
        if ($lastRow >= 1) {
            $sheet->getStyle('A1:F' . $lastRow)->getBorders()
                  ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        // ===========================
        // OUTPUT FILE KE BROWSER
        // ===========================
        $fileName = 'laporan-pengaduan-' . strtolower($status) . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}