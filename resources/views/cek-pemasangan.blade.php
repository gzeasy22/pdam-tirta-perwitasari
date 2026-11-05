@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .lacak-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .lacak-page h1, .lacak-page h2, .lacak-page h3, .lacak-page h4 {
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
        margin-bottom: 50px; /* HAPUS MARGIN NEGATIF, GANTI JADI POSITIF */
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

    /* --- MAIN CARD --- */
    .lacak-wrap {
        max-width: 700px;
        margin: 0 auto 100px auto; /* TAMBAH JARAK BAWAH BIAR FOOTER AMAN */
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }
    .lacak-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px -10px rgba(3, 105, 161, 0.15);
        border: 1px solid #e2e8f0;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }
    .lacak-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 5px;
        background: linear-gradient(90deg, #0ea5e9, #0369a1);
    }

    /* --- ALERTS --- */
    .alert-box {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14.5px;
        font-weight: 600;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        line-height: 1.5;
    }
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }

    /* --- FORM SEARCH --- */
    .search-title { text-align: center; color: #0f172a; font-size: 26px; font-weight: 800; margin: 0 0 10px 0; }
    .search-desc { text-align: center; color: #64748b; font-size: 15px; margin-bottom: 30px; }
    
    .form-control-lacak {
        width: 100%;
        padding: 18px 24px;
        font-size: 18px;
        font-family: inherit;
        font-weight: 700;
        color: #1e293b;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        text-align: center;
        letter-spacing: 1.5px;
        transition: all 0.2s ease;
        box-sizing: border-box;
        margin-bottom: 20px;
    }
    .form-control-lacak::placeholder { color: #94a3b8; font-weight: 500; letter-spacing: normal; font-size: 16px; }
    .form-control-lacak:focus { outline: none; background: #ffffff; border-color: #0ea5e9; box-shadow: 0 0 0 4px #e0f2fe; }

    /* --- BUTTONS --- */
    .btn-main {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #0ea5e9, #0369a1);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16.5px;
        font-weight: 800;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-main:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4); }

    /* --- USER DETAIL INFO --- */
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px dashed #cbd5e1;
        padding-bottom: 20px;
        margin-bottom: 24px;
    }
    .detail-header h2 { font-size: 20px; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px; }
    .btn-back {
        background: #f1f5f9; color: #475569; text-decoration: none; padding: 8px 16px; border-radius: 8px;
        font-size: 13.5px; font-weight: 700; border: 1px solid #cbd5e1; transition: all 0.2s;
    }
    .btn-back:hover { background: #e2e8f0; color: #0f172a; }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        margin-bottom: 30px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
    }
    .info-item { display: flex; flex-direction: column; gap: 4px; }
    .info-item span { font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-item strong { font-size: 16px; font-weight: 700; color: #0f172a; }

    /* --- STATUS BOXES --- */
    .status-box {
        padding: 30px;
        border-radius: 16px;
        border: 1px solid transparent;
        position: relative;
        overflow: hidden;
    }
    .status-title { font-size: 22px; font-weight: 800; margin: 0 0 12px 0; display: flex; align-items: center; gap: 10px; }
    .status-desc { font-size: 15px; line-height: 1.6; margin: 0; }

    /* Status: Rejected */
    .status-rejected { background: #fef2f2; border-color: #fecaca; }
    .status-rejected .status-title { color: #dc2626; }
    .status-rejected .status-desc { color: #7f1d1d; }
    .reason-box { background: #fff; padding: 16px; border-radius: 12px; border: 1px solid #fecaca; margin-top: 20px; font-size: 14px; color: #991b1b; }
    
    /* Status: Approved (Selesai) */
    .status-approved { background: #f0fdf4; border-color: #bbf7d0; text-align: center; }
    .status-approved .status-title { justify-content: center; color: #16a34a; }
    .status-approved .status-desc { color: #166534; }
    .nopel-box { background: #fff; border: 2px dashed #22c55e; padding: 24px; font-size: 36px; font-weight: 800; color: #15803d; border-radius: 12px; margin: 20px 0; letter-spacing: 2px; font-family: monospace; }

    /* Status: Waiting (Menunggu Survei) */
    .status-waiting { background: #fffbeb; border-color: #fde68a; }
    .status-waiting .status-title { color: #d97706; }
    .status-waiting .status-desc { color: #92400e; }

    /* Status: Unpaid (Belum Bayar) */
    .status-unpaid { background: #ffffff; border-color: #e2e8f0; box-shadow: 0 4px 20px -5px rgba(0,0,0,0.05); }
    .status-unpaid .status-title { color: #ef4444; }
    .status-unpaid .status-desc { color: #475569; }
    .price-tag { font-size: 34px; font-weight: 800; color: #0f172a; margin: 12px 0 24px 0; }
    
    .action-grid { display: flex; flex-direction: column; gap: 12px; margin-top: 24px; }
    .action-grid-row { display: flex; gap: 12px; }
    .action-grid-row form { flex: 1; }
    
    .btn-action { width: 100%; padding: 14px; border: none; border-radius: 10px; font-size: 14.5px; font-weight: 700; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-sizing: border-box; }
    .btn-pay { background: #10b981; color: white; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); font-size: 16px; padding: 16px; }
    .btn-pay:hover { background: #059669; }
    .btn-doc { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
    .btn-doc:hover { background: #e2e8f0; color: #0f172a; }
    .btn-sync { background: #0ea5e9; color: white; }
    .btn-sync:hover { background: #0284c7; }
    .btn-cancel { background: white; color: #ef4444; border: 1px solid #fca5a5; }
    .btn-cancel:hover { background: #fef2f2; }

    /* Status: Lunas */
    .status-paid { background: #f0f9ff; border-color: #bae6fd; }
    .status-paid .status-title { color: #0284c7; }
    .status-paid .status-desc { color: #075985; }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px 20px; }
        .tarif-hero h1 { font-size: 28px; }
        .lacak-wrap { margin-bottom: 60px; }
        .lacak-card { padding: 24px; margin: 0 10px; }
        .detail-header { flex-direction: column; align-items: flex-start; gap: 16px; }
        .status-box { padding: 20px; }
        .price-tag { font-size: 28px; }
        .action-grid-row { flex-direction: column; }
        .nopel-box { font-size: 28px; padding: 16px; }
    }
</style>

<div class="lacak-page">
    
    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow">Layanan Pelanggan</span>
        <h1>Cek Status Pasang Baru</h1>
        <p>Pantau progres pendaftaran, hasil survei, hingga proses pembayaran instalasi pipa air Anda secara transparan.</p>
    </div>

    <div class="lacak-wrap">
        <div class="lacak-card">

            {{-- ERROR / SUCCESS ALERTS --}}
            @if(session('error'))
                <div class="alert-box alert-error">
                    <span style="font-size: 20px;">❌</span> 
                    <div><strong>Pencarian Gagal:</strong> <br> {{ session('error') }}</div>
                </div>
            @endif

            @if(session('sukses'))
                <div class="alert-box alert-success">
                    <span style="font-size: 20px;">✅</span> 
                    <div><strong>Berhasil:</strong> <br> {{ session('sukses') }}</div>
                </div>
            @endif

            {{-- KONDISI 1: FORM PENCARIAN (BELUM ADA DATA) --}}
            @if(!isset($data))
                <div style="margin-bottom: 30px;">
                    <h2 class="search-title">🔍 Cari Data Pendaftar</h2>
                    <p class="search-desc">Masukkan 16 digit NIK KTP Anda yang terdaftar pada sistem kami untuk melacak status pemasangan.</p>
                </div>

                <form action="{{ route('cek-pemasangan.index') }}" method="GET">
                    <input type="text" name="nik" class="form-control-lacak" placeholder="Contoh: 3301234567890001" value="{{ request('nik') }}" required autocomplete="off">
                    <button type="submit" class="btn-main">Lacak Status Saya</button>
                </form>

            {{-- KONDISI 2: HASIL PENCARIAN DITEMUKAN --}}
            @else
                
                <div class="detail-header">
                    <h2>📄 Detail Pemohon</h2>
                    <a href="{{ route('cek-pemasangan.index') }}" class="btn-back">← Cari NIK Lain</a>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <span>NIK KTP Pendaftar</span>
                        <strong>{{ $data->nik }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Nama Lengkap</span>
                        <strong>{{ $data->nama_lengkap }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Alamat Lokasi Pemasangan</span>
                        <strong>{{ $data->alamat_lengkap }}</strong>
                    </div>
                </div>

                {{-- STATUS 1: REJECTED --}}
                @if($data->status == 'Rejected')
                    <div class="status-box status-rejected">
                        <h3 class="status-title">❌ Pengajuan Ditolak</h3>
                        <p class="status-desc">Mohon maaf, pengajuan pemasangan baru Anda tidak dapat diproses lebih lanjut.</p>
                        <div class="reason-box">
                            <strong>Alasan Penolakan:</strong> <br>
                            {{ $data->alasan_penolakan ?? 'Tidak ada keterangan tambahan dari petugas.' }}
                        </div>
                    </div>
            
                {{-- STATUS 2: APPROVED (SELESAI) --}}
                @elseif($data->status == 'Approved')
                    <div class="status-box status-approved">
                        <h3 class="status-title">🎉 Pemasangan Selesai!</h3>
                        <p class="status-desc">Selamat, sambungan air Anda telah aktif sepenuhnya.</p>
                        <div class="nopel-box">{{ $data->nomor_pelanggan }}</div>
                        <p class="status-desc">Ini adalah <strong>Nomor Pelanggan</strong> resmi Anda. Simpan dan gunakan nomor tersebut untuk keperluan pembayaran tagihan air bulanan.</p>
                    </div>

                {{-- STATUS 3: MENUNGGU SURVEI --}}
                @elseif(empty($data->total_tagihan_pasang))
                    <div class="status-box status-waiting">
                        <h3 class="status-title">⏳ Menunggu Hasil Survei</h3>
                        <p class="status-desc">Pendaftaran Anda sedang diproses. Petugas kami akan segera menjadwalkan atau sedang melakukan survei ke lokasi Anda. <br><br> Tagihan biaya Rencana Anggaran Biaya (RAB) akan muncul di halaman ini setelah hasil survei divalidasi oleh tim admin kami.</p>
                    </div>
                
                {{-- STATUS 4: BELUM BAYAR (TAGIHAN MUNCUL) --}}
                @elseif($data->status_pembayaran_pasang == 'Belum Bayar')
                    <div class="status-box status-unpaid">
                        <h3 class="status-title">⚠️ Tagihan Belum Dibayar</h3>
                        <p class="status-desc">Survei lapangan telah selesai. Berikut adalah total biaya Rencana Anggaran Biaya (RAB) pemasangan Anda beserta biaya layanan:</p>
                        
                        {{-- 🚨 LOGIKA UI BIAYA ADMIN 3000 --}}
                        <div class="price-tag" style="margin-bottom: 30px;">
                            Rp {{ number_format($data->total_tagihan_pasang + 3000, 0, ',', '.') }}
                            <div style="font-size: 13px; font-weight: 600; color: #64748b; margin-top: 8px;">
                                *Rincian: RAB Rp {{ number_format($data->total_tagihan_pasang, 0, ',', '.') }} + Admin Rp 3.000
                            </div>
                        </div>
                        
                        <div class="action-grid">
                            <a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_rab', 'nama_file' => $data->foto_rab]) }}" target="_blank" class="btn-action btn-doc">
                                📄 Buka Dokumen Rincian RAB
                            </a>

                            <button id="pay-button" class="btn-action btn-pay">
                                💳 Lanjutkan ke Pembayaran
                            </button>

                            <div class="action-grid-row">
                                <form action="{{ route('cek-pemasangan.sinkron') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="nik" value="{{ $data->nik }}">
                                    <button type="submit" class="btn-action btn-sync">🔄 Cek Status Bayar</button>
                                </form>

                                <form action="{{ route('cek-pemasangan.batal') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="nik" value="{{ $data->nik }}">
                                    <button type="submit" onclick="return confirm('Yakin ingin mereset/mengganti metode pembayaran?')" class="btn-action btn-cancel">❌ Ganti Metode</button>
                                </form>
                            </div>
                        </div>
                    </div>

                {{-- STATUS 5: LUNAS --}}
                @elseif($data->status_pembayaran_pasang == 'Lunas')
                    <div class="status-box status-paid">
                        <h3 class="status-title">✅ Pembayaran Berhasil!</h3>
                        <p class="status-desc">Pembayaran Anda sebesar <strong>Rp {{ number_format($data->total_tagihan_pasang + 3000, 0, ',', '.') }}</strong> telah sukses diverifikasi oleh sistem.<br><br>Saat ini tim teknis kami sedang menyusun jadwal pemasangan pipa di lokasi Anda. Silakan cek halaman ini secara berkala untuk mendapatkan Nomor Pelanggan resmi setelah instalasi selesai.</p>
                    </div>
                @endif

            @endif 

        </div>
    </div>
</div>

{{-- SCRIPT MIDTRANS (LOGIKA BAWAAN DIPERTAHANKAN) --}}
@if(isset($snapToken))
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        var payButton = document.getElementById('pay-button');
        if(payButton) {
            payButton.onclick = function(){
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result){
                        alert("Pembayaran berhasil! Sistem sedang memproses data Anda.");
                        window.location.reload();
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran Anda. Silakan selesaikan tagihan melalui metode yang Anda pilih.");
                    },
                    onError: function(result){
                        alert("Pembayaran gagal!");
                    },
                    onClose: function(){
                        alert('Anda menutup jendela pembayaran sebelum menyelesaikannya.');
                    }
                });
            };
        }
    </script>
@endif

@endsection