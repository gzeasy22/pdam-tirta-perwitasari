@extends('layouts.app')

@section('content')

{{-- 🔥 JURUS SAKTI: Langsung nembak database dari View tanpa nyentuh Controller --}}
@php
    $prestasis = \App\Models\Prestasi::latest()->get();
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .prestasi-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    
    .prestasi-page h1, .prestasi-page h2, .prestasi-page h3 {
        font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
        letter-spacing: -0.01em;
    }

    /* ================================================================
       HERO SECTION 
    ================================================================ */
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

    /* ================================================================
       WRAPPER & HIGHLIGHT (STATIS)
    ================================================================ */
    .pb-wrap {
        max-width: 1100px;
        margin: 0 auto 60px auto;
        padding: 0 20px;
        box-sizing: border-box;
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
        width: 6px; height: 24px;
        background: #0ea5e9;
        border-radius: 4px;
    }

    .highlight-card {
        background: linear-gradient(135deg, #ffffff, #f0f9ff);
        border-radius: 24px;
        box-shadow: 0 10px 30px -5px rgba(3, 105, 161, 0.1);
        border: 1px solid #bae6fd;
        display: flex;
        overflow: hidden;
        margin-bottom: 60px;
        align-items: center;
    }
    .highlight-icon {
        width: 240px;
        background: #0ea5e9;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 80px;
        flex-shrink: 0;
        align-self: stretch;
    }
    .highlight-content {
        padding: 40px;
        flex-grow: 1;
    }
    .highlight-badge {
        display: inline-block;
        background: #fef08a;
        color: #854d0e;
        padding: 6px 14px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
    }
    .highlight-content h2 {
        font-size: 26px;
        color: #0f172a;
        margin: 0 0 12px 0;
    }
    .highlight-content p {
        font-size: 15px;
        line-height: 1.7;
        color: #475569;
        margin: 0;
    }

    /* ================================================================
       AREA CAROUSEL DINAMIS
    ================================================================ */
    .carousel-outer {
        position: relative;
        width: 100%;
        user-select: none;
    }
    .carousel-viewport {
        overflow: hidden;
        width: 100%;
        padding: 20px 0;
    }
    .carousel-track {
        display: flex;
        gap: 0; 
        transition: transform 0.55s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        will-change: transform;
    }

    .poster-card {
        flex: 0 0 100%; 
        width: 100%;
        background: #ffffff; 
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: row; /* Desktop: Gambar kiri, Teks Kanan */
        box-sizing: border-box;
        min-height: 350px; /* Jauh lebih proporsional */
    }
    .poster-img-box {
        width: 45%;
        background: #f1f5f9; 
        flex-shrink: 0;
        position: relative;
    }
    .poster-img-box img {
        width: 100%; 
        height: 100%; 
        object-fit: cover;
        position: absolute;
        top: 0; left: 0;
    }
    .poster-content {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 55%;
    }
    .poster-date {
        display: inline-flex;
        align-items: center;
        color: #0ea5e9;
        font-size: 13.5px;
        font-weight: 700;
        margin-bottom: 16px;
    }
    .poster-excerpt {
        font-size: 15px;
        color: #475569;
        line-height: 1.8;
        margin: 0;
    }
    .poster-excerpt p {
        margin-top: 0;
        margin-bottom: 16px;
    }
    .poster-excerpt p:last-child {
        margin-bottom: 0;
    }

    /* TOMBOL PANAH NAVIGASI */
    .carousel-arrow {
        position: absolute;
        top: 50%; 
        transform: translateY(-50%);
        z-index: 10;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #ffffff; 
        color: #0ea5e9;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .carousel-arrow:hover:not(:disabled) {
        background: #0ea5e9; 
        color: #ffffff;
        transform: translateY(-50%) scale(1.05);
    }
    .carousel-arrow:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
    .carousel-arrow.prev { left: -24px; }
    .carousel-arrow.next { right: -24px; }

    /* DOT INDIKATOR */
    .carousel-dots {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }
    .dot-btn {
        width: 10px; height: 10px;
        border-radius: 50%;
        background: #cbd5e1;
        border: none;
        padding: 0;
        cursor: pointer;
        transition: 0.3s ease;
    }
    .dot-btn.is-active {
        width: 28px;
        border-radius: 6px;
        background: #0ea5e9;
    }

    /* EMPTY STATE */
    .empty-state {
        background: #ffffff;
        border: 2px dashed #cbd5e1;
        border-radius: 20px;
        padding: 60px 20px;
        text-align: center;
        box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.02);
    }
    .empty-state h3 { font-size: 20px; color: #0f172a; margin: 16px 0 8px; }
    .empty-state p { color: #64748b; margin: 0; }

    /* ================================================================
       RESPONSIVE MOBILE
    ================================================================ */
    @media (max-width: 860px) {
        .highlight-card { flex-direction: column; }
        .highlight-icon { width: 100%; height: 160px; font-size: 60px; }
        .highlight-content { padding: 32px; }
        
        .poster-card { flex-direction: column; }
        .poster-img-box { width: 100%; height: 240px; }
        .poster-content { width: 100%; padding: 32px; }
        
        .carousel-arrow.prev { left: -10px; }
        .carousel-arrow.next { right: -10px; }
    }
    @media (max-width: 480px) {
        .tarif-hero { padding: 64px 20px 48px; }
        .tarif-hero h1 { font-size: 28px; }
        .highlight-content { padding: 24px; }
        .poster-content { padding: 24px; }
    }
</style>

<div class="prestasi-page">

    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow">Pencapaian Perusahaan</span>
        <h1>Prestasi & Penghargaan</h1>
        <p>Jejak langkah kebanggaan dan bukti komitmen nyata PDAM Tirta Perwitasari dalam memberikan pelayanan air bersih terbaik bagi masyarakat.</p>
    </div>

    <div class="pb-wrap">

        {{-- HIGHLIGHT STATIS (TAMBAHAN DATA PRESTASI) --}}
        <h2 class="section-title">Sorotan Utama</h2>
        <div class="highlight-card">
            <div class="highlight-icon"></div>
            <div class="highlight-content">
                <span class="highlight-badge">Tahun 2024</span>
                <h2>Peringkat 3 Nasional Kinerja BUMD Air Minum</h2>
                <p>Menginjak usia emas 50 tahun, PDAM Tirta Perwitasari Purworejo berhasil menorehkan prestasi gemilang dengan meraih <strong>Peringkat 3 Tingkat Nasional</strong> untuk kategori BUMD Air Minum dengan jumlah pelanggan di bawah 50.000 Sambungan Rumah (SR). Penghargaan ini menjadi bukti efektivitas tata kelola dan budaya kerja Prima perusahaan.</p>
            </div>
        </div>

        {{-- CAROUSEL DINAMIS (DARI DATABASE) --}}
        <h2 class="section-title">Arsip Penghargaan Lainnya</h2>
        
        <div class="prestasi-section">
            {{-- Loop data dari database[cite: 4] --}}
            @forelse($prestasis as $item)

                @if($loop->first)
                <div class="carousel-outer">
                    <button class="carousel-arrow prev" id="pBtnPrev" aria-label="Sebelumnya">&#10094;</button>

                    <div class="carousel-viewport" id="pCarouselViewport">
                        <div class="carousel-track" id="pCarouselTrack">
                @endif

                            <div class="poster-card" data-index="{{ $loop->index }}">
                                <div class="poster-img-box">
                                    {{-- Foto dari storage[cite: 4] --}}
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Penghargaan">
                                </div>
                                <div class="poster-content">
                                    {{-- Tanggal diarsipkan[cite: 4] --}}
                                    <span class="poster-date">🗓️ Diarsipkan pada {{ $item->created_at->format('d M Y') }}</span>
                                    
                                    <div class="poster-excerpt">
                                        {{-- Teks HTML dari DB[cite: 4] --}}
                                        {!! $item->deskripsi !!}
                                    </div>
                                </div>
                            </div>

                @if($loop->last)
                        </div>
                    </div>
                    <button class="carousel-arrow next" id="pBtnNext" aria-label="Berikutnya">&#10095;</button>
                </div>

                <div class="carousel-dots" id="pCarouselDots">
                    @for($d = 0; $d < $loop->count; $d++)
                        <button class="dot-btn {{ $d === 0 ? 'is-active' : '' }}" data-dot="{{ $d }}"></button>
                    @endfor
                </div>
                @endif

            @empty
                {{-- Empty state jika data kosong[cite: 4] --}}
                <div class="empty-state">
                    <p style="font-size:50px; margin:0 0 16px;">📭</p>
                    <h3>Belum Ada Arsip Lainnya</h3>
                    <p>Admin belum menambahkan data prestasi tambahan ke dalam sistem.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

{{-- SCRIPT JS CAROUSEL BAWAAN TETAP DIPERTAHANKAN --}}
<script>
(function () {
    const track    = document.getElementById('pCarouselTrack');
    const viewport = document.getElementById('pCarouselViewport');
    const btnPrev  = document.getElementById('pBtnPrev');
    const btnNext  = document.getElementById('pBtnNext');
    const dots     = document.querySelectorAll('#pCarouselDots .dot-btn');
    const cards    = document.querySelectorAll('.poster-card');
    const TOTAL    = cards.length;
    let   current  = 0;

    // Logika event carousel[cite: 4]
    if (!track || TOTAL === 0) return;

    function render() {
        const widthX = viewport.offsetWidth;
        track.style.transform = 'translateX(-' + (current * widthX) + 'px)';
        
        dots.forEach(function (dot, i) {
            dot.classList.toggle('is-active', i === current);
        });
        
        if (btnPrev)  btnPrev.disabled = (current === 0);
        if (btnNext)  btnNext.disabled = (current === TOTAL - 1);
    }

    function move(dir) {
        current = Math.max(0, Math.min(current + dir, TOTAL - 1));
        render();
    }

    function goTo(index) {
        current = index;
        render();
    }

    if (btnPrev) btnPrev.addEventListener('click', function () { move(-1); });
    if (btnNext) btnNext.addEventListener('click', function () { move(1);  });

    dots.forEach(function (dot, i) {
        dot.addEventListener('click', function () { goTo(i); });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft')  move(-1);
        if (e.key === 'ArrowRight') move(1);
    });

    var touchStartX = 0;
    viewport.addEventListener('touchstart', function (e) {
        touchStartX = e.touches[0].clientX;
    }, { passive: true });
    viewport.addEventListener('touchend', function (e) {
        var diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) move(diff > 0 ? 1 : -1);
    }, { passive: true });

    window.addEventListener('resize', render);
    render();
})();
</script>
@endsection