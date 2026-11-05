@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap');

    body {
        background-color: #f8fafc;
    }

    .pb-page {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: #334155;
    }
    .pb-page h1, .pb-page h2, .pb-page h3 {
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

    /* --- FORM WRAPPER & CARD --- */
    .pb-wrap {
        max-width: 950px;
        margin: 0 auto 80px auto;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
    }
    .form-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px -5px rgba(3, 105, 161, 0.08);
        border: 1px solid #e2e8f0;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }
    .form-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 5px;
        background: linear-gradient(90deg, #0ea5e9, #0369a1);
    }

    /* --- ALERTS --- */
    .alert-success {
        background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;
        padding: 16px 20px; border-radius: 12px; margin-bottom: 30px;
        display: flex; align-items: center; gap: 12px; font-weight: 600; font-size: 15px;
    }
    .alert-error {
        background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
        padding: 16px 20px; border-radius: 12px; margin-bottom: 30px;
    }
    .alert-error ul { margin: 0; padding-left: 20px; font-size: 14.5px; line-height: 1.6; }
    
    /* --- FORM SECTIONS --- */
    .form-section {
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px dashed #cbd5e1;
    }
    .form-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 30px;
    }
    .form-section h3 {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 24px 0;
    }
    .step-badge {
        background: #e0f2fe; color: #0369a1;
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; font-weight: 800;
    }

    /* --- FORM CONTROLS & GRID --- */
    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .form-grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 2fr;
        gap: 20px;
    }
    .input-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }
    .input-group.full-width { grid-column: 1 / -1; }
    
    .input-label {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        font-size: 14.5px;
    }
    .input-label span { color: #ef4444; }
    
    .form-control {
        width: 100%;
        padding: 14px 16px;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        font-family: inherit;
        font-size: 15px;
        color: #334155;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .form-control::placeholder { color: #94a3b8; }
    .form-control:focus {
        outline: none;
        background: #ffffff;
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px #e0f2fe;
    }
    textarea.form-control { resize: vertical; min-height: 100px; }

    /* --- FILE UPLOAD --- */
    .file-upload-box {
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
        text-align: center;
        transition: all 0.2s ease;
    }
    .file-upload-box:hover { border-color: #0ea5e9; background: #f0f9ff; }
    .file-upload-input {
        width: 100%; font-family: inherit; font-size: 13.5px; color: #475569; cursor: pointer;
    }
    .file-upload-input::file-selector-button {
        background: #e2e8f0; border: none; padding: 8px 14px; border-radius: 8px;
        color: #0f172a; font-weight: 600; cursor: pointer; margin-right: 12px;
        transition: background 0.2s ease;
    }
    .file-upload-input::file-selector-button:hover { background: #cbd5e1; }

    /* --- SUBMIT BUTTON --- */
    .btn-submit {
        background: linear-gradient(135deg, #0ea5e9, #0369a1);
        color: #ffffff; padding: 18px 32px; border: none; border-radius: 12px;
        font-size: 16px; font-weight: 800; cursor: pointer; width: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(14, 165, 233, 0.4);
    }

    /* --- RESPONSIVE MOBILE --- */
    @media (max-width: 768px) {
        .tarif-hero { padding: 64px 20px 48px; }
        .tarif-hero h1 { font-size: 28px; }
        .form-card { padding: 24px; }
        .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; gap: 0; }
        .form-section h3 { font-size: 18px; }
    }
</style>

<div class="pb-page">
    
    {{-- HERO SECTION --}}
    <div class="tarif-hero">
        <span class="pb-eyebrow"><span class="dot"></span>Layanan Pelanggan</span>
        <h1>Formulir Pendaftaran Pasang Baru</h1>
        <p>Silakan isi data dengan lengkap dan benar. Data ini akan digunakan petugas untuk proses survei lapangan ke lokasi Anda.</p>
    </div>

    <div class="pb-wrap">
        <div class="form-card">
            <form action="{{ route('pelanggan.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf 

                {{-- ALERT SUKSES --}}
                @if(session('sukses'))
                    <div class="alert-success">
                        <span style="font-size: 20px;">✅</span> 
                        <div>{{ session('sukses') }}</div>
                    </div>
                @endif
                
                {{-- ALERT ERROR --}}
                @if ($errors->any())
                    <div class="alert-error">
                        <div style="font-weight: 700; margin-bottom: 8px;">⚠️ Terdapat kesalahan pengisian:</div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- BAGIAN 1: DATA DIRI --}}
                <div class="form-section">
                    <h3><span class="step-badge">1</span> Data Diri Pemohon</h3>
                    
                    <div class="input-group full-width" style="margin-bottom: 20px;">
                        <label class="input-label">Nama Lengkap (Sesuai KTP) <span>*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="form-grid-2">
                        <div class="input-group">
                            <label class="input-label">Nomor Induk Kependudukan (NIK) <span>*</span></label>
                            <input type="number" name="nik" class="form-control" placeholder="16 digit angka NIK" required>
                        </div>
                        <div class="input-group">
                            <label class="input-label">Nomor Kartu Keluarga (KK) <span>*</span></label>
                            <input type="number" name="no_kk" class="form-control" placeholder="16 digit angka No. KK" required>
                        </div>
                        <div class="input-group">
                            <label class="input-label">Nomor HP / WhatsApp (Aktif) <span>*</span></label>
                            <input type="number" name="no_hp" class="form-control" placeholder="Contoh: 08123456xxx" required>
                        </div>
                        <div class="input-group">
                            <label class="input-label">Alamat Email (Opsional)</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com">
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 2: LOKASI --}}
                <div class="form-section">
                    <h3><span class="step-badge">2</span> Lokasi Pemasangan</h3>
                    
                    <div class="input-group full-width">
                        <label class="input-label">Alamat Lengkap (Jalan, No Rumah, Patokan) <span>*</span></label>
                        <textarea name="alamat_lengkap" class="form-control" rows="3" placeholder="Sebutkan alamat detail dan patokan rumah (misal: Samping warung warna biru)..." required></textarea>
                    </div>

                    <div class="form-grid-3">
                        <div class="input-group">
                            <label class="input-label">RT <span>*</span></label>
                            <input type="number" name="rt" class="form-control" placeholder="001" required>
                        </div>
                        <div class="input-group">
                            <label class="input-label">RW <span>*</span></label>
                            <input type="number" name="rw" class="form-control" placeholder="002" required>
                        </div>
                        <div class="input-group">
                            <label class="input-label">Kelurahan / Desa <span>*</span></label>
                            <!-- BERUBAH JADI DROPDOWN -->
                            <select name="kelurahan" id="inputKelurahan" class="form-control" required>
                                <option value="" selected disabled>-- Pilih Kecamatan Dulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="input-group">
                            <label class="input-label">Kecamatan <span>*</span></label>
                            <select name="cabang_id" id="pilihKecamatan" class="form-control" required>
                                <option value="" selected disabled>-- Pilih Kecamatan --</option>
                                <option value="1">Kec. Bagelen</option>
                                <option value="2">Kec. Banyuurip</option>
                                <option value="3">Kec. Bayan</option>
                                <option value="4">Kec. Bener</option>
                                <option value="5">Kec. Butuh</option>
                                <option value="6">Kec. Gebang</option>
                                <option value="7">Kec. Grabag</option>
                                <option value="8">Kec. Kemiri</option>
                                <option value="9">Kec. Kutoarjo</option>
                                <option value="10">Kec. Loano</option>
                                <option value="11">Kec. Pituruh</option>
                                <option value="12">Kec. Purwodadi</option>
                                <option value="13">Kec. Purworejo</option>
                            </select>
                            {{-- Input Siluman --}}
                            <input type="hidden" name="kecamatan" id="namaKecamatan">
                        </div>
                        <div class="input-group">
                            <label class="input-label">Link Google Maps (Opsional)</label>
                            <input type="text" name="koordinat_map" class="form-control" placeholder="Tempel link share dari Maps">
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 3: DATA TEKNIS & DOKUMEN --}}
                <div class="form-section">
                    <h3><span class="step-badge">3</span> Data Teknis & Dokumen</h3>
                    
                    <div class="form-grid-2">
                        <div class="input-group">
                            <label class="input-label">Peruntukan Bangunan <span>*</span></label>
                            
                            {{-- Logika PHP bawaan dipertahankan --}}
                            @php
                                $listPeruntukan = \App\Models\TarifAir::select('kategori_golongan')
                                ->whereNotNull('kategori_golongan')
                                ->distinct()
                                ->pluck('kategori_golongan');
                            @endphp
                            
                            <select name="peruntukan" class="form-control" required>
                                <option value="" selected disabled>-- Pilih Peruntukan --</option>
                                @foreach($listPeruntukan as $peruntukan)
                                    <option value="{{ $peruntukan }}">{{ ucwords(strtolower($peruntukan)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="input-group">
                            <label class="input-label">Status Kepemilikan <span>*</span></label>
                            <select name="status_kepemilikan" class="form-control" required>
                                <option value="" selected disabled>-- Pilih Status --</option>
                                <option value="Milik Sendiri">Milik Sendiri</option>
                                <option value="Sewa / Kontrak">Sewa / Kontrak</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-label" style="margin-top: 10px;">Upload Berkas Lampiran <span>*</span></div>
                    <div class="form-grid-2" style="margin-top: 5px;">
                        <div class="file-upload-box">
                            <div class="input-label" style="font-size: 13px;">Foto KTP (Jelas & Terbaca)</div>
                            <input type="file" name="foto_ktp" accept="image/*" required class="file-upload-input">
                        </div>
                        
                        <div class="file-upload-box">
                            <div class="input-label" style="font-size: 13px;">Foto Kartu Keluarga (KK)</div>
                            <input type="file" name="foto_kk" accept="image/*" required class="file-upload-input">
                        </div>
                        
                        <div class="file-upload-box">
                            <div class="input-label" style="font-size: 13px;">Foto Tampak Depan Rumah</div>
                            <input type="file" name="foto_rumah" accept="image/*" required class="file-upload-input">
                        </div>

                        <!-- TAMBAHAN KOTAK SELFIE KTP -->
                        <div class="file-upload-box">
                            <div class="input-label" style="font-size: 13px;">Foto Selfie Memegang KTP</div>
                            <input type="file" name="foto_selfie_ktp" accept="image/*" required class="file-upload-input">
                        </div>
                    </div>
                </div>

                {{-- SUBMIT AREA --}}
                <div style="margin-top: 10px;">
                    <button type="submit" class="btn-submit">Kirim Formulir Pendaftaran</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    // 1. DATABASE SUPER LENGKAP DESA/KELURAHAN KAB. PURWOREJO (13 Kecamatan di Form)
    // 100% CLEAN: Hanya data resmi tingkat Desa/Kelurahan (Bukan Dusun/Pedukuhan)
    const dataDesa = {
        "Kec. Bagelen": [
            "Bagelen", "Bapangsari", "Bugel", "Clapar", "Dadirejo", "Durensari", 
            "Hargorojo", "Kalirejo", "Kemanukan", "Piji", "Semagung", "Semawung", 
            "Soko", "Sokoagung", "Somorejo", "Tlogokotes"
        ],
        "Kec. Banyuurip": [
            "Bajang", "Banyuurip", "Bencal", "Borokulon", "Borowetan", "Candisari", 
            "Cengkawakrejo", "Condongsari", "Golok", "Kertosono", "Kledung Karangdalem", 
            "Kledung Kradenan", "Malangrejo", "Popongan", "Sawit", "Seborokrapyak", 
            "Sokowaten", "Sumber Sari", "Surorejo", "Tanjunganom", "Tegalkuning", 
            "Tegalrejo", "Triwarno", "Wangunrejo", "Wardasari"
        ],
        "Kec. Bayan": [
            "Awuawu", "Bandung Kidul", "Bandungrejo", "Banyu Urip", "Bayan", 
            "Besole", "Boto Daleman", "Botorejo", "Bringin", "Dukuhrejo", "Grantung", 
            "Jatingarang", "Jono", "Jrakah", "Kalimiru", "Ketiwijayan", "Krandegan", 
            "Pekutan", "Pogung Juru Tengah", "Pogungkalangan", "Pogungrejo", 
            "Pucang Agung", "Sambeng", "Sucenjurutengah", "Tangkisan", "Tanjungrejo"
        ],
        "Kec. Bener": [
            "Bener", "Benowo", "Bleber", "Cacaban Kidul", "Cacaban Lor", "Guntur", 
            "Jati", "Kalijambe", "Kalitapas", "Kaliurip", "Kamijoro", "Karangsari", 
            "Kedung Loteng", "Kedung Pucang", "Ketosari", "Legetan", "Limbangan", 
            "Mayungsari", "Medono", "Ngasinan", "Nglaris", "Pekacangan", 
            "Sendangsari", "Sukowuwuh", "Wadas"
        ],
        "Kec. Butuh": [
            "Andong", "Binangun", "Butuh", "Dlangu", "Kaliwatubumi", 
            "Kaliwatukranggan", "Karanganom", "Karangduren", "Kedungagung", 
            "Kedungmulyo", "Kedungsari", "Ketug", "Klepu", "Kunir", "Langenrejo", 
            "Lubang Dukuh", "Lubang Indangan", "Lubang Kidul", "Lubang Lor", 
            "Lubang Sampang", "Lugu", "Lugurejo", "Mangunjayan", "Panggeldlangu", 
            "Polomarto", "Rowodadi", "Sidomulyo", "Sruwohdukuh", "Sruwohrejo", 
            "Sumbersari", "Tamansari", "Tanjunganom", "Tegalgondo", "Tlogorejo", 
            "Wareng", "Wironatan", "Wonodadi", "Wonorejokulon", "Wonorejowetan"
        ],
        "Kec. Gebang": [
            "Bendosari", "Bulus", "Gebang", "Gintungan", "Kalitengkek", "Kemiri", 
            "Kragilan", "Lugosobo", "Mlaran", "Ngaglik", "Ngemplak", "Pelutan", 
            "Penungkulan", "Prumben", "Redin", "Rendeng", "Salam", "Seren", 
            "Sidoleren", "Tlogosono", "Winong Kidul", "Winong Lor"
        ],
        "Kec. Grabag": [
            "Aglik", "Bakurejo", "Banyuyoso", "Bendungan", "Dudukulon", "Dukuhdungus", 
            "Grabag", "Harjobinangun", "Kalirejo", "Kedung Kamal", "Kertojoyo", 
            "Kese", "Ketawangrejo", "Munggangsari", "Nambangan", "Pasaranom", 
            "Patutrejo", "Rejosari", "Rowodadi", "Roworejo", "Sangubanyu", 
            "Sumberagung", "Tegalrejo", "Trimulyo", "Tulusrejo", "Ukirsari", "Wonoenggal"
        ],
        "Kec. Kemiri": [
            "Bedono Kluwung", "Bedono Pageron", "Dilem", "Gedong", "Gesikan", 
            "Girijoyo", "Girimulyo", "Gunungteges", "Jatiwangsan", "Kaliglagah", 
            "Kalimeneng", "Kapiteran", "Karangluas", "Kemiri Kidul", "Kemiri Lor", 
            "Kerep", "Kroyo Kulon", "Kroyo Lor", "Loning", "Pakhis", "Purbayan", 
            "Rebug", "Rejosari", "Rejowinangun", "Rowobayem", "Samping", "Sidodadi", 
            "Sokogelap", "Sutoragan", "Turus", "Waled", "Wanurojo", "Winong", 
            "Wonosari", "Wonosuko"
        ],
        "Kec. Kutoarjo": [
            "Bandung", "Karangrejo", "Karangwuluh", "Katerban", "Kebondalem", 
            "Kemadu Lor", "Kepatihan", "Kepuh", "Kiyangkongrejo", "Kutoarjo", 
            "Kuwurejo", "Majir", "Pacor", "Pringgowijayan", "Purwosari", 
            "Semawung Daleman", "Semawung Kembaran", "Sidomulyo", "Sokoharjo", 
            "Suren", "Tepus Kulon", "Tepus Wetan", "Tunggorono", "Turgobogo", "Wirun"
        ],
        "Kec. Loano": [
            "Banyuasin Kembaran", "Banyuasin Separe", "Guyangan", "Jetis", 
            "Kaliglagah", "Kalikalong", "Karangrejo", "Kebon Gunung", "Kedungpoh", 
            "Kemejing", "Loano", "Maron", "Mudal", "Ngargosari", "Rimun", "Sedayu", 
            "Tridadi", "Trirejo"
        ],
        "Kec. Pituruh": [
            "Blekatuk", "Brengkol", "Cibodas", "Dlisen Kulon", "Dlisen Wetan", 
            "Girigondo", "Gumawangrejo", "Kaligintung", "Kaligondang", "Kalijering", 
            "Kalikotes", "Kalimati", "Karanganyar", "Karanggetas", "Keburusan", 
            "Kedungbatur", "Kendalrejo", "Kesawen", "Luweng Kidul", "Luweng Lor", 
            "Megulung Kidul", "Megulung Lor", "Ngampel", "Ngandagan", "Pamriyan", 
            "Pangkalan", "Pekacangan", "Pepe", "Petuguran", "Pituruh", "Polita", 
            "Prapag Kidul", "Prapag Lor", "Prigelan", "Ringgit", "Sawangan", 
            "Sikambang", "Somorejo", "Sumber", "Tapen", "Tasikmadu", "Tersidi Kidul", 
            "Tersidi Lor", "Tunjungtejo", "Wironatan", "Wonosido", "Wonoyoso"
        ],
        "Kec. Purwodadi": [
            "Banjarsari", "Blendung", "Bongkot", "Bragolan", "Budiarjo", "Dadirejo", 
            "Gagaksipat", "Geparang", "Gesing", "Guyangan", "Jatikontal", 
            "Jatimalang", "Jukong", "Karanganyar", "Karangmulyo", "Karangsari", 
            "Kebonsari", "Keduren", "Kentengrejo", "Keponggok", "Kesugihan", 
            "Ketangi", "Nampu", "Ngentak", "Ngrandu", "Paduroso", "Panggeldlangu", 
            "Pleret", "Purwodadi", "Purwosari", "Sendangsari", "Sidoharjo", 
            "Sidomulyo", "Sukomanah", "Sumberejo", "Sumbersari", "Tlogorejo", 
            "Tulusrejo", "Watukuro"
        ],
        "Kec. Purworejo": [
            "Baledono", "Brenggong", "Cangkrep Kidul", "Cangkrep Lor", "Donorati", 
            "Doplang", "Ganggeng", "Kedungsari", "Keseneng", "Mranti", "Mudal", 
            "Pacekelan", "Paduroso", "Pangenjurutengah", "Pangenrejo", "Plipir", 
            "Purworejo", "Semawung", "Sidomulyo", "Sindurjan", "Sudimoro", 
            "Tambakrejo", "Wonoroto", "Wonotulus"
        ]
    };

    // TRIGGER OTOMATIS SAAT KECAMATAN DIPILIH
    document.getElementById('pilihKecamatan').addEventListener('change', function() {
        let namaKec = this.options[this.selectedIndex].text;
        
        // Isi input siluman buat dilempar ke database
        document.getElementById('namaKecamatan').value = namaKec;

        let selectKelurahan = document.getElementById('inputKelurahan');
        selectKelurahan.innerHTML = '<option value="" selected disabled>-- Pilih Kelurahan/Desa --</option>';

        if (dataDesa[namaKec]) {
            // Urutin abjad A-Z biar warga gampang carinya
            let desaUrut = dataDesa[namaKec].sort();
            
            desaUrut.forEach(function(desa) {
                let opt = document.createElement('option');
                opt.value = desa;
                opt.innerHTML = desa;
                selectKelurahan.appendChild(opt);
            });
        } else {
            let opt = document.createElement('option');
            opt.value = "-";
            opt.innerHTML = "Desa Belum Tersedia";
            selectKelurahan.appendChild(opt);
        }
    });
</script>
@endsection