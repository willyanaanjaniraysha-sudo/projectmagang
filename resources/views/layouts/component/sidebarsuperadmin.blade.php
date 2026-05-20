<div class="sidebar d-flex flex-column" style="min-height: 100vh; background: #1a1a2e; color: #fff; width: 260px; position: fixed; top: 0; left: 0; z-index: 999;">
    <!-- Brand -->
    <div class="p-4 text-center" style="background: rgba(0,0,0,0.1);">
        <h5 class="mb-0 fw-bold text-white">
            <i class="fas fa-school me-2"></i>E-Aspirasi
        </h5>
    </div>

    <!-- User Panel -->
    <div class="d-flex align-items-center px-3 py-3" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
        <img src="{{ asset('templates/dist/img/sunghoongwehj.jpg') }}" 
             class="rounded-circle me-2" width="40" height="40" alt="User">
        <div>
            <small class="text-white fw-bold">{{ Auth::user()->name }}</small><br>
            <small style="color: #a2a2c2;">Super Admin</small>
        </div>
    </div>

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
            <span><i class="fas fa-user-shield me-2"></i> Role</span>
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

        <a class="nav-link {{ request()->is('profil*') ? 'active' : '' }}" href="/profil"
           style="color: {{ request()->is('profil*') ? '#fff' : '#a2a2c2' }} !important; padding: 12px 20px; margin: 3px 12px; border-radius: 8px; background: {{ request()->is('profil*') ? 'rgba(255,255,255,0.1)' : 'transparent' }}; border-left: 4px solid {{ request()->is('profil*') ? '#818cf8' : 'transparent' }};">
            <i class="fas fa-user-circle me-2"></i> Profil
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                <i class="fas fa-sign-out-alt me-1"></i> Keluar
            </button>
        </form>
    </div>
</div>

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