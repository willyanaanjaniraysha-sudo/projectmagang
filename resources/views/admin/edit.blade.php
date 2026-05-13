<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; }
        .nav-link { color: #a2a2c2; padding: 12px 20px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); border-left: 4px solid #818cf8; }
        .main-content { flex: 1; padding: 30px; }
    </style>
</head>
<body>
<div class="d-flex">

    @include('layouts.component.sidebarsuperadmin')

    <div class="main-content" style="max-width: 600px;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('admin.index') }}" class="btn btn-sm btn-secondary rounded-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h4 class="fw-bold mb-0"><i class="fas fa-user-edit me-2 text-warning"></i>Edit Admin</h4>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $admin->name) }}">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Password Baru
                        <small class="text-muted fw-normal">(kosongkan jika tidak ingin diubah)</small>
                    </label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Minimal 6 karakter">
                </div>
                <button type="submit" class="btn btn-warning w-100 rounded-3 fw-bold">
                    <i class="fas fa-save me-1"></i> Update Admin
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>