@extends('layouts.admin')

@section('content')
<style>
    .admin-card { background: #ffffff; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); padding: 25px; margin-bottom: 30px; }
    .btn-tambah-custom { background: #3b82f6; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background: #f8fafc; padding: 15px; text-align: left; border-bottom: 2px solid #e2e8f0; }
    .custom-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .btn-hapus-custom { background: #ef4444; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer; }
</style>

<div class="container-fluid">
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-weight: 800; margin: 0;">🏆 Manajemen Prestasi</h2>
            <a href="{{ route('admin.prestasi.create') }}" class="btn-tambah-custom">+ Tambah Prestasi</a>
        </div>

        @if(session('success'))
            <div style="background: #dcfce3; color: #166534; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Foto Piagam / Prestasi</th>
                    <th>Deskripsi Prestasi</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestasis as $key => $p)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $p->foto) }}" alt="Prestasi" style="width: 100px; height: 70px; object-fit: cover; border-radius: 8px;">
                    </td>
                    <td>{!! Str::limit(strip_tags($p->deskripsi), 100) !!}</td>
                    <td style="text-align: center;">
                        <form action="{{ route('admin.prestasi.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus prestasi ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus-custom">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center; padding: 30px;">Belum ada data prestasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection