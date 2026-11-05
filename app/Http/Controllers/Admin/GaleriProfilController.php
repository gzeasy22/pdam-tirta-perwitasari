<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriProfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// Import Intervention Image (Pastikan package-nya sudah di-install)
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriProfilController extends Controller
{
    public function index()
    {
        // PILAR 1: Ganti get() jadi paginate() biar database/RAM nggak jebol pas data ribuan
        $galeris = GaleriProfil::latest()->paginate(12);
        
        return view('admin.galeri_profil.index', compact('galeris'));
    }

    public function create()
    {
        return view('admin.galeri_profil.create');
    }

    public function store(Request $request)
    {
        // Tetap izinkan upload 3MB di awal untuk jaga-jaga file HD
        $request->validate([
            'kategori' => 'required|string|max:100',
            'foto'     => 'required|image|mimes:jpeg,png,jpg,webp|max:3072', 
        ]);

        try {
            DB::transaction(function () use ($request) {
                $file = $request->file('foto');
                $filename = Str::slug($request->kategori) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $path = 'galeri_fotos/' . $filename;

                // PILAR 4: Kompresi Gambar sebelum masuk Storage
                // Resize lebar max 1200px (aspect ratio terjaga) & kompres kualitas 75%
                $image = Image::make($file)->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($file->getClientOriginalExtension(), 75);

                // Simpan ke storage public
                Storage::disk('public')->put($path, $image);

                // Insert ke database
                GaleriProfil::create([
                    'kategori' => $request->kategori,
                    'foto'     => $path,
                ]);
            });

            return redirect()->route('admin.galeri_profil.index')
                ->with('success', 'Berhasil! Gambar ' . $request->kategori . ' sudah dikompres & diupload.');

        } catch (\Exception $e) {
            Log::error('Gagal upload galeri: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses gambar.');
        }
    }

    public function destroy($id)
    {
        $galeri = GaleriProfil::findOrFail($id);
        
        // PILAR 2: Soft Deletes Implementation
        // HAPUS SCRIPT LAMA: Jangan gunakan Storage::disk('public')->delete() di sini!
        // Kalau file fisiknya dihapus sekarang, fitur "Restore Data" dari Soft Deletes bakal error karena fotonya udah hilang beneran.
        
        $galeri->delete(); // Ini otomatis cuma ngisi kolom 'deleted_at' (kalau trait SoftDeletes aktif di Model)

        return redirect()->route('admin.galeri_profil.index')
            ->with('success', 'Sip! Gambar berhasil dipindah ke tong sampah (Soft Deleted).');
    }
}