@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .bn-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .bn-page h1, .bn-page h2, .bn-page h3, .bn-page h4 {
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
        margin-bottom: 50px;
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
        color: #ffffff; margin: 0 0 16px 0; font-size: 38px; font-weight: 800; position: relative; z-index: 1;
    }
    .tarif-hero p {
        color: rgba(255, 255, 255, 0.85); margin: 0 auto; font-size: 16px; max-width: 620px; line-height: 1.6; position: relative; z-index: 1;
    }

    /* --- WRAPPER & CARDS --- */
    .bn-wrap {
        max-width: 800px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }
    .bn-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px -10px rgba(3, 105, 161, 0.12);
        border: 1px solid #e2e8f0;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    .card-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 24px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* --- ALERTS --- */
    .alert-box {
        padding: 16px 20px; border-radius: 12px; margin-bottom: 24px;
        font-size: 14.5px; font-weight: 600; display: flex; align-items: center; gap: 12px;
    }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

    /* --- STATUS ALERTS (BALIK NAMA) --- */
    .status-alert {
        border-radius: 16px; padding: 24px; margin-bottom: 30px;
        border: 2px solid transparent; box-shadow: 0 4px 15px -3px rgba(0,0,0,0.05);
    }
    .status-alert.rejected { background: #fef2f2; border-color: #fecaca; }
    .status-alert.rejected h3 { color: #dc2626; font-size: 22px; font-weight: 800; margin: 0 0 12px 0; }
    .status-alert.rejected p { color: #991b1b; font-size: 15px; margin: 0 0 16px 0; line-height: 1.6; }
    .status-alert.rejected .reason {
        background: #ef4444; color: white; padding: 12px 20px; border-radius: 8px;
        font-weight: 700; font-size: 15px; display: inline-block; margin-bottom: 16px;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
    }
    .status-alert.rejected .footer { color: #b91c1c; font-size: 14px; font-weight: 700; }

    .status-alert.approved { background: #f0fdf4; border-color: #bbf7d0; }
    .status-alert.approved h3 { color: #16a34a; font-size: 22px; font-weight: 800; margin: 0 0 12px 0; }
    .status-alert.approved p { color: #15803d; font-size: 15px; margin: 0; line-height: 1.6; }
    
    .status-alert.pending { background: #fffbeb; border-color: #fde68a; }
    .status-alert.pending h3 { color: #d97706; font-size: 22px; font-weight: 800; margin: 0 0 12px 0; }
    .status-alert.pending p { color: #b45309; font-size: 15px; margin: 0; line-height: 1.6; }

    /* --- FORM CONTROLS --- */
    .form-group { margin-bottom: 20px; }
    .input-label {
        display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 14.5px;
    }
    .form-control {
        width: 100%; padding: 16px 20px; font-size: 15px; font-family: inherit;
        color: #334155; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px;
        transition: all 0.2s ease; box-sizing: border-box;
    }
    .form-control:focus {
        outline: none; background: #ffffff; border-color: #0ea5e9; box-shadow: 0 0 0 4px #e0f2fe;
    }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    /* --- FILE UPLOAD --- */
    .file-upload-box {
        border: 2px dashed #cbd5e1; background: #f8fafc; padding: 20px; border-radius: 12px;
        text-align: center; transition: all 0.2s ease;
    }
    .file-upload-box:hover { border-color: #0ea5e9; background: #f0f9ff; }
    .file-upload-input { width: 100%; font-family: inherit; font-size: 13.5px; color: #475569; cursor: pointer; }
    .file-upload-input::file-selector-button {
        background: #e2e8f0; border: none; padding: 8px 14px; border-radius: 8px;
        color: #0f172a; font-weight: 700; cursor: pointer; margin-right: 12px; transition: 0.2s;
    }
    .file-upload-input::file-selector-button:hover { background: #cbd5e1; }

    /* --- DATA READ-ONLY BOX --- */
    .data-box {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border: 1px solid #bae6fd; padding: 24px; border-radius: 16px; margin-bottom: 30px;
    }
    .data-box h4 { margin: 0 0 16px 0; color: #0369a1; font-size: 16px; display: flex; align-items: center; gap: 8px; }
    .data-item { margin-bottom: 12px; display: flex; flex-direction: column; gap: 4px; }
    .data-item:last-child { margin-bottom: 0; }
    .data-item span { font-size: 13px; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; }
    .data-item strong { font-size: 16px; color: #0f172a; }
    .data-note { margin-top: 16px; padding-top: 16px; border-top: 1px dashed #bae6fd; font-size: 13px; color: #0284c7; }

    /* --- BUTTONS --- */
    .btn-main {
        width: 100%; padding: 16px; background: linear-gradient(135deg, #0ea5e9, #0369a1);
        color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 800;
        cursor: pointer; transition: 0.2s ease; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
        display: flex; justify-content: center; align-items: center; gap: 8px;
    }
    .btn-main:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4); }
    
    .btn-cek { background:  #0ea5e9, #0369a1; box-shadow: 0 4px 15px rgba(30, 41, 59, 0.2); }
    .btn-cek:hover { background:  #0ea5e9, #0369a1; box-shadow: 0 8px 25px rgba(30, 41, 59, 0.3); }

    .btn-back {
        display: inline-flex; align-items: center; gap: 8px;
        color: #64748b; text-decoration: none; font-weight: 700;
        font-size: 14.5px; margin-bottom: 20px; transition: color 0.2s ease;
    }
    .btn-back:hover { color: #0ea5e9, #0369a1; }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px; }
        .tarif-hero h1 { font-size: 28px; }
        .bn-card { padding: 24px; }
        .form-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="bn-page">

    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Layanan Administratif</span>
        <h1>Pengajuan Balik Nama</h1>
        <p>Proses pembaruan data kepemilikan sambungan air secara mudah dan transparan.</p>
    </div>

    <div class="bn-wrap">

        {{-- ALERTS GLOBAL --}}
        @if(session('sukses')) 
            <div class="alert-box alert-success">✅ <div>{{ session('sukses') }}</div></div> 
        @endif
        @if(session('error')) 
            <div class="alert-box alert-error">🛑 <div>{{ session('error') }}</div></div> 
        @endif
        @if($errors->any()) 
            <div class="alert-box alert-error">🛑 <div>Cek lagi isian formulir Anda, ada yang belum sesuai format.</div></div> 
        @endif


        {{-- LOGIKA PISAH HALAMAN DIMULAI DI SINI --}}
        @if(!$pelanggan)

            {{-- FASE 1: HANYA MUNCUL JIKA DATA BELUM DICARI / TIDAK KETEMU --}}
            <div class="bn-card" style="max-width: 600px; margin: 0 auto;">
                <h2 class="card-title" style="justify-content: center; margin-bottom: 10px;">
                    🔍 Cari Data Sambungan
                </h2>
                <p style="text-align: center; color: #64748b; margin-bottom: 30px; font-size: 15px;">
                    Masukkan Nomor Pelanggan Anda untuk memulai proses verifikasi Balik Nama.
                </p>

                <form action="{{ route('balik-nama.index') }}" method="GET">
                    <div class="form-group">
                        <input type="text" name="nomor_pelanggan" class="form-control" style="text-align: center; font-weight: bold; font-size: 18px; letter-spacing: 1px;" placeholder="Contoh: 22022004" value="{{ request('nomor_pelanggan') }}" required autocomplete="off">
                    </div>
                    <button type="submit" class="btn-main btn-cek">Verifikasi Nomor Pelanggan</button>
                </form>
            </div>

        @else

            {{-- FASE 2: HASIL PENCARIAN DITEMUKAN --}}
            <a href="{{ route('balik-nama.index') }}" class="btn-back">← Kembali Cari Nomor Lain</a>
            
            @php $tampilForm = true; @endphp

            {{-- AREA STATUS PENGAJUAN --}}
            @if(isset($riwayatPengajuan))
                
                @if($riwayatPengajuan->status == 'Ditolak' || $riwayatPengajuan->status == 'Rejected')
                    <div class="status-alert rejected">
                        <h3>❌ Pengajuan Sebelumnya Ditolak!</h3>
                        <p>Mohon maaf, pengajuan Balik Nama Anda ditolak oleh admin dengan alasan:</p>
                        <div class="reason">"{{ $riwayatPengajuan->alasan_penolakan ?? 'Berkas tidak lengkap atau tidak valid' }}"</div>
                        <div class="footer">👇 Silakan perbaiki dokumen Anda dan ajukan ulang melalui formulir di bawah ini.</div>
                    </div>
                    @php $tampilForm = true; @endphp 

                @elseif($riwayatPengajuan->status == 'Pending')
                    <div class="status-alert pending">
                        <h3>⏳ Sedang Diproses</h3>
                        <p>Pengajuan Balik Nama Anda sedang dalam tahap validasi oleh tim admin. Mohon cek halaman ini secara berkala.</p>
                    </div>
                    @php $tampilForm = false; @endphp 

                @elseif($riwayatPengajuan->status == 'Menunggu Pembayaran')
                    {{-- 🚨 KOTAK BAYAR MIDTRANS (DENGAN LOGIKA SNAP TOKEN) --}}
                    <div class="status-alert pending" style="background: #eff6ff; border-color: #bfdbfe;">
                        <h3 style="color: #1d4ed8;">💳 Berkas Valid! Selesaikan Pembayaran</h3>
                        
                        {{-- JIKA BELUM KLIK BAYAR (TOKEN BELUM ADA) --}}
                        @if(!$riwayatPengajuan->snap_token)
                            <p style="color: #1e40af; margin-bottom: 20px;">Berkas kepemilikan Anda telah divalidasi. Silakan selesaikan pembayaran administrasi sebesar <strong>Rp 27.500</strong> (+ Biaya Layanan Rp 3.000) agar sistem dapat segera merubah data kepemilikan Anda.</p>
                            
                            <form action="{{ route('balik-nama.bayar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_pengajuan" value="{{ $riwayatPengajuan->id }}">
                                <button type="submit" class="btn-main" style="background: linear-gradient(135deg, #10b981, #059669); max-width: 320px; padding: 12px;">
                                    💵 Bayar Rp 30.500 Sekarang
                                </button>
                            </form>

                        {{-- JIKA SUDAH MUNCUL POPUP MIDTRANS (TOKEN SUDAH ADA) --}}
                        @else
                            <p style="color: #1e40af; margin-bottom: 20px;">Anda sudah memilih metode pembayaran. Silakan selesaikan transaksi sebesar <strong>Rp 30.500</strong> atau klik tombol di bawah untuk mengecek status dan mengganti metode pembayaran.</p>
                            
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                {{-- Tombol Lanjut Bayar --}}
                                <button type="button" class="btn-main" onclick="window.snap.pay('{{ $riwayatPengajuan->snap_token }}')" style="background: linear-gradient(135deg, #10b981, #059669); flex: 1; min-width: 220px; padding: 12px;">
                                    💳 Lanjutkan Pembayaran
                                </button>

                                {{-- Tombol Sinkron --}}
                                <form action="{{ route('balik-nama.sinkron') }}" method="POST" style="flex: 1; min-width: 220px;">
                                    @csrf
                                    <input type="hidden" name="id_pengajuan" value="{{ $riwayatPengajuan->id }}">
                                    <button type="submit" class="btn-main" style="background: linear-gradient(135deg, #0ea5e9, #0284c7); width: 100%; padding: 12px;">
                                        🔄 Cek Status Pembayaran
                                    </button>
                                </form>

                                {{-- Tombol Batal --}}
                                <form action="{{ route('balik-nama.batal') }}" method="POST" style="flex: 1; min-width: 220px;">
                                    @csrf
                                    <input type="hidden" name="id_pengajuan" value="{{ $riwayatPengajuan->id }}">
                                    <button type="submit" class="btn-main" onclick="return confirm('Yakin ingin membatalkan metode pembayaran ini?')" style="background: linear-gradient(135deg, #ef4444, #b91c1c); width: 100%; padding: 12px;">
                                        ❌ Ganti Metode / Batal
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    @php $tampilForm = false; @endphp 

                @elseif($riwayatPengajuan->status == 'Selesai' || $riwayatPengajuan->status == 'Approved')
                    <div class="status-alert approved">
                        <h3>🎉 Balik Nama Sukses!</h3>
                        <p>Data kepemilikan sambungan air untuk nomor pelanggan <strong>{{ $pelanggan->nomor_pelanggan }}</strong> telah berhasil diperbarui menjadi atas nama <strong>{{ $riwayatPengajuan->nama_baru }}</strong>. Terima kasih!</p>
                    </div>
                    @php $tampilForm = true; @endphp 
                @endif
            @endif


            {{-- AREA FORM ISIAN BARU (MUNCUL KALAU $tampilForm TRUE) --}}
            @if($tampilForm)
                <div class="bn-card" style="border-top: 5px solid #0ea5e9;">
                    <h2 class="card-title">📝 Lengkapi Data Pemilik Baru</h2>

                    {{-- Kotak Info Data Lama --}}
                    <div class="data-box">
                        <h4>📋 Identitas Pemilik Saat Ini</h4>
                        <div class="data-item">
                            <span>Nama Terdaftar</span>
                            <strong>{{ $pelanggan->nama_lengkap }}</strong>
                        </div>
                        <div class="data-item">
                            <span>Alamat Pemasangan</span>
                            <strong>{{ $pelanggan->alamat_lengkap }}, {{ $pelanggan->kecamatan }}</strong>
                        </div>
                        <div class="data-note">
                            * Jika data lokasi di atas sudah benar, silakan lanjutkan pengisian formulir di bawah ini dengan identitas Anda sebagai pemilik baru.
                        </div>
                    </div>

                    {{-- Form Pengajuan Balik Nama --}}
                    <form action="{{ route('balik-nama.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pelanggan_id" value="{{ $pelanggan->id }}">

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="input-label">Nama Pemilik Baru (Sesuai KTP)</label>
                                <input type="text" name="nama_baru" class="form-control" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="form-group">
                                <label class="input-label">NIK Pemilik Baru (16 Digit)</label>
                                <input type="number" name="nik_baru" class="form-control" placeholder="Masukkan 16 digit NIK" required>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="input-label">Upload Foto KTP Baru</label>
                                <div class="file-upload-box">
                                    <input type="file" name="foto_ktp_baru" class="file-upload-input" accept="image/*" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="input-label">Upload Bukti Kepemilikan (AJB/Sertifikat)</label>
                                <div class="file-upload-box">
                                    <input type="file" name="foto_bukti_kepemilikan" class="file-upload-input" accept="image/*" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-main" style="margin-top: 10px;">
                            Kirim Pengajuan Balik Nama 🚀
                        </button>
                    </form>
                </div>
            @endif

        @endif

    </div>
</div>
{{-- SCRIPT MIDTRANS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

@if(session('snap_token'))
    <script type="text/javascript">
        window.snap.pay('{{ session('snap_token') }}', {
            onSuccess: function(result){
                alert("✅ Pembayaran berhasil! Halaman akan dimuat ulang...");
                window.location.reload();
            },
            onPending: function(result){
                alert("⏳ Anda belum menyelesaikan pembayaran di jendela sebelumnya.");
            },
            onError: function(result){
                alert("❌ Pembayaran gagal!");
            },
            onClose: function(){
                alert('⚠️ Anda menutup popup Midtrans sebelum menyelesaikan pembayaran!');
            }
        });
    </script>
@endif
@endsection