<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sistem Aspirasi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://jsdelivr.net" rel="stylesheet">
    <!-- Google Fonts & Font Awesome -->
    <link href="https://googleapis.com" rel="stylesheet">
    <link rel="stylesheet" href="https://cloudflare.com">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; }
        .sidebar { min-height: 100vh; background: #1a1a2e; color: #fff; width: 260px; transition: all 0.3s; }
        .sidebar-header { padding: 20px; text-align: center; background: rgba(0,0,0,0.1); }
        .nav-link { color: #a2a2c2; padding: 12px 20px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); border-left: 4px solid #818cf8; }
        .main-content { flex: 1; padding: 30px; }
        .stat-card { border: none; border-radius: 15px; transition: transform 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .top-nav { background: #fff; padding: 15px 30px; border-bottom: 1px solid #e3e6f0; }
        .logout-btn { border-radius: 10px; font-weight: 600; }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- SIDEBAR -->
    @include('layouts.component.sidebaruser')

    <!-- MAIN -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-muted">Pantau dan kelola aspirasi sekolah dalam satu pintu.</p>
            </div>
            <div class="text-end">
                <span class="badge bg-soft-primary text-primary px-3 py-2" style="background: #e0e7ff;">
                    <i class="fas fa-user-shield me-1"></i> {{ strtoupper(Auth::user()->role) }}
                </span>
            </div>
        </div>

        <!-- STATS BOXES -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-envelope-open-text fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Total Laporan</h6>
                            <h4 class="fw-bold mb-0">12</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center text-warning">
                        <div class="bg-warning text-white rounded-circle p-3 me-3">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Pending</h6>
                            <h4 class="fw-bold mb-0">5</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-3 text-success">
                    <div class="bg-success text-white rounded-circle p-3 me-3">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Selesai</h6>
                        <h4 class="fw-bold mb-0">7</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- INFO SECTION -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="fas fa-bullhorn me-2 text-primary"></i>Informasi Terbaru</h5>
                <div class="alert alert-light border-start border-primary border-4">
                    <strong>Pemberitahuan:</strong> Pastikan setiap pengaduan disertai dengan bukti foto yang jelas untuk mempercepat proses tindak lanjut.
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://jsdelivr.net"></script>
</body>
</html>
