<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; }
        .nav-link { color: #a2a2c2; padding: 12px 20px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); border-left: 4px solid #818cf8; }
        .main-content { flex: 1; padding: 30px; margin-left: 260px; width: calc(100% - 260px); }
    </style>
</head>
<body>
<div class="d-flex">

    @include('layouts.component.sidebarsuperadmin')

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1"><i class="fas fa-user-tie me-2 text-primary"></i>Daftar Admin</h4>
                <p class="text-muted mb-0">Manajemen akun admin sistem</p>
            </div>
            <a href="{{ route('admin.create') }}" class="btn btn-primary rounded-3">
                <i class="fas fa-plus me-1"></i> Tambah Admin
            </a>
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
                        @forelse($admins as $index => $admin)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width:35px; height:35px; font-size:13px;">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    {{ $admin->name }}
                                </div>
                            </td>
                            <td class="text-muted">{{ $admin->email }}</td>
                            <td>
                            <span class="badge" style="background-color: #e2e8f0; color: #1e293b; background: #d1fae5; color: #065f46; padding: 8px 14px; border-radius: 14px; font-size: 12px;">
                             {{ $admin->role }} 
                            </span>
                            </td>
                            <td class="text-muted">{{ $admin->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.edit', $admin->id) }}"
                                   class="btn btn-sm btn-warning rounded-3 me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.destroy', $admin->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus admin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-3">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada admin.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>