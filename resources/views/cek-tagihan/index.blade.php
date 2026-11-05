@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .tagihan-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .tagihan-page h1, .tagihan-page h2 {
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
        margin-bottom: 50px; /* HAPUS MARGIN NEGATIF, GANTI JADI JARAK NORMAL */
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

    /* --- FORM BOX --- */
    .cek-container {
        max-width: 540px;
        margin: 0 auto 100px auto; /* Jarak bawah digedein (100px) biar footer aman */
        padding: 40px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px -10px rgba(3, 105, 161, 0.15);
        position: relative;
        z-index: 10;
        border: 1px solid #e2e8f0;
    }
    .cek-container::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 5px;
        background: linear-gradient(90deg, #0ea5e9, #0369a1);
        border-radius: 20px 20px 0 0;
    }
    
    .title-cek {
        text-align: center;
        color: #0f172a;
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 8px 0;
    }
    .desc-cek {
        text-align: center;
        color: #64748b;
        margin-bottom: 32px;
        font-size: 15px;
        line-height: 1.6;
    }

    /* --- ALERTS --- */
    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        text-align: center;
        font-weight: 600;
        font-size: 14.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    /* --- FORM CONTROL --- */
    .form-group {
        margin-bottom: 20px;
    }
    .form-control-custom {
        width: 100%;
        padding: 16px 20px;
        font-size: 16px;
        font-family: inherit;
        font-weight: 600;
        color: #334155;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.2s ease;
        box-sizing: border-box;
        background: #f8fafc;
        text-align: center;
        letter-spacing: 1px;
    }
    .form-control-custom::placeholder {
        color: #94a3b8;
        font-weight: 500;
        letter-spacing: normal;
    }
    .form-control-custom:focus {
        border-color: #0ea5e9;
        outline: none;
        background: #ffffff;
        box-shadow: 0 0 0 4px #e0f2fe;
    }
    
    .btn-cek {
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
    }
    .btn-cek:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
    }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px 20px; }
        .tarif-hero h1 { font-size: 28px; }
        .cek-container { margin: 0 20px 80px 20px; padding: 32px 24px; }
        .title-cek { font-size: 22px; }
    }
</style>

<div class="tagihan-page">

    <div class="tarif-hero">
        <span class="pb-eyebrow">Layanan Pelanggan</span>
        <h1>Cek Tagihan Air Bulanan</h1>
        <p>Akses informasi rinci tagihan air Anda dengan cepat dan mudah.</p>
    </div>

    <div class="cek-container">
        <h2 class="title-cek">🔍 Cek Tagihan Air</h2>
        <p class="desc-cek">Masukkan Nomor Pelanggan / Sambungan Anda pada kolom di bawah untuk melihat rincian tagihan aktif maupun riwayat pembayaran.</p>

        @if(session('error'))
            <div class="alert-error">
                <span>⚠️</span> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('cek-tagihan.proses') }}" method="GET">
            <div class="form-group">
                <input type="text" name="nomor_pelanggan" class="form-control-custom" placeholder="Contoh: 0102030405" required autocomplete="off">
            </div>
            <button type="submit" class="btn-cek">Cek Tagihan Sekarang</button>
        </form>
    </div>

</div>

@endsection