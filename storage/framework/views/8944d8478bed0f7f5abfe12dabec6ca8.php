<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengaduan</title>
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

    <?php echo $__env->make('layouts.component.sidebarsuperadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-tasks me-2 text-primary"></i>Kelola Pengaduan</h4>
                <p class="text-muted mb-0">Semua pengaduan masuk dari pengguna</p>
            </div>
            
            <div class="d-flex gap-2">
                <a href="/aspirasi" class="btn btn-sm <?php echo e(!request('status') ? 'btn-primary' : 'btn-outline-secondary'); ?> rounded-3">Semua</a>
                <a href="/aspirasi?status=Pending" class="btn btn-sm <?php echo e(request('status') == 'Pending' ? 'btn-warning' : 'btn-outline-warning'); ?> rounded-3">Pending</a>
                <a href="/aspirasi?status=Proses" class="btn btn-sm <?php echo e(request('status') == 'Proses' ? 'btn-info' : 'btn-outline-info'); ?> rounded-3">Proses</a>
                <a href="/aspirasi?status=Selesai" class="btn btn-sm <?php echo e(request('status') == 'Selesai' ? 'btn-success' : 'btn-outline-success'); ?> rounded-3">Selesai</a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Pelapor</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pengaduans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4"><?php echo e($index + 1); ?></td>
                            <td><?php echo e($item->user->name ?? '-'); ?></td>
                            <td><?php echo e($item->judul); ?></td>
                            <td><?php echo e(Str::limit($item->deskripsi, 50)); ?></td>
                            <td>
                                <a href="<?php echo e(asset('storage/' . $item->gambar)); ?>" target="_blank">
                                    <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>" width="55" height="55"
                                         style="object-fit:cover; border-radius:8px;">
                                </a>
                            </td>
                            <td>
                                <?php if($item->status == 'Pending'): ?>
                                    <span class="badge rounded-pill px-3 py-2" style="background:#fef3c7; color:#92400e;">Pending</span>
                                <?php elseif($item->status == 'Proses'): ?>
                                    <span class="badge rounded-pill px-3 py-2" style="background:#dbeafe; color:#1e40af;">Proses</span>
                                <?php else: ?>
                                    <span class="badge rounded-pill px-3 py-2" style="background:#d1fae5; color:#065f46;">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted"><?php echo e($item->created_at->format('d M Y')); ?></td>
                            <td>
                                <form action="<?php echo e(route('aspirasi.updateStatus', $item->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <select name="status" class="form-select form-select-sm d-inline w-auto"
                                            onchange="this.form.submit()">
                                        <option value="Pending"  <?php echo e($item->status == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                        <option value="Proses"   <?php echo e($item->status == 'Proses'  ? 'selected' : ''); ?>>Proses</option>
                                        <option value="Selesai"  <?php echo e($item->status == 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Tidak ada pengaduan.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/aspirasi/kelola.blade.php ENDPATH**/ ?>