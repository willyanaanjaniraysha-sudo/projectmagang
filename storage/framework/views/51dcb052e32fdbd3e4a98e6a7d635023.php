<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; }
        .nav-link { color: #a2a2c2; padding: 12px 20px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); border-left: 4px solid rgba(255,255,255,0.1); }
        .main-content { flex: 1; padding: 30px; }
    </style>
</head>
<body>
<div class="d-flex">

    <?php echo $__env->make('layouts.component.sidebaradmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="main-content" style="max-width: 600px;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="<?php echo e(route('user.index')); ?>" class="btn btn-sm btn-secondary rounded-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0"><i class="fas fa-user-plus me-2 text-primary"></i>Tambah User</h4>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <form action="<?php echo e(route('user.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" 
                           value="<?php echo e(old('name')); ?>" placeholder="Masukkan nama lengkap">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" 
                           placeholder="Minimal 6 karakter">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Role</label>
                    <select name="role" class="form-select">
                        <option value="">-- Pilih Role --</option>
                        <option value="user"        <?php echo e(old('role') == 'user'        ? 'selected' : ''); ?>>User</option>
                        <option value="admin"       <?php echo e(old('role') == 'admin'       ? 'selected' : ''); ?>>Admin</option>
                        <option value="super admin" <?php echo e(old('role') == 'super admin' ? 'selected' : ''); ?>>Super Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-3">
                    <i class="fas fa-save me-1"></i> Simpan User
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/user/create.blade.php ENDPATH**/ ?>