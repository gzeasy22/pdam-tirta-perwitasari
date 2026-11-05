@extends('layouts.admin') {{-- Ganti jadi layouts.app kalau emang nama file layout lu app --}}

@section('content')
<style>
    .admin-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        padding: 25px;
        margin-bottom: 30px;
    }
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 15px;
    }
    .admin-title {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
    }
    .btn-tambah-custom {
        background: #3b82f6;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
        border: none;
    }
    .btn-tambah-custom:hover {
        background: #2563eb;
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }
    .custom-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #e2e8f0;
    }
    .custom-table td {
        padding: 15px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }
    .custom-table tr:hover td {
        background-color: #f8fafc;
    }
    .badge-kategori {
        background: #e0f2fe;
        color: #0369a1;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-hapus-custom {
        background: #ef4444;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: bold;
        transition: 0.2s;
    }
    .btn-hapus-custom:hover {
        background: #dc2626;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
    }
</style>

<div class="container-fluid">
    <div class="admin-card">
        
        <div class="admin-header">
            <h2 class="admin-title">👥 Manajemen Profil & Organisasi</h2>
            <a href="{{ route('admin.profil.create') }}" class="btn-tambah-custom">
                + Tambah Data Baru
            </a>
        </div>

        @if(session('success'))
            <div style="background: #dcfce3; border-left: 5px solid #22c55e; color: #166534; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Kategori</th>
                        <th>Foto</th>
                        <th>Nama / Judul</th>
                        <th>Jabatan / Keterangan</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profils as $key => $p)
                    <tr>
                        <td style="font-weight: bold; color: #94a3b8;">{{ $key + 1 }}</td>
                        <td><span class="badge-kategori">{{ str_replace('_', ' ', $p->kategori) }}</span></td>
                        <td>
                            <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 2px solid #e2e8f0;">
                        </td>
                        <td style="font-weight: bold;">{{ $p->nama_atau_judul }}</td>
                        <td>{{ $p->jabatan_atau_keterangan ?? '-' }}</td>
                        <td style="text-align: center;">
                            <form action="{{ route('admin.profil.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-hapus-custom">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8; font-weight: bold;">
                            Belum ada data. Silakan tambah data baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection