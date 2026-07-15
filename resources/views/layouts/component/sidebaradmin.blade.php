<style>
@media (max-width: 991.98px) {
    .sidebar-fixed {
        /* Mengubah posisi jadi kotak melayang di tengah mirip modal acuan */
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) scale(0.9) !important;
        
        /* Menimpa inline style width: 260px menjadi responsif */
        width: 90% !important; 
        max-width: 340px !important;
        height: auto !important;
        min-height: auto !important; /* Mematikan min-height: 100vh bawaan */
        max-height: 85vh !important;
        
        border-radius: 20px !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.3) !important;
        z-index: 1060 !important;
        
        /* Menyembunyikan menu saat pertama kali dimuat */
        opacity: 0 !important;
        pointer-events: none !important;
        transition: all 0.3s ease-in-out !important;
    }

    /* Ketika class .show ditambahkan oleh JavaScript */
    .sidebar-fixed.show {
        opacity: 1 !important;
        pointer-events: auto !important;
        transform: translate(-50%, -50%) scale(1) !important;
    }

    /* Konten utama di belakang meluas penuh */
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 15px !important;
    }

    /* Efek background blur gelap di belakang menu melayang */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(47, 93, 80);
        backdrop-filter: blur(4px);
        z-index: 1050;
    }
    .sidebar-overlay.show {
        display: block;
    }
}

/* 2. SAAT TAMPILAN DI LAPTOP / DESKTOP (Minimal 992px) */
@media (min-width: 992px) {
    .sidebar-fixed {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 260px !important;
        height: 100vh !important;
        transform: none !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }
    .main-content {
        margin-left: 260px !important;
        width: calc(100% - 260px) !important;
    }
}
    .logout-modal {
    width: 380px;
        max-width: 90%;
        border: none;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        background: #fff;
        box-shadow: 0 20px 40px rgba(47, 93, 80);
        animation: modal-popup 0.25s ease;
    }
    .logout-modal::backdrop {
    background: rgba(47, 93, 80) !important;
    backdrop-filter: blur(2px) !important;
    position: fixed !important; 
    inset: 0 !important;    
    }
</style>

<div id="sidebarMenu" class="sidebar sidebar-fixed d-none d-lg-flex flex-column" style="background: #f5fffb; color: #fff; width: 260px;">
    <!-- Tombol Silang (X) Penutup di HP -->
    <div class="d-flex justify-content-end d-lg-none p-2 w-100">
        <button type="button" class="btn-close btn-close-white" id="sidebarCloseBtn" aria-label="Close" style="font-size: 1.1rem;"></button>
    </div>
    
    <!-- Brand (Teruskan kode bawaan Anda ke bawah...) -->
    <div class="p-4 text-center" style="background: rgba(255, 255, 255, 0.1);">
        <h5 class="mb-0 fw-bold text-black">
            <i class="fas fa-school me-2"></i>E-Aspirasi
        </h5>
    </div>
    

    <!-- User Panel -->
    <a href="{{ route('profil') }}" class="text-decoration-none">
    <div class="d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid rgba(159, 255, 212, 0.1); cursor: pointer;">
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
    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }} py-2" href="/dashboard">
        <i class="fas fa-fw fa-tachometer-alt me-2"></i> Dashboard
    </a>

    <button onclick="toggleRole()" class="nav-link d-flex justify-content-between align-items-center py-2" 
    style="color: {{ (request()->is('aspirasi*') || request()->is('laporan*')) ? '#fff' : '#a2a2c2' }} !important; padding: 12px 20px; border-radius: 8px; background: {{ (request()->is('aspirasi*') || request()->is('laporan*')) ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ (request()->is('aspirasi*') || request()->is('laporan*')) ? '#818cf8' : 'transparent' }};">
    <span><i class="fas fa-fw fa-envelope-open-text me-2"></i> Laporan Pengaduan</span>
    <i id="roleArrow" class="fas fa-chevron-down" style="font-size: 12px; transform: {{ (request()->is('aspirasi*') || request()->is('laporan*')) ? 'rotate(-90deg)' : '' }};"></i>
