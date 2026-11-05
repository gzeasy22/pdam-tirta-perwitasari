@extends('layouts.admin')

@section('content')
<div style="padding: 24px; font-family: sans-serif;">
    <h2 style="color: #0f172a; margin-bottom: 20px;">📂 Kelola Dokumen PPID</h2>

    @if(session('sukses'))
        <div style="background: #d1fae5; color: #047857; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #34d399;">
            ✅ {{ session('sukses') }}
        </div>
    @endif

    <!-- FORM UPLOAD -->
    <div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h3 style="margin-top: 0; color: #334155; font-size: 16px;">➕ Unggah Dokumen Baru</h3>
        <form action="{{ route('admin.ppid.store') }}" method="POST" enctype="multipart/form-data" style="display: grid; gap: 15px;">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 14px;">Kategori *</label>
                    <select name="kategori" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                        <option value="Informasi Berkala">Informasi Berkala</option>
                        <option value="Informasi Serta Merta">Informasi Serta Merta</option>
                        <option value="Informasi Setiap Saat">Informasi Setiap Saat</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 14px;">Judul Dokumen *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Laporan Keuangan 2025" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                </div>
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 14px;">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="2" placeholder="Penjelasan singkat isi dokumen..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;"></textarea>
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 14px;">Upload File (PDF/Doc/Gambar, Max 5MB) *</label>
                <input type="file" name="file_dokumen" required accept=".pdf,.doc,.docx,.jpg,.png" style="width: 100%; padding: 10px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 6px;">
            </div>

            <button type="submit" style="background: #3b82f6; color: white; padding: 12px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">🚀 Simpan Dokumen</button>
        </form>
    </div>

    <!-- TABEL DATA -->
    <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <tr>
                    <th style="padding: 15px; font-size: 13px; color: #64748b;">KATEGORI</th>
                    <th style="padding: 15px; font-size: 13px; color: #64748b;">JUDUL DOKUMEN</th>
                    <th style="padding: 15px; font-size: 13px; color: #64748b;">TGL UPLOAD</th>
                    <th style="padding: 15px; font-size: 13px; color: #64748b; text-align: right;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ppids as $item)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 15px; font-weight: 600; font-size: 14px; color: #3b82f6;">{{ $item->kategori }}</td>
                    <td style="padding: 15px;">
                        <strong style="color: #1e293b; display: block;">{{ $item->judul }}</strong>
                        <span style="font-size: 12px; color: #64748b;">{{ Str::limit($item->deskripsi, 50) }}</span>
                    </td>
                    <td style="padding: 15px; font-size: 14px; color: #475569;">{{ $item->created_at->format('d M Y') }}</td>
                    <td style="padding: 15px; text-align: right;">
                        <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank" style="background: #10b981; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: bold; margin-right: 5px;">👁️ Lihat</a>
                        
                        <form action="{{ route('admin.ppid.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin mau hapus dokumen ini?')" style="background: #ef4444; color: white; padding: 6px 12px; border: none; border-radius: 4px; font-size: 12px; font-weight: bold; cursor: pointer;">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection