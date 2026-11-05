@extends('layouts.app')

@section('content')

{{-- 🔥 JURUS SAKTI: Panggil data langsung di dalem View tanpa Controller tambahan --}}
@php
    $struktur = \App\Models\GaleriProfil::where('kategori', 'struktur_organisasi')->latest()->first();
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .struktur-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .struktur-page h1, .struktur-page h2, .struktur-page h3 {
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
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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
    .tarif-hero .pb-eyebrow .dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.18);
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
        font-weight: 400;
        max-width: 620px;
        line-height: 1.6;
        position: relative;
        z-index: 1;
    }

    /* --- WRAPPER --- */
    .pb-wrap {
        max-width: 1200px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }

    /* --- IMAGE CARD --- */
    .struktur-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }
    .struktur-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 5px;
        background: linear-gradient(90deg, #0ea5e9, #0369a1);
    }
    
    .struktur-header {
        text-align: center;
        margin-bottom: 32px;
    }
    .struktur-header h2 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 8px 0;
    }
    .struktur-header p {
        font-size: 15px;
        color: #64748b;
        margin: 0;
    }

    .struktur-img-wrapper {
        width: 100%;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 20px;
        box-sizing: border-box;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .struktur-img-wrapper img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .struktur-img-wrapper:hover img {
        transform: scale(1.01); /* Sedikit zoom saat kursor masuk */
    }

    /* --- EMPTY STATE --- */
    .empty-state {
        background: #ffffff;
        border: 2px dashed #cbd5e1;
        border-radius: 20px;
        padding: 80px 20px;
        text-align: center;
        box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.02);
    }
    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: #f0f9ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 24px auto;
        border: 1px solid #bae6fd;
    }
    .empty-state h3 {
        font-size: 22px;
        color: #0f172a;
        margin: 0 0 12px 0;
    }
    .empty-state p {
        font-size: 15px;
        color: #64748b;
        margin: 0;
        line-height: 1.6;
    }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px 20px; }
        .tarif-hero h1 { font-size: 28px; }
        .struktur-card { padding: 24px 20px; }
        .struktur-img-wrapper { padding: 10px; }
        .empty-state { padding: 60px 20px; }
    }
</style>

<div class="struktur-page">
    
    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Struktur Organisasi</span>
        <h1>Bagan Susunan Pengurus</h1>
        <p>Visualisasi struktur komando, hierarki, dan pembagian divisi kerja dalam memastikan berjalannya pelayanan prima di PDAM Tirta Perwitasari.</p>
    </div>

    <div class="pb-wrap">
        
        {{-- Kondisi Jika Gambar Ada --}}
        @if($struktur && $struktur->foto)
            <div class="struktur-card">
                <div class="struktur-header">
                    <h2>Struktur Organisasi Perusahaan</h2>
                    <p>Bagan resmi kepengurusan PDAM Tirta Perwitasari</p>
                </div>
                
                <div class="struktur-img-wrapper">
                    {{-- Path Foto dari Backend dipertahankan --}}
                    <img src="{{ asset('storage/' . $struktur->foto) }}" alt="Bagan Struktur Organisasi PDAM Tirta Perwitasari">
                </div>
            </div>

        {{-- Kondisi Jika Gambar Belum Diupload Admin --}}
        @else
            <div class="empty-state">
                <div class="empty-state-icon">🗺️</div>
                <h3>Bagan Struktur Belum Tersedia</h3>
                <p>Admin belum mengunggah gambar bagan struktur organisasi.<br>Silakan tambahkan melalui Dashboard Manajemen.</p>
            </div>
        @endif

    </div>
</div>

@endsection