<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengaduan Dihapus</title>
    <!-- Kita pakai Bootstrap CDN agar tampilannya langsung rapi tanpa install apapun -->
    <link rel="stylesheet" href="https://jsdelivr.net">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Riwayat Pengaduan yang Anda Hapus</h5>
            <a href="/dashboard" class="btn btn-sm btn-light">Kembali ke Dashboard</a>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Cek apakah user punya riwayat hapus --}}
            @if($history->isEmpty())
                <div class="text-center py-5 text-muted">
                    <p class="mb-0">Tidak ada riwayat pengaduan yang Anda hapus.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Waktu Hapus</th>
                                <th>Judul</th>
                                <th>Deskripsi Lama</th>
                                <th>Status Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d M Y, H:i') }} WIB</td>
                                    {{-- Mengambil data asli dari kolom JSON Spatie --}}
                                    <td><strong>{{ $log->properties['old']['judul'] ?? 'Tanpa Judul' }}</strong></td>
                                    <td>{{ \Illuminate\Support\Str::limit($log->properties['old']['deskripsi'] ?? '-', 80) }}</td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $log->properties['old']['status'] ?? 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Tombol navigasi halaman --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $history->links() }}
                </div>
            @endif

        </div>
    </div>
</div>

</body>
</html>
