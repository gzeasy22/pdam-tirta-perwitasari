@extends('layouts.admin')

@section('content')
<style>
    /* ========== DESIGN SYSTEM ========== */
    :root {
        --primary: #3b82f6; --primary-hover: #2563eb; --primary-light: #eff6ff;
        --success: #10b981; --success-light: #ecfdf5;
        --warning: #f59e0b; --warning-light: #fffbeb;
        --danger: #ef4444; --danger-light: #fef2f2;
        --info: #0ea5e9; --dark: #0f172a; --text: #334155; --text-muted: #64748b; --text-light: #94a3b8;
        --border: #e2e8f0; --bg-card: #ffffff; --bg-page: #f8fafc;
        --radius-md: 8px; --radius-lg: 12px;
        --shadow-sm: 0 1px 2px rgba(0,0,0,0.05); --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1); --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
        --transition: all 0.2s ease;
    }

    /* ========== TABS & SEARCH ========== */
    .tabs-wrapper { margin-bottom: 20px; display: flex; gap: 10px; border-bottom: 2px solid var(--border); padding-bottom: 10px; overflow-x: auto; }
    .tab-btn { padding: 10px 20px; border: none; background: transparent; color: var(--text-muted); font-weight: 600; font-size: 14px; cursor: pointer; border-radius: var(--radius-md); transition: var(--transition); white-space: nowrap; position: relative; }
    .tab-btn:hover { background: #f1f5f9; color: var(--dark); }
    .tab-btn.active { background: var(--primary-light); color: var(--primary); }
    .tab-badge { display: inline-flex; align-items: center; justify-content: center; background: var(--danger); color: white; font-size: 11px; font-weight: 800; padding: 2px 6px; border-radius: 99px; margin-left: 6px; }
    .tab-btn.active .tab-badge { background: var(--primary); }
    .tab-content { display: none; animation: fadeIn 0.3s ease; }
    .tab-content.active { display: block; }
    
    .search-bar { width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 14px; margin-bottom: 16px; }
    .search-bar:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12); }

    /* ========== TABLE BASE ========== */
    .table-card { background: var(--bg-card); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow-x: auto; box-shadow: var(--shadow-sm); }
    table { width: 100%; border-collapse: collapse; }
    th { padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; border-bottom: 2px solid var(--border); background: var(--bg-page); }
    td { padding: 16px 18px; font-size: 14px; color: var(--text); border-bottom: 1px solid var(--border); vertical-align: middle; }
    tr:hover { background: #f1f5f9; transition: var(--transition); }
    .cell-name strong { display: block; font-weight: 600; color: var(--dark); margin-bottom: 2px; }
    .cell-sub { font-size: 12px; color: var(--text-muted); }

    /* ========== BUTTONS & BADGES ========== */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border: none; border-radius: var(--radius-md); font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; transition: var(--transition); }
    .btn:hover { transform: translateY(-1px); box-shadow: var(--shadow-md); }
    .btn-primary { background: var(--info); color: #fff; }
    .btn-success { background: var(--success); color: #fff; }

    /* ========== MODAL OVERLAY & BOX ========== */
    .modal-overlay { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); animation: fadeIn 0.2s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .modal-dialog { background-color: var(--bg-card); margin: 40px auto; padding: 0; border-radius: var(--radius-lg); width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; box-shadow: var(--shadow-lg); animation: modalSlide 0.3s ease; }
    @keyframes modalSlide { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .modal-head { display: flex; align-items: center; justify-content: space-between; padding: 20px 28px; border-bottom: 1px solid var(--border); }
    .modal-head h3 { font-size: 18px; font-weight: 700; color: var(--dark); margin: 0; }
    .modal-close { background: var(--bg-page); border: none; font-size: 20px; width: 36px; height: 36px; border-radius: 50%; display: flex; justify-content: center; align-items: center; cursor: pointer; color: var(--text-muted); transition: var(--transition); }
    .modal-close:hover { background: var(--danger-light); color: var(--danger); }
    .modal-body { padding: 28px; }

    /* ========== MODAL CONTENT DETAIL ========== */
    .modal-subtitle { font-size: 14px; color: var(--text-muted); display: flex; gap: 8px; align-items: center; }
    .modal-status { font-weight: 600; font-size: 13px; }
    
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
    @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }
    
    .detail-box { background: var(--bg-page); padding: 20px; border-radius: var(--radius-lg); border: 1px solid var(--border); }
    .detail-box h4 { margin: 0 0 16px 0; font-size: 15px; font-weight: 700; color: var(--dark); padding-bottom: 10px; border-bottom: 2px solid var(--border); }
    .detail-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 14px; }
    .detail-row .dl { color: var(--text-muted); font-weight: 500; }
    .detail-row .dv { color: var(--dark); font-weight: 600; text-align: right; max-width: 60%; }
    
    .detail-highlight { background: var(--primary-light); padding: 16px; border-radius: var(--radius-md); text-align: center; margin-top: 12px; border: 1px dashed var(--primary); }
    .detail-highlight .dh-label { font-size: 12px; font-weight: 700; color: var(--primary); text-transform: uppercase; margin-bottom: 4px; }
    .detail-highlight .dh-value { font-size: 26px; font-weight: 800; color: var(--primary-hover); }
    
    .total-tagihan-box { background: var(--bg-card); border: 2px dashed var(--success); border-radius: var(--radius-lg); padding: 24px; text-align: center; }
    .total-tagihan-box .ttb-label { font-size: 14px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }
    .total-tagihan-box .ttb-value { font-size: 34px; font-weight: 800; color: var(--success); margin: 8px 0; }
    .total-tagihan-box .ttb-note { font-size: 12px; color: var(--text-light); }
    
    .btn-close-modal { width: 100%; padding: 14px; background: var(--danger); color: #fff; font-weight: 700; font-size: 15px; border: none; border-radius: var(--radius-md); cursor: pointer; margin-top: 24px; transition: var(--transition); }
    .btn-close-modal:hover { background: #dc2626; box-shadow: var(--shadow-md); }
</style>

<div class="page-wrapper">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div class="page-header-left">
            <h2>💸 Manajemen Tagihan Pelanggan</h2>
            <p>Pantau pemasukan kas dan kelola tunggakan pembayaran warga.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success-custom" style="background: var(--success-light); color: #065f46; border: 1px solid #a7f3d0; padding: 14px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="tabs-wrapper">
        <button class="tab-btn active" onclick="bukaTab(event, 'tab-nunggak')">
            🔴 Belum Bayar <span class="tab-badge" id="badge-nunggak">{{ count($belumBayar) }}</span>
        </button>
        <button class="tab-btn" onclick="bukaTab(event, 'tab-lunas')">
            🟢 Sudah Lunas ({{ count($sudahLunas) }})
        </button>
        <button class="tab-btn" onclick="bukaTab(event, 'tab-semua')">
            📋 Semua Riwayat ({{ count($semuaTagihan) }})
        </button>
    </div>

    @php
        // Cek login status, khusus buat laci kecamatan
        $isSuperAdmin = auth()->user()->role == 'super_admin';
    @endphp

    {{-- ======================================================= --}}
    {{-- TAB 1: BELUM BAYAR --}}
    {{-- ======================================================= --}}
    <div id="tab-nunggak" class="tab-content active">
        <input type="text" class="search-bar" id="search-nunggak" onkeyup="filterTableLaci('search-nunggak', 'container-nunggak')" placeholder="🔍 Cari Nomor atau Nama Pelanggan (Belum Bayar)...">
        
        <div id="container-nunggak">
            @php $belumPerBulan = $belumBayar->groupBy('bulan_tagihan')->sortKeysDesc(); @endphp

            @forelse($belumPerBulan as $bulan => $dataBulan)
                @php 
                    $bulanName = date('F Y', strtotime($bulan)); 
                    $blnId = \Illuminate\Support\Str::slug($bulan);
                @endphp
                <div class="bulan-group mb-4">
                    <!-- HEADER BULAN (BISA DIKLIK) -->
                    <div onclick="toggleLaci('laci-bulan-nunggak-{{ $blnId }}')" style="background: var(--danger-light); color: #991b1b; padding: 12px 16px; border-radius: 8px; border-left: 4px solid var(--danger); display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: var(--shadow-sm);">
                        <strong style="font-size: 15px;">📅 Periode Tagihan: {{ $bulanName }}</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 12px; background: white; padding: 4px 10px; border-radius: 20px; font-weight: bold; border: 1px solid var(--border);">{{ count($dataBulan) }} Nunggak</span>
                            <!-- Icon rotate otomatis kalau dia bulan pertama -->
                            <i class="fas fa-chevron-down" style="transition: 0.3s; transform: {{ $loop->first ? 'rotate(180deg)' : 'rotate(0deg)' }};" id="icon-laci-bulan-nunggak-{{ $blnId }}"></i>
                        </div>
                    </div>

                    <!-- ISI LACI BULAN (Otomatis kebuka buat bulan terbaru) -->
                    <div id="laci-bulan-nunggak-{{ $blnId }}" style="display: {{ $loop->first ? 'block' : 'none' }}; padding-top: 12px;">
                        
                        @php
                            $loopDataBelum = $isSuperAdmin ? $dataBulan->groupBy(function($item) { return $item->pelanggan->kecamatan ?? 'Wilayah Tidak Diketahui'; })->sortKeys() : ['_flat' => $dataBulan];
                        @endphp

                        @foreach($loopDataBelum as $kecamatan => $items)
                            @php $kecId = \Illuminate\Support\Str::slug($kecamatan ?? 'unknown'); @endphp
                            
                            @if($isSuperAdmin)
                            <div class="kecamatan-group mb-3">
                                <div onclick="toggleLaci('laci-kec-nunggak-{{ $blnId }}-{{ $kecId }}')" style="background: #1e293b; border-left: 4px solid #ef4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: var(--shadow-sm);">
                                    <strong style="color: #ffffff; font-size: 14px;">🏢 Kecamatan: {{ $kecamatan }}</strong>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span style="background: #ef4444; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($items) }} Tagihan</span>
                                        <i class="fas fa-chevron-down" style="color: #ffffff; transition: 0.3s;" id="icon-laci-kec-nunggak-{{ $blnId }}-{{ $kecId }}"></i>
                                    </div>
                                </div>
                                <div id="laci-kec-nunggak-{{ $blnId }}-{{ $kecId }}" style="display: none; padding: 10px 15px; border: 1px dashed #cbd5e1; border-top: none; border-radius: 0 0 8px 8px; background: #f8fafc; margin-bottom: 16px;">
                            @endif

                                @php 
                                    $rayons = $items->groupBy(function($item) { return substr($item->pelanggan->nomor_pelanggan ?? '000000', 0, 6); })->sortKeys(); 
                                @endphp

                                @foreach($rayons as $rayon => $tagihans)
                                <div class="rayon-group mb-2">
                                    <div onclick="toggleLaci('laci-rayon-nunggak-{{ $blnId }}-{{ $kecId }}-{{ $rayon }}')" style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                        <strong style="color: #991b1b; font-size: 13.5px;">📍 Area Rayon: {{ $rayon == '000000' ? 'Tidak Diketahui' : $rayon }}</strong>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <span style="background: #ef4444; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($tagihans) }} Tagihan</span>
                                            <i class="fas fa-chevron-down" style="color: #ef4444; transition: 0.3s;" id="icon-laci-rayon-nunggak-{{ $blnId }}-{{ $kecId }}-{{ $rayon }}"></i>
                                        </div>
                                    </div>
                                    
                                    <div id="laci-rayon-nunggak-{{ $blnId }}-{{ $kecId }}-{{ $rayon }}" style="display: none; transition: all 0.3s ease;">
                                        <div class="table-card mb-2">
                                            <table>
                                                <thead><tr><th>No</th><th>Nama Pelanggan</th><th>No Pelanggan</th><th>Periode</th><th>Tagihan</th><th>Status</th><th>Aksi</th></tr></thead>
                                                <tbody>
                                                    @foreach($tagihans as $index => $tagihan)
                                                    <tr class="data-row">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><div class="cell-name"><strong>{{ $tagihan->pelanggan->nama_lengkap ?? '-' }}</strong></div></td>
                                                        <td><div class="cell-name"><strong>{{ $tagihan->pelanggan->nomor_pelanggan ?? '-' }}</strong></div></td>
                                                        <td><span style="font-weight: 500;">{{ date('F Y', strtotime($tagihan->bulan_tagihan)) }}</span></td>
                                                        <td><span style="font-weight: 700; color: var(--danger);">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</span></td>
                                                        <td>
                                                            @if(strtolower(trim($tagihan->status)) == 'belum bayar')
                                                                <span style="background: var(--danger-light); color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">🔴 Belum Bayar</span>
                                                            @else
                                                                <span style="background: var(--warning-light); color: #92400e; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">🟡 Pending</span>
                                                            @endif
                                                        </td>
                                                        <td style="display: flex; gap: 8px;">
                                                            <button class="btn btn-primary btn-sm" onclick="bukaDetail('{{ $tagihan->id }}')" style="background: #0ea5e9; border: none;">🔍 Detail & Foto</button>
                                                            <form action="/admin/tagihan/{{ $tagihan->id }}/lunas" method="POST" style="display: inline-block;">
                                                                @csrf @method('PUT')
                                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin tagihan ini sudah dibayar LUNAS oleh warga?')" style="background: var(--success); border: none;">💵 Set Lunas</button>
                                                            </form>
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
                                </div>
                            </div>
                            @endif
                        @endforeach

                    </div> <!-- End Isi Laci Bulan -->
                </div> <!-- End Bulan Group -->
            @empty
                <div style="padding: 40px; text-align: center; color: var(--text-muted);">Tidak ada warga yang menunggak pembayaran saat ini.</div>
            @endforelse
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- TAB 2: SUDAH LUNAS --}}
    {{-- ======================================================= --}}
    <div id="tab-lunas" class="tab-content">
        <input type="text" class="search-bar" id="search-lunas" onkeyup="filterTableLaci('search-lunas', 'container-lunas')" placeholder="🔍 Cari Nomor atau Nama Pelanggan (Sudah Lunas)...">
        
        <div id="container-lunas">
            @php $lunasPerBulan = $sudahLunas->groupBy('bulan_tagihan')->sortKeysDesc(); @endphp

            @forelse($lunasPerBulan as $bulan => $dataBulan)
                @php 
                    $bulanName = date('F Y', strtotime($bulan)); 
                    $blnId = \Illuminate\Support\Str::slug($bulan);
                @endphp
                <div class="bulan-group mb-4">
                    <div onclick="toggleLaci('laci-bulan-lunas-{{ $blnId }}')" style="background: var(--primary-light); color: var(--primary-hover); padding: 12px 16px; border-radius: 8px; border-left: 4px solid var(--primary); display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: var(--shadow-sm);">
                        <strong style="font-size: 15px;">📅 Periode Tagihan: {{ $bulanName }}</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 12px; background: white; padding: 4px 10px; border-radius: 20px; font-weight: bold; border: 1px solid var(--border);">{{ count($dataBulan) }} Transaksi Lunas</span>
                            <i class="fas fa-chevron-down" style="transition: 0.3s; transform: {{ $loop->first ? 'rotate(180deg)' : 'rotate(0deg)' }};" id="icon-laci-bulan-lunas-{{ $blnId }}"></i>
                        </div>
                    </div>

                    <div id="laci-bulan-lunas-{{ $blnId }}" style="display: {{ $loop->first ? 'block' : 'none' }}; padding-top: 12px;">
                        
                        @php
                            $loopDataLunas = $isSuperAdmin ? $dataBulan->groupBy(function($item) { return $item->pelanggan->kecamatan ?? 'Wilayah Tidak Diketahui'; })->sortKeys() : ['_flat' => $dataBulan];
                        @endphp

                        @foreach($loopDataLunas as $kecamatan => $items)
                            @php $kecId = \Illuminate\Support\Str::slug($kecamatan ?? 'unknown'); @endphp
                            
                            @if($isSuperAdmin)
                            <div class="kecamatan-group mb-3">
                                <div onclick="toggleLaci('laci-kec-lunas-{{ $blnId }}-{{ $kecId }}')" style="background: #1e293b; border-left: 4px solid #10b981; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: var(--shadow-sm);">
                                    <strong style="color: #ffffff; font-size: 14px;">🏢 Kecamatan: {{ $kecamatan }}</strong>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span style="background: #10b981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($items) }} Lunas</span>
                                        <i class="fas fa-chevron-down" style="color: #ffffff; transition: 0.3s;" id="icon-laci-kec-lunas-{{ $blnId }}-{{ $kecId }}"></i>
                                    </div>
                                </div>
                                <div id="laci-kec-lunas-{{ $blnId }}-{{ $kecId }}" style="display: none; padding: 10px 15px; border: 1px dashed #cbd5e1; border-top: none; border-radius: 0 0 8px 8px; background: #f8fafc; margin-bottom: 16px;">
                            @endif

                                @php 
                                    $rayons = $items->groupBy(function($item) { return substr($item->pelanggan->nomor_pelanggan ?? '000000', 0, 6); })->sortKeys(); 
                                @endphp

                                @foreach($rayons as $rayon => $tagihans)
                                <div class="rayon-group mb-2">
                                    <div onclick="toggleLaci('laci-rayon-lunas-{{ $blnId }}-{{ $kecId }}-{{ $rayon }}')" style="background: #ecfdf5; border-left: 4px solid #10b981; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                        <strong style="color: #065f46; font-size: 13.5px;">📍 Area Rayon: {{ $rayon == '000000' ? 'Tidak Diketahui' : $rayon }}</strong>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <span style="background: #10b981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($tagihans) }} Lunas</span>
                                            <i class="fas fa-chevron-down" style="color: #10b981; transition: 0.3s;" id="icon-laci-rayon-lunas-{{ $blnId }}-{{ $kecId }}-{{ $rayon }}"></i>
                                        </div>
                                    </div>
                                    
                                    <div id="laci-rayon-lunas-{{ $blnId }}-{{ $kecId }}-{{ $rayon }}" style="display: none; transition: all 0.3s ease;">
                                        <div class="table-card mb-2">
                                            <table>
                                                <thead><tr><th>No</th><th>Nama Pelanggan</th><th>No Pelanggan</th><th>Periode</th><th>Tagihan</th><th>Status</th><th>Aksi</th></tr></thead>
                                                <tbody>
                                                    @foreach($tagihans as $index => $tagihan)
                                                    <tr class="data-row">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><div class="cell-name"><strong>{{ $tagihan->pelanggan->nama_lengkap ?? '-' }}</strong></div></td>
                                                        <td><div class="cell-name"><strong>{{ $tagihan->pelanggan->nomor_pelanggan ?? '-' }}</strong></div></td>
                                                        <td><span style="font-weight: 500;">{{ date('F Y', strtotime($tagihan->bulan_tagihan)) }}</span></td>
                                                        <td><span style="font-weight: 700; color: var(--success);">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</span></td>
                                                        <td><span style="background: var(--success-light); color: #065f46; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">🟢 Lunas</span></td>
                                                        <td><button class="btn btn-primary btn-sm" onclick="bukaDetail('{{ $tagihan->id }}')" style="background: #0ea5e9; border: none;">🔍 Detail & Foto</button></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            @if($isSuperAdmin)
                                </div>
                            </div>
                            @endif

                        @endforeach
                    </div> <!-- End Isi Laci -->
                </div> <!-- End Bulan Group -->
            @empty
                <div style="padding: 40px; text-align: center; color: var(--text-muted);">Belum ada data pembayaran lunas.</div>
            @endforelse
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- TAB 3: SEMUA RIWAYAT --}}
    {{-- ======================================================= --}}
    <div id="tab-semua" class="tab-content">
        <input type="text" class="search-bar" id="search-semua" onkeyup="filterTableLaci('search-semua', 'container-semua')" placeholder="🔍 Cari Riwayat (Seluruh Data Tagihan)...">
        
        <div id="container-semua">
            @php $semuaPerBulan = $semuaTagihan->groupBy('bulan_tagihan')->sortKeysDesc(); @endphp

            @forelse($semuaPerBulan as $bulan => $dataBulan)
                @php 
                    $bulanName = date('F Y', strtotime($bulan)); 
                    $blnId = \Illuminate\Support\Str::slug($bulan);
                @endphp
                <div class="bulan-group mb-4">
                    <div onclick="toggleLaci('laci-bulan-semua-{{ $blnId }}')" style="background: #f1f5f9; color: var(--dark); padding: 12px 16px; border-radius: 8px; border-left: 4px solid var(--text-muted); display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: var(--shadow-sm);">
                        <strong style="font-size: 15px;">📅 Periode Tagihan: {{ $bulanName }}</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 12px; background: white; padding: 4px 10px; border-radius: 20px; font-weight: bold; border: 1px solid var(--border);">{{ count($dataBulan) }} Tagihan Tercatat</span>
                            <i class="fas fa-chevron-down" style="transition: 0.3s; transform: {{ $loop->first ? 'rotate(180deg)' : 'rotate(0deg)' }};" id="icon-laci-bulan-semua-{{ $blnId }}"></i>
                        </div>
                    </div>

                    <div id="laci-bulan-semua-{{ $blnId }}" style="display: {{ $loop->first ? 'block' : 'none' }}; padding-top: 12px;">
                        
                        @php
                            $loopDataSemua = $isSuperAdmin ? $dataBulan->groupBy(function($item) { return $item->pelanggan->kecamatan ?? 'Wilayah Tidak Diketahui'; })->sortKeys() : ['_flat' => $dataBulan];
                        @endphp

                        @foreach($loopDataSemua as $kecamatan => $items)
                            @php $kecId = \Illuminate\Support\Str::slug($kecamatan ?? 'unknown'); @endphp
                            
                            @if($isSuperAdmin)
                            <div class="kecamatan-group mb-3">
                                <div onclick="toggleLaci('laci-kec-semua-{{ $blnId }}-{{ $kecId }}')" style="background: #1e293b; border-left: 4px solid #64748b; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: var(--shadow-sm);">
                                    <strong style="color: #ffffff; font-size: 14px;">🏢 Kecamatan: {{ $kecamatan }}</strong>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span style="background: #64748b; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($items) }} Tagihan</span>
                                        <i class="fas fa-chevron-down" style="color: #ffffff; transition: 0.3s;" id="icon-laci-kec-semua-{{ $blnId }}-{{ $kecId }}"></i>
                                    </div>
                                </div>
                                <div id="laci-kec-semua-{{ $blnId }}-{{ $kecId }}" style="display: none; padding: 10px 15px; border: 1px dashed #cbd5e1; border-top: none; border-radius: 0 0 8px 8px; background: #f8fafc; margin-bottom: 16px;">
                            @endif

                                @php 
                                    $rayons = $items->groupBy(function($item) { return substr($item->pelanggan->nomor_pelanggan ?? '000000', 0, 6); })->sortKeys(); 
                                @endphp

                                @foreach($rayons as $rayon => $tagihans)
                                <div class="rayon-group mb-2">
                                    <div onclick="toggleLaci('laci-rayon-semua-{{ $blnId }}-{{ $kecId }}-{{ $rayon }}')" style="background: #f8fafc; border-left: 4px solid #64748b; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; border: 1px solid var(--border);">
                                        <strong style="color: #475569; font-size: 13.5px;">📍 Area Rayon: {{ $rayon == '000000' ? 'Tidak Diketahui' : $rayon }}</strong>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <span style="background: #64748b; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($tagihans) }} Tagihan</span>
                                            <i class="fas fa-chevron-down" style="color: #64748b; transition: 0.3s;" id="icon-laci-rayon-semua-{{ $blnId }}-{{ $kecId }}-{{ $rayon }}"></i>
                                        </div>
                                    </div>
                                    
                                    <div id="laci-rayon-semua-{{ $blnId }}-{{ $kecId }}-{{ $rayon }}" style="display: none; transition: all 0.3s ease;">
                                        <div class="table-card mb-2">
                                            <table>
                                                <thead><tr><th>No</th><th>Nama Pelanggan</th><th>No Pelanggan</th><th>Periode</th><th>Tagihan</th><th>Status</th><th>Aksi</th></tr></thead>
                                                <tbody>
                                                    @foreach($tagihans as $index => $tagihan)
                                                    <tr class="data-row">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><div class="cell-name"><strong>{{ $tagihan->pelanggan->nama_lengkap ?? '-' }}</strong></div></td>
                                                        <td><div class="cell-name"><strong>{{ $tagihan->pelanggan->nomor_pelanggan ?? '-' }}</strong></div></td>
                                                        <td><span style="font-weight: 500;">{{ date('F Y', strtotime($tagihan->bulan_tagihan)) }}</span></td>
                                                        <td><span style="font-weight: 700;">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</span></td>
                                                        <td>
                                                            @if(strtolower(trim($tagihan->status)) == 'belum bayar')
                                                                <span style="color: var(--danger); font-weight: 600;">Belum Bayar</span>
                                                            @elseif(strtolower(trim($tagihan->status)) == 'pending')
                                                                <span style="color: var(--warning); font-weight: 600;">Pending</span>
                                                            @else
                                                                <span style="color: var(--success); font-weight: 600;">Lunas</span>
                                                            @endif
                                                        </td>
                                                        <td><button class="btn btn-primary btn-sm" onclick="bukaDetail('{{ $tagihan->id }}')" style="background: #0ea5e9; border: none;">🔍 Detail & Foto</button></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            @if($isSuperAdmin)
                                </div>
                            </div>
                            @endif

                        @endforeach
                    </div> <!-- End Isi Laci -->
                </div> <!-- End Bulan Group -->
            @empty
                <div style="padding: 40px; text-align: center; color: var(--text-muted);">Belum ada riwayat tagihan di sistem.</div>
            @endforelse
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- ======================= MODAL DETAIL & FOTO (SAMA KAYA PUNYA LU) ======================= -->
@foreach($semuaTagihan as $tagihan)
<div id="modal-{{ $tagihan->id }}" class="modal-overlay">
    <div class="modal-dialog">
        <div class="modal-head">
            <h3>📄 Detail Tagihan #{{ $tagihan->id }}</h3>
            <button class="modal-close" onclick="tutupDetail('{{ $tagihan->id }}')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="modal-subtitle">
                <span>Periode: <strong>{{ date('F Y', strtotime($tagihan->bulan_tagihan)) }}</strong></span>
                <span>|</span>
                @if(strtolower(trim($tagihan->status)) == 'lunas')
                    <span class="modal-status" style="color: var(--success);">🟢 Lunas</span>
                @else
                    <span class="modal-status" style="color: var(--danger);">🔴 Belum Bayar</span>
                @endif
            </div>

            <hr style="margin: 20px 0; border: 0; border-top: 1px solid var(--border);">

            <div class="detail-grid">
                <div class="detail-box">
                    <h4>👤 Info Pelanggan & Tarif</h4>
                    <div class="detail-row"><span class="dl">No. Sambungan</span><span class="dv">{{ $tagihan->pelanggan->nomor_pelanggan ?? '-' }}</span></div>
                    <div class="detail-row"><span class="dl">Golongan Tarif</span><span class="dv"><span style="background: var(--success-light); color: #065f46; padding: 2px 10px; border-radius: 6px; font-size: 12px; font-weight: bold;">{{ $tagihan->pelanggan->sub_golongan ?? '-' }}</span></span></div>
                    <div class="detail-row"><span class="dl">Ukuran Meter</span><span class="dv">{{ $tagihan->pelanggan->ukuran_meter ?? '0,5' }} Inchi</span></div>
                    <div class="detail-row"><span class="dl">Alamat</span><span class="dv">{{ $tagihan->pelanggan->alamat_lengkap ?? '-' }}</span></div>
                    <div class="detail-row"><span class="dl">No Meter</span><span class="dv">{{ $tagihan->pelanggan->no_meter ?? '-' }}</span></div>
                    <div class="detail-row"><span class="dl">Merk Meter</span><span class="dv">{{ $tagihan->pelanggan->merk_meter ?? '-' }}</span></div>
                </div>

                <div class="detail-box">
                    <h4>💧 Data Meteran Air</h4>
                    <div class="detail-row"><span class="dl">Meter Bulan Lalu</span><span class="dv">{{ $tagihan->meteran_awal }} m³</span></div>
                    <div class="detail-row"><span class="dl">Meter Bulan Ini</span><span class="dv">{{ $tagihan->meteran_akhir }} m³</span></div>
                    
                    <div class="detail-highlight">
                        <div class="dh-label">Total Kubikasi Pemakaian</div>
                        <div class="dh-value">{{ $tagihan->pemakaian }} m³</div>
                    </div>

                    @if($tagihan->foto_meter)
                        <a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_meter', 'nama_file' => $tagihan->foto_meter]) }}" target="_blank" class="btn-foto-meter" style="display: block; text-align: center; background: var(--info); color: white; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: bold; margin-top: 15px;">
                            👁️ Lihat Bukti Foto Meteran
                        </a>
                    @else
                        <div style="margin-top: 15px; text-align: center; font-size: 12px; color: var(--text-light); font-style: italic;">
                            *Belum ada lampiran foto meteran.
                        </div>
                    @endif
                </div>
            </div>

            <div class="total-tagihan-box">
                <div class="ttb-label">Total Tagihan Pembayaran</div>
                <div class="ttb-value">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</div>
                <div class="ttb-note">*Nominal di atas sudah mencakup biaya pemakaian air progresif, sewa meteran bulanan, dan biaya administrasi.</div>
            </div>

            <button class="btn-close-modal" onclick="tutupDetail('{{ $tagihan->id }}')">
                ✕ Tutup Detail
            </button>
        </div>
    </div>
