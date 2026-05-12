<div class="sidebar d-flex flex-column" style="min-height: 100vh; background: #1a1a2e; color: #fff; width: 260px;">
    <!-- Brand -->
    <div class="p-4 text-center" style="background: rgba(0,0,0,0.1);">
        <h5 class="mb-0 fw-bold text-white">
            <i class="fas fa-school me-2"></i>E-Aspirasi
        </h5>
    </div>

    <!-- User Panel -->
    <div class="d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
        <img src="<?php echo e(asset('templates/dist/img/sunghoongwehj.jpg')); ?>" 
             class="rounded-circle me-2" width="40" height="40" alt="User">
        <div>
            <small class="text-white fw-bold"><?php echo e(Auth::user()->name); ?></small><br>
            <small style="color: #a2a2c2;">Admin</small>
        </div>
    </div>

    <!-- Menu -->
   <nav class="nav flex-column mt-2 flex-grow-1">
    <!-- DASHBOARD -->
    <a class="nav-link <?php echo e(request()->is('dashboard') ? 'active' : ''); ?> py-2" href="/dashboard">
        <i class="fas fa-fw fa-tachometer-alt me-2"></i> Dashboard
    </a>
    <a class="nav-link <?php echo e(request()->is('aspirasi/masuk*') ? 'active' : ''); ?> py-2" href="/aspirasi/masuk">
        <i class="fas fa-fw fa-envelope-open-text me-2"></i> Laporan Masuk
    </a>
    <a class="nav-link <?php echo e(request()->is('aspirasi/proses*') ? 'active' : ''); ?> py-2" href="/aspirasi/proses">
        <i class="fas fa-fw fa-spinner me-2"></i> Dalam Proses
    </a>
    <a class="nav-link <?php echo e(request()->is('aspirasi/selesai*') ? 'active' : ''); ?> py-2" href="/aspirasi/selesai">
        <i class="fas fa-fw fa-check-double me-2"></i> Riwayat Selesai
    </a>

    <!-- DATA MASTER -->
    <?php if(auth()->user()->role == 'admin' || auth()->user()->role == 'super admin'): ?>
        <div class="text-uppercase small fw-bold px-3 mt-2 text-muted" style="font-size: 0.65rem; opacity: 0.6;">
            Data Master
        </div>
        <a class="nav-link <?php echo e(request()->is('user*') ? 'active' : ''); ?> py-2" href="/user">
            <i class="fas fa-fw fa-users-cog me-2"></i> Kelola User
        </a>
        <a class="nav-link <?php echo e(request()->is('laporan*') ? 'active' : ''); ?> py-2" href="/laporan">
            <i class="fas fa-fw fa-file-pdf me-2"></i> Cetak Laporan
        </a>
    <?php endif; ?>

    <!-- REKAPITULASI -->
    <div class="text-uppercase small fw-bold px-3 mt-2 text-muted" style="font-size: 0.65rem; opacity: 0.6;">
        Rekapitulasi
    </div>
    
</nav>



    <!-- Logout -->
    <div class="p-3">
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                <i class="fas fa-sign-out-alt me-1"></i> Keluar
            </button>
        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/layouts/component/sidebaradmin.blade.php ENDPATH**/ ?>