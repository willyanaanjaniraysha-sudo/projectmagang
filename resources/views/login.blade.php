<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Pengaduan Sekolah</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&family=Fraunces:wght@700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f0ede8;
      padding: 2rem 1rem;
    }

    .login-wrapper {
      display: flex;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }

    /* ---- LEFT PANEL ---- */
    .panel-left {
      width: 300px;
      background: #1a1a2e;
      padding: 2.5rem 2rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 540px;
      position: relative;
      overflow: hidden;
    }

    .panel-left::before {
      content: '';
      position: absolute;
      width: 220px; height: 220px;
      border-radius: 50%;
      background: rgba(99,102,241,0.18);
      top: -60px; right: -60px;
    }

    .panel-left::after {
      content: '';
      position: absolute;
      width: 150px; height: 150px;
      border-radius: 50%;
      background: rgba(99,102,241,0.1);
      bottom: 40px; left: -40px;
    }

    .brand {
      font-family: 'Fraunces', serif;
      font-size: 20px;
      color: #fff;
      position: relative;
      z-index: 1;
    }

    .brand span { color: #818cf8; }

    .panel-left-body { position: relative; z-index: 1; }

    .panel-left-body h2 {
      font-family: 'Fraunces', serif;
      font-size: 24px;
      color: #fff;
      line-height: 1.35;
      margin-bottom: 10px;
    }

    .panel-left-body p {
      font-size: 13px;
      color: #94a3b8;
      line-height: 1.6;
    }

    .dots { display: flex; gap: 6px; position: relative; z-index: 1; }
    .dots span { width: 8px; height: 8px; border-radius: 50%; background: #334155; }
    .dots span.active { background: #818cf8; width: 22px; border-radius: 4px; }

    /* ---- RIGHT PANEL ---- */
    .panel-right {
      width: 360px;
      background: #fff;
      padding: 2.5rem 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .panel-right h3 {
      font-family: 'Fraunces', serif;
      font-size: 22px;
      color: #0f172a;
      margin-bottom: 4px;
    }

    .panel-right .sub {
      font-size: 13px;
      color: #94a3b8;
      margin-bottom: 28px;
    }

    /* Alert */
    .alert-error {
      display: none;
      align-items: center;
      gap: 8px;
      background: #fef2f2;
      border: 1px solid #fecaca;
      border-radius: 8px;
      padding: 10px 14px;
      font-size: 13px;
      color: #b91c1c;
      margin-bottom: 18px;
    }

    /* Form fields */
    .form-group { margin-bottom: 16px; }

    .form-group label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: #475569;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 6px;
    }

    .input-field {
      display: flex;
      align-items: center;
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      padding: 0 14px;
      height: 44px;
      background: #f8fafc;
      transition: border-color 0.2s, background 0.2s;
    }

    .input-field:focus-within {
      border-color: #818cf8;
      background: #fff;
    }

    .input-field svg {
      width: 16px; height: 16px;
      stroke: #94a3b8;
      flex-shrink: 0;
      margin-right: 10px;
      transition: stroke 0.2s;
    }

    .input-field:focus-within svg { stroke: #818cf8; }

    .input-field input,
    .input-field select {
      border: none;
      background: transparent;
      font-size: 14px;
      color: #0f172a;
      width: 100%;
      outline: none;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .input-field input::placeholder { color: #cbd5e1; }
    .input-field select { cursor: pointer; }

    /* Button */
    .btn-login {
      width: 100%;
      height: 46px;
      background: #1a1a2e;
      color: #fff;
      border: none;
      border-radius: 10px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 8px;
      letter-spacing: 0.3px;
      transition: background 0.2s, transform 0.1s;
    }

    .btn-login:hover { background: #2d2d4e; }
    .btn-login:active { transform: scale(0.99); }

    @media (max-width: 680px) {
      .panel-left { display: none; }
      .panel-right { border-radius: 20px; width: 100%; max-width: 380px; }
      .login-wrapper { box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
    }
  </style>
</head>
<body>

<div class="login-wrapper">
  <!-- LEFT -->
  <div class="panel-left">
    <div class="brand"><span>Pengaduan</span>Sekolah</div>
    <div class="panel-left-body">
      <h2>Selamat Datang Kembali 👋</h2>
      <p>Masuk untuk mengelola laporan pengaduan sekolah dengan mudah dan transparan.</p>
    </div>
    <div class="dots">
      <span class="active"></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="panel-right">
    <h3>Login Akun</h3>
    <p class="sub">Silahkan masuk dengan akun kamu</p>

    {{-- Error Session --}}
    @if (session('error'))
    <div class="alert-error" style="display:flex">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#b91c1c" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ session('error') }}
    </div>
    @endif

    {{-- Validasi --}}
    @if ($errors->any())
    <div class="alert-error" style="display:flex; flex-direction:column; align-items:flex-start; gap:4px">
      @foreach ($errors->all() as $error)
        <span>• {{ $error }}</span>
      @endforeach
    </div>
    @endif

    <form action="{{ route('proses.login') }}" method="post">
      @csrf

        
      <div class="form-group">
        <label>Username </label>
        <div class="input-field">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          <input type="text" name="name" placeholder="Masukkan username / NISN" value="{{ old('name') }}" required>
        </div>
      </div>

      <div class="form-group">
        <label>Password</label>
        <div class="input-field">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          <input type="password" name="password" placeholder="Masukkan password" required>
        </div>
      </div>

      <div class="form-group">
        <label>Role</label>
        <div class="input-field">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          <select name="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="super admin" {{ old('role') == 'super admin' ? 'selected' : '' }}>Super Admin</option>
            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn-login">Masuk</button>
    </form>
  </div>
</div>

</body>
</html>
