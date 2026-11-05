@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .pengaduan-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .pengaduan-page h1, .pengaduan-page h2 {
        font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
        letter-spacing: -0.01em;
    }

    /* --- HERO SECTION --- */
    .tarif-hero {
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        background: linear-gradient(160deg, #0c4a6e 0%, #0369a1 55%, #0ea5e9 100%);
        padding: 80px 24px;
        text-align: center;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        box-sizing: border-box;
    }
    .tarif-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }
    .tarif-hero .pb-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.28);
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }
    .tarif-hero h1 {
        color: #ffffff;
        margin: 0 0 16px 0;
        font-size: 38px;
        font-weight: 800;
        position: relative;
        z-index: 1;
    }
    .tarif-hero p {
        color: rgba(255, 255, 255, 0.85);
        margin: 0 auto;
        font-size: 16px;
        max-width: 620px;
        line-height: 1.6;
        position: relative;
        z-index: 1;
    }

    /* --- FORM WRAPPER & CARD --- */
    .pb-wrap {
        max-width: 900px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }

    .form-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px -5px rgba(3, 105, 161, 0.08);
        border: 1px solid #e2e8f0;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }
    .form-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 5px;
        background: linear-gradient(90deg, #0ea5e9, #0369a1);
    }

    /* --- ALERTS --- */
    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        font-size: 15px;
        box-shadow: 0 4px 6px -1px rgba(22, 101, 52, 0.05);
    }
    .alert-icon { font-size: 22px; }
    .error-msg {
        color: #ef4444;
        font-size: 13px;
        font-weight: 600;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* --- FORM CONTROLS --- */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }
    .input-group {
        display: flex;
        flex-direction: column;
    }
    .input-group.full-width {
        grid-column: 1 / -1;
        margin-bottom: 24px;
    }
    .input-label {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
        font-size: 14.5px;
    }
    .input-label span { color: #ef4444; } /* Bintang merah buat required */
    
    .form-control {
        width: 100%;
        padding: 14px 16px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        font-family: inherit;
        font-size: 15px;
        color: #334155;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .form-control::placeholder { color: #94a3b8; }
    .form-control:focus {
        outline: none;
        background: #ffffff;
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px #e0f2fe;
    }
    textarea.form-control { resize: vertical; min-height: 100px; }

    /* --- FILE UPLOAD --- */
    .file-upload-box {
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        padding: 24px;
        border-radius: 12px;
        text-align: center;
        transition: all 0.2s ease;
        position: relative;
    }
    .file-upload-box:hover, .file-upload-box:focus-within {
        border-color: #0ea5e9;
        background: #f0f9ff;
    }
    .file-upload-input {
        width: 100%;
        font-family: inherit;
        font-size: 14.5px;
        color: #475569;
        cursor: pointer;
    }
    .file-upload-input::file-selector-button {
        background: #e2e8f0;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        color: #0f172a;
        font-weight: 600;
        cursor: pointer;
        margin-right: 12px;
        transition: background 0.2s ease;
    }
    .file-upload-input::file-selector-button:hover { background: #cbd5e1; }
    .file-helper {
        font-size: 13px;
        color: #64748b;
        margin: 8px 0 0 0;
    }

    /* --- SUBMIT BUTTON --- */
    .btn-submit {
        background: linear-gradient(135deg, #0ea5e9, #0369a1);
        color: #ffffff;
        padding: 16px 32px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        width: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
    }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px; }
        .tarif-hero h1 { font-size: 28px; }
        .form-card { padding: 24px; }
        .form-grid { grid-template-columns: 1fr; gap: 20px; }
        .input-group.full-width { margin-bottom: 20px; }
    }
</style>

<div class="pengaduan-page">
    
    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Layanan Pelanggan</span>
        <h1>Laporan Gangguan</h1>
        <p>Ada masalah dengan aliran air atau melihat pipa jaringan bocor? Laporkan segera agar tim teknis kami dapat bertindak cepat.</p>
    </div>

    <div class="pb-wrap">
        
        {{-- SUCCESS ALERT (Logika dipertahankan) --}}
        @if(session('sukses_lapor'))
            <div class="alert-success">
                <span class="alert-icon">✅</span> 
                <div>{{ session('sukses_lapor') }}</div>
            </div>
        @endif

        {{-- FORM PENGADUAN --}}
        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf
            
            <!-- SAKLAR JENIS PELAPOR -->
            <div class="input-group full-width" style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 24px;">
                <label class="input-label" style="font-size: 16px; margin-bottom: 12px;">Anda Melapor Sebagai Siapa? <span>*</span></label>
                <div style="display: flex; gap: 24px; flex-wrap: wrap;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600; font-size: 15px;">
                        <input type="radio" name="jenis_pelapor" value="Pelanggan" id="radioPelanggan" checked onclick="toggleForm()" style="width: 18px; height: 18px; accent-color: #0ea5e9;"> 
                        Pelanggan PDAM
                    </label>
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600; font-size: 15px;">
                        <input type="radio" name="jenis_pelapor" value="Umum" id="radioUmum" onclick="toggleForm()" style="width: 18px; height: 18px; accent-color: #0ea5e9;"> 
                        Masyarakat Umum / Instansi Lain
                    </label>
                </div>
            </div>

            <div class="form-grid">
                <!-- Nama Pelapor -->
                <div class="input-group">
                    <label class="input-label">Nama Lengkap Pelapor <span>*</span></label>
                    <input type="text" name="nama_pelapor" class="form-control" placeholder="Masukkan nama Anda" required value="{{ old('nama_pelapor') }}">
                </div>
                
                <!-- No Pelanggan (Muncul kalau Pelanggan) -->
                <div class="input-group" id="wadahNoPelanggan">
                    <label class="input-label">Nomor Pelanggan <span>*</span></label>
                    <input type="text" name="nomor_pelanggan" id="inputNoPelanggan" class="form-control" placeholder="Contoh: 22022004" required value="{{ old('nomor_pelanggan') }}">
                </div>

                <!-- Pilihan Kecamatan (Muncul kalau Umum) -->
                <div class="input-group" id="wadahKecamatan" style="display: none;">
                    <label class="input-label">Kecamatan Lokasi Kebocoran <span>*</span></label>
                    <select name="cabang_id" id="inputCabangId" class="form-control">
                        <option value="" selected disabled>-- Pilih Kecamatan --</option>
                        <option value="1">Kec. Bagelen</option>
                        <option value="2">Kec. Banyuurip</option>
                        <option value="3">Kec. Bayan</option>
                        <option value="4">Kec. Bener</option>
                        <option value="5">Kec. Butuh</option>
                        <option value="6">Kec. Gebang</option>
                        <option value="7">Kec. Grabag</option>
                        <option value="8">Kec. Kemiri</option>
                        <option value="9">Kec. Kutoarjo</option>
                        <option value="10">Kec. Loano</option>
                        <option value="11">Kec. Pituruh</option>
                        <option value="12">Kec. Purwodadi</option>
                        <option value="13">Kec. Purworejo</option>
                    </select>
                </div>
                
                <!-- No HP -->
                <div class="input-group full-width" id="wadahNoHp">
                    <label class="input-label">No. HP / WhatsApp <span>*</span></label>
                    <input type="text" name="no_hp" class="form-control" required value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789">
                </div>
            </div>

            <div class="form-grid">
                <!-- Link Google Maps -->
                <div class="input-group">
                    <label class="input-label">Link Google Maps (Titik Kebocoran) <span>*</span></label>
                    <input type="url" name="link_map" class="form-control" placeholder="Paste URL dari aplikasi Google Maps" required value="{{ old('link_map') }}">
                </div>

                <!-- Detail Patokan (Dulu Lokasi Kejadian) -->
                <div class="input-group">
                    <label class="input-label">Detail Patokan Lokasi <span>*</span></label>
                    <input type="text" name="lokasi_kejadian" class="form-control" placeholder="Contoh: Depan pagar hitam / Dekat tiang PLN" required value="{{ old('lokasi_kejadian') }}">
                </div>
            </div>

            <!-- Deskripsi Masalah -->
            <div class="input-group full-width">
                <label class="input-label">Deskripsi Masalah / Keluhan <span>*</span></label>
                <textarea name="deskripsi_masalah" class="form-control" required rows="4" placeholder="Jelaskan detail masalahnya (misal: Air bocor ke jalanan sejak jam 8 pagi, dll)...">{{ old('deskripsi_masalah') }}</textarea>
            </div>

            <!-- Upload Foto -->
            <div class="input-group full-width" style="margin-bottom: 32px;">
                <label class="input-label">Upload Foto Bukti (Opsional namun disarankan)</label>
                <div class="file-upload-box">
                    <input type="file" name="foto_bukti" accept="image/*" class="file-upload-input">
                    <p class="file-helper">Format yang didukung: JPG/PNG (Maksimal 2MB)</p>
                </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn-submit">
                <span>🚀</span> Kirim Laporan Pengaduan
            </button>
            
        </form>
    </div>
</div>
{{-- JAVASCRIPT BUAT SAKLAR DINAMIS --}}
        <script>
            function toggleForm() {
                let isUmum = document.getElementById('radioUmum').checked;
                let wadahNoPelanggan = document.getElementById('wadahNoPelanggan');
                let inputNoPelanggan = document.getElementById('inputNoPelanggan');
                let wadahKecamatan = document.getElementById('wadahKecamatan');
                let inputCabangId = document.getElementById('inputCabangId');

                if (isUmum) {
                    wadahNoPelanggan.style.display = 'none';
                    inputNoPelanggan.required = false;
                    inputNoPelanggan.value = ''; 
                    
                    // Munculin wajib isi Kecamatan
                    wadahKecamatan.style.display = 'flex';
                    inputCabangId.required = true;
                } else {
                    wadahNoPelanggan.style.display = 'flex';
                    inputNoPelanggan.required = true;
                    
                    // Sembunyiin Kecamatan
                    wadahKecamatan.style.display = 'none';
                    inputCabangId.required = false;
                    inputCabangId.value = '';
                }
            }
            window.onload = function() { toggleForm(); };
        </script>
@endsection