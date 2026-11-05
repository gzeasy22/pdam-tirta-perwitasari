<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal layanan resmi PDAM Tirta Perwitasari Kabupaten Purworejo — cek tagihan, lapor gangguan, dan pasang sambungan baru air bersih secara online.">
    <title>PDAM Tirta Perwitasari Purworejo | Portal Layanan Pelanggan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* ============================================
           ANIMATION LAYER — tidak mengubah style.css
           ============================================ */

        /* --- Scroll reveal --- */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-left {
            opacity: 0;
            transform: translateX(-28px);
            transition: opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* Stagger delay untuk grid items */
        .stagger-1 { transition-delay: 0.05s; }
        .stagger-2 { transition-delay: 0.15s; }
        .stagger-3 { transition-delay: 0.25s; }
        .stagger-4 { transition-delay: 0.35s; }
        .stagger-5 { transition-delay: 0.45s; }
        .stagger-6 { transition-delay: 0.55s; }

        /* --- Hero parallax layer --- */
        .hero-section {
            overflow: hidden;
            position: relative;
        }
        .hero-parallax-bg {
            position: absolute;
            inset: -40px;
            background: inherit;
            will-change: transform;
            pointer-events: none;
        }
        /* Floating water bubble decorations */
        .hero-bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            pointer-events: none;
            animation: bubbleFloat linear infinite;
        }
        @keyframes bubbleFloat {
            0%   { transform: translateY(0px) scale(1);   opacity: 0.06; }
            50%  { transform: translateY(-18px) scale(1.04); opacity: 0.10; }
            100% { transform: translateY(0px) scale(1);   opacity: 0.06; }
        }
        .hero-bubble:nth-child(1) { width:90px;  height:90px;  top:12%; left:6%;  animation-duration:7s;  animation-delay:0s; }
        .hero-bubble:nth-child(2) { width:50px;  height:50px;  top:55%; left:15%; animation-duration:5s;  animation-delay:1.2s; }
        .hero-bubble:nth-child(3) { width:130px; height:130px; top:8%;  right:8%; animation-duration:9s;  animation-delay:0.5s; }
        .hero-bubble:nth-child(4) { width:60px;  height:60px;  bottom:20%; right:18%; animation-duration:6s; animation-delay:2s; }
        .hero-bubble:nth-child(5) { width:40px;  height:40px;  top:70%; right:5%; animation-duration:4.5s; animation-delay:0.8s; }

        /* Hero content fade-in on load */
        .hero-content {
            animation: heroFadeUp 0.9s cubic-bezier(0.22, 1, 0.36, 1) both;
            animation-delay: 0.2s;
        }
        @keyframes heroFadeUp {
            from { opacity: 0; transform: translateY(32px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Hero CTA buttons */
        .hero-actions a {
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        }
        .hero-actions a:hover {
            transform: translateY(-2px);
            opacity: 0.92;
        }
        .hero-actions a:active {
            transform: translateY(0px) scale(0.98);
        }

        /* --- Navbar entrance --- */
        .navbar {
            animation: navSlideDown 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
        @keyframes navSlideDown {
            from { opacity: 0; transform: translateY(-100%); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .nav-link {
            transition: color 0.2s ease, background 0.2s ease;
        }

        /* --- Service cards hover --- */
        .service-card {
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1),
                        box-shadow 0.3s ease,
                        border-color 0.3s ease;
            will-change: transform;
            cursor: default;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.10);
            border-color: rgba(14, 165, 233, 0.35); /* selaras --primary-blue, sebelumnya teal & tidak match style.css */
        }
        .service-card .icon-wrapper {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .service-card:hover .icon-wrapper {
            transform: scale(1.15) rotate(-4deg);
        }
        .card-link {
            transition: letter-spacing 0.25s ease, opacity 0.25s ease;
            display: inline-block;
        }
        .service-card:hover .card-link {
            letter-spacing: 0.02em;
            opacity: 0.8;
        }

        /* --- News cards hover --- */
        .news-card {
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1),
                        box-shadow 0.3s ease;
            will-change: transform;
        }
        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.09);
        }
        .news-image img {
            transition: transform 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .news-card:hover .news-image img {
            transform: scale(1.04);
        }
        .news-image {
            overflow: hidden;
        }
        .news-link {
            transition: letter-spacing 0.2s ease;
            display: inline-block;
        }
        .news-card:hover .news-link {
            letter-spacing: 0.02em;
        }

        /* --- Footer links hover --- */
        .site-footer a {
            transition: opacity 0.2s ease, transform 0.2s ease;
            display: inline-block;
        }
        .site-footer a:hover {
            opacity: 0.75;
            transform: translateX(3px);
        }

        /* --- Dropdown menu animasi --- */
        .dropdown-menu {
            transform-origin: top center;
            animation: none;
        }
        .dropdown:hover .dropdown-menu {
            animation: dropdownOpen 0.25s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
        @keyframes dropdownOpen {
            from { opacity: 0; transform: translateY(-8px) scaleY(0.95); }
            to   { opacity: 1; transform: translateY(0)   scaleY(1); }
        }

        /* --- Counter angka --- */
        .counter-target {
            display: inline-block;
        }

        /* --- Section header underline animate --- */
        .section-header h2 {
            position: relative;
            display: inline-block;
        }
        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0%;
            height: 2px;
            background: currentColor;
            opacity: 0.25;
            transition: width 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .section-header.visible h2::after {
            width: 100%;
        }

        /* --- Ripple effect on CTA buttons --- */
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }
        .ripple-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            transform: scale(0);
            animation: rippleAnim 0.55s linear;
            pointer-events: none;
        }
        @keyframes rippleAnim {
            to { transform: scale(4); opacity: 0; }
        }

        /* --- Smooth logo pulse --- */
        .nav-logo .logo-text {
            transition: opacity 0.2s ease;
        }
        .nav-logo:hover .logo-text {
            opacity: 0.8;
        }

        /* ============================================
           PROFESIONALISASI TAMPILAN + KONTEN PURWOREJO
           Layer tambahan — tidak menghapus/mengubah
           aturan style.css maupun struktur backend.
           ============================================ */

        :root {
            --pdam-navy-900: #0c4a6e; /* deep navy, selaras rgba(15,23,42) overlay hero/footer */
            --pdam-blue-700: var(--dark-blue);
            --pdam-blue-500: var(--primary-blue);
            --pdam-blue-100: #e0f2fe; /* = warna icon-wrapper style.css */
            --pdam-ink: var(--text-dark);
            --pdam-slate: #64748b; /* = warna teks muted style.css */
            --pdam-sand: var(--light-bg);
            --pdam-white: var(--white);
            --pdam-radius-lg: 20px;
            --pdam-radius-md: 14px;
            --pdam-shadow-soft: 0 10px 30px rgba(14, 165, 233, 0.08);
            --pdam-shadow-lift: 0 20px 40px rgba(14, 165, 233, 0.16);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }
        h1, h2, h3, h4,
        .logo-text,
        .footer-logo {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -0.01em;
        }

        /* --- Nav logo w/ subtitle kabupaten --- */
        .nav-logo {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        .nav-logo .logo-sub {
            font-size: 0.66rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--pdam-blue-500);
            opacity: 0.85;
        }

        /* --- Hamburger toggle (mobile nav) --- */
        .nav-toggle {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            width: 42px;
            height: 42px;
            border: none;
            background: rgba(14, 165, 233, 0.08);
            border-radius: 10px;
            cursor: pointer;
            padding: 0;
            z-index: 210;
        }
        .nav-toggle span {
            display: block;
            width: 20px;
            height: 2px;
            background: var(--pdam-navy-900);
            border-radius: 2px;
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1),
                        opacity 0.3s ease;
        }
        .nav-toggle[aria-expanded="true"] span:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }
        .nav-toggle[aria-expanded="true"] span:nth-child(2) {
            opacity: 0;
        }
        .nav-toggle[aria-expanded="true"] span:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        /* --- Badge kecil (dipakai di hero & tentang kami) --- */
        .eyebrow-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.28);
            color: inherit;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }
        .eyebrow-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.18);
        }

        /* --- Tentang Kami section --- */
        .about-section {
            padding: 88px 24px;
            background: var(--pdam-sand);
        }
        .about-inner {
            max-width: 1160px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 56px;
            align-items: center;
        }
        .about-inner .eyebrow-badge {
            background: var(--pdam-blue-100);
            border-color: transparent;
            color: var(--pdam-blue-700);
        }
        .about-inner .eyebrow-badge .dot {
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.14);
        }
        .about-copy h2 {
            font-size: clamp(1.7rem, 2.6vw, 2.35rem);
            color: var(--pdam-ink);
            margin-bottom: 16px;
            line-height: 1.25;
        }
        .about-copy p {
            color: var(--pdam-slate);
            line-height: 1.75;
            margin-bottom: 14px;
            font-size: 0.98rem;
        }
        .about-copy p strong {
            color: var(--pdam-navy-900);
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-top: 32px;
        }
        .about-stat-card {
            background: var(--pdam-white);
            border-radius: var(--pdam-radius-md);
            padding: 20px 18px;
            box-shadow: var(--pdam-shadow-soft);
            border: 1px solid rgba(14, 165, 233, 0.10);
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s ease;
        }
        .about-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--pdam-shadow-lift);
        }
        .about-stat-card .stat-number {
            display: flex;
            align-items: baseline;
            gap: 2px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: clamp(1.5rem, 2.6vw, 1.9rem);
            color: var(--pdam-blue-700);
        }
        .about-stat-card .stat-label {
            margin-top: 4px;
            font-size: 0.8rem;
            color: var(--pdam-slate);
            font-weight: 500;
            line-height: 1.4;
        }

        .about-panel {
            position: relative;
            background: linear-gradient(155deg, var(--pdam-navy-900), var(--pdam-blue-700));
            border-radius: var(--pdam-radius-lg);
            padding: 38px 32px;
            color: rgba(255, 255, 255, 0.94);
            box-shadow: var(--pdam-shadow-lift);
            overflow: hidden;
        }
        .about-panel::before {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
            top: -70px;
            right: -60px;
        }
        .about-panel h3 {
            font-size: 1.15rem;
            margin-bottom: 6px;
            position: relative;
        }
        .about-panel .panel-eyebrow {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.62);
            margin-bottom: 14px;
            display: block;
        }
        .about-panel-list {
            list-style: none;
            margin: 18px 0 0;
            padding: 0;
            position: relative;
        }
        .about-panel-list li {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.14);
            font-size: 0.9rem;
            line-height: 1.55;
            color: rgba(255, 255, 255, 0.88);
        }
        .about-panel-list li:first-child {
            border-top: none;
            padding-top: 4px;
        }
        .about-panel-list .li-icon {
            flex-shrink: 0;
            width: 26px;
            height: 26px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.14);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
        }

        /* ============================================
           RESPONSIVE — MOBILE / TABLET
           ============================================ */
        @media (max-width: 1024px) {
            .about-inner {
                grid-template-columns: 1fr;
                gap: 36px;
            }
            .about-panel { order: -1; }
        }

        @media (max-width: 900px) {
            .nav-toggle { display: flex; }

            .nav-menu {
                position: fixed;
                top: 0;
                right: 0;
                height: 100vh;
                width: min(78vw, 320px);
                background: var(--pdam-white);
                flex-direction: column;
                align-items: flex-start;
                gap: 2px;
                padding: 88px 22px 32px;
                box-shadow: -12px 0 40px rgba(15, 23, 42, 0.18);
                transform: translateX(100%);
                transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1);
                overflow-y: auto;
                z-index: 200;
            }
            .nav-menu.is-open {
                transform: translateX(0);
            }
            .nav-menu li { width: 100%; }
            .nav-menu .nav-link {
                display: block;
                width: 100%;
                padding: 13px 4px;
                border-bottom: 1px solid rgba(14, 165, 233, 0.10);
            }
            .dropdown-menu {
                position: static;
                box-shadow: none;
                display: none;
                padding-left: 12px;
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
            .dropdown.is-open .dropdown-menu { display: block; }
            .dropdown:hover .dropdown-menu { animation: none; }

            .nav-scrim {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.45); /* selaras overlay hero-section & site-footer */
                z-index: 190;
            }
            .nav-scrim.is-open { display: block; }

            body.nav-locked { overflow: hidden; }
        }

        @media (max-width: 640px) {
            .about-section { padding: 60px 18px; }
            .about-stats { grid-template-columns: 1fr 1fr; gap: 12px; }
            .about-panel { padding: 30px 24px; }
            .hero-actions { flex-direction: column; align-items: stretch; }
            .services-grid, .news-grid { gap: 18px; }
        }

        @media (max-width: 480px) {
            .about-stats { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="nav-logo">
                <span class="logo-text">PDAM Tirta Perwitasari</span>
                <span class="logo-sub">Kabupaten Purworejo</span>
            </a>

            <button type="button" class="nav-toggle" id="navToggle" aria-label="Buka menu navigasi" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            
            <ul class="nav-menu" id="navMenu">
                 <li><a href="{{ route('pelanggan.dashboard') }}" class="nav-link">Dashboard</a></li>
                
                <li class="dropdown">
                    <a href="#" class="nav-link">Profil Perusahaan ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="/profil">Sejarah & Visi Misi</a></li>
                        <li><a href="/dewan-pengawas">Dewan Pengawas</a></li>
                        <li><a href="/manajemen">Manajemen</a></li>
                        <li><a href="/struktur-organisasi">Struktur Organisasi</a></li>
                        <li><a href="/prestasi">Prestasi</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link">Info Pelanggan ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="/pengaduan">Form Pengaduan</a></li>
                        <li><a href="/prosedur-pasang">Prosedur Pasang Pipa Baru</a></li>
                        <li><a href="/pasang-baru">Form Pasang Pipa Baru</a></li>
                        <li><a href="/balik-nama">Form Pengajuan Balik Nama</a></li>
                        <li><a href="/cek-tagihan">Cek Tagihan Bulanan</a></li>
                        <li><a href="/cek-pemasangan">Cek Pemasangan Pipa Baru</a></li>
                        <li><a href="/tarif-minum">Tarif Air Minum / Simulasi Tagihan</a></li>
                        <li><a href="/edukasi-tips">Edukasi Tips Pelanggan</a></li>
                        <li><a href="/faq">FAQ</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link">Info Perusahaan ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="/berita">Berita</a></li>
                        <li><a href="/wilayah-pelayanan">Wilayah Pelayanan</a></li>
                    </ul>
                </li>

                <li><a href="/ppid" class="nav-link">PPID</a></li>
                <li><a href="/kontak" class="nav-link">Kontak</a></li>
            </ul>
        </div>
        <div class="nav-scrim" id="navScrim"></div>
    </nav>

    <header class="hero-section">
        <div class="hero-overlay"></div>

        {{-- Floating bubbles dekoratif --}}
        <div class="hero-bubble"></div>
        <div class="hero-bubble"></div>
        <div class="hero-bubble"></div>
        <div class="hero-bubble"></div>
        <div class="hero-bubble"></div>
        
        <div class="hero-content">
            <span class="eyebrow-badge"><span class="dot"></span>Melayani Kabupaten Purworejo Sejak 1925</span>
            <h1>Layanan Air Bersih Terpadu & Terpercaya untuk Purworejo</h1>
            <p>PDAM Tirta Perwitasari menyediakan air bersih bagi masyarakat Kabupaten Purworejo. Cek tagihan, lapor gangguan, dan ajukan pemasangan baru dengan cepat melalui portal layanan resmi pelanggan.</p>
            
            <div class="hero-actions">
                <a href="prosedur-pasang" class="btn btn-secondary btn-large btn-ripple">Info Pemasangan</a>
            </div>
        </div>
    </header>

    <section class="about-section">
        <div class="about-inner">
            <div class="about-copy reveal-left">
                <span class="eyebrow-badge"><span class="dot"></span>Tentang Kami</span>
                <h2>Mengalirkan Air Bersih untuk Purworejo, Lebih dari Satu Abad</h2>
                <p>PDAM Tirta Perwitasari berawal dari prasarana air minum peninggalan Pemerintah Hindia Belanda yang telah beroperasi sejak <strong>tahun 1925</strong>, memanfaatkan sumber Mata Air Mudal di Desa Kalinongko, Kecamatan Loano. Kini, sebagai Perusahaan Daerah Air Minum resmi Kabupaten Purworejo, kami terus menjaga amanah untuk menghadirkan air bersih yang layak bagi masyarakat.</p>
                <p>Kami melayani pelanggan di seluruh wilayah Kabupaten Purworejo, termasuk melalui kantor cabang seperti di Kutoarjo, dengan dukungan layanan digital agar pelanggan tidak perlu lagi antre ke loket untuk cek tagihan maupun pengaduan.</p>

                <div class="about-stats">
                    <div class="about-stat-card">
                        <div class="stat-number"><span class="counter-target" data-target="101" data-duration="1600">0</span>+</div>
                        <div class="stat-label">Tahun mengabdi sejak 1925</div>
                    </div>
                    <div class="about-stat-card">
                        <div class="stat-number"><span class="counter-target" data-target="13" data-duration="1400">0</span></div>
                        <div class="stat-label">Kecamatan di wilayah Kabupaten Purworejo</div>
                    </div>
                    <div class="about-stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Layanan pengaduan gangguan online</div>
                    </div>
                    <div class="about-stat-card">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Layanan digital, bebas antre loket</div>
                    </div>
                </div>
            </div>

            <div class="about-panel reveal">
                <span class="panel-eyebrow">Informasi Perusahaan</span>
                <h3>PDAM Tirta Perwitasari</h3>
                <p style="font-size:0.88rem; color:rgba(255,255,255,0.75);">Perusahaan Daerah Air Minum Kabupaten Purworejo</p>
                <ul class="about-panel-list">
                    <li><span class="li-icon">📍</span><span>Jl. Jenderal Sudirman No. 101, Pangenjurutengah, Kec. Purworejo, Kab. Purworejo, Jawa Tengah 54114</span></li>
                    <li><span class="li-icon">📞</span><span>(0275) 321050 / 323766</span></li>
                    <li><span class="li-icon">✉️</span><span>pdampurworejo@yahoo.com</span></li>
                    <li><span class="li-icon">💧</span><span>Sumber air: Mata Air Mudal, Desa Kalinongko, Kec. Loano</span></li>
                </ul>
            </div>
        </div>
    </section>

    <div class="section-background">

        <section class="services-section">
            <div class="section-header reveal">
                <h2>Layanan Digital Pelanggan</h2>
                <p>Akses berbagai layanan PDAM Tirta Perwitasari Kabupaten Purworejo dengan mudah, cepat, dan transparan langsung dari perangkat Anda.</p>
            </div>

            <div class="services-grid">
                <div class="service-card reveal stagger-1">
                    <div class="icon-wrapper"><span class="icon">💧</span></div>
                    <h3>Cek Tagihan</h3>
                    <p>Pantau rincian pemakaian air dan tagihan bulanan Anda secara real-time tanpa harus antre ke loket.</p>
                    <a href="{{ route('cek-tagihan.index') }}" class="card-link">Cek Sekarang ➔</a>
                </div>

                <div class="service-card reveal stagger-2">
                    <div class="icon-wrapper"><span class="icon">🛠️</span></div>
                    <h3>Lapor Gangguan</h3>
                    <p>Sampaikan keluhan pipa bocor atau air mati. Tim teknis kami akan segera meluncur ke lokasi.</p>
                    <a href="pengaduan" class="card-link">Buat Laporan ➔</a>
                </div>

                <div class="service-card reveal stagger-3">
                    <div class="icon-wrapper"><span class="icon">📝</span></div>
                    <h3>Pasang Baru</h3>
                    <p>Daftar pemasangan saluran air bersih baru untuk rumah atau tempat usaha Anda dengan persyaratan mudah.</p>
                    <a href="pasang-baru" class="card-link">Daftar Online ➔</a>
                </div>

            </div>
        </section>

       <section class="news-section">
            <div class="section-header reveal">
                <h2>Pusat Informasi & Pengumuman</h2>
                <p>Update terkini seputar layanan, pemeliharaan jaringan, dan edukasi pelanggan PDAM Tirta Perwitasari.</p>
            </div>
            <div class="news-grid">
                @forelse($berita as $item)
                <article class="news-card reveal stagger-{{ $loop->iteration <= 6 ? $loop->iteration : 6 }}">
                    <div class="news-image">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Berita">
                        @else
                            <div style="width: 100%; height: 100%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: bold;">
                                Tanpa Foto
                            </div>
                        @endif
                        <span class="news-badge">Informasi</span>
                    </div>
                    <div class="news-content">
                        <span class="news-date">🗓️ {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</span>
                        <h3>{{ $item->judul }}</h3>
                        <p>{{ Str::limit($item->isi, 100) }}</p>
                        <a href="berita" class="news-link">Baca Selengkapnya ➔</a>
                    </div>
                </article>
                @empty
                <div style="grid-column: 1 / -1; background: #f8fafc; padding: 30px; text-align: center; border-radius: 8px; color: #64748b; border: 1px dashed #cbd5e1;">
                    Belum ada pengumuman terbaru dari PDAM.
                </div>
                @endforelse
            </div>
        </section>
    </div>

    <footer class="site-footer reveal">
        <div class="footer-container">
            <div class="footer-col about-col reveal-left stagger-1">
                <h3 class="footer-logo">PDAM Tirta Perwitasari</h3>
                <p>Perusahaan Daerah Air Minum Kabupaten Purworejo, menyediakan layanan air bersih berkualitas sejak 1925 untuk kesejahteraan masyarakat dan pembangunan daerah yang berkelanjutan melalui inovasi digital.</p>
            </div>
            
            <div class="footer-col reveal-left stagger-2">
                <h4>Layanan Cepat</h4>
                <ul>
                    <li><a href="{{ route('cek-tagihan.index') }}">Cek Tagihan Air</a></li>
                    <li><a href="pengaduan">Lapor Gangguan</a></li>
                    <li><a href="pasang-baru">Pasang Sambungan Baru</a></li>
                    <li><a href="tarif-minum">Tarif Air Minum</a></li>
                </ul>
            </div>

            <div class="footer-col reveal-left stagger-3">
                <h4>Informasi Publik</h4>
                <ul>
                    <li><a href="berita">Berita & Pengumuman</a></li>
                </ul>
            </div>

            <div class="footer-col contact-col reveal-left stagger-4">
                <h4>Hubungi Kami</h4>
                <p>📍 Jl. Jenderal Sudirman No. 101, Pangenjurutengah, Kec. Purworejo, Kab. Purworejo, Jawa Tengah 54114</p>
                <p>📞 Telepon: (0275) 321050 / 323766</p>
                <p>✉️ Email: pdampurworejo@yahoo.com</p>
                <p>📷 Instagram: @pdam.purworejo</p>
                <p>🕒 Senin - Jumat (08:00 - 15:00)</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 PDAM Tirta Perwitasari Kabupaten Purworejo. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        /* ============================================
           ANIMATION SCRIPTS — vanilla JS, no deps
           ============================================ */

        /* 1. Scroll Reveal (IntersectionObserver) */
        (function () {
            const targets = document.querySelectorAll('.reveal, .reveal-left, .section-header');
            if (!targets.length) return;

            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

            targets.forEach(function (el) { observer.observe(el); });
        })();

        /* 2. Counter animasi (angka yang ada di halaman) */
        (function () {
            function animateCounter(el, target, duration) {
                var start = 0;
                var startTime = null;
                var isFloat = target % 1 !== 0;

                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    var progress = Math.min((timestamp - startTime) / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3);
                    var current = eased * target;
                    el.textContent = isFloat
                        ? current.toFixed(1)
                        : Math.floor(current).toLocaleString('id-ID');
                    if (progress < 1) requestAnimationFrame(step);
                }
                requestAnimationFrame(step);
            }

            var counterObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        var el = entry.target;
                        var target = parseFloat(el.getAttribute('data-target'));
                        var duration = parseInt(el.getAttribute('data-duration') || '1800');
                        animateCounter(el, target, duration);
                        counterObserver.unobserve(el);
                    }
                });
            }, { threshold: 0.5 });

            document.querySelectorAll('.counter-target').forEach(function (el) {
                counterObserver.observe(el);
            });
        })();

        /* 3. Parallax dinonaktifkan — mencegah background hero terpotong saat scroll */

        /* 4. Ripple effect pada tombol .btn-ripple */
        (function () {
            document.querySelectorAll('.btn-ripple').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    var rect = btn.getBoundingClientRect();
                    var size = Math.max(rect.width, rect.height) * 1.4;
                    var x = e.clientX - rect.left - size / 2;
                    var y = e.clientY - rect.top  - size / 2;

                    var ripple = document.createElement('span');
                    ripple.classList.add('ripple-circle');
                    ripple.style.cssText = [
                        'width:'  + size + 'px',
                        'height:' + size + 'px',
                        'left:'   + x    + 'px',
                        'top:'    + y    + 'px'
                    ].join(';');

                    btn.appendChild(ripple);
                    ripple.addEventListener('animationend', function () { ripple.remove(); });
                });
            });
        })();

        /* 5. Bubble floating — beda durasi tiap bubble supaya natural */
        (function () {
            var bubbles = document.querySelectorAll('.hero-bubble');
            bubbles.forEach(function (b, i) {
                b.style.animationDelay = (i * 0.9) + 's';
            });
        })();
        /* 6. Mobile nav toggle (hamburger) + dropdown tap-to-open di mobile */
        (function () {
            var toggle = document.getElementById('navToggle');
            var menu = document.getElementById('navMenu');
            var scrim = document.getElementById('navScrim');
            if (!toggle || !menu) return;

            function closeMenu() {
                menu.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                if (scrim) scrim.classList.remove('is-open');
                document.body.classList.remove('nav-locked');
                menu.querySelectorAll('.dropdown.is-open').forEach(function (d) {
                    d.classList.remove('is-open');
                });
            }

            function openMenu() {
                menu.classList.add('is-open');
                toggle.setAttribute('aria-expanded', 'true');
                if (scrim) scrim.classList.add('is-open');
                document.body.classList.add('nav-locked');
            }

            toggle.addEventListener('click', function () {
                var isOpen = menu.classList.contains('is-open');
                if (isOpen) { closeMenu(); } else { openMenu(); }
            });

            if (scrim) scrim.addEventListener('click', closeMenu);

            /* Dropdown: di layar sempit, klik label membuka submenu alih-alih hover */
            menu.querySelectorAll('.dropdown > .nav-link').forEach(function (link) {
                link.addEventListener('click', function (e) {
                    if (window.innerWidth > 900) return; // desktop tetap pakai hover
                    e.preventDefault();
                    var parent = link.closest('.dropdown');
                    var wasOpen = parent.classList.contains('is-open');
                    menu.querySelectorAll('.dropdown.is-open').forEach(function (d) {
                        d.classList.remove('is-open');
                    });
                    if (!wasOpen) parent.classList.add('is-open');
                });
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth > 900) closeMenu();
            });
        })();
    </script>

</body>
</html>