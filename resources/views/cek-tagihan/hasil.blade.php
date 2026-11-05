@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .hasil-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .hasil-page h1, .hasil-page h2, .hasil-page h3, .hasil-page h4 {
        font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
        letter-spacing: -0.01em;
    }

    /* --- HERO SECTION --- */
    .tarif-hero {
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        background: linear-gradient(160deg, #0c4a6e 0%, #0369a1 55%, #0ea5e9 100%);
        padding: 60px 24px;
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
    .tarif-hero h1 {
        color: #ffffff; margin: 0 0 10px 0; font-size: 32px; font-weight: 800; position: relative; z-index: 1;
    }
    .tarif-hero p {
        color: rgba(255, 255, 255, 0.85); margin: 0 auto; font-size: 15px; position: relative; z-index: 1;
    }

    /* --- CONTAINER --- */
    .hasil-container {
        max-width: 900px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
    }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        font-size: 14.5px;
        margin-bottom: 24px;
        transition: color 0.2s ease;
    }
    .btn-back:hover { color: #0f172a; }

    /* --- IDENTITAS CARD --- */
    .info-card {
        background: linear-gradient(135deg, #0ea5e9, #0369a1);
        color: white;
        padding: 32px;
        border-radius: 20px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px -5px rgba(3, 105, 161, 0.2);
        display: flex;
        flex-direction: column;
        gap: 12px;
        position: relative;
        overflow: hidden;
    }
    .info-card::after {
        content: '💧';
        position: absolute;
        right: 20px; bottom: -20px;
        font-size: 120px;
        opacity: 0.1;
        pointer-events: none;
    }
    .info-card h3 {
        margin: 0; font-size: 24px; font-weight: 800; display: flex; align-items: center; gap: 10px;
    }
    .info-card p {
        margin: 0; font-size: 15px; opacity: 0.9; display: flex; align-items: center; gap: 8px;
    }
    .info-card .nomor-badge {
        background: rgba(255,255,255,0.2);
        padding: 4px 12px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 16px;
        font-weight: bold;
    }

    /* --- SECTION TITLE --- */
    .section-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* --- TAGIHAN CARD --- */
    .tagihan-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px -3px rgba(0,0,0,0.03);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.2s ease, box-shadow 0.2s;
    }
    .tagihan-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(0,0,0,0.08);
        border-color: #cbd5e1;
    }
    
    .tagihan-detail h4 {
        margin: 0 0 8px 0; color: #0f172a; font-size: 18px;
    }
    .tagihan-detail p {
        margin: 0; color: #64748b; font-size: 14.5px;
    }
    
    .tagihan-harga {
        font-size: 26px;
        font-weight: 800;
        color: #ef4444; /* Merah untuk tunggakan */
        text-align: right;
        margin-bottom: 12px;
    }
    .harga-lunas { color: #10b981; } /* Hijau untuk lunas */

    /* --- BADGE --- */
    .badge {
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .badge-hijau { background: #dcfce3; color: #166534; border: 1px solid #bbf7d0; }

    /* --- BUTTONS --- */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
    }
    .btn-bayar {
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-primary { background: #0ea5e9; color: white; box-shadow: 0 2px 8px rgba(14,165,233,0.3); }
    .btn-primary:hover { background: #0284c7; }
    
    .btn-warning { background: #f59e0b; color: white; box-shadow: 0 2px 8px rgba(245,158,11,0.3); }
    .btn-warning:hover { background: #d97706; }
    
    .btn-outline { background: white; color: #64748b; border: 1px solid #cbd5e1; }
    .btn-outline:hover { background: #f1f5f9; color: #0f172a; }
    
    .btn-danger-outline { background: white; color: #ef4444; border: 1px solid #fca5a5; }
    .btn-danger-outline:hover { background: #fef2f2; }
    
    .btn-success { background: #10b981; color: white; text-decoration: none; }
    .btn-success:hover { background: #059669; }

    /* --- ALERTS --- */
    .alert-success {
        background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;
        padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; text-align: center;
    }

    /* --- EMPTY STATE --- */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        background: white;
        border-radius: 16px;
        border: 2px dashed #cbd5e1;
        margin-bottom: 24px;
    }
    .empty-state h4 { color: #0f172a; margin: 16px 0 8px 0; font-size: 20px; }
    .empty-state p { color: #64748b; margin: 0; }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 768px) {
        .tarif-hero { padding: 48px 20px; }
        .tarif-hero h1 { font-size: 26px; }
        
        .tagihan-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
            padding: 20px;
        }
        .tagihan-detail { width: 100%; }
        .tagihan-harga { text-align: left; margin-bottom: 0; font-size: 24px; }
        .action-buttons { width: 100%; }
        .action-buttons form, .btn-bayar { flex: 1; width: 100%; text-align: center; }
        
        .info-card { padding: 24px; }
        .info-card h3 { font-size: 20px; }
    }
</style>

<div class="hasil-page">

    <div class="tarif-hero">
        <h1>Rincian Tagihan Air</h1>
        <p>Informasi detail penggunaan air dan riwayat pembayaran pelanggan.</p>
    </div>

    <div class="hasil-container">
        
        <a href="{{ route('cek-tagihan.index') }}" class="btn-back">← Kembali ke Pencarian</a>

        {{-- INFO PELANGGAN --}}
        <div class="info-card">
            <h3>👤 {{ $pelanggan->nama_lengkap }}</h3>
            <p>No. Sambungan: <span class="nomor-badge">{{ $pelanggan->nomor_pelanggan }}</span></p>
            <p>📍 {{ $pelanggan->alamat }}</p>
        </div>

        {{-- BAGIAN TAGIHAN AKTIF --}}
        <h2 class="section-title">🔴 Tagihan Belum Dibayar</h2>
        
        @if(session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Forelse Tagihan Aktif Bawaan Backend --}}
        @forelse($tagihan_aktif as $aktif)
            <div class="tagihan-card">
                
                <div class="tagihan-detail">
                    <h4>Bulan: {{ \Carbon\Carbon::parse($aktif->bulan_tagihan)->format('F Y') }}</h4>
                    <p>Pemakaian: <strong>{{ $aktif->pemakaian }} m³</strong> (Awal: {{ $aktif->meteran_awal }} - Akhir: {{ $aktif->meteran_akhir }})</p>
                    
                    {{-- AREA TOMBOL AKSI MIDTRANS --}}
                    <div class="action-buttons">
                        {{-- Logika IF bawaan dipertahankan --}}
                        <form action="{{ route('cek-tagihan.bayar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_tagihan" value="{{ $aktif->id }}">
                            
                            @if($aktif->status == 'Pending')
                                <button type="submit" class="btn-bayar btn-warning">💳 Lanjutkan Pembayaran</button>
                            @else
                                <button type="submit" class="btn-bayar btn-primary">Pilih Metode Bayar</button>
                            @endif
                        </form>

                        @if($aktif->status == 'Pending')
                            <form action="{{ route('cek-tagihan.sinkron') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_tagihan" value="{{ $aktif->id }}">
                                <button type="submit" class="btn-bayar btn-outline">🔄 Cek Status</button>
                            </form>

                            <form action="{{ route('cek-tagihan.batal') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_tagihan" value="{{ $aktif->id }}">
                                <button type="submit" class="btn-bayar btn-danger-outline" onclick="return confirm('Yakin ingin membatalkan pilihan metode bayar sebelumnya?')">✖ Batal</button>
                            </form>
                        @endif
                    </div>
                </div>
                
                {{-- HARGA --}}
                <div style="text-align: right;">
                    <div class="tagihan-harga">Rp {{ number_format($aktif->total_tagihan, 0, ',', '.') }}</div>
                </div>

            </div>
            
        @empty
            <div class="empty-state">
                <span style="font-size: 40px;">🎉</span>
                <h4>Tidak Ada Tunggakan!</h4>
                <p>Semua tagihan air Anda bulan ini sudah lunas. Terima kasih atas ketepatan waktunya.</p>
            </div>
        @endforelse

        {{-- BAGIAN RIWAYAT LUNAS --}}
        <h2 class="section-title" style="margin-top: 60px;">✅ Riwayat Pembayaran (Lunas)</h2>
        
        @forelse($riwayat_lunas as $lunas)
            <div class="tagihan-card" style="border-left: 4px solid #10b981;">
                <div class="tagihan-detail">
                    <h4>Bulan: {{ \Carbon\Carbon::parse($lunas->bulan_tagihan)->format('F Y') }}</h4>
                    <p style="margin-bottom: 10px;">Pemakaian: <strong>{{ $lunas->pemakaian }} m³</strong> (Awal: {{ $lunas->meteran_awal }} - Akhir: {{ $lunas->meteran_akhir }})</p>
                    <span class="badge badge-hijau">✔ Lunas</span>
                </div>
                
                <div style="text-align: right;">
                    <div class="tagihan-harga harga-lunas">Rp {{ number_format($lunas->total_tagihan, 0, ',', '.') }}</div>
                    <a href="{{ route('cek-tagihan.cetak', $lunas->id) }}" target="_blank" class="btn-bayar btn-success">📥 Cetak Kwitansi</a>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 20px; color: #94a3b8; font-weight: 500;">
                Belum ada riwayat pembayaran yang tercatat dalam sistem.
            </div>
        @endforelse

    </div>
</div>

{{-- SCRIPT MIDTRANS (LOGIKA BAWAAN DIPERTAHANKAN) --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

@if(session('snap_token'))
<script>
    window.onload = function() {
        snap.pay('{{ session('snap_token') }}', {
            onSuccess: function(result){
                alert("Pembayaran Berhasil! Sistem akan mengupdate status secara otomatis."); 
                window.location.reload();
            },
            onPending: function(result){
                alert("Silakan lanjutkan pembayaran Anda."); 
            },
            onError: function(result){
                alert("Terjadi kesalahan pada pembayaran!"); 
            },
            onClose: function(){
                alert('Anda menutup halaman sebelum menyelesaikan pembayaran.');
            }
        });
    };
</script>
@endif

@endsection