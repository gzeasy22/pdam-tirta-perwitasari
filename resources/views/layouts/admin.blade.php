<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - PDAM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* ================= RESET & DASAR ================= */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; min-height: 100vh; background-color: #f1f5f9; } /* Flexbox buat misahin Kiri & Kanan */

        /* ================= SIDEBAR (KIRI) ================= */
        .sidebar { 
            width: 260px; background-color: #0f172a; /* Dark Navy khas admin */
            color: white; display: flex; 
            flex-direction: column; 
        }
        .sidebar-header { 
            padding: 20px; background-color: #020617; 
            text-align: center; 
            font-weight: bold; 
            font-size: 20px; 
            border-bottom: 1px solid #1e293b;
        }
        .sidebar-menu { list-style: none; padding: 20px 0; flex: 1; }
        .sidebar-menu li a { 
            display: block; padding: 15px 25px; 
            color: #cbd5e1; 
            text-decoration: none; 
            transition: 0.3s; 
        }
        /* Efek nyala kalau menu lagi di-klik/hover */
        .sidebar-menu li a:hover, .sidebar-menu li a.active { 
            background-color: #1e293b; color: #38bdf8; 
            border-left: 4px solid #38bdf8; 
        }

        /* ================= KONTEN UTAMA (KANAN) ================= */
        .main-content { flex: 1; display: flex; flex-direction: column; }
        
        .topbar { 
            background-color: white; padding: 15px 30px; 
            display: flex; 
            justify-content: flex-end; 
            align-items: center; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .content-area { padding: 30px; overflow-y: auto; }

        /* ================= STYLE TABEL & KOTAK ================= */
        .card { 
            background: white; padding: 25px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; border-bottom: 1px solid #e2e8f0; text-align: left; font-size: 14px; }
        th { background-color: #f8fafc; color: #475569; font-weight: 600; }
        
        .badge-pending { background: #f59e0b; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold;}
        
        .btn-action { 
            cursor:pointer; padding: 8px 14px; 
            background: #0ea5e9; 
            color: white; 
            border: none; 
            border-radius: 4px; 
            transition: 0.3s; 
            font-weight: bold;
        }
        .btn-action:hover { background: #0284c7; }

        /* ================= CSS KHUSUS MODAL GAIB (PROFIL) ================= */
        .modal-gaib-overlay {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.6); z-index: 9999;
            display: none; justify-content: center; align-items: center;
            opacity: 0; transition: opacity 0.3s ease;
        }
        .modal-gaib-overlay.tampil { display: flex; opacity: 1; }
        .modal-gaib-box {
            background: white; border-radius: 12px; width: 400px; max-width: 90%;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            transform: translateY(-30px); transition: transform 0.3s ease;
            overflow: hidden; font-family: 'Segoe UI', sans-serif;
        }
        .modal-gaib-overlay.tampil .modal-gaib-box { transform: translateY(0); }
        .modal-gaib-header {
            background: #0ea5e9; color: white; padding: 15px 20px;
            display: flex; justify-content: space-between; align-items: center;
            font-weight: bold; font-size: 16px;
        }
        .modal-gaib-close {
            background: none; border: none; color: white; font-size: 24px; cursor: pointer; line-height: 1;
        }
        .modal-gaib-body { padding: 25px; }
        .tabel-profil td { padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #475569; font-size: 14px; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            💧 Admin PDAM
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard Utama</a></li>
    
            <li><a href="{{ route('admin.pelanggan') }}" class="{{ request()->routeIs('admin.pelanggan') ? 'active' : '' }}">Data Pelanggan</a></li>
             
            <li><a href="{{ route('admin.pengaduan.index') }}" class="{{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">Pengaduan Warga</a></li>
            
            @if(in_array(auth()->user()->role, ['super_admin', 'kepala_cabang', 'petugas_pemasangan']))
            <li><a href="{{ route('admin.balik-nama') }}" class="{{ request()->routeIs('admin.balik-nama*') ? 'active' : '' }}">Validasi Balik Nama</a></li>
            @endif
            
            @if(in_array(auth()->user()->role, ['super_admin']))
            <li><a href="{{ route('admin.tarif.index') }}" class="{{ request()->routeIs('admin.tarif.index') ? 'active' : '' }}">Kelola Tarif Air</a></li>
            @endif
            
            @if(in_array(auth()->user()->role, ['super_admin', 'kepala_cabang', 'kasir','petugas_meter']))
            <li><a href="{{ route('admin.tagihan.index') }}" class="{{ request()->routeIs('admin.tagihan.index') ? 'active' : '' }}">Data Tagihan</a></li>
             @endif

            @if(in_array(auth()->user()->role, ['super_admin', 'kepala_cabang', 'petugas_meter']))
            <li><a href="{{ route('admin.tagihan.create') }}" class="{{ request()->routeIs('admin.tagihan.create') ? 'active' : '' }}">Pencatatan Meter</a></li>
            @endif

            @if(in_array(auth()->user()->role, ['super_admin', 'kepala_cabang', 'admin_berita']))
            <li><a href="{{ route('admin.berita') }}" class="{{ request()->routeIs('admin.berita') ? 'active' : '' }}">Kelola Berita</a></li>
            @endif
            
            @if(in_array(auth()->user()->role, ['super_admin']))
            <li><a href="{{ route('admin.galeri_profil.index') }}" class="{{ request()->routeIs('admin.galeri_profil.index') ? 'active' : '' }}">Galeri_profil</a></li>
            <li><a href="{{ route('admin.prestasi.index') }}" class="{{ request()->routeIs('admin.prestasi.index') ? 'active' : '' }}">Prestasi</a></li>
            <li><a href="{{ route('admin.ppid.index') }}" class="{{ request()->routeIs('admin.ppid.index') ? 'active' : '' }}">PPID</a></li>
            @endif

            @if(in_array(auth()->user()->role, ['super_admin', 'kepala_cabang']))
            <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Kelola Akun Pegawai</a></li>
            @endif
            
            <li style="margin-top: 50px;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #ef4444; padding: 15px 25px; width: 100%; text-align: left; cursor: pointer; font-size: 16px; font-family: inherit; font-weight: bold;">
                        🚪 Keluar (Logout)
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="topbar" style="display: flex; justify-content: flex-end; align-items: center; gap: 15px;">
             <span>Halo, <strong>{{ auth()->user()->name }}</strong></span>
             <button type="button" onclick="bukaModalProfil()" style="padding: 6px 15px; border-radius: 20px; border: 1px solid #0ea5e9; background: white; color: #0ea5e9; font-weight: bold; cursor: pointer; transition: 0.3s;">
                 <i class="fas fa-user-circle"></i> Profil Saya
             </button>
        </header>
        <section class="content-area">
            
            @if(session('error'))
                <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 4px; margin-bottom: 20px; font-weight: bold;">
                    🛑 {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 4px; margin-bottom: 20px; font-weight: bold;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </section>
    </main>

    <div class="modal-gaib-overlay" id="profilSayaModal">
        <div class="modal-gaib-box">
            <div class="modal-gaib-header">
                <span><i class="fas fa-id-card me-2"></i> Kartu Identitas Pegawai</span>
                <button type="button" class="modal-gaib-close" onclick="tutupModalProfil()">&times;</button>
            </div>
            <div class="modal-gaib-body">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 80px; height: 80px; background: #e0f2fe; color: #0ea5e9; font-size: 35px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h5 style="margin: 0; color: #1e293b; font-size: 18px; font-weight: bold;">{{ auth()->user()->name }}</h5>
                    <span style="background: #0ea5e9; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block; margin-top: 5px;">
                        {{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}
                    </span>
                </div>
                <table class="tabel-profil" style="width: 100%; border-collapse: collapse;">
                    <tr><td width="40%">NIK Karyawan</td><td>: <strong>{{ auth()->user()->nik_karyawan ?? '-' }}</strong></td></tr>
                    <tr><td>Username</td><td>: <strong>{{ auth()->user()->username ?? '-' }}</strong></td></tr>
                    <tr><td>Email</td><td>: <strong>{{ auth()->user()->email }}</strong></td></tr>
                    <tr><td>Tempat, Tgl Lahir</td><td>: <strong>{{ auth()->user()->tempat_lahir ?? '-' }}, {{ auth()->user()->tanggal_lahir ? \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('d M Y') : '-' }}</strong></td></tr>
                    <tr><td style="border: none;">Lokasi Cabang</td><td style="border: none;">: <strong>{{ auth()->user()->cabang ? auth()->user()->cabang->nama_cabang : 'Pusat (Super Admin)' }}</strong></td></tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        function bukaModalProfil() {
            let modal = document.getElementById('profilSayaModal');
            modal.style.display = 'flex';
            // Efek transisi halus (fade-in)
            setTimeout(() => { modal.classList.add('tampil'); }, 10);
        }
        function tutupModalProfil() {
            let modal = document.getElementById('profilSayaModal');
            modal.classList.remove('tampil');
            // Nunggu efek fade-out kelar baru diilangin 100%
            setTimeout(() => { modal.style.display = 'none'; }, 300);
        }
        
        // Fitur tutup otomatis kalau klik area hitam luar kotak
        window.onclick = function(event) {
            if (event.target == document.getElementById('profilSayaModal')) {
                tutupModalProfil();
            }
        }
    </script>

</body>
</html>