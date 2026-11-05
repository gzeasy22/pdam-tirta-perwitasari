<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi PDAM</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body class="bg-light">

    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="nav-logo">
                <span class="logo-text">PDAM Tirta Perwitasari</span>
            </a>
            
            <ul class="nav-menu">
                <li><a href="{{ route('pelanggan.dashboard') }}" class="nav-link">Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="nav-link">Profil Perusahaan ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="/profil">Sejarah & Visi Misi</a></li>
                        <li><a href="/dewan-pengawas">Dewan Pengawas</a></li>
                        <li><a href="/manajemen">Manajemen</a></li>
                        <li><a href="/struktur-organisasi">Struktur Organisasi</a></li>
                        <li><a href="/prestasi">Prestasi</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link">Info Pelanggan ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="/pengaduan">Form Pengaduan</a></li>
                        <li><a href="/prosedur-pasang">Prosedur Pasang Pipa Baru</a></li>
                        <li><a href="/pasang-baru">Form Pasang Pipa Baru</a></li>
                        <li><a href="/balik-nama">Form Pengajuan Balik Nama</a></li>
                        <li><a href="/cek-tagihan">Cek Tagihan Bulanan</a></li>
                        <li><a href="/cek-pemasangan">Cek Pemasangan Pipa Baru</a></li>
                        <li><a href="/tarif-minum">Tarif Air Minum / Simulasi Tagihan</a></li>
                        <li><a href="/edukasi-tips">Edukasi Tips Pelanggan</a></li>
                        <li><a href="/faq">FAQ</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link">Info Perusahaan ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="/berita">Berita</a></li>
                        <li><a href="/wilayah-pelayanan">Wilayah Pelayanan</a></li>
                    </ul>
                </li>

                <li><a href="/ppid" class="nav-link">PPID</a></li>
                <li><a href="/kontak" class="nav-link">Kontak</a></li>
            </ul>

        </div>
    </nav>

    <main>
        @yield('content') 
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col about-col">
                <h3 class="footer-logo">PDAM Tirta Perwitasari</h3>
                <p>Menyediakan layanan air bersih berkualitas untuk kesejahteraan masyarakat dan mendukung pembangunan daerah yang berkelanjutan melalui inovasi digital.</p>
            </div>
            
            <div class="footer-col">
                <h4>Layanan Cepat</h4>
                <ul>
                    <li><a href="#">Cek Tagihan Air</a></li>
                    <li><a href="#">Lapor Gangguan</a></li>
                    <li><a href="#">Pasang Sambungan Baru</a></li>
                    <li><a href="#">Tarif Air Minum</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Informasi Publik</h4>
                <ul>
                    <li><a href="#">Berita & Pengumuman</a></li>
                    <li><a href="#">Profil Perusahaan</a></li>
                    <li><a href="#">Transparansi (PPID)</a></li>
                    <li><a href="#">Karir & Lowongan</a></li>
                </ul>
            </div>

            <div class="footer-col contact-col">
                <h4>Hubungi Kami</h4>
                <p>📍 Jl. Air Bersih No. 123, Kota Air, 40123</p>
                <p>📞 Call Center: 1500-123</p>
                <p>📱 WhatsApp: 0811-2233-4455</p>
                <p>✉️ Email: humas@pdamtirtamakmur.co.id</p>
                <p>🕒 Senin - Jumat (08:00 - 15:00)</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 PDAM Tirta Perwitasari. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>