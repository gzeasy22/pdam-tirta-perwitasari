<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config; 
use Midtrans\Snap;    
use Midtrans\Transaction;

class BalikNamaController extends Controller
{
    // ==========================================
    // 🌐 SISI PUBLIK (PELANGGAN)
    // ==========================================
    public function indexPublik(Request $request)
    {
        $pelanggan = null;
        $riwayatPengajuan = null; 
        
        if ($request->has('nomor_pelanggan')) {
            $pelanggan = DB::table('pelanggans')->where('nomor_pelanggan', $request->nomor_pelanggan)->first();
            if (!$pelanggan) { return redirect()->route('balik-nama.index')->with('error', 'Nomor Pelanggan tidak ditemukan!'); }

            $riwayatPengajuan = DB::table('pengajuan_balik_namas')->where('pelanggan_id', $pelanggan->id)->orderBy('created_at', 'desc')->first();
        }
        return view('balik-nama', compact('pelanggan', 'riwayatPengajuan'));
    }

    public function storePengajuan(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required', 'nama_baru' => 'required|string|max:255', 'nik_baru' => 'required|string|size:16',
            'foto_ktp_baru' => 'required|image|mimes:jpg,jpeg,png|max:2048', 'foto_bukti_kepemilikan' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $ktpPath = $request->file('foto_ktp_baru')->store('rahasia/berkas_ktp');
        $buktiPath = $request->file('foto_bukti_kepemilikan')->store('rahasia/berkas_kepemilikan');
        $pelanggan = DB::table('pelanggans')->where('id', $request->pelanggan_id)->first();

        DB::table('pengajuan_balik_namas')->insert([
            'pelanggan_id' => $request->pelanggan_id, 'nama_lama' => $pelanggan->nama_lengkap, 'nama_baru' => $request->nama_baru,
            'nik_baru' => $request->nik_baru, 'foto_ktp_baru' => $ktpPath, 'foto_bukti_kepemilikan' => $buktiPath,
            'status' => 'Pending', 'created_at' => now(), 'updated_at' => now(),
        ]);
        return redirect()->route('balik-nama.index')->with('sukses', 'Pengajuan Balik Nama berhasil dikirim! Silakan tunggu validasi dari admin.');
    }

    // 🚨 FUNGSI BARU: Generate Token Midtrans saat warga klik bayar
    // 🚨 UPDATE: Generate Token Midtrans (Plus Biaya Admin 3.000)
    public function bayar(Request $request)
    {
        $pengajuan = DB::table('pengajuan_balik_namas')->where('id', $request->id_pengajuan)->first();
        
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        if (!$pengajuan->snap_token) {
            $order_id = 'BN-' . $pengajuan->id . '-' . time();
            
            // 💰 LOGIKA BIAYA ADMIN
            $biaya_balik_nama = 27500;
            $biaya_admin = 3000;
            $total_bayar = $biaya_balik_nama + $biaya_admin;

            $params = [
                'transaction_details' => [ 'order_id' => $order_id, 'gross_amount' => $total_bayar ],
                'item_details' => [ 
                    [ 'id' => 'ADM-BN', 'price' => $biaya_balik_nama, 'quantity' => 1, 'name' => 'Biaya Admin Balik Nama PDAM' ],
                    [ 'id' => 'FEE-MD', 'price' => $biaya_admin, 'quantity' => 1, 'name' => 'Biaya Layanan Pembayaran' ]
                ],
                'customer_details' => [ 'first_name' => $pengajuan->nama_baru ]
            ];
            
            $snapToken = Snap::getSnapToken($params);
            
            DB::table('pengajuan_balik_namas')->where('id', $pengajuan->id)->update([
                'snap_token' => $snapToken, 'order_id' => $order_id
            ]);
        } else {
            $snapToken = $pengajuan->snap_token;
        }

        return redirect()->back()->with('snap_token', $snapToken);
    }

    // 🚨 FUNGSI BARU: Cek Status Manual via Tombol Sinkron
    public function sinkron(Request $request)
    {
        $pengajuan = DB::table('pengajuan_balik_namas')->where('id', $request->id_pengajuan)->first();
        if (!$pengajuan->order_id) return redirect()->back()->with('error', 'Belum ada transaksi yang diproses.');

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            $statusMidtrans = Transaction::status($pengajuan->order_id);
            
            if ($statusMidtrans->transaction_status == 'settlement' || $statusMidtrans->transaction_status == 'capture') {
                // EKSEKUSI GANTI NAMA (Sama kayak di Callback)
                $pelangganLama = DB::table('pelanggans')->where('id', $pengajuan->pelanggan_id)->first();
                if ($pelangganLama && Storage::exists($pelangganLama->foto_ktp)) {
                    Storage::delete($pelangganLama->foto_ktp);
                }
                
                DB::table('pelanggans')->where('id', $pengajuan->pelanggan_id)->update([
                    'nama_lengkap' => $pengajuan->nama_baru,
                    'nik' => $pengajuan->nik_baru,
                    'foto_ktp' => $pengajuan->foto_ktp_baru,
                    'updated_at' => now(),
                ]);

                DB::table('pengajuan_balik_namas')->where('id', $pengajuan->id)->update([
                    'status' => 'Selesai',
                    'updated_at' => now(),
                ]);
                return redirect()->back()->with('sukses', 'Mantap! Pembayaran sudah lunas dan data kepemilikan berhasil diubah.');
            
            } elseif (in_array($statusMidtrans->transaction_status, ['expire', 'cancel', 'deny'])) {
                DB::table('pengajuan_balik_namas')->where('id', $pengajuan->id)->update([
                    'snap_token' => null, 'order_id' => null
                ]);
                return redirect()->back()->with('error', 'Waktu pembayaran habis atau dibatalkan. Silakan pilih metode pembayaran baru.');
            } else {
                return redirect()->back()->with('sukses', 'Pembayaran masih menunggu (Pending). Silakan selesaikan di aplikasi M-Banking/E-Wallet Anda.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal terhubung ke Midtrans. Coba lagi nanti.');
        }
    }

    // 🚨 FUNGSI BARU: Batalkan / Ganti Metode Pembayaran
    public function batal(Request $request)
    {
        DB::table('pengajuan_balik_namas')->where('id', $request->id_pengajuan)->update([
            'snap_token' => null, 'order_id' => null
        ]);
        return redirect()->back()->with('sukses', 'Sistem pembayaran sebelumnya dibatalkan. Silakan klik bayar lagi untuk memilih metode baru.');
    }

    // 🚨 FUNGSI BARU: Webhook Callback Midtrans
    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            if (str_starts_with($request->order_id, 'BN-')) {
                if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                    
                    $pengajuan = DB::table('pengajuan_balik_namas')->where('order_id', $request->order_id)->first();
                    
                    if ($pengajuan && $pengajuan->status !== 'Selesai') {
                        // 1. Hapus fisik KTP mantan pelanggan
                        $pelangganLama = DB::table('pelanggans')->where('id', $pengajuan->pelanggan_id)->first();
                        if ($pelangganLama && Storage::exists($pelangganLama->foto_ktp)) {
                            Storage::delete($pelangganLama->foto_ktp);
                        }

                        // 2. UPDATE TABEL UTAMA PELANGGAN (Kunci suksesnya di sini!)
                        DB::table('pelanggans')->where('id', $pengajuan->pelanggan_id)->update([
                            'nama_lengkap' => $pengajuan->nama_baru,
                            'nik' => $pengajuan->nik_baru,
                            'foto_ktp' => $pengajuan->foto_ktp_baru, 
                            'updated_at' => now(),
                        ]);

                        // 3. Update status tiket
                        DB::table('pengajuan_balik_namas')->where('id', $pengajuan->id)->update([
                            'status' => 'Selesai',
                            'updated_at' => now(),
                        ]);
                    }
                } 
                elseif (in_array($request->transaction_status, ['expire', 'cancel', 'deny'])) {
                    // Kalau batal bayar, reset tokennya
                    DB::table('pengajuan_balik_namas')->where('order_id', $request->order_id)->update([
                        'snap_token' => null, 'order_id' => null
                    ]);
                }
            } 
        }
        return response()->json(['message' => 'Callback Balik Nama diterima!']);
    }

    // ==========================================
    // 🏢 SISI ADMIN (VALIDASI BALIK NAMA)
    // ==========================================
    public function indexAdmin(Request $request)
    {
        $tab = $request->query('tab', 'Pending');
        $user = auth()->user();

        $baseQuery = DB::table('pengajuan_balik_namas')
            ->join('pelanggans', 'pengajuan_balik_namas.pelanggan_id', '=', 'pelanggans.id')
            ->select('pengajuan_balik_namas.*', 'pelanggans.nomor_pelanggan', 'pelanggans.kecamatan', 'pelanggans.alamat_lengkap');

        if ($user->role !== 'super_admin') {
            $baseQuery->where('pelanggans.cabang_id', $user->cabang_id);
            if ($user->role === 'petugas_meter') {
                $rayonTugas = DB::table('rayon_petugas')->where('user_id', $user->id)->pluck('rayon_code')->toArray();
                if (empty($rayonTugas)) { $baseQuery->whereNull('pengajuan_balik_namas.id'); } 
                else {
                    $baseQuery->where(function($subQuery) use ($rayonTugas) {
                        foreach ($rayonTugas as $rayon) { $subQuery->orWhere('pelanggans.nomor_pelanggan', 'like', $rayon . '%'); }
                    });
                }
            }
        }

        // 🚨 Hitungan kasta statusnya ditambah!
        $countPending = (clone $baseQuery)->where('pengajuan_balik_namas.status', 'Pending')->count();
        $countMenunggu = (clone $baseQuery)->where('pengajuan_balik_namas.status', 'Menunggu Pembayaran')->count();
        $countSelesai = (clone $baseQuery)->where('pengajuan_balik_namas.status', 'Selesai')->count();
        $countRejected = (clone $baseQuery)->where('pengajuan_balik_namas.status', 'Rejected')->count();

        $pengajuanRaw = $baseQuery->where('pengajuan_balik_namas.status', $tab)->orderBy('pengajuan_balik_namas.created_at', 'desc')->get();

        $groupedPengajuan = $pengajuanRaw->groupBy('kecamatan')->map(function ($items) {
            return $items->groupBy(function ($item) { return substr($item->nomor_pelanggan, 0, 6); })->sortKeys();
        })->sortKeys();

        return view('admin.balik-nama', compact('groupedPengajuan', 'tab', 'countPending', 'countMenunggu', 'countSelesai', 'countRejected'));
    }

    public function approve($id)
    {
        $pengajuan = DB::table('pengajuan_balik_namas')->where('id', $id)->first();
        if (!$pengajuan) return back()->with('error', 'Data tidak ditemukan!');

        // 🚨 Logic berubah: Admin gak nge-update data pelanggan lagi. Cuma naikin status!
        DB::table('pengajuan_balik_namas')->where('id', $id)->update([
            'status' => 'Menunggu Pembayaran',
            'updated_at' => now(),
        ]);

        return back()->with('sukses', 'Berhasil! Data Valid. Silakan tunggu warga melakukan pembayaran Rp 27.500.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['alasan_penolakan' => 'required|string']);
        DB::table('pengajuan_balik_namas')->where('id', $id)->update([
            'status' => 'Rejected', 'alasan_penolakan' => $request->alasan_penolakan, 'updated_at' => now(),
        ]);
        return back()->with('sukses', 'Pengajuan Balik Nama berhasil ditolak.');
    }
}