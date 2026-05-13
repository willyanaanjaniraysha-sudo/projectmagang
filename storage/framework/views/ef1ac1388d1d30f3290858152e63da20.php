<?php $__env->startSection('content'); ?>
<div style="max-width: 600px;">
    <h2 style="margin-bottom: 20px;">Profil Saya</h2>
    
    <div class="card" style="padding: 30px; text-align: center;">
        <div style="background: #4e73df; color: #fff; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; font-weight: bold; margin: 0 auto 20px;">
            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

        </div>
        
        <h3 style="margin: 10px 0;"><?php echo e($user->name); ?></h3>
        <p style="color: #666; margin-bottom: 20px;">Status: <strong><?php echo e(strtoupper($user->role)); ?></strong></p>
        
        <div style="text-align: left; border-top: 1px solid #eee; padding-top: 20px;">
            <label style="font-weight: bold; display: block; font-size: 13px; color: #888;">EMAIL</label>
            <p style="margin: 5px 0 15px; font-weight: 500;"><?php echo e($user->email); ?></p>
            
            <label style="font-weight: bold; display: block; font-size: 13px; color: #888;">TANGGAL BERGABUNG</label>
            <p style="margin: 5px 0 0; font-weight: 500;"><?php echo e($user->created_at->format('d M Y')); ?></p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainsuperadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/profil.blade.php ENDPATH**/ ?>