<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; }
        .nav-link { color: #a2a2c2; padding: 12px 20px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); border-left: 4px solid #818cf8; }
        .main-content { flex: 1; padding: 30px; }
    </style>
</head>
<body>
<div class="d-flex">

    <?php if(Auth::user()->role == 'super admin'): ?>
    <?php echo $__env->make('layouts.component.sidebarsuperadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif(Auth::user()->role == 'admin'): ?>
    <?php echo $__env->make('layouts.component.sidebaradmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('layouts.component.sidebaruser', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

    <div class="main-content">
        <h4 class="fw-bold mb-1"><i class="fas fa-file-pdf me-2 text-danger"></i>Cetak Laporan</h4>
        <p class="text-muted mb-4">Filter dan unduh laporan pengaduan dalam format PDF</p>

        
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <form action="<?php echo e(route('laporan.cetak')); ?>" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Filter Status</label>
                    <select name="status" class="form-select">
                        <option value="semua">Semua Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Proses">Dalam Proses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-danger w-100 rounded-3">
                        <i class="fas fa-file-pdf me-1"></i> Download PDF
                    </button>
                </div>
            </form>
        </div>

        
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 px-4 border-0">
                <h6 class="fw-bold mb-0">Preview Semua Laporan (<?php echo e($pengaduans->count()); ?> data)</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
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
                            <td class="ps-4"><?php echo e($index + 1); ?></td>
                            <td><?php echo e($item->user->name ?? '-'); ?></td>
                            <td><?php echo e($item->judul); ?></td>
                            <td><?php echo e(Str::limit($item->deskripsi, 60)); ?></td>
                            <td>
                                <?php if($item->status == 'Pending'): ?>
                                    <span class="badge rounded-pill" style="background:#fef3c7; color:#92400e;">Pending</span>
                                <?php elseif($item->status == 'Proses'): ?>
                                    <span class="badge rounded-pill" style="background:#dbeafe; color:#1e40af;">Proses</span>
                                <?php else: ?>
                                    <span class="badge rounded-pill" style="background:#d1fae5; color:#065f46;">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted"><?php echo e($item->created_at->format('d M Y')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data laporan.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/laporan/index.blade.php ENDPATH**/ ?>