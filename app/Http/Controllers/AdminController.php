<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan; // Gunakan Eloquent Model, bukan DB::table
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image; // Pilar 4: Kompresi Gambar
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function indexPelanggan(Request $request)
    {
        $search = $request->query('search');
        $tab = $request->query('tab', 'Pending'); 
        $user = auth()->user();

        // 🚨 RBAC: KACAMATA KUDA KHUSUS PETUGAS METER & KASIR
        if (in_array($user->role, ['petugas_meter', 'kasir']) && $tab !== 'Approved') {
            return redirect()->route('admin.pelanggan', ['tab' => 'Approved']);
        }

        // Gunakan Eloquent Model
        $query = Pelanggan::query()->orderBy('created_at', 'desc')->where('status', $tab);

        // ==========================================
        // 🛡️ LOGIKA FILTER CABANG & RAYON (KACAMATA KUDA)
        // ==========================================
        if (!in_array($user->role, ['super_admin', 'kepala_cabang'])) {
            
            // 1. Kunci Utama: Petugas Pemasangan & Petugas Meter dikunci di cabangnya sendiri
            $query->where('cabang_id', $user->cabang_id);
            
            // 2. Kunci Ekstra: Khusus Petugas Meter
            if ($user->role === 'petugas_meter') {
                $rayonTugas = DB::table('rayon_petugas')
                                ->where('user_id', $user->id)
                                ->pluck('rayon_code')
                                ->toArray();

                if (empty($rayonTugas)) {
                    $query->whereNull('id'); // Block akses jika belum ada rayon
                } else {
                    $query->where(function($subQuery) use ($rayonTugas) {
                        foreach ($rayonTugas as $rayon) {
                            $subQuery->orWhere('nomor_pelanggan', 'like', $rayon . '%');
                        }
                    });
                }
            }
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nomor_pelanggan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_lengkap', 'LIKE', "%{$search}%");
            });
        }

        // PILAR 1: Ganti get() dengan paginate() agar RAM tidak jebol saat data puluhan ribu
        $pendaftar = $query->paginate(20);
        
        // Ambil collection dari data yang dipaginasi untuk di-grouping
        $pendaftarCollection = $pendaftar->getCollection();
        
        $groupedPending = collect();
        $groupedApproved = collect();

        if ($tab == 'Pending') {
            $groupedPending = $pendaftarCollection->groupBy('kecamatan')->sortKeys();
        } elseif ($tab == 'Approved') {
            $groupedApproved = $pendaftarCollection->groupBy('kecamatan')->map(function ($items) {
                return $items->groupBy(function ($item) {
                    return substr($item->nomor_pelanggan, 0, 6); 
                })->sortKeys();
            })->sortKeys();
        }

        // Hitungan lencana (badge) yang aman dan teroptimasi
        $countPending = 0;
        $countRejected = 0;
        $countApproved = 0;

        if (in_array($user->role, ['petugas_meter', 'kasir'])) {
            $countApproved = $pendaftar->total(); // Ambil total dari pagination
        } else {
            $baseQuery = Pelanggan::query();
            
            if (!in_array($user->role, ['super_admin', 'kepala_cabang'])) {
                $baseQuery->where('cabang_id', $user->cabang_id);
            }
            
            $countPending = (clone $baseQuery)->where('status', 'Pending')->count();
            $countApproved = (clone $baseQuery)->where('status', 'Approved')->count();
            $countRejected = (clone $baseQuery)->where('status', 'Rejected')->count();
        }
        
        return view('admin.pelanggan', compact('pendaftar', 'tab', 'search', 'countPending', 'countApproved', 'countRejected', 'groupedPending', 'groupedApproved'));
    }

    public function approvePelanggan(Request $request, $id)
    {
        // 🚨 GEMBOK TAMBAHAN: Cuma Super Admin & Kepala Cabang yang bisa Approve
        if (!in_array(auth()->user()->role, ['super_admin', 'kepala_cabang'])) {
            return back()->with('error', 'Akses Ditolak! Anda tidak memiliki wewenang untuk menyetujui pelanggan.');
        }

        $validated = $request->validate([
            'nomor_pelanggan' => 'required|unique:pelanggans,nomor_pelanggan',
            'sub_golongan'    => 'required|string', 
            'ukuran_meter'    => 'required|string',
            'no_meter'        => 'required|string',
            'merk_meter'      => 'required|string',
            'koordinat_map'   => 'nullable',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
        ]);

        try {
            DB::transaction(function () use ($validated, $id) {
                // PILAR 2: Gunakan Eloquent Model untuk update agar mematuhi standar ORM
                $pelanggan = Pelanggan::findOrFail($id);
                $validated['status'] = 'Approved';
                $pelanggan->update($validated);
            });

            return back()->with('sukses', 'Aktivasi Berhasil! Nomor Pelanggan, Tarif & Data Meter sudah masuk ke sistem.');
        } catch (\Exception $e) {
            Log::error('Approval error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function updateNomor(Request $request, $id)
    {
        // 🚨 GEMBOK TAMBAHAN: Cuma Super Admin & Kepala Cabang yang bisa Revisi Data
        if (!in_array(auth()->user()->role, ['super_admin', 'kepala_cabang'])) {
            return back()->with('error', 'Akses Ditolak! Anda tidak memiliki wewenang untuk merevisi data meter dan tarif.');
        }

        $validated = $request->validate([
            'nomor_pelanggan' => 'required|unique:pelanggans,nomor_pelanggan,' . $id,
            'sub_golongan'    => 'required|string',
            'ukuran_meter'    => 'required|string',
            'no_meter'        => 'required|string',
            'merk_meter'      => 'required|string',
            'koordinat_map'   => 'nullable',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
        ]);

        try {
            DB::transaction(function () use ($validated, $id) {
                $pelanggan = Pelanggan::findOrFail($id);
                $pelanggan->update($validated);
            });

            return back()->with('sukses', 'Data Pelanggan (Nomor, Tarif & Meteran) berhasil direvisi!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function inputRab(Request $request, $id)
    {
        // 🚨 GEMBOK TAMBAHAN: Cuma Super Admin, Kepala Cabang, & Petugas Pemasangan
        if (!in_array(auth()->user()->role, ['super_admin', 'kepala_cabang', 'petugas_pemasangan'])) {
            return back()->with('error', 'Akses Ditolak! Hanya Petugas Pemasangan yang berhak menginput RAB.');
        }

        $request->validate([
            'total_tagihan_pasang' => 'required|numeric',
            'foto_rab'             => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $file = $request->file('foto_rab');
                $filename = time() . '_RAB_' . $file->getClientOriginalName();
                $path = 'rahasia/berkas_rab/' . $filename;

                // PILAR 4: Kompresi foto RAB agar irit storage & ringan di-load
                $image = Image::make($file)->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($file->getClientOriginalExtension(), 75);

                Storage::disk('local')->put($path, $image);

                $pelanggan = Pelanggan::findOrFail($id);
                $pelanggan->update([
                    'total_tagihan_pasang'     => $request->total_tagihan_pasang,
                    'foto_rab'                 => $path,
                    'status_pembayaran_pasang' => 'Belum Bayar',
                ]);
            });

            return back()->with('sukses', 'RAB berhasil diinput! Menunggu pembayaran pelanggan.');
        } catch (\Exception $e) {
            Log::error('Upload RAB Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengunggah RAB.');
        }
    }

    public function lunasManual($id)
    {
        // 🚨 GEMBOK TAMBAHAN: Cuma Super Admin & Kasir
        if (!in_array(auth()->user()->role, ['super_admin', 'kasir'])) {
            return back()->with('error', 'Akses Ditolak! Hanya Kasir yang berhak melunasi tagihan.');
        }

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'status_pembayaran_pasang' => 'Lunas',
        ]);

        return back()->with('sukses', 'Pembayaran Pasang Baru diset Lunas! Silakan masukkan Nomor Pelanggan resmi.');
    }

    public function destroyPelanggan($id)
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'kepala_cabang'])) {
            return back()->with('error', 'Akses Ditolak! Hanya Kepala Cabang yang berhak menghapus pendaftaran.');
        }

        // PILAR 2: Soft Deletes
        // Diganti dari DB::table()->delete() menjadi Eloquent Model delete().
        // Ini akan mengamankan data dengan mengisi kolom 'deleted_at' (tidak hilang dari database).
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return back()->with('sukses', 'Data berhasil dipindahkan ke tong sampah (Soft Deleted)!');
    }

    public function tolakPengajuan(Request $request, $id)
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'kepala_cabang'])) {
            return back()->with('error', 'Akses Ditolak! Hanya Kepala Cabang yang berhak menolak pendaftaran.');
        }

        $validated = $request->validate([
            'alasan_penolakan' => 'required|string|min:10',
        ], [
            'alasan_penolakan.required' => 'Wajib isi alasan penolakan!',
            'alasan_penolakan.min'      => 'Alasan minimal 10 karakter ya bre!'
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'status'           => 'Rejected',
            'alasan_penolakan' => $validated['alasan_penolakan'],
        ]);

        return back()->with('sukses', 'Pengajuan pasang baru berhasil DITOLAK.');
    }
}