<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TarifAir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// Cache facade udah dihapus biar gak menuh-menuhin memori

class TarifAirController extends Controller
{
    public function index()
    {
        // OPTIMASI JANGKA PANJANG:
        // Ambil data langsung dari database menggunakan Paginate.
        // Jauh lebih aman dan gak akan ada bentrok data string vs object di view Blade.
        $tarifs = TarifAir::orderBy('kategori_golongan', 'ASC')
                          ->orderBy('sub_golongan', 'ASC')
                          ->paginate(15);

        return view('admin.tarif.index', compact('tarifs'));
    }

    public function create()
    {
        // Nampilin halaman form untuk nambah data tarif
        return view('admin.tarif.create'); 
    }   

    public function edit($id)
    {
        // Cari data tarif berdasarkan ID buat ditampilin di form edit
        $tarif = TarifAir::findOrFail($id);
        
        // Lempar data ke halaman form edit
        return view('admin.tarif.edit', compact('tarif'));
    }

    public function store(Request $request)
    {
        // Validasi ketat + Mass Assignment Protection
        $validated = $request->validate([
            'kategori_golongan' => 'required|string|max:50',
            'sub_golongan'      => 'required|string|max:50',
            'min_pakai'         => 'required|numeric',
            'tarif_blok_1'      => 'required|numeric',
            'tarif_blok_2'      => 'required|numeric',
            'tarif_blok_3'      => 'required|numeric',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                TarifAir::create($validated);
            });

            return redirect()->route('admin.tarif.index')
                             ->with('success', 'Mantap! Tarif golongan baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal simpan tarif: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_golongan' => 'required|string|max:50',
            'sub_golongan'      => 'required|string|max:50',
            'min_pakai'         => 'required|numeric',
            'tarif_blok_1'      => 'required|numeric',
            'tarif_blok_2'      => 'required|numeric',
            'tarif_blok_3'      => 'required|numeric',
        ]);

        try {
            DB::transaction(function () use ($validated, $id) {
                $tarif = TarifAir::findOrFail($id);
                $tarif->update($validated);
            });

            return redirect()->route('admin.tarif.index')
                             ->with('success', 'Sip! Harga tarif berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Gagal update tarif: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupdate tarif.');
        }
    }

    public function destroy($id)
    {
        // Soft Deletes berjalan otomatis kalau model TarifAir udah dipasang trait SoftDeletes
        $tarif = TarifAir::findOrFail($id);
        $tarif->delete();

        return redirect()->route('admin.tarif.index')
                         ->with('success', 'Tarif berhasil dipindah ke tong sampah.');
    }
}