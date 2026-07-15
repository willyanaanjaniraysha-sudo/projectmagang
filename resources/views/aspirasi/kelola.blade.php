<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; }
        .nav-link { color: #a2a2c2; padding: 12px 20px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); border-left: 4px solid #818cf8; }
        .main-content { flex: 1; padding: 30px; margin-left: 260px; width: calc(100% - 260px); }

        /* TAMBAHAN: Style komponen kustom bertema hijau #2F5D50 */
        .text-custom-green {
            color: #2F5D50 !important;
        }
        .btn-custom-green {
            background-color: #2F5D50 !important;
            border-color: #2F5D50 !important;
            color: #fff !important;
            transition: all 0.3s ease;
        }
        .btn-custom-green:hover {
            background-color: #214339 !important;
            border-color: #214339 !important;
            color: #fff !important;
        }
        .form-select:focus {
            border-color: #2F5D50 !important;
            box-shadow: 0 0 0 0.25rem rgba(47, 93, 80, 0.25) !important;
        }

        /* TAMBAHAN: Tema ungu untuk status Disposisi (belum ada warna bawaan Bootstrap-nya) */
        .btn-disposisi {
            background-color: #8B5CF6 !important;
            border-color: #8B5CF6 !important;
            color: #fff !important;
        }
        .btn-outline-disposisi {
            border-color: #8B5CF6 !important;
            color: #8B5CF6 !important;
        }
        .btn-outline-disposisi:hover {
            background-color: #8B5CF6 !important;
            color: #fff !important;
        }
    </style>
</head>
<body>
<div class="d-flex">

    @include('layouts.component.sidebarsuperadmin')

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <!-- MODIFIKASI: Mengubah warna icon judul ke text-custom-green -->
                <h4 class="fw-bold mb-1"><i class="fas fa-tasks me-2 text-custom-green"></i>Kelola Pengaduan</h4>
                <p class="text-muted mb-0">Semua pengaduan masuk dari pengguna</p>
            </div>
            {{-- Filter Status --}}
            <div class="d-flex gap-2">
                <!-- MODIFIKASI: Mengubah filter tombol aktif "Semua" ke warna hijau tema -->
                <a href="/aspirasi" class="btn btn-sm {{ !request('status') ? 'btn-custom-green' : 'btn-outline-secondary' }} rounded-3">Semua</a>
                <a href="/aspirasi?status=Pending" class="btn btn-sm {{ request('status') == 'Pending' ? 'btn-warning' : 'btn-outline-warning' }} rounded-3">Pending</a>
                <a href="/aspirasi?status=Proses" class="btn btn-sm {{ request('status') == 'Proses' ? 'btn-info' : 'btn-outline-info' }} rounded-3">Proses</a>
                <a href="/aspirasi?status=Disposisi" class="btn btn-sm {{ request('status') == 'Disposisi' ? 'btn-disposisi' : 'btn-outline-disposisi' }} rounded-3">Disposisi</a>
                <a href="/aspirasi?status=Selesai" class="btn btn-sm {{ request('status') == 'Selesai' ? 'btn-success' : 'btn-outline-success' }} rounded-3">Selesai</a>
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
                                    <span class="badge rounded-pill px-3 py-2" style="background:#fef3c7; color:#92400e;">Pending</span>
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
                                        <option value="Pending"   {{ $item->status == 'Pending'   ? 'selected' : '' }}>Pending</option>
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
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>