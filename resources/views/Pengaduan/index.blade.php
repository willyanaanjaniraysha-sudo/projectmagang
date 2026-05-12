<!DOCTYPE html>
<html>
<head>
    <title>Pengaduan</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial;
            background: #f4f7fb;
            padding: 30px;
        }

        .top-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: #e2e8f0;
            color: #1e293b;
            text-decoration: none;
            border-radius: 8px;
            font-size: 13px;
        }

        .btn-back:hover { background: #cbd5e1; }

        h1 {
            color: #1e293b;
            font-size: 22px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .btn:hover { background: #1d4ed8; }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #6ee7b7;
        }

        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 40px;
            font-size: 15px;
        }

        .list { display: flex; flex-direction: column; gap: 16px; }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            gap: 16px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            align-items: flex-start;
        }

        .card img {
            width: 100px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .card-body { flex: 1; }

        .card-body h3 {
            font-size: 16px;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .card-body p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-pending  { background: #fef9c3; color: #854d0e; }
        .badge-diproses { background: #dbeafe; color: #1e40af; }
        .badge-selesai  { background: #d1fae5; color: #065f46; }

        .tanggal {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 6px;
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <a href="/dashboard" class="btn-back">← Dashboard</a>
        <h1>📋 Riwayat Pengaduan</h1>
    </div>

    <a href="/pengaduan/create" class="btn">+ Buat Pengaduan</a>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="list">
        @forelse($pengaduan as $item)
            <div class="card">
                @if($item->gambar)
                    <img src="{{ asset('upload/' . $item->gambar) }}" alt="Foto">
                @endif
                <div class="card-body">
                    <h3>{{ $item->judul }}</h3>
                    <p>{{ $item->deskripsi }}</p>

                    @php
                        $badgeClass = match($item->status) {
                            'Diproses' => 'badge-diproses',
                            'Selesai'  => 'badge-selesai',
                            default    => 'badge-pending',
                        };
                    @endphp

                    <span class="badge {{ $badgeClass }}">{{ $item->status }}</span>
                    <div class="tanggal">Dikirim: {{ $item->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
        @empty
            <div class="empty">😴 Belum ada pengaduan. Silakan buat pengaduan baru.</div>
        @endforelse
    </div>

</body>
</html>