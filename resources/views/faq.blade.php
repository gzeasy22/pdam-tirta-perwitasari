@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .faq-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .faq-page h1, .faq-page h2, .faq-page h3 {
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
    .tarif-hero h1 {
        color: #ffffff; margin: 0 0 16px 0; font-size: 38px; font-weight: 800; position: relative; z-index: 1;
    }
    .tarif-hero p {
        color: rgba(255, 255, 255, 0.85); margin: 0 auto; font-size: 16px; max-width: 620px; line-height: 1.6; position: relative; z-index: 1;
    }

    /* --- WRAPPER --- */
    .pb-wrap {
        max-width: 900px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }

    /* --- SEARCH BAR (FUNGIONAL) --- */
    .faq-search-box {
        background: #ffffff;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 10px 30px -5px rgba(3, 105, 161, 0.08);
        border: 1px solid #e2e8f0;
        margin-top: 0;
        margin-bottom: 50px;
        position: relative;
        z-index: 10;
        display: flex;
        gap: 12px;
    }
    .faq-search-input {
        flex-grow: 1;
        padding: 16px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-family: inherit;
        font-size: 16px;
        color: #0f172a;
        transition: 0.3s;
    }
    .faq-search-input:focus {
        outline: none;
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px #e0f2fe;
    }
    .faq-search-btn {
        background: #0ea5e9;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0 24px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }
    .faq-search-btn:hover { background: #0284c7; }

    /* --- CATEGORY SECTION --- */
    .faq-category {
        margin-bottom: 40px;
    }
    .faq-category-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 20px 0;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 2px dashed #cbd5e1;
        padding-bottom: 12px;
    }

    /* --- ACCORDION UI --- */
    .accordion-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 12px;
        overflow: hidden;
        transition: 0.3s ease;
    }
    .accordion-item.active {
        border-color: #bae6fd;
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.08);
    }

    .accordion-header {
        width: 100%;
        text-align: left;
        background: transparent;
        border: none;
        padding: 20px 24px;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: inherit;
        transition: 0.3s ease;
    }
    .accordion-header:hover { color: #0ea5e9; }
    
    .accordion-icon {
        width: 24px;
        height: 24px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 18px;
        flex-shrink: 0;
        transition: 0.3s ease;
    }
    .accordion-item.active .accordion-header { color: #0369a1; background: #f0f9ff; }
    .accordion-item.active .accordion-icon {
        background: #0ea5e9;
        color: white;
        transform: rotate(45deg);
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
        background: #ffffff;
    }
    .accordion-inner {
        padding: 0 24px 24px 24px;
        color: #475569;
        font-size: 15px;
        line-height: 1.7;
    }
    .accordion-inner ul {
        margin: 10px 0 0 0; padding-left: 20px;
    }
    .accordion-inner li { margin-bottom: 6px; }

    /* --- EMPTY STATE (Kalo gak ketemu) --- */
    #faq-empty-state {
        display: none;
        text-align: center;
        padding: 60px 20px;
        background: #ffffff;
        border-radius: 16px;
        border: 2px dashed #cbd5e1;
        margin-bottom: 40px;
    }
    #faq-empty-state h3 { font-size: 20px; color: #0f172a; margin: 16px 0 8px 0; }
    #faq-empty-state p { color: #64748b; margin: 0; }

    /* --- CONTACT CTA --- */
    .cta-box {
        background: linear-gradient(135deg, #0ea5e9, #0369a1);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        color: white;
        margin-top: 60px;
        box-shadow: 0 10px 30px -5px rgba(3, 105, 161, 0.2);
    }
    .cta-box h3 { font-size: 24px; margin: 0 0 12px 0; color: white; }
    .cta-box p { font-size: 15px; opacity: 0.9; margin: 0 0 24px 0; }
    .btn-cta {
        display: inline-flex; align-items: center; gap: 8px;
        background: #ffffff; color: #0369a1; text-decoration: none;
        padding: 14px 28px; border-radius: 999px; font-weight: 800; font-size: 15px;
        transition: 0.3s;
    }
    .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px 20px; }
        .tarif-hero h1 { font-size: 28px; }
        .faq-search-box { flex-direction: column; padding: 16px; margin-top: 0; }
        .faq-search-btn { padding: 16px; }
        .accordion-header { padding: 16px 20px; font-size: 15px; }
        .accordion-inner { padding: 0 20px 20px 20px; }
        .cta-box { padding: 32px 20px; }
    }
</style>

<div class="faq-page">

    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Pusat Bantuan</span>
        <h1>Pertanyaan Seputar Layanan</h1>
        <p>Temukan jawaban cepat untuk pertanyaan yang paling sering diajukan oleh pelanggan PDAM Tirta Perwitasari.</p>
    </div>

    <div class="pb-wrap">

        {{-- SEARCH BAR (SEKARANG BERFUNGSI) --}}
        <div class="faq-search-box">
            <input type="text" id="faqSearchInput" class="faq-search-input" placeholder="Ketik kata kunci pertanyaan Anda di sini...">
            <button id="faqSearchBtn" class="faq-search-btn">Cari Jawaban</button>
        </div>

        {{-- AREA HASIL FAQ KESELURUHAN --}}
        <div id="faqContainer">
            
            {{-- KATEGORI 1: TAGIHAN & PEMBAYARAN --}}
            <div class="faq-category">
                <h2 class="faq-category-title">💳 Tagihan & Pembayaran</h2>
                
                <div class="accordion-item">
                    <button class="accordion-header">
                        Kapan batas waktu pembayaran tagihan air setiap bulannya?
                        <span class="accordion-icon">+</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            Batas akhir pembayaran tagihan air PDAM Tirta Perwitasari adalah **tanggal 20 setiap bulannya**. Jika Anda melakukan pembayaran melewati tanggal tersebut, akan dikenakan denda keterlambatan sebesar Rp 10.000 per rekening.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header">
                        Di mana saja saya bisa membayar tagihan air?
                        <span class="accordion-icon">+</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            Pembayaran sangat mudah dan bisa dilakukan melalui berbagai saluran:
                            <ul>
                                <li>Melalui menu <strong>"Cek Tagihan"</strong> di website ini menggunakan integrasi pembayaran Midtrans.</li>
                                <li>Loket resmi di kantor cabang PDAM terdekat.</li>
                                <li>Minimarket (Indomaret / Alfamart).</li>
                                <li>Mobile Banking / ATM yang telah bekerja sama.</li>
                                <li>Aplikasi e-wallet (OVO, Gopay, LinkAja, ShopeePay).</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header">
                        Apa itu Biaya Pemeliharaan Meter Air?
                        <span class="accordion-icon">+</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            Biaya pemeliharaan meter adalah biaya tetap bulanan yang dibebankan kepada pelanggan untuk perawatan dan pemeliharaan alat meteran air agar pencatatan tetap akurat. Besaran biaya ini bervariasi menyesuaikan ukuran diameter inchi meteran yang terpasang di rumah Anda (mulai dari Rp 6.000 untuk ukuran 0,5").
                        </div>
                    </div>
                </div>
            </div>

            {{-- KATEGORI 2: PEMASANGAN BARU --}}
            <div class="faq-category">
                <h2 class="faq-category-title">🚰 Pemasangan Sambungan Baru</h2>
                
                <div class="accordion-item">
                    <button class="accordion-header">
                        Bagaimana cara mendaftar untuk Pasang Baru?
                        <span class="accordion-icon">+</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            Anda dapat mendaftar secara online melalui menu <strong>"Layanan Cepat -> Pasang Sambungan Baru"</strong> di website ini. Siapkan dokumen persyaratan berupa foto KTP, foto Kartu Keluarga (KK), dan foto tampak depan rumah yang akan dipasangi saluran air. Tim kami akan memproses pendaftaran dan melakukan survei ke lokasi Anda.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header">
                        Berapa biaya pemasangan sambungan air baru?
                        <span class="accordion-icon">+</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            Biaya pemasangan baru <strong>tidak dipukul rata</strong>. Biaya ini akan ditentukan berdasarkan Rencana Anggaran Biaya (RAB) hasil survei petugas kami di lapangan. Faktor yang memengaruhi biaya meliputi jarak rumah dari pipa utama PDAM, kebutuhan material pipa tambahan, dan golongan peruntukan bangunan Anda.
                        </div>
                    </div>
                </div>
            </div>

            {{-- KATEGORI 3: GANGGUAN & TEKNIS --}}
            <div class="faq-category">
                <h2 class="faq-category-title">🔧 Gangguan Teknis & Keluhan</h2>
                
                <div class="accordion-item">
                    <button class="accordion-header">
                        Air di rumah saya mati atau mengalir sangat kecil, apa penyebabnya?
                        <span class="accordion-icon">+</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            Ada beberapa kemungkinan penyebab aliran air terganggu:
                            <ul>
                                <li><strong>Jam Puncak:</strong> Pada pagi (05:00-08:00) dan sore hari, banyak orang menggunakan air bersamaan sehingga tekanan bisa menurun.</li>
                                <li><strong>Perbaikan Jaringan:</strong> Mungkin sedang ada penanganan kebocoran pipa utama di area Anda.</li>
                                <li><strong>Tunggakan:</strong> Pastikan Anda tidak memiliki tunggakan tagihan yang menyebabkan pemutusan sementara.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header">
                        Bagaimana cara melaporkan pipa bocor di jalan?
                        <span class="accordion-icon">+</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-inner">
                            Kami sangat mengapresiasi keaktifan warga! Anda bisa langsung masuk ke menu <strong>"Lapor Gangguan"</strong> di website ini, isi form lengkap dengan lokasi dan foto kebocoran. Tim Reaksi Cepat kami akan segera meluncur ke lokasi untuk melakukan penanganan.
                        </div>
                    </div>
                </div>
            </div>

        </div> {{-- EMPTY STATE (Muncul kalau search gak nemu apa-apa) --}}
        <div id="faq-empty-state">
            <span style="font-size: 50px;">🔍</span>
            <h3>Pencarian Tidak Ditemukan</h3>
            <p>Maaf, kami tidak menemukan jawaban yang sesuai dengan kata kunci tersebut.<br>Silakan coba kata kunci lain atau langsung hubungi Customer Service kami.</p>
        </div>

        {{-- CONTACT CTA --}}
        <div class="cta-box">
            <h3>Masih Punya Pertanyaan Lain?</h3>
            <p>Jangan ragu untuk menghubungi Customer Service kami. Kami siap membantu Anda di hari dan jam kerja.</p>
            <a href="https://wa.me/6281122334455" target="_blank" class="btn-cta">
                <span>💬</span> Hubungi via WhatsApp
            </a>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. LOGIKA ANIMASI BUKA-TUTUP ACCORDION
        const accordions = document.querySelectorAll(".accordion-header");
        accordions.forEach(acc => {
            acc.addEventListener("click", function() {
                const item = this.parentElement;
                const isActive = item.classList.contains("active");

                // Tutup yang lain (Opsional)
                document.querySelectorAll(".accordion-item").forEach(otherItem => {
                    otherItem.classList.remove("active");
                    otherItem.querySelector(".accordion-content").style.maxHeight = null;
                });

                if (!isActive) {
                    item.classList.add("active");
                    const content = item.querySelector(".accordion-content");
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        });

        // 2. LOGIKA FITUR PENCARIAN REAL-TIME
        const searchInput = document.getElementById("faqSearchInput");
        const searchBtn = document.getElementById("faqSearchBtn");
        const categories = document.querySelectorAll(".faq-category");
        const emptyState = document.getElementById("faq-empty-state");

        function filterFAQ() {
            const keyword = searchInput.value.toLowerCase();
            let totalVisibleItems = 0; // Buat ngecek ada pertanyaan yg cocok gak

            categories.forEach(category => {
                const items = category.querySelectorAll(".accordion-item");
                let hasVisibleItemInCategory = false;

                items.forEach(item => {
                    const question = item.querySelector(".accordion-header").innerText.toLowerCase();
                    const answer = item.querySelector(".accordion-inner").innerText.toLowerCase();

                    // Cek apakah keyword ada di judul pertanyaan ATAU isi jawaban
                    if (question.includes(keyword) || answer.includes(keyword)) {
                        item.style.display = "block"; // Munculin item
                        hasVisibleItemInCategory = true;
                        totalVisibleItems++;
                    } else {
                        item.style.display = "none"; // Sembunyiin item
                        item.classList.remove("active"); // Tutup kalau lagi kebuka
                        item.querySelector(".accordion-content").style.maxHeight = null;
                    }
                });

                // Kalau di kategori ini gak ada yg cocok, sembunyiin sekalian Judul Kategorinya
                if (hasVisibleItemInCategory) {
                    category.style.display = "block";
                } else {
                    category.style.display = "none";
                }
            });

            // Tampilkan pesan Empty State kalau bener-bener gak ada yg cocok
            if (totalVisibleItems === 0) {
                emptyState.style.display = "block";
            } else {
                emptyState.style.display = "none";
            }
        }

        // Jalankan pencarian saat ngetik langsung (real-time)
        searchInput.addEventListener("input", filterFAQ);
        
        // Buat jaga-jaga kalau user pengen mencet tombol
        searchBtn.addEventListener("click", function(e) {
            e.preventDefault();
            filterFAQ();
        });
    });
</script>

@endsection