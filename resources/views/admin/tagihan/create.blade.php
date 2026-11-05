@extends('layouts.admin')

@section('content')
<style>
    :root {
        --primary: #3b82f6; --primary-hover: #2563eb; --primary-light: #eff6ff;
        --success: #10b981; --success-light: #ecfdf5;
        --warning: #f59e0b; --warning-light: #fffbeb;
        --danger: #ef4444; --danger-light: #fef2f2;
        --dark: #0f172a; --text: #334155; --text-muted: #64748b;
        --border: #e2e8f0; --bg-card: #ffffff;
        --radius-md: 8px; --radius-lg: 12px;
        --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
    }

    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-size: 22px; font-weight: 700; color: var(--dark); margin: 0 0 6px 0; }
    .page-header p { font-size: 14px; color: var(--text-muted); margin: 0; }

    /* ALERT WARNING */
    .alert-warning-custom {
        background: var(--warning-light); color: #92400e; border: 1px solid #fde68a;
        border-radius: var(--radius-md); padding: 14px 18px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 10px; font-weight: 600;
    }

    /* TABS */
    .tabs-wrapper { margin-bottom: 20px; display: flex; gap: 10px; border-bottom: 2px solid var(--border); padding-bottom: 10px; overflow-x: auto; }
    .tab-btn {
        padding: 10px 20px; border: none; background: transparent; color: var(--text-muted);
        font-weight: 600; font-size: 14px; cursor: pointer; border-radius: var(--radius-md);
        transition: all 0.2s; white-space: nowrap; position: relative;
    }
    .tab-btn:hover { background: #f1f5f9; color: var(--dark); }
    .tab-btn.active { background: var(--primary-light); color: var(--primary); }
    
    /* BADGE ON TAB */
    .tab-badge {
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--danger); color: white; font-size: 11px; font-weight: 800;
        padding: 2px 6px; border-radius: 99px; margin-left: 6px;
    }
    .tab-btn.active .tab-badge { background: var(--primary); }

    .tab-content { display: none; animation: fadeIn 0.3s ease; }
    .tab-content.active { display: block; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

    /* SEARCH BAR */
    .search-bar { width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 14px; margin-bottom: 16px; }
    .search-bar:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12); }

    /* TABLE */
    .table-card { background: var(--bg-card); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th { padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; border-bottom: 2px solid var(--border); background: #f8fafc; }
    td { padding: 16px 18px; font-size: 14px; color: var(--text); border-bottom: 1px solid var(--border); vertical-align: middle; }
    tr:hover { background: #f8fafc; }
    .cell-name strong { display: block; font-weight: 600; color: var(--dark); margin-bottom: 2px; }
    .cell-sub { font-size: 12px; color: var(--text-muted); }

    /* MODAL FORM */
    .modal-overlay { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); }
    .modal-dialog { background-color: var(--bg-card); margin: 5vh auto; padding: 0; border-radius: var(--radius-lg); width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; }
    .modal-head { padding: 20px 28px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
    .modal-head h3 { margin: 0; font-size: 18px; font-weight: 700; color: var(--dark); }
    .modal-close { background: none; border: none; font-size: 24px; cursor: pointer; color: var(--text-muted); }
    .modal-body { padding: 28px; }

    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: var(--text); }
    .form-control { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 14px; box-sizing: border-box; }
    .form-control[readonly] { background: #f1f5f9; cursor: not-allowed; font-weight: 600; }
    .btn-submit { width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: var(--radius-md); font-weight: 700; cursor: pointer; margin-top: 10px; }
    .btn-submit:hover { background: var(--primary-hover); }
</style>

<div class="card">
    <div class="page-header">
        <h2>📱 Tugas Catat Meteran</h2>
        <p>Bulan Berjalan: <strong>{{ date('F Y', strtotime($bulanSekarang)) }}</strong></p>
    </div>

    @if(session('success'))
        <div style="background: var(--success-light); color: #065f46; border: 1px solid #a7f3d0; padding: 14px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: var(--danger-light); color: #991b1b; border: 1px solid #fecaca; padding: 14px; border-radius: 8px; margin-bottom: 20px; font-weight: 600;">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if(count($belumDicatat) > 0)
        <div class="alert-warning-custom">
            ⚠️ Peringatan: Ada {{ count($belumDicatat) }} Pelanggan yang belum dicatat meterannya bulan ini!
        </div>
    @else
        <div style="background: var(--success-light); color: #065f46; border: 1px solid #a7f3d0; padding: 14px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; display:flex; align-items:center; gap: 8px;">
            🎉 Luar Biasa! Semua meteran pelanggan bulan ini sudah selesai dicatat.
        </div>
    @endif

    <div class="tabs-wrapper">
        <button class="tab-btn active" onclick="bukaTab(event, 'tab-belum')">
            🔴 Belum Diinput <span class="tab-badge" id="badge-belum">{{ count($belumDicatat) }}</span>
        </button>
        <button class="tab-btn" onclick="bukaTab(event, 'tab-sudah')">
            🟢 Sudah Diinput ({{ count($sudahDicatat) }})
        </button>
        <button class="tab-btn" onclick="bukaTab(event, 'tab-semua')">
            📋 Semua Pelanggan ({{ count($semuaPelanggan) }})
        </button>
    </div>

    @php
        $isSuperAdmin = auth()->user()->role == 'super_admin';
    @endphp

    {{-- ======================================================= --}}
    {{-- TAB 1: BELUM DIINPUT --}}
    {{-- ======================================================= --}}
    <div id="tab-belum" class="tab-content active">
        <input type="text" class="search-bar" id="search-belum" onkeyup="filterTable('search-belum', 'container-belum')" placeholder="🔍 Cari Nomor atau Nama Pelanggan (Belum Diinput)...">
        
        <div id="container-belum">
            @php
                $loopDataBelum = $isSuperAdmin ? $belumDicatat->groupBy('kecamatan')->sortKeys() : ['_flat' => $belumDicatatPerRayon];
            @endphp

            @forelse($loopDataBelum as $kecamatan => $groupData)
                @php $kecId = \Illuminate\Support\Str::slug($kecamatan ?? 'unknown'); @endphp
                
                @if($isSuperAdmin)
                <div class="kecamatan-group mb-4">
                    <div onclick="toggleLaci('laci-kec-belum-{{ $kecId }}')" style="background: #1e293b; border-left: 4px solid #0f172a; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <strong style="color: #ffffff; font-size: 15px;">🏢 Kecamatan: {{ $kecamatan ?: 'Belum Diisi' }}</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #3b82f6; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($groupData) }} Warga</span>
                            <i class="fas fa-chevron-down" style="color: #ffffff; transition: 0.3s;" id="icon-laci-kec-belum-{{ $kecId }}"></i>
                        </div>
                    </div>
                    <div id="laci-kec-belum-{{ $kecId }}" style="display: none; padding: 10px 15px; border: 1px dashed #cbd5e1; border-top: none; border-radius: 0 0 8px 8px; background: #f8fafc; margin-bottom: 20px;">
                    @php $rayons = $groupData->groupBy(function($item) { return substr($item->nomor_pelanggan, 0, 6); })->sortKeys(); @endphp
                @else
                    @php $rayons = $groupData; @endphp
                @endif

                @foreach($rayons as $rayon => $pelanggans)
                <div class="rayon-group mb-3">
                    <div onclick="toggleLaci('laci-belum-{{ $kecId }}-{{ $rayon }}')" style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <strong style="color: #1e3a8a; font-size: 14px;">📍 Area Rayon: {{ $rayon }}</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #3b82f6; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($pelanggans) }} Warga</span>
                            <i class="fas fa-chevron-down" style="color: #3b82f6; transition: 0.3s;" id="icon-laci-belum-{{ $kecId }}-{{ $rayon }}"></i>
                        </div>
                    </div>
                    
                    <div id="laci-belum-{{ $kecId }}-{{ $rayon }}" style="display: none; transition: all 0.3s ease;">
                        <div class="table-card mb-2">
                            <table>
                                <thead><tr><th>No</th><th>Nama</th><th>Nomor Pelanggan</th><th>Alamat</th><th>Golongan</th><th>Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($pelanggans as $index => $p)
                                    <tr class="data-row">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="cell-name">
                                                <strong>{{ $p->nama_lengkap }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-name">
                                                <strong>{{ $p->nomor_pelanggan }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="display: block; color: var(--dark); margin-bottom: 2px;">{{ $p->alamat_lengkap }}</span>
                                            <span class="cell-sub" style="display: block; margin-bottom: 6px;">RT {{ $p->rt ?? '-' }}/RW {{ $p->rw ?? '-' }}, Kel. {{ $p->kelurahan ?? '-' }}</span>
                                            
                                            {{-- LOGIKA TAMPILAN BADGE JARAK --}}
                                            @if(isset($p->jarak_km))
                                                @if($p->jarak_km < 1)
                                                    <span style="background: #ecfdf5; color: #059669; font-weight: bold; font-size: 11px; padding: 3px 8px; border-radius: 6px; border: 1px solid #a7f3d0;">
                                                        📍 Berjarak {{ number_format($p->jarak_km * 1000, 0, ',', '.') }} Meter
                                                    </span>
                                                @elseif($p->jarak_km < 5)
                                                    <span style="background: #fffbeb; color: #d97706; font-weight: bold; font-size: 11px; padding: 3px 8px; border-radius: 6px; border: 1px solid #fde68a;">
                                                        📍 Berjarak {{ number_format($p->jarak_km, 2, ',', '.') }} KM
                                                    </span>
                                                @else
                                                    <span style="background: #fef2f2; color: #dc2626; font-weight: bold; font-size: 11px; padding: 3px 8px; border-radius: 6px; border: 1px solid #fecaca;">
                                                        📍 Berjarak {{ number_format($p->jarak_km, 2, ',', '.') }} KM
                                                    </span>
                                                @endif
                                            @else
                                                <span style="background: #f8fafc; color: #94a3b8; font-weight: 600; font-size: 11px; padding: 3px 8px; border-radius: 6px; border: 1px dashed #cbd5e1;">
                                                    Memuat Jarak...
                                                </span>
                                            @endif
                                            {{-- TOMBOL NAVIGASI GOOGLE MAPS --}}
                                            @if($p->latitude && $p->longitude)
                                                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $p->latitude }},{{ $p->longitude }}&travelmode=driving" target="_blank" style="display: block; margin-top: 5px; text-decoration: none; font-size: 11px; font-weight: bold; color: #3b82f6;">
                                                <i class="fas fa-location-arrow"></i> Buka Navigasi
                                                </a>
                                            @endif
                                        </td>
                                        <td><span style="background:var(--success-light); color:#065f46; padding:4px 8px; border-radius:4px; font-size:12px; font-weight:600;">{{ $p->sub_golongan }}</span></td>
                                        <td style="white-space: nowrap; width: 1%;">
                                            <div style="display: flex; gap: 8px; flex-wrap: nowrap; align-items: center;">
                                                <button type="button" data-nama="{{ $p->nama_lengkap }}" data-nomor="{{ $p->nomor_pelanggan }}" data-alamat="{{ $p->alamat_lengkap }}, RT {{ $p->rt ?? '-' }}/RW {{ $p->rw ?? '-' }}, Kel. {{ $p->kelurahan ?? '-' }}" data-golongan="{{ $p->sub_golongan }}" data-ukuran="{{ $p->ukuran_meter ?? '-' }}" data-noseri="{{ $p->no_meter ?? '-' }}" data-merk="{{ $p->merk_meter ?? '-' }}" onclick="bukaDetailModal(this)" style="background: #0ea5e9; color:white; border:none; padding:8px 12px; border-radius:6px; font-weight:600; cursor:pointer; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; box-shadow: var(--shadow-sm);">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                <button onclick="bukaFormModal({{ $p->id }}, '{{ $p->nama_lengkap }}', '{{ $p->nomor_pelanggan }}')" style="background:var(--primary); color:white; border:none; padding:8px 12px; border-radius:6px; font-weight:600; cursor:pointer; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; box-shadow: var(--shadow-sm);">
                                                    <i class="fas fa-camera"></i> Input
                                                </button>
                                            </div>
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
            @empty
                <div style="padding: 40px; text-align: center; color: var(--text-muted);">Tab ini sudah kosong bersih. Pekerjaan selesai!</div>
            @endforelse
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- TAB 2: SUDAH DIINPUT --}}
    {{-- ======================================================= --}}
    <div id="tab-sudah" class="tab-content">
        <input type="text" class="search-bar" id="search-sudah" onkeyup="filterTable('search-sudah', 'container-sudah')" placeholder="🔍 Cari Nomor atau Nama Pelanggan (Sudah Diinput)...">
        
        <div id="container-sudah">
            @php
                $loopDataSudah = $isSuperAdmin ? $sudahDicatat->groupBy('kecamatan')->sortKeys() : ['_flat' => $sudahDicatatPerRayon];
            @endphp

            @forelse($loopDataSudah as $kecamatan => $groupData)
                @php $kecId = \Illuminate\Support\Str::slug($kecamatan ?? 'unknown'); @endphp
                
                @if($isSuperAdmin)
                <div class="kecamatan-group mb-4">
                    <div onclick="toggleLaci('laci-kec-sudah-{{ $kecId }}')" style="background: #1e293b; border-left: 4px solid #0f172a; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <strong style="color: #ffffff; font-size: 15px;">🏢 Kecamatan: {{ $kecamatan ?: 'Belum Diisi' }}</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #10b981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($groupData) }} Selesai</span>
                            <i class="fas fa-chevron-down" style="color: #ffffff; transition: 0.3s;" id="icon-laci-kec-sudah-{{ $kecId }}"></i>
                        </div>
                    </div>
                    <div id="laci-kec-sudah-{{ $kecId }}" style="display: none; padding: 10px 15px; border: 1px dashed #cbd5e1; border-top: none; border-radius: 0 0 8px 8px; background: #f8fafc; margin-bottom: 20px;">
                    @php $rayons = $groupData->groupBy(function($item) { return substr($item->nomor_pelanggan, 0, 6); })->sortKeys(); @endphp
                @else
                    @php $rayons = $groupData; @endphp
                @endif

                @foreach($rayons as $rayon => $pelanggans)
                <div class="rayon-group mb-3">
                    <div onclick="toggleLaci('laci-sudah-{{ $kecId }}-{{ $rayon }}')" style="background: #ecfdf5; border-left: 4px solid #10b981; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <strong style="color: #065f46; font-size: 14px;">📍 Area Rayon: {{ $rayon }} (Selesai)</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #10b981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($pelanggans) }} Warga</span>
                            <i class="fas fa-chevron-down" style="color: #10b981; transition: 0.3s;" id="icon-laci-sudah-{{ $kecId }}-{{ $rayon }}"></i>
                        </div>
                    </div>
                    
                    <div id="laci-sudah-{{ $kecId }}-{{ $rayon }}" style="display: none; transition: all 0.3s ease;">
                        <div class="table-card mb-2">
                            <table>
                                <thead><tr><th>No</th><th>Nama</th><th>Nomor Pelanggan</th><th>Alamat</th><th>Status Tagihan</th></tr></thead>
                                <tbody>
                                    @foreach($pelanggans as $index => $p)
                                    <tr class="data-row">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="cell-name">
                                                <strong>{{ $p->nama_lengkap }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-name">
                                                <strong>{{ $p->nomor_pelanggan }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="display: block; color: var(--dark); margin-bottom: 2px;">{{ \Illuminate\Support\Str::limit($p->alamat_lengkap, 40) }}</span>
                                            <span class="cell-sub" style="display: block; margin-bottom: 6px;">RT {{ $p->rt ?? '-' }}/RW {{ $p->rw ?? '-' }}, Kel. {{ $p->kelurahan ?? '-' }}</span>
                                        </td>
                                        <td style="white-space: nowrap; width: 1%;">
                                            <div style="display: flex; gap: 8px; flex-wrap: nowrap; align-items: center;">
                                                <button type="button" data-nama="{{ $p->nama_lengkap }}" data-nomor="{{ $p->nomor_pelanggan }}" data-alamat="{{ $p->alamat_lengkap }}, RT {{ $p->rt ?? '-' }}/RW {{ $p->rw ?? '-' }}, Kel. {{ $p->kelurahan ?? '-' }}" data-golongan="{{ $p->sub_golongan }}" data-ukuran="{{ $p->ukuran_meter ?? '-' }}" data-noseri="{{ $p->no_meter ?? '-' }}" data-merk="{{ $p->merk_meter ?? '-' }}" onclick="bukaDetailModal(this)" style="background: #0ea5e9; color:white; border:none; padding:8px 12px; border-radius:6px; font-weight:600; cursor:pointer; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; box-shadow: var(--shadow-sm);">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                @php $tagihan = $tagihanBulanIni->where('pelanggan_id', $p->id)->first(); @endphp
                                                @if($tagihan)
                                                    <button type="button" onclick="bukaEditModal('{{ $tagihan->id }}', '{{ $p->nama_lengkap }}', '{{ $p->nomor_pelanggan }}', '{{ $tagihan->meteran_awal }}', '{{ $tagihan->meteran_akhir }}')" style="background: var(--warning); color: #fff; border: none; padding: 8px 12px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: var(--shadow-sm);">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                @else
                                                    <span style="background: #f1f5f9; color: var(--text-muted); padding:8px 12px; border-radius:6px; font-size:13px; font-weight:600; display: inline-flex; align-items: center; gap: 6px;">
                                                        <i class="fas fa-check-circle text-success"></i> Selesai
                                                    </span>
                                                @endif
                                            </div>
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
            @empty
                <div style="padding: 40px; text-align: center; color: var(--text-muted);">Belum ada pelanggan yang dicatat bulan ini.</div>
            @endforelse
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- TAB 3: SEMUA PELANGGAN --}}
    {{-- ======================================================= --}}
    <div id="tab-semua" class="tab-content">
        <input type="text" class="search-bar" id="search-semua" onkeyup="filterTable('search-semua', 'container-semua')" placeholder="🔍 Cari Nomor atau Nama Pelanggan (Seluruh Data)...">
        
        <div id="container-semua">
            @php
                $loopDataSemua = $isSuperAdmin ? $semuaPelanggan->groupBy('kecamatan')->sortKeys() : ['_flat' => $semuaPelangganPerRayon];
            @endphp

            @forelse($loopDataSemua as $kecamatan => $groupData)
                @php $kecId = \Illuminate\Support\Str::slug($kecamatan ?? 'unknown'); @endphp
                
                @if($isSuperAdmin)
                <div class="kecamatan-group mb-4">
                    <div onclick="toggleLaci('laci-kec-semua-{{ $kecId }}')" style="background: #1e293b; border-left: 4px solid #0f172a; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <strong style="color: #ffffff; font-size: 15px;">🏢 Kecamatan: {{ $kecamatan ?: 'Belum Diisi' }}</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #64748b; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($groupData) }} Warga</span>
                            <i class="fas fa-chevron-down" style="color: #ffffff; transition: 0.3s;" id="icon-laci-kec-semua-{{ $kecId }}"></i>
                        </div>
                    </div>
                    <div id="laci-kec-semua-{{ $kecId }}" style="display: none; padding: 10px 15px; border: 1px dashed #cbd5e1; border-top: none; border-radius: 0 0 8px 8px; background: #f8fafc; margin-bottom: 20px;">
                    @php $rayons = $groupData->groupBy(function($item) { return substr($item->nomor_pelanggan, 0, 6); })->sortKeys(); @endphp
                @else
                    @php $rayons = $groupData; @endphp
                @endif

                @foreach($rayons as $rayon => $pelanggans)
                <div class="rayon-group mb-3">
                    <div onclick="toggleLaci('laci-semua-{{ $kecId }}-{{ $rayon }}')" style="background: #f8fafc; border-left: 4px solid #64748b; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <strong style="color: #334155; font-size: 14px;">📍 Area Rayon: {{ $rayon }} (Total)</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #64748b; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($pelanggans) }} Warga</span>
                            <i class="fas fa-chevron-down" style="color: #64748b; transition: 0.3s;" id="icon-laci-semua-{{ $kecId }}-{{ $rayon }}"></i>
                        </div>
                    </div>
                    
                    <div id="laci-semua-{{ $kecId }}-{{ $rayon }}" style="display: none; transition: all 0.3s ease;">
                        <div class="table-card mb-2">
                            <table>
                                <thead><tr><th>No</th><th>Nama</th><th>No Pelanggan</th><th>Alamat</th><th>Golongan</th><th>Detail</th></tr></thead>
                                <tbody>
                                    @foreach($pelanggans as $index => $p)
                                    <tr class="data-row">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="cell-name">
                                                <strong>{{ $p->nama_lengkap }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cell-name">
                                                <strong>{{ $p->nomor_pelanggan }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="display: block; color: var(--dark); margin-bottom: 2px;">{{ \Illuminate\Support\Str::limit($p->alamat_lengkap, 40) }}</span>
                                            <span class="cell-sub" style="display: block; margin-bottom: 6px;">RT {{ $p->rt ?? '-' }}/RW {{ $p->rw ?? '-' }}, Kel. {{ $p->kelurahan ?? '-' }}</span>
                                        </td>
                                        <td><span class="cell-sub">{{ $p->sub_golongan }}</span></td>
                                        <td style="white-space: nowrap; width: 1%;">
                                            <button type="button" data-nama="{{ $p->nama_lengkap }}" data-nomor="{{ $p->nomor_pelanggan }}" data-alamat="{{ $p->alamat_lengkap }}, RT {{ $p->rt ?? '-' }}/RW {{ $p->rw ?? '-' }}, Kel. {{ $p->kelurahan ?? '-' }}" data-golongan="{{ $p->sub_golongan }}" data-ukuran="{{ $p->ukuran_meter ?? '-' }}" data-noseri="{{ $p->no_meter ?? '-' }}" data-merk="{{ $p->merk_meter ?? '-' }}" onclick="bukaDetailModal(this)" style="background: #0ea5e9; color:white; border:none; padding:8px 14px; border-radius:6px; font-weight:600; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; cursor:pointer; box-shadow: var(--shadow-sm);">
                                                <i class="fas fa-eye"></i> Lihat Detail
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
                    </div> 
                </div> 
                @endif
            @empty
                 <div style="padding: 40px; text-align: center; color: var(--text-muted);">Belum ada pelanggan di area ini.</div>
            @endforelse
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- ======================= MODAL FORMS TETAP SAMA ======================= -->
<div id="modalFormInput" class="modal-overlay">
    <div class="modal-dialog" style="max-width: 700px; box-sizing: border-box;">
        <div class="modal-head" style="padding: 20px 24px; border-bottom: 1px solid #e9ecef;">
            <h3 style="margin: 0; font-size: 20px; font-weight: 700; color: #343a40; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-edit text-warning" style="color: #ffc107;"></i> Input Meteran Pelanggan
            </h3>
            <button class="modal-close" onclick="tutupFormModal()">×</button>
        </div>
        <div class="modal-body" style="padding: 28px; box-sizing: border-box; background-color: #ffffff;">
            <div style="margin-bottom: 24px;">
                <label style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 8px; display: block;"><i class="fas fa-user-tag me-1"></i> Data Pelanggan</label>
                <div style="background-color: #f8f9fa; padding: 14px 18px; border-radius: 8px; border: 1px solid #e9ecef;">
                    <div style="font-size: 16px; font-weight: 700; color: #495057;" id="modal_nama_pelanggan">-</div>
                    <div style="font-size: 13px; color: #6c757d; margin-top: 4px;" id="modal_nomor_pelanggan">-</div>
                </div>
            </div>
            <form action="{{ route('admin.tagihan.store') }}" method="POST" enctype="multipart/form-data" id="formCatatMeter">
                @csrf
                <input type="hidden" name="pelanggan_id" id="input_pelanggan_id">
                <input type="hidden" name="bulan_tagihan" value="{{ $bulanSekarang }}">
                <div style="display: flex; gap: 20px; margin-bottom: 24px; flex-wrap: wrap; box-sizing: border-box;">
                    <div style="flex: 1; min-width: 250px; box-sizing: border-box;">
                        <label style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 8px; display: block;"><i class="fas fa-tachometer-alt me-1"></i> Meteran Awal (Bulan Lalu)</label>
                        <div style="display: flex; align-items: center; background: #f8f9fa; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #dee2e6;">
                            <span style="padding: 12px 16px; background: #ffffff; color: #0dcaf0; border-right: 1px solid #dee2e6;"><i class="fas fa-tint"></i></span>
                            <input type="number" name="meteran_awal" id="input_meteran_awal" style="flex: 1; border: none; background: transparent; padding: 12px; font-size: 16px; font-weight: bold; color: #495057; outline: none; width: 100%; cursor: not-allowed;" readonly required>
                            <span style="padding: 12px 16px; background: #ffffff; color: #6c757d; font-weight: 600; border-left: 1px solid #dee2e6;">m³</span>
                        </div>
                        <small id="loading_text" style="color: #0dcaf0; display: none; font-size: 12px; margin-top: 6px; font-weight: 500;"><i class="fas fa-spinner fa-spin me-1"></i> Menarik data bulan lalu...</small>
                    </div>
                    <div style="flex: 1; min-width: 250px; box-sizing: border-box;">
                        <label style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 8px; display: block;"><i class="fas fa-tachometer-alt me-1"></i> Meteran Akhir (Bulan Ini) <span style="color: #dc3545;">*</span></label>
                        <div style="display: flex; align-items: center; background: #ffffff; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #dee2e6;">
                            <span style="padding: 12px 16px; background: #ffffff; color: #0d6efd; border-right: 1px solid #dee2e6;"><i class="fas fa-water"></i></span>
                            <input type="number" name="meteran_akhir" style="flex: 1; border: none; background: transparent; padding: 12px; font-size: 16px; color: #495057; outline: none; width: 100%;" placeholder="Ketik angka..." required>
                            <span style="padding: 12px 16px; background: #ffffff; color: #6c757d; font-weight: 600; border-left: 1px solid #dee2e6;">m³</span>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 40px; box-sizing: border-box;">
                    <label style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 8px; display: block;"><i class="fas fa-camera me-1"></i> Jepret Foto Meteran <span style="color: #dc3545;">*</span></label>
                    <input type="file" name="foto_meter" style="width: 100%; padding: 12px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); font-size: 14px; color: #495057; outline: none; box-sizing: border-box;" accept="image/*" capture="environment" required>
                    <small style="color: #6c757d; display: block; margin-top: 8px; font-size: 12px;"><i class="fas fa-info-circle text-info"></i> Sistem otomatis membuka kamera HP. Arahkan ke meteran pelanggan.</small>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" onclick="tutupFormModal()" style="padding: 12px 28px; background: #6c757d; color: white; border: none; border-radius: 50px; font-weight: 700; font-size: 15px; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: 0.2s;"><i class="fas fa-times"></i> Batal</button>
                    <button type="submit" onclick="return confirm('Sudah yakin angka meteran dan fotonya benar?')" style="padding: 12px 28px; background: #ffc107; color: #212529; border: none; border-radius: 50px; font-weight: 700; font-size: 15px; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: 0.2s;"><i class="fas fa-sync-alt"></i> Simpan & Hitung Tagihan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalEditInput" class="modal-overlay">
    <div class="modal-dialog" style="max-width: 700px; box-sizing: border-box;">
        <div class="modal-head" style="padding: 20px 24px; border-bottom: 1px solid #e9ecef;">
            <h3 style="margin: 0; font-size: 20px; font-weight: 700; color: #343a40; display: flex; align-items: center; gap: 10px;"><i class="fas fa-edit text-warning" style="color: #ffc107;"></i> Edit Meteran Pelanggan</h3>
            <button class="modal-close" onclick="tutupEditModal()">×</button>
        </div>
        <div class="modal-body" style="padding: 28px; box-sizing: border-box; background-color: #ffffff;">
            <div style="margin-bottom: 24px;">
                <label style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 8px; display: block;"><i class="fas fa-user-tag me-1"></i> Data Pelanggan</label>
                <div style="background-color: #f8f9fa; padding: 14px 18px; border-radius: 8px; border: 1px solid #e9ecef;">
                    <div style="font-size: 16px; font-weight: 700; color: #495057;" id="edit_nama_pelanggan">-</div>
                    <div style="font-size: 13px; color: #6c757d; margin-top: 4px;" id="edit_nomor_pelanggan">-</div>
                </div>
            </div>
            <form id="formEditMeter" action="" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input type="hidden" name="bulan_tagihan" value="{{ $bulanSekarang }}">
                <div style="display: flex; gap: 20px; margin-bottom: 24px; flex-wrap: wrap; box-sizing: border-box;">
                    <div style="flex: 1; min-width: 250px; box-sizing: border-box;">
                        <label style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 8px; display: block;"><i class="fas fa-tachometer-alt me-1"></i> Meteran Awal (Bulan Lalu)</label>
                        <div style="display: flex; align-items: center; background: #f8f9fa; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #dee2e6;">
                            <span style="padding: 12px 16px; background: #ffffff; color: #0dcaf0; border-right: 1px solid #dee2e6;"><i class="fas fa-tint"></i></span>
                            <input type="number" name="meteran_awal" id="edit_meteran_awal" style="flex: 1; border: none; background: transparent; padding: 12px; font-size: 16px; font-weight: bold; color: #495057; outline: none; width: 100%; cursor: not-allowed;" readonly required>
                            <span style="padding: 12px 16px; background: #ffffff; color: #6c757d; font-weight: 600; border-left: 1px solid #dee2e6;">m³</span>
                        </div>
                    </div>
                    <div style="flex: 1; min-width: 250px; box-sizing: border-box;">
                        <label style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 8px; display: block;"><i class="fas fa-tachometer-alt me-1"></i> Meteran Akhir (Bulan Ini) <span style="color: #dc3545;">*</span></label>
                        <div style="display: flex; align-items: center; background: #ffffff; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #dee2e6;">
                            <span style="padding: 12px 16px; background: #ffffff; color: #0d6efd; border-right: 1px solid #dee2e6;"><i class="fas fa-water"></i></span>
                            <input type="number" name="meteran_akhir" id="edit_meteran_akhir" style="flex: 1; border: none; background: transparent; padding: 12px; font-size: 16px; color: #495057; outline: none; width: 100%;" required>
                            <span style="padding: 12px 16px; background: #ffffff; color: #6c757d; font-weight: 600; border-left: 1px solid #dee2e6;">m³</span>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 40px; box-sizing: border-box;">
                    <label style="font-size: 14px; font-weight: 600; color: #6c757d; margin-bottom: 8px; display: block;"><i class="fas fa-camera me-1"></i> Ganti Foto Meteran <span style="color: #6c757d; font-weight: normal;">(Opsional)</span></label>
                    <input type="file" name="foto_meter" style="width: 100%; padding: 12px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); font-size: 14px; color: #495057; outline: none; box-sizing: border-box;" accept="image/*" capture="environment">
                    <small style="color: #6c757d; display: block; margin-top: 8px; font-size: 12px;"><i class="fas fa-info-circle text-info"></i> Kosongkan jika tidak ingin mengganti foto bukti meteran saat ini.</small>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" onclick="tutupEditModal()" style="padding: 12px 28px; background: #6c757d; color: white; border: none; border-radius: 50px; font-weight: 700; font-size: 15px; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: 0.2s;"><i class="fas fa-times"></i> Batal</button>
                    <button type="submit" onclick="return confirm('Sudah yakin ingin mengupdate angka meteran ini?')" style="padding: 12px 28px; background: #ffc107; color: #212529; border: none; border-radius: 50px; font-weight: 700; font-size: 15px; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: 0.2s;"><i class="fas fa-sync-alt"></i> Update & Hitung Ulang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalDetailPelanggan" class="modal-overlay">
    <div class="modal-dialog">
        <div class="modal-head">
            <h3>📋 Detail Info Pelanggan</h3>
            <button class="modal-close" onclick="tutupDetailModal()">×</button>
        </div>
        <div class="modal-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f8fafc; padding: 24px; border-radius: 12px; border: 1px solid var(--border);">
                <div>
                    <small style="color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 11px;">Nama Pelanggan</small>
                    <div id="det_nama" style="font-weight: 700; color: var(--dark); font-size: 16px; margin-top: 4px;">-</div>
                </div>
                <div>
                    <small style="color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 11px;">Nomor Sambungan</small>
                    <div id="det_nomor" style="font-weight: 800; color: var(--primary); font-size: 16px; margin-top: 4px;">-</div>
                </div>
                <div style="grid-column: 1 / -1;">
                    <small style="color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 11px;">Alamat Lokasi Meteran</small>
                    <div id="det_alamat" style="font-weight: 600; color: var(--dark); font-size: 14px; margin-top: 4px; line-height: 1.5;">-</div>
                </div>
                <hr style="grid-column: 1 / -1; border: 0; border-top: 1px dashed var(--border); margin: 0;">
                <div>
                    <small style="color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 11px;">Golongan Tarif</small>
                    <div id="det_golongan" style="font-weight: 700; color: var(--success); font-size: 15px; margin-top: 4px;">-</div>
                </div>
                <div>
                    <small style="color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 11px;">Ukuran Meter</small>
                    <div id="det_ukuran" style="font-weight: 600; color: var(--dark); font-size: 15px; margin-top: 4px;">-</div>
                </div>
                <div>
                    <small style="color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 11px;">Nomor Seri Meter</small>
                    <div id="det_noseri" style="font-weight: 600; color: var(--warning-hover); font-size: 15px; margin-top: 4px;">-</div>
                </div>
                <div>
                    <small style="color: var(--text-muted); font-weight: 700; text-transform: uppercase; font-size: 11px;">Merk Meteran</small>
                    <div id="det_merk" style="font-weight: 600; color: var(--dark); font-size: 15px; margin-top: 4px;">-</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

    // JS BARU: Filter Search yang diupgrade buat laci bertingkat (Kecamatan -> Rayon)
    function filterTable(inputId, containerId) {
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
            // Mode Petugas/Kacab (Laci Rayon aja)
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

    function bukaFormModal(id, nama, nomor) {
        document.getElementById('modalFormInput').style.display = 'block';
        document.body.style.overflow = 'hidden';
        document.getElementById('modal_nama_pelanggan').innerText = nama;
        document.getElementById('modal_nomor_pelanggan').innerText = 'ID: ' + nomor;
        document.getElementById('input_pelanggan_id').value = id;
        
        const inputMeterAwal = document.getElementById('input_meteran_awal');
        const loadingText = document.getElementById('loading_text');
        inputMeterAwal.value = '...';
        loadingText.style.display = 'block';
        
        fetch(`/admin/pencatatan-meter/get-meter-awal/${id}`)
            .then(response => response.json())
            .then(data => {
                inputMeterAwal.value = data.meteran_awal;
                loadingText.style.display = 'none';
            })
            .catch(error => {
                inputMeterAwal.value = 0;
                loadingText.style.display = 'none';
            });
    }

    function tutupFormModal() {
        document.getElementById('modalFormInput').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('formCatatMeter').reset();
    }

    function bukaDetailModal(btn) {
        document.getElementById('det_nama').innerText = btn.getAttribute('data-nama');
        document.getElementById('det_nomor').innerText = btn.getAttribute('data-nomor');
        document.getElementById('det_alamat').innerText = btn.getAttribute('data-alamat');
        document.getElementById('det_golongan').innerText = btn.getAttribute('data-golongan');
        document.getElementById('det_ukuran').innerText = btn.getAttribute('data-ukuran') + ' Inchi';
        document.getElementById('det_noseri').innerText = btn.getAttribute('data-noseri');
        document.getElementById('det_merk').innerText = btn.getAttribute('data-merk');
        document.getElementById('modalDetailPelanggan').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function tutupDetailModal() {
        document.getElementById('modalDetailPelanggan').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function bukaEditModal(id, nama, nomor, meterAwal, meterAkhir) {
        document.getElementById('edit_nama_pelanggan').innerText = nama;
        document.getElementById('edit_nomor_pelanggan').innerText = 'ID: ' + nomor;
        document.getElementById('edit_meteran_awal').value = meterAwal;
        document.getElementById('edit_meteran_akhir').value = meterAkhir;
        document.getElementById('formEditMeter').action = '/admin/tagihan/' + id;
        document.getElementById('modalEditInput').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function tutupEditModal() {
        document.getElementById('modalEditInput').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('formEditMeter').reset();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const lat = urlParams.get('lat');
        const lng = urlParams.get('lng');
        if (!lat || !lng) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        let currentUrl = window.location.href.split('?')[0];
                        window.location.href = currentUrl + '?lat=' + position.coords.latitude + '&lng=' + position.coords.longitude;
                    },
                    function(error) {
                        console.warn("GPS diblokir. Mode sorting abjad.");
                        document.querySelectorAll("td span[style*='Memuat Jarak']").forEach(el => {
                            el.innerText = "⚠️ GPS Petugas Mati";
                            el.style.color = "#ef4444";
                            el.style.borderColor = "#fecaca";
                            el.style.background = "#fef2f2";
                        });
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            }
        }
    });
</script>
@endsection