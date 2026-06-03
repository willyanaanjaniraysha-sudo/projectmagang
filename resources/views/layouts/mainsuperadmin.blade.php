<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin | E-Aspirasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; margin: 0; }
        .main-wrapper { margin-left: 260px; flex-grow: 1; min-height: 100vh; width: calc(100% - 260px); }
        .top-navbar { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; }
        .content-area { padding: 25px; }
        .card { background: #fff; padding: 50px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eee; }
        .form-group { margin-bottom: 15px; }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-primary { background: #4e73df; color: #fff; }
        .btn-danger { background: #e74a3b; color: #fff; }

        /* Tambahan ini untuk fix warna sidebar */
        .sidebar a, .sidebar button { color: #a2a2c2 !important; text-decoration: none !important; }
        .sidebar a:hover, .sidebar button:hover { color: #fff !important; }
    </style>
</head>
<body>
<div style="display:flex; width:100%;">
    @if(Auth::user()->role === 'super admin')
        @include('layouts.component.sidebarsuperadmin')
    @endif
    <div class="main-wrapper">
        <header class="top-navbar">
            <h4 style="margin:0; color:#333;">PANEL SUPER ADMIN</h4>
            <div>Halo, <strong>{{ Auth::user()->name }}</strong></div>
        </header>
        <main class="content-area">
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>