<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Pengaduan Sekolah</title>
  <link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&family=Fraunces:wght@700&display=swap" rel="stylesheet">

 
</head>
<body>

  <div class="login-card">

    <h2>Login Akun</h2>
    <p>Silahkan masuk dengan akun kamu</p>

    
    <?php if(session('error')): ?>
      <div class="alert-error">
        <?php echo e(session('error')); ?>

      </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
      <div class="alert-error">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div>• <?php echo e($error); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>

    <form action="<?php echo e(route('proses.login')); ?>" method="POST">
      <?php echo csrf_field(); ?>

      <!-- Username -->
      <div class="form-group">
        <label>Username</label>
        <div class="input-field">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>

          <input 
            type="text" 
            name="name"
            placeholder="Masukkan username / NISN"
            value="<?php echo e(old('name')); ?>"
            required
          >
        </div>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label>Password</label>
        <div class="input-field">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>

          <input 
            type="password" 
            name="password"
            placeholder="Masukkan password"
            required
          >
        </div>
      </div>

      <!-- Role -->
      <div class="form-group">
        <label>Role</label>
        <div class="input-field">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
          </svg>

          <select name="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="super admin">Super Admin</option>
            <option value="user">User</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn-login">
        Masuk
      </button>

    </form>

  </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/login.blade.php ENDPATH**/ ?>