@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc; /* Latar belakang off-white elegan */
    }

    .direksi-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .direksi-page h1, .direksi-page h2, .direksi-page h3, .direksi-page h4 {
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

    /* --- PROFILE CARDS (HORIZONTAL) --- */
    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        display: flex;
        overflow: hidden;
        margin-bottom: 40px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .profile-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(3, 105, 161, 0.12);
    }
    
    .profile-image-wrapper {
        width: 320px;
        flex-shrink: 0;
        background: #e0f2fe; /* Warna fallback kalau gambar belum ada */
        position: relative;
        border-right: 1px solid #f1f5f9;
    }
    .profile-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
    }
    .profile-image-wrapper::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 40%;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.4), transparent);
    }
    
    .profile-content {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex-grow: 1;
    }
    
    .profile-badge {
        display: inline-block;
        background: #f0f9ff;
        color: #0369a1;
        padding: 6px 14px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 12.5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        width: fit-content;
        border: 1px solid #bae6fd;
    }
    
    .profile-content h2 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
    }
    
    .profile-title {
        font-size: 16px;
        font-weight: 700;
        color: #0ea5e9;
        margin: 0 0 20px 0;
    }
    
    .profile-desc {
        font-size: 15px;
        line-height: 1.7;
        color: #475569;
        margin: 0 0 20px 0;
    }
    
    .profile-highlights {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .profile-highlights li {
        position: relative;
        padding-left: 26px;
        margin-bottom: 12px;
        font-size: 14.5px;
        color: #334155;
        line-height: 1.5;
    }
    .profile-highlights li:last-child {
        margin-bottom: 0;
    }
    .profile-highlights li::before {
        content: '✓';
        position: absolute;
        left: 0;
        top: 0;
        color: #ffffff;
        background: #0ea5e9;
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 10px;
        font-weight: bold;
        margin-top: 3px;
    }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 860px) {
        .profile-image-wrapper { width: 280px; }
        .profile-content { padding: 32px; }
    }
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px 20px; }
        .tarif-hero h1 { font-size: 28px; }
        
        .profile-card { flex-direction: column; }
        .profile-image-wrapper { 
            width: 100%; 
            height: 320px; 
            border-right: none;
            border-bottom: 1px solid #f1f5f9;
        }
        .profile-content { padding: 24px; }
        .profile-content h2 { font-size: 22px; }
    }
</style>

<div class="direksi-page">
    
    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Manajemen</span>
        <h1>Dewan Pengawas & Direksi</h1>
        <p>Mengenal lebih dekat para pemangku amanah di balik tata kelola perusahaan yang profesional dan pelayanan prima PDAM Tirta Perwitasari.</p>
    </div>

    <div class="pb-wrap">

        <!-- ================= CARD 1: DEWAN PENGAWAS ================= -->
        <div class="profile-card">
            <!-- Ganti src dengan path foto asli Bapak Wiyoto Harjono -->
            <div class="profile-image-wrapper">
                <img src="{{ asset('img/foto_profil.jpg') }}" alt="Wiyoto Harjono, S.T. - Dewan Pengawas">
            </div>
            <div class="profile-content">
                <span class="profile-badge">Masa Jabatan 2025 - 2029</span>
                <h2>Wiyoto Harjono, S.T.</h2>
                <div class="profile-title">Dewan Pengawas (Dewas)</div>
                <p class="profile-desc">
                    Menduduki jabatan Dewan Pengawas Perumda Air Minum Tirta Perwitasari untuk periode 2025-2029. Memiliki rekam jejak panjang di pemerintahan dan turut terlibat aktif dalam pengawasan proyek strategis pipanisasi SPAM Regional Keburejo.
                </p>
                <ul class="profile-highlights">
                    <li>Memastikan tata kelola perusahaan (Good Corporate Governance) berjalan akuntabel.</li>
                    <li>Mendorong sinergi dan kolaborasi manajemen demi terwujudnya kualitas, kuantitas, dan kontinuitas layanan air.</li>
                    <li>Turut mengemban amanah sebagai Kepala Dinas Lingkungan Hidup dan Perikanan (DLHP) Kabupaten Purworejo.</li>
                </ul>
            </div>
        </div>

        <!-- ================= CARD 2: DIREKTUR ================= -->
        <div class="profile-card">
            <!-- Ganti src dengan path foto asli Bapak Hermawan Wahyu Utomo -->
            <div class="profile-image-wrapper">
                <img src="{{ asset('img/foto_profil.jpg') }}" alt="Hermawan Wahyu Utomo, S.T., M.Si. - Direktur">
            </div>
            <div class="profile-content">
                <span class="profile-badge">Periode Ketiga: 2024 - 2029</span>
                <h2>Hermawan Wahyu Utomo, S.T., M.Si.</h2>
                <div class="profile-title">Direktur</div>
                <p class="profile-desc">
                    Tengah mengemban amanah sebagai Direktur untuk periode ketiganya, berkat pencapaian kinerja luar biasa yang berhasil menempatkan PDAM Tirta Perwitasari pada Peringkat 3 Nasional kategori pelanggan di bawah 50.000 SR.
                </p>
                <ul class="profile-highlights">
                    <li>Memegang prinsip kerja tanggap dan "Gerak Cepat" dalam menindaklanjuti kebutuhan maupun gangguan pelanggan.</li>
                    <li>Sukses membawa berbagai inovasi teknologi ke dalam sistem pelayanan dan operasional PDAM.</li>
                    <li>Saat ini juga dipercaya menjabat sebagai Sekretaris Pengurus Daerah (PD) PERPAMSI Jawa Tengah periode 2026-2030.</li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection