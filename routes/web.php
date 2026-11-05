<?php

use App\Http\Controllers\BalikNamaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PelangganController; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TagihanController;
use App\Http\Middleware\RoleMiddleware;

// =========================================================
// AREA PUBLIK (PELANGGAN) - BEBAS DIAKSES TANPA LOGIN
// =========================================================
Route::get('/', function () {
            $berita = \App\Models\Berita::orderBy('created_at', 'desc')->take(3)->get();
            return view('Dashboard', compact('berita')); 
        })->name('pelanggan.dashboard');

        // Halaman-halaman Informasi
        Route::get('/pasang-baru', function () { return view('pasang-baru'); });
        Route::post('/pasang-baru', [PelangganController::class, 'store'])->name('pelanggan.simpan');
        Route::get('/pengaduan', function () { return view('pengaduan'); })->name('pengaduan.index');
        Route::post('/pengaduan/kirim', [PengaduanController::class, 'store'])->name('pengaduan.store'); 
        Route::get('/profil', function () { return view('profil'); });
        Route::get('/struktur-organisasi', function () { return view('struktur-organisasi'); });
        Route::get('/prestasi', function () { return view('prestasi'); });
        Route::get('/dewan-pengawas', function () { return view('dewan-pengawas'); });
        Route::get('/manajemen', function () { return view('manajemen'); });
        Route::get('/edukasi-tips', function () { return view('edukasi-tips'); });
        Route::get('/faq', function () { return view('faq'); });
        Route::get('/kontak', function () { return view('kontak'); });
        
        // Fitur Pengajuan Balik Nama (Publik)
        Route::get('/balik-nama', [BalikNamaController::class, 'indexPublik'])->name('balik-nama.index');
        Route::post('/balik-nama/simpan', [BalikNamaController::class, 'storePengajuan'])->name('balik-nama.store');
        Route::post('/balik-nama/bayar', [BalikNamaController::class, 'bayar'])->name('balik-nama.bayar');
        Route::post('/balik-nama/sinkron', [BalikNamaController::class, 'sinkron'])->name('balik-nama.sinkron');
        Route::post('/balik-nama/batal', [BalikNamaController::class, 'batal'])->name('balik-nama.batal');
        Route::post('/midtrans/callback-bn', [BalikNamaController::class, 'callback'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        
        // NAH INI RUTE TARIF MINUM PELANGGAN YANG BENER (Narik dari DB)
        Route::get('/tarif-minum', function () { 
            $tarifs = \App\Models\TarifAir::all(); 
            return view('tarif-minum', compact('tarifs')); 
        });

        Route::get('/prosedur-pasang', function () { return view('prosedur-pasang'); });
        Route::get('/wilayah-pelayanan', function () { return view('wilayah-pelayanan'); });
        Route::get('/berita', [BeritaController::class, 'beritaPelanggan'])->name('berita.pelanggan');
        Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
        Route::get('/ppid', [App\Http\Controllers\PpidController::class, 'indexPublic'])->name('ppid.index');

        // Fitur Tagihan Pelanggan
        Route::get('/cek-tagihan', [TagihanController::class, 'cekTagihan'])->name('cek-tagihan.index');
        Route::get('/cek-tagihan/hasil', [TagihanController::class, 'prosesCekTagihan'])->name('cek-tagihan.proses');
        Route::post('/cek-tagihan/bayar', [TagihanController::class, 'bayar'])->name('cek-tagihan.bayar');
        Route::post('/cek-tagihan/sinkron', [TagihanController::class, 'sinkron'])->name('cek-tagihan.sinkron');
        Route::post('/cek-tagihan/batal', [TagihanController::class, 'batal'])->name('cek-tagihan.batal');
        Route::get('/cek-tagihan/cetak/{id}', [TagihanController::class, 'cetakKwitansi'])->name('cek-tagihan.cetak');

        // Fitur Cek Status Pemasangan Baru (Berdasarkan NIK)
        Route::get('/cek-pemasangan', [PelangganController::class, 'cekStatus'])->name('cek-pemasangan.index');
        Route::post('/cek-pemasangan/sinkron', [PelangganController::class, 'sinkron'])->name('cek-pemasangan.sinkron');
        Route::post('/cek-pemasangan/batal', [PelangganController::class, 'batal'])->name('cek-pemasangan.batal');
        
        // Webhook Midtrans Khusus Pasang Baru
        Route::post('/midtrans/callback-rab', [PelangganController::class, 'callbackRab'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        
        // Webhook Midtrans
        Route::post('/midtrans/callback', [TagihanController::class, 'callback'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

        // Autentikasi (Login/Logout)
        Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
        Route::post('/login', [AuthController::class, 'authenticate']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =========================================================
// AREA PRIVAT (ADMIN PDAM) - WAJIB LOGIN!
// =========================================================
    Route::middleware(['auth'])->group(function () {

    Route::get('/dokumen-rahasia/{jenis}/{nama_file}', [\App\Http\Controllers\DokumenController::class, 'lihatFile'])
        ->where('nama_file', '.*')
        ->name('dokumen.rahasia');

    Route::get('/dashboard', function () {
        return redirect()->route('admin.pelanggan');
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        
        // ==========================================
        // 1. ZONA BACA BERSAMA (Bisa diakses semua pegawai)
        // ==========================================
        Route::get('/pelanggan', [AdminController::class, 'indexPelanggan'])->name('pelanggan');

        // ==========================================
        // 2. ZONA KASIR & SUPER ADMIN
        // ==========================================
        Route::middleware([RoleMiddleware::class . ':super_admin,kasir'])->group(function () {
            // Pelunasan
            Route::post('/pelanggan/{id}/lunas-manual', [AdminController::class, 'lunasManual'])->name('pelanggan.lunas_manual');
        });

        // ==========================================
        // 3. ZONA TARIF & TAGIHAN (KASIR, METER, SUPER ADMIN)
        // ==========================================
        Route::middleware([RoleMiddleware::class . ':super_admin,kasir,petugas_meter'])->group(function () {
            // Tagihan
            Route::get('/data-tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
            Route::put('/tagihan/{id}/lunas', [TagihanController::class, 'lunas'])->name('tagihan.lunas');
            Route::get('/tagihan/{id}/edit', [TagihanController::class, 'edit'])->name('tagihan.edit');
            Route::put('/tagihan/{id}', [TagihanController::class, 'update'])->name('tagihan.update');

            // Tarif Air 
            Route::get('/tarif', [\App\Http\Controllers\Admin\TarifAirController::class, 'index'])->name('tarif.index');
            Route::get('/tarif/tambah', [\App\Http\Controllers\Admin\TarifAirController::class, 'create'])->name('tarif.create');
            Route::post('/tarif', [\App\Http\Controllers\Admin\TarifAirController::class, 'store'])->name('tarif.store');
            Route::get('/tarif/{id}/edit', [\App\Http\Controllers\Admin\TarifAirController::class, 'edit'])->name('tarif.edit');
            Route::put('/tarif/{id}', [\App\Http\Controllers\Admin\TarifAirController::class, 'update'])->name('tarif.update');
            Route::delete('/tarif/{id}', [\App\Http\Controllers\Admin\TarifAirController::class, 'destroy'])->name('tarif.destroy');
        });

        // ==========================================
        // 4. ZONA PENGADUAN (METER & PEMASANGAN & SUPER ADMIN)
        // ==========================================
        // (Rute pengaduan yang tadinya tabrakan, digabung di sini)
        Route::middleware([RoleMiddleware::class . ':super_admin,petugas_meter,petugas_pemasangan'])->group(function () {
            Route::get('/pengaduan', [PengaduanController::class, 'indexAdmin'])->name('pengaduan.index');
            Route::put('/pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');
        });

        // ==========================================
        // 5. ZONA PETUGAS METER & SUPER ADMIN
        // ==========================================
        Route::middleware([RoleMiddleware::class . ':super_admin,petugas_meter'])->group(function () {
            Route::get('/pencatatan-meter', [TagihanController::class, 'create'])->name('tagihan.create');
            Route::post('/pencatatan-meter', [TagihanController::class, 'store'])->name('tagihan.store');
            Route::get('/pencatatan-meter/get-meter-awal/{id}', [TagihanController::class, 'getMeterAwal'])->name('tagihan.get_meter_awal');
        });

        // ==========================================
        // 6. ZONA PETUGAS PEMASANGAN, KEPALA CABANG & SUPER ADMIN
        // ==========================================
        Route::middleware([RoleMiddleware::class . ':super_admin,kepala_cabang,petugas_pemasangan'])->group(function () {
            Route::post('/pelanggan/{id}/input-rab', [AdminController::class, 'inputRab'])->name('pelanggan.input_rab');
            
            // Validasi Balik Nama
            Route::get('/validasi-balik-nama', [BalikNamaController::class, 'indexAdmin'])->name('balik-nama');
            Route::post('/validasi-balik-nama/{id}/approve', [BalikNamaController::class, 'approve'])->name('balik-nama.approve');
            Route::post('/validasi-balik-nama/{id}/reject', [BalikNamaController::class, 'reject'])->name('balik-nama.reject');
        });

        // ==========================================
        // 7. ZONA KEPALA CABANG & SUPER ADMIN
        // ==========================================
        Route::middleware([RoleMiddleware::class . ':super_admin,kepala_cabang'])->group(function () {
            // Aksi Eksekusi Pelanggan
            Route::post('/pelanggan/{id}/approve', [AdminController::class, 'approvePelanggan'])->name('pelanggan.approve');
            Route::post('/pelanggan/{id}/update-nomor', [AdminController::class, 'updateNomor'])->name('pelanggan.update_nomor');
            Route::post('/pelanggan/{id}/tolak', [AdminController::class, 'tolakPengajuan'])->name('pelanggan.tolak');
            Route::delete('/pelanggan/{id}', [AdminController::class, 'destroyPelanggan'])->name('pelanggan.destroy');
            
            // Kelola Admin (Index aja biar Kacab bisa liat daftar pegawai)
            Route::get('/kelola-admin', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        });

        // ==========================================
        // 8. ZONA ADMIN BERITA & SUPER ADMIN
        // ==========================================
        Route::middleware([RoleMiddleware::class . ':super_admin,admin_berita'])->group(function () {
            // --- MANAJEMEN BERITA ---
            Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
            Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
            Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
            
            // --- MANAJEMEN PROFIL & ORGANISASI ---
            Route::get('/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'index'])->name('profil.index');
            Route::get('/profil/tambah', [\App\Http\Controllers\Admin\ProfilController::class, 'create'])->name('profil.create');
            Route::post('/profil/simpan', [\App\Http\Controllers\Admin\ProfilController::class, 'store'])->name('profil.store');
            Route::delete('/profil/{id}/hapus', [\App\Http\Controllers\Admin\ProfilController::class, 'destroy'])->name('profil.destroy');
            
            // --- MANAJEMEN STRUKTUR & PRESTASI (GAMBAR ONLY) ---
            Route::get('/galeri-profil', [\App\Http\Controllers\Admin\GaleriProfilController::class, 'index'])->name('galeri_profil.index');
            Route::get('/galeri-profil/tambah', [\App\Http\Controllers\Admin\GaleriProfilController::class, 'create'])->name('galeri_profil.create');
            Route::post('/galeri-profil/simpan', [\App\Http\Controllers\Admin\GaleriProfilController::class, 'store'])->name('galeri_profil.store');
            Route::delete('/galeri-profil/{id}/hapus', [\App\Http\Controllers\Admin\GaleriProfilController::class, 'destroy'])->name('galeri_profil.destroy');
            
            // --- MANAJEMEN PRESTASI ---
            Route::get('/prestasi', [\App\Http\Controllers\Admin\PrestasiController::class, 'index'])->name('prestasi.index');
            Route::get('/prestasi/tambah', [\App\Http\Controllers\Admin\PrestasiController::class, 'create'])->name('prestasi.create');
            Route::post('/prestasi/simpan', [\App\Http\Controllers\Admin\PrestasiController::class, 'store'])->name('prestasi.store');
            Route::delete('/prestasi/{id}/hapus', [\App\Http\Controllers\Admin\PrestasiController::class, 'destroy'])->name('prestasi.destroy');
            
            // --- MANAJEMEN PPID ---
            Route::get('/ppid', [App\Http\Controllers\PpidController::class, 'indexAdmin'])->name('ppid.index');
            Route::post('/ppid', [App\Http\Controllers\PpidController::class, 'store'])->name('ppid.store');
            Route::delete('/ppid/{id}', [App\Http\Controllers\PpidController::class, 'destroy'])->name('ppid.destroy');
        });

        // ==========================================
        // 9. ZONA KHUSUS SUPER ADMIN
        // ==========================================
        Route::middleware([RoleMiddleware::class . ':super_admin'])->group(function () {
            Route::post('/kelola-admin', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
            Route::delete('/kelola-admin/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
            Route::post('/users/{id}/update-rayon', [\App\Http\Controllers\UserController::class, 'updateRayon'])->name('users.update_rayon');
            Route::put('/users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        });

    }); 
});