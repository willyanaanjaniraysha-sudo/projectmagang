@extends($layout)

@section('content')
<style>
    /* MODIFIKASI: Penyelarasan skema warna badge penanda role */
    .badge-superadmin { background: #ede9fe; color: #6d28d9; } /* Ungu gelap agar kontras */
    .badge-admin { background: #e0f2fe; color: #0369a1; }      /* Biru soft profesional */
    .badge-user { background: #d1fae5; color: #065f46; }       /* Hijau bawaan */

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
    }
    .btn-outline-custom-green {
        color: #2F5D50 !important;
        border-color: #2F5D50 !important;
        background-color: transparent;
        transition: all 0.3s ease;
    }
    .btn-outline-custom-green:hover, .btn-outline-custom-green.active {
        background-color: #2F5D50 !important;
        border-color: #2F5D50 !important;
        color: #fff !important;
    }
    .form-control:focus {
        border-color: #2F5D50 !important;
        box-shadow: 0 0 0 0.25rem rgba(47, 93, 80, 0.25) !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <!-- PERBAIKAN: Memperbaiki typo nama class text-custom-green -->
            <i class="fas fa-users-cog me-2 text-custom-green"></i>Kelola User
        </h4>
        <p class="text-muted mb-0">Manajemen akun pengguna sistem</p>
    </div>

    <div class="d-flex align-items-center gap-2">
        <form action="{{ route('user.index') }}" method="GET">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama, email, role..."
                class="form-control"
                style="width:250px;"
            >
        </form>
        
        <div class="d-flex gap-2">
            <!-- MODIFIKASI: Menyelaraskan seluruh tombol filter agar aktif berwarna hijau tema -->
            <a href="/user" class="btn btn-sm {{ !request('search') ? 'btn-custom-green' : 'btn-outline-secondary' }} rounded-3">Semua</a>
            <a href="/user?search=admin" class="btn btn-sm {{ request('search') == 'admin' ? 'btn-custom-green' : 'btn-outline-secondary' }} rounded-3">Admin</a>
            <a href="/user?search=user" class="btn btn-sm {{ request('search') == 'user' ? 'btn-custom-green' : 'btn-outline-secondary' }} rounded-3">User</a>
        
            @if(Auth::user()->role == 'admin')
                <a href="#" class="btn btn-sm btn-outline-secondary rounded-3 disabled" aria-disabled="true">Super Admin</a>
            @else
                <a href="/user?search=super admin" class="btn btn-sm {{ request('search') == 'super admin' ? 'btn-custom-green' : 'btn-outline-secondary' }} rounded-3">Super Admin</a>
            @endif
        </div>
        
        <!-- MODIFIKASI: Mengubah tombol "Tambah User" ke warna hijau tema -->
        <a href="{{ route('user.create') }}" class="btn btn-custom-green rounded-3">
            <i class="fas fa-plus me-1"></i> Tambah User
        </a>
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td class="ps-4">{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <!-- MODIFIKASI: Mengubah latar inisial nama di tabel menjadi hijau #2F5D50 -->
                            <div class="text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:35px; height:35px; font-size:13px; background-color: #2F5D50;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            {{ $user->name }}
                        </div>
                    </td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'super admin')
                            <span class="badge badge-superadmin px-3 py-2 rounded-pill">Super Admin</span>
                        @elseif($user->role == 'admin')
                            <span class="badge badge-admin px-3 py-2 rounded-pill">Admin</span>
                        @else
                            <span class="badge badge-user px-3 py-2 rounded-pill">User</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                    <td>
                        @if($user->trashed())
                            <!-- TOMBOL PULIHKAN (Hanya muncul jika user status soft delete) -->
                            <form action="{{ route('user.restore', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success rounded-3">
                                    <i class="fas fa-undo me-1"></i> Pulihkan
                                </button>
                            </form>
                        @else
                            <!-- TOMBOL NORMAL (Muncul jika user aktif) -->
                            <a href="{{ route('user.edit', $user->id) }}" 
                               class="btn btn-sm btn-warning rounded-3 me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger rounded-3">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 px-2">
    <form action="{{ route('user.index') }}" method="GET" class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
            <label for="per_page" class="small text-muted text-nowrap">Tampilkan:</label>
            <select name="per_page" id="per_page" class="form-select form-select-sm" style="width: 80px;" onchange="this.form.submit()">
                @foreach([10, 25, 50, 100, 150, 200] as $value)
                    <option value="{{ $value }}" {{ request('per_page', 10) == $value ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
    </form>
</div>
@endsection