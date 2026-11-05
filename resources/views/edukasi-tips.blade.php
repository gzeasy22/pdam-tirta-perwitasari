@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .edukasi-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .edukasi-page h1, .edukasi-page h2, .edukasi-page h3, .edukasi-page h4 {
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
        max-width: 1100px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }

    .section-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 24px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .section-title::before {
        content: ''; display: block; width: 6px; height: 24px; background: #0ea5e9; border-radius: 4px;
    }

    /* --- HIGHLIGHT CARD (DETEKSI KEBOCORAN) --- */
    .highlight-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 10px 30px -5px rgba(3, 105, 161, 0.1);
        border: 1px solid #e2e8f0;
        display: flex;
        overflow: hidden;
        margin-bottom: 60px;
        position: relative;
    }
    .highlight-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, #ef4444, #f59e0b);
    }
    .highlight-img {
        width: 35%;
        background: #fffbeb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 100px;
        border-right: 1px solid #e2e8f0;
    }
    .highlight-content {
        padding: 40px;
        width: 65%;
    }
    .highlight-badge {
        display: inline-block; background: #fee2e2; color: #b91c1c; padding: 6px 14px; border-radius: 999px;
        font-weight: 800; font-size: 12.5px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 16px; border: 1px solid #fecaca;
    }
    .highlight-content h2 { font-size: 24px; color: #0f172a; margin: 0 0 12px 0; }
    .highlight-content p { font-size: 15px; line-height: 1.7; color: #475569; margin: 0 0 20px 0; }
    
    .step-list { list-style: none; padding: 0; margin: 0; }
    .step-list li {
        display: flex; gap: 16px; margin-bottom: 16px;
    }
    .step-list li:last-child { margin-bottom: 0; }
    .step-num {
        background: #fef3c7; color: #d97706; width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; flex-shrink: 0;
    }
    .step-text h4 { margin: 0 0 4px 0; font-size: 16px; color: #0f172a; }
    .step-text p { margin: 0; font-size: 14px; color: #64748b; line-height: 1.6; }

    /* --- GRID TIPS HEMAT AIR --- */
    .tips-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 60px;
    }
    .tip-card {
        background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 32px;
        box-shadow: 0 4px 15px -3px rgba(0,0,0,0.03); transition: transform 0.3s, box-shadow 0.3s;
    }
    .tip-card:hover {
        transform: translateY(-5px); box-shadow: 0 12px 25px -5px rgba(3, 105, 161, 0.12); border-color: #cbd5e1;
    }
    .tip-icon {
        width: 56px; height: 56px; background: #e0f2fe; color: #0369a1; border-radius: 16px;
        display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 20px; border: 1px solid #bae6fd;
    }
    .tip-card h3 { font-size: 18px; color: #0f172a; margin: 0 0 12px 0; }
    .tip-card p { font-size: 14.5px; line-height: 1.6; color: #475569; margin: 0; }

    /* --- POJOK EDUKASI (FAQ STYLE) --- */
    .edu-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    .edu-card {
        background: #f8fafc; border-left: 4px solid #0ea5e9; border-radius: 12px; padding: 24px;
        border-top: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;
        transition: background 0.2s;
    }
    .edu-card:hover { background: #ffffff; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
    .edu-card h4 {
        font-size: 16px; font-weight: 800; color: #0369a1; margin: 0 0 8px 0; display: flex; align-items: center; gap: 8px;
    }
    .edu-card p { font-size: 14px; color: #475569; line-height: 1.6; margin: 0; }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 860px) {
        .highlight-card { flex-direction: column; }
        .highlight-img { width: 100%; height: 200px; border-right: none; border-bottom: 1px solid #e2e8f0; }
        .highlight-content { width: 100%; padding: 32px 24px; }
        .edu-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px; }
        .tarif-hero h1 { font-size: 28px; }
    }
</style>

<div class="edukasi-page">

    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Info Pelanggan</span>
        <h1>Edukasi & Tips Air Bersih</h1>
        <p>Kumpulan informasi bermanfaat, cara perawatan pipa, hingga tips cerdas menghemat air untuk kehidupan yang lebih baik.</p>
    </div>

    <div class="pb-wrap">

        {{-- BAGIAN 1: HIGHLIGHT (DETEKSI KEBOCORAN) --}}
        <div class="highlight-card">
            <div class="highlight-img">
                🔎💧
            </div>
            <div class="highlight-content">
                <span class="highlight-badge">Penting Diketahui</span>
                <h2>Cara Deteksi Kebocoran Pipa Mandiri</h2>
                <p>Tagihan air tiba-tiba melonjak drastis padahal pemakaian normal? Besar kemungkinan terjadi kebocoran pada instalasi pipa dalam rumah Anda (setelah meteran). Berikut cara memastikannya:</p>
                
                <ul class="step-list">
                    <li>
                        <div class="step-num">1</div>
                        <div class="step-text">
                            <h4>Tutup Semua Kran Air</h4>
                            <p>Pastikan tidak ada satupun kran yang terbuka atau alat yang menggunakan air (seperti mesin cuci) sedang menyala di dalam rumah.</p>
                        </div>
                    </li>
                    <li>
                        <div class="step-num">2</div>
                        <div class="step-text">
                            <h4>Periksa Meteran Air</h4>
                            <p>Lihat indikator putaran (baling-baling/segitiga kecil) pada meteran air PDAM di depan rumah Anda.</p>
                        </div>
                    </li>
                    <li>
                        <div class="step-num">3</div>
                        <div class="step-text">
                            <h4>Amati Putarannya</h4>
                            <p>Jika semua kran sudah ditutup <strong>tetapi indikator meteran tetap berputar</strong>, maka dipastikan ada kebocoran pada pipa instalasi dalam rumah Anda. Segera panggil tukang ledeng untuk perbaikan instalasi internal.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        {{-- BAGIAN 2: TIPS HEMAT AIR --}}
        <h2 class="section-title">💡 Tips Cerdas Menghemat Air</h2>
        <div class="tips-grid">
            
            <div class="tip-card">
                <div class="tip-icon">🚿</div>
                <h3>Gunakan Shower & Matikan Kran</h3>
                <p>Mandi menggunakan shower jauh lebih hemat air dibandingkan menggunakan gayung atau bathtub. Jangan lupa matikan kran saat Anda sedang menyabuni badan atau menggosok gigi.</p>
            </div>

            <div class="tip-card">
                <div class="tip-icon">🧺</div>
                <h3>Tunggu Cucian Penuh</h3>
                <p>Gunakan mesin cuci pakaian hanya saat kapasitasnya sudah penuh. Mencuci sedikit demi sedikit akan membuang banyak air dan listrik secara sia-sia.</p>
            </div>

            <div class="tip-card">
                <div class="tip-icon">🔧</div>
                <h3>Perbaiki Kran Menetes</h3>
                <p>Jangan sepelekan kran yang bocor atau menetes. Satu kran yang menetes terus-menerus bisa membuang hingga 15-20 liter air bersih per hari tanpa Anda sadari.</p>
            </div>

        </div>

        {{-- BAGIAN 3: POJOK EDUKASI FAQ --}}
        <h2 class="section-title">📚 Pojok Edukasi Pelanggan</h2>
        <div class="edu-grid">
            
            <div class="edu-card">
                <h4>Kenapa air terkadang keruh setelah perbaikan?</h4>
                <p>Saat terjadi perbaikan pipa bocor di jalan, aliran air harus dimatikan sementara. Ketika air dialirkan kembali, endapan di dalam pipa akan terdorong keluar. Buka kran Anda beberapa saat hingga air kembali jernih.</p>
            </div>

            <div class="edu-card">
                <h4>Apa itu Instalasi Pipa Dalam & Luar?</h4>
                <p>Pipa PDAM sebelum meteran (termasuk meteran) adalah tanggung jawab PDAM. Sedangkan pipa setelah meteran yang masuk ke dalam rumah adalah <strong>Instalasi Dalam</strong> dan menjadi tanggung jawab penuh pelanggan.</p>
            </div>

            <div class="edu-card">
                <h4>Mengapa tekanan air kecil di jam tertentu?</h4>
                <p>Pada "Jam Puncak" (biasanya pagi hari pukul 05:00-08:00 dan sore hari), mayoritas pelanggan menggunakan air secara bersamaan, sehingga tekanan aliran di jaringan pipa terbagi dan bisa sedikit melemah.</p>
            </div>

            <div class="edu-card">
                <h4>Bolehkah memodifikasi area Meteran Air?</h4>
                <p>Pelanggan <strong>dilarang keras</strong> merusak, memindahkan, atau memodifikasi segel dan meteran air PDAM. Biarkan area sekitar meteran bersih agar mempermudah petugas kami saat mencatat meteran setiap bulan.</p>
            </div>

        </div>

    </div>
</div>

@endsection