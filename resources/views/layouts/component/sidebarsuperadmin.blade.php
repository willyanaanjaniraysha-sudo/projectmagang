{{-- ============================================================
     Sidebar + Logout Modal — E-Aspirasi
     ============================================================ --}}

<style>
    /* ── Sidebar ─────────────────────────────────────────── */
    .sidebar {
        min-height: 100vh;
        background: #2F5D50;
        color: #fff;
        width: 260px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 999;
        display: flex;
        flex-direction: column;
    }

    .sidebar-brand {
        padding: 16px;
        text-align: center;
        background: #2F5D50;
    }

    .sidebar-user {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        text-decoration: none;
    }

    .sidebar-user img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .sidebar-user .user-name {
        font-size: 13px;
        font-weight: 700;
        color: #fff;
    }

    .sidebar-user .user-role {
        font-size: 12px;
        color: #a2a2c2;
    }

    /* ── Nav Links ───────────────────────────────────────── */
    .sidebar nav {
        flex-grow: 1;
        margin-top: 12px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        margin: 3px 12px;
        border-radius: 8px;
        border-left: 4px solid transparent;
        color: #a2a2c2;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.2s, color 0.2s;
    }

    .nav-item:hover {
        background: rgba(255, 255, 255, 0.06);
        color: #fff;
    }

    .nav-item.active {
        background: rgba(255, 255, 255, 0.1);
        border-left-color: #09c190;
        color: #fff;
    }

    .nav-item i {
        width: 18px;
        margin-right: 10px;
        text-align: center;
    }

    /* ── Dropdown toggle (Data Master) ──────────────────── */
    .nav-toggle {
        all: unset;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: calc(100% - 24px);
        padding: 12px 20px;
        margin: 3px 12px;
        border-radius: 8px;
        border-left: 4px solid transparent;
        color: #a2a2c2;
        cursor: pointer;
        font-size: 14px;
        box-sizing: border-box;
        transition: background 0.2s, color 0.2s;
    }

    .nav-toggle:hover {
        background: rgba(255, 255, 255, 0.06);
        color: #fff;
    }

    .nav-toggle.active {
        background: rgba(255, 255, 255, 0.1);
        border-left-color: #09c190;
        color: #fff;
    }

    .nav-toggle .arrow {
        transition: transform 0.25s;
        font-size: 12px;
    }

    .nav-toggle.open .arrow {
        transform: rotate(-90deg);
    }

    /* Submenu items sit slightly indented */
    #roleMenu .nav-item {
        padding-left: 44px;
    }

    /* ── Logout button ───────────────────────────────────── */
    .sidebar-footer {
        margin-top: auto;
        padding: 16px 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .btn-logout {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 12px 16px;
        background: #3A6B5A;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.3px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.25s, transform 0.25s, box-shadow 0.25s;
    }

    .btn-logout:hover {
        background: #4D8771;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
    }

    .btn-logout svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    /* ── Main content offset ─────────────────────────────── */
    .main-content {
        flex: 1;
        padding: 30px;
        min-width: 0;
        margin-left: 260px;
    }

    /* ── Logout Modal ────────────────────────────────────── */
    .logout-modal {
        width: 380px;
        max-width: 90%;
        border: none;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        background: #fff;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.18);
        animation: modal-popup 0.25s ease;
    }

    .logout-modal::backdrop {
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(3px);
    }

    @keyframes modal-popup {
        from {
            opacity: 0;
            transform: translateY(15px) scale(0.96);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }

    .modal-title {
        margin: 0 0 10px;
        font-size: 20px;
        font-weight: 700;
        color: #2F5D50;
    }

    .modal-desc {
        margin: 0 0 24px;
        font-size: 14px;
        line-height: 1.6;
        color: #64748B;
    }

    .modal-actions {
        display: flex;
        gap: 12px;
    }

    .modal-btn {
        flex: 1;
        padding: 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
    }

    .btn-cancel {
        background: #F8FBFA;
        color: #2F5D50;
        border: 1px solid #D8E3DE;
    }

    .btn-cancel:hover {
        background: #EAF3EF;
        border-color: #2F5D50;
    }

    .btn-confirm {
        background: #2F5D50;
        color: #fff;
        border: none;
    }

    .btn-confirm:hover {
        background: #3A6B5A;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(47, 93, 80, 0.25);
    }
</style>


{{-- ── Sidebar ─────────────────────────────────────────────── --}}
<aside class="sidebar">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <h5 class="mb-0 fw-bold text-white">
            <i class="fas fa-school me-2"></i>E-Aspirasi
        </h5>
    </div>

    {{-- User Panel --}}
    <a href="{{ route('profil') }}" class="sidebar-user">
        @if(Auth::user()->photo)
            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto Profil">
        @else
            <img src="{{ asset('templates/dist/img/sunghoongwehj.jpg') }}" alt="Foto Profil">
        @endif
        <div>
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-role">Super Admin</div>
        </div>
    </a>

    {{-- Navigation --}}
    <nav>
        <a href="/dashboard"
           class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>

        <a href="/aspirasi"
           class="nav-item {{ request()->is('aspirasi*') ? 'active' : '' }}">
            <i class="fas fa-tasks"></i> Kelola Pengaduan
        </a>

        {{-- Data Master Dropdown --}}
        <button type="button"
                class="nav-toggle {{ request()->is('user*') || request()->is('admin*') || request()->is('pengaturan*') ? 'active open' : '' }}"
                onclick="toggleRole(this)">
            <span><i class="fas fa-user-shield" style="margin-right:10px;"></i>Data Master</span>
            <i class="fas fa-angle-left arrow"></i>
        </button>

        <div id="roleMenu"
             style="{{ request()->is('user*') || request()->is('pengaturan*') ? '' : 'display:none;' }}">
            <a href="/user"
               class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Kelola User
            </a>
            <a href="/pengaturan"
               class="nav-item {{ request()->is('pengaturan*') ? 'active' : '' }}">
                <i class="fas fa-cogs"></i> Pengaturan Sistem
            </a>
        </div>

        <a href="/laporan"
           class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> Laporan
        </a>

        <a href="{{ route('admin.activity-logs.index') }}"
           class="nav-item {{ request()->is('admin/activity-logs*') ? 'active' : '' }}">
            <i class="fas fa-history"></i> Log Aktivitas
        </a>
    </nav>

    {{-- Logout --}}
    <div class="sidebar-footer">
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>

        <button type="button"
                class="btn-logout"
                onclick="document.getElementById('logout-modal').showModal()">
            <span>Logout</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor"
                 stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                <path d="m16 17 5-5-5-5"></path>
                <path d="M21 12H9"></path>
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            </svg>
        </button>
    </div>

</aside>


{{-- ── Logout Confirmation Modal ───────────────────────────── --}}
<dialog id="logout-modal" class="logout-modal">

    <div class="modal-icon">📄</div>

    <h3 class="modal-title">Konfirmasi Keluar</h3>

    <p class="modal-desc">
        Apakah Anda yakin ingin keluar dari sistem <strong>E-Aspirasi</strong>?
        Sesi Anda saat ini akan diakhiri.
    </p>

    <div class="modal-actions">
        <button type="button"
                class="modal-btn btn-cancel"
                onclick="document.getElementById('logout-modal').close()">
            Batal
        </button>
        <button type="button"
                class="modal-btn btn-confirm"
                onclick="document.getElementById('logout-form-sidebar').submit()">
            Ya, Keluar
        </button>
    </div>

</dialog>


{{-- ── Scripts ─────────────────────────────────────────────── --}}
<script>
    function toggleRole(btn) {
        const menu  = document.getElementById('roleMenu');
        const open  = menu.style.display !== 'none';

        menu.style.display = open ? 'none' : 'block';
        btn.classList.toggle('open', !open);
    }
</script>