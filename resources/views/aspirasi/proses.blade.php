<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dalam Proses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; }
        .nav-link { color: #a2a2c2; padding: 12px 20px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); border-left: 4px solid #818cf8; }
        .main-content { flex: 1; padding: 30px; margin-left: 260px; }
        .badge-proses { background: #dbeafe; color: #1e40af; }
    </style>
</head>
<body>
<div class="d-flex">

    @include('layouts.component.sidebaradmin')

    <div class="main-content">
        <h4 class="fw-bold mb-1"><i class="fas fa-spinner me-2 text-primary"></i>Dalam Proses</h4>
        <p class="text-muted mb-4">Daftar pengaduan dengan status <strong>Proses</strong></p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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
                            <th>Aksi</th>
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
                                <span class="badge badge-proses px-3 py-2 rounded-pill">Proses</span>
                            </td>
                            <td>
                                <form action="{{ route('aspirasi.updateStatus', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm d-inline w-auto"
                                            onchange="this.form.submit()">
                                        <option value="Pending"  {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Proses"   {{ $item->status == 'Proses'  ? 'selected' : '' }}>Proses</option>
                                        <option value="Selesai"  {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada pengaduan dalam proses.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>