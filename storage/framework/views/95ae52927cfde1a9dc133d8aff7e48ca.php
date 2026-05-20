<style>
.nav-link{
    color:#a2a2c2;
    padding:12px 20px;
    transition:0.3s;
}

.nav-link:hover{
    color:#fff;
    background:rgba(255,255,255,0.05);
}

.menu-active{
    color:#fff !important;
    background:rgba(255,255,255,0.1);
    border-left:4px solid #818cf8;
}

.sidebar-fixed {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1000;
}
</style>

<div class="sidebar sidebar-fixed d-flex flex-column" style="min-height: 100vh; background: #1a1a2e; color: #fff; width: 260px;">
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
            <small style="color: #a2a2c2;"><?php echo e(Auth::user()->role); ?></small>
        </div>
    </div>

    <!-- Menu -->
    <nav class="nav flex-column mt-3 flex-grow-1">
        <a class="nav-link <?php echo e(request()->is('dashboard') ? 'menu-active' : ''); ?>" 
           href="/dashboard">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a class="nav-link <?php echo e(request()->is('pengaduan') ? 'menu-active' : ''); ?>" 
           href="/pengaduan">
            <i class="fas fa-bullhorn me-2"></i> Riwayat Pengaduan
        </a>
        <a class="nav-link <?php echo e(request()->is('pengaduan/create') ? 'menu-active' : ''); ?>" 
           href="/pengaduan/create">
            <i class="fas fa-bullhorn me-2"></i> Buat Pengaduan
        </a>
        <a class="nav-link <?php echo e(request()->is('pengaduan/saya') ? 'menu-active' : ''); ?>" 
           href="/pengaduan/saya">
            <i class="fas fa-user me-2"></i> Saya
        </a>
    </nav>
<div style="margin-top: auto; padding: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
        
        <!-- Form POST Tersembunyi untuk Proses Logout Laravel -->
        <form id="logout-form-sidebar" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>

        <!-- Tombol Logout yang Memicu Popup Modal -->
        <a class="btn btn-sm btn-block btn-soft btn-error" 
           onclick="document.getElementById('account_modal').showModal(); event.preventDefault();" 
           style="cursor: pointer; display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 10px 14px; background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px; text-decoration: none; transition: all 0.2s ease-in-out;"
           onmouseover="this.style.background='#ef4444'; this.style.color='#ffffff'; this.style.borderColor='#ef4444';" 
           onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='#f87171'; this.style.borderColor='rgba(239, 68, 68, 0.2)';">
            
            <span style="font-size: 14px; font-weight: 600; letter-spacing: 0.3px;">Logout</span>
            
            <svg class="stroke-3" xmlns="http://w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                <path d="m16 17 5-5-5-5"></path>
                <path d="M21 12H9"></path>
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            </svg>            
        </a>
    </div>
</div>

<!-- ========================================================= -->
<!-- STRUKTUR POPUP CONFIRMATION MODAL DI DALAM HTML5 DIALOG -->
<!-- ========================================================= -->
<dialog id="account_modal" class="logout-modal">
    <div style="font-size: 40px; margin-bottom: 12px;">🚪</div>
    <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Konfirmasi Keluar</h3>
    <p style="font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.5;">
        Apakah Anda yakin ingin keluar dari sistem E-Aspirasi? Sesi Anda saat ini akan diakhiri.
    </p>
    <div style="display: flex; gap: 12px; justify-content: center;">
        <!-- Tombol Batal -->
        <button class="modal-btn btn-batal" style="flex: 1;" onclick="document.getElementById('account_modal').close()">
            Batal
        </button>
        <!-- Tombol Ya, Keluar (Mengeksekusi Form POST Laravel) -->
        <button class="modal-btn btn-keluar-modal" style="flex: 1;" onclick="document.getElementById('logout-form-sidebar').submit();">
            Ya, Keluar
        </button>
    </div>
</dialog><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/layouts/component/sidebaruser.blade.php ENDPATH**/ ?>