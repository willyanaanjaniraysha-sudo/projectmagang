<!DOCTYPE html>
<html>
<head>
    <title>Buat Pengaduan</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial;
            background: #f4f7fb;
            padding: 30px;
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

        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #1e293b;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            color: #1e293b;
            background: #f8fafc;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
            background: white;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px dashed #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
            font-size: 13px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #fca5a5;
            font-size: 13px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }

        .btn-submit:hover { background: #1d4ed8; }
    </style>
</head>
<body>

    <div class="top-bar">
        <a href="/pengaduan" class="btn-back">← Kembali</a>
        <h1>📝 Buat Pengaduan</h1>
    </div>

    <div class="card">

        @if($errors->any())
            <div class="alert-error">
                <ul style="padding-left: 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Judul Pengaduan</label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Jalan Rusak">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" placeholder="Jelaskan pengaduan kamu...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-group">
                <label>Foto Bukti</label>
                <input type="file" name="gambar" accept="image/*">
                <small style="color:#94a3b8; font-size:12px;">Format: JPG, JPEG, PNG. Maksimal 10MB.</small>
            </div>

            <button type="submit" class="btn-submit">📤 Kirim Pengaduan</button>

        </form>

    </div>

</body>
</html>