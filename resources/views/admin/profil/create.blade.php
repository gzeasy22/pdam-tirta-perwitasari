@extends('layouts.admin') {{-- Ganti jadi layouts.app kalau emang nama file layout lu app --}}

@section('content')
<style>
    .form-wrapper {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
        padding: 40px;
        max-width: 700px;
        margin: 0 auto 40px;
    }
    .form-title {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 5px;
        text-align: center;
    }
    .form-subtitle {
        color: #64748b;
        text-align: center;
        margin-bottom: 30px;
        font-size: 14px;
    }
    .input-group-custom {
        margin-bottom: 20px;
    }
    .label-custom {
        display: block;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .form-control-custom {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #cbd5e0;
        border-radius: 8px;
        font-size: 15px;
        color: #1e293b;
        background-color: #f8fafc;
        box-sizing: border-box;
        transition: 0.3s;
    }
    .form-control-custom:focus {
        border-color: #3b82f6;
        background-color: #ffffff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    .btn-submit-custom {
        background: #3b82f6;
        color: white;
        padding: 12px 0;
        border-radius: 8px;
        font-weight: bold;
        border: none;
        width: 100%;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
    }
    .btn-submit-custom:hover {
        background: #2563eb;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }
    .btn-back-custom {
        display: inline-block;
        color: #64748b;
        text-decoration: none;
        font-weight: bold;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .btn-back-custom:hover {
        color: #3b82f6;
    }
</style>

<div class="container-fluid">
    <a href="{{ route('admin.profil.index') }}" class="btn-back-custom">← Kembali ke Daftar</a>
    
    <div class="form-wrapper">
        <h2 class="form-title">Tambah Data Profil Baru</h2>
        <p class="form-subtitle">Lengkapi form di bawah ini dengan benar.</p>

        <form action="{{ route('admin.profil.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="input-group-custom">
                <label class="label-custom">1. Kategori Halaman <span style="color: red;">*</span></label>
                <select name="kategori" class="form-control-custom" required>
                    <option value="" selected disabled>-- Pilih Kategori --</option>
                    <option value="dewan_pengawas">Dewan Pengawas</option>
                    <option value="direksi">Direksi</option>
                    <option value="manajemen">Manajemen</option>
                </select>
            </div>

            <div class="input-group-custom">
                <label class="label-custom">2. Nama Pejabat <span style="color: red;">*</span></label>
                <input type="text" name="nama_atau_judul" class="form-control-custom" placeholder="Contoh: Ir. Budi Santoso" required>
            </div>

            <div class="input-group-custom">
                <label class="label-custom">3. Jabatan Pejabat</label>
                <input type="text" name="jabatan_atau_keterangan" class="form-control-custom" placeholder="Contoh: Direktur Utama">
            </div>

            <div class="input-group-custom">
                <label class="label-custom">4. Riwayat Pendidikan / Karir Singkat</label>
                <textarea name="deskripsi" class="form-control-custom" rows="4" placeholder="Contoh: Meraih gelar S1 Teknik Lingkungan... (Boleh dikosongkan)"></textarea>
            </div>
            
            <div class="input-group-custom">
                <label class="label-custom">5. Upload Foto <span style="color: red;">*</span></label>
                <input type="file" name="foto" class="form-control-custom" style="padding: 9px 15px;" accept="image/jpeg,image/png,image/jpg" required>
            </div>

            <button type="submit" class="btn-submit-custom">Simpan Data</button>
        </form>
    </div>
</div>
@endsection