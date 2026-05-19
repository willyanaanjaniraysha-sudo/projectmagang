<div class="sidebar d-flex flex-column" style="min-height: 100vh; background: #1a1a2e; color: #fff; width: 260px;">
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
    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
        <i class="fas fa-home me-2"></i> Dashboard
    </a>
    <a class="nav-link {{ request()->is('aspirasi*') ? 'active' : '' }}" href="/aspirasi">
        <i class="fas fa-tasks me-2"></i> Kelola Pengaduan
    </a>
    <button onclick="toggleRole()" 
    style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;"
    class="nav-link d-flex justify-content-between align-items-center {{ request()->is('user*') || request()->is('admin*') ? 'active' : '' }}">
    <span><i class="fas fa-user-shield me-2"></i> Role</span>
    <i class="fas fa-angle-left" id="roleArrow" style="{{ request()->is('user*') || request()->is('admin*') ? 'transform: rotate(-90deg);' : '' }}"></i>
</button>
<div id="roleMenu" style="{{ request()->is('user*') || request()->is('admin*') ? '' : 'display:none;' }}">
    <a class="nav-link ps-4 {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.index') }}">
        <i class="fas fa-user-tie me-2"></i> Kelola Admin
    </a>
    <a class="nav-link ps-4 {{ request()->is('user*') ? 'active' : '' }}" href="/user">
        <i class="fas fa-users me-2"></i> Kelola User
    </a>
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

    <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" href="/laporan">
        <i class="fas fa-file-alt me-2"></i> Laporan
    </a>
    <a class="nav-link {{ request()->is('pengaturan*') ? 'active' : '' }}" href="/pengaturan">
        <i class="fas fa-cogs me-2"></i> Pengaturan Sistem
    </a>
    <a class="nav-link {{ request()->is('profil*') ? 'active' : '' }}" href="/profil">
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