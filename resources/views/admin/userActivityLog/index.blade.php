@extends($layout)

@section('hide-header', 'yes')

@section('content')
<!-- Container Utama Tanpa Batasan Ukuran -->
<div class="w-100" style="background: #f8fafc; min-height: 100vh;">
    <div class="container-fluid px-0">
        
        <!-- Header Halaman -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="fas fa-history me-2 text-custom-green"></i>Log Aktivitas Pengguna
                </h4>
                <p class="text-muted small mb-0">Memantau rekam jejak digital, login, dan aksi CRUD seluruh pengguna sistem.</p>
            </div>
        </div>

        <!-- Tabel Log Card - Dipaksa Melebar Penuh 100% -->
        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; background: #fff; width: 100% !important; padding: 20px !important;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 w-100">
                        <thead class="table-light" style="background: #f1f5f9; color: #475569;">
                            <tr>
                                <th class="px-3 py-3 text-nowrap" style="width: 15%;">Waktu</th>
                                <th class="py-3 text-nowrap" style="width: 15%;">Pengguna</th>
                                <th class="py-3 text-nowrap" style="width: 10%;">Role</th>
                                <th class="py-3 text-nowrap" style="width: 10%;">Aksi</th>
                                <th class="py-3 text-nowrap" style="width: 25%;">Modul / Deskripsi Data</th>
                                <th class="py-3 text-nowrap" style="width: 10%;">Alamat IP</th>
                                <th class="px-3 py-3 text-nowrap" style="width: 15%;">Perangkat / Browser</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $log)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <!-- 1. Waktu -->
                                    <td class="px-3 text-secondary small text-nowrap">
                                        {{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB
                                    </td>

                                    <!-- 2. Pengguna -->
                                    <td>
                                        <div class="fw-bold text-dark small text-nowrap">{{ $log->user->name ?? 'User Terhapus' }}</div>
                                        <small class="text-muted" style="font-size: 11px;">{{ $log->user->email ?? '-' }}</small>
                                    </td>

                                    <!-- 3. Role -->
                                    <!-- 3. Role (Ukuran Kotak Disamakan) -->
                                    <td class="text-nowrap">
                                        @php
                                            $roleClass = 'bg-secondary';
                                            if(str_contains(strtolower($log->role ?? ''), 'super')) { $roleClass = 'bg-danger'; }
                                            elseif(strtolower($log->role ?? '') == 'admin') { $roleClass = 'bg-primary'; }
                                        @endphp
                                        <!-- Ditambahkan d-inline-block text-center dan style width agar lebar kotak sama rata -->
                                        <span class="badge {{ $roleClass }} d-inline-block text-center px-2 py-1.5 fw-semibold" style="font-size: 11px; border-radius: 6px; width: 95px;">
                                            {{ $log->role ?? 'User' }}
                                        </span>
                                    </td>

                                   <!-- 4. Aksi (Ukuran Kotak Disamakan) -->
                                    <td class="text-nowrap">
                                        @php
                                            $actionColors = [
                                                'LOGIN' => 'bg-success text-white',
                                                'LOGOUT' => 'bg-secondary text-white',
                                                'CREATE' => 'bg-info text-white',
                                                'UPDATE' => 'bg-warning text-dark',
                                                'DELETE' => 'bg-danger text-white', 
                                                'DOWNLOAD' => 'bg-primary text-white',
                                            ];
                                            $badgeColor = $actionColors[strtoupper($log->action ?? 'LOGIN')] ?? '';
                                        @endphp
                                    
                                        @if(strtoupper($log->action ?? '') === 'VIEW')
                                            <!-- Desain Kotak Warna Lilac Spesial Khusus untuk VIEW -->
                                            <span class="badge d-inline-block text-center px-2 py-1.5 text-uppercase" 
                                                  style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px; width: 90px; background-color: #e2d1f9; color: #5a3791; border: 1px solid #d1bbf2; border-radius: 6px;">
                                                {{ $log->action }}
                                            </span>
                                        @else
                                            <!-- Warna Badge Standar Lainnya -->
                                            <span class="badge {{ $badgeColor }} d-inline-block text-center px-2 py-1.5 text-uppercase" 
                                                  style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px; width: 90px; border-radius: 6px;">
                                                {{ $log->action ?? 'LOGIN' }}
                                            </span>
                                        @endif
                                    </td>
                                    

                                    <!-- 5. Modul & Deskripsi (Disatukan di kolom luas agar teks panjang leluasa ke kanan) -->
                                    <td>
                                        <strong class="text-secondary small d-block mb-1">[{{ $log->resource ?? 'auth' }}]</strong>
                                        <span class="text-dark small d-block" style="white-space: normal; word-break: break-word;">
                                            {{ $log->description ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- 6. Alamat IP -->
                                    <td class="text-nowrap">
                                        <code class="text-primary bg-light px-2 py-0.5 rounded" style="font-size: 12px; font-weight: bold;">
                                            {{ $log->ip_address ?? '127.0.0.1' }}
                                        </code>
                                    </td>

                                    <!-- 7. Perangkat / Browser -->
                                    <td class="px-3 text-muted small" style="font-size: 12px; white-space: normal; word-break: break-word;">
                                        {{ $log->device_info ?? $log->user_agent ?? 'Desktop - Edge' }}
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
                        <!-- TAMBAHAN: Tag style disatukan langsung di sini agar tidak merusak struktur atas -->
                        <style scoped>
                            .pagination .page-item.active .page-link {
                                background-color: #2F5D50 !important;
                                border-color: #2F5D50 !important;
                                color: #ffffff !important;
                            }
                            .pagination .page-link {
                                color: #2F5D50 !important;
                            }
                            .pagination .page-link:hover {
                                background-color: #eaf1ef !important;
                                color: #214339 !important;
                            }
                        </style>

                        {{ $activities->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
            

                        </div>
        </div>

    </div>
</div>
@endsection