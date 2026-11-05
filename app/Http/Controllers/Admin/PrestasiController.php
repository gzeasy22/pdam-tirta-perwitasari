<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        // PILAR 1: Ganti get() dengan paginate() untuk meringankan beban server
        $prestasis = Prestasi::latest()->paginate(10);
        return view('admin.prestasi.index', compact('prestasis'));
    }

    public function create()
    {
        return view('admin.prestasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto'      => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'required|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $file = $request->file('foto');
                $filename = 'prestasi-' . time() . '.' . $file->getClientOriginalExtension();
                $path = 'prestasi_fotos/' . $filename;

                // PILAR 4: Kompresi Gambar pakai Intervention Image yang baru diinstall
                // Resize lebar max 800px (karena biasanya foto prestasi gak butuh sebesar galeri)
                $image = Image::make($file)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($file->getClientOriginalExtension(), 75);

                // Simpan hasil kompresi ke public storage
                Storage::disk('public')->put($path, $image);

                // Insert ke database
                Prestasi::create([
                    'foto'      => $path,
                    'deskripsi' => $request->deskripsi,
                ]);
            });

            return redirect()->route('admin.prestasi.index')
                ->with('success', 'Mantap! Data Prestasi berhasil ditambahkan dan foto telah dikompres.');

        } catch (\Exception $e) {
            Log::error('Gagal upload prestasi: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.');
        }
    }

    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        
        // PILAR 2: Implementasi Soft Deletes
        // Script Storage::delete() dihapus agar file fisik tetap ada jika sewaktu-waktu data di-restore
        
        $prestasi->delete();
        
        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Sip! Prestasi berhasil dipindah ke tong sampah (Soft Deleted).');
    }
}