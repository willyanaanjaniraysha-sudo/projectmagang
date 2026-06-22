<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sistem Aspirasi</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
    rel="stylesheet">

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body{
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
        }

        .nav-link{
            color:#a2a2c2;
            padding:12px 20px;
            transition:0.3s;
        }

        .nav-link:hover,
        .nav-link.active{
            color:#fff;
            background:rgba(255,255,255,0.1);
            border-left:4px solid #818cf8;
        }

        .stat-card{
            border:none;
            border-radius:15px;
            transition:0.3s;
        }

        .stat-card:hover{
            transform:translateY(-5px);
        }

        .main-content{
            flex:1;
            padding:30px;
            margin-left: 260px; 
            width: calc(100% - 260px);
            padding-top: 70px;
        }

        .chart-card{
            border-radius:20px;
        }

        .icon-circle{
            width:60px;
            height:60px;
            background:#09c190;
            color:#fff;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-shrink:0;
        }

        /* Card */
        .info-card{
            background:#FFFFFF;
            border-radius:18px;
            transition:.3s;
        }

        .info-card:hover{
            transform:translateY(-3px);
            box-shadow:0 12px 28px rgba(47,93,80,.12);
        }

/* Judul */ 
        .info-title{
            color:#09c190;
        }

/* Icon */
        .info-title i{
            color:#09c190;
        }

/* Alert */
        .info-alert{
            background:#F2F8F5;
            border-left:5px solid #09c190;
            padding:16px 18px;
            border-radius:10px;
            color:#374151;
            font-size:15px;
            line-height:1.7;
        }

/* Tulisan Pemberitahuan */
        .info-alert strong{
            color:#09c190;
        }

/* Badge Umum */
        .device-badge,
        .role-badge{
            padding:8px 16px;
            border-radius:30px;
            font-size:13px;
            font-weight:600;
            display:flex;
            align-items:center;
            gap:5px;
        }

/* Desktop */
        .desktop-badge{
            background:#E8F2EE;
            color:#2F5D50;
            border:1px solid #C7DDD4;
        }

/* Mobile */
        .mobile-badge{
            background:#FFF7E6;
            color:#B7791F;
            border:1px solid #F6D48B;
        }

    /* Role */
        .role-badge{
            background:#09c190;
            color:#fff;
        }

    /* Hover */
        .device-badge:hover,
        .role-badge:hover{
            transform:translateY(-2px);
            transition:.3s;
        }
    </style>
</head>

<body>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<div class="d-flex">
@include('layouts.component.sidebaradmin')
    <!-- SIDEBAR -->
    @if(Auth::user()->role == 'super admin')
        @include('layouts.component.sidebarsuperadmin')
    @elseif(Auth::user()->role == 'admin')
        @include('layouts.component.sidebaradmin')
    @else
        @include('layouts.component.sidebaruser')
    @endif

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- HEADER -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div class="d-flex align-items-center gap-3">
            <div>
                <h3 class="fw-bold mb-0">
                     <span id="greeting"></span>, {{ Auth::user()->name }}!
                </h3>
                <p class="text-muted">
                    Pantau dan kelola aspirasi kelurahan dalam satu pintu.
                </p>
            </div>
        </div>

        <div class="text-end d-flex flex-wrap align-items-center gap-2">
    @if(Agent::isMobile())
        <span class="device-badge mobile-badge">
            <i class="fas fa-mobile-alt me-1"></i> Mobile
        </span>
    @else
        <span class="device-badge desktop-badge">
            <i class="fas fa-desktop me-1"></i> Desktop
        </span>
    @endif

    <span class="role-badge">
        <i class="fas fa-user-shield me-1"></i>
        {{ strtoupper(Auth::user()->role) }}
    </span>
</div>
        </div>

                <!-- CARD STATISTIK -->
        <div class="row g-3 g-md-4 mb-4">

            <!-- TOTAL LAPORAN -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle me-3">
                            <i class="fas fa-envelope-open-text fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Total Laporan</h6>
                            <h4 class="fw-bold mb-0">{{ $total }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PENDING -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width:60px; height:60px; flex-shrink:0;">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Pending</h6>
                            <h4 class="fw-bold mb-0 text-warning">{{ $pending }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PROSES -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info text-white rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width:60px; height:60px; flex-shrink:0;">
                            <i class="fas fa-spinner fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Proses</h6>
                            <h4 class="fw-bold mb-0 text-info">{{ $proses }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SELESAI -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width:60px; height:60px; flex-shrink:0;">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Selesai</h6>
                            <h4 class="fw-bold mb-0 text-success">{{ $selesai }}</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- PENUTUP ROW STATISTIK -->

       <!-- INFORMASI -->
<div class="card info-card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">

        <h5 class="fw-bold mb-3 info-title">
            <i class="fas fa-bullhorn me-2"></i>
            Informasi Terbaru
        </h5>

        <div class="info-alert">
            <strong>Pemberitahuan:</strong>
            Pastikan setiap pengaduan disertai dengan bukti foto
            yang jelas untuk mempercepat proses tindak lanjut.
        </div>

    </div>
</div>

        <!-- CHART -->
        <div class="card border-0 shadow-sm chart-card">

            <div class="card-body p-4">
                <h4 class="fw-bold">
                    Aktivitas Pengaduan
                </h4>
                <p class="text-muted mb-4">
                    Statistik status pengaduan saat ini
                </p>
                <canvas id="pengaduanChart" height="120"></canvas>
            </div>
        </div>
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

<!-- SCRIPT CHART -->
<script>
const ctx = document.getElementById('pengaduanChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: {!! json_encode($days) !!},

        datasets: [

        // PENDING
        {
            label: 'Pending',
            data: {!! json_encode($chartPending) !!},
            borderColor: '#facc15',
            backgroundColor: 'rgba(250,204,21,0.2)',
            tension: 0.4,
            fill: true,
            borderWidth: 3,
            pointBackgroundColor: '#facc15',
            pointRadius: 5
        },

        // PROSES
        {
            label: 'Proses',
            data: {!! json_encode($chartProses) !!},
            borderColor: '#38bdf8',
            backgroundColor: 'rgba(56,189,248,0.2)',
            tension: 0.4,
            fill: true,
            borderWidth: 3,
            pointBackgroundColor: '#38bdf8',
            pointRadius: 5
        },

        // SELESAI
        {
            label: 'Selesai',
            data: {!! json_encode($chartSelesai) !!},
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34,197,94,0.2)',
            tension: 0.4,
            fill: true,
            borderWidth: 3,
            pointBackgroundColor: '#22c55e',
            pointRadius: 5
        }

        ]
    },

    options: {
        responsive: true,

        plugins: {
            legend: {
                position: 'top'
            }
        },

        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
<script>
// 1. Fungsi Dropdown Submenu Laporan Pengaduan
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

    // 2. Fungsi Logika Buka/Tutup Menu Jendela Melayang HP
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById('sidebarToggle');   
        const closeBtn = document.getElementById('sidebarCloseBtn'); 
        const overlay = document.getElementById('sidebarOverlay');   
        const sidebar = document.querySelector('.sidebar-fixed');    

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

const hour = new Date().getHours();

let greeting = '';

if(hour >= 5 && hour < 12){
    greeting = 'Selamat Pagi ☀️';
}
else if(hour >= 12 && hour < 15){
    greeting = 'Selamat Siang 🌤️';
}
else if(hour >= 15 && hour < 18){
    greeting = 'Selamat Sore 🌅';
}
else{
    greeting = 'Selamat Malam 🌙';
}

document.getElementById('greeting').innerHTML = greeting;
</script>



</body>
</html>