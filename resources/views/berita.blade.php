@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .berita-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .berita-page h1, .berita-page h2, .berita-page h3 {
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
        color: #ffffff; margin: 0 0 16px 0; font-size: 38px; font-weight: 800; position: relative; z-index: 1;
    }
    .tarif-hero p {
        color: rgba(255, 255, 255, 0.85); margin: 0 auto; font-size: 16px; max-width: 620px; line-height: 1.6; position: relative; z-index: 1;
    }

    /* ================================================================
       AREA CAROUSEL UTAMA
    ================================================================ */
    .berita-section {
        max-width: 1000px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }

    .carousel-outer {
        position: relative;
        width: 100%;
        margin: 0 auto;
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

    /* ================================================================
       POSTER CARD (DESAIN BARU: KIRI GAMBAR, KANAN TEKS)
    ================================================================ */
    .poster-card {
        flex: 0 0 100%;
        width: 100%;
        background: #ffffff; 
        border-radius: 24px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 10px 30px -5px rgba(3, 105, 161, 0.08);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: row; /* Desktop jadi nyamping */
        min-height: 400px;
        box-sizing: border-box;
    }

    .poster-img-box {
        width: 45%;
        position: relative;
        background: #f1f5f9; 
        flex-shrink: 0;
    }

    .poster-img-box img {
        width: 100%; 
        height: 100%;
        object-fit: cover; /* Biar gambar gak gepeng, auto crop cantik */
        position: absolute;
        top: 0; left: 0;
    }

    /* AREA TEKS KANAN */
    .poster-content {
        padding: 40px;
        width: 55%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-sizing: border-box;
    }

    .poster-date {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #0ea5e9;
        font-size: 13.5px;
        font-weight: 700;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .poster-title {
        font-size: 26px; 
        font-weight: 800;
        color: #0f172a;
        line-height: 1.4;
        margin: 0 0 20px 0;
    }

    .poster-excerpt {
        font-size: 15px;
        color: #475569;
        line-height: 1.8;
        margin: 0;
        /* Maksimal 5 baris text buat preview biar gak kepanjangan */
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .poster-excerpt p {
        margin: 0 0 10px 0;
    }

    /* ================================================================
       TOMBOL PANAH (DI LUAR KOTAK BIAR ELEGAN)
    ================================================================ */
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
        opacity: 0.3;
        cursor: not-allowed;
    }
    .carousel-arrow.prev { left: -24px; }
    .carousel-arrow.next { right: -24px; }

    /* ================================================================
       DOT INDIKATOR & COUNTER
    ================================================================ */
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

    .carousel-counter {
        text-align: center;
        margin-top: 15px;
        font-size: 13.5px;
        color: #64748b;
        font-weight: 600;
    }
    .carousel-counter span { color: #0ea5e9; font-weight: 800; }

    /* --- EMPTY STATE --- */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #ffffff;
        border-radius: 20px;
        border: 2px dashed #cbd5e1;
        box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.02);
    }
    .empty-state h3 { font-size: 20px; color: #0f172a; margin: 16px 0 8px; }
    .empty-state p { color: #64748b; margin: 0; }

    /* ================================================================
       RESPONSIVE BIAR DI HP TETEP RAPI
    ================================================================ */
    @media (max-width: 860px) {
        .poster-card { flex-direction: column; min-height: auto; }
        .poster-img-box { width: 100%; height: 250px; }
        .poster-img-box img { position: relative; }
        .poster-content { width: 100%; padding: 32px 24px; }
        .carousel-arrow.prev { left: -10px; }
        .carousel-arrow.next { right: -10px; }
    }
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px 20px; }
        .tarif-hero h1 { font-size: 28px; }
        .poster-title { font-size: 22px; }
    }
</style>

<div class="berita-page">

    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow">Pusat Informasi</span>
        <h1>Informasi Dan Berita PDAM</h1>
        <p>Seputar layanan, tips hemat air, dan info gangguan terkini PDAM Tirta Perwitasari.</p>
    </div>

    <div class="berita-section">

        @forelse($berita as $item)

            @if($loop->first)
            <div class="carousel-outer">
                <button class="carousel-arrow prev" id="btnPrev" aria-label="Sebelumnya">&#10094;</button>

                <div class="carousel-viewport" id="carouselViewport">
                    <div class="carousel-track" id="carouselTrack">
            @endif

                        <div class="poster-card" data-index="{{ $loop->index }}">
                            
                            {{-- Area Foto (Kiri) --}}
                            <div class="poster-img-box">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 60px; color: #cbd5e1; background: #f8fafc; position: absolute; top: 0; left: 0;">
                                        🖼️
                                    </div>
                                @endif
                            </div>

                            {{-- Area Teks (Kanan) --}}
                            <div class="poster-content">
                                <span class="poster-date">📅 {{ $item->created_at->format('d M Y') }}</span>
                                <h2 class="poster-title">{{ $item->judul }}</h2>
                                
                                <div class="poster-excerpt">
                                    {!! $item->isi !!}
                                </div>
                            </div>

                        </div>

            @if($loop->last)
                    </div>
                </div>

                <button class="carousel-arrow next" id="btnNext" aria-label="Berikutnya">&#10095;</button>
            </div>

            <div class="carousel-dots" id="carouselDots">
                @for($d = 0; $d < $loop->count; $d++)
                    <button class="dot-btn {{ $d === 0 ? 'is-active' : '' }}" data-dot="{{ $d }}"></button>
                @endfor
            </div>

            <p class="carousel-counter">
                <span id="counterCurrent">1</span> / {{ $loop->count }}
            </p>
            @endif

        @empty
            <div class="empty-state">
                <p style="font-size:50px; margin:0 0 16px;">📰</p>
                <h3>Belum Ada Berita Saat Ini</h3>
                <p>Nantikan update informasi dan berita terbaru dari kami segera.</p>
            </div>
        @endforelse

        {{-- PAGINATION --}}
        <div style="display: flex; justify-content: center; margin-top: 40px;">
            {{ $berita->links() }}
        </div>

    </div>

</div>

{{-- SCRIPT JS BAWAAN TETAP UTUH --}}
<script>
(function () {
    const track    = document.getElementById('carouselTrack');
    const viewport = document.getElementById('carouselViewport');
    const btnPrev  = document.getElementById('btnPrev');
    const btnNext  = document.getElementById('btnNext');
    const counter  = document.getElementById('counterCurrent');
    const dots     = document.querySelectorAll('.dot-btn');
    const cards    = document.querySelectorAll('.poster-card');
    const TOTAL    = cards.length;
    let   current  = 0;

    if (!track || TOTAL === 0) return;

    function render() {
        const widthX = viewport.offsetWidth;
        track.style.transform = 'translateX(-' + (current * widthX) + 'px)';
        
        dots.forEach(function (dot, i) {
            dot.classList.toggle('is-active', i === current);
        });
        
        if (counter) counter.textContent = current + 1;
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