</div>
@endforeach

<script>
    // Buka Tab
    function bukaTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Toggle Laci Kecamatan
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

    // Filter Search Anti-Badai (Bottom-Up DOM Traversal)
    // Filter Search Anti-Badai (Auto-Expand Laci)
    function filterTableLaci(inputId, containerId) {
        let input = document.getElementById(inputId).value.toUpperCase();
        let container = document.getElementById(containerId);
        if(!container) return;

        // 1. Filter baris data tabel
        let rows = container.querySelectorAll('.data-row');
        rows.forEach(row => {
            if (row.innerText.toUpperCase().includes(input)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });

        // 2. Evaluasi Rayon
        container.querySelectorAll('.rayon-group').forEach(group => {
            let hasVisible = Array.from(group.querySelectorAll('.data-row')).some(r => r.style.display !== "none");
            group.style.display = hasVisible ? "block" : "none";
            
            // Auto-buka laci rayon kalau lagi nge-search
            let laci = group.querySelector('[id^="laci-rayon-"]');
            let icon = group.querySelector('[id^="icon-laci-rayon-"]');
            if (input !== "" && hasVisible && laci) {
                laci.style.display = "block";
                if(icon) icon.style.transform = "rotate(180deg)";
            }
        });

        // 3. Evaluasi Kecamatan
        container.querySelectorAll('.kecamatan-group').forEach(group => {
            let hasVisible = Array.from(group.querySelectorAll('.data-row')).some(r => r.style.display !== "none");
            group.style.display = hasVisible ? "block" : "none";

            // Auto-buka laci kecamatan kalau lagi nge-search
            let laci = group.querySelector('[id^="laci-kec-"]');
            let icon = group.querySelector('[id^="icon-laci-kec-"]');
            if (input !== "" && hasVisible && laci) {
                laci.style.display = "block";
                if(icon) icon.style.transform = "rotate(180deg)";
            }
        });

        // 4. Evaluasi Bulan
        container.querySelectorAll('.bulan-group').forEach(group => {
            let hasVisible = Array.from(group.querySelectorAll('.data-row')).some(r => r.style.display !== "none");
            group.style.display = hasVisible ? "block" : "none";

            // Auto-buka laci bulan kalau lagi nge-search
            let laci = group.querySelector('[id^="laci-bulan-"]');
            let icon = group.querySelector('[id^="icon-laci-bulan-"]');
            if (input !== "" && hasVisible && laci) {
                laci.style.display = "block";
                if(icon) icon.style.transform = "rotate(180deg)";
            }
        });
    }

    // JS Modal Detail
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