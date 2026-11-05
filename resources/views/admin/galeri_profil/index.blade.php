@extends('layouts.admin')

@section('content')
<style>
    .admin-card { background: #ffffff; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); padding: 25px; margin-bottom: 30px; border: 1px solid #e2e8f0; }
    .btn-tambah-custom { background: #3b82f6; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: 0.3s; }
    .btn-tambah-custom:hover { background: #2563eb; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background: #f8fafc; padding: 15px; text-align: left; border-bottom: 2px solid #e2e8f0; color: #475569; }
    .custom-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; color: #334155; }
    .btn-hapus-custom { background: #ef4444; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.2s; }
    .btn-hapus-custom:hover { background: #dc2626; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); }
</style>

<div class="container-fluid">
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-weight: 800; margin: 0; color: #1e293b;">🗺️ Struktur Organisasi</h2>
            <a href="{{ route('admin.galeri_profil.create') }}" class="btn-tambah-custom">+ Upload Bagan</a>
        </div>

        @if(session('success'))
            <div style="background: #dcfce3; border-left: 5px solid #22c55e; color: #166534; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Foto Bagan Struktur</th>
                    <th>Kategori</th>
                    <th style="text-align: center; width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galeris as $key => $g)
                <tr>
                    <td style="font-weight: bold; color: #94a3b8;">{{ $key + 1 }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $g->foto) }}" alt="Bagan Struktur" style="height: 120px; width: auto; max-width: 100%; object-fit: contain; border-radius: 8px; border: 1px solid #cbd5e0; padding: 5px; background: #f8fafc;">
                    </td>
                    <td>
                        <span style="background: #e0f2fe; color: #0369a1; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 800; text-transform: uppercase;">
                            {{ str_replace('_', ' ', $g->kategori) }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <form action="{{ route('admin.galeri_profil.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus bagan ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus-custom">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #94a3b8; font-weight: bold;">
                        Belum ada bagan struktur yang diupload.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection