@extends($layout)

@section('hide-header', 'yes')

@section('content')
<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* ===========================
       GENERIC CARD / INFO CARD
    =========================== */
    .info-card {
        background: #FFFFFF;
        border-radius: 18px;
        transition: .3s;
    }

    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(47, 93, 80, .12);
    }

    .info-title,
    .info-title i {
        color: #09c190;
    }

    .info-alert {
        background: #F2F8F5;
        border-left: 5px solid #09c190;
        padding: 16px 18px;
        border-radius: 10px;
        color: #374151;
        font-size: 15px;
        line-height: 1.7;
    }

    .info-alert strong {
        color: #09c190;
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        background: #09c190;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ===========================
       BADGES
    =========================== */
    .device-badge,
    .role-badge {
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .desktop-badge {
        background: #E8F2EE;
        color: #2F5D50;
        border: 1px solid #C7DDD4;
    }

    .mobile-badge {
        background: #FFF7E6;
        color: #B7791F;
        border: 1px solid #F6D48B;
    }

    .role-badge {
        background: #09c190;
        color: #fff;
    }

    .device-badge:hover,
    .role-badge:hover {
        transform: translateY(-2px);
        transition: .3s;
    }

    /* ===========================
       STAT CARDS
    =========================== */
    .stat-card {
        border: none;
        border-radius: 18px;
        background: #fff;
        transition: all .3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(47, 93, 80, .12);
    }

    .stat-card h6 {
        color: #6b7280;
        font-size: 14px;
    }

    .stat-card h4 {
        font-weight: 700;
        font-size: 30px;
    }

    /* Icons */
    .icon-total,
    .icon-masuk,
    .icon-proses,
    .icon-disposisi,
    .icon-selesai {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
    }

    .icon-total    { background: #2F5D50; }
    .icon-masuk    { background: #F59E0B; }
    .icon-proses   { background: #3B82F6; }
    .icon-disposisi{ background: #8B5CF6; }
    .icon-selesai  { background: #09c190; }

    /* Text colors */
    .text-total    { color: #2F5D50; }
    .text-masuk    { color: #F59E0B; }
    .text-proses   { color: #3B82F6; }
    .text-disposisi{ color: #8B5CF6; }
    .text-selesai  { color: #09c190; }

    /* ===========================
       CHART CARD
    =========================== */
    .chart-card {
        border-radius: 20px;
    }

    .chart-wrapper {
        position: relative;
        height: 380px; /* Kontrol tinggi chart di sini */
        width: 100%;
    }
</style>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-0">
            <span id="greeting"></span>, {{ Auth::user()->name }}!
        </h3>
        <p class="text-muted">
            Sistem Informasi Persuratan Sekolah.
        </p>
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

<!-- STATS BOXES -->
<div class="row g-4 mb-4">

    <!-- Total Surat -->
    <div class="col">
        <div class="card stat-card p-3 shadow-sm">
            <div class="d-flex align-items-center">
                <div class="icon-total me-3">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div>
                    <h6 class="mb-1">Total Surat</h6>
                    <h4 class="mb-0 text-total">{{ $total }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Masuk / Pending -->
    <div class="col">
        <div class="card stat-card p-3 shadow-sm">
            <div class="d-flex align-items-center">
                <div class="icon-masuk me-3">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <h6 class="mb-1">Surat Masuk</h6>
                    <h4 class="mb-0 text-masuk">{{ $masuk }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Proses -->
    <div class="col">
        <div class="card stat-card p-3 shadow-sm">
            <div class="d-flex align-items-center">
                <div class="icon-proses me-3">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <div>
                    <h6 class="mb-1">Proses</h6>
                    <h4 class="mb-0 text-proses">{{ $proses }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Disposisi -->
    <div class="col">
        <div class="card stat-card p-3 shadow-sm">
            <div class="d-flex align-items-center">
                <div class="icon-disposisi me-3">
                    <i class="fas fa-share-alt"></i>
                </div>
                <div>
                    <h6 class="mb-1">Disposisi</h6>
                    <h4 class="mb-0 text-disposisi">{{ $disposisi }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Selesai -->
    <div class="col">
        <div class="card stat-card p-3 shadow-sm">
            <div class="d-flex align-items-center">
                <div class="icon-selesai me-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h6 class="mb-1">Selesai</h6>
                    <h4 class="mb-0 text-selesai">{{ $selesai }}</h4>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- INFORMASI TERBARU -->
<div class="card info-card p-4 shadow-sm mb-4">
    <h5 class="fw-bold info-title mb-3">
        <i class="fas fa-bullhorn me-2"></i>Informasi Terbaru
    </h5>
    <div class="info-alert">
        <strong>Pemberitahuan:</strong> Pastikan setiap pengaduan disertai dengan bukti foto yang jelas untuk mempercepat proses tindak lanjut.
    </div>
</div>

<!-- CHART -->
<div class="card chart-card p-4 shadow-sm mb-4">
    <h5 class="fw-bold mb-1">Statistik Persuratan</h5>
    <p class="text-muted mb-3">Statistik status pengaduan saat ini</p>
    <div class="chart-wrapper">
        <canvas id="pengaduanChart"></canvas>
    </div>
</div>

<!-- SCRIPT: GREETING -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const hour = new Date().getHours();
    let greeting = '';

    if (hour >= 5 && hour < 12) {
        greeting = 'Selamat Pagi ';
    } else if (hour >= 12 && hour < 15) {
        greeting = 'Selamat Siang 🌤️';
    } else if (hour >= 15 && hour < 18) {
        greeting = 'Selamat Sore 🌅';
    } else {
        greeting = 'Selamat Malam 🌙';
    }

    const greetingElement = document.getElementById('greeting');
    if (greetingElement) {
        greetingElement.innerHTML = greeting;
    }
});
</script>

<!-- SCRIPT: CHART -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('pengaduanChart');
    if (!ctx) return;

    // Ambil data yang dikirim dari controller perbaikan terbaru
    const labelDays = {!! json_encode($days ?? []) !!};
    const dataMasuk = {!! json_encode($chartMasuk ?? []) !!};
    const dataProses = {!! json_encode($chartProses ?? []) !!};
    const dataDisposisi = {!! json_encode($chartDisposisi ?? []) !!};
    const dataSelesai = {!! json_encode($chartSelesai ?? []) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labelDays,
            datasets: [
                {
                    label: 'Surat Masuk',
                    data: dataMasuk,
                    borderColor: '#F59E0B', /* Warna Oranye Amber sesuai legenda kotak Anda */
                    backgroundColor: 'rgba(245, 158, 11, 0.05)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3,
                    pointBackgroundColor: '#F59E0B',
                    pointRadius: 4
                },
                {
                    label: 'Proses',
                    data: dataProses,
                    borderColor: '#3B82F6', /* Warna Biru sesuai legenda kotak Anda */
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3,
                    pointBackgroundColor: '#3B82F6',
                    pointRadius: 4
                },
                {
                    label: 'Disposisi',
                    data: dataDisposisi,
                    borderColor: '#8B5CF6', /* Warna Ungu sesuai legenda kotak Anda */
                    backgroundColor: 'rgba(139, 92, 246, 0.05)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3,
                    pointBackgroundColor: '#8B5CF6',
                    pointRadius: 4
                },
                {
                    label: 'Selesai',
                    data: dataSelesai,
                    borderColor: '#10B981', /* Warna Hijau Emerald sesuai legenda kotak Anda */
                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                    tension: 0.4,
                    fill: false,
                    borderWidth: 3,
                    pointBackgroundColor: '#10B981',
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        font: { size: 12, weight: 'bold' }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,              // Memulai grafik tegas dari angka 0
                    suggestedMax: 4,     // Memaksa batas atas grafik naik ke angka 4 jika data tertinggi masih rendah
                    ticks: {
                        stepSize: 1,     // Memaksa lompatan angka bernilai 1
                        precision: 0,    // Menghilangkan angka desimal koma (0.5, 1.5)
                        // Fungsi Callback untuk menyaring hanya angka bulat (integer) yang lolos cetak
                        callback: function(value) {
                            if (value % 1 === 0) {
                                return value;
                            }
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection