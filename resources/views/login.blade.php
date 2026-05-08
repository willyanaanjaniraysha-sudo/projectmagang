<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Pengaduan Sekolah</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&family=Fraunces:wght@700&display=swap" rel="stylesheet">

  <style>
    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
    }

    body{
      font-family:'Plus Jakarta Sans', sans-serif;
      background:#f3f4f6;
      min-height:100vh;
      display:flex;
      justify-content:center;
      align-items:center;
      padding:20px;
    }

    /* CARD LOGIN */
    .login-card{
      width:100%;
      max-width:500px;
      background:#fff;
      border-radius:20px;
      padding:40px 32px;
      box-shadow:0 10px 40px rgba(0,0,0,0.08);
    }

    .login-card h2{
      font-family:'Fraunces', serif;
      font-size:32px;
      color:#111827;
      margin-bottom:8px;
    }

    .login-card p{
      font-size:14px;
      color:#6b7280;
      margin-bottom:30px;
    }

    /* FORM */
    .form-group{
      margin-bottom:18px;
    }

    .form-group label{
      display:block;
      margin-bottom:8px;
      font-size:13px;
      font-weight:600;
      color:#374151;
    }

    .input-field{
      display:flex;
      align-items:center;
      border:1.5px solid #dbe3ef;
      border-radius:12px;
      padding:0 14px;
      height:48px;
      background:#f9fafb;
      transition:0.2s;
    }

    .input-field:focus-within{
      border-color:#4f46e5;
      background:#fff;
    }

    .input-field svg{
      width:18px;
      height:18px;
      stroke:#9ca3af;
      margin-right:10px;
      flex-shrink:0;
    }

    .input-field input,
    .input-field select{
      width:100%;
      border:none;
      outline:none;
      background:transparent;
      font-size:14px;
      font-family:'Plus Jakarta Sans', sans-serif;
      color:#111827;
    }

    .input-field input::placeholder{
      color:#9ca3af;
    }

    /* BUTTON */
    .btn-login{
      width:100%;
      height:50px;
      border:none;
      border-radius:12px;
      background:#111827;
      color:#fff;
      font-size:15px;
      font-weight:600;
      cursor:pointer;
      margin-top:10px;
      transition:0.2s;
    }

    .btn-login:hover{
      background:#1f2937;
    }

    /* ALERT */
    .alert-error{
      background:#fee2e2;
      color:#b91c1c;
      padding:12px 14px;
      border-radius:10px;
      margin-bottom:18px;
      font-size:13px;
    }
  </style>
</head>
<body>

  <div class="login-card">

    <h2>Login Akun</h2>
    <p>Silahkan masuk dengan akun kamu</p>

    {{-- Error Session --}}
    @if (session('error'))
      <div class="alert-error">
        {{ session('error') }}
      </div>
    @endif

    {{-- Validasi --}}
    @if ($errors->any())
      <div class="alert-error">
        @foreach ($errors->all() as $error)
          <div>• {{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ route('proses.login') }}" method="POST">
      @csrf

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
            value="{{ old('name') }}"
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
