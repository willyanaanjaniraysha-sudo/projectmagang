<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1e293b; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1e293b; padding-bottom: 10px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header p { margin: 4px 0 0; font-size: 11px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #1e293b; color: white; padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; font-size: 11px; }
        tr:nth-child(even) { background: #f8fafc; }
        .badge { padding: 3px 8px; border-radius: 20px; font-size: 10px; font-weight: bold; }
        .pending  { background: #fef3c7; color: #92400e; }
        .proses   { background: #dbeafe; color: #1e40af; }
        .selesai  { background: #d1fae5; color: #065f46; }
        .footer { margin-top: 20px; font-size: 10px; color: #94a3b8; text-align: right; }
        .info-box { background: #f1f5f9; padding: 8px 12px; border-radius: 6px; margin-bottom: 14px; font-size: 11px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN PENGADUAN</h2>
        <p>Sistem E-Aspirasi Kelurahan &mdash; Dicetak pada <?php echo e(now()->format('d M Y, H:i')); ?> WIB</p>
    </div>

    <div class="info-box">
        Filter Status: <strong><?php echo e($status == 'semua' ? 'Semua Status' : $status); ?></strong> &nbsp;|&nbsp;
        Total Data: <strong><?php echo e($pengaduans->count()); ?> pengaduan</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Pelapor</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pengaduans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->user->name ?? '-'); ?></td>
                <td><?php echo e($item->judul); ?></td>
                <td><?php echo e(Str::limit($item->deskripsi, 80)); ?></td>
                <td>
                    <span class="badge <?php echo e(strtolower($item->status)); ?>"><?php echo e($item->status); ?></span>
                </td>
                <td><?php echo e($item->created_at->format('d M Y')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" style="text-align:center; color:#94a3b8;">Tidak ada data.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem &mdash; E-Aspirasi Kelurahan
    </div>

</body>
</html><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/laporan/pdf.blade.php ENDPATH**/ ?>