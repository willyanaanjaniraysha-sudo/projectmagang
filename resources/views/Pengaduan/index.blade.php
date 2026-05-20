@extends('layouts.mainuser')

@section('content')
    <title>Pengaduan</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial;
            background: #f4f7fb;
            margin-left: 260px;
        }

        .top-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        h1 {
            color: #1e293b;
            font-size: 22px;
        }

        .list { display: flex; flex-direction: column; gap: 16px; }

        /* KARTU: Tetap memanjang ke bawah sebagai list, menggunakan flexbox */
        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            display: flex; /* Membuat gambar dan text-body berjejer ke samping */
            flex-direction: row; /* Memastikan arahnya horizontal (Gambar kiri, Teks kanan) */
            gap: 20px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            align-items: center; /* Membuat isi konten tegak lurus di tengah secara vertikal */
        }

        /* GAMBAR: Diatur ukurannya agar pas di sebelah kiri */
        .card img {
            width: 140px;      /* Lebar gambar diperbesar sedikit agar proporsional */
            height: 110px;     /* Tinggi gambar */
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;    /* Mencegah gambar gepeng atau mengecil */
        }

        /* KONTEN TEKS: Dibuat memenuhi sisa ruang di sebelah kanan gambar */
        .card-body { 
            flex: 1; 
            display: flex;
            flex-direction: column;
            gap: 4px; /* Memberi jarak konsisten antara judul, deskripsi, dan status */
        }

        .card-body h3 {
            font-size: 18px;
            color: #1e293b;
            margin: 0;
        }

        .card-body p {
            font-size: 14px;
            color: #64748b;
            margin: 4px 0 8px 0;
            line-height: 1.5;
        }

        /* Pembungkus status dan tanggal agar sejajar horizontal di bawah deskripsi */
        .meta-info {
            display: flex;
            align-items: center;
            gap: 12px;
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
        }

        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 40px;
            font-size: 15px;
        }
    </style>
    

    <div class="top-bar">
        <h1>📋 Riwayat Pengaduan</h1>
    </div>

    <a href="/pengaduan/create" class="btn btn-primary mb-3">+ Buat Pengaduan</a>

    @if(session('success'))
        <div class="alert alert-success d-block mb-3">{{ session('success') }}</div>
    @endif

    <div class="list">
        @forelse($pengaduan as $item)
            <div class="card">
                @if($item->gambar)
                    <img src="{{ asset('upload/' . $item->gambar) }}" alt="Foto">
                @else
                    <div style="width: 140px; height: 110px; background: #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0;">
                        <i class="fas fa-image fa-2x"></i>
                    </div>
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

                <div class="meta-info" style="justify-content: space-between; width: 100%;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                    <span class="badge {{ $badgeClass }}">{{ $item->status }}</span>
                        <div class="tanggal">Dikirim: {{ $item->created_at->format('d M Y, H:i') }}</div>
                    </div>
            <form action="{{ route('pengaduan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
        @csrf
        @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" style="padding: 4px 12px; border-radius: 6px; font-size: 13px; font-weight: bold; cursor: pointer; background-color: #ef4444; color: white; border: none;">
                     🗑️ Hapus
                </button>
            </form>
                </div>

            </div>
            </div>
        @empty
            <div class="empty">😴 Belum ada pengaduan. Silakan buat pengaduan baru.</div>
        @endforelse
    </div>
@endsection