@extends('layouts.mainsuperadmin')

@section('content')
<div style="max-width: 800px;">
    <!-- Judul & Deskripsi -->
    <div class="card">
    <div style="margin-bottom: 25px;">
        <h2 style="margin: 0; color: #1a1a2e;">Konfigurasi Sistem</h2>
        <p style="color: #666; font-size: 14px; margin-top: 5px;">Kelola pengaturan dasar aplikasi E-Aspirasi sekolah Anda.</p>
    </div>
    

    <!-- Form Pengaturan -->
    <form action="#" method="POST">
        @csrf
        <div class="form-group">
            <label>NAMA SEKOLAH / INSTANSI</label>
            <input type="text" value="SMK NEGERI 7 PROJECT" style="background: #fff; border: 1px solid #ddd; font-size: 15px; font-weight: 500;">
        </div>

        <div class="form-group">
            <label>ALAMAT SERVER (HOST)</label>
            <input type="text" value="127.0.0.1:8000" readonly style="background: #f9f9f9; color: #888; cursor: not-allowed;">
        </div>

        <!-- Kotak Informasi (Manual CSS) -->
        <div style="background:  #eaf1ef; color:  #2F5D50; padding: 15px; border-radius: 8px; margin: 20px 0; font-size: 13px; border-left: 5px solid  #2F5D50;">
            <strong>Informasi:</strong> Pastikan konfigurasi server sesuai dengan environment lokal Anda untuk menjaga stabilitas data aspirasi.
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
        <button type="submit" 
        class="btn text-white fw-bold rounded-3 shadow-sm btn-custom-green-action" 
        style="padding: 12px 30px; font-size: 14px; background-color: #2F5D50; border-color: #2F5D50; transition: all 0.3s ease;"
        onmouseover="this.style.backgroundColor='#214339'; this.style.borderColor='#214339'; this.style.transform='translateY(-1px)'"
        onmouseout="this.style.backgroundColor='#2F5D50'; this.style.borderColor='#2F5D50'; this.style.transform='translateY(0)'">
        Simpan Perubahan
        </button>

        </div>
     </form>
    </div>
</div>
@endsection
