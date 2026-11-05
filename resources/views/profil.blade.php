@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    /* Tambahan: Kasih background halaman sedikit off-white biar card putihnya nonjol */
    body {
        background-color: #f8fafc; 
    }

    .profil-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .profil-page h1, .profil-page h2, .profil-page h3, .profil-page h4 {
        font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
        letter-spacing: -0.01em;
    }

    /* --- HERO SECTION --- */
    .tarif-hero {
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        background: linear-gradient(160deg, #0c4a6e 0%, #0369a1 55%, #0ea5e9 100%);
        padding: 80px 24px; /* Padding atas bawah digedein dikit biar lega */
        text-align: center;
        margin-bottom: 40px; /* Jarak antara hero dengan konten di bawahnya */
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

    /* --- WRAPPER & TYPOGRAPHY --- */
    .pb-wrap {
        max-width: 1000px;
        margin: 0 auto 60px auto; /* HAPUS MARGIN MINUS - Biar kontennya turun natural */
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }
    .section-title {
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
    .divider {
        border: 0;
        border-top: 2px dashed #cbd5e1;
        margin: 48px 0;
    }

    /* --- TIMELINE SEJARAH --- */
    .timeline-container {
        background: #ffffff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); /* Shadow diperhalus biar gak terlalu tajam */
        border: 1px solid #e2e8f0;
        margin-bottom: 40px;
    }
    .timeline-item {
        display: flex;
        gap: 24px;
        margin-bottom: 32px;
        position: relative;
    }
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 40px;
        bottom: -40px;
        width: 2px;
        background: #e2e8f0;
    }
    .timeline-item:last-child::before {
        display: none;
    }
    .timeline-icon {
        width: 42px;
        height: 42px;
        background: #e0f2fe;
        color: #0369a1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        flex-shrink: 0;
        border: 4px solid #ffffff;
        box-shadow: 0 0 0 1px #bae6fd;
        position: relative;
        z-index: 2;
    }
    .timeline-content {
        background: #ffffff; /* Ubah ke putih bersih */
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        flex-grow: 1;
        display: flex;
        gap: 20px;
        align-items: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .timeline-content:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px -6px rgba(3, 105, 161, 0.12);
        border-color: #cbd5e1;
    }
    .timeline-content img {
        width: 160px;
        height: 110px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
        background-color: #f1f5f9; /* Placeholder warna kalau gambar belum load */
    }
    .timeline-text h3 {
        color: #0369a1;
        margin: 0 0 6px 0;
        font-size: 18px;
    }
    .timeline-text h3 span {
        color: #0f172a;
        font-size: 16px;
        font-weight: 600;
    }
    .timeline-text p {
        margin: 0;
        color: #475569;
        font-size: 14.5px;
        line-height: 1.6;
    }

    /* --- GRID VISI MISI & TUJUAN --- */
    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
        align-items: stretch;
    }
    .card {
        background: #ffffff;
        border-radius: 16px;
        padding: 32px 28px;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(3, 105, 161, 0.15);
    }
    .card.blue-card {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border-color: #bae6fd;
    }
    .card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }
    .card-icon {
        font-size: 26px;
    }
    .card h3 {
        margin: 0;
        color: #0f172a;
        font-size: 20px;
    }
    .blue-card h3 {
        color: #0369a1;
    }
    .card p.italic-text {
        font-size: 16.5px;
        color: #0c4a6e;
        font-style: italic;
        font-weight: 500;
        line-height: 1.7;
        margin: 0;
    }
    .card ul, .card ol {
        margin: 0;
        padding-left: 20px;
        color: #475569;
        font-size: 14.5px;
        line-height: 1.7;
    }
    .card ul li, .card ol li {
        margin-bottom: 8px;
    }

    /* --- CORE VALUES --- */
    .core-values {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
    }
    .value-chip {
        background: #0ea5e9;
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.2);
    }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 860px) {
        .grid-2 { grid-template-columns: 1fr; }
        .timeline-content { flex-direction: column; align-items: flex-start; text-align: left; }
        .timeline-content img { width: 100%; height: auto; max-height: 160px; }
    }
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px 20px; }
        .tarif-hero h1 { font-size: 28px; }
        .pb-wrap { padding: 0 16px; }
        .timeline-container { padding: 24px 20px; }
        .timeline-item { gap: 16px; }
        .timeline-item::before { left: 16px; }
        .timeline-icon { width: 34px; height: 34px; font-size: 14px; }
        .card { padding: 24px 20px; }
    }
</style>

