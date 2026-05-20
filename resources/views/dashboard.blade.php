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
        }

        .chart-card{
            border-radius:20px;
        }

        .dark-mode {
    background-color: #121212 !important;
    color: white !important;
}

.dark-mode .card,
.dark-mode .bg-white,
.dark-mode .alert,
.dark-mode .main-content {
    background-color: #1e1e1e !important;
    color: white !important;
}

.dark-mode .text-muted {
    color: #cfcfcf !important;
}

.dark-mode h1,
.dark-mode h2,
.dark-mode h3,
.dark-mode h4,
.dark-mode h5,
.dark-mode h6,
.dark-mode p,
.dark-mode span {
    color: white !important;
}

.dark-mode canvas {
    background-color: #1e1e1e;
    border-radius: 10px;
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
                    Pantau dan kelola aspirasi kelurahan dalam satu pintu.
                </p>
            </div>
           <div class="text-end d-flex align-items-center gap-2">

    <button onclick="toggleDarkMode()" class="btn btn-dark btn-sm">
        <i class="fas fa-moon"></i>
    </button>

    <span class="badge bg-soft-primary text-primary px-3 py-2" style="background: #e0e7ff;">
        <i class="fas fa-user-shield me-1"></i> {{ strtoupper(Auth::user()->role) }}
    </span>
</div>
        </div>

        <!-- CARD STATISTIK -->
        <div class="row g-4 mb-4">

            <!-- TOTAL -->
            <div class="col-md-3">
                <div class="card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-envelope-open-text fa-lg"></i>
                        </div>

                        <div>
                            <h6 class="text-muted mb-0">
                                Total Laporan
                            </h6>
                            <h4 class="fw-bold mb-0">
                                {{ $total }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PENDING -->
            <div class="col-md-3">
                <div class="card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-white rounded-circle p-3 me-3">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">
                                Pending
                            </h6>
                            <h4 class="fw-bold mb-0 text-warning">
                                {{ $pending }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PROSES -->
            <div class="col-md-3">
                <div class="card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info text-white rounded-circle p-3 me-3">
                            <i class="fas fa-spinner fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">
                                Proses
                            </h6>
                            <h4 class="fw-bold mb-0 text-info">
                                {{ $proses }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SELESAI -->
            <div class="col-md-3">
                <div class="card stat-card shadow-sm p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded-circle p-3 me-3">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">
                                Selesai
                            </h6>
                            <h4 class="fw-bold mb-0 text-success">
                                {{ $selesai }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- INFORMASI -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-bullhorn text-primary me-2"></i>
                    Informasi Terbaru
                </h5>
                <div class="alert alert-light border-start border-primary border-4">
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
                <canvas id="pengaduanChart" height="50"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT CHART -->
<script>
    const dates = [];

for(let i = 6; i >= 0; i--) {
    let d = new Date();
    d.setDate(d.getDate() - i);
    let day = d.getDate();
    let month = d.toLocaleString('id-ID', { month: 'short' });
    dates.push(day + ' ' + month);
}

const ctx = document.getElementById('pengaduanChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: dates,

        datasets: [

        // PENDING
        {
            label: 'Pending',
            data: [5, 4, 4, 3, 2, 2, 1],
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
            data: [1,2,3,4,5,4,3],
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
            data: [0, 1, 1, 2, 2, 3, 5],
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

<script>
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');

    if(document.body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'enabled');
    } else {
        localStorage.setItem('darkMode', 'disabled');
    }
}

if(localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
}
</script>

</body>
</html>