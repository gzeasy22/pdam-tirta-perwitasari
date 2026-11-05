@extends('layouts.admin')

@section('content')
<style>
    .form-berita { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
    .input-group { margin-bottom: 15px; }
    .input-group label { display: block; font-weight: 600; color: #475569; margin-bottom: 8px; }
    .input-group input[type="text"], .input-group textarea { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; }
    .input-group input[type="file"] { padding: 10px; border: 1px dashed #cbd5e1; width: 100%; border-radius: 6px; }
    .btn-submit { background: #0ea5e9; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
    .btn-submit:hover { background: #0284c7; }
    .img-thumb { width: 100px; height: 70px; object-fit: cover; border-radius: 4px; }
</style>

@if(session('sukses'))
    <div style="background: #10b981; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        ✅ {{ session('sukses') }}
    </div>
@endif

<div class="form-berita">
    <h2 style="margin-bottom: 20px; color: #0f172a;">✍️ Tulis Berita Baru</h2>
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group">
            <label>Judul Berita</label>
            <input type="text" name="judul" placeholder="Contoh: Pipa Bocor di Jalan Merdeka..." required>
        </div>
        <div class="input-group">
            <label>Isi Pengumuman / Berita</label>
            <textarea name="isi" rows="5" placeholder="Tulis detail informasinya di sini..." required></textarea>
        </div>
        <div class="input-group">
            <label>Upload Foto Pendukung (Opsional)</label>
            <input type="file" name="foto" accept="image/*">
        </div>
        <button type="submit" class="btn-submit">Publikasikan Berita</button>
    </form>
</div>

<div class="card">
    <h2 style="margin-bottom: 20px; color: #0f172a;">📰 Daftar Berita Terpublikasi</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Judul Berita</th>
                <th>Tanggal Publish</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($berita as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" class="img-thumb" alt="Foto Berita">
                    @else
                        <span style="color: #94a3b8; font-size: 13px;">Tanpa Foto</span>
                    @endif
                </td>
                <td><strong>{{ $item->judul }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</td>
                <td>
                    <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau menghapus berita ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action" style="background: #ef4444; border: none; cursor: pointer;">🗑️ Hapus</button>
                </form>
                </td>
            </tr>
            @endforeach
            
            @if($berita->isEmpty())
            <tr>
                <td colspan="5" style="text-align: center; color: #64748b; padding: 20px;">Belum ada berita yang dipublikasikan.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection