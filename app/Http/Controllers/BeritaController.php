<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    // 1. Nampilin Halaman Berita
    public function index()
    {

    if (auth()->user()->role !== 'super_admin' && auth()->user()->role !== 'admin_berita' && auth()->user()->role !== 'kepala_cabang') {
    return redirect()->route('admin.pelanggan')->with('error', 'Divisi lu gak berhak ngurusin berita/pengumuman bre!');
    }
        // Tarik semua berita dari yang paling baru
        $berita = Berita::orderBy('created_at', 'desc')->get();
        return view('admin.berita', compact('berita'));
    }

    public function beritaPelanggan()
{
    
    $berita = Berita::latest()->paginate(9);
    return view('berita', compact('berita')); 
}

    // 2. Nyimpen Berita Baru ke Database
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'super_admin' && auth()->user()->role !== 'admin_berita' && auth()->user()->role !== 'kepala_cabang') {
        return redirect()->route('admin.pelanggan')->with('error', 'Divisi lu gak berhak ngurusin berita/pengumuman bre!');
        }
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048' // Maksimal 2MB
        ]);

        $fotoPath = null;
        // Kalau admin nge-upload foto, simpan ke folder 'berita_foto'
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('berita_foto', 'public');
        }

        // Masukin ke database
        Berita::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'foto' => $fotoPath
        ]);

        return back()->with('sukses', 'Berita berhasil dipublikasikan!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'super_admin' && auth()->user()->role !== 'admin_berita' && auth()->user()->role !== 'kepala_cabang') {
        return redirect()->route('admin.pelanggan')->with('error', 'Divisi lu gak berhak ngurusin berita/pengumuman bre!');
        }
        $berita = Berita::findOrFail($id);

        // Kalau beritanya punya foto, hapus dulu fotonya dari folder storage
        if ($berita->foto) {
            Storage::disk('public')->delete($berita->foto);
        }

        // Kalau fotonya udah aman kehapus, baru hapus datanya dari database
        $berita->delete();

        return back()->with('sukses', 'Berita beserta fotonya berhasil dihapus bersih!');
    }
}