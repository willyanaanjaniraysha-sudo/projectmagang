@extends('layouts.mainuser')

@section('content')
    <title>Profil Saya</title>
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
.profile-header{
    display:flex;
    align-items:center;
    gap:20px;
    margin-bottom:25px;
}

.avatar-section{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:8px;
}

.profile-photo{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #2563eb;
}

.btn-foto{
    background:#2563eb;
    color:white;
    padding:6px 12px;
    border-radius:6px;
    cursor:pointer;
    font-size:12px;
}

.btn-hapus{
    background:#ef4444;
    color:white;
    border:none;
    padding:6px 12px;
    border-radius:6px;
    cursor:pointer;
    font-size:12px;
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

        .stats {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            flex: 1;
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }

        .stat-card .angka {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
        }

        .stat-card .keterangan {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }

        .stat-card.kuning .angka { color: #d97706; }
        .stat-card.hijau  .angka { color: #16a34a; }

        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #2563eb;
            color: white;
            font-size: 32px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .nama {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .email {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .info-item {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 12px 16px;
            background: #f8fafc;
            border-radius: 8px;
        }

        .info-item .label {
            font-size: 13px;
            color: #94a3b8;
            width: 130px;
            flex-shrink: 0;
        }

        .info-item .value {
            font-size: 14px;
            color: #1e293b;
            font-weight: 500;
        }

        .btn-logout {
            display: inline-block;
            width: 100%;
            padding: 12px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }

        .btn-logout:hover { background: #dc2626; }
    </style>


    <div class="top-bar">
        <h1>👤 Profil Saya</h1>
    </div>

    {{-- Statistik --}}
    @php
        $total        = App\Models\Pengaduan::where('user_id', Auth::id())->count();
        $pending      = App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Pending')->count();
        $selesai      = App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Selesai')->count();
        $totalDihapus = $history->count();
    @endphp

    <div class="stats">
        <div class="stat-card">
            <div class="angka">{{ $total }}</div>
            <div class="keterangan">Total Pengaduan</div>
        </div>
        <div class="stat-card kuning">
            <div class="angka">{{ $pending }}</div>
            <div class="keterangan">Pending</div>
        </div>
        <div class="stat-card hijau">
            <div class="angka">{{ $selesai }}</div>
            <div class="keterangan">Selesai</div>
        </div>
        <div class="stat-card merah">
            <div class="angka">{{ $totalDihapus }}</div>
            <div class="keterangan">Dihapus</div>
        </div>
    </div>

    {{-- Profil --}}
    <div class="card">
       <div class="profile-header">

    <div class="avatar-section">

        @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}"
                 class="profile-photo">
                 
        @else
            <div class="avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif

        <form action="{{ route('profil.update-photo') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="photo" class="btn-foto">
                Ganti Foto
            </label>

            <input type="file"
                   id="photo"
                   name="photo"
                   hidden
                   onchange="this.form.submit()">
        </form>

        @if($user->photo)
        <form action="{{ route('profil.delete-photo') }}"
              method="POST"
              onsubmit="return confirm('Hapus foto profil?')">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn-hapus">
                Hapus Foto
            </button>
        </form>
        @endif

    </div>

    <div>
        <div class="nama">{{ $user->name }}</div>
        <div class="email">{{ $user->email }}</div>
    </div>

</div>
        <div class="info-row">
            <div class="info-item">
                <span class="label">📛 Nama</span>
                <span class="value">{{ $user->name }}</span>
            </div>
            <div class="info-item">
                <span class="label">📧 Email</span>
                <span class="value">{{ $user->email }}</span>
            </div>
            <div class="info-item">
                <span class="label">📅 Bergabung</span>
                <span class="value">{{ $user->created_at->format('d M Y') }}</span>
            </div>
            <div class="info-item">
                <span class="label">✅ Status</span>
                 <div class="d-flex align-items-center gap-2">
                    <span class="value text-success fw-bold me-1">Aktif</span>
                    
                   </div>
            </div>
        </div>

        <!-- Tombol Simpan Otomatis Muncul jika Anda Mengubah Teks Nama -->
        @if($errors->has('name') || $errors->has('photo'))
            <div class="text-danger small mt-2 px-3 text-center">
                {{ $errors->first('name') ?: $errors->first('photo') }}
            </div>
        @endif
    <div class="history-section" style="margin-top: 32px; margin-bottom: 20px;">
    <!-- Header Area yang Elegan -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 22px;">📋</span>
            <h2 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0; letter-spacing: -0.3px;">
                Riwayat Pengaduan yang Dihapus
            </h2>
        </div>
        <a href="/dashboard" class="btn-back" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: #ffffff; color: #64748b; text-decoration: none; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s ease;">
            <i class="fas fa-arrow-left" style="font-size: 12px;"></i> Kembali ke Dashboard
        </a>
    </div>
        
               <div class="history-list">
            @forelse($history as $log)
                <div class="info-item" style="display: flex; flex-direction: column; align-items: flex-start; background: #fff5f5; border: 1px solid #fee2e2; padding: 16px; margin-bottom: 12px; gap: 6px; width: 100%;">
                    
                    <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                        <span class="value" style="font-size: 15px; color: #991b1b; font-weight: bold;">
                            {{ $log->properties['old']['judul'] ?? 'Tanpa Judul' }}
                        </span>
                        <span class="tanggal" style="font-size: 12px; color: #f87171;">
                            {{ $log->created_at->format('d M Y, H:i') }} WIB
                        </span>
                    </div>
                    <div style="font-size: 13px; color: #7f1d1d; background: rgba(254, 226, 226, 0.4); padding: 10px; border-radius: 6px; width: 100%; border-left: 3px solid #f87171; line-height: 1.5; text-align: left;">
                        {{ $log->properties['old']['deskripsi'] ?? 'Tidak ada deskripsi.' }}
                    </div>
                    <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">
                        Status terakhir sebelum dihapus: <span style="background: #e2e8f0; color: #475569; padding: 2px 6px; border-radius: 4px; font-weight: bold;">{{ $log->properties['old']['status'] ?? 'Pending' }}</span>
                    </div>
                </div>
            @empty
                <div class="info-item" style="justify-content: center; color: #94a3b8; padding: 20px; font-size: 14px; text-align: center; display: block;">
                    Bersih! Anda belum pernah menghapus pengaduan apa pun.
                </div>
            @endforelse
        </div>
    </div>

@endsection
