<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
   public function indexAdmin(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $search = $request->query('search');

        $query = \App\Models\Pengaduan::with('pelanggan')->latest();

        // 🚨 SATPAM CABANG DIPERBARUI 🚨
        // Sekarang filternya langsung nembak ke kolom cabang_id di tabel pengaduans!
        if ($user->role !== 'super_admin' && $user->cabang_id) {
            $query->where('cabang_id', $user->cabang_id); 
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pelapor', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi_masalah', 'LIKE', "%{$search}%")
                  ->orWhereHas('pelanggan', function($subQ) use ($search) {
                      $subQ->where('nomor_pelanggan', 'LIKE', "%{$search}%");
                  });
            });
        }

        $pengaduans = $query->get(); 
        return view('admin.pengaduan', compact('pengaduans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_pelapor'     => 'required|in:Pelanggan,Umum',
            'nama_pelapor'      => 'required|string',
            'no_hp'             => 'required|string',
            'lokasi_kejadian'   => 'required|string',
            'link_map'          => 'required|url', 
            'deskripsi_masalah' => 'required|string',
            'foto_bukti'        => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('pengaduan_foto', 'public');
        }

        // LOGIKA PENYIMPANAN CABANG & KECAMATAN
        if ($request->jenis_pelapor == 'Pelanggan') {
            $request->validate([
                'nomor_pelanggan' => 'required|exists:pelanggans,nomor_pelanggan'
            ], ['nomor_pelanggan.exists' => 'Nomor Pelanggan tidak terdaftar di sistem kami.']);

            $dataPelanggan = \App\Models\Pelanggan::where('nomor_pelanggan', $request->nomor_pelanggan)->first();

            \App\Models\Pengaduan::updateOrCreate(
                ['pelanggan_id' => $dataPelanggan->id, 'status' => 'Open'],
                [
                    'jenis_pelapor'     => $request->jenis_pelapor,
                    'cabang_id'         => $dataPelanggan->cabang_id, // Ambil dari profil pelanggan
                    'kecamatan'         => $dataPelanggan->kecamatan, // Ambil dari profil pelanggan
                    'nama_pelapor'      => $request->nama_pelapor,
                    'no_hp'             => $request->no_hp,
                    'lokasi_kejadian'   => $request->lokasi_kejadian,
                    'link_map'          => $request->link_map,
                    'deskripsi_masalah' => $request->deskripsi_masalah,
                    'foto_bukti'        => $fotoPath ?? \DB::raw('foto_bukti'),
                    'updated_at'        => now(),
                ]
            );
        } else {
            // Validasi tambahan khusus masyarakat umum wajib milih wilayah
            $request->validate(['cabang_id' => 'required']);
            
            $cabangTerpilih = \Illuminate\Support\Facades\DB::table('cabangs')->where('id', $request->cabang_id)->first();
            $namaKecamatan = $cabangTerpilih ? $cabangTerpilih->nama_cabang : 'Wilayah Tidak Diketahui';

            \App\Models\Pengaduan::create([
                'pelanggan_id'      => null,
                'jenis_pelapor'     => $request->jenis_pelapor,
                'cabang_id'         => $request->cabang_id, // Ambil dari dropdown form
                'kecamatan'         => $namaKecamatan,      // Ambil dari database cabang
                'nama_pelapor'      => $request->nama_pelapor,
                'no_hp'             => $request->no_hp,
                'lokasi_kejadian'   => $request->lokasi_kejadian,
                'link_map'          => $request->link_map,
                'deskripsi_masalah' => $request->deskripsi_masalah,
                'foto_bukti'        => $fotoPath,
                'status'            => 'Open',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        return back()->with('sukses_lapor', 'Laporan Anda sudah kami terima! Mohon tunggu tim teknisi kami mengecek lokasi.');
    }

    // Fungsi baru buat update status pengaduan oleh admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Open,Proses,Resolved'
        ]);

        $pengaduan = \App\Models\Pengaduan::findOrFail($id);
        $pengaduan->status = $request->status;
        $pengaduan->save();

        return back()->with('sukses_lapor', 'Status pengaduan berhasil diperbarui!');
    }
}