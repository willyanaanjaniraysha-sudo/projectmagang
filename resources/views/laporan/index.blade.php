@extends($layout)

@section('content')
<style>
    /* TAMBAHAN: Sinkronisasi efek interaksi komponen form ke tema hijau */
    .form-select:focus {
        border-color: #2F5D50 !important;
        box-shadow: 0 0 0 0.25rem rgba(47, 93, 80, 0.25) !important;
    }

    /* Efek transisi halus tombol PDF */
    .btn-danger {
        transition: all 0.3s ease;
    }
    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(220, 53, 69, 0.15);
    }

    .btn-custom-green {
        background-color: #2F5D50 !important;
        border-color: #2F5D50 !important;
        color: #ffffff !important;
    }
</style>

<!-- Judul Halaman tetap menggunakan aksen merah khas dokumen PDF -->
<h4 class="fw-bold mb-1"><i class="fas fa-file-pdf me-2 text-custom-green"></i>Cetak Laporan</h4>
<p class="text-muted mb-4">Filter dan unduh laporan pengaduan dalam format PDF</p>

{{-- Filter & Cetak --}}
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <form action="{{ route('laporan.cetak') }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-bold small text-muted">FILTER STATUS</label>
            <select name="status" class="form-select rounded-3">
                <option value="semua">Semua Status</option>
                <option value="Pending">Pending</option>
                <option value="Proses">Dalam Proses</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>
        <div class="col-md-3">
           <button type="submit" class="btn btn-custom-green w-100 rounded-3 fw-bold py-2 text-white" style="background-color: #2F5D50 !important; border-color: #2F5D50 !important;">
                <i class="fas fa-download me-1"></i> Download PDF
            </button>
        </div>
        <div class="col-md-3">
            <a href="{{ route('laporan.exportExcel') }}?status={{ request('status', 'semua') }}"
               class="btn btn-success w-100 rounded-3 fw-bold py-2 text-white"
               id="btn-export-excel">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </a>
        </div>
    </form>
</div>

<script>
    // Sinkronkan link Export Excel dengan filter status yang lagi dipilih,
    // tanpa perlu submit ulang form (biar user bisa langsung klik export)
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelect = document.querySelector('select[name="status"]');
        const excelBtn = document.getElementById('btn-export-excel');
        if (statusSelect && excelBtn) {
            statusSelect.addEventListener('change', function () {
                excelBtn.href = "{{ route('laporan.exportExcel') }}?status=" + this.value;
            });
        }
    });
</script>

{{-- Preview Tabel --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <!-- MODIFIKASI: Menambahkan warna teks utama redup agar selaras dengan tabel -->
    <div class="card-header bg-white py-3 px-4 border-0 border-bottom border-light">
        <h6 class="fw-bold mb-0 text-dark">Preview Semua Laporan ({{ $pengaduans->count() }} data)</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Pelapor</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengaduans as $index => $item)
                <tr>
                    <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                    <td class="fw-semibold text-dark">{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->judul }}</td>
                    <td class="text-secondary">{{ Str::limit($item->deskripsi, 60) }}</td>
                    <td>
                        @if($item->status == 'Pending')
                            <span class="badge rounded-pill" style="background:#fef3c7; color:#92400e;">Pending</span>
                        @elseif($item->status == 'Proses')
                            <span class="badge rounded-pill" style="background:#e0f2fe; color:#0369a1;">Proses</span>
                        @else
                            <!-- Status selesai disamakan menggunakan basis warna hijau #2F5D50 yang soft -->
                            <span class="badge rounded-pill" style="background:#d1fae5; color:#065f46;">Selesai</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $item->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Tidak ada data laporan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection