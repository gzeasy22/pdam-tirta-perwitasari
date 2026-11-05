@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .tarif-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .tarif-page h1, .tarif-page h2, .tarif-page h3, .tarif-page h4 {
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
        margin-bottom: 40px;
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

    /* --- WRAPPER & CARDS --- */
    .pb-wrap {
        max-width: 1100px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }
    .card-ui {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px -5px rgba(3, 105, 161, 0.08);
        border: 1px solid #e2e8f0;
        margin-bottom: 32px;
        overflow: hidden;
    }

    /* --- INFO SECTION --- */
    .info-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 32px;
        padding: 40px;
    }
    .info-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .info-desc {
        font-size: 15px;
        line-height: 1.7;
        color: #475569;
        margin: 0 0 20px 0;
    }
    .callout-box {
        background: #f0f9ff;
        border-left: 4px solid #0ea5e9;
        padding: 16px 20px;
        border-radius: 0 12px 12px 0;
        font-size: 14.5px;
        color: #334155;
        line-height: 1.6;
    }
    .benefit-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
    }
    .benefit-title {
        font-weight: 800;
        color: #10b981;
        font-size: 16px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .benefit-list {
        list-style: none; padding: 0; margin: 0;
    }
    .benefit-list li {
        display: flex; align-items: flex-start; gap: 10px;
        margin-bottom: 12px; font-size: 14.5px; color: #475569; line-height: 1.6;
    }
    .benefit-list li:last-child { margin-bottom: 0; }
    .benefit-list li::before {
        content: '✓'; color: #0ea5e9; font-weight: bold; margin-top: 2px;
    }

    /* --- TABLE SECTION --- */
    .table-header-box {
        background: linear-gradient(90deg, #0ea5e9, #0369a1);
        color: white;
        padding: 20px 32px;
        font-size: 18px;
        font-weight: 800;
    }
    .table-responsive {
        overflow-x: auto;
        padding: 0 20px 20px 20px;
    }
    .tarif-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        margin-top: 20px;
    }
    .tarif-table th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }
    .tarif-table td {
        padding: 16px;
        color: #334155;
        font-size: 14.5px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .tarif-table tbody tr:hover { background: #f0f9ff; }
    .col-kategori { font-weight: 700; color: #0369a1; }
    .col-harga { font-family: monospace; font-size: 15px; font-weight: 600; text-align: center; }
    .text-center { text-align: center; }

    /* --- DETAIL GRID (KETERANGAN & METER) --- */
    .detail-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 32px;
        margin-bottom: 32px;
    }
    .detail-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px -2px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        padding: 32px;
    }
    .detail-card h3 {
        margin: 0 0 24px 0;
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .keterangan-list {
        list-style: none; padding: 0; margin: 0;
    }
    .keterangan-list li {
        display: flex; gap: 12px; margin-bottom: 16px;
        font-size: 14.5px; color: #475569; line-height: 1.6;
    }
    .keterangan-list .num {
        background: #e0f2fe; color: #0369a1;
        width: 24px; height: 24px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 12px; flex-shrink: 0; margin-top: 2px;
    }
    
    .meter-table {
        width: 100%; border-collapse: collapse; font-size: 14.5px;
    }
    .meter-table th {
        padding: 12px 0; color: #64748b; font-size: 13px; border-bottom: 2px solid #e2e8f0; text-align: left;
    }
    .meter-table th:last-child { text-align: right; }
    .meter-table td {
        padding: 14px 0; border-bottom: 1px solid #f1f5f9; color: #334155;
    }
    .meter-table td:last-child {
        text-align: right; font-weight: 700; color: #0f172a; font-family: monospace; font-size: 15px;
    }

    /* --- CALCULATOR SECTION --- */
    .calc-body {
        padding: 40px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: start;
    }
    .calc-form-group { margin-bottom: 24px; }
    .calc-form-group label {
        display: block; font-weight: 700; color: #0f172a; font-size: 14.5px; margin-bottom: 8px;
    }
    .form-control-calc {
        width: 100%; padding: 14px 16px;
        background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 12px;
        font-family: inherit; font-size: 15px; color: #334155;
        transition: all 0.2s; box-sizing: border-box;
    }
    .form-control-calc:focus {
        outline: none; background: #fff; border-color: #0ea5e9; box-shadow: 0 0 0 4px #e0f2fe;
    }
    select.form-control-calc {
        cursor: pointer; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 16px center; padding-right: 40px;
    }
    
    .grid-2-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .btn-calc {
        width: 100%; padding: 16px; margin-top: 10px;
        background: linear-gradient(135deg, #0ea5e9, #0369a1); color: white;
        border: none; border-radius: 12px; font-size: 16px; font-weight: 800; cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
    }
    .btn-calc:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4); }

    .result-box {
        background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px;
        padding: 32px; display: flex; flex-direction: column; justify-content: center; align-items: center;
        color: #94a3b8; text-align: center; min-height: 380px; transition: all 0.3s;
    }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 900px) {
        .info-grid, .detail-grid, .calc-body { grid-template-columns: 1fr; gap: 24px; }
        .calc-body { padding: 32px 24px; }
    }
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px 20px; }
        .tarif-hero h1 { font-size: 28px; }
        .info-grid { padding: 24px; }
        .table-header-box { padding: 16px 20px; font-size: 16px; }
        .detail-card { padding: 24px; }
        .grid-2-cols { grid-template-columns: 1fr; }
    }
</style>

<div class="tarif-page">
    
    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Layanan Informasi</span>
        <h1>Tarif & Simulasi Tagihan</h1>
        <p>Rincian lengkap golongan tarif air dan kalkulator estimasi perhitungan tagihan bulanan pelanggan PDAM Tirta Perwitasari.</p>
    </div>

    <div class="pb-wrap">

        {{-- INFO PENERAPAN --}}
        <div class="card-ui">
            <div class="info-grid">
                <div>
                    <h2 class="info-title">Penerapan Tarif Tahun 2026</h2>
                    <p class="info-desc">PDAM Tirta Perwitasari menerapkan tarif sesuai dengan Peraturan Bupati (Perbup) Kabupaten Purworejo Nomor 6 Tahun 2023 tentang Tarif Air Minum Perusahaan Umum Daerah Air Minum Tirta Perwitasari.</p>
                    <div class="callout-box">
                        <strong style="color:#0f172a; display:block; margin-bottom:4px;">Dasar Penetapan Tarif:</strong>
                        Keterjangkauan dan keadilan, mutu pelayanan, pemulihan biaya, efisiensi pemakaian air, perlindungan air baku, transparansi dan akuntabilitas.
                    </div>
                </div>
                <div class="benefit-box">
                    <div class="benefit-title">✨ Keuntungan Menjadi Pelanggan</div>
                    <ul class="benefit-list">
                        <li>Kualitas air terjamin sesuai Permenkes No 492 Tahun 2010.</li>
                        <li>Suplai distribusi stabil dengan tekanan air yang terukur.</li>
                        <li>Pemantauan kualitas air secara berkala oleh laboratorium.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- TABEL TARIF --}}
        <div class="card-ui">
            <div class="table-header-box">
                📊 Daftar Tarif Air Per Kubik (m³)
            </div>
            <div class="table-responsive">
                <table class="tarif-table">
                    <thead>
                        <tr>
                            <th>Kelompok Golongan</th>
                            <th>Sub Golongan</th>
                            <th class="text-center">Blok I (0-10 m³)</th>
                            <th class="text-center">Blok II (11-20 m³)</th>
                            <th class="text-center">Blok III (>20 m³)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tarifs->sortBy([['kategori_golongan', 'asc'], ['sub_golongan', 'asc']]) as $t)
                        <tr>
                            <td class="col-kategori">{{ $t->kategori_golongan }}</td>
                            <td>{{ $t->sub_golongan }}</td>
                            <td class="col-harga text-center">Rp {{ number_format($t->tarif_blok_1, 0, ',', '.') }}</td>
                            <td class="col-harga text-center">Rp {{ number_format($t->tarif_blok_2, 0, ',', '.') }}</td>
                            <td class="col-harga text-center">Rp {{ number_format($t->tarif_blok_3, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 30px; color:#94a3b8;">Data tarif belum dikonfigurasi oleh admin.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- KETERANGAN & BIAYA METER --}}
        <div class="detail-grid">
            <div class="detail-card">
                <h3>📌 Syarat & Ketentuan Berlaku</h3>
                <ul class="keterangan-list">
                    <li><span class="num">1</span><span>Tarif untuk golongan rumah tangga, sosial, dan instansi berlaku minimal pemakaian 10 m³.</span></li>
                    <li><span class="num">2</span><span>Tarif untuk golongan niaga dan industri berlaku minimal pemakaian 20 m³.</span></li>
                    <li><span class="num">3</span><span>Pembayaran tagihan setelah tanggal 20 akan dikenakan denda Rp 10.000 / rekening.</span></li>
                    <li><span class="num">4</span><span>Penambahan biaya materai senilai Rp 10.000 jika nilai tagihan lebih dari Rp 5.000.000.</span></li>
                    <li><span class="num">5</span><span>Beban tetap dihitung dari biaya administrasi (Rp 2.500) dan biaya pemeliharaan meter air (sesuai ukuran diameter).</span></li>
                </ul>
            </div>

            <div class="detail-card">
                <h3>⚙️ Pemeliharaan Meter</h3>
                <table class="meter-table">
                    <thead>
                        <tr>
                            <th>Ukuran (Inchi)</th>
                            <th>Biaya / Bulan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>0,5"</td><td>Rp 6.000</td></tr>
                        <tr><td>0,75"</td><td>Rp 9.350</td></tr>
                        <tr><td>1"</td><td>Rp 12.850</td></tr>
                        <tr><td>1,5"</td><td>Rp 30.350</td></tr>
                        <tr><td>2"</td><td>Rp 47.250</td></tr>
                        <tr><td>3"</td><td>Rp 68.250</td></tr>
                        <tr><td>10"</td><td>Rp 106.150</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- KALKULATOR SIMULASI --}}
        <div class="card-ui">
            <div class="table-header-box" style="background: #1e293b;">
                🧮 Kalkulator Simulasi Tagihan Mandiri
            </div>
            <div class="calc-body">
                
                {{-- Form Kiri --}}
                <div>
                    <div class="calc-form-group">
                        <label>Pilih Sub Golongan:</label>
                        <select id="simulasi_golongan" class="form-control-calc">
                            <option value="" disabled selected>-- Pilih Golongan Rumah/Usaha Anda --</option>
                            @foreach($tarifs as $t)
                                <option value="{{ $t->sub_golongan }}">{{ $t->sub_golongan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="calc-form-group">
                        <label>Ukuran Meter Air (Inchi):</label>
                        <select id="simulasi_meter" class="form-control-calc">
                            <option value="0,5">0,5 Inchi — Beban Rp 6.000</option>
                            <option value="0,75">0,75 Inchi — Beban Rp 9.350</option>
                            <option value="1">1 Inchi — Beban Rp 12.850</option>
                            <option value="1,5">1,5 Inchi — Beban Rp 30.350</option>
                            <option value="2">2 Inchi — Beban Rp 47.250</option>
                            <option value="3">3 Inchi — Beban Rp 68.250</option>
                            <option value="10">10 Inchi — Beban Rp 106.150</option>
                        </select>
                    </div>

                    <div class="grid-2-cols">
                        <div class="calc-form-group">
                            <label>Angka Meter Awal:</label>
                            <input type="number" id="simulasi_awal" value="0" min="0" class="form-control-calc">
                        </div>
                        <div class="calc-form-group">
                            <label>Angka Meter Akhir:</label>
                            <input type="number" id="simulasi_akhir" value="0" min="0" class="form-control-calc">
                        </div>
                    </div>

                    <button onclick="hitungSimulasi()" class="btn-calc">Hitung Estimasi Tagihan</button>
                </div>

                {{-- Result Kanan --}}
                <div id="hasil_box" class="result-box">
                    <span style="font-size: 40px; margin-bottom: 16px;">🧾</span>
                    <p style="margin:0; line-height:1.6;">Masukkan data penggunaan air Anda di form sebelah kiri untuk melihat rincian kalkulasi biaya bulan ini.</p>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    // Tarik data tarif asli dari database Laravel
    const dataTarifDariDb = @json($tarifs);

    function hitungSimulasi() {
        const golTerpilih = document.getElementById('simulasi_golongan').value;
        const meterAwal = parseInt(document.getElementById('simulasi_awal').value) || 0;
        const meterAkhir = parseInt(document.getElementById('simulasi_akhir').value) || 0;
        const ukuranMeter = document.getElementById('simulasi_meter').value;

        if (!golTerpilih) {
            alert('Silakan pilih Sub Golongan tarif terlebih dahulu!');
            return;
        }

        if (meterAkhir < meterAwal) {
            alert('Angka meteran akhir tidak boleh lebih kecil dari meteran awal!');
            return;
        }

        const aturan = dataTarifDariDb.find(item => item.sub_golongan === golTerpilih);
        if (!aturan) {
            alert('Aturan tarif golongan tidak ditemukan!');
            return;
        }

        const pemakaianMurni = meterAkhir - meterAwal;
        const minPakai = parseInt(aturan.min_pakai);
        const pemakaianHitung = pemakaianMurni < minPakai ? minPakai : pemakaianMurni;
        
        let biayaAir = 0;
        const blok1 = parseInt(aturan.tarif_blok_1);
        const blok2 = parseInt(aturan.tarif_blok_2);
        const blok3 = parseInt(aturan.tarif_blok_3);

        if (pemakaianHitung <= 10) {
            biayaAir = pemakaianHitung * blok1;
        } else if (pemakaianHitung <= 20) {
            biayaAir = (10 * blok1) + ((pemakaianHitung - 10) * blok2);
        } else {
            biayaAir = (10 * blok1) + (10 * blok2) + ((pemakaianHitung - 20) * blok3);
        }

        const daftarHargaMeter = {
            '0,5': 6000, '0,75': 9350, '1': 12850, '1,5': 30350,
            '2': 47250, '3': 68250, '10': 106150
        };
        const biayaMeter = daftarHargaMeter[ukuranMeter] || 6000;
        const biayaAdmin = 2500;

        let totalTagihan = biayaAir + biayaAdmin + biayaMeter;
        let biayaMaterai = 0;

        if (totalTagihan > 5000000) {
            biayaMaterai = 10000;
            totalTagihan += biayaMaterai;
        }

        const formatRupiah = (angka) => 'Rp ' + angka.toLocaleString('id-ID');
        
        // CSS in JS untuk kotak hasil yang rapi
        let htmlHasil = `
            <div style="width: 100%; text-align: left; color: #334155; display: flex; flex-direction: column; height: 100%;">
                <h3 style="color: #0f172a; margin-top: 0; margin-bottom: 20px; font-size: 18px; font-weight: 800; display: flex; align-items: center; justify-content: space-between;">
                    Rincian Kalkulasi <span>🧾</span>
                </h3>
                
                <div style="background: #f0f9ff; border: 1px solid #bae6fd; padding: 20px; border-radius: 12px; text-align: center; margin-bottom: 24px;">
                    <span style="font-size: 14px; color: #0369a1; font-weight: 600; display: block; margin-bottom: 8px;">Total Estimasi Tagihan</span>
                    <strong style="font-size: 32px; color: #0ea5e9; font-weight: 800; letter-spacing: -1px;">${formatRupiah(totalTagihan)}</strong>
                </div>

                <div style="font-size: 14.5px; line-height: 1.6; flex-grow: 1;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed #cbd5e1; padding-bottom: 12px; margin-bottom: 12px;">
                        <span style="color:#64748b;">Golongan Tarif:</span>
                        <strong style="color:#0f172a;">${golTerpilih}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed #cbd5e1; padding-bottom: 12px; margin-bottom: 12px;">
                        <span style="color:#64748b;">Jumlah Pemakaian:</span>
                        <strong style="color:#0f172a;">${pemakaianMurni} m³ ${pemakaianMurni < minPakai ? '<br><small style="color:#ef4444; font-weight:600;">(Dihitung Min. '+minPakai+' m³)</small>' : ''}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color:#64748b;">Biaya Pemakaian Air:</span>
                        <strong style="color:#0f172a; font-family:monospace; font-size:15px;">${formatRupiah(biayaAir)}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color:#64748b;">Biaya Pemeliharaan Meter:</span>
                        <strong style="color:#0f172a; font-family:monospace; font-size:15px;">${formatRupiah(biayaMeter)}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color:#64748b;">Biaya Administrasi:</span>
                        <strong style="color:#0f172a; font-family:monospace; font-size:15px;">${formatRupiah(biayaAdmin)}</strong>
                    </div>`;

        if (biayaMaterai > 0) {
            htmlHasil += `
                    <div style="display: flex; justify-content: space-between; margin-top: 12px; padding-top: 12px; border-top: 1px solid #e2e8f0; color: #d97706;">
                        <span style="font-weight:600;">Biaya Materai (> 5 Juta):</span>
                        <strong style="font-family:monospace; font-size:15px;">${formatRupiah(biayaMaterai)}</strong>
                    </div>`;
        }

        htmlHasil += `
                </div>
                <div style="margin-top: 24px; padding: 12px 16px; background: #fef2f2; color: #b91c1c; border-radius: 8px; font-size: 13px; font-weight: 600; line-height: 1.5; border: 1px solid #fecaca;">
                    ⚠️ Pembayaran setelah tgl 20 dikenakan denda keterlambatan Rp 10.000/rekening.
                </div>
            </div>
        `;

        let box = document.getElementById('hasil_box');
        box.innerHTML = htmlHasil;
        box.style.border = "none";
        box.style.background = "#ffffff";
        box.style.boxShadow = "0 4px 20px -2px rgba(0,0,0,0.05)";
        box.style.border = "1px solid #e2e8f0";
    }
</script>
@endsection