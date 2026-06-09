@extends('layouts.mainadmin') {{-- Otomatis menggunakan layout utama admin Anda --}}

@section('content')
<div class="main-content" style="background: #f8fafc; min-height: 100vh; padding: 30px;">
    <div class="container-fluid">
        
        <!-- Header Halaman -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="fas fa-history me-2 text-primary"></i>Log Aktivitas Pengguna
                </h4>
                <p class="text-muted small mb-0">Memantau rekam jejak digital, login, dan aksi CRUD seluruh pengguna sistem.</p>
            </div>
        </div>

        <!-- Tabel Log Card -->
        <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden; background: #fff;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="min-width: 900px;">
                        <thead class="table-light" style="background: #f1f5f9; color: #475569;">
                            <tr>
                                <th class="px-4 py-3" style="width: 180px;">Waktu</th>
                                <th class="py-3">Pengguna</th>
                                <th class="py-3" style="width: 130px;">Role</th>
                                <th class="py-3">Modul / Data</th>
                                <th class="py-3">Alamat IP</th>
                                <th class="px-4 py-3">Perangkat / Browser</th>
                                <th class="py-3" style="width: 120px;">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $log)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="px-4 text-secondary small">
                                        {{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark small">{{ $log->user->name ?? 'User Terhapus' }}</div>
                                        <small class="text-muted" style="font-size: 11px;">{{ $log->user->email ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <!-- Penyesuaian warna badge sesuai css sidebar Anda -->
                                        @php
                                            $roleClass = 'badge-user';
                                            if(str_contains(strtolower($log->role), 'super')) { $roleClass = 'badge-superadmin'; }
                                            elseif(strtolower($log->role) == 'admin') { $roleClass = 'badge-admin'; }
                                        @endphp
                                        <span class="badge {{ $roleClass }} px-2.5 py-1.5 fw-semibold" style="font-size: 11px; border-radius: 6px;">
                                            {{ $log->role }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $actionColors = [
                                                'LOGIN' => 'bg-success',
                                                'LOGOUT' => 'bg-secondary',
                                                'CREATE' => 'bg-primary',
                                                'UPDATE' => 'bg-warning text-dark',
                                                'DELETE' => 'bg-danger'
                                            ];
                                            $badgeColor = $actionColors[$log->action] ?? 'bg-info';
                                        @endphp
                                        <span class="badge {{ $badgeColor }} px-2 py-1 text-uppercase" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark fw-medium small">{{ $log->resource }}</span>
                                        @if($log->description)
                                            <br><small class="text-muted" style="font-size: 11px;">{{ $log->description }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <code class="text-primary bg-light px-2 py-0.5 rounded small" style="font-size: 11px;">
                                            {{ $log->ip_address ?? '127.0.0.1' }}
                                        </code>
                                    </td>
                                    <td class="px-4 text-muted small" style="font-size: 12px; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $log->device_info }}">
                                        {{ $log->device_info ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open d-block mb-2 fs-3 text-light"></i>
                                        Belum ada rekaman aktivitas user saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($activities->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top bg-light">
                        <small class="text-muted">
                            Menampilkan {{ $activities->firstItem() }} sampai {{ $activities->lastItem() }} dari {{ $activities->total() }} riwayat
                        </small>
                        <div>
                            {{ $activities->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
