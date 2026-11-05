<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function lihatFile($jenis, $nama_file)
    {
        // Pastiin spasi di URL (kayak %20) terbaca normal
        $nama_file = urldecode($nama_file);

        // JARING 1: Data Lama (Cek di disk 'public')
        if (Storage::disk('public')->exists($nama_file)) {
            return response()->file(Storage::disk('public')->path($nama_file));
        }

        // JARING 2: Data Baru (Karena DB PelangganController nyimpen full path 'rahasia/berkas_ktp/...')
        // Kita langsung tembak aja ke disk local tanpa nambahin apa-apa
        if (Storage::disk('local')->exists($nama_file)) {
            return response()->file(Storage::disk('local')->path($nama_file));
        }

        // JARING 3: Format RAB & Meteran (Nyimpen cuma nama filenya doang di DB)
        $pathRahasia = 'rahasia/' . $jenis . '/' . $nama_file;
        if (Storage::disk('local')->exists($pathRahasia)) {
            return response()->file(Storage::disk('local')->path($pathRahasia));
        }

        // MUNCULIN LAYAR DETEKTIF KALAU MASIH GAK KETEMU
        $path1 = Storage::disk('public')->path($nama_file);
        $path2 = Storage::disk('local')->path($nama_file);
        $path3 = Storage::disk('local')->path($pathRahasia);

        return response("
            <div style='font-family: sans-serif; padding: 30px; background: #fff5f5; border: 2px solid #fc8181; border-radius: 8px; max-width: 800px; margin: 40px auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>
                <h2 style='color: #c53030; margin-top: 0;'>🚨 TERCIDUK! FOTO GAK KETEMU DI SERVER! 🚨</h2>
                <p style='color: #333;'>Satpam Laravel udah nerima URL lu, tapi pas dia ngecek ke gudang <b>storage</b>, file fisiknya beneran <b>GAK ADA</b> bre!</p>
                <p style='color: #333;'><b>Dia udah nyari ke 3 jalur ini:</b></p>
                <ol style='color: #555; background: #fff; padding: 15px 35px; border-radius: 6px; border: 1px solid #e2e8f0;'>
                    <li style='margin-bottom: 10px;'><code>$path1</code></li>
                    <li style='margin-bottom: 10px;'><code>$path2</code></li>
                    <li><code>$path3</code></li>
                </ol>
                <h4 style='color: #c53030; margin-bottom: 5px;'>💡 Solusi:</h4>
                <p style='color: #333; margin-top: 0;'>Ini 100% terjadi karena data lama yang fotonya belum masuk, atau folder storage lu sempet ke-reset/kosong.</p>
            </div>
        ", 404);
    }
}