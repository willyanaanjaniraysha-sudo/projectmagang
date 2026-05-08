<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <span class="brand-text font-weight-light">Project Magang</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('templates/dist/img/sunghoongwehj.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Pengaduan -->
                <li class="nav-item">
                    <a href="/pengaduan" class="nav-link {{ request()->is('pengaduan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>Pengaduan</p>
                    </a>
                </li>

                <!-- Saya -->
                <li class="nav-item">
                    <a href="/pengaduan/saya" class="nav-link {{ request()->is('pengaduan/saya*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Saya</p>
                    </a>
                </li>

                <!-- Keluar -->
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-left w-100">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Keluar</p>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>