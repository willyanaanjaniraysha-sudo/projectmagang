<div class="sidebar d-flex flex-column" style="min-height: 100vh; background: #1a1a2e; color: #fff; width: 260px; position: fixed; top: 0; left: 0; z-index: 999;">
    <!-- Brand -->
    <div class="p-4 text-center" style="background: rgba(0,0,0,0.1);">
        <h5 class="mb-0 fw-bold text-white">
            <i class="fas fa-school me-2"></i>E-Aspirasi
        </h5>
    </div>

    <!-- User Panel -->
    <a href="{{ route('profil') }}" class="text-decoration-none">
    <div class="d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid rgba(255,255,255,0.1); cursor: pointer;">
        
        <!-- BAGIAN YANG DIPERBAIKI: Sinkronisasi Foto Profil -->
        @if(Auth::user()->photo)
            <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                 class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;" alt="User">
        @else
            <img src="{{ asset('templates/dist/img/sunghoongwehj.jpg') }}" 
                 class="rounded-circle me-2" width="40" height="40" alt="User">
        @endif

        <div>
            <small class="text-white fw-bold">{{ Auth::user()->name }}</small><br>
            <small style="color: #a2a2c2;">Super Admin</small>
        </div>
    </div>
    </a>

    <!-- Menu -->
    <nav class="nav flex-column mt-3 flex-grow-1">
        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard"
           style="color: {{ request()->is('dashboard') ? '#fff' : '#a2a2c2' }} !important; padding: 12px 20px; margin: 3px 12px; border-radius: 8px; background: {{ request()->is('dashboard') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->is('dashboard') ? '#818cf8' : 'transparent' }};">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>

        <a class="nav-link {{ request()->is('aspirasi*') ? 'active' : '' }}" href="/aspirasi"
           style="color: {{ request()->is('aspirasi*') ? '#fff' : '#a2a2c2' }} !important; padding: 12px 20px; margin: 3px 12px; border-radius: 8px; background: {{ request()->is('aspirasi*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->is('aspirasi*') ? '#818cf8' : 'transparent' }};">
            <i class="fas fa-tasks me-2"></i> Kelola Pengaduan
        </a>

        <button onclick="toggleRole()"
            style="background: {{ request()->is('user*') || request()->is('admin*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border: none; border-left: 4px solid {{ request()->is('user*') || request()->is('admin*') ? '#818cf8' : 'transparent' }}; width: calc(100% - 24px); text-align: left; cursor: pointer; color: {{ request()->is('user*') || request()->is('admin*') ? '#fff' : '#a2a2c2' }} !important; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; margin: 3px 12px; border-radius: 8px;">
            <span><i class="fas fa-user-shield me-2"></i> Data Master</span>
            <i class="fas fa-angle-left" id="roleArrow" style="{{ request()->is('user*') || request()->is('admin*') ? 'transform: rotate(-90deg);' : '' }}"></i>
        </button>

        <div id="roleMenu" style="{{ request()->is('user*') || request()->is('admin*') ? '' : 'display:none;' }}">
            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.index') }}"
               style="color: {{ request()->routeIs('admin.*') ? '#fff' : '#a2a2c2' }} !important; padding: 10px 20px 10px 44px; margin: 2px 12px; border-radius: 8px; background: {{ request()->routeIs('admin.*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->routeIs('admin.*') ? '#818cf8' : 'transparent' }};">
                <i class="fas fa-user-tie me-2"></i> Kelola Admin
            </a>
            <a class="nav-link {{ request()->is('user*') ? 'active' : '' }}" href="/user"
               style="color: {{ request()->is('user*') ? '#fff' : '#a2a2c2' }} !important; padding: 10px 20px 10px 44px; margin: 2px 12px; border-radius: 8px; background: {{ request()->is('user*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->is('user*') ? '#818cf8' : 'transparent' }};">
                <i class="fas fa-users me-2"></i> Kelola User
            </a>
        </div>

        <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" href="/laporan"
           style="color: {{ request()->is('laporan*') ? '#fff' : '#a2a2c2' }} !important; padding: 12px 20px; margin: 3px 12px; border-radius: 8px; background: {{ request()->is('laporan*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->is('laporan*') ? '#818cf8' : 'transparent' }};">
            <i class="fas fa-file-alt me-2"></i> Laporan
        </a>

        <a class="nav-link {{ request()->is('pengaturan*') ? 'active' : '' }}" href="/pengaturan"
           style="color: {{ request()->is('pengaturan*') ? '#fff' : '#a2a2c2' }} !important; padding: 12px 20px; margin: 3px 12px; border-radius: 8px; background: {{ request()->is('pengaturan*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->is('pengaturan*') ? '#818cf8' : 'transparent' }};">
            <i class="fas fa-cogs me-2"></i> Pengaturan Sistem
        </a>
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
    <div style="font-size: 40px; margin-bottom: 12px;">🚪</div>
    <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Konfirmasi Keluar</h3>
    <p style="font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.5;">
        Apakah Anda yakin ingin keluar dari sistem E-Aspirasi? Sesi Anda saat ini akan diakhiri.
    </p>
    <div style="display: flex; gap: 12px; justify-content: center;">
        <button class="modal-btn btn-batal" style="flex: 1;" onclick="document.getElementById('account_modal').close()">
            Batal
        </button>
        <button class="modal-btn btn-keluar-modal" style="flex: 1;" onclick="document.getElementById('logout-form-sidebar').submit();">
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
