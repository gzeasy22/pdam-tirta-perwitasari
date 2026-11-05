<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ppid;
use Illuminate\Support\Facades\Storage;

class PpidController extends Controller
{
    // ================= PUBLIK (Warga) =================
    public function indexPublic(Request $request)
    {
        $kategori = $request->query('kategori');
        $query = Ppid::latest();

        // Fitur filter kategori kalau warga milih di dropdown
        if ($kategori && $kategori != 'Semua') {
            $query->where('kategori', $kategori);
        }

        $ppids = $query->paginate(15);
        return view('ppid', compact('ppids', 'kategori'));
    }

    // ================= ADMIN =================
    public function indexAdmin()
    {
        $ppids = Ppid::latest()->get();
        return view('admin.ppid', compact('ppids'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori'     => 'required',
            'judul'        => 'required|string|max:255',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:5120', // Maksimal 5MB
        ]);

        // Simpan file ke folder storage/app/public/ppid_dokumen
        $path = $request->file('file_dokumen')->store('ppid_dokumen', 'public');

        Ppid::create([
            'kategori'     => $request->kategori,
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'file_dokumen' => $path,
        ]);

        return back()->with('sukses', 'Dokumen PPID berhasil diunggah!');
    }

    public function destroy($id)
    {
        $ppid = Ppid::findOrFail($id);
        
        // Hapus file fisiknya dari storage biar memori server gak penuh
        if ($ppid->file_dokumen) {
            Storage::disk('public')->delete($ppid->file_dokumen);
        }
        
        $ppid->delete();

        return back()->with('sukses', 'Dokumen PPID berhasil dihapus!');
    }
}