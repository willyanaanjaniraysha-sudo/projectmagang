<style>
    .nav-link:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
    }
    .main-content {
        flex: 1;
        padding: 30px;
        position: relative;
    }
    .sidebar-fixed {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1000;
    }
    .badge-admin {
        background: #dbeafe;
        color: #1e40af;
    }
    .badge-superadmin { 
        background: #ede9fe;
        color: #5b21b6;
    }
    .badge-user {    
        background: #d1fae5;
        color: #065f46;
    }
    .logout-modal {
    border: none !important;
    border-radius: 12px !important;
    background: white !important;
    padding: 24px !important;
    max-width: 400px !important;
    width: 90% !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
    text-align: center !important;
    position: fixed !important;
    margin: auto !important;
    top: 0% !important;
    left: 0 !important; /* 130px adalah setengah dari lebar sidebar 260px */
    right: 0 !important;
    bottom: 0 !important;   
    transform: none !important;
    background: #ffffff !important;
    }
    .logout-modal::backdrop {
    background: rgba(0, 0, 0, 0.5) !important;
    backdrop-filter: blur(2px) !important;
    position: fixed !important; 
    inset: 0 !important;    
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
    <a href="{{ route('profil') }}" class="text-decoration-none">
    <div class="d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid rgba(255,255,255,0.1); cursor: pointer;">
        @if(Auth::user()->photo)
            <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                 class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;" alt="User">
        @else
            <img src="{{ asset('templates/dist/img/sunghoongwehj.jpg') }}" 
                 class="rounded-circle me-2" width="40" height="40" alt="User">
        @endif
        <div>
            <small class="text-white fw-bold">{{ Auth::user()->name }}</small><br>
            <small style="color: #a2a2c2;">Admin</small>
        </div>
    </div>
    </a>

    <!-- Menu -->
   <nav class="nav flex-column mt-2 flex-grow-1">
    <!-- DASHBOARD -->
    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }} py-2" href="/dashboard">
        <i class="fas fa-fw fa-tachometer-alt me-2"></i> Dashboard
    </a>
    <a class="nav-link {{ request()->is('aspirasi/masuk*') ? 'active' : '' }} py-2" href="/aspirasi/masuk">
        <i class="fas fa-fw fa-envelope-open-text me-2"></i> Laporan Masuk
    </a>
    <a class="nav-link {{ request()->is('aspirasi/proses*') ? 'active' : '' }} py-2" href="/aspirasi/proses">
        <i class="fas fa-fw fa-spinner me-2"></i> Dalam Proses
    </a>
    <a class="nav-link {{ request()->is('aspirasi/selesai*') ? 'active' : '' }} py-2" href="/aspirasi/selesai">
        <i class="fas fa-fw fa-check-double me-2"></i> Riwayat Selesai
    </a>

    <!-- DATA MASTER -->
    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'super admin')
        <div class="text-uppercase small fw-bold px-3 mt-2 text-muted" style="font-size: 0.65rem; opacity: 0.6;">
            Data Master
        </div>
        <a class="nav-link {{ request()->is('user*') ? 'active' : '' }} py-2" href="/user">
            <i class="fas fa-fw fa-users-cog me-2"></i> Kelola User
        </a>
        <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }} py-2" href="/laporan">
            <i class="fas fa-fw fa-file-pdf me-2"></i> Cetak Laporan
        </a>
    @endif

    <!-- REKAPITULASI -->
    <div class="text-uppercase small fw-bold px-3 mt-2 text-muted" style="font-size: 0.65rem; opacity: 0.6;">
        Rekapitulasi
    </div>
    
</nav>



    <!-- Logout -->
    <div style="margin-top: auto; padding: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
        
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

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

<dialog id="account_modal" class="logout-modal">
    <div style="font-size: 40px; margin-bottom: 12px;">📄</div>
    <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Konfirmasi Keluar</h3>
    <p style="font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.5;">
        Apakah Anda yakin ingin keluar dari sistem E-Aspirasi? Sesi Anda saat ini akan diakhiri.
    </p>
    <div style="display: flex; gap: 12px; justify-content: center;">
        <button class="modal-btn btn-batal" style="flex: 1; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; cursor: pointer; font-weight: 600;" onclick="document.getElementById('account_modal').close()">
            Batal
        </button>
        <button class="modal-btn btn-keluar-modal" style="flex: 1; padding: 10px; border-radius: 6px; border: none; background: #ef4444; color: white; cursor: pointer; font-weight: 600;" onclick="document.getElementById('logout-form-sidebar').submit();">
            Ya, Keluar
        </button>
    </div>
</dialog>

<script>
function toggleRole() {
    const menu = document.getElementById('roleMenu');
    const arrow = document.getElementById('roleArrow');
    if (menu.style.display === 'none') {
        menu.style.display = 'block';
        arrow.style.transform = 'rotate(-90deg)';
    } else {
        menu.style.display = 'none';
        arrow.style.transform = '';
    }
}
</script>