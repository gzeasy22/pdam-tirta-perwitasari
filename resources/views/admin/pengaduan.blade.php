@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap');

    :root {
        --primary: #3b82f6; --primary-hover: #2563eb; --primary-light: #eff6ff;
        --success: #10b981; --success-hover: #059669; --success-light: #ecfdf5;
        --warning: #f59e0b; --warning-light: #fffbeb;
        --danger: #ef4444; --danger-hover: #dc2626; --danger-light: #fef2f2;
        --info: #0ea5e9; --info-hover: #0284c7;
        --dark: #0f172a; --text: #334155; --text-muted: #64748b; --text-light: #94a3b8;
        --border: #e2e8f0; --bg-page: #f8fafc; --bg-card: #ffffff;
        --radius-sm: 6px; --radius-md: 8px; --radius-lg: 12px; --radius-full: 9999px;
        --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
        --transition: all 0.2s ease;
    }

    .page-wrapper, .page-wrapper * { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
    .page-header h2, .modal-head h3 { font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }

    .page-wrapper { padding: 24px; }
    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-size: 22px; font-weight: 700; color: var(--dark); margin: 0 0 6px 0; display: flex; align-items: center; gap: 10px; }
    .page-header p { font-size: 14px; color: var(--text-muted); margin: 0; }

    /* ========== SEARCH TOOLBAR ========== */
    .toolbar { display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px; gap: 10px; flex-wrap: wrap; }
    .toolbar input[type="text"] { padding: 10px 16px; border: 1px solid var(--border); border-radius: var(--radius-md); width: 270px; font-size: 14px; color: var(--text); background: var(--bg-card); transition: var(--transition); outline: none; }
    .toolbar input[type="text"]:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12); }
    .toolbar input[type="text"]::placeholder { color: var(--text-light); }

    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 10px 18px; border: none; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; transition: var(--transition); white-space: nowrap; line-height: 1.4; }
    .btn:hover { transform: translateY(-1px); box-shadow: var(--shadow-md); }
    .btn:active { transform: translateY(0); }
    .btn:focus-visible { outline: 2px solid var(--primary); outline-offset: 2px; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: var(--primary-hover); }
    .btn-danger { background: var(--danger); color: #fff; }
    .btn-danger:hover { background: var(--danger-hover); }
    .btn-sm { padding: 8px 14px; font-size: 13px; }

    /* ========== TABLE ========== */
    .table-card { background: var(--bg-card); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; box-shadow: var(--shadow-sm); }
    .table-card table { width: 100%; border-collapse: collapse; }
    .table-card thead { background: var(--bg-page); }
    .table-card thead th { padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid var(--border); }
    .table-card tbody tr { transition: var(--transition); }
    .table-card tbody tr:hover { background: #f1f5f9; }
    .table-card tbody td { padding: 16px 18px; font-size: 14px; color: var(--text); border-bottom: 1px solid var(--border); vertical-align: middle; }
    .table-card tbody tr:last-child td { border-bottom: none; }
    .cell-name strong { display: block; font-weight: 600; color: var(--dark); margin-bottom: 2px; }
    .cell-sub { font-size: 12px; color: var(--text-muted); }
    .cell-desc { color: var(--text); line-height: 1.5; }

    /* ========== BADGES ========== */
    .badge-pelapor { display: inline-block; margin-top: 6px; padding: 3px 10px; border-radius: 12px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .badge-umum { background: var(--warning-light); color: #d97706; border: 1px solid #fde68a; }
    .badge-pelanggan { background: var(--primary-light); color: #1d4ed8; border: 1px solid #bfdbfe; }

    /* ========== STATUS SELECT ========== */
    .status-select { appearance: none; -webkit-appearance: none; padding: 6px 30px 6px 14px; border-radius: var(--radius-full); font-size: 12px; font-weight: 700; cursor: pointer; outline: none; transition: var(--transition); background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; box-shadow: var(--shadow-sm); }
    .status-select:focus { box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); }
    .status-open { background-color: var(--danger-light); color: #991b1b; border: 1px solid #fecaca; }
    .status-proses { background-color: var(--warning-light); color: #92400e; border: 1px solid #fde68a; }
    .status-resolved { background-color: var(--success-light); color: #065f46; border: 1px solid #a7f3d0; }

    /* ========== MODAL ========== */
    .modal-overlay { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); animation: fadeIn 0.2s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .modal-dialog { background-color: var(--bg-card); margin: 40px auto; padding: 0; border-radius: var(--radius-lg); width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; box-shadow: var(--shadow-lg); animation: modalSlide 0.3s ease; }
    @keyframes modalSlide { from { opacity: 0; transform: translateY(20px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
    .modal-head { display: flex; align-items: center; justify-content: space-between; padding: 20px 28px; border-bottom: 1px solid var(--border); position: sticky; top: 0; background: var(--bg-card); z-index: 2; }
    .modal-head h3 { font-size: 18px; font-weight: 700; color: var(--dark); margin: 0; }
    .modal-close { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border: none; background: var(--bg-page); border-radius: 50%; font-size: 20px; color: var(--text-muted); cursor: pointer; transition: var(--transition); flex-shrink: 0; }
    .modal-close:hover { background: var(--danger-light); color: var(--danger); }
    .modal-body { padding: 28px; }

    .detail-table { width: 100%; margin-bottom: 24px; border-collapse: collapse; }
    .detail-table tr td { padding: 14px 0; font-size: 14px; vertical-align: top; border-bottom: 1px solid var(--border); }
    .detail-table tr:last-child td { border-bottom: none; }
    .detail-table .dt-label { width: 180px; font-weight: 600; color: var(--text-muted); display: flex; align-items: flex-start; gap: 8px; }
    .detail-table .dt-sep { width: 15px; font-weight: 700; color: var(--text-light); }
    .detail-table .dt-value { color: var(--dark); line-height: 1.6; }

    .photo-section { margin-top: 4px; }
    .photo-section .section-label { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 12px; }
    .photo-box { background: var(--bg-page); padding: 20px; border-radius: var(--radius-lg); text-align: center; border: 1px dashed var(--border); }
    .photo-box img { max-width: 100%; max-height: 400px; object-fit: contain; border-radius: var(--radius-md); }
    .photo-box .no-photo { color: var(--text-light); font-style: italic; font-size: 14px; margin: 0; padding: 20px 0; }

    .btn-close-modal { width: 100%; padding: 14px; background: var(--danger); color: #fff; font-weight: 700; font-size: 15px; border: none; border-radius: var(--radius-md); cursor: pointer; transition: var(--transition); margin-top: 24px; }
    .btn-close-modal:hover { background: var(--danger-hover); transform: translateY(-1px); box-shadow: var(--shadow-md); }

    .empty-state { text-align: center; padding: 48px 20px; color: var(--text-muted); }
    .empty-state .empty-icon { font-size: 40px; margin-bottom: 12px; opacity: 0.5; }
    .empty-state p { font-size: 14px; margin: 0; }

    /* RESPONSIVE */
    @media (max-width: 900px) { .modal-dialog { width: 92%; } }
    @media (max-width: 768px) {
        .page-wrapper { padding: 16px; }
        .page-header h2 { font-size: 19px; }
        .toolbar { justify-content: stretch; }
        .toolbar input[type="text"] { width: 100%; flex: 1; }
        .toolbar form { width: 100%; }
        .modal-dialog { width: 95%; margin: 20px auto; }
        .modal-body { padding: 22px; }
        .detail-table .dt-label { width: 140px; font-size: 13px; }
        .table-card { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .table-card table { min-width: 760px; }
    }
    @media (max-width: 560px) {
        .page-header h2 { font-size: 17px; flex-wrap: wrap; }
        .page-header p { font-size: 13px; }
        .btn, .btn-sm { padding: 9px 12px; font-size: 12.5px; }
        .modal-head { padding: 16px 18px; }
        .modal-head h3 { font-size: 16px; }
        .modal-body { padding: 18px; }
        .toolbar input[type="text"] { font-size: 16px; }
        .detail-table .dt-label { width: 100%; display: block; margin-bottom: 2px; }
        .detail-table .dt-sep { display: none; }
        .detail-table tr td { display: block; width: 100% !important; padding: 6px 0; }
        .detail-table tr { display: block; padding: 10px 0; border-bottom: 1px solid var(--border); }
        .detail-table tr:last-child { border-bottom: none; }
        .detail-table tr td.dt-value { padding-bottom: 10px; }
    }
    @media (max-width: 420px) { .modal-dialog { width: 100%; margin: 0; border-radius: 0; max-height: 100vh; height: 100%; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="page-wrapper">
    <div class="page-header">
        <h2>📋 Kelola Data Pengaduan Warga</h2>
        <p>Pantau dan kelola seluruh laporan pengaduan dari pelanggan maupun masyarakat umum.</p>
    </div>

    @if(session('sukses_lapor'))
        <div style="background: var(--success-light); color: #065f46; border: 1px solid #a7f3d0; padding: 14px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
            ✅ {{ session('sukses_lapor') }}
        </div>
    @endif

    <div class="toolbar">
        <form action="{{ route('admin.pengaduan.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <input type="text" id="search-pengaduan" name="search" value="{{ request('search') }}" onkeyup="filterTableLaci('search-pengaduan', 'container-pengaduan')" placeholder="Cari Pelapor / No. Pelanggan...">
            <button type="submit" class="btn btn-primary btn-sm">🔍 Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-danger btn-sm">✕ Reset</a>
            @endif
        </form>
    </div>

    @php
        $isSuperAdmin = auth()->user()->role == 'super_admin';
        // Grouping dengan Fallback: Cek tabel pengaduan dulu, kalau kosong (data lama), ambil dari tabel pelanggan
        $loopDataPengaduan = $isSuperAdmin 
            ? $pengaduans->groupBy(function($item) { 
                return $item->kecamatan ?? ($item->pelanggan->kecamatan ?? 'Wilayah Tidak Diketahui'); 
            })->sortKeys() 
            : ['_flat' => $pengaduans];
    @endphp

    <div id="container-pengaduan">
        @forelse($loopDataPengaduan as $kecamatan => $items)
            @php $kecId = \Illuminate\Support\Str::slug($kecamatan ?? 'unknown'); @endphp
            
            @if($isSuperAdmin)
            <div class="kecamatan-group mb-4">
                <div onclick="toggleLaci('laci-kec-pengaduan-{{ $kecId }}')" style="background: #1e293b; border-left: 4px solid #0ea5e9; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: var(--shadow-sm);">
                    <strong style="color: #ffffff; font-size: 15px;">
                        {{ $kecamatan == 'Laporan Masyarakat Umum' ? '🌍 Kategori:' : '🏢 Kecamatan:' }} {{ $kecamatan }}
                    </strong>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="background: #0ea5e9; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($items) }} Laporan</span>
                        <i class="fas fa-chevron-down" style="color: #ffffff; transition: 0.3s;" id="icon-laci-kec-pengaduan-{{ $kecId }}"></i>
                    </div>
                </div>
                
                <div id="laci-kec-pengaduan-{{ $kecId }}" style="display: none; padding: 10px 15px; border: 1px dashed #cbd5e1; border-top: none; border-radius: 0 0 8px 8px; background: #f8fafc; margin-bottom: 20px;">
            @endif

                @php 
                    // Pecah data per Rayon (6 digit awal nomor pelanggan). Kalau dari Umum otomatis 000000
                    $rayons = $items->groupBy(function($item) { 
                        return substr($item->pelanggan->nomor_pelanggan ?? '000000', 0, 6); 
                    })->sortKeys(); 
                @endphp

                {{-- LOOPING LACI RAYON --}}
                @foreach($rayons as $rayon => $pengaduanPerRayon)
                <div class="rayon-group mb-3">
                    <div onclick="toggleLaci('laci-rayon-{{ $kecId }}-{{ $rayon }}')" style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <strong style="color: #1e3a8a; font-size: 14px;">
                            {{ $rayon == '000000' ? '📍 Laporan Non-Pelanggan (Masyarakat Umum)' : '📍 Area Rayon: ' . $rayon }}
                        </strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #3b82f6; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($pengaduanPerRayon) }} Laporan</span>
                            <i class="fas fa-chevron-down" style="color: #3b82f6; transition: 0.3s;" id="icon-laci-rayon-{{ $kecId }}-{{ $rayon }}"></i>
                        </div>
                    </div>
                    
                    <div id="laci-rayon-{{ $kecId }}-{{ $rayon }}" style="display: none; transition: all 0.3s ease;">
                        <div class="table-card mb-2">
                            <table>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pelapor</th>
                                        <th>No. Pelanggan</th>
                                        <th>Alamat / Lokasi</th> 
                                        <th>Detail Gangguan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduanPerRayon as $index => $item)
                                    <tr class="data-row">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="cell-name">
                                                <strong>{{ $item->nama_pelapor }}</strong>
                                                <span class="cell-sub">📞 {{ $item->no_hp }}</span>
                                                @if($item->jenis_pelapor == 'Umum')
                                                    <span class="badge-pelapor badge-umum">Umum</span>
                                                @else
                                                    <span class="badge-pelapor badge-pelanggan">Pelanggan</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($item->jenis_pelapor == 'Umum')
                                                <span style="font-style: italic; color: #94a3b8; font-size: 13px;">Bukan Pelanggan</span>
                                            @else
                                                <span style="font-weight: 600; color: var(--primary);">{{ $item->pelanggan->nomor_pelanggan ?? 'N/A' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="font-size: 13px;">
                                                @if($item->jenis_pelapor == 'Umum')
                                                    <strong style="color: #475569;">Laporan Umum:</strong><br>
                                                    <span class="text-muted">Tidak ada relasi wilayah Master</span>
                                                @else
                                                    <strong style="color: #475569;">Alamat Master (Area):</strong><br>
                                                    <span class="text-muted">
                                                        {{ $item->pelanggan->alamat_lengkap ?? 'Alamat tidak ditemukan' }}, 
                                                        {{ $item->pelanggan->kecamatan ?? '' }}
                                                    </span>
                                                @endif
                                                <hr style="margin: 6px 0; border-color: #e2e8f0;">
                                                <strong style="color: #475569;">Titik Patokan Warga:</strong><br>
                                                <span style="color: #dc2626;">📍 {{ Str::limit($item->lokasi_kejadian, 40) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="cell-desc" title="{{ $item->deskripsi_masalah }}">
                                                {{ Str::limit($item->deskripsi_masalah, 50) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.pengaduan.updateStatus', $item->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" onchange="this.form.submit()" 
                                                        class="status-select 
                                                        {{ $item->status == 'Open' ? 'status-open' : '' }}
                                                        {{ $item->status == 'Proses' ? 'status-proses' : '' }}
                                                        {{ $item->status == 'Resolved' ? 'status-resolved' : '' }}">
                                                    <option value="Open" {{ $item->status == 'Open' ? 'selected' : '' }}>Laporan Baru Masuk</option>
                                                    <option value="Proses" {{ $item->status == 'Proses' ? 'selected' : '' }}>Lagi Dikerjain</option>
                                                    <option value="Resolved" {{ $item->status == 'Resolved' ? 'selected' : '' }}>Masalah Selesai</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" onclick="bukaDetail('{{ $item->id }}')" style="background: #0ea5e9; border: none;">
                                                🔍 Detail
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach

            @if($isSuperAdmin)
                </div> </div> @endif

        @empty
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>Belum ada satupun data pengaduan masuk.</p>
            </div>
        @endforelse
    </div>
</div>

@foreach($pengaduans as $item)
<div id="modal-{{ $item->id }}" class="modal-overlay">
    <div class="modal-dialog">
        <div class="modal-head">
            <h3>📋 Detail Pengaduan #{{ $item->id }}</h3>
            <button class="modal-close" onclick="tutupDetail('{{ $item->id }}')">&times;</button>
        </div>
        <div class="modal-body">
            <table class="detail-table">
                <tr>
                    <td class="dt-label">📍 Patokan Lokasi</td>
                    <td class="dt-sep">:</td>
                    <td class="dt-value">{{ $item->lokasi_kejadian }}</td>
                </tr>
                <tr>
                    <td class="dt-label">🗺️ Koordinat Maps</td>
                    <td class="dt-sep">:</td>
                    <td class="dt-value">
                        @if($item->link_map)
                            <a href="{{ $item->link_map }}" target="_blank" class="btn btn-primary btn-sm" style="text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-location-arrow"></i> Buka Rute di Google Maps
                            </a>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">Tidak ada link terlampir</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="dt-label">📝 Isi Keluhan</td>
                    <td class="dt-sep">:</td>
                    <td class="dt-value">{{ $item->deskripsi_masalah }}</td>
                </tr>
            </table>

            <div class="photo-section">
                <div class="section-label">📸 Foto Bukti</div>
                <div class="photo-box">
                    @if($item->foto_bukti)
                        <img src="{{ asset('storage/'.$item->foto_bukti) }}" alt="Foto bukti pengaduan">
                    @else
                        <p class="no-photo">Tidak ada foto bukti yang dilampirkan.</p>
                    @endif
                </div>
            </div>

            <button class="btn-close-modal" onclick="tutupDetail('{{ $item->id }}')">
                ✕ Tutup Detail
            </button>
        </div>
    </div>
</div>
@endforeach

<script>
    // JS Buka Tutup Laci
    function toggleLaci(id) {
        let laci = document.getElementById(id);
        let icon = document.getElementById('icon-' + id);
        if (laci.style.display === "none" || laci.style.display === "") {
            laci.style.display = "block";
            icon.style.transform = "rotate(180deg)"; 
        } else {
            laci.style.display = "none";
            icon.style.transform = "rotate(0deg)"; 
        }
    }

    // JS Live Search Filter Bertingkat (Kecamatan -> Rayon)
    function filterTableLaci(inputId, containerId) {
        let input = document.getElementById(inputId).value.toUpperCase();
        let container = document.getElementById(containerId);
        if(!container) return;

        let kecGroups = container.querySelectorAll('.kecamatan-group');
        
        if (kecGroups.length > 0) {
            // Mode Superadmin (Ada Laci Kecamatan)
            kecGroups.forEach(kec => {
                let hasVisibleRayonInKec = false;
                let rayonGroups = kec.querySelectorAll('.rayon-group');
                
                rayonGroups.forEach(group => {
                    let rows = group.querySelectorAll('tbody tr.data-row');
                    let hasVisibleRow = false;
                    rows.forEach(row => {
                        if (row.innerText.toUpperCase().includes(input)) {
                            row.style.display = "";
                            hasVisibleRow = true;
                        } else {
                            row.style.display = "none";
                        }
                    });
                    group.style.display = hasVisibleRow ? "block" : "none";
                    if (hasVisibleRow) hasVisibleRayonInKec = true;
                });
                
                kec.style.display = hasVisibleRayonInKec ? "block" : "none";
            });
        } else {
            // Mode Kacab / Petugas (Cuma ada Laci Rayon)
            let rayonGroups = container.querySelectorAll('.rayon-group');
            rayonGroups.forEach(group => {
                let rows = group.querySelectorAll('tbody tr.data-row');
                let hasVisibleRow = false;
                rows.forEach(row => {
                    if (row.innerText.toUpperCase().includes(input)) {
                        row.style.display = "";
                        hasVisibleRow = true;
                    } else {
                        row.style.display = "none";
                    }
                });
                group.style.display = hasVisibleRow ? "block" : "none";
            });
        }
    }

    // JS Buka Tutup Modal Detail
    function bukaDetail(id) {
        document.getElementById('modal-' + id).style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function tutupDetail(id) {
        document.getElementById('modal-' + id).style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                tutupDetail(this.id.replace('modal-', ''));
            }
        });
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay').forEach(m => {
                if (m.style.display === 'block') {
                    m.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        }
    });
</script>
@endsection