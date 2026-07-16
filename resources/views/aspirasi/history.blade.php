@extends($layout)

@section('content')
<style>
    .text-custom-green {
        color: #2F5D50 !important;
    }
    .pagination .page-item.active .page-link {
        background-color: #2F5D50 !important;
        border-color: #2F5D50 !important;
        color: #ffffff !important;
    }
    .pagination .page-link {
        color: #2F5D50 !important;
    }
    .pagination .page-link:hover {
        background-color: #eaf1ef !important;
        color: #214339 !important;
    }
</style>

<h4 class="fw-bold mb-1"><i class="fas fa-trash-restore me-2 text-custom-green"></i>Riwayat Penghapusan Pengaduan</h4>
<p class="text-muted mb-4">Daftar pengaduan yang pernah dihapus oleh Anda</p>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Judul Pengaduan</th>
                    <th>Deskripsi</th>
                    <th>Dihapus Oleh</th>
                    <th>Tanggal Dihapus</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $index => $log)
                    @php
                        // Data pengaduan aslinya sudah terhapus dari tabel utama,
                        // jadi kita ambil dari snapshot properti log aktivitas (jika tersimpan).
                        $oldData = $log->properties['old'] ?? $log->properties['attributes'] ?? [];
                    @endphp
                    <tr>
                        <td class="ps-4">{{ $history->firstItem() + $index }}</td>
                        <td class="fw-semibold text-dark">{{ $oldData['judul'] ?? '-' }}</td>
                        <td class="text-secondary">{{ Str::limit($oldData['deskripsi'] ?? '-', 60) }}</td>
                        <td>{{ $log->causer->name ?? 'User Terhapus' }}</td>
                        <td class="text-muted">{{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open d-block mb-2 fs-3 text-light"></i>
                            Belum ada riwayat penghapusan pengaduan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($history->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top bg-light">
        <small class="text-muted">
            Menampilkan {{ $history->firstItem() }} sampai {{ $history->lastItem() }} dari {{ $history->total() }} riwayat
        </small>
        <div>
            {{ $history->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsection