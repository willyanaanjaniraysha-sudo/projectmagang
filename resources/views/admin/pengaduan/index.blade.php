@extends('layouts.mainadmin')

@section('content')
    <title>Kelola Pengaduan</title>
    <style>
        * { box-sizing: border-box; }

        .top-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .list { display: flex; flex-direction: column; gap: 16px; }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: row;
            gap: 20px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            align-items: center;
        }

        .card img {
            width: 140px;
            height: 110px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
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

        .card-body small {
            color: #94a3b8;
        }

        .meta-info {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: space-between;
            width: 100%;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-pending   { background: #fef9c3; color: #854d0e; }
        .badge-diproses  { background: #dbeafe; color: #1e40af; }
        .badge-disposisi { background: #ede9fe; color: #5b21b6; }
        .badge-selesai   { background: #d1fae5; color: #065f46; }

        .tanggal {
            font-size: 12px;
            color: #94a3b8;
        }

        .status-form {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-form select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            font-size: 13px;
        }

        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 40px;
            font-size: 15px;
        }
    </style>

    <div class="top-bar">
        <h1>🗂️ Kelola Pengaduan</h1>
    </div>

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
                    <small>Oleh: {{ $item->user->name ?? 'Pengguna dihapus' }}</small>

                    @php
                        $badgeClass = match($item->status) {
                            'Diproses'  => 'badge-diproses',
                            'Disposisi' => 'badge-disposisi',
                            'Selesai'   => 'badge-selesai',
                            default     => 'badge-pending',
                        };
                    @endphp

                    <div class="meta-info">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span class="badge {{ $badgeClass }}">{{ $item->status }}</span>
                            <div class="tanggal">Dikirim: {{ $item->created_at->format('d M Y, H:i') }}</div>
                        </div>

                        <form action="{{ route('admin.pengaduan.updateStatus', $item->id) }}" method="POST" class="status-form">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" @selected($item->status === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty">😴 Belum ada pengaduan.</div>
        @endforelse
    </div>
@endsection