<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&family=Fraunces:wght@700&display=swap" rel="stylesheet">

 
</head>
<body>

  <div class="login-card">

    <h2 style="text-align: center;">Login Akun</h2>
    <p style="text-align: center; font-weight: bold;">Pantau Aspirasi dengan Mudah dan Efisien</p>

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
        <label>Username (G-mail)</label>
        <div class="input-field">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>

          <input 
            type="text" 
            name="email"
            placeholder="Masukkan email"
            value="{{ old('email') }}"
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
      

      <button type="submit" class="btn-login">
        Masuk
      </button>

    </form>

  </div>

</body>
</html>
