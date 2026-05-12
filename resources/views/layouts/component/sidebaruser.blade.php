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
            <small style="color: #a2a2c2;">{{ Auth::user()->role }}</small>
        </div>
    </div>

    <!-- Menu -->
    <nav class="nav flex-column mt-3 flex-grow-1">
        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" 
           href="/dashboard"
           style="color: #a2a2c2; padding: 12px 20px; transition: 0.3s; {{ request()->is('dashboard') ? 'color:#fff; background:rgba(255,255,255,0.1); border-left:4px solid #818cf8;' : '' }}">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->is('pengaduan') ? 'active' : '' }}" 
           href="/pengaduan"
           style="color: #a2a2c2; padding: 12px 20px; transition: 0.3s; {{ request()->is('pengaduan') ? 'color:#fff; background:rgba(255,255,255,0.1); border-left:4px solid #818cf8;' : '' }}">
            <i class="fas fa-bullhorn me-2"></i> Riwayat Pengaduan
        </a>
        <a class="nav-link {{ request()->is('pengaduan') ? 'active' : '' }}" 
           href="/pengaduan/create"
           style="color: #a2a2c2; padding: 12px 20px; transition: 0.3s; {{ request()->is('pengaduan') ? 'color:#fff; background:rgba(255,255,255,0.1); border-left:4px solid #818cf8;' : '' }}">
            <i class="fas fa-bullhorn me-2"></i> Buat Pengaduan
        </a>
        <a class="nav-link {{ request()->is('pengaduan/saya') ? 'active' : '' }}" 
           href="/pengaduan/saya"
           style="color: #a2a2c2; padding: 12px 20px; transition: 0.3s; {{ request()->is('pengaduan/saya') ? 'color:#fff; background:rgba(255,255,255,0.1); border-left:4px solid #818cf8;' : '' }}">
            <i class="fas fa-user me-2"></i> Saya
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