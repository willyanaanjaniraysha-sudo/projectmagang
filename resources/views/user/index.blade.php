@extends('layouts.components,sidebaradmin') {{-- Pastikan ini sesuai dengan nama file layout utama kamu --}}

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Kelola Pengguna</h3>
            <p class="text-muted small">Manajemen akun admin, petugas, dan siswa.</p>
        </div>
        <button class="btn btn-primary btn-sm px-3 rounded-3">
            <i class="fas fa-plus me-1"></i> Tambah User
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 border-0">Nama Lengkap</th>
                            <th class="py-3 border-0">Email / Username</th>
                            <th class="py-3 border-0 text-center">Role</th>
                            <th class="py-3 border-0">Terdaftar Pada</th>
                            <th class="px-4 py-3 border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: #eef2ff;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email ?? $user->username }}</td>
                            <td class="text-center">
                                @if($user->role == 'super admin')
                                    <span class="badge bg-danger rounded-pill px-3">Super Admin</span>
                                @elseif($user->role == 'admin')
                                    <span class="badge bg-primary rounded-pill px-3">Admin</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3">User</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-4 text-center">
                                <button class="btn btn-sm btn-outline-info me-1"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                                <p>Belum ada data pengguna lainnya.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
