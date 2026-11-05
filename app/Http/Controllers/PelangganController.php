<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'foto_kk' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'foto_rumah' => 'required|image|mimes:jpg,jpeg,png|max:4096',
            'foto_selfie_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048', // <-- TAMBAHAN VALIDASI SELFIE
            'nik' => 'required|string|size:16|unique:pelanggans,nik', 
            'no_kk' => 'required|string|size:16', 
            'cabang_id' => 'required'
        ], [
            'nik.size' => 'NIK harus berjumlah tepat 16 digit ya!',
            'nik.unique' => 'Waduh, NIK KTP ini sudah pernah didaftarkan sebelumnya!',
            'no_kk.size' => 'Nomor KK harus berjumlah tepat 16 digit ya!',
            'cabang_id.required' => 'Kecamatan wajib dipilih!',
            'foto_selfie_ktp.required' => 'Foto Selfie memegang KTP wajib diunggah!',
        ]);

        // 2. Simpan foto-foto ke folder storage
        $ktpPath = $request->file('foto_ktp')->store('rahasia/berkas_ktp');
        $kkPath = $request->file('foto_kk')->store('rahasia/berkas_ktp');
        $rumahPath = $request->file('foto_rumah')->store('rahasia/berkas_ktp');
        $selfiePath = $request->file('foto_selfie_ktp')->store('rahasia/berkas_ktp'); // <-- TAMBAHAN SIMPAN SELFIE

        $cabangTerpilih = \Illuminate\Support\Facades\DB::table('cabangs')->where('id', $request->cabang_id)->first();
        $namaKecamatan = $cabangTerpilih ? $cabangTerpilih->nama_cabang : 'Tidak Diketahui';

        // 4. Masukin semua data ke database tabel 'pelanggans'
        \Illuminate\Support\Facades\DB::table('pelanggans')->insert([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'no_kk' => $request->no_kk, 
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat_lengkap' => $request->alamat_lengkap,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $namaKecamatan,
            'cabang_id' => $request->cabang_id,
            'koordinat_map' => $request->koordinat_map,
            'peruntukan' => $request->peruntukan,
            'status_kepemilikan' => $request->status_kepemilikan,
            'foto_ktp' => $ktpPath,
            'foto_kk' => $kkPath,
            'foto_rumah' => $rumahPath,
            'foto_selfie_ktp' => $selfiePath, // <-- TAMBAHAN INSERT DB
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Kalau sukses, lempar balik ke halaman form bawa pesan sukses
        return back()->with('sukses', 'Pendaftaran berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = auth()->user(); // Kenali siapa admin yang lagi login sekarang!

        $pelanggans = \App\Models\Pelanggan::query()
            // ==========================================
            // 🛡️ KACAMATA KUDA (FILTER CABANG) DIMULAI!
            // ==========================================
            ->when($user->role !== 'super_admin' && $user->role !== 'kepala_cabang' && $user->cabang_id, function ($query) use ($user) {
                // Kalau BUKAN Super Admin, KUNCI data sesuai cabang adminnya!
                $query->where('cabang_id', $user->cabang_id);
            })
            // ==========================================
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_pelanggan', 'like', "%{$search}%")
                      ->orWhere('nama_lengkap', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20);

        return view('admin.pelanggan', compact('pelanggans'));
    }

    // 1. Function buat nyetujuin pendaftaran baru (Pending -> Approved)
    public function approve(Request $request, $id)
    {
        $request->validate([
            'nomor_pelanggan' => 'required|string|unique:pelanggans,nomor_pelanggan',
            'sub_golongan' => 'required|string',
        ]);

        // Cari pelanggan, lalu timpa datanya secara paksa (Bypass filter model)
        $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->update([
            'nomor_pelanggan' => $request->nomor_pelanggan,
            'sub_golongan'    => $request->sub_golongan,
            'status'          => 'Approved',
        ]);

        return back()->with('sukses', 'Pemasangan disetujui! Nomor & Tarif berhasil disimpan.');
    }

    // 2. Function buat revisi/edit kalau admin salah input
    public function update_nomor(Request $request, $id)
    {
        $validated = $request->validate([
            'nomor_pelanggan' => 'required|string',
            'sub_golongan'    => 'required|string',
        ]);

        Pelanggan::findOrFail($id)->update($validated);

        return back()->with(
            'sukses',
            'Revisi Nomor Pelanggan & Tarif berhasil diupdate!'
        );
    }

    // Nampilin halaman form input NIK
    // Nampilin halaman form input NIK
    public function cekStatus(Request $request)
    {
        // 1. Kalau user belum ngetik NIK (Baru buka halaman awal)
        if (!$request->has('nik') || $request->nik == '') {
            return view('cek-pemasangan');
        }

        // 2. Kalau NIK udah di-submit via GET, kita cari di database
        $data = \App\Models\Pelanggan::where('nik', $request->nik)->first();

        // Kalau NIK gak ketemu
        if (!$data) {
            return redirect()->route('cek-pemasangan.index')->with('error', 'Data Pendaftaran tidak ditemukan. Pastikan NIK sudah benar.');
        }

        // 3. Logika Midtrans (Ditambah Biaya Admin 3000)
        if ($data->status_pembayaran_pasang == 'Belum Bayar') {
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Kalau belum punya token, buatin dan simpan
            if (!$data->snap_token_pasang) {
                $orderId = 'RAB-' . $data->id . '-' . time();
                
                // 🚨 LOGIKA PENAMBAHAN BIAYA ADMIN
                $biaya_rab = $data->total_tagihan_pasang;
                $biaya_admin = 3000;
                $total_bayar = $biaya_rab + $biaya_admin;

                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => $total_bayar,
                    ],
                    'item_details' => [
                        [
                            'id' => 'RAB-PASANG-' . $data->id,
                            'price' => $biaya_rab,
                            'quantity' => 1,
                            'name' => 'Biaya RAB Pasang Baru PDAM'
                        ],
                        [
                            'id' => 'ADMIN-FEE',
                            'price' => $biaya_admin,
                            'quantity' => 1,
                            'name' => 'Biaya Layanan Pembayaran'
                        ]
                    ],
                    'customer_details' => [
                        'first_name' => $data->nama_lengkap,
                        'phone' => $data->no_hp,
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);

                $data->update([
                    'order_id_pasang' => $orderId,
                    'snap_token_pasang' => $snapToken
                ]);
            }
        }

        $snapToken = $data->snap_token_pasang ?? null;
        return view('cek-pemasangan', compact('data', 'snapToken'));
    }

    public function sinkron(Request $request)
    {
        $data = \App\Models\Pelanggan::where('nik', $request->nik)->first();

        if (!$data || !$data->order_id_pasang) return back();

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;

        try {
            $statusMidtrans = \Midtrans\Transaction::status($data->order_id_pasang);

            if ($statusMidtrans->transaction_status == 'settlement' || $statusMidtrans->transaction_status == 'capture') {
                $data->update(['status_pembayaran_pasang' => 'Lunas']);
                // Redirect bawa NIK biar formnya langsung nampil
                return redirect()->route('cek-pemasangan.index', ['nik' => $request->nik])->with('sukses', 'Mantap! Pembayaran Anda sudah Lunas.');
            } elseif ($statusMidtrans->transaction_status == 'expire' || $statusMidtrans->transaction_status == 'cancel') {
                $data->update(['snap_token_pasang' => null, 'order_id_pasang' => null]);
                return redirect()->route('cek-pemasangan.index', ['nik' => $request->nik])->with('error', 'Waktu pembayaran habis. Silakan klik Bayar Sekarang lagi.');
            } else {
                return redirect()->route('cek-pemasangan.index', ['nik' => $request->nik])->with('sukses', 'Status saat ini: Pembayaran masih menunggu (Pending).');
            }
        } catch (\Exception $e) {
            return redirect()->route('cek-pemasangan.index', ['nik' => $request->nik])->with('error', 'Gagal terhubung ke Midtrans.');
        }
    }

    public function batal(Request $request)
    {
        $data = \App\Models\Pelanggan::where('nik', $request->nik)->first();

        if ($data && $data->status_pembayaran_pasang == 'Belum Bayar') {
            // Hapus token lama biar Midtrans bisa nge-generate yang baru
            $data->update(['snap_token_pasang' => null, 'order_id_pasang' => null]);
            return redirect()->route('cek-pemasangan.index', ['nik' => $request->nik])->with('sukses', 'Pilihan metode pembayaran direset. Silakan klik Bayar Sekarang untuk memilih ulang.');
        }
        
        return back();
    }

    public function callbackRab(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY_PASANG');

        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                // Ambil ID pelanggan dari order_id (Format kita tadi: RAB-ID-TIME)
                $orderIdParts = explode('-', $request->order_id);
                $pelangganId = $orderIdParts[1];

                // Update status di database jadi Lunas!
                \App\Models\Pelanggan::where('id', $pelangganId)->update([
                    'status_pembayaran_pasang' => 'Lunas',
                    'updated_at' => now(),
                ]);
            }
        }
        return response()->json(['message' => 'Callback diterima']);
    }
}