@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    .kontak-page, .kontak-page * { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
    .kontak-page h1, .kontak-page h2, .kontak-page h3 { font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }

    /* --- HERO --- */
    .tarif-hero {
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        background: linear-gradient(160deg, #0c4a6e 0%, var(--dark-blue, #0369a1) 50%, var(--primary-blue, #0ea5e9) 100%);
        padding: 72px 24px;
        text-align: center;
        margin-bottom: 44px;
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
    .tarif-hero .kontak-eyebrow {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 7px 16px; border-radius: 999px;
        background: rgba(255, 255, 255, 0.14); border: 1px solid rgba(255, 255, 255, 0.28);
        color: #ffffff; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase;
        margin-bottom: 16px; position: relative; z-index: 1;
    }
    .tarif-hero .kontak-eyebrow .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.18); }
    .tarif-hero h1 { color: #ffffff; margin: 0 0 12px 0; font-size: 34px; font-weight: 800; letter-spacing: -0.5px; position: relative; z-index: 1; }
    .tarif-hero p { color: rgba(255, 255, 255, 0.85); margin: 0 auto; font-size: 16px; font-weight: 400; max-width: 620px; line-height: 1.6; position: relative; z-index: 1; }

    /* --- CONTAINER --- */
    .kontak-container { max-width: 1100px; margin: 0 auto 80px auto; padding: 0 20px; box-sizing: border-box; }

    /* --- QUICK CONTACT CARDS --- */
    .kontak-quick-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin: 0 0 46px 0;
    }
    .kq-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 26px 20px;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 12px 26px -8px rgba(3, 105, 161, 0.18);
        border: 1px solid #e2e8f0;
        transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .kq-card:hover { transform: translateY(-6px); box-shadow: 0 18px 34px -8px rgba(3, 105, 161, 0.24); border-color: #93c5fd; }
    .kq-card .kq-icon {
        width: 52px; height: 52px; margin: 0 auto 14px auto;
        border-radius: 14px;
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        display: flex; align-items: center; justify-content: center;
        font-size: 24px;
    }
    .kq-card h4 { margin: 0 0 4px 0; font-size: 14.5px; color: var(--text-dark, #1e293b); font-weight: 700; }
    .kq-card p { margin: 0; font-size: 13px; color: #64748b; word-break: break-word; }

    /* --- MAIN GRID: INFO + MAP --- */
    .kontak-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1.1fr;
        gap: 26px;
        align-items: stretch;
    }

    .kontak-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px -5px rgba(3, 105, 161, 0.08);
        overflow: hidden;
    }
    .kontak-card-header {
        background: linear-gradient(135deg, var(--primary-blue, #0ea5e9), var(--dark-blue, #0369a1));
        color: white; padding: 18px 24px; font-weight: 700; font-size: 16px;
        display: flex; align-items: center; gap: 10px;
    }
    .kontak-card-body { padding: 24px; }

    .kontak-info-list { list-style: none; padding: 0; margin: 0; }
    .kontak-info-list li {
        display: flex; gap: 14px; padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px; color: #334155; line-height: 1.6;
    }
    .kontak-info-list li:last-child { border-bottom: none; padding-bottom: 0; }
    .kontak-info-list .ki-icon {
        flex-shrink: 0; width: 36px; height: 36px; border-radius: 10px;
        background: #f0f9ff; display: flex; align-items: center; justify-content: center; font-size: 17px;
    }
    .kontak-info-list .ki-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; color: #94a3b8; margin-bottom: 2px; }
    .kontak-info-list .ki-value { color: var(--text-dark, #1e293b); font-weight: 500; }

    .kontak-branch-note {
        margin-top: 18px;
        background: #f0f9ff;
        border: 1px dashed #bae6fd;
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 13px;
        color: #0369a1;
        line-height: 1.6;
    }

    .kontak-map { width: 100%; height: 100%; min-height: 340px; border: 0; display: block; }

    /* --- LAYANAN CEPAT --- */
    .kontak-services {
        margin-top: 30px;
    }
    .kontak-services h3 { font-size: 17px; color: var(--text-dark, #1e293b); margin: 0 0 16px 0; }
    .ks-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .ks-card {
        background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px;
        padding: 18px 20px; text-decoration: none; display: flex; align-items: center; gap: 12px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .ks-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px -6px rgba(3, 105, 161, 0.18); }
    .ks-card .ks-icon { font-size: 22px; }
    .ks-card span.ks-label { font-size: 13.5px; font-weight: 600; color: var(--dark-blue, #0369a1); }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 900px) {
        .kontak-quick-grid { grid-template-columns: repeat(2, 1fr); }
        .kontak-grid-2 { grid-template-columns: 1fr; }
        .kontak-map { min-height: 280px; }
    }
    @media (max-width: 768px) {
        .tarif-hero { padding: 56px 20px; }
        .tarif-hero h1 { font-size: 26px; }
        .tarif-hero p { font-size: 14px; }
        .ks-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .tarif-hero { padding: 48px 16px; }
        .tarif-hero h1 { font-size: 22px; }
        .kontak-quick-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
        .kq-card { padding: 20px 14px; }
        .kontak-card-body { padding: 20px; }
    }
</style>

<div class="kontak-page">

    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="kontak-eyebrow"><span class="dot"></span>PDAM Tirta Perwitasari &middot; Kabupaten Purworejo</span>
        <h1>Hubungi Kami</h1>
        <p>Ada pertanyaan seputar layanan air bersih? Tim PDAM Tirta Perwitasari siap membantu Anda melalui berbagai kanal berikut.</p>
    </div>

    <div class="kontak-container">

        <!-- QUICK CONTACT CARDS -->
        <div class="kontak-quick-grid">
            <a href="https://wa.me/62895623300101" target="_blank" rel="noopener" class="kq-card">
                <div class="kq-icon">💬</div>
                <h4>WhatsApp</h4>
                <p>0895 6233 00101</p>
            </a>
            <a href="tel:+622753210501" class="kq-card">
                <div class="kq-icon">☎️</div>
                <h4>Telepon</h4>
                <p>(0275) 321050</p>
            </a>
            <a href="mailto:pdampurworejo@yahoo.com" class="kq-card">
                <div class="kq-icon">✉️</div>
                <h4>Email</h4>
                <p>pdampurworejo@yahoo.com</p>
            </a>
            <a href="https://instagram.com/pdam.purworejo" target="_blank" rel="noopener" class="kq-card">
                <div class="kq-icon">📷</div>
                <h4>Instagram</h4>
                <p>@pdam.purworejo</p>
            </a>
        </div>

        <!-- INFO + MAP -->
        <div class="kontak-grid-2">
            <div class="kontak-card">
                <div class="kontak-card-header">
                    <span>🏢</span> Kantor Pusat
                </div>
                <div class="kontak-card-body">
                    <ul class="kontak-info-list">
                        <li>
                            <div class="ki-icon">📍</div>
                            <div>
                                <div class="ki-label">Alamat</div>
                                <div class="ki-value">Jl. Jenderal Sudirman No. 101, Pangenjurutengah, Kec. Purworejo, Kab. Purworejo, Jawa Tengah 54114</div>
                            </div>
                        </li>
                        <li>
                            <div class="ki-icon">☎️</div>
                            <div>
                                <div class="ki-label">Telepon</div>
                                <div class="ki-value">(0275) 321050 / 323766</div>
                            </div>
                        </li>
                        <li>
                            <div class="ki-icon">✉️</div>
                            <div>
                                <div class="ki-label">Email</div>
                                <div class="ki-value">pdampurworejo@yahoo.com</div>
                            </div>
                        </li>
                        <li>
                            <div class="ki-icon">🕒</div>
                            <div>
                                <div class="ki-label">Jam Operasional</div>
                                <div class="ki-value">Senin - Jumat, 08:00 - 15:00 WIB</div>
                            </div>
                        </li>
                    </ul>

                    <div class="kontak-branch-note">
                        📌 PDAM Tirta Perwitasari juga memiliki kantor cabang di beberapa kecamatan untuk memudahkan pelayanan, salah satunya <strong>Kantor Cabang Kutoarjo</strong> di Jl. Marditomo No. 2, Kutoarjo — yang melayani wilayah Kutoarjo dan sekitarnya.
                    </div>
                </div>
            </div>

            <div class="kontak-card">
                <iframe
                    class="kontak-map"
                    src="https://maps.google.com/maps?q=PDAM%20Tirta%20Perwitasari%2C%20Jl.%20Jenderal%20Sudirman%20No.%20101%2C%20Purworejo&z=15&output=embed"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi Kantor Pusat PDAM Tirta Perwitasari Purworejo">
                </iframe>
            </div>
        </div>

        <!-- LAYANAN CEPAT -->
        <div class="kontak-services">
            <h3>Butuh Layanan Lain?</h3>
            <div class="ks-grid">
                <a href="/pengaduan" class="ks-card">
                    <span class="ks-icon">📢</span>
                    <span class="ks-label">Lapor Gangguan / Pengaduan</span>
                </a>
                <a href="/pasang-baru" class="ks-card">
                    <span class="ks-icon">🚰</span>
                    <span class="ks-label">Pasang Sambungan Baru</span>
                </a>
                <a href="/cek-tagihan" class="ks-card">
                    <span class="ks-icon">🧾</span>
                    <span class="ks-label">Cek Tagihan Bulanan</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection