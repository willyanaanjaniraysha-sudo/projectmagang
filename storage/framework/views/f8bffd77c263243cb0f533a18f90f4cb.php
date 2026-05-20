<?php $__env->startSection('content'); ?>
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

    
    <?php
        $total   = App\Models\Pengaduan::where('user_id', Auth::id())->count();
        $pending = App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Pending')->count();
        $selesai = App\Models\Pengaduan::where('user_id', Auth::id())->where('status', 'Selesai')->count();
    ?>

    <div class="stats">
        <div class="stat-card">
            <div class="angka"><?php echo e($total); ?></div>
            <div class="keterangan">Total Pengaduan</div>
        </div>
        <div class="stat-card kuning">
            <div class="angka"><?php echo e($pending); ?></div>
            <div class="keterangan">Pending</div>
        </div>
        <div class="stat-card hijau">
            <div class="angka"><?php echo e($selesai); ?></div>
            <div class="keterangan">Selesai</div>
        </div>
    </div>

    
    <div class="card">
        <div class="avatar">
            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

        </div>

        <div class="nama"><?php echo e($user->name); ?></div>
        <div class="email"><?php echo e($user->email); ?></div>

        <div class="info-row">
            <div class="info-item">
                <span class="label">📛 Nama</span>
                <span class="value"><?php echo e($user->name); ?></span>
            </div>
            <div class="info-item">
                <span class="label">📧 Email</span>
                <span class="value"><?php echo e($user->email); ?></span>
            </div>
            <div class="info-item">
                <span class="label">📅 Bergabung</span>
                <span class="value"><?php echo e($user->created_at->format('d M Y')); ?></span>
            </div>
            <div class="info-item">
                <span class="label">✅ Status</span>
                <span class="value">Aktif</span>
            </div>
        </div>
    </div>

    
    <form action="<?php echo e(route('logout')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn-logout">🚪 Logout</button>
    </form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.mainuser', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/pengaduan/saya.blade.php ENDPATH**/ ?>