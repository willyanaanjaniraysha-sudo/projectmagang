<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SIPERSA</title>

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

/* ===========================
   DASHBOARD SIPERSA
=========================== */

.stat-card{
    border: none;
    border-radius: 18px;
    transition: all .3s ease;
    background: #fff;
}

.stat-card:hover{
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(47,93,80,.12);
}

/* ICON */

.icon-total,
.icon-masuk,
.icon-proses,
.icon-disposisi{
    width:60px;
    height:60px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:22px;
}

.icon-total{
    background:#2F5D50;
}

.icon-masuk{
    background:#3B82F6;
}

.icon-proses{
    background:#F59E0B;
}

.icon-disposisi{
    background:#8B5CF6;
}

/* TEXT */

.text-total{
    color:#2F5D50;
}

.text-masuk{
    color:#3B82F6;
}

.text-proses{
    color:#F59E0B;
}

.text-disposisi{
    color:#8B5CF6;
}

.stat-card h6{
    color:#6b7280;
    font-size:14px;
}

.stat-card h4{
    font-weight:700;
    font-size:30px;
}
       
    </style>
</head>

<body>

<div class="d-flex">

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
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-0">
                     <span id="greeting"></span>, {{ Auth::user()->name }}!
                </h3>
                <p class="text-muted">
                    Selamat datang di SIPERSA,
                    Sistem Informasi Persuratan Sekolah.
                </p>
            </div>
           <div class="text-end d-flex align-items-center gap-2">
</div>
<div class="text-end d-flex align-items-center gap-2">

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
        <div class="row g-4 mb-4">

            <!-- TOTAL -->
        <!-- STATS BOXES -->
<div class="row g-4 mb-2">

    <!-- Total Surat -->
    <div class="col-md-3">
        <div class="card stat-card p-3 shadow-sm">
            <div class="d-flex align-items-center">

                <div class="icon-total me-3">
                    <i class="fas fa-envelope-open-text"></i>
                </div>

                <div>
                    <h6 class="mb-1">Total Surat</h6>

                    <h4 class="mb-0 text-total">
                        {{ $total }}
                    </h4>
                </div>

            </div>
        </div>
    </div>

    <!-- Surat Masuk -->
    <div class="col-md-3">
        <div class="card stat-card p-3 shadow-sm">
            <div class="d-flex align-items-center">

                <div class="icon-masuk me-3">
                    <i class="fas fa-inbox"></i>
                </div>

                <div>
                    <h6 class="mb-1">Surat Masuk</h6>

                    <h4 class="mb-0 text-masuk">
                        {{ $pending }}
                    </h4>
                </div>

            </div>
        </div>
    </div>

    <!-- Surat Diproses -->
    <div class="col-md-3">
        <div class="card stat-card p-3 shadow-sm">
            <div class="d-flex align-items-center">

                <div class="icon-proses me-3">
                    <i class="fas fa-file-signature"></i>
                </div>

                <div>
                    <h6 class="mb-1">Diproses</h6>

                    <h4 class="mb-0 text-proses">
                        {{ $proses }}
                    </h4>
                </div>

            </div>
        </div>
    </div>

    <!-- Disposisi -->
    <div class="col-md-3">
        <div class="card stat-card p-3 shadow-sm">
            <div class="d-flex align-items-center">

                <div class="icon-disposisi me-3">
                    <i class="fas fa-share-alt"></i>
                </div>

                <div>
                    <h6 class="mb-1">Disposisi</h6>

                    <h4 class="mb-0 text-disposisi">
                        {{ $selesai }}
                    </h4>
                </div>

            </div>
        </div>
    </div>

</div>

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
                    Statistik Persuratan
                </h4>
                <p class="text-muted mb-4">
                   Statistik Surat Mingguan
                </p>
                <canvas id="pengaduanChart" height="50"></canvas>
            </div>
        </div>
    </div>
</div>

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
            label: 'Surat Masuk',
            data: {!! json_encode($chartPending) !!},
            borderColor:  '#2F5D50',
            backgroundColor: 'rgba(15,118,110,0.08)',
            tension: 0.4,
            fill: false,
            borderWidth: 3,
            pointBackgroundColor: '#2F5D50',
            pointRadius: 5
        },

        // PROSES
        {
            label: 'Surat Keluar',
            data: {!! json_encode($chartProses) !!},
            borderColor: '#3B82F6',
            backgroundColor: 'rgba(37,99,235,0.08)',
            tension: 0.4,
            fill: false,
            borderWidth: 3,
            pointBackgroundColor: '#3B82F6',
            pointRadius: 5
        },

        // disposisi
        {
            label: 'Disposisi',
            data: {!! json_encode($chartDisposisi) !!},
            borderColor: '#F59E0B',
            backgroundColor: 'rgba(217,119,6,0.08)',
            tension: 0.4,
            fill: false,
            borderWidth: 3,
            pointBackgroundColor: '#F59E0B',
            pointRadius: 5
        },

        // SELESAI
        {
            label: 'Selesai',
            data: {!! json_encode($chartSelesai) !!},
            borderColor:'#8B5CF6',
            backgroundColor: 'rgba(22,163,74,0.2)',
            tension: 0.4,
            fill: false,
            borderWidth: 3,
            pointBackgroundColor: '#8B5CF6',
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