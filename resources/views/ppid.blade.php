@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    .ppid-page, .ppid-page * { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
    .ppid-page h1, .ppid-page h2, .ppid-page h3 { font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }

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
    .tarif-hero .ppid-eyebrow {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 7px 16px; border-radius: 999px;
        background: rgba(255, 255, 255, 0.14); border: 1px solid rgba(255, 255, 255, 0.28);
        color: #ffffff; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase;
        margin-bottom: 16px; position: relative; z-index: 1;
    }
    .tarif-hero .ppid-eyebrow .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.18); }
    .tarif-hero h1 { color: #ffffff; margin: 0 0 12px 0; font-size: 34px; font-weight: 800; letter-spacing: -0.5px; position: relative; z-index: 1; }
    .tarif-hero p { color: rgba(255, 255, 255, 0.85); margin: 0 auto; font-size: 16px; font-weight: 400; max-width: 620px; line-height: 1.6; position: relative; z-index: 1; }

    /* --- CONTAINER --- */
    .ppid-container { max-width: 1000px; margin: 0 auto 80px auto; padding: 0 20px; box-sizing: border-box; }

    /* --- EDUKASI: APA ITU PPID --- */
    .ppid-intro {
        background: #ffffff;
        border-radius: 16px;
        padding: 28px 30px;
        margin: 0 0 40px 0;
        box-shadow: 0 8px 20px -6px rgba(3, 105, 161, 0.10);
        border: 1px solid #e2e8f0;
    }
    .ppid-intro p { margin: 0; color: var(--text-dark, #1e293b); font-size: 14.5px; line-height: 1.75; }
    .ppid-intro strong { color: var(--dark-blue, #0369a1); }

    .ppid-cat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 40px;
    }
    .ppid-cat-card {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 14px;
        padding: 20px;
    }
    .ppid-cat-card .cat-icon { font-size: 26px; margin-bottom: 8px; }
    .ppid-cat-card h4 { margin: 0 0 6px 0; font-size: 14.5px; color: var(--text-dark, #1e293b); font-weight: 700; }
    .ppid-cat-card p { margin: 0; font-size: 12.5px; color: #475569; line-height: 1.6; }

    /* --- FILTER --- */
    .filter-box { margin-bottom: 24px; display: flex; justify-content: flex-end; }
    .filter-box select {
        padding: 11px 34px 11px 18px; border-radius: 10px; border: 1px solid #cbd5e1;
        font-weight: 600; font-size: 14px; color: var(--text-dark, #1e293b);
        outline: none; background: #ffffff; cursor: pointer;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .filter-box select:focus { border-color: var(--primary-blue, #0ea5e9); box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.14); }

    /* --- KARTU DOKUMEN --- */
    .ppid-list-title {
        font-size: 15px; font-weight: 700; color: var(--text-dark, #1e293b);
        margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;
    }

    .ppid-card {
        background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px;
        margin-bottom: 16px;
        display: flex; justify-content: space-between; align-items: center; gap: 20px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04);
        transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .ppid-card:hover { transform: translateY(-4px); box-shadow: 0 14px 26px -6px rgba(3, 105, 161, 0.16); border-color: #93c5fd; }

    .ppid-info { flex: 1; min-width: 0; }
    .ppid-badge {
        display: inline-block; padding: 6px 14px; font-size: 12px; font-weight: 700;
        border-radius: 20px; margin-bottom: 10px;
        background: #eff6ff; color: #2563eb;
    }
    .ppid-badge.cat-berkala { background: #eff6ff; color: #2563eb; }
    .ppid-badge.cat-serta-merta { background: #fef2f2; color: #dc2626; }
    .ppid-badge.cat-setiap-saat { background: #ecfdf5; color: #059669; }

    .ppid-title { margin: 0 0 8px 0; font-size: 18px; color: #0f172a; font-weight: 700; line-height: 1.4; }
    .ppid-desc { margin: 0; color: #64748b; font-size: 14px; line-height: 1.6; }

    .ppid-actions { display: flex; gap: 10px; flex-shrink: 0; }
    .btn-download {
        color: white; padding: 12px 22px; border-radius: 10px; text-decoration: none;
        font-weight: 600; font-size: 14px; white-space: nowrap; transition: 0.25s;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-download.btn-view { background: var(--primary-blue, #3b82f6); }
    .btn-download.btn-view:hover { background: var(--dark-blue, #2563eb); }
    .btn-download.btn-get { background: #10b981; }
    .btn-download.btn-get:hover { background: #059669; }

    /* --- EMPTY STATE --- */
    .ppid-empty {
        text-align: center; padding: 60px 24px; color: #94a3b8;
        background: #f8fafc; border-radius: 16px; border: 2px dashed #cbd5e1;
    }
    .ppid-empty .empty-icon { font-size: 40px; margin: 0 0 10px; }
    .ppid-empty h3 { margin: 0; color: #64748b; font-size: 16px; }

    /* --- BANTUAN PERMOHONAN INFORMASI --- */
    .ppid-help {
        margin-top: 36px;
        background: linear-gradient(135deg, #0c4a6e 0%, var(--dark-blue, #0369a1) 60%, var(--primary-blue, #0ea5e9) 100%);
        color: white; border-radius: 16px; padding: 28px 30px;
        display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px;
        box-shadow: 0 10px 25px -5px rgba(3, 105, 161, 0.3);
    }
    .ppid-help-text h3 { margin: 0 0 6px 0; font-size: 18px; }
    .ppid-help-text p { margin: 0; font-size: 13.5px; color: rgba(255,255,255,0.85); line-height: 1.6; max-width: 480px; }
    .ppid-help-btn {
        background: rgba(15, 23, 42, 0.55); color: white; text-decoration: none;
        padding: 13px 22px; border-radius: 12px; font-weight: 700; font-size: 14px;
        white-space: nowrap; transition: background 0.3s ease, transform 0.2s ease;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .ppid-help-btn:hover { background: rgba(15, 23, 42, 0.75); transform: translateY(-2px); }

    .ppid-pagination { margin-top: 30px; }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 768px) {
        .tarif-hero { padding: 56px 20px; }
        .tarif-hero h1 { font-size: 26px; }
        .tarif-hero p { font-size: 14px; }
        .ppid-intro { padding: 20px 22px; }
        .ppid-cat-grid { grid-template-columns: 1fr; }
        .ppid-card { flex-direction: column; align-items: flex-start; }
        .ppid-actions { width: 100%; }
        .btn-download { width: 100%; justify-content: center; }
        .ppid-help { flex-direction: column; align-items: flex-start; }
        .ppid-help-btn { width: 100%; justify-content: center; }
    }
    @media (max-width: 480px) {
        .tarif-hero { padding: 48px 16px; }
        .tarif-hero h1 { font-size: 22px; }
        .filter-box { justify-content: stretch; }
        .filter-box form { width: 100%; }
        .filter-box select { width: 100%; font-size: 16px; }
        .ppid-actions { flex-direction: column; }
    }
</style>

<div class="ppid-page">

    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="ppid-eyebrow"><span class="dot"></span>PDAM Tirta Perwitasari &middot; Kabupaten Purworejo</span>
        <h1>Layanan Informasi PPID</h1>
        <p>Transparansi informasi publik PDAM Tirta Perwitasari Kabupaten Purworejo. Unduh laporan dan dokumen resmi di bawah ini.</p>
    </div>

    <div class="ppid-container">

        <div class="ppid-intro">
            <p><strong>Pejabat Pengelola Informasi dan Dokumentasi (PPID)</strong> adalah pejabat yang bertanggung jawab menyimpan, mendokumentasikan, dan melayani permintaan informasi publik, sesuai amanat Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik. Melalui halaman ini, PDAM Tirta Perwitasari menyediakan dokumen dan laporan resmi yang dapat diakses secara terbuka oleh masyarakat Kabupaten Purworejo.</p>
        </div>

        <div class="ppid-cat-grid">
            <div class="ppid-cat-card">
                <div class="cat-icon">🗓️</div>
                <h4>Informasi Berkala</h4>
                <p>Wajib diumumkan dan diperbarui secara rutin, tanpa harus diminta terlebih dahulu.</p>
            </div>
            <div class="ppid-cat-card">
                <div class="cat-icon">⚡</div>
                <h4>Informasi Serta Merta</h4>
                <p>Wajib disebarluaskan secepatnya karena berkaitan dengan hajat hidup orang banyak.</p>
            </div>
            <div class="ppid-cat-card">
                <div class="cat-icon">🗂️</div>
                <h4>Informasi Setiap Saat</h4>
                <p>Tersedia secara berkelanjutan dan dapat diakses kapan pun sesuai permintaan.</p>
            </div>
        </div>

        <!-- Filter Kategori -->
        <div class="filter-box">
            <form action="{{ route('ppid.index') }}" method="GET">
                <select name="kategori" onchange="this.form.submit()">
                    <option value="Semua" {{ request('kategori') == 'Semua' ? 'selected' : '' }}>📋 Semua Kategori</option>
                    <option value="Informasi Berkala" {{ request('kategori') == 'Informasi Berkala' ? 'selected' : '' }}>Informasi Berkala</option>
                    <option value="Informasi Serta Merta" {{ request('kategori') == 'Informasi Serta Merta' ? 'selected' : '' }}>Informasi Serta Merta</option>
                    <option value="Informasi Setiap Saat" {{ request('kategori') == 'Informasi Setiap Saat' ? 'selected' : '' }}>Informasi Setiap Saat</option>
                </select>
            </form>
        </div>

        <!-- List Dokumen -->
        @forelse($ppids as $item)
            @php
                $catClass = match($item->kategori) {
                    'Informasi Berkala' => 'cat-berkala',
                    'Informasi Serta Merta' => 'cat-serta-merta',
                    'Informasi Setiap Saat' => 'cat-setiap-saat',
                    default => 'cat-berkala',
                };
            @endphp
            <div class="ppid-card">
                <div class="ppid-info">
                    <span class="ppid-badge {{ $catClass }}">{{ $item->kategori }}</span>
                    <h3 class="ppid-title">{{ $item->judul }}</h3>
                    <p class="ppid-desc">{{ $item->deskripsi ?? 'Dokumen resmi PDAM Tirta Perwitasari.' }}</p>
                </div>
                <div class="ppid-actions">
                    <!-- Tombol Lihat (Warna Biru) -->
                    <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank" class="btn-download btn-view">
                        👁️ Lihat
                    </a>

                    <!-- Tombol Download Langsung (Warna Hijau, dikasih atribut "download") -->
                    <a href="{{ asset('storage/' . $item->file_dokumen) }}" download class="btn-download btn-get">
                        ⬇️ Download
                    </a>
                </div>
            </div>
        @empty
            <div class="ppid-empty">
                <p class="empty-icon">📭</p>
                <h3>Belum ada dokumen yang diunggah</h3>
            </div>
        @endforelse

        <div class="ppid-pagination">
            {{ $ppids->links() }}
        </div>

        <!-- BANTUAN PERMOHONAN INFORMASI -->
        <div class="ppid-help">
            <div class="ppid-help-text">
                <h3>Tidak Menemukan Dokumen yang Dicari?</h3>
                <p>Ajukan permohonan informasi publik langsung ke PPID PDAM Tirta Perwitasari. Tanggapan tertulis akan kami sampaikan sesuai ketentuan UU Keterbukaan Informasi Publik.</p>
            </div>
            <a href="https://wa.me/62895623300101" target="_blank" rel="noopener" class="ppid-help-btn">
                💬 Hubungi PPID
            </a>
        </div>

    </div>
</div>
@endsection