</button>
        <div id="roleMenu" style="{{ (request()->is('aspirasi*') || request()->is('laporan*')) ? '' : 'display:none;' }}">
    <a class="nav-link {{ request()->is('aspirasi/masuk*') ? 'active' : '' }} py-2" href="/aspirasi/masuk" style="padding: 0% 20px 0% 44px; color: {{ request()->is('aspirasi/masuk*') ? '#fff' : '#a2a2c2' }} !important; background: {{ request()->is('aspirasi/masuk*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->is('aspirasi/masuk*') ? '#818cf8' : 'transparent' }};">
        <i class="fas fa-fw fa-inbox me-2"></i> Laporan Masuk
    </a>
    <a class="nav-link {{ request()->is('aspirasi/proses*') ? 'active' : '' }} py-2" href="/aspirasi/proses" style="padding: 0% 20px 0% 44px; color: {{ request()->is('aspirasi/proses*') ? '#fff' : '#a2a2c2' }} !important; background: {{ request()->is('aspirasi/proses*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->is('aspirasi/proses*') ? '#818cf8' : 'transparent' }};">
        <i class="fas fa-fw fa-spinner me-2"></i> Dalam Proses
    </a>
    <a class="nav-link {{ request()->is('aspirasi/selesai*') ? 'active' : '' }} py-2" href="/aspirasi/selesai" style="padding: 0% 20px 0% 44px; color: {{ request()->is('aspirasi/selesai*') ? '#fff' : '#a2a2c2' }} !important; background: {{ request()->is('aspirasi/selesai*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->is('aspirasi/selesai*') ? '#818cf8' : 'transparent' }};">
        <i class="fas fa-fw fa-check-double me-2"></i> Riwayat Selesai
    </a>
    <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }} py-2" href="/laporan" style="padding: 12px 20px 12px 44px; color: {{ request()->is('laporan*') ? '#fff' : '#a2a2c2' }} !important; background: {{ request()->is('laporan*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->is('laporan*') ? '#818cf8' : 'transparent' }};">
        <i class="fas fa-fw fa-file-pdf me-2"></i> Cetak Laporan
    </a>
    </div>

    <!-- DATA MASTER -->
    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'admin')
            <a class="nav-link {{ request()->is('user*') ? 'active' : '' }} py-2" href="/user">
                <i class="fas fa-fw fa-users-cog me-2"></i> Kelola User
            </a>
            
            <!-- TAMBAHKAN MENU LOG AKTIVITAS DI SINI -->
            <a class="nav-link {{ request()->is('admin/activity-logs*') ? 'active' : '' }} py-2" href="{{ route('admin.activity-logs.index') }}">
                <i class="fas fa-fw fa-history me-2"></i> Log Aktivitas
            </a>
        @endif
</nav>



    <!-- Logout -->
    <div style="margin-top: auto; padding: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
        
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <a class="btn btn-sm btn-block btn-soft btn-error" 
           onclick="document.getElementById('account_modal').showModal(); event.preventDefault();" 
           style="cursor: pointer; display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 10px 14px; background: rgba(189, 223, 205, 0.1); color: #6ce5a3; border: 1px solid rgba(6, 198, 131, 0.2); border-radius: 8px; text-decoration: none; transition: all 0.2s ease-in-out;"
           onmouseover="this.style.background='#18db83'; this.style.color='#ffffff'; this.style.borderColor='#18db83';" 
           onmouseout="this.style.background='rgba(94, 190, 140, 0.1)'; this.style.color='#71f8b7'; this.style.borderColor='rgba(180, 255, 216, 0.1)';">
            
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
    <h3 style="font-size: 18px; font-weight: 700; color: #2F5D50; margin-bottom: 8px;">Konfirmasi Keluar</h3>
    <p style="font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.5;">
        Apakah Anda yakin ingin keluar dari sistem E-Aspirasi? Sesi Anda saat ini akan diakhiri.
    </p>
    <div style="display: flex; gap: 12px; justify-content: center;">
        <button class="modal-btn btn-batal" style="flex: 1; padding: 10px; border-radius: 6px; border: 1px solid #D8E3DE; background: white; cursor: pointer; font-weight: 600; color: #2F5D50" onclick="document.getElementById('account_modal').close()">
            Batal
        </button>
        <button class="modal-btn btn-keluar-modal" style="flex: 1; padding: 10px; border-radius: 6px; border: none; background: #2F5D50; color: white; cursor: pointer; font-weight: 600;" onclick="document.getElementById('logout-form-sidebar').submit();">
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

document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById('sidebarToggle');   // Tombol buka di header
        const closeBtn = document.getElementById('sidebarCloseBtn'); // Tombol X di dalam sidebar
        const overlay = document.getElementById('sidebarOverlay');
        const sidebar = document.querySelector('.sidebar-fixed');    // Membidik class sidebar-fixed

        if (sidebar) {
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.add('show');
                    if (overlay) overlay.classList.add('show');
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    if (overlay) overlay.classList.remove('show');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
        }
    });
</script>