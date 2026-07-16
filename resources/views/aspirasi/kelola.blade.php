@extends($layout)

@section('content')
<style>
    /* TAMBAHAN: Style komponen kustom bertema hijau #2F5D50 */
    .text-custom-green {
            color: #2F5D50 !important;
        }
    .form-select:focus {
        border-color: #2F5D50 !important;
        box-shadow: 0 0 0 0.25rem rgba(47, 93, 80, 0.25) !important;
    }

    /* Segmented control minimalis untuk filter status */
    .filter-segment {
        display: inline-flex;
        align-items: center;
        gap: 2px;
        padding: 4px;
        background: #f1f5f9;
        border-radius: 10px;
    }
    .filter-segment a {
        padding: 7px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #64748b;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .filter-segment a:hover {
        color: #1e293b;
    }
    .filter-segment a.active {
        background: #ffffff;
        color: #1e293b;
        box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <!-- MODIFIKASI: Mengubah warna icon judul ke text-custom-green -->
        <h4 class="fw-bold mb-1"><i class="fas fa-tasks me-2 text-custom-green"></i>Kelola Pengaduan</h4>
        <p class="text-muted mb-0">Semua pengaduan masuk dari pengguna</p>
    </div>
    {{-- Filter Status --}}
    <div class="filter-segment">
        <a href="/aspirasi" class="{{ !request('status') ? 'active' : '' }}">Semua</a>
        <a href="/aspirasi?status=Pending" class="{{ request('status') == 'Pending' ? 'active' : '' }}">Masuk</a>
        <a href="/aspirasi?status=Proses" class="{{ request('status') == 'Proses' ? 'active' : '' }}">Proses</a>
        <a href="/aspirasi?status=Disposisi" class="{{ request('status') == 'Disposisi' ? 'active' : '' }}">Disposisi</a>
        <a href="/aspirasi?status=Selesai" class="{{ request('status') == 'Selesai' ? 'active' : '' }}">Selesai</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Pelapor</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengaduans as $index => $item)
                <tr>
                    <td class="ps-4">{{ $index + 1 }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                    <td>
                        <a href="{{ asset('upload/' . $item->gambar) }}" target="_blank">
                            <img src="{{ asset('upload/' . $item->gambar) }}"
                                 width="55"
                                 height="55"
                                 style="object-fit:cover; border-radius:8px;">
                        </a>
                    </td>
                    <td>
                        @if($item->status == 'Pending')
                            <span class="badge rounded-pill px-3 py-2" style="background:#fef3c7; color:#92400e;">Masuk</span>
                        @elseif($item->status == 'Proses')
                            <span class="badge rounded-pill px-3 py-2" style="background:#dbeafe; color:#1e40af;">Proses</span>
                        @elseif($item->status == 'Disposisi')
                            <span class="badge rounded-pill px-3 py-2" style="background:#ede9fe; color:#5b21b6;">Disposisi</span>
                        @else
                            <span class="badge rounded-pill px-3 py-2" style="background:#d1fae5; color:#065f46;">Selesai</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <form action="{{ route('aspirasi.updateStatus', $item->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <!-- MODIFIKASI: Input select otomatis mendapatkan efek fokus ring outline hijau kustom saat diklik -->
                            <select name="status" class="form-select form-select-sm d-inline w-auto"
                                    onchange="this.form.submit()"
                                    {{ $item->status == 'Selesai' ? 'disabled' : '' }}>
                                <option value="Pending"   {{ $item->status == 'Pending'   ? 'selected' : '' }}>Masuk</option>
                                <option value="Proses"    {{ $item->status == 'Proses'    ? 'selected' : '' }}>Proses</option>
                                <option value="Disposisi" {{ $item->status == 'Disposisi' ? 'selected' : '' }}>Disposisi</option>
                                <option value="Selesai"   {{ $item->status == 'Selesai'   ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">Tidak ada pengaduan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection