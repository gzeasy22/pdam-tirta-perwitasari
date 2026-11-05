<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB; 

class UserController extends Controller
{
    // 1. Nampilin Tabel Pegawai & Data Rayon
   public function index()
    {
        $userLogin = auth()->user();

        // 🚨 LOGIKA FILTER CABANG (DIOPTIMASI DENGAN PAGINATION) 🚨
        if ($userLogin->role === 'super_admin') {
            // Superadmin lihat semua pegawai, KECUALI akun dia sendiri
            $users = User::where('id', '!=', $userLogin->id)->paginate(20);
        } else {
            // Kacab cuma dikasih lihat pasukannya sendiri, KECUALI akun dia sendiri
            $users = User::where('cabang_id', $userLogin->cabang_id)
                         ->where('id', '!=', $userLogin->id)
                         ->paginate(20);
        }

        // LOGIKA CERDAS V4: Join ke tabel cabangs buat ambil ID
        $dataPelanggan = DB::table('pelanggans')
                            ->join('cabangs', 'pelanggans.cabang_id', '=', 'cabangs.id')
                            ->whereNotNull('pelanggans.nomor_pelanggan')
                            ->selectRaw('cabangs.id as cabang_id, cabangs.nama_cabang, SUBSTRING(pelanggans.nomor_pelanggan, 1, 6) as kode')
                            ->distinct()
                            ->get();

        $rayonPerCabang = [];
        $semuaRayonTerdaftar = [];

        foreach ($dataPelanggan as $data) {
            $cabangId = $data->cabang_id;
            $namaCabang = strtoupper(str_ireplace(['kec. ', 'kecamatan '], '', $data->nama_cabang));
            
            if (!in_array($data->kode, $semuaRayonTerdaftar)) {
                if (!isset($rayonPerCabang[$cabangId])) {
                    $rayonPerCabang[$cabangId] = ['nama' => $namaCabang, 'rayons' => []];
                }
                $rayonPerCabang[$cabangId]['rayons'][] = $data->kode;
                $semuaRayonTerdaftar[] = $data->kode; 
            }
        }

        $rayonManual = DB::table('rayon_petugas')->select('rayon_code')->distinct()->pluck('rayon_code')->toArray();

        foreach ($rayonManual as $rm) {
            if (!in_array($rm, $semuaRayonTerdaftar)) {
                if (!isset($rayonPerCabang[0])) { 
                    $rayonPerCabang[0] = ['nama' => 'INPUT MANUAL / LAINNYA', 'rayons' => []];
                }
                $rayonPerCabang[0]['rayons'][] = $rm;
            }
        }

        $userRayons = DB::table('rayon_petugas')->get()->groupBy('user_id');

        return view('admin.users.index', compact('users', 'rayonPerCabang', 'userRayons'));
    }

    // 2. Proses Simpan Pegawai Baru
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'super_admin') abort(403);

        $request->validate([
            'nik_karyawan'  => 'nullable|string',
            'name'          => 'required',
            'tempat_lahir'  => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'username'      => 'required|string|unique:users,username',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6',
            // 🚨 VALIDASI ROLE DITAMBAHIN PETUGAS PEMASANGAN 🚨
            'role'          => 'required|in:super_admin,kepala_cabang,kasir,petugas_meter,admin_berita,petugas_pemasangan',
            'cabang_id'     => 'nullable|exists:cabangs,id'
        ]);

        User::create([
            'nik_karyawan'  => $request->nik_karyawan,
            'name'          => $request->name,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'username'      => $request->username,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
            'role'          => $request->role,
            'cabang_id'     => $request->cabang_id, 
        ]);

        return back()->with('success', 'Akun pegawai berhasil ditambahkan secara komplit!');
    }

    // 3. Proses Edit / Mutasi Pegawai
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'super_admin') abort(403);

        $user = User::findOrFail($id);

        $request->validate([
            'name'          => 'required',
            'username'      => 'required|string|unique:users,username,'.$id,
            'email'         => 'required|email|unique:users,email,'.$id,
            // 🚨 VALIDASI ROLE DITAMBAHIN PETUGAS PEMASANGAN 🚨
            'role'          => 'required|in:super_admin,kepala_cabang,kasir,petugas_meter,admin_berita,petugas_pemasangan',
            'cabang_id'     => 'nullable|exists:cabangs,id'
        ]);

        $oldCabang = $user->cabang_id;
        $newCabang = $request->cabang_id;

        if ($request->role === 'super_admin') {
            $newCabang = null;
        }

        $user->name = $request->name;
        $user->nik_karyawan = $request->nik_karyawan;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->cabang_id = $newCabang;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        $pesanEkstra = '';

        if ($user->role === 'petugas_meter' && $oldCabang != $newCabang) {
            DB::table('rayon_petugas')->where('user_id', $user->id)->delete();

            $pesanEkstra = ' Karena petugas dipindah cabang, area tugas lamanya telah di-reset. Jangan lupa atur Rayon barunya!';
        }

        return back()->with('success', 'Data pegawai berhasil diupdate!' . $pesanEkstra);
    }

    // 4. Proses Hapus Akun Pegawai
    public function destroy($id)
    {
        if (auth()->user()->role !== 'super_admin') abort(403);

        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Lu gak bisa ngehapus akun lu sendiri bre!');
        }

        $user->delete();
        return back()->with('success', 'Akun berhasil dihapus!');
    }

    // 5. Proses Update Penugasan Rayon
    public function updateRayon(Request $request, $id)
    {
        if (auth()->user()->role !== 'super_admin') abort(403);

        $rayons = $request->rayons ?? [];

        DB::table('rayon_petugas')->where('user_id', $id)->delete();

        $data = [];

        foreach($rayons as $r) {
            $data[] = [
                'user_id' => $id,
                'rayon_code' => $r,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if(count($data) > 0) {
            DB::table('rayon_petugas')->insert($data);
        }

        if ($request->filled('rayon_baru')) {
            DB::table('rayon_petugas')->insert([
                'user_id' => $id,
                'rayon_code' => $request->rayon_baru,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Tugas Area (Rayon) berhasil diperbarui untuk petugas tersebut!');
    }
}