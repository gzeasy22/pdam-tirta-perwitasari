@extends('layouts.admin')

@section('content')
<style>
    .form-wrapper { background: #ffffff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 40px; max-width: 800px; margin: 0 auto; }
    .label-custom { display: block; font-weight: 700; margin-bottom: 8px; }
    .form-control-custom { width: 100%; padding: 12px; border: 1px solid #cbd5e0; border-radius: 8px; margin-bottom: 20px; box-sizing: border-box; }
    .btn-submit-custom { background: #3b82f6; color: white; padding: 12px; border-radius: 8px; font-weight: bold; border: none; width: 100%; cursor: pointer; transition: 0.3s; }
    .btn-submit-custom:hover { background: #2563eb; }
</style>

<div class="container-fluid">
    <a href="{{ route('admin.prestasi.index') }}" style="display:inline-block; margin-bottom:20px; font-weight:bold; color:#64748b; text-decoration:none;">← Kembali</a>
    
    <div class="form-wrapper">
        <h2 style="font-weight: 800; text-align: center; margin-bottom: 30px;">Tambah Prestasi Baru</h2>

        <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="label-custom">1. Upload Foto Piagam / Dokumentasi <span style="color:red;">*</span></label>
            <input type="file" name="foto" class="form-control-custom" accept="image/jpeg,image/png,image/jpg" required>

            <label class="label-custom">2. Deskripsi Prestasi <span style="color:red;">*</span></label>
            <textarea name="deskripsi" class="form-control-custom" rows="6" placeholder="Ceritakan detail prestasi, juara berapa, tahun berapa, tingkat apa..." required></textarea>

            <button type="submit" class="btn-submit-custom">Simpan Data Prestasi</button>
        </form>
    </div>
</div>
@endsection