<div class="profil-page">
    
    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Tentang Kami</span>
        <h1>Profil Perusahaan</h1>
        <p>Mengenal lebih dekat perjalanan panjang, dedikasi, serta komitmen PDAM Tirta Perwitasari dalam melayani kebutuhan air bersih masyarakat Kabupaten Purworejo.</p>
    </div>

    <div class="pb-wrap">
        
        <div class="timeline-container">
            <h2 class="section-title">Rekam Jejak & Sejarah</h2>
            
            <div class="timeline-item">
                <div class="timeline-icon">25</div>
                <div class="timeline-content">
                    <img src="{{ asset('img/image.png') }}" alt="Awal Mula USAM">
                    <div class="timeline-text">
                        <h3>1925 <span>- Awal Mula (USAM)</span></h3>
                        <p>Awal mula sistem penyediaan air bersih di wilayah Purworejo pada masa Hindia Belanda dengan nama Unit Saluran Air Minum (USAM), membangun jaringan pipa dari sumber mata air Kalinongko menuju Tuksongo.</p>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-icon">74</div>
                <div class="timeline-content">
                    <img src="{{ asset('img/image2.png') }}" alt="Lahirnya PDAM">
                    <div class="timeline-text">
                        <h3>1974 <span>- Pendirian PDAM</span></h3>
                        <p>Pemerintah Daerah Kabupaten Purworejo secara resmi mendirikan Perusahaan Daerah Air Minum (PDAM) melalui Perda No. 85 Tahun 1974 sebagai tonggak kemandirian pengelolaan air bersih.</p>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-icon">19</div>
                <div class="timeline-content">
                    <img src="{{ asset('img/image3.png') }}" alt="Perubahan Status">
                    <div class="timeline-text">
                        <h3>2019 <span>- Transformasi Perumda</span></h3>
                        <p>Sesuai amanat perundang-undangan, PDAM Kabupaten Purworejo resmi bertransformasi dan berganti nama menjadi Perusahaan Umum Daerah (Perumda) Air Minum Tirta Perwitasari.</p>
                    </div>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-icon">24</div>
                <div class="timeline-content">
                    <img src="{{ asset('img/image4.png') }}" alt="Smart Water Management">
                    <div class="timeline-text">
                        <h3>2024 <span>- Peringkat 3 Nasional</span></h3>
                        <p>Menginjak usia 50 tahun, PDAM Tirta Perwitasari sukses melayani lebih dari 40.000 pelanggan dan berhasil meraih Peringkat 3 Nasional untuk kinerja terbaik dengan jumlah pelanggan di bawah 50 ribu SR.</p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="section-title">Visi & Misi</h2>
        <div class="grid-2">
            <div class="card blue-card">
                <div class="card-header">
                    <span class="card-icon">🔭</span>
                    <h3>Visi Perusahaan</h3>
                </div>
                <p class="italic-text">"Menjadi Perumda Air Minum Yang Profesional Dan Mandiri Menuju Terwujudnya Pelayanan Prima."</p>
            </div>
            <div class="card">
                <div class="card-header">
                    <span class="card-icon">🎯</span>
                    <h3>Misi Perusahaan</h3>
                </div>
                <ul>
                    <li>Mengupayakan sumber air baku untuk meningkatkan cakupan pelayanan di seluruh kecamatan.</li>
                    <li>Meningkatkan kualitas pelayanan air minum yang memenuhi aspek Kualitas, Kuantitas, dan Kontinuitas (K3).</li>
                    <li>Meningkatkan sinergitas dan kerjasama dengan semua stakeholder untuk terwujudnya layanan yang optimal.</li>
                </ul>
            </div>
        </div>

        <hr class="divider">

        <h2 class="section-title">Tujuan & Budaya Kerja</h2>
        <div class="grid-2">
            <div class="card">
                <div class="card-header">
                    <span class="card-icon">📈</span>
                    <h3>Tujuan Perusahaan</h3>
                </div>
                <ol>
                    <li>Memenuhi kebutuhan masyarakat berupa penyediaan air minum dan air bersih yang bermutu bagi pemenuhan hajat hidup masyarakat.</li>
                    <li>Turut serta dalam melaksanakan pembangunan daerah dan meningkatkan Pendapatan Asli Daerah (PAD).</li>
                </ol>
            </div>
            <div class="card">
                <div class="card-header">
                    <span class="card-icon">💎</span>
                    <h3>Budaya Kerja PRIMA</h3>
                </div>
                <p style="margin-top: 0; color: #475569; font-size: 14.5px;">Menerapkan budaya kerja utama dalam menjalankan tugas dan kewajiban bagi seluruh insan Perumda Air Minum Tirta Perwitasari:</p>
                <div class="core-values">
                    <span class="value-chip">Profesional</span>
                    <span class="value-chip">Responsif</span>
                    <span class="value-chip">Integritas</span>
                    <span class="value-chip">Mandiri</span>
                    <span class="value-chip">Akuntabel</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection