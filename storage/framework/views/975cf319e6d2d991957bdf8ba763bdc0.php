<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin | E-Aspirasi</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f7f6; margin: 0; display: flex; }
        .sidebar { width: 260px; background: #1a1a2e; color: #fff; min-height: 100vh; position: fixed; box-shadow: 2px 0 5px rgba(0,0,0,0.1); }
        .main-wrapper { margin-left: 260px; flex-grow: 1; min-height: 100vh; }
        .top-navbar { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; }
        .p-4 { padding: 25px; }

        .nav-link { color: #a2a2c2; padding: 12px 20px; display: block; text-decoration: none; margin: 5px 15px; border-radius: 8px; }
        .nav-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .nav-link.active { background: #4e73df; color: #fff; }

        .card { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eee; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; font-size: 14px; }
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-primary { background: #4e73df; color: #fff; }
        .btn-danger { background: #e74a3b; color: #fff; width: 80%; margin: 20px; }
        .badge { background: #e7f0ff; color: #4e73df; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div style="padding: 25px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <h3 style="margin: 0;">E-Aspirasi</h3>
        </div>
        <div style="margin-top: 20px;">
            <a href="/pengaturan" class="nav-link <?php echo e(request()->is('pengaturan') ? 'active' : ''); ?>">Pengaturan</a>
        </div>
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-danger">Keluar</button>
        </form>
    </div>

    <div class="main-wrapper">
        <header class="top-navbar">
            <h4 style="margin: 0; color: #333;">PANEL SUPER ADMIN</h4>
            <div>Halo, <strong><?php echo e(Auth::user()->name); ?></strong></div>
        </header>

        <main class="p-4">
            <div class="card">
                <h3 style="margin-top: 0;">Konfigurasi Sistem</h3>
                <p class="badge">SUPER ADMIN</p>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

                <?php echo $__env->yieldContent('content'); ?>

            </div>
        </main>
    </div>

</body>
</html><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/layouts/mainsuperadmin.blade.php ENDPATH**/ ?>