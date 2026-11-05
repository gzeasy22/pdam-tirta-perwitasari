@extends('layouts.admin')

@section('content')
<style>
    .form-wrapper { background: #ffffff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; padding: 40px; max-width: 600px; margin: 0 auto; }
    .label-custom { display: block; font-weight: 700; margin-bottom: 8px; color: #334155; }
    .form-control-custom { width: 100%; padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px; margin-bottom: 20px; box-sizing: border-box; }
    .btn-submit-custom { background: #3b82f6; color: white; padding: 12px; border-radius: 8px; font-weight: bold; border: none; width: 100%; cursor: pointer; font-size: 16px; transition: 0.3s; }
    .btn-submit-custom:hover { background: #2563eb; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4); }
</style>

<div class="container-fluid">
    <a href="{{ route('admin.galeri_profil.index') }}" style="display:inline-block; margin-bottom:20px; font-weight:bold; color:#64748b; text-decoration:none;">← Kembali ke Daftar</a>
    
    <div class="form-wrapper">
        <h2 style="font-weight: 800; text-align: center; margin-bottom: 10px; color: #1e293b;">Upload Bagan Struktur</h2>
        <p style="text-align: center; color: #64748b; margin-bottom: 30px; font-size: 14px;">Silakan upload gambar bagan organisasi di bawah ini.</p>

        <form action="{{ route('admin.galeri_profil.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="label-custom">1. Kategori</label>
            <input type="text" name="kategori" class="form-control-custom" value="struktur_organisasi" readonly style="background-color: #f1f5f9; cursor: not-allowed; color: #94a3b8;">

            <label class="label-custom">2. Upload Foto Bagan <span style="color:red;">*</span></label>
            <input type="file" name="foto" class="form-control-custom" accept="image/jpeg,image/png,image/jpg" required>
            <small style="color: #94a3b8; display: block; margin-top: -15px; margin-bottom: 25px; font-size: 12px;">
                *Format: JPG, PNG. Maksimal 3MB. (Bagan resolusi tinggi tetap aman).
            </small>

            <button type="submit" class="btn-submit-custom">Simpan Bagan</button>
        </form>
    </div>
</div>
@endsection