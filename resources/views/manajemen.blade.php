@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .mgmt-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .mgmt-page h1, .mgmt-page h2, .mgmt-page h3, .mgmt-page h4 {
        font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
        letter-spacing: -0.01em;
    }

    /* --- HERO SECTION (TETAP) --- */
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
        max-width: 1000px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }

    .section-title {
        text-align: left;
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 28px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .section-title::before {
        content: '';
        display: block;
        width: 6px;
        height: 24px;
        background: #0ea5e9;
        border-radius: 4px;
    }

    /* --- DIRECTORY LIST LAYOUT (NEW) --- */
    .mgmt-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .mgmt-row {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
        padding: 32px;
        display: flex;
        align-items: stretch; /* Biar tinggi seimbang */
        gap: 32px;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .mgmt-row:hover {
        transform: translateX(4px);
        box-shadow: 0 10px 25px -5px rgba(3, 105, 161, 0.1);
        border-color: #cbd5e1;
    }

    /* Aksen garis kiri kecil */
    .mgmt-row::before {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 0;
        width: 4px;
        background: #0ea5e9;
        border-radius: 16px 0 0 16px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .mgmt-row:hover::before {
        opacity: 1;
    }

    /* Bagian Kiri: Info Utama */
    .mgmt-info {
        flex: 1;
        display: flex;
        gap: 20px;
    }
    
    .mgmt-avatar {
        width: 56px; height: 56px;
        background: #f0f9ff;
        color: #0369a1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
        flex-shrink: 0;
        border: 1px solid #bae6fd;
    }

    .mgmt-details h2 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
    }
    .mgmt-details h3 {
        font-size: 13.5px;
        font-weight: 700;
        color: #0ea5e9;
        margin: 0 0 12px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .mgmt-details p {
        font-size: 14.5px;
        line-height: 1.6;
        color: #475569;
        margin: 0;
    }

    /* Bagian Kanan: Sub-Bagian (Chips) */
    .mgmt-subs {
        width: 320px;
        flex-shrink: 0;
        border-left: 1px dashed #cbd5e1;
        padding-left: 32px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .mgmt-subs-title {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 12px;
    }

    .chip-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .chip-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .chip-item::before {
        content: '•';
        color: #0ea5e9;
        font-size: 18px;
        line-height: 1;
    }
    .mgmt-row:hover .chip-item {
        background: #fff;
        border-color: #bae6fd;
    }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 860px) {
        .mgmt-row {
            flex-direction: column;
            gap: 24px;
            padding: 24px;
        }
        .mgmt-subs {
            width: 100%;
            border-left: none;
            border-top: 1px dashed #cbd5e1;
            padding-left: 0;
            padding-top: 24px;
        }
    }
    @media (max-width: 480px) {
        .tarif-hero { padding: 64px 20px 48px 20px; }
        .tarif-hero h1 { font-size: 28px; }
        .mgmt-info { flex-direction: column; gap: 16px; }
        .mgmt-avatar { width: 48px; height: 48px; font-size: 20px; }
    }
</style>

<div class="mgmt-page">
    
    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Struktur Organisasi</span>
        <h1>Jajaran Manajemen</h1>
        <p>Orang-orang di balik layar yang memastikan roda operasional, distribusi air bersih, dan layanan administrasi PDAM Tirta Perwitasari berjalan secara optimal setiap harinya.</p>
    </div>

    <div class="pb-wrap">
        
        <h2 class="section-title">Manajemen Eksekutif Operasional</h2>

        <div class="mgmt-list">

            <!-- KABAG TEKNIK -->
            <div class="mgmt-row">
                <div class="mgmt-info">
                    <div class="mgmt-avatar"></div>
                    <div class="mgmt-details">
                        <h2>Susanto</h2>
                        <h3>Kepala Bagian Teknik</h3>
                        <p>Bertanggung jawab atas kelancaran operasional hulu ke hilir, mulai dari instalasi produksi, distribusi pipa, hingga pengawasan teknis guna menekan angka kebocoran air.</p>
                    </div>
                </div>
                <div class="mgmt-subs">
                    <div class="mgmt-subs-title">Membawahi Sub-Bagian:</div>
                    <div class="chip-list">
                        <div class="chip-item">Subbag Produksi</div>
                        <div class="chip-item">Subbag Perencana & Pengawasan</div>
                        <div class="chip-item">Subbag Penanggulangan Kehilangan Air</div>
                    </div>
                </div>
            </div>

            <!-- KABAG ADM & KEUANGAN -->
            <div class="mgmt-row">
                <div class="mgmt-info">
                    <div class="mgmt-avatar"></div>
                    <div class="mgmt-details">
                        <h2>Muslih Sujarwo, S.E.</h2>
                        <h3>Kabag Adm. & Keuangan</h3>
                        <p>Mengelola tata laksana administrasi perusahaan, kepegawaian, hingga manajemen finansial. Memastikan kelancaran sistem penagihan dan akuntansi perusahaan.</p>
                    </div>
                </div>
                <div class="mgmt-subs">
                    <div class="mgmt-subs-title">Membawahi Sub-Bagian:</div>
                    <div class="chip-list">
                        <div class="chip-item">Subbag Umum & Kepegawaian</div>
                        <div class="chip-item">Subbag Keuangan</div>
                        <div class="chip-item">Subbag PDE</div>
                    </div>
                </div>
            </div>

            <!-- SPI -->
            <div class="mgmt-row">
                <div class="mgmt-info">
                    <div class="mgmt-avatar"></div>
                    <div class="mgmt-details">
                        <h2>Eko Teguh P, S.E.</h2>
                        <h3>Kepala SPI</h3>
                        <p>Memimpin Satuan Pengawas Internal secara independen untuk melakukan audit, kontrol kinerja, serta memastikan setiap prosedur dijalankan akuntabel tanpa menyalahi regulasi.</p>
                    </div>
                </div>
                <div class="mgmt-subs">
                    <div class="mgmt-subs-title">Fokus Tugas Utama:</div>
                    <div class="chip-list">
                        <div class="chip-item">Audit Internal Mutu</div>
                        <div class="chip-item">Evaluasi Kinerja Mutu</div>
                        <div class="chip-item">Pengawasan Regulasi</div>
                    </div>
                </div>
            </div>

            <!-- KEPALA CABANG -->
            <div class="mgmt-row">
                <div class="mgmt-info">
                    <div class="mgmt-avatar"></div>
                    <div class="mgmt-details">
                        <h2>Kepala Cabang</h2>
                        <h3>Area Purworejo & Sekitarnya</h3>
                        <p>Garda terdepan yang bersentuhan dengan masyarakat kecamatan. Memastikan respon cepat terhadap keluhan pelanggan dan kelancaran distribusi air cakupan.</p>
                    </div>
                </div>
                <div class="mgmt-subs">
                    <div class="mgmt-subs-title">Membawahi Urusan:</div>
                    <div class="chip-list">
                        <div class="chip-item">Urusan Administrasi Cabang</div>
                        <div class="chip-item">Urusan Teknik Cabang</div>
                    </div>
                </div>
            </div>

        </div> <!-- End List -->

    </div>
</div>
@endsection