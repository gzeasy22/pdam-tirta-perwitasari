@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap');

    /* ========== DESIGN SYSTEM ==========
       Nilai warna & radius TETAP SAMA seperti sebelumnya
       (banyak dipakai lewat inline style di HTML bawah,
       jadi tidak diubah supaya semuanya tetap konsisten).
       Yang ditambah: font, shadow/transition lebih halus,
       dan breakpoint responsive yang jauh lebih lengkap. */
    :root {
        --primary: #3b82f6; --primary-hover: #2563eb; --primary-light: #eff6ff;
        --success: #10b981; --success-hover: #059669; --success-light: #ecfdf5;
        --warning: #f59e0b; --warning-hover: #d97706; --warning-light: #fffbeb;
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

    .card, .card * { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
    .page-header h2, .modal-head h2, .form-section h3 { font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }

    /* ========== TAB NAVIGATION ========== */
    .tab-navigation { display: flex; gap: 12px; margin-bottom: 24px; border-bottom: 2px solid var(--border); padding-bottom: 8px; overflow-x: auto; -webkit-overflow-scrolling: touch; scrollbar-width: thin; }
    .tab-item { padding: 10px 20px; text-decoration: none; font-weight: 600; color: var(--text-muted); border-radius: var(--radius-md) var(--radius-md) 0 0; transition: var(--transition); white-space: nowrap; display: flex; align-items: center; gap: 8px; }
    .tab-item:hover { background: var(--bg-page); color: var(--dark); }
    .tab-item.active { color: var(--primary); border-bottom: 3px solid var(--primary); background: var(--primary-light); margin-bottom: -10px; padding-bottom: 12px; }
    .tab-badge { background: var(--bg-card); color: var(--text); padding: 2px 8px; border-radius: 9999px; font-size: 11px; border: 1px solid var(--border); }
    .tab-item.active .tab-badge { background: var(--primary); color: #fff; border-color: var(--primary); }

    /* ========== PAGE LAYOUT ========== */
    .card { padding: 8px; }
    .page-header { margin-bottom: 24px; }
    .page-header h2 { font-size: 22px; font-weight: 700; color: var(--dark); margin: 0 0 6px 0; display: flex; align-items: center; gap: 10px; }
    .page-header p { font-size: 14px; color: var(--text-muted); margin: 0; }

    /* ========== ALERTS ========== */
    .alert { padding: 14px 18px; border-radius: var(--radius-md); margin-bottom: 20px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; animation: alertSlide 0.3s ease; }
    @keyframes alertSlide { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
    .alert-success { background: var(--success-light); color: #065f46; border: 1px solid #a7f3d0; }
    .alert-error { background: var(--danger-light); color: #991b1b; border: 1px solid #fecaca; }

    /* ========== TOOLBAR ========== */
    .toolbar { display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px; gap: 10px; flex-wrap: wrap; }
    .toolbar input[type="text"] { padding: 10px 16px; border: 1px solid var(--border); border-radius: var(--radius-md); width: 270px; font-size: 14px; color: var(--text); background: var(--bg-card); transition: var(--transition); outline: none; }
    .toolbar input[type="text"]:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12); }

    /* ========== BUTTONS ========== */
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 10px 18px; border: none; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; transition: var(--transition); white-space: nowrap; }
    .btn:hover { transform: translateY(-1px); box-shadow: var(--shadow-md); }
    .btn:active { transform: translateY(0); }
    .btn:focus-visible { outline: 2px solid var(--primary); outline-offset: 2px; }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: var(--primary-hover); }
    .btn-danger { background: var(--danger); color: #fff; }
    .btn-danger:hover { background: var(--danger-hover); }
    .btn-success { background: var(--success); color: #fff; }
    .btn-sm { padding: 8px 14px; font-size: 13px; }

    /* ========== TABLE ========== */
    .table-card { background: var(--bg-card); border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; box-shadow: var(--shadow-sm); }
    .table-card table { width: 100%; border-collapse: collapse; }
    .table-card thead { background: var(--bg-page); }
    .table-card thead th { padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.04em; border-bottom: 2px solid var(--border); }
    .table-card tbody tr { transition: var(--transition); }
    .table-card tbody tr:hover { background: #f1f5f9; }
    .table-card tbody td { padding: 16px 18px; font-size: 14px; color: var(--text); border-bottom: 1px solid var(--border); vertical-align: middle; }
    .table-card tbody tr:last-child td { border-bottom: none; }
    .cell-name strong { display: block; font-weight: 600; color: var(--dark); margin-bottom: 2px; }
    .cell-sub { font-size: 12px; color: var(--text-muted); }

    /* ========== BADGES ========== */
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 5px 12px; border-radius: var(--radius-full); font-size: 12px; font-weight: 600; }
    .badge-pending { background: var(--warning-light); color: #92400e; border: 1px solid #fde68a; }
    .badge-approved { background: var(--success-light); color: #065f46; border: 1px solid #a7f3d0; }
    .badge-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* ========== MODAL ========== */
    .modal-overlay { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); animation: fadeIn 0.2s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .modal-dialog { background-color: var(--bg-card); margin: 3% auto; padding: 0; border-radius: var(--radius-lg); width: 70%; max-width: 820px; max-height: 90vh; overflow-y: auto; box-shadow: var(--shadow-lg); animation: modalSlide 0.3s ease; }
    @keyframes modalSlide { from { opacity: 0; transform: translateY(20px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
    .modal-head { display: flex; align-items: center; justify-content: space-between; padding: 20px 28px; border-bottom: 1px solid var(--border); position: sticky; top: 0; background: var(--bg-card); z-index: 2; }
    .modal-head h2 { font-size: 18px; font-weight: 700; color: var(--dark); margin: 0; }
    .modal-close { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border: none; background: var(--bg-page); border-radius: 50%; font-size: 20px; color: var(--text-muted); cursor: pointer; transition: var(--transition); flex-shrink: 0; }
    .modal-close:hover { background: var(--danger-light); color: var(--danger); }
    .modal-body { padding: 28px; }

    /* ========== DETAIL GRID & FORMS ========== */
    .section-label { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid var(--border); }
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 28px; }
    .detail-item { margin-bottom: 14px; }
    .detail-item .label { font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px; }
    .detail-item .value { font-size: 14px; font-weight: 500; color: var(--dark); line-height: 1.5; word-break: break-word; }
    .btn-doc { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: var(--radius-md); font-size: 13px; font-weight: 600; text-decoration: none; color: #fff !important; transition: var(--transition); margin-top: 6px; }
    .btn-doc:hover { filter: brightness(0.92); transform: translateY(-1px); }
    .btn-doc-ktp { background: var(--info); } .btn-doc-kk { background: #8b5cf6; } .btn-doc-rumah { background: var(--success); } .btn-doc-rab { background: var(--warning); }
    
    .form-section { background: var(--bg-page); padding: 24px; border-radius: var(--radius-lg); border: 1px dashed var(--border); margin-top: 24px; }
    .form-section h3 { font-size: 16px; font-weight: 700; color: var(--dark); margin: 0 0 6px 0; }
    .form-section .form-desc { font-size: 13px; color: var(--text-muted); margin: 0 0 18px 0; }
    .form-section--warning { background: var(--warning-light); border-color: var(--warning); }
    .form-section--success { background: var(--success-light); border-color: var(--success); }
    
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px; }
    .form-control { width: 100%; padding: 11px 14px; border: 1px solid var(--border); border-radius: var(--radius-md); font-size: 14px; background: var(--bg-card); box-sizing: border-box; transition: var(--transition); }
    .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12); }
    .btn-submit-full { margin-top: 10px; width: 100%; padding: 12px; color: #fff; border: none; border-radius: var(--radius-md); font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: var(--transition); }
    .btn-submit-full:hover { filter: brightness(0.94); transform: translateY(-1px); box-shadow: var(--shadow-md); }
    .btn-submit-success { background: var(--success); } .btn-submit-warning { background: var(--warning); } .btn-submit-primary { background: var(--primary); }
    .dual-form { display: flex; gap: 20px; margin-top: 24px; flex-wrap: wrap; }
    .dual-form .form-section { flex: 1; min-width: 280px; margin-top: 0; }
    .approved-box { background: var(--success-light); padding: 20px 24px; border-radius: var(--radius-lg); margin-top: 24px; border-left: 4px solid var(--success); }

    /* ============================================
       RESPONSIVE — MOBILE / TABLET
       (breakpoint lebih lengkap dari sebelumnya)
       ============================================ */
    @media (max-width: 900px) {
        .modal-dialog { width: 90%; }
    }

    @media (max-width: 768px) {
        .card { padding: 4px; }
        .page-header h2 { font-size: 19px; }
        .tab-item { padding: 9px 14px; font-size: 13.5px; }
        .toolbar { justify-content: stretch; }
        .toolbar input[type="text"] { width: 100%; flex: 1; }
        .toolbar form { width: 100%; }
        .modal-dialog { width: 94%; margin: 4% auto; }
        .modal-body { padding: 22px; }
        .detail-grid { grid-template-columns: 1fr; gap: 16px; }
        .dual-form { flex-direction: column; }
        .table-card { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .table-card table { min-width: 640px; }
    }

    @media (max-width: 560px) {
        .page-header h2 { font-size: 17px; flex-wrap: wrap; }
        .page-header p { font-size: 13px; }
        .btn, .btn-sm { padding: 9px 12px; font-size: 12.5px; }
        .btn-doc { width: 100%; }
        .form-section { padding: 18px; }
        .modal-head { padding: 16px 18px; }
        .modal-head h2 { font-size: 16px; }
        .modal-body { padding: 18px; }
        /* form input font-size 16px agar tidak auto-zoom saat fokus di iOS */
        .form-control, .toolbar input[type="text"] { font-size: 16px; }
        .btn-submit-full { font-size: 13.5px; }
    }

    @media (max-width: 420px) {
        .modal-dialog { width: 100%; margin: 0; border-radius: 0; max-height: 100vh; height: 100%; }
        .tab-badge { display: none; }
    }
</style>

<div class="card">
    <div class="page-header">
        <h2>📋 Data Pendaftaran Sambungan Baru</h2>
        <p>Daftar warga yang masuk antrean verifikasi pemasangan sambungan air.</p>
    </div>

    @if(session('sukses'))
        <div class="alert alert-success"><span>✅</span> {{ session('sukses') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error"><span>❌</span> Terjadi kesalahan, pastikan data yang diinput benar!</div>
    @endif

    {{-- SEMBUNYIKAN TAB PENDING & REJECTED DARI PETUGAS METER --}}
    <div class="tab-navigation">
        @if(!in_array(auth()->user()->role, ['petugas_meter', 'kasir']))
        <a href="{{ route('admin.pelanggan', ['tab' => 'Pending', 'search' => request('search')]) }}" class="tab-item {{ $tab == 'Pending' ? 'active' : '' }}">
            ⏳ Pending <span class="tab-badge">{{ $countPending ?? 0 }}</span>
        </a>
        @endif
        
        <a href="{{ route('admin.pelanggan', ['tab' => 'Approved', 'search' => request('search')]) }}" class="tab-item {{ $tab == 'Approved' ? 'active' : '' }}">
            ✅ Disetujui <span class="tab-badge">{{ $countApproved ?? 0 }}</span>
        </a>
        
        @if(!in_array(auth()->user()->role, ['petugas_meter', 'kasir']))
        <a href="{{ route('admin.pelanggan', ['tab' => 'Rejected', 'search' => request('search')]) }}" class="tab-item {{ $tab == 'Rejected' ? 'active' : '' }}">
            ❌ Ditolak <span class="tab-badge">{{ $countRejected ?? 0 }}</span>
        </a>
        @endif
    </div>

    <div class="toolbar">
        <form action="{{ route('admin.pelanggan') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <input type="hidden" name="tab" value="{{ $tab }}"> 
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Pelanggan / Nama...">
            <button type="submit" class="btn btn-primary btn-sm">🔍 Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.pelanggan', ['tab' => $tab]) }}" class="btn btn-danger btn-sm">✕ Reset</a>
            @endif
        </form>
    </div>

    {{-- ========================================================== --}}
    {{-- TAB 1: PENDING (LACI KECAMATAN SAJA) --}}
    {{-- ========================================================== --}}
    @if($tab == 'Pending' && !in_array(auth()->user()->role, ['petugas_meter', 'kasir']))
        <div id="container-pending">
            @forelse($groupedPending as $kecamatan => $pelanggans)
                @php $kecId = \Illuminate\Support\Str::slug($kecamatan ?? 'unknown'); @endphp
                <div class="rayon-group mb-4">
                    <div onclick="toggleLaci('laci-kec-{{ $kecId }}')" style="background: #fffbeb; border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 8px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: var(--shadow-sm);">
                        <strong style="color: #b45309; font-size: 15px;">🏢 Kecamatan: {{ $kecamatan ?? 'Belum Diisi' }}</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #f59e0b; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($pelanggans) }} Antrean</span>
                            <i class="fas fa-chevron-down" style="color: #f59e0b; transition: 0.3s;" id="icon-laci-kec-{{ $kecId }}"></i>
                        </div>
                    </div>

                    <div id="laci-kec-{{ $kecId }}" style="display: {{ request('search') ? 'block' : 'none' }}; transition: all 0.3s ease;">
                        <div class="table-card">
                            <table>
                                <thead><tr><th>No</th><th>Nama & Kontak</th><th>Alamat Pemasangan</th><th>Status</th><th>Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($pelanggans as $index => $data)
                                        @php 
                                            // LOGIKA IZIN EDIT & HAPUS
                                            $canEdit = (auth()->user()->role == 'super_admin') || (in_array(auth()->user()->role, ['kepala_cabang', 'petugas_pemasangan']) && auth()->user()->cabang_id == $data->cabang_id);
                                            // Petugas Pasang gak boleh hapus/tolak
                                            $canDelete = (auth()->user()->role == 'super_admin') || (auth()->user()->role == 'kepala_cabang' && auth()->user()->cabang_id == $data->cabang_id);
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="cell-name">
                                                    <strong>{{ $data->nama_lengkap }}</strong>
                                                    <span class="cell-sub">📞 {{ $data->no_hp }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $data->alamat_lengkap }}
                                                    <div class="cell-sub">RT {{ $data->rt }}/RW {{ $data->rw }}, {{ $data->kelurahan }}, {{ $data->kecamatan }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-pending">⏳ Pending</span>
                                            </td>
                                            <td style="white-space: nowrap; width: 1%;">
                                                <div style="display: flex; gap: 8px; align-items: center;">
                                                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal-{{ $data->id }}').style.display='block'">👁️ Detail</button>
                                                    
                                                    @if($canDelete)
                                                        <form action="{{ route('admin.pelanggan.destroy', $data->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini dari daftar?')">🗑️ Hapus</button>
                                                        </form>
                                                    @elseif(!$canEdit)
                                                        <span style="background: #f1f5f9; color: #94a3b8; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; border: 1px dashed #cbd5e1; cursor: not-allowed;" title="Akses Ditolak: Beda Wilayah Cabang">🔒 Read Only</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- ===== MODAL ===== --}}
                                        <div id="modal-{{ $data->id }}" class="modal-overlay">
                                            <div class="modal-dialog">
                                                <div class="modal-head">
                                                    <h2>📄 Detail Pemohon: {{ $data->nama_lengkap }}</h2>
                                                    <button class="modal-close" onclick="document.getElementById('modal-{{ $data->id }}').style.display='none'">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="detail-grid">
                                                        <div>
                                                            <div class="section-label">Informasi Pemohon</div>
                                                            <div class="detail-item"><div class="label">NIK</div><div class="value">{{ $data->nik }}</div></div>
                                                            <div class="detail-item"><div class="label">No KK</div><div class="value">{{ $data->no_kk }}</div></div>
                                                            <div class="detail-item"><div class="label">Email</div><div class="value">{{ $data->email ?? '-' }}</div></div>
                                                            <div class="detail-item"><div class="label">Peruntukan Awal</div><div class="value">{{ $data->peruntukan }}</div></div>
                                                            <div class="detail-item"><div class="label">Sub-Golongan Spesifik</div><div class="value highlight">{{ $data->sub_golongan ?? 'Belum Ditentukan' }}</div></div>
                                                            <div class="detail-item"><div class="label">Status Kepemilikan</div><div class="value">{{ $data->status_kepemilikan }}</div></div>
                                                            <div class="detail-item">
                                                                <div class="label">Link Peta Survei</div>
                                                                <div class="value">
                                                                    @if($data->koordinat_map)
                                                                    <a href="{{ $data->koordinat_map }}" target="_blank">📍 Buka di Google Maps</a>
                                                                    @else
                                                                    <span style="color: var(--text-light);">Tidak ada link peta</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="section-label">Berkas Dokumen</div>
                                                            <div class="detail-item"><div class="label">Foto KTP</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_ktp', 'nama_file' => $data->foto_selfie_ktp]) }}" target="_blank" class="btn-doc btn-doc-ktp">👁️ Buka Selfie KTP</a></div></div>
                                                            <div class="detail-item"><div class="label">Foto KTP</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_ktp', 'nama_file' => $data->foto_ktp]) }}" target="_blank" class="btn-doc btn-doc-ktp">👁️ Buka KTP</a></div></div>
                                                            <div class="detail-item"><div class="label">Foto KK</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_rumah', 'nama_file' => $data->foto_kk]) }}" target="_blank" class="btn-doc btn-doc-kk">👁️ Buka KK</a></div></div>
                                                            <div class="detail-item"><div class="label">Foto Rumah</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_rumah', 'nama_file' => $data->foto_rumah]) }}" target="_blank" class="btn-doc btn-doc-rumah">🏠 Buka Foto Rumah</a></div></div>
                                                        </div>
                                                    </div>

                                                    @if($canEdit)
                                                        @if(empty($data->total_tagihan_pasang) && empty($data->status_pembayaran_pasang))
                                                            <div class="dual-form">
                                                                <div class="form-section form-section--warning">
                                                                    <h3>🚧 Khusus Pasang Baru</h3>
                                                                    <p class="form-desc">Input hasil survei lapangan untuk ditagihkan ke warga.</p>
                                                                    <form action="{{ route('admin.pelanggan.input_rab', $data->id) }}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="form-group"><label>Total Tagihan (Rp)</label><input type="number" name="total_tagihan_pasang" class="form-control" required></div>
                                                                        <div class="form-group"><label>Upload Foto RAB</label><input type="file" name="foto_rab" class="form-control" accept="image/*" required></div>
                                                                        <button type="submit" class="btn-submit-full btn-submit-warning">📥 Simpan RAB & Kirim Tagihan</button>
                                                                    </form>
                                                                </div>
                                                                <div class="form-section">
                                                                    <h3>✅ Khusus Migrasi Data</h3>
                                                                    <p class="form-desc">Langsung aktifkan dan masukkan ID Pelanggan Lama.</p>
                                                                    <form action="{{ route('admin.pelanggan.approve', $data->id) }}" method="POST">
                                                                        @csrf
                                                                        <div class="form-group"><label>1. Masukkan Nomor Pelanggan</label><input type="text" name="nomor_pelanggan" class="form-control" required></div>
                                                                        <div class="form-group">
                                                                            <label>2. Tetapkan Sub-Golongan Tarif</label>
                                                                            @php
                                                                            // Narik semua data sub_golongan spesifik dari tabel tarif_airs
                                                                            $listSubGolongan = \App\Models\TarifAir::select('sub_golongan')
                                                                                                ->whereNotNull('sub_golongan')
                                                                                                ->distinct()
                                                                                                ->pluck('sub_golongan');
                                                                            @endphp
                                                                            <div class="form-group mb-3">
                                                                                <label style="font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">
                                                                                    <i class="fas fa-layer-group me-1" style="color: #3b82f6;"></i> Sub-Golongan Spesifik <span style="color: #ef4444;">*</span>
                                                                                </label>
                                                                                
                                                                                <div style="position: relative;">
                                                                                    <select name="sub_golongan" class="form-select shadow-sm" style="border-radius: 8px; border: 1px solid #cbd5e1; padding: 12px 16px; font-size: 14px; color: #334155; font-weight: 500; cursor: pointer; transition: all 0.2s ease; background-color: #f8fafc;" required>
                                                                                        <option value="" selected disabled>-- Pilih Sub-Golongan Tarif --</option>
                                                                                        @foreach($listSubGolongan as $sub)
                                                                                            <option value="{{ $sub }}">{{ $sub }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>3. Pilih Ukuran Meter</label>
                                                                            <select name="ukuran_meter" class="form-control" required>
                                                                                <option value="" disabled selected>-- Pilih Ukuran Meter --</option>
                                                                                <option value="0,5">0,5 Inchi</option>
                                                                                <option value="0,75">0,75 Inchi</option>
                                                                                <option value="1">1 Inchi</option>
                                                                                <option value="1,5">1,5 Inchi</option>
                                                                                <option value="2">2 Inchi</option>
                                                                                <option value="3">3 Inchi</option>
                                                                                <option value="10">10 Inchi</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group"><label>4. Nomor Seri Meter</label><input type="text" name="no_meter" class="form-control" required></div>
                                                                        <div class="form-group"><label>5. Merk Meter</label><input type="text" name="merk_meter" class="form-control" required></div>
                                                                        
                                                                        <div style="grid-column: 1 / -1; margin-top: 10px;">
                                                                            <label style="font-size: 11px; color: #065f46; font-weight: bold; margin-bottom: 3px;">Titik Koordinat Rumah (GPS)</label>
                                                                            <div style="display: flex; gap: 10px; align-items: center;">
                                                                                <input type="text" name="latitude" id="lat_{{ $data->id }}" value="{{ $data->latitude ?? '' }}" class="form-control" style="background:#f8fafc;" readonly required>
                                                                                <input type="text" name="longitude" id="long_{{ $data->id }}" value="{{ $data->longitude ?? '' }}" class="form-control" style="background:#f8fafc;" readonly required>
                                                                                <button type="button" onclick="getLocation({{ $data->id }})" class="btn-submit-primary" style="padding:10px 16px; border-radius:8px; border:none; color:white; font-weight:bold; cursor:pointer;">📍 Lacak Lokasi</button>
                                                                            </div>
                                                                            <small id="status_gps_{{ $data->id }}" style="font-size:11px; color:#64748b;">Tekan tombol Lacak Lokasi</small>
                                                                        </div>
                                                                        <button type="submit" class="btn-submit-full btn-submit-success">✅ Aktivasi Langsung</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            
                                                            @if($canDelete)
                                                            <div class="divider" style="margin: 30px 0;"></div>
                                                            <div class="form-section" style="background: #fef2f2; border-color: #fecaca; margin-top:0;">
                                                                <h3 style="color: #991b1b;">❌ Tolak Pengajuan</h3>
                                                                <form action="{{ route('admin.pelanggan.tolak', $data->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="form-group"><textarea name="alasan_penolakan" class="form-control" rows="3" required></textarea></div>
                                                                    <button type="submit" class="btn-submit-full btn-danger" style="background: #dc2626;">Kirim Penolakan</button>
                                                                </form>
                                                            </div>
                                                            @endif
                                                        @elseif($data->status_pembayaran_pasang == 'Belum Bayar')
                                                            <div class="form-section form-section--warning">
                                                                <h3>⏳ Menunggu Pembayaran Pasang Baru</h3>
                                                                <div class="payment-info">
                                                                    <p><strong>Total Tagihan:</strong> Rp {{ number_format($data->total_tagihan_pasang, 0, ',', '.') }}</p>
                                                                    <p><strong>Status:</strong> <span class="status-danger">BELUM BAYAR</span></p>
                                                                </div>
                                                                <p><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_rab', 'nama_file' => $data->foto_rab]) }}" target="_blank" class="btn-doc btn-doc-rab">📄 Cek Foto RAB Lapangan</a></p>
                                                                <hr class="divider">
                                                                <p class="hint-text">Jika pelanggan membayar tunai di kantor, klik tombol di bawah ini:</p>
                                                                <form action="{{ route('admin.pelanggan.lunas_manual', $data->id) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" onclick="return confirm('Yakin set lunas manual?')" class="btn-submit-full btn-submit-primary">💵 Set Lunas Manual (Bayar Cash)</button>
                                                                </form>
                                                            </div>
                                                        @elseif($data->status_pembayaran_pasang == 'Lunas')
                                                            <div class="form-section form-section--success">
                                                                <h3>💳 Pembayaran Lunas! Siap Aktifkan</h3>
                                                                <p class="form-desc">Pelanggan telah membayar biaya pasang. Silakan masukkan Nomor Pelanggan resmi setelah pipa terpasang.</p>
                                                                <form action="{{ route('admin.pelanggan.approve', $data->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="form-group"><label>1. Masukkan Nomor Pelanggan Baru</label><input type="text" name="nomor_pelanggan" class="form-control" required></div>
                                                                    <div class="form-group">
                                                                        <label>2. Tetapkan Sub-Golongan Tarif</label>
                                                                        @php
                                                                        $listSubGolongan = \App\Models\TarifAir::select('sub_golongan')
                                                                                            ->whereNotNull('sub_golongan')
                                                                                            ->distinct()
                                                                                            ->pluck('sub_golongan');
                                                                        @endphp
                                                                        <div class="form-group mb-3">
                                                                            <select name="sub_golongan" class="form-select shadow-sm" style="border-radius: 8px; border: 1px solid #cbd5e1; padding: 12px 16px; font-size: 14px; background-color: #f8fafc;" required>
                                                                                <option value="" selected disabled>-- Pilih Sub-Golongan Tarif --</option>
                                                                                @foreach($listSubGolongan as $sub)
                                                                                    <option value="{{ $sub }}">{{ $sub }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>3. Pilih Ukuran Meter</label>
                                                                        <select name="ukuran_meter" class="form-control" required>
                                                                            <option value="" disabled selected>-- Pilih Ukuran Meter --</option>
                                                                            <option value="0,5">0,5 Inchi</option>
                                                                            <option value="0,75">0,75 Inchi</option>
                                                                            <option value="1">1 Inchi</option>
                                                                            <option value="1,5">1,5 Inchi</option>
                                                                            <option value="2">2 Inchi</option>
                                                                            <option value="3">3 Inchi</option>
                                                                            <option value="10">10 Inchi</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group"><label>4. Nomor Seri Meter</label><input type="text" name="no_meter" class="form-control" required></div>
                                                                    <div class="form-group"><label>5. Merk Meter</label><input type="text" name="merk_meter" class="form-control" required></div>
                                                                    <div style="grid-column: 1 / -1; margin-top: 10px;">
                                                                        <label style="font-size: 11px; color: #065f46; font-weight: bold; margin-bottom: 3px;">Titik Koordinat Rumah (GPS)</label>
                                                                        <div style="display: flex; gap: 10px; align-items: center;">
                                                                            <input type="text" name="latitude" id="lat_{{ $data->id }}" value="{{ $data->latitude ?? '' }}" class="form-control" style="background:#f8fafc;" readonly required>
                                                                            <input type="text" name="longitude" id="long_{{ $data->id }}" value="{{ $data->longitude ?? '' }}" class="form-control" style="background:#f8fafc;" readonly required>
                                                                            <button type="button" onclick="getLocation({{ $data->id }})" class="btn-submit-primary" style="padding:10px 16px; border-radius:8px; border:none; color:white; font-weight:bold; cursor:pointer;">📍 Lacak Lokasi</button>
                                                                        </div>
                                                                    </div>
                                                                    <button type="submit" class="btn-submit-full btn-submit-success">✅ Simpan Nomor, Tarif & Setujui</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div style="margin-top: 24px; padding: 16px; background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; color: #475569; font-size: 14px; text-align: center;">
                                                            <span style="font-size: 24px; display: block; margin-bottom: 8px;">👀</span>
                                                            <strong>Mode Pratinjau (Read-Only)</strong><br>
                                                            Kewenangan untuk menyetujui pengajuan ini hanya dimiliki oleh Kepala Cabang wilayah <strong>{{ $data->kecamatan }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align:center; padding:40px; color:var(--text-muted); background: var(--bg-card); border-radius: 8px; border: 1px solid var(--border);">
                    <div style="font-size: 32px; margin-bottom: 10px;">📭</div>
                    <em>Belum ada antrean pendaftaran di tab Pending.</em>
                </div>
            @endforelse
        </div>

    {{-- ========================================================== --}}
    {{-- TAB 2: APPROVED (LACI KECAMATAN -> LACI RAYON) --}}
    {{-- ========================================================== --}}
    @elseif($tab == 'Approved')
        <div id="container-approved">
            @forelse($groupedApproved as $kecamatan => $rayons)
                @php $kecId = \Illuminate\Support\Str::slug($kecamatan ?? 'unknown'); @endphp
                
                <div class="rayon-group mb-4">
                    <div onclick="toggleLaci('laci-kec-app-{{ $kecId }}')" style="background: #1e293b; border-left: 4px solid #0f172a; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: var(--shadow-sm);">
                        <strong style="color: #ffffff; font-size: 15px;">🏢 Kecamatan: {{ $kecamatan ?? 'Belum Diisi' }}</strong>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="background: #3b82f6; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ $rayons->flatten()->count() }} Warga</span>
                            <i class="fas fa-chevron-down" style="color: #ffffff; transition: 0.3s;" id="icon-laci-kec-app-{{ $kecId }}"></i>
                        </div>
                    </div>

                    <div id="laci-kec-app-{{ $kecId }}" style="display: {{ request('search') ? 'block' : 'none' }}; padding: 10px 15px; border: 1px dashed #cbd5e1; border-top: none; border-radius: 0 0 8px 8px; background: #f8fafc; margin-bottom: 20px;">
                        @foreach($rayons as $rayon => $pelanggans)
                            <div class="rayon-group mb-3">
    <div onclick="toggleLaci('laci-ray-{{ $kecId }}-{{ $rayon }}')" style="background: #ecfdf5; border-left: 4px solid #10b981; padding: 10px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
        <strong style="color: #065f46; font-size: 14px;">📍 Area Rayon: {{ $rayon }}</strong>
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="background: #10b981; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">{{ count($pelanggans) }} Warga</span>
            <i class="fas fa-chevron-down" style="color: #10b981; transition: 0.3s;" id="icon-laci-ray-{{ $kecId }}-{{ $rayon }}"></i>
        </div>
    </div>
    
    <div id="laci-ray-{{ $kecId }}-{{ $rayon }}" style="display: {{ request('search') ? 'block' : 'none' }}; transition: all 0.3s ease;">
                                    <div class="table-card">
                                        <table>
                                            <thead><tr><th>No</th><th>Nama & Kontak</th><th>No Pelanggan</th><th>Alamat Pemasangan</th><th>Status</th><th>Aksi</th></tr></thead>
                                            <tbody>
                                                @foreach($pelanggans as $index => $data)
                                                    @php 
                                                        // LOGIKA IZIN EDIT & HAPUS
                                                        $canEdit = (auth()->user()->role == 'super_admin') || (in_array(auth()->user()->role, ['kepala_cabang', 'petugas_pemasangan']) && auth()->user()->cabang_id == $data->cabang_id);
                                                        // Petugas Pasang gak boleh hapus/tolak
                                                        $canDelete = (auth()->user()->role == 'super_admin') || (auth()->user()->role == 'kepala_cabang' && auth()->user()->cabang_id == $data->cabang_id);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="cell-name">
                                                                <strong>{{ $data->nama_lengkap }}</strong>
                                                                <span class="cell-sub">📞 {{ $data->no_hp }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="cell-name">
                                                                <strong>{{ $data->nomor_pelanggan }}</strong>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                {{ $data->alamat_lengkap }}
                                                                <div class="cell-sub">RT {{ $data->rt }}/RW {{ $data->rw }}, {{ $data->kelurahan }}, {{ $data->kecamatan }}</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-approved">✅ Approved</span>
                                                        </td>
                                                        <td style="white-space: nowrap; width: 1%;">
                                                            <div style="display: flex; gap: 8px; align-items: center;">
                                                                <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal-{{ $data->id }}').style.display='block'">👁️ Detail</button>
                                                                
                                                                @if($canDelete)
                                                                    <form action="{{ route('admin.pelanggan.destroy', $data->id) }}" method="POST" style="display:inline-block;">
                                                                        @csrf @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini dari daftar?')">🗑️ Hapus</button>
                                                                    </form>
                                                                @elseif(!$canEdit)
                                                                    <span style="background: #f1f5f9; color: #94a3b8; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; border: 1px dashed #cbd5e1; cursor: not-allowed;" title="Akses Ditolak: Beda Wilayah Cabang">🔒 Read Only</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    {{-- ===== MODAL ===== --}}
                                                    <div id="modal-{{ $data->id }}" class="modal-overlay">
                                                        <div class="modal-dialog">
                                                            <div class="modal-head">
                                                                <h2>📄 Detail Pemohon: {{ $data->nama_lengkap }}</h2>
                                                                <button class="modal-close" onclick="document.getElementById('modal-{{ $data->id }}').style.display='none'">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="detail-grid">
                                                                    <div>
                                                                        <div class="section-label">Informasi Pemohon</div>
                                                                        <div class="detail-item"><div class="label">NIK</div><div class="value">{{ $data->nik }}</div></div>
                                                                        <div class="detail-item"><div class="label">No KK</div><div class="value">{{ $data->no_kk }}</div></div>
                                                                        <div class="detail-item"><div class="label">Email</div><div class="value">{{ $data->email ?? '-' }}</div></div>
                                                                        <div class="detail-item"><div class="label">Peruntukan Awal</div><div class="value">{{ $data->peruntukan }}</div></div>
                                                                        <div class="detail-item"><div class="label">Sub-Golongan Spesifik</div><div class="value highlight">{{ $data->sub_golongan ?? 'Belum Ditentukan' }}</div></div>
                                                                        <div class="detail-item"><div class="label">Status Kepemilikan</div><div class="value">{{ $data->status_kepemilikan }}</div></div>
                                                                        <div class="detail-item">
                                                                            <div class="label">Link Peta Survei</div>
                                                                            <div class="value">
                                                                                @if($data->koordinat_map)
                                                                                <a href="{{ $data->koordinat_map }}" target="_blank">📍 Buka di Google Maps</a>
                                                                                @else
                                                                                <span style="color: var(--text-light);">Tidak ada link peta</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="section-label">Berkas Dokumen</div>
                                                                        <div class="detail-item"><div class="label">Foto KTP</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_ktp', 'nama_file' => $data->foto_selfie_ktp]) }}" target="_blank" class="btn-doc btn-doc-ktp">👁️ Buka Selfie KTP</a></div></div>
                                                                        <div class="detail-item"><div class="label">Foto KTP</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_ktp', 'nama_file' => $data->foto_ktp]) }}" target="_blank" class="btn-doc btn-doc-ktp">👁️ Buka KTP</a></div></div>
                                                                        <div class="detail-item"><div class="label">Foto KK</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_rumah', 'nama_file' => $data->foto_kk]) }}" target="_blank" class="btn-doc btn-doc-kk">👁️ Buka KK</a></div></div>
                                                                        <div class="detail-item"><div class="label">Foto Rumah</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_rumah', 'nama_file' => $data->foto_rumah]) }}" target="_blank" class="btn-doc btn-doc-rumah">🏠 Buka Foto Rumah</a></div></div>
                                                                    </div>
                                                                </div>

                                                                @if($canEdit)
                                                                    <div class="approved-box">
                                                                        <h3>✅ Pemasangan Disetujui</h3>
                                                                        <form action="{{ route('admin.pelanggan.update_nomor', $data->id) }}" method="POST">
                                                                            @csrf
                                                                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px;">
                                                                                <div><label style="font-size:11px; font-weight:bold;">Nomor Pelanggan</label><input type="text" name="nomor_pelanggan" value="{{ $data->nomor_pelanggan }}" class="form-control" required></div>
                                                                                <div>
                                                                                    <label style="font-size:11px; font-weight:bold;">Golongan Tarif</label>
                                                                                    <select name="sub_golongan" class="form-control" required>
                                                                                        <option value="{{ $data->sub_golongan ?? '' }}" selected>{{ $data->sub_golongan ?? 'Pilih Ulang' }}</option>
                                                                                        <option value="Sosial Umum">Sosial Umum</option>
                                                                                        <option value="Sosial Khusus">Sosial Khusus</option>
                                                                                        <option value="Rumah Tangga A">Rumah Tangga A</option>
                                                                                        <option value="Rumah Tangga B">Rumah Tangga B</option>
                                                                                        <option value="Rumah Tangga C">Rumah Tangga C</option>
                                                                                        <option value="Rumah Tangga D">Rumah Tangga D</option>
                                                                                        <option value="Instansi">Instansi</option>
                                                                                        <option value="Niaga A">Niaga A</option>
                                                                                        <option value="Niaga B">Niaga B</option>
                                                                                        <option value="Industri A">Industri A</option>
                                                                                        <option value="Industri B">Industri B</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div>
                                                                                    <label style="font-size:11px; font-weight:bold;">Ukuran Meter</label>
                                                                                    <select name="ukuran_meter" class="form-control" required>
                                                                                        <option value="{{ $data->ukuran_meter ?? '' }}" selected>{{ $data->ukuran_meter ?? 'Pilih' }}</option>
                                                                                        <option value="0,5">0,5 Inchi</option>
                                                                                        <option value="0,75">0,75 Inchi</option>
                                                                                        <option value="1">1 Inchi</option>
                                                                                        <option value="1,5">1,5 Inchi</option>
                                                                                        <option value="2">2 Inchi</option>
                                                                                        <option value="3">3 Inchi</option>
                                                                                        <option value="10">10 Inchi</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div><label style="font-size:11px; font-weight:bold;">Nomor Seri</label><input type="text" name="no_meter" value="{{ $data->no_meter }}" class="form-control" required></div>
                                                                                <div style="grid-column: 1 / -1;"><label style="font-size:11px; font-weight:bold;">Merk Meter</label><input type="text" name="merk_meter" value="{{ $data->merk_meter }}" class="form-control" required></div>
                                                                                
                                                                                <div style="grid-column: 1 / -1; margin-top: 10px;">
                                                                                    <div style="display: flex; gap: 10px; align-items: center;">
                                                                                        <input type="text" name="latitude" id="lat_edit_{{ $data->id }}" value="{{ $data->latitude ?? '' }}" class="form-control" readonly required>
                                                                                        <input type="text" name="longitude" id="long_edit_{{ $data->id }}" value="{{ $data->longitude ?? '' }}" class="form-control" readonly required>
                                                                                        <button type="button" onclick="getLocation({{ $data->id }})" class="btn-submit-primary" style="padding:10px 16px; border-radius:8px; border:none; color:white; font-weight:bold; cursor:pointer;">📍 Lacak</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="submit" class="btn-submit-full btn-submit-success" style="margin-top: 15px;">✏️ Update Data</button>
                                                                        </form>
                                                                    </div>
                                                                @else
                                                                    <div style="margin-top: 24px; padding: 16px; background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; color: #475569; font-size: 14px; text-align: center;">
                                                                        <span style="font-size: 24px; display: block; margin-bottom: 8px;">👀</span>
                                                                        <strong>Mode Pratinjau (Read-Only)</strong><br>
                                                                        Kewenangan untuk mengubah data warga ini hanya dimiliki oleh Kepala Cabang atau Petugas Pemasangan wilayah <strong>{{ $data->kecamatan }}</strong>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div style="text-align:center; padding:40px; color:var(--text-muted); background: var(--bg-card); border-radius: 8px; border: 1px solid var(--border);">
                    <div style="font-size: 32px; margin-bottom: 10px;">📭</div>
                    <em>Belum ada warga yang disetujui di tab ini.</em>
                </div>
            @endforelse
        </div>

    {{-- ========================================================== --}}
    {{-- TAB 3: REJECTED (TABEL FLAT TANPA LACI) --}}
    {{-- ========================================================== --}}
    @elseif($tab == 'Rejected' && !in_array(auth()->user()->role, ['petugas_meter', 'kasir']))
        <div class="table-card">
            <table>
                <thead><tr><th>No</th><th>Nama & Kontak</th><th>Alamat Pemasangan</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($pendaftar as $index => $data)
                        @php 
                            $canDelete = (auth()->user()->role == 'super_admin') || (auth()->user()->role == 'kepala_cabang' && auth()->user()->cabang_id == $data->cabang_id);
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="cell-name">
                                    <strong>{{ $data->nama_lengkap }}</strong>
                                    <span class="cell-sub">📞 {{ $data->no_hp }}</span>
                                </div>
                            </td>
                            <td>
                                <div>
                                    {{ $data->alamat_lengkap }}
                                    <div class="cell-sub">RT {{ $data->rt }}/RW {{ $data->rw }}, {{ $data->kelurahan }}, {{ $data->kecamatan }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-rejected">❌ Rejected</span>
                            </td>
                            <td style="white-space: nowrap; width: 1%;">
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal-{{ $data->id }}').style.display='block'">👁️ Detail</button>
                                    
                                    @if($canDelete)
                                        <form action="{{ route('admin.pelanggan.destroy', $data->id) }}" method="POST" style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini dari daftar?')">🗑️ Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- ===== MODAL ===== --}}
                        <div id="modal-{{ $data->id }}" class="modal-overlay">
                            <div class="modal-dialog">
                                <div class="modal-head">
                                    <h2>📄 Detail Pemohon: {{ $data->nama_lengkap }}</h2>
                                    <button class="modal-close" onclick="document.getElementById('modal-{{ $data->id }}').style.display='none'">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="detail-grid">
                                        <div>
                                            <div class="section-label">Informasi Pemohon</div>
                                            <div class="detail-item"><div class="label">NIK</div><div class="value">{{ $data->nik }}</div></div>
                                            <div class="detail-item"><div class="label">No KK</div><div class="value">{{ $data->no_kk }}</div></div>
                                            <div class="detail-item"><div class="label">Email</div><div class="value">{{ $data->email ?? '-' }}</div></div>
                                            <div class="detail-item"><div class="label">Peruntukan Awal</div><div class="value">{{ $data->peruntukan }}</div></div>
                                            <div class="detail-item"><div class="label">Sub-Golongan Spesifik</div><div class="value highlight">{{ $data->sub_golongan ?? 'Belum Ditentukan' }}</div></div>
                                            <div class="detail-item"><div class="label">Status Kepemilikan</div><div class="value">{{ $data->status_kepemilikan }}</div></div>
                                        </div>
                                        <div>
                                            <div class="section-label">Berkas Dokumen</div>
                                            <div class="detail-item"><div class="label">Foto KTP</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_ktp', 'nama_file' => $data->foto_selfie_ktp]) }}" target="_blank" class="btn-doc btn-doc-ktp">👁️ Buka Selfie KTP</a></div></div>
                                            <div class="detail-item"><div class="label">Foto KTP</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_ktp', 'nama_file' => $data->foto_ktp]) }}" target="_blank" class="btn-doc btn-doc-ktp">👁️ Buka KTP</a></div></div>
                                            <div class="detail-item"><div class="label">Foto KK</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_rumah', 'nama_file' => $data->foto_kk]) }}" target="_blank" class="btn-doc btn-doc-kk">👁️ Buka KK</a></div></div>
                                            <div class="detail-item"><div class="label">Foto Rumah</div><div class="value"><a href="{{ route('dokumen.rahasia', ['jenis' => 'berkas_rumah', 'nama_file' => $data->foto_rumah]) }}" target="_blank" class="btn-doc btn-doc-rumah">🏠 Buka Foto Rumah</a></div></div>
                                        </div>
                                    </div>
                                    
                                    <div style="background: #fef2f2; border: 1px solid #fecaca; padding: 20px; border-radius: 8px; margin-top: 24px;">
                                        <h3 style="color: #991b1b; margin-top: 0;">❌ Pengajuan Ini Ditolak</h3>
                                        <p style="font-size: 14px; color: #b91c1c;"><strong>Alasan:</strong> {{ $data->alasan_penolakan ?? 'Tidak ada keterangan.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px; color:var(--text-muted);">
                                <div style="font-size: 32px; margin-bottom: 10px;">📭</div>
                                <em>Tidak ada data pengajuan yang ditolak.</em>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
    <div style="display: flex; justify-content: center; margin-top: 25px; margin-bottom: 20px;">
        {{ $pendaftar->links() }}
    </div>
</div>

<script>
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

    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none');
        }
    });

    function getLocation(id) {
        const statusText = document.getElementById('status_gps_' + id) || document.getElementById('status_gps_edit_' + id);
        statusText.innerText = "⏳ Sedang mencari sinyal GPS satelit...";
        statusText.style.color = "#f59e0b";

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    let latInput = document.getElementById('lat_' + id) || document.getElementById('lat_edit_' + id);
                    let longInput = document.getElementById('long_' + id) || document.getElementById('long_edit_' + id);
                    
                    if (latInput) latInput.value = position.coords.latitude;
                    if (longInput) longInput.value = position.coords.longitude;
                    
                    statusText.innerText = "✅ Titik GPS berhasil dikunci!";
                    statusText.style.color = "#10b981";
                },
                function(error) {
                    statusText.innerText = "❌ Gagal: Tolong izinkan akses lokasi (Location) di browser Anda.";
                    statusText.style.color = "#ef4444";
                },
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        } else {
            statusText.innerText = "❌ Browser atau perangkat Anda tidak mendukung fitur GPS.";
            statusText.style.color = "#ef4444";
        }
    }
</script>
@endsection