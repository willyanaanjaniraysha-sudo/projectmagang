

<?php $__env->startSection('content'); ?>
<div style="padding: 20px;">
    <!-- Header & Tombol Tambah -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="margin: 0; color: #1a1a2e;">Manajemen Role</h2>
            <p style="color: #666; font-size: 14px; margin-top: 5px;">Atur hak akses pengguna sekolah.</p>
        </div>
        <!-- Tombol Tambah -->
        <a href="<?php echo e(route('user.create')); ?>" style="background: #4e73df; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; font-size: 14px; box-shadow: 0 4px 6px rgba(78,115,223,0.2);">
            + Tambah User / Admin
        </a>
    </div>

    <!-- Tabel Manual -->
    <div class="card" style="padding: 0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f8f9fc; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px 20px; font-size: 12px; color: #333; text-transform: uppercase;">Nama Pengguna</th>
                    <th style="padding: 15px 20px; font-size: 12px; color: #333; text-transform: uppercase;">Email</th>
                    <th style="padding: 15px 20px; font-size: 12px; color: #333; text-transform: uppercase; text-align: center;">Status Role</th>
                    <th style="padding: 15px 20px; font-size: 12px; color: #333; text-transform: uppercase; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px 20px; font-weight: 600; color: #444;"><?php echo e($user->name); ?></td>
                    <td style="padding: 15px 20px; color: #666;"><?php echo e($user->email); ?></td>
                    <td style="padding: 15px 20px; text-align: center;">
                        <span style="background: #e7f0ff; color: #4e73df; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase;">
                            <?php echo e($user->role); ?>

                        </span>
                    </td>
                    <td style="padding: 15px 20px; text-align: center;">
                        <!-- Tombol Edit -->
                        <a href="<?php echo e(route('user.edit', $user->id)); ?>" style="color: #f6c23e; text-decoration: none; margin-right: 15px; font-size: 14px; font-weight: bold;">Edit</a>
                        
                        <!-- Tombol Hapus -->
                        <form action="<?php echo e(route('user.destroy', $user->id)); ?>" method="POST" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" style="background: none; border: none; color: #e74a3b; cursor: pointer; font-weight: bold; font-size: 14px; padding: 0;">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

   <?php if(method_exists($users, 'links')): ?>
    <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #666;">
        <div>Menampilkan <?php echo e($users->count()); ?> data dari <?php echo e($users->total()); ?></div>
        <div class="manual-pagination">
            <?php echo e($users->links()); ?>

        </div>
    </div>
<?php endif; ?>

<style>
    /* Supaya angka pagination tidak raksasa */
    .manual-pagination svg { width: 20px; }
    .manual-pagination nav div:first-child { display: none; } /* Sembunyikan teks "Showing..." bawaan */
    .manual-pagination nav { display: flex; gap: 5px; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainsuperadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/role.blade.php ENDPATH**/ ?>