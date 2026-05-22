@extends('layouts.mainsuperadmin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6 mx-auto">
            
            <!-- Notifikasi Sukses Unggah Foto -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Kartu Utama Profil -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-circle me-2"></i>Profil Saya</h5>
                </div>
                
                <div class="card-body p-4 text-center">
                    
                    <!-- Form Utama Foto Profil -->
        <form action="{{ route('profil.update-photo') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            @method('PUT')

    <div class="position-relative d-inline-block mb-3">
        @if(Auth::user()->photo)
            <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                 class="rounded-circle border border-3 border-light shadow" 
                 width="110" height="110" style="object-fit: cover;" alt="User Photo">
        @else
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow mx-auto fw-bold" 
                 style="width: 110px; height: 110px; font-size: 38px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
    </div>

    <div class="mb-3 max-width-xs mx-auto px-4">
        <label for="photo" class="form-label small text-muted fw-bold">UBAH FOTO PROFIL</label>
        <input type="file" class="form-control form-control-sm @error('photo') is-invalid @enderror" id="photo" name="photo">
        
        @error('photo')
            <div class="invalid-feedback text-start small">{{ $message }}</div>
        @enderror
    </div>

    <!-- AREA D-FLEX UNTUK MEMBUAT TOMBOL SEJAJAR KANAN KIRI -->
    <div class="d-flex justify-content-center align-items-center gap-2">
        <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">
            <i class="fas fa-save me-1"></i> Simpan Foto
        </button>
</form> <!-- Penutup form simpan ditaruh di sini agar tidak merusak baris -->

        @if(Auth::user()->photo)
            <form action="{{ route('profil.delete-photo') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto profil?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm px-4 rounded-pill">
                    <i class="fas fa-trash me-1"></i> Hapus Foto
                </button>
            </form>
        @endif
    </div>

                    <!-- Identitas Nama dan Peran -->
                    <h4 class="mb-1 fw-bold text-dark">{{ $user->name }}</h4>
                    <span class="badge bg-danger rounded-pill px-3 py-2 mb-4 fs-7 fw-bold shadow-sm">
                        <i class="fas fa-user-shield me-1"></i> {{ strtoupper($user->role) }}
                    </span>
                    
                    <!-- Detail Informasi Akun -->
                    <div class="text-start pt-3 border-top border-light">
                        <div class="mb-3">
                            <small class="text-muted fw-bold d-block letter-spacing-1">ALAMAT EMAIL</small>
                            <span class="text-dark fw-semibold fs-6">{{ $user->email }}</span>
                        </div>
                        
                        <div>
                            <small class="text-muted fw-bold d-block letter-spacing-1">TANGGAL BERGABUNG</small>
                            <span class="text-dark fw-semibold fs-6">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
