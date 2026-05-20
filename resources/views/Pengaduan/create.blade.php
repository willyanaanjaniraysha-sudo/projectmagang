@extends('layouts.mainuser')

@section('content')

<style>
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

    .btn-back:hover {
        background: #cbd5e1;
    }

    .page-title {
        color: #1e293b;
        font-size: 24px;
        font-weight: bold;
        margin-left: 720px;
    }

    .card-form {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        max-width: 700px;
        margin-left: 520px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #1e293b;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #dbe2ea;
        border-radius: 10px;
        background: #f8fafc;
        font-size: 14px;
    }

    input[type="text"]:focus,
    textarea:focus {
        outline: none;
        border-color: #2563eb;
        background: white;
    }

    textarea {
        min-height: 130px;
        resize: vertical;
    }

    input[type="file"] {
        width: 100%;
        padding: 12px;
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        background: #f8fafc;
    }

    .btn-submit {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 10px;
        background: #2563eb;
        color: white;
        font-weight: bold;
        font-size: 15px;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background: #1d4ed8;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 14px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
</style>

<div class="top-bar">
   
    <h1 class="page-title">
        📝 Buat Pengaduan
    </h1>
</div>

<div class="card-form">

    @if($errors->any())
        <div class="alert-error">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengaduan.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label>Judul Pengaduan</label>

            <input type="text"
                   name="judul"
                   value="{{ old('judul') }}"
                   placeholder="Contoh: Jalan Rusak">
        </div>

        <div class="form-group">
            <label>Deskripsi</label>

            <textarea name="deskripsi"
                      placeholder="Jelaskan pengaduan kamu...">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label>Foto Bukti</label>

            <input type="file"
                   name="gambar"
                   accept="image/*">

            <small class="text-muted">
                Format: JPG, JPEG, PNG. Maksimal 10MB.
            </small>
        </div>

        <button type="submit" class="btn-submit">
            📤 Kirim Pengaduan
        </button>

    </form>

</div>

@endsection