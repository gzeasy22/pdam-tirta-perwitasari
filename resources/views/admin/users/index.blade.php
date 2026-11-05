@extends('layouts.admin')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    body { background-color: #f8f9fa; }
    .table-hover tbody tr:hover { background-color: #f1f5f9; }
</style>

<div class="container-fluid px-4 mt-4 mb-5">
    
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body d-flex justify-content-between align-items-center py-3 px-4">
            <div>
                <h5 class="fw-bold text-dark m-0"><i class="fas fa-users-cog text-primary me-2"></i> Kelola Akun Pegawai</h5>
                <small class="text-muted">Manajemen hak akses internal staf dan penugasan area</small>
            </div>
            @if(auth()->user()->role == 'super_admin')
            <button type="button" class="btn btn-primary shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">
                <i class="fas fa-plus me-1"></i> Tambah Pegawai
            </button>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 5px solid #198754;">
            <i class="fas fa-check-circle me-2"></i> <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 5px solid #dc3545;">
            <i class="fas fa-exclamation-triangle me-2"></i> 
            <strong>Gagal!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        $isSuperAdmin = auth()->user()->role == 'super_admin';
        // Kalau Superadmin, kelompokkan per laci cabang
        $loopDataPegawai = $isSuperAdmin ? $users->groupBy('cabang_id')->sortKeys() : ['_flat' => $users];
    @endphp

    <div id="container-pegawai">
        @forelse($loopDataPegawai as $cabangId => $pegawais)
            @php 
                $kecId = $cabangId ?: 'pusat'; 
                $namaCabangLaci = $cabangId ? "KECAMATAN " . strtoupper($pegawais->first()->cabang->nama_cabang ?? 'CABANG ID '.$cabangId) : "KANTOR PUSAT / MANAJEMEN UTAMA";
            @endphp
            
            @if($isSuperAdmin)
            <div class="kecamatan-group mb-4">
                <div onclick="toggleLaci('laci-kec-pegawai-{{ $kecId }}')" style="background: #1e293b; border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <strong style="color: #ffffff; font-size: 15px;">🏢 {{ $namaCabangLaci }}</strong>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="background: #f59e0b; color: #0f172a; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">{{ count($pegawais) }} Pegawai</span>
                        <i class="fas fa-chevron-down" style="color: #ffffff; transition: 0.3s;" id="icon-laci-kec-pegawai-{{ $kecId }}"></i>
                    </div>
                </div>
                <div id="laci-kec-pegawai-{{ $kecId }}" style="display: none; padding: 0; background: transparent; margin-bottom: 20px;">
            @endif
    
                <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    @if(!$isSuperAdmin)
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 fw-bold" style="color: #475569;">Daftar Akun Aktif di Cabang Anda</h6>
                    </div>
                    @endif
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="text-secondary small fw-bold" style="background-color: #f8fafc;">
                                    <tr>
                                        <th class="ps-4 py-3" style="width: 80px;">NO</th>
                                        <th>NAMA PEGAWAI</th>
                                        <th>EMAIL LOGIN</th>
                                        <th>JABATAN (ROLE)</th>
                                        <th class="text-center text-nowrap" style="width: 250px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody class="small border-top-0">
                                    @foreach($pegawais as $index => $u)
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary">{{ $loop->iteration }}</td>
                                        <td class="fw-semibold text-dark">{{ $u->name }}</td>
                                        <td><span class="text-muted">{{ $u->email }}</span></td>
                                        <td>
                                            {{-- 🚨 BADGE ROLE DENGAN PETUGAS PEMASANGAN 🚨 --}}
                                            @if($u->role == 'super_admin')
                                                <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold"><i class="fas fa-key me-1"></i> Super Admin</span>
                                            @elseif($u->role == 'kepala_cabang')
                                                <span class="badge bg-primary px-3 py-2 rounded-pill fw-bold"><i class="fas fa-user-tie me-1"></i> Kepala Cabang</span>
                                            @elseif($u->role == 'kasir')
                                                <span class="badge bg-success px-3 py-2 rounded-pill fw-bold"><i class="fas fa-wallet me-1"></i> Kasir / Loket</span>
                                            @elseif($u->role == 'admin_berita')
                                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold"><i class="fas fa-newspaper me-1"></i> Admin Berita</span>
                                            @elseif($u->role == 'petugas_pemasangan')
                                                <span class="badge bg-dark text-white px-3 py-2 rounded-pill fw-bold"><i class="fas fa-tools me-1"></i> Petugas Pasang</span>
                                            @else
                                                <span class="badge bg-info text-dark px-3 py-2 rounded-pill fw-bold"><i class="fas fa-tint me-1"></i> Petugas Meter</span>
                                            @endif
                                        </td>
                                        <td class="text-center pe-3">
                                            <div style="display: flex; gap: 8px; justify-content: center;">
                                                
                                                {{-- TOMBOL LIHAT DETAIL --}}
                                                <button type="button" class="btn btn-sm btn-outline-info px-3 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#detailPegawaiModal{{ $u->id }}" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i> {{ !$isSuperAdmin ? 'Lihat Detail' : '' }}
                                                </button>

                                                @if($isSuperAdmin)
                                                    {{-- TOMBOL ATUR RAYON (Khusus Petugas Meter) --}}
                                                    @if($u->role == 'petugas_meter')
                                                    <button type="button" class="btn btn-sm btn-outline-success px-3 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#aturRayonModal{{ $u->id }}" title="Atur Area Rayon">
                                                        <i class="fas fa-map-marked-alt"></i>
                                                    </button>
                                                    @endif

                                                    {{-- TOMBOL EDIT / MUTASI PEGAWAI --}}
                                                    <button type="button" class="btn btn-sm btn-outline-warning px-3 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#editPegawaiModal{{ $u->id }}" title="Edit / Mutasi">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    {{-- TOMBOL HAPUS --}}
                                                    @if($u->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin mau menghapus akun {{ $u->name }}?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill shadow-sm" title="Hapus Akun">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                    @else
                                                    <span class="badge bg-secondary px-3 py-2 rounded-pill" style="display: flex; align-items: center;">Aktif</span>
                                                    @endif
                                                @endif
                                            </div>

                                            {{-- MODAL DETAIL PEGAWAI --}}
                                            <div class="modal fade" id="detailPegawaiModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow-lg text-start" style="border-radius: 15px; overflow: hidden;">
                                                        <div class="modal-header bg-info text-white border-0">
                                                            <h6 class="modal-title fw-bold"><i class="fas fa-address-card me-2"></i> Data Pegawai: {{ $u->name }}</h6>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <table class="table table-sm table-borderless mb-0">
                                                                <tr><td class="text-secondary" width="45%">NIK Karyawan</td><td>: <strong>{{ $u->nik_karyawan ?? '-' }}</strong></td></tr>
                                                                <tr><td class="text-secondary">Username</td><td>: <strong>{{ $u->username ?? '-' }}</strong></td></tr>
                                                                <tr><td class="text-secondary">Email Akses</td><td>: <strong>{{ $u->email }}</strong></td></tr>
                                                                <tr><td class="text-secondary">Tempat Lahir</td><td>: <strong>{{ $u->tempat_lahir ?? '-' }}</strong></td></tr>
                                                                <tr><td class="text-secondary">Tanggal Lahir</td><td>: <strong>{{ $u->tanggal_lahir ? \Carbon\Carbon::parse($u->tanggal_lahir)->format('d M Y') : '-' }}</strong></td></tr>
                                                                {{-- Rapiin text modal role nya pakai trik kemarin --}}
                                                                <tr><td class="text-secondary">Jabatan Sistem</td><td>: <strong>{{ ucwords(str_replace('_', ' ', $u->role)) }}</strong></td></tr>
                                                                <tr><td class="text-secondary">Lokasi Cabang</td><td>: <strong>{{ $u->cabang ? $u->cabang->nama_cabang : 'Pusat (Semua Akses)' }}</strong></td></tr>
                                                                <tr><td class="text-secondary">Akun Dibuat</td><td>: <strong>{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</strong></td></tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            {{-- HANYA RENDER MODAL INI JIKA SUPER ADMIN --}}
                                            @if($isSuperAdmin)
                                                {{-- MODAL ATUR RAYON --}}
                                                <div class="modal fade" id="aturRayonModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content border-0 shadow-lg text-start" style="border-radius: 15px; overflow: hidden;">
                                                            <div class="modal-header bg-success text-white border-0">
                                                                <h6 class="modal-title fw-bold"><i class="fas fa-map-marker-alt me-2"></i> Atur Area (Rayon): {{ $u->name }}</h6>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('admin.users.update_rayon', $u->id) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body p-4">
                                                                    <p class="text-muted small mb-3">Pilih kecamatan untuk membuka daftar area (rayon), lalu centang yang menjadi tanggung jawab petugas ini:</p>
                                                                    
                                                                    <div class="accordion" id="accordionRayon{{ $u->id }}">
                                                                        @forelse($rayonPerCabang as $cabangModalId => $dataCabang)
                                                                            @php
                                                                                if ($u->cabang_id != $cabangModalId && $cabangModalId != 0) { continue; }
                                                                            @endphp

                                                                            <div class="accordion-item mb-2 border-0 shadow-sm rounded">
                                                                                <h2 class="accordion-header" id="heading{{ $u->id }}_{{ $cabangModalId }}">
                                                                                    <button class="accordion-button collapsed fw-bold text-dark rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $u->id }}_{{ $cabangModalId }}" style="background-color: #f8fafc; font-size: 14px;">
                                                                                        📍 KECAMATAN {{ $dataCabang['nama'] }} <span class="badge bg-success ms-2">{{ count($dataCabang['rayons']) }} Area</span>
                                                                                    </button>
                                                                                </h2>
                                                                                <div id="collapse{{ $u->id }}_{{ $cabangModalId }}" class="accordion-collapse collapse" data-bs-parent="#accordionRayon{{ $u->id }}">
                                                                                    <div class="accordion-body bg-white border-top">
                                                                                        <div class="row">
                                                                                            @foreach($dataCabang['rayons'] as $rayon)
                                                                                                @php $isChecked = isset($userRayons[$u->id]) && $userRayons[$u->id]->contains('rayon_code', $rayon); @endphp
                                                                                                <div class="col-6 mb-2">
                                                                                                    <div class="form-check form-switch">
                                                                                                        <input class="form-check-input" type="checkbox" name="rayons[]" value="{{ $rayon }}" id="rayon_{{ $u->id }}_{{ $rayon }}" {{ $isChecked ? 'checked' : '' }}>
                                                                                                        <label class="form-check-label fw-semibold text-secondary" for="rayon_{{ $u->id }}_{{ $rayon }}" style="font-size: 13px;">Rayon {{ $rayon }}</label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @empty
                                                                            <div class="col-12 text-center text-muted small py-2">Belum ada data rayon di sistem.</div>
                                                                        @endforelse
                                                                    </div>
                                                                    <hr class="my-3">
                                                                    <label class="form-label small fw-bold text-dark">Tambah Rayon Baru (Manual)</label>
                                                                    <input type="text" name="rayon_baru" class="form-control form-control-sm" placeholder="Contoh: 100205 (Kosongkan jika tidak perlu)">
                                                                </div>
                                                                <div class="modal-footer bg-light py-3 border-top-0">
                                                                    <button type="button" class="btn btn-secondary px-4 rounded-pill shadow-sm" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm"><i class="fas fa-save me-1"></i> Simpan Area</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- MODAL EDIT / MUTASI PEGAWAI --}}
                                                <div class="modal fade" id="editPegawaiModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content border-0 shadow-lg text-start" style="border-radius: 15px; overflow: hidden;">
                                                            <div class="modal-header bg-warning text-dark py-3 border-0">
                                                                <h6 class="modal-title fw-bold"><i class="fas fa-user-edit me-2"></i> Edit / Mutasi Pegawai</h6>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('admin.users.update', $u->id) }}" method="POST">
                                                                @csrf @method('PUT')
                                                                <div class="modal-body p-4 bg-white">
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label small fw-bold text-secondary">Nomor Induk Karyawan</label>
                                                                            <input type="text" name="nik_karyawan" value="{{ $u->nik_karyawan }}" class="form-control">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                                                                            <input type="text" name="name" value="{{ $u->name }}" class="form-control" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label small fw-bold text-secondary">Tempat Lahir</label>
                                                                            <input type="text" name="tempat_lahir" value="{{ $u->tempat_lahir }}" class="form-control">
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label small fw-bold text-secondary">Tanggal Lahir</label>
                                                                            <input type="date" name="tanggal_lahir" value="{{ $u->tanggal_lahir }}" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label small fw-bold text-secondary">Username Login</label>
                                                                            <input type="text" name="username" value="{{ $u->username }}" class="form-control" required>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label small fw-bold text-secondary">Email Kedinasan</label>
                                                                            <input type="email" name="email" value="{{ $u->email }}" class="form-control" required>
                                                                        </div>
                                                                    </div>      
                                                                    <div class="mb-3">
                                                                        <label class="form-label small fw-bold text-secondary">Reset Password (Opsional)</label>
                                                                        <input type="password" name="password" class="form-control" minlength="6" placeholder="Kosongkan jika tidak ingin ganti">
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label small fw-bold text-secondary">Jabatan (Role)</label>
                                                                            @if($u->role == 'super_admin' && $u->id == auth()->id())
                                                                                <input type="text" class="form-control" value="Super Admin / Pusat" disabled>
                                                                                <input type="hidden" name="role" value="super_admin">
                                                                            @else
                                                                                <select name="role" class="form-select" required>
                                                                                    <option value="kasir" {{ $u->role == 'kasir' ? 'selected' : '' }}>👩‍💻 Kasir Loket</option>
                                                                                    <option value="petugas_meter" {{ $u->role == 'petugas_meter' ? 'selected' : '' }}>👷‍♂️ Petugas Meter</option>
                                                                                    <option value="petugas_pemasangan" {{ $u->role == 'petugas_pemasangan' ? 'selected' : '' }}>🔧 Petugas Pemasangan</option>
                                                                                    <option value="admin_berita" {{ $u->role == 'admin_berita' ? 'selected' : '' }}>📰 Admin Berita</option>
                                                                                    <option value="super_admin" {{ $u->role == 'super_admin' ? 'selected' : '' }}>🛡️ Super Admin / Pusat</option>
                                                                                    <option value="kepala_cabang" {{ $u->role == 'kepala_cabang' ? 'selected' : '' }}>👔 Kepala Cabang</option>
                                                                                </select>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label small fw-bold text-secondary">Penempatan Cabang</label>
                                                                            @if($u->role == 'super_admin')
                                                                                <select class="form-select" disabled><option>-- PUSAT (Super Admin) --</option></select>
                                                                                <input type="hidden" name="cabang_id" value="">
                                                                            @else
                                                                                <select name="cabang_id" class="form-select">
                                                                                    <option value="">-- PUSAT --</option>
                                                                                    @for($i=1; $i<=13; $i++)
                                                                                        <option value="{{ $i }}" {{ $u->cabang_id == $i ? 'selected' : '' }}>Kecamatan ID {{ $i }}</option>
                                                                                    @endfor
                                                                                </select>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer bg-light py-3 border-top-0">
                                                                    <button type="button" class="btn btn-secondary px-4 rounded-pill shadow-sm" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-warning px-4 rounded-pill shadow-sm fw-bold"><i class="fas fa-save me-1"></i> Update Akun</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @if($isSuperAdmin)
                </div> 
            </div> 
            @endif
        @empty
                <div class="text-center py-4 text-muted">Belum ada data pegawai yang terdaftar.</div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

@if(auth()->user()->role == 'super_admin')
{{-- MODAL TAMBAH PEGAWAI --}}
<div class="modal fade" id="tambahAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header bg-primary text-white py-3 border-0">
                <h6 class="modal-title fw-bold"><i class="fas fa-user-plus me-2"></i> Tambah Akun Pegawai</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 bg-white">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Nomor Induk Karyawan</label>
                            <input type="text" name="nik_karyawan" class="form-control" placeholder="Contoh: 202609001">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" required placeholder="Sesuai KTP">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota lahir">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Username Login</label>
                            <input type="text" name="username" class="form-control" required placeholder="Buat username unik">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Email Kedinasan</label>
                            <input type="email" name="email" class="form-control" required placeholder="nama@pdam.com">
                        </div>
                    </div>      
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Password Akses Sementara</label>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="Minimal 6 karakter">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Pilih Jabatan (Role)</label>
                            <select name="role" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Hak Akses --</option>
                                <option value="kasir">👩‍💻 Kasir Loket</option>
                                <option value="petugas_meter">👷‍♂️ Petugas Meter</option>
                                <option value="petugas_pemasangan">🔧 Petugas Pemasangan</option>
                                <option value="admin_berita">📰 Admin Berita</option>
                                <option value="super_admin">🛡️ Super Admin / Pusat</option>
                                <option value="kepala_cabang">👔 Kepala Cabang</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">Penempatan Cabang</label>
                            <select name="cabang_id" class="form-select">
                                <option value="">-- PUSAT (Khusus Super Admin) --</option>
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
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-3 border-top-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill shadow-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm"><i class="fas fa-save me-1"></i> Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
</script>
@endsection