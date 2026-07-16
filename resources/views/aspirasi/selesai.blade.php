@extends($layout)

@section('content')
<style>
    .badge-selesai { background: #d1fae5; color: #065f46; }
</style>

<h4 class="fw-bold mb-1"><i class="fas fa-check-double me-2 text-success"></i>Riwayat Selesai</h4>
<p class="text-muted mb-4">Daftar pengaduan yang telah <strong>Selesai</strong> ditangani</p>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Pelapor</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Tanggal Selesai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengaduans as $index => $item)
                <tr>
                    <td class="ps-4">{{ $index + 1 }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ Str::limit($item->deskripsi, 60) }}</td>
                    <td>
    @if($item->gambar)
        <a href="{{ asset('upload/' . $item->gambar) }}" target="_blank">
            <img src="{{ asset('upload/' . $item->gambar) }}" width="60" height="60" 
                 style="object-fit:cover; border-radius:8px;">
        </a>
    @else
        <span class="text-muted" style="font-size: 12px;">Tidak ada foto</span>
    @endif
</td>
                    <td>
                        <span class="badge badge-selesai px-3 py-2 rounded-pill">Selesai</span>
                    </td>
                    <td class="text-muted">
                        {{ $item->updated_at->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Belum ada pengaduan yang selesai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection