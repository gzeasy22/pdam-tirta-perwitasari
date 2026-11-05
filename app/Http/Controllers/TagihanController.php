<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Transaction; 
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pelanggan;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // 1. Panggil data tagihan HANYA JIKA pelanggannya masih ada di sistem
        $query = Tagihan::with('pelanggan')->has('pelanggan')->latest();

        // 🚨 2. SATPAM CABANG: Kalau bukan Super Admin, filter sesuai cabangnya!
        if ($user->role !== 'super_admin' && $user->cabang_id) {
            $query->whereHas('pelanggan', function($q) use ($user) {
                $q->where('cabang_id', $user->cabang_id);
            });
        }

        // Ambil semua data tagihan tanpa di-paginate dulu biar gampang difilter di Tab
        $semuaTagihan = $query->get();

        // 3. Pisahkan jadi kolam-kolam status
        $belumBayar = $semuaTagihan->filter(function($item) {
            return in_array(strtolower(trim($item->status)), ['belum bayar', 'pending']);
        });

        $sudahLunas = $semuaTagihan->filter(function($item) {
            return strtolower(trim($item->status)) == 'lunas';
        });

        return view('admin.tagihan.index', compact('semuaTagihan', 'belumBayar', 'sudahLunas'));
    }

  public function create(Request $request)
    {
        $user = auth()->user();
        
        // 1. Dapatkan bulan dan tahun saat ini (Format: YYYY-MM)
        $bulanSekarang = date('Y-m');

        // 2. TANGKAP GPS DARI HP PETUGAS (Dikirim via URL dari Frontend Javascript)
        $petugasLat = $request->lat; 
        $petugasLng = $request->lng;

        // 3. LOGIKA HAVERSINE DINAMIS (Matematika Bumi Bulat)
        if ($petugasLat != null && $petugasLng != null) {
            $query = Pelanggan::selectRaw(
                "pelanggans.*, 
                ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS jarak_km",
                [$petugasLat, $petugasLng, $petugasLat]
            )
            ->where('status', 'Approved')
            ->orderBy('jarak_km', 'ASC');
        } else {
            $query = Pelanggan::selectRaw("pelanggans.*, NULL as jarak_km")
            ->where('status', 'Approved')
            ->orderBy('nama_lengkap', 'ASC');
        }

        // FILTER LAPIS 1: Kunci sesuai Cabang (Khusus selain Super Admin)
        if ($user->role !== 'super_admin' && $user->cabang_id) {
            $query->where('cabang_id', $user->cabang_id);
        }

        // 🚨 FILTER LAPIS 2: Kunci Area Sesuai Penugasan (Khusus Petugas Meter)
        if ($user->role === 'petugas_meter') {
            // Cek ke database, si petugas ini ditugasin ke rayon mana aja?
            $rayonPetugas = \Illuminate\Support\Facades\DB::table('rayon_petugas')
                                ->where('user_id', $user->id)
                                ->pluck('rayon_code')
                                ->toArray();

            if (empty($rayonPetugas)) {
                // Kalau Superadmin belum ngasih area sama sekali, blokir datanya! (ID = 0)
                $query->where('id', 0); 
            } else {
                // Cari warga yang 6 digit awal nomor pelanggannya cocok sama area tugas
                $query->where(function($q) use ($rayonPetugas) {
                    foreach($rayonPetugas as $rayon) {
                        $q->orWhere('nomor_pelanggan', 'LIKE', $rayon . '%');
                    }
                });
            }
        }

        // Ambil semua data pelanggan yang sudah melewati filter ketat
        $semuaPelanggan = $query->get();

        // 4. Cari tau ID pelanggan mana saja yang SUDAH ditagih (dicatat) bulan ini
        $tagihanBulanIni = \App\Models\Tagihan::where('bulan_tagihan', $bulanSekarang)->get();
        $pelangganSudahDicatatIds = $tagihanBulanIni->pluck('pelanggan_id')->toArray();

        // 5. Pisahkan jadi 2 kolam
        $belumDicatat = $semuaPelanggan->whereNotIn('id', $pelangganSudahDicatatIds);
        $sudahDicatat = $semuaPelanggan->whereIn('id', $pelangganSudahDicatatIds);
         
        // 🚨 LOGIKA BARU POIN 3: Kelompokkan data per Rayon (6 digit awal nomor pelanggan)
        $belumDicatatPerRayon = $belumDicatat->groupBy(function($item) {
            return substr($item->nomor_pelanggan, 0, 6);
        })->sortKeys();

        $sudahDicatatPerRayon = $sudahDicatat->groupBy(function($item) {
            return substr($item->nomor_pelanggan, 0, 6);
        })->sortKeys();

        $semuaPelangganPerRayon = $semuaPelanggan->groupBy(function($item) {
            return substr($item->nomor_pelanggan, 0, 6);
        })->sortKeys();

        // Lempar variabel baru yang udah dikelompokkan ke View
        return view('admin.tagihan.create', compact('semuaPelanggan', 'belumDicatat', 'sudahDicatat', 'belumDicatatPerRayon', 'sudahDicatatPerRayon', 'semuaPelangganPerRayon', 'bulanSekarang', 'tagihanBulanIni', 'petugasLat', 'petugasLng'));
    }

    private function hitungTagihan($pemakaianMurni, $aturanTarif, $ukuranMeter)
    {
        $pemakaianHitung = max($pemakaianMurni, $aturanTarif->min_pakai);

        if ($pemakaianHitung <= 10) {
            $biayaAir = $pemakaianHitung * $aturanTarif->tarif_blok_1;
        } elseif ($pemakaianHitung <= 20) {
            $biayaAir = (10 * $aturanTarif->tarif_blok_1) + (($pemakaianHitung - 10) * $aturanTarif->tarif_blok_2);
        } else {
            $biayaAir = (10 * $aturanTarif->tarif_blok_1) + (10 * $aturanTarif->tarif_blok_2) + (($pemakaianHitung - 20) * $aturanTarif->tarif_blok_3);
        }

        $ukuranMeter = str_replace(',', '.', $ukuranMeter);
        
        $daftarHargaMeter = [
            '0.5'  => 6000, '0.75' => 9350, '1'    => 12850, '1.5'  => 30350,
            '2'    => 47250, '3'    => 68250, '10'   => 106150,
        ];

        if (in_array($ukuranMeter, $daftarHargaMeter)) {
            $biayaPemeliharaanMeter = (int)$ukuranMeter;
        } else {
            $biayaPemeliharaanMeter = $daftarHargaMeter[$ukuranMeter] ?? 6000;
        }

        $totalTagihan = $biayaAir + 2500 + $biayaPemeliharaanMeter;
        if ($totalTagihan > 5000000) { $totalTagihan += 10000; }

        return $totalTagihan;
    }

    public function store(Request $request)
    {
        // 1. Validasi fotonya harus masuk dan berwujud gambar
        $request->validate([
            'pelanggan_id'  => 'required',
            'bulan_tagihan' => 'required|string',
            'meteran_awal'  => 'required|numeric|min:0',
            'meteran_akhir' => 'required|numeric|gte:meteran_awal',
            'foto_meter'    => 'required|image|mimes:jpeg,png,jpg|max:2048', // MAX 2MB
        ]);

        $pelanggan = Pelanggan::findOrFail($request->pelanggan_id);
        if (auth()->user()->role !== 'super_admin' && auth()->user()->cabang_id != $pelanggan->cabang_id) {
        return redirect()->back()->with('error', '🛑 Akses Ditolak! Anda tidak diizinkan mencatat meteran warga dari luar wilayah cabang Anda.');
        }
        $meteranAwal = $request->meteran_awal;
        $meteranAkhir = $request->meteran_akhir;
        $pemakaianMurni = $meteranAkhir - $meteranAwal;

        $aturanTarif = \App\Models\TarifAir::where('sub_golongan', $pelanggan->sub_golongan)->first();
        if (!$aturanTarif) {
            return redirect()->back()->with('error', 'Gagal hitung! Tarif untuk golongan ' . $pelanggan->sub_golongan . ' belum diatur di sistem.');
        }

        $ukuranPipa = $pelanggan->ukuran_meter ?? '0.5';
        $totalTagihan = $this->hitungTagihan($pemakaianMurni, $aturanTarif, $ukuranPipa);
        if ($totalTagihan > 5000000) { $totalTagihan += 10000; }

        // 2. Simpan Foto Fisik ke Lemari Rahasia (Folder Storage)
        $fotoName = time() . '_METER_' . $request->file('foto_meter')->getClientOriginalName();
        $request->file('foto_meter')->storeAs('rahasia/berkas_meter', $fotoName);

        // 3. Catat di tabel
        Tagihan::create([
            'pelanggan_id'  => $pelanggan->id,
            'bulan_tagihan' => $request->bulan_tagihan,
            'meteran_awal'  => $meteranAwal,
            'meteran_akhir' => $meteranAkhir,
            'pemakaian'     => $pemakaianMurni,
            'total_tagihan' => $totalTagihan,
            'status'        => 'Belum Bayar',
            'foto_meter'    => $fotoName, // <- Data foto masuk ke laci database
        ]);

        return redirect()->route('admin.tagihan.create')->with('success', 'Berhasil! Tagihan atas nama ' . $pelanggan->nama_lengkap . ' dengan total Rp ' . number_format($totalTagihan, 0, ',', '.') . ' sudah dihitung dan disimpan beserta foto meteran.');
    }

    public function lunas($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update(['status' => 'Lunas']);
        return redirect()->route('admin.tagihan.index')->with('success', 'Mantap! Tagihan atas nama ' . ($tagihan->pelanggan->nama_lengkap ?? 'Pelanggan') . ' berhasil dilunasi.');
    }

    public function edit($id)
    {
        $tagihan = Tagihan::with('pelanggan')->findOrFail($id);
        return view('admin.tagihan.edit', compact('tagihan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi opsional buat foto_meter, karena admin bisa edit angka doang tanpa ganti foto
        $request->validate([
            'bulan_tagihan' => 'required|string',
            'meteran_awal'  => 'required|numeric|min:0',
            'meteran_akhir' => 'required|numeric|gte:meteran_awal',
            'foto_meter'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $tagihan = \App\Models\Tagihan::findOrFail($id);
        $pelanggan = \App\Models\Pelanggan::findOrFail($tagihan->pelanggan_id);
        
        $meteranAwal = $request->meteran_awal;
        $meteranAkhir = $request->meteran_akhir;
        $pemakaianMurni = $meteranAkhir - $meteranAwal;

        $aturanTarif = \App\Models\TarifAir::where('sub_golongan', $pelanggan->sub_golongan)->first();
        if (!$aturanTarif) {
            return redirect()->back()->with('error', 'Gagal hitung! Tarif untuk golongan ' . $pelanggan->sub_golongan . ' belum diatur di sistem.');
        }

        $ukuranPipa = $pelanggan->ukuran_meter ?? '0.5';
        $totalTagihan = $this->hitungTagihan($pemakaianMurni, $aturanTarif, $ukuranPipa);
        if ($totalTagihan > 5000000) { $totalTagihan += 10000; }

        $updateData = [
            'bulan_tagihan' => $request->bulan_tagihan,
            'meteran_awal'  => $meteranAwal,
            'meteran_akhir' => $meteranAkhir,
            'pemakaian'     => $pemakaianMurni,
            'total_tagihan' => $totalTagihan,
        ];

        // Cek kalau admin ternyata masukin file foto baru pas di form edit
        if ($request->hasFile('foto_meter')) {
            $fotoName = time() . '_METER_' . $request->file('foto_meter')->getClientOriginalName();
            $request->file('foto_meter')->storeAs('rahasia/berkas_meter', $fotoName);
            $updateData['foto_meter'] = $fotoName; // Timpa foto lama dengan yang baru
        }

        $tagihan->update($updateData);
        
        return redirect()->route('admin.tagihan.create')->with('success', 'Mantap! Tagihan berhasil dihitung ulang dan diedit.');
    }

    public function bayar(Request $request)
    {
        $tagihan = \App\Models\Tagihan::with('pelanggan')->findOrFail($request->id_tagihan);
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        if (!$tagihan->snap_token) {
            $biaya_admin = 3000;
            
            // 🚨 --- LOGIKA DENDA KETERLAMBATAN OTOMATIS --- 🚨
            // Kita set tenggat waktunya ke tanggal 20, jam 23:59:59 di bulan tagihan tersebut
            $tenggat_waktu = \Carbon\Carbon::parse($tagihan->bulan_tagihan)->setDay(20)->endOfDay();
            $denda = 0;
            
            // Cek apakah waktu saat tombol 'Bayar' diklik sudah melewati tenggat waktu
            if (now()->greaterThan($tenggat_waktu)) {
                $denda = 10000; // Kena denda flat Rp 10.000
            }
            // ------------------------------------------------

            // Total yang dibayar ke Midtrans ditambah denda (kalau ada)
            $total_bayar = $tagihan->total_tagihan + $biaya_admin + $denda;
            $order_id = 'PDAM-' . $tagihan->id . '-' . time();
            
            // Susun rincian item untuk struk / nota digital di layar Midtrans
            $item_details = [
                [
                    'id' => 'AIR-' . \Carbon\Carbon::parse($tagihan->bulan_tagihan)->format('mY'),
                    'price' => $tagihan->total_tagihan,
                    'quantity' => 1,
                    'name' => 'Tagihan Air Bln ' . \Carbon\Carbon::parse($tagihan->bulan_tagihan)->format('M Y')
                ],
                [
                    'id' => 'ADMIN-FEE',
                    'price' => $biaya_admin,
                    'quantity' => 1,
                    'name' => 'Biaya Admin / Layanan'
                ]
            ];

            // Kalau kena denda, selipin dendanya ke dalam nota Midtrans!
            if ($denda > 0) {
                $item_details[] = [
                    'id' => 'DENDA-TELAT',
                    'price' => $denda,
                    'quantity' => 1,
                    'name' => 'Denda Lewat Tgl 20'
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => $total_bayar,
                ],
                'item_details' => $item_details,
                'customer_details' => [
                    'first_name' => $tagihan->pelanggan->nama_lengkap,
                    'phone' => $tagihan->pelanggan->no_hp ?? '08111222333',
                    'address' => $tagihan->pelanggan->alamat,
                ]
            ];
            
            $snapToken = Snap::getSnapToken($params);

            $tagihan->snap_token = $snapToken;
            $tagihan->order_id = $order_id;
            $tagihan->status = 'Pending';
            $tagihan->save();
        }

        return redirect()->back()->with('snap_token', $tagihan->snap_token);
    }

    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            if (str_starts_with($request->order_id, 'RAB-')) {
                if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                    $orderIdParts = explode('-', $request->order_id);
                    $pelangganId = $orderIdParts[1];

                    \App\Models\Pelanggan::where('id', $pelangganId)->update([
                        'status_pembayaran_pasang' => 'Lunas',
                        'updated_at' => now(),
                    ]);
                }
            } 
            else {
                $tagihan = \App\Models\Tagihan::where('order_id', $request->order_id)->first();
                if ($tagihan) {
                    if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                        $tagihan->status = 'Lunas';
                        $tagihan->metode_pembayaran = $request->payment_type;
                    } 
                    elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                        $tagihan->status = 'Belum Bayar';
                        $tagihan->snap_token = null;
                        $tagihan->order_id = null;
                    }
                    $tagihan->save();
                }
            }
        }
        return response()->json(['message' => 'Callback 2 Pintu diterima bro!']);
    }

    public function sinkron(Request $request)
    {
        $tagihan = \App\Models\Tagihan::findOrFail($request->id_tagihan);
        if (!$tagihan->order_id) { return redirect()->back()->with('error', 'Tagihan belum diproses ke pembayaran.'); }

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            $statusMidtrans = Transaction::status($tagihan->order_id);
            if ($statusMidtrans->transaction_status == 'settlement' || $statusMidtrans->transaction_status == 'capture') {
                $tagihan->status = 'Lunas';
                $tagihan->metode_pembayaran = $statusMidtrans->payment_type ?? 'QRIS/Transfer';
                $pesan = 'Mantap! Pembayaran sudah Lunas.';
            } elseif ($statusMidtrans->transaction_status == 'expire' || $statusMidtrans->transaction_status == 'cancel') {
                $tagihan->status = 'Belum Bayar';
                $tagihan->snap_token = null;
                $tagihan->order_id = null;
                $pesan = 'Waktu pembayaran habis atau dibatalkan. Silakan buat ulang.';
            } else {
                $pesan = 'Pembayaran masih menunggu (Pending).';
            }
            $tagihan->save();
            return redirect()->back()->with('success', $pesan);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal terhubung ke Midtrans. Coba lagi nanti.');
        }
    }

    public function batal(Request $request)
    {
        $tagihan = \App\Models\Tagihan::findOrFail($request->id_tagihan);
        if ($tagihan->status == 'Pending') {
            $tagihan->status = 'Belum Bayar';
            $tagihan->snap_token = null;
            $tagihan->order_id = null;
            $tagihan->save();
            return redirect()->back()->with('success', 'Pembayaran sebelumnya dibatalkan. Silakan pilih metode pembayaran baru.');
        }
        return redirect()->back()->with('error', 'Tagihan ini tidak bisa dibatalkan.');
    }

    public function cetakKwitansi($id)
    {
        $tagihan = \App\Models\Tagihan::with('pelanggan')->findOrFail($id);
        if (strtolower(trim($tagihan->status)) != 'lunas') { return redirect()->back()->with('error', 'Kwitansi hanya bisa dicetak untuk tagihan yang sudah Lunas.'); }

        $pdf = Pdf::loadView('cek-tagihan.kwitansi', compact('tagihan'));
        $nama_file = 'Kwitansi_PDAM_' . $tagihan->pelanggan->nomor_pelanggan . '_' . \Carbon\Carbon::parse($tagihan->bulan_tagihan)->format('m-Y') . '.pdf';
        return $pdf->stream($nama_file);
    }

    public function cekTagihan()
    {
        return view('cek-tagihan.index');
    }

    public function prosesCekTagihan(Request $request)
    {
        $request->validate(['nomor_pelanggan' => 'required']);
        $pelanggan = \App\Models\Pelanggan::where('nomor_pelanggan', $request->nomor_pelanggan)->first();
        if (!$pelanggan) { return redirect()->back()->with('error', 'Waduh, Nomor Pelanggan tidak ditemukan!'); }

        $tagihan_aktif = \App\Models\Tagihan::where('pelanggan_id', $pelanggan->id)
                            ->whereIn('status', ['Belum Bayar', 'Pending'])
                            ->latest()->get();

        $riwayat_lunas = \App\Models\Tagihan::where('pelanggan_id', $pelanggan->id)
                            ->where('status', 'Lunas')
                            ->latest()->get();

        return view('cek-tagihan.hasil', compact('pelanggan', 'tagihan_aktif', 'riwayat_lunas'));
    }

    public function getMeterAwal($id)
    {
        $tagihanTerakhir = \App\Models\Tagihan::where('pelanggan_id', $id)->orderBy('created_at', 'desc')->first();
        return response()->json([
            'meteran_awal' => $tagihanTerakhir ? $tagihanTerakhir->meteran_akhir : 0
        ]);
    }
}