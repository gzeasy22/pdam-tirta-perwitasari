@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .wilayah-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .wilayah-page h1, .wilayah-page h2, .wilayah-page h3 {
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

    /* --- WRAPPER & GRID --- */
    .pb-wrap {
        max-width: 1100px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }
    
    .wilayah-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        border-bottom: 2px dashed #cbd5e1;
        padding-bottom: 16px;
    }
    .wilayah-stats h2 {
        font-size: 22px; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px;
    }
    .wilayah-stats .badge-total {
        background: #e0f2fe; color: #0369a1; padding: 6px 16px; border-radius: 999px; font-weight: 800; font-size: 14px;
    }

    .wilayah-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    /* --- CARDS --- */
    .wilayah-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 24px;
        box-shadow: 0 4px 15px -3px rgba(0,0,0,0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        display: flex;
        flex-direction: column;
    }
    .wilayah-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px -5px rgba(3, 105, 161, 0.12);
        border-color: #bae6fd;
    }

    .card-header {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 20px;
    }
    .icon-box {
        width: 48px; height: 48px; background: #f0f9ff; color: #0ea5e9; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;
    }
    .card-title-group h3 {
        font-size: 18px; color: #0f172a; margin: 0 0 4px 0;
    }
    .card-title-group p {
        font-size: 13.5px; color: #64748b; margin: 0;
    }

    .card-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px dashed #e2e8f0;
    }
    .badge-aktif {
        background: #dcfce3; color: #166534; padding: 6px 12px; border-radius: 8px;
        font-size: 12.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #bbf7d0;
    }
    .badge-aktif::before {
        content: ''; display: block; width: 6px; height: 6px; background: #22c55e; border-radius: 50%;
    }

    .btn-detail {
        background: #ffffff; color: #0ea5e9; border: 1px solid #0ea5e9; padding: 6px 16px; border-radius: 8px;
        font-size: 13.5px; font-weight: 700; cursor: pointer; transition: 0.2s; text-decoration: none;
    }
    .btn-detail:hover { background: #0ea5e9; color: #ffffff; }

    /* --- UNDER DEVELOPMENT BOX --- */
    .dev-box {
        background: #fffbeb;
        border: 2px dashed #fcd34d;
        border-radius: 16px;
        padding: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .dev-icon {
        font-size: 40px; flex-shrink: 0;
    }
    .dev-content h4 {
        margin: 0 0 8px 0; color: #b45309; font-size: 18px; font-weight: 800;
    }
    .dev-content p {
        margin: 0; color: #92400e; font-size: 15px; line-height: 1.6;
    }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px 20px; }
        .tarif-hero h1 { font-size: 28px; }
        .wilayah-stats { flex-direction: column; align-items: flex-start; gap: 12px; }
        .dev-box { flex-direction: column; text-align: center; }
    }
</style>

<div class="wilayah-page">

    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Informasi Publik</span>
        <h1>Cakupan Wilayah Pelayanan</h1>
        <p>Data area cakupan distribusi air bersih PDAM Tirta Perwitasari di seluruh wilayah Kabupaten Purworejo.</p>
    </div>

    <div class="pb-wrap">

        {{-- ARRAY PHP BAWAAN (Gak Disentuh) --}}
        @php
            $wilayah = [
                'Bagelen', 'Banyuurip', 'Bayan', 'Bener', 'Butuh', 
                'Gebang', 'Grabag', 'Kemiri', 'Kutoarjo', 'Loano', 
                'Pituruh', 'Purwodadi', 'Purworejo'
            ];
        @endphp

        <div class="wilayah-stats">
            <h2>📍 Daftar Kecamatan Terjangkau</h2>
            <span class="badge-total">Total: {{ count($wilayah) }} Kecamatan</span>
        </div>

        {{-- GRID KARTU KECAMATAN --}}
        <div class="wilayah-grid">
            @foreach($wilayah as $index => $item)
            <div class="wilayah-card">
                
                <div class="card-header">
                    <div class="icon-box">🗺️</div>
                    <div class="card-title-group">
                        <h3>Kec. {{ $item }}</h3>
                        <p>Kabupaten Purworejo, Jawa Tengah</p>
                    </div>
                </div>

                <div class="card-status">
                    <span class="badge-aktif">Tersedia</span>
                    {{-- Tombol Detail bisa diarahin ke route spesifik nantinya --}}
                    <button class="btn-detail" onclick="bukaModal('{{ $item }}')">Detail Area</button>
                </div>

            </div>
            @endforeach
        </div>

        {{-- AREA CATATAN PENGEMBANGAN --}}
        <div class="dev-box">
            <div class="dev-icon">🚧</div>
            <div class="dev-content">
                <h4>Tahap Pengembangan Jaringan</h4>
                <p>Harap bersabar, untuk wilayah <strong>Kecamatan Bruno, Kaligesing, dan Ngombol</strong> saat ini masih dalam tahap survei dan pengembangan infrastruktur jaringan pipa distribusi air bersih.</p>
            </div>
        </div>

    </div>
</div>
<div id="detailModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background: white; width: 90%; max-width: 500px; padding: 30px; border-radius: 16px; position: relative;">
        <h3 id="modalTitle" style="margin:0 0 15px 0; color:#0f172a;">Detail Kecamatan</h3>
        <p id="modalBody" style="color:#475569; line-height:1.6;"></p>
        <button onclick="tutupModal()" style="width:100%; padding:12px; background:#e2e8f0; border:none; border-radius:8px; font-weight:700; cursor:pointer; margin-top:20px;">Tutup</button>
    </div>
</div>
@endsection
<script>
    function bukaModal(namaKec) {
        const modal = document.getElementById('detailModal');
        const title = document.getElementById('modalTitle');
        const body = document.getElementById('modalBody');

        title.innerText = "Info Kecamatan " + namaKec;
        body.innerHTML = `Layanan air bersih di <strong>Kec. ${namaKec}</strong> sudah tersedia dengan jaringan pipa distribusi utama. Jika ada keluhan teknis atau pengajuan pasang baru, silakan hubungi admin kami melalui WhatsApp.`;
        
        modal.style.display = 'flex';
    }

    function tutupModal() {
        document.getElementById('detailModal').style.display = 'none';
    }
    
    // Klik di luar modal buat nutup
    window.onclick = function(event) {
        if (event.target == document.getElementById('detailModal')) tutupModal();
    }
</script>