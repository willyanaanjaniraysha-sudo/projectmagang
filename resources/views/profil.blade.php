@php
    $layout = Auth::user()->role === 'super admin'
        ? 'layouts.mainsuperadmin'
        : 'layouts.mainadmin';
@endphp

@extends($layout)

<style>
    .btn-custom-green {
        background-color: #2F5D50 !important;
        border-color: #2F5D50 !important;
        transition: all 0.3s ease;
    }
    .btn-custom-green:hover {
        background-color: #214339 !important; /* Warna hijau sedikit lebih gelap saat di-hover */
        border-color: #214339 !important;
        transform: translateY(-1px); /* Efek sedikit terangkat */
    }
    .form-control:focus {
        border-color: #2F5D50 !important;
        box-shadow: 0 0 0 0.25rem rgba(47, 93, 80, 0.25) !important; /* Glow hijau transparan */
    }
</style>

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6 mx-auto">
            
            <!-- Notifikasi Sukses Pembaruan -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Kartu Utama Profil Terpadu -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <!-- MODIFIKASI: Mengubah warna background header ke #2F5D50 -->
                <div class="card-header text-white py-3" style="background-color: #2F5D50;">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-circle me-2"></i>Profil Saya</h5>
                </div>
                
                <div class="card-body p-4 text-center">
                    
                    <!-- FORM UTAMA: Ganti Foto & Nama Sekaligus -->
                    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        @method('PUT')

                        <!-- Tampilan Komponen Foto Profil -->
                        <div class="position-relative d-inline-block mb-3">
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                     class="rounded-circle border border-3 border-light shadow" 
                                     width="110" height="110" style="object-fit: cover;" alt="User Photo">
                            @else
                                <!-- MODIFIKASI: Mengubah background inisial nama ke #2F5D50 -->
                                <div class="text-white rounded-circle d-flex align-items-center justify-content-center shadow mx-auto fw-bold" 
                                     style="width: 110px; height: 110px; font-size: 38px; background-color: #2F5D50;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Input Unggah File Gambar -->
                        <div class="mb-3 max-width-xs mx-auto px-4">
                            <label for="photo" class="form-label small text-muted fw-bold">UBAH FOTO PROFIL</label>
                            <input type="file" class="form-control form-control-sm @error('photo') is-invalid @enderror" id="photo" name="photo">
                            
                            @error('photo')
                                <div class="invalid-feedback text-start small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Badge Peran Akun Saat Ini -->
                        <div class="mb-4">
                            <span class="badge bg-danger rounded-pill px-3 py-2 fs-7 fw-bold shadow-sm">
                                <i class="fas fa-user-shield me-1"></i> {{ strtoupper($user->role) }}
                            </span>
                        </div>
                        
                        <!-- Detail & Form Input Teks Informasi Akun -->
                        <div class="text-start pt-3 border-top border-light">
                            
                            <!-- Input Nama Lengkap (Sekarang Bisa Diedit) -->
                            <div class="mb-3">
                                <label for="name" class="form-label small text-muted fw-bold mb-1 letter-spacing-1">NAMA LENGKAP</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Input Teks Email (Hanya Tampil / Read-only) -->
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold mb-1 letter-spacing-1">ALAMAT EMAIL</label>
                                <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                                <small class="text-muted" style="font-size: 11px;">*Alamat email tidak dapat diubah</small>
                            </div>
                            
                            <!-- Tampilan Tanggal Bergabung -->
                            <div class="mb-4">
                                <small class="text-muted fw-bold d-block mb-1 letter-spacing-1">TANGGAL BERGABUNG</small>
                                <span class="text-dark fw-semibold fs-6">{{ $user->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Tombol Utama: Simpan Perubahan Nama & Foto -->
                        <!-- MODIFIKASI: Mengubah tombol submit menggunakan warna #2F5D50 dan efek hover/border dasar -->
                        <div class="px-2 mb-2">
                            <button type="submit" class="btn text-white w-100 fw-bold rounded-pill shadow-sm" style="background-color: #2F5D50; border-color: #2F5D50;">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan Profil
                            </button>
                        </div>
                    </form> <!-- Penutup Form Utama Perubahan -->

                    <hr class="my-3 border-light">

                    <!-- SEKSI TOMBOL AKSI TAMBAHAN (Hapus Foto & Hapus Akun) -->
                    <div class="d-flex flex-column gap-2 px-2">
                        
                        <!-- Tombol Hapus Fotonya Saja (Hanya Muncul Jika Ada Foto) -->
                        @if(Auth::user()->photo)
                            <form action="{{ route('profil.delete-photo') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto profil?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100 btn-sm fw-bold rounded-pill">
                                    <i class="fas fa-image me-1"></i> Hapus Foto Profil
                                </button>
                            </form>
                        @endif

                        <!-- Tombol Hapus Akun Secara Permanen -->
                        <form action="{{ route('profil.delete') }}" method="POST" onsubmit="return confirm('PERINGATAN! Apakah Anda yakin ingin menghapus seluruh akun ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 btn-sm fw-bold rounded-pill">
                                <i class="fas fa-trash me-1"></i> Hapus Akun Saya
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
