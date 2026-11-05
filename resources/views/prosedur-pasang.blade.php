@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    /* ============================================
       Selaras dengan style.css (var(--primary-blue),
       var(--dark-blue), var(--text-dark), var(--white))
       ============================================ */
    body {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .pb-page h1, .pb-page h2, .pb-page h3 {
        font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
        letter-spacing: -0.01em;
    }

    /* --- HERO --- */
    .tarif-hero {
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        background: linear-gradient(160deg, #0c4a6e 0%, var(--dark-blue, #0369a1) 55%, var(--primary-blue, #0ea5e9) 100%);
        padding: 72px 24px;
        text-align: center;
        margin-bottom: 50px; /* HAPUS MARGIN 0, GANTI JADI JARAK AMAN */
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
        margin-bottom: 16px;
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
        margin: 0 0 12px 0;
        font-size: 34px;
        font-weight: 800;
        letter-spacing: -0.5px;
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
        max-width: 1100px;
        margin: 0 auto 60px auto;
        padding: 0 20px;
        box-sizing: border-box;
    }
    .pb-intro {
        max-width: 760px;
        margin: 0 auto 46px auto; /* HAPUS MARGIN NEGATIF (-34px) */
        background: #ffffff;
        border-radius: 16px;
        padding: 22px 26px;
        text-align: center;
        box-shadow: 0 12px 30px -8px rgba(3, 105, 161, 0.18);
        border: 1px solid #e2e8f0;
        position: relative;
        z-index: 2;
    }
    .pb-intro p {
        margin: 0;
        color: var(--text-dark, #1e293b);
        font-size: 15px;
        line-height: 1.7;
    }
    .pb-intro strong { color: var(--dark-blue, #0369a1); }

    .pb-section-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--text-dark, #1e293b);
        margin: 0 0 22px 0;
        text-align: center;
    }

    /* --- 4 LANGKAH --- */
    .pb-steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 22px;
        margin-bottom: 46px;
    }
    .step-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 40px 20px 28px 20px;
        text-align: center;
        box-shadow: 0 10px 25px -5px rgba(3, 105, 161, 0.08);
        border: 1px solid #f1f5f9;
        position: relative;
        transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s ease;
    }
    .step-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 34px -6px rgba(3, 105, 161, 0.18);
    }
    .step-badge {
        background: linear-gradient(135deg, var(--primary-blue, #0ea5e9), var(--dark-blue, #0369a1));
        color: white;
        width: 34px; height: 34px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 15px;
        position: absolute;
        top: -14px; right: 18px;
        box-shadow: 0 4px 10px rgba(3, 105, 161, 0.35);
        border: 3px solid white;
    }
    .step-icon {
        font-size: 38px;
        margin-bottom: 14px;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .step-card:hover .step-icon { transform: scale(1.12) rotate(-4deg); }
    .step-card h3 {
        color: var(--text-dark, #0f172a);
        margin: 0 0 8px 0;
        font-size: 17px;
    }
    .step-card p {
        color: #64748b;
        font-size: 13.5px;
        line-height: 1.6;
        margin: 0;
    }

    /* --- CALLOUT: SAPA APP + MOBIL TANGKI --- */
    .pb-callouts {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        margin-bottom: 46px;
    }
    .callout-card {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 14px;
        padding: 22px 24px;
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }
    .callout-card .callout-icon {
        flex-shrink: 0;
        width: 44px; height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
    }
    .callout-card h4 {
        margin: 0 0 4px 0;
        font-size: 15px;
        color: var(--text-dark, #1e293b);
        font-weight: 700;
    }
    .callout-card p {
        margin: 0;
        font-size: 13.5px;
        color: #475569;
        line-height: 1.6;
    }
    .callout-card a.callout-link {
        display: inline-block;
        margin-top: 8px;
        font-size: 13px;
        font-weight: 700;
        color: var(--dark-blue, #0369a1);
        text-decoration: none;
    }
    .callout-card a.callout-link:hover { text-decoration: underline; }

    /* --- PERSYARATAN & BANTUAN --- */
    .pb-grid-2 {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 26px;
        margin-bottom: 36px;
        align-items: stretch;
    }
    .pb-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(3, 105, 161, 0.08);
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .pb-card-header {
        background: linear-gradient(135deg, var(--primary-blue, #0ea5e9), var(--dark-blue, #0369a1));
        color: white;
        padding: 18px 24px;
        font-weight: 700;
        font-size: 17px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .pb-card-body { padding: 24px; }
    .pb-req-list {
        list-style: none;
        padding: 0; margin: 0;
        color: #475569;
        font-size: 14.5px;
        line-height: 1.7;
    }
    .pb-req-list li {
        display: flex;
        gap: 12px;
        margin-bottom: 14px;
    }
    .pb-req-list li:last-child { margin-bottom: 0; }
    .pb-req-list li span.check {
        color: var(--primary-blue, #0ea5e9);
        font-size: 17px;
        flex-shrink: 0;
    }

    .pb-help-card {
        background: linear-gradient(135deg, #0c4a6e 0%, var(--dark-blue, #0369a1) 60%, var(--primary-blue, #0ea5e9) 100%);
        color: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(3, 105, 161, 0.3);
        padding: 32px 28px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .pb-help-card h3 {
        margin: 0 0 12px 0;
        font-size: 22px;
    }
    .pb-help-card p {
        margin: 0 0 20px 0;
        font-size: 14.5px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.85);
    }
    .pb-wa-btn {
        background: rgba(15, 23, 42, 0.55);
        color: white;
        text-decoration: none;
        padding: 14px 18px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 14px;
        width: fit-content;
        max-width: 100%;
        transition: background 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
        margin-bottom: 14px;
    }
    .pb-wa-btn:hover { background: rgba(15, 23, 42, 0.75); transform: translateY(-2px); }
    .pb-wa-btn .wa-icon { font-size: 24px; flex-shrink: 0; }
    .pb-wa-btn .wa-label { font-size: 11.5px; color: rgba(255,255,255,0.65); margin-bottom: 2px; }
    .pb-wa-btn .wa-number { font-size: 16px; font-weight: bold; letter-spacing: 0.4px; }

    .pb-office-info {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding-top: 14px;
        font-size: 13px;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.85);
    }
    .pb-office-info div { display: flex; gap: 8px; }

    /* --- SLOGAN --- */
    .pb-slogan {
        background: #f0f9ff;
        border: 1px dashed var(--primary-blue, #0ea5e9);
        color: var(--dark-blue, #0369a1);
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        font-style: italic;
        font-weight: bold;
        font-size: 15px;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 860px) {
        .pb-grid-2 { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .tarif-hero { padding: 56px 20px; }
        .tarif-hero h1 { font-size: 26px; }
        .tarif-hero p { font-size: 14px; }
        .pb-intro { margin-top: 0; padding: 18px 20px; } /* HAPUS MARGIN NEGATIF (-26px) */
    }
    @media (max-width: 480px) {
        .tarif-hero { padding: 48px 16px; }
        .tarif-hero h1 { font-size: 22px; }
        .pb-wa-btn { width: 100%; }
        .pb-wa-btn .wa-number { font-size: 15px; word-break: break-word; }
        .pb-help-card, .pb-card-body { padding: 24px 20px; }
    }
</style>

<div class="pb-page">

    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>PDAM Tirta Perwitasari &middot; Kabupaten Purworejo</span>
        <h1>Prosedur Pasang Pipa Baru</h1>
        <p>Langkah mudah menjadi bagian dari keluarga besar pelanggan PDAM Tirta Perwitasari, melayani seluruh wilayah Kabupaten Purworejo.</p>
    </div>

    <div class="pb-wrap">

        <div class="pb-intro">
            <p>PDAM Tirta Perwitasari adalah <strong>Perusahaan Daerah Air Minum resmi Kabupaten Purworejo</strong> yang telah melayani masyarakat sejak tahun 1925. Ikuti 4 langkah berikut untuk mengajukan sambungan air bersih baru ke rumah atau tempat usaha Anda.</p>
        </div>

        <div class="pb-steps">

            <div class="step-card">
                <div class="step-badge">1</div>
                <div class="step-icon">📝</div>
                <h3>Pendaftaran</h3>
                <p>Isi formulir dan lengkapi berkas persyaratan di kantor terdekat, atau daftar online melalui Web ini atau aplikasi SAPA Purworejo.</p>
            </div>

            <div class="step-card">
                <div class="step-badge">2</div>
                <div class="step-icon">🔍</div>
                <h3>Survei</h3>
                <p>Petugas kami akan mengecek ketersediaan jaringan pipa PDAM di lokasi Anda.</p>
            </div>

            <div class="step-card">
                <div class="step-badge">3</div>
                <div class="step-icon">💳</div>
                <h3>Pembayaran</h3>
                <p>Lakukan pembayaran biaya pemasangan sesuai hasil survei.</p>
            </div>

            <div class="step-card">
                <div class="step-badge">4</div>
                <div class="step-icon">🚰</div>
                <h3>Pemasangan</h3>
                <p>Instalasi sambungan baru dilakukan, dan dilanjutkan aktivasi status pelanggan.</p>
            </div>

        </div>

        <div class="pb-callouts">
            <div class="callout-card">
                <div class="callout-icon">📲</div>
                <div>
                    <h4>Daftar Online lewat SAPA Purworejo</h4>
                    <p>Selain datang ke kantor, pendaftaran sambungan baru juga bisa dilakukan lewat aplikasi resmi SAPA Purworejo — satu aplikasi untuk cek tagihan, lapor gangguan, hingga pasang baru.</p>
                    <a href="https://play.google.com/store/apps/details?id=id.co.perumdaairminumpurworejo.sapapurworejo" target="_blank" rel="noopener" class="callout-link">Unduh di Google Play ➔</a>
                </div>
            </div>
            <div class="callout-card">
                <div class="callout-icon">🚛</div>
                <div>
                    <h4>Belum Terjangkau Jaringan Pipa?</h4>
                    <p>Untuk lokasi yang belum tercakup jaringan perpipaan, PDAM Tirta Perwitasari juga menyediakan layanan suplai air bersih menggunakan mobil tangki.</p>
                </div>
            </div>
        </div>

        <div class="pb-grid-2">

            <div class="pb-card">
                <div class="pb-card-header">
                    <span>📋</span> Persyaratan Dokumen
                </div>
                <div class="pb-card-body">
                    <ul class="pb-req-list">
                        <li><span class="check">✔️</span> Fotokopi KTP Pemohon yang masih berlaku (1 lembar).</li>
                        <li><span class="check">✔️</span> Nomor kontak pemohon yang aktif (WhatsApp/Telp).</li>
                        <li><span class="check">✔️</span> Denah lokasi atau rekening air tetangga terdekat.</li>
                        <li><span class="check">✔️</span> Materai 10.000 untuk formulir pendaftaran.</li>
                        <li><span class="check">✔️</span> Foto rumah/lokasi yang akan dipasang sambungan.</li>
                    </ul>
                </div>
            </div>

            <div class="pb-help-card">
                <h3>Butuh Bantuan?</h3>
                <p>Tim layanan pelanggan kami siap membantu Anda menyelesaikan proses pendaftaran. Hubungi kami untuk informasi lebih lanjut.</p>

                <a href="https://wa.me/62895623300101" target="_blank" rel="noopener" class="pb-wa-btn">
                    <span class="wa-icon">💬</span>
                    <div>
                        <div class="wa-label">WhatsApp Official</div>
                        <div class="wa-number">0895 6233 00101</div>
                    </div>
                </a>

                <div class="pb-office-info">
                    <div>📍 <span>Jl. Jenderal Sudirman No. 101, Pangenjurutengah, Kec. Purworejo, Kab. Purworejo, Jawa Tengah 54114</span></div>
                    <div>☎️ <span>(0275) 321050 &nbsp;(Call Center, jam kerja)</span></div>
                    <div>✉️ <span>pdampurworejo@yahoo.com</span></div>
                </div>
            </div>

        </div>

        <div class="pb-slogan">
            "PDAM Tirta Perwitasari: Setia Melayani, Mengalirkan Kehidupan"
        </div>

    </div>
</div>
@endsection