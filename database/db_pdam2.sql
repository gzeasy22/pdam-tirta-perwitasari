-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 12, 2026 at 03:01 PM
-- Server version: 8.0.30
-- PHP Version: 8.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pdam2`
--

-- --------------------------------------------------------

--
-- Table structure for table `beritas`
--

CREATE TABLE `beritas` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beritas`
--

INSERT INTO `beritas` (`id`, `judul`, `isi`, `foto`, `created_at`, `updated_at`) VALUES
(14, 'PDAM Purworejo Tembus 10 Besar Kategori Sehat se-Jawa Tengah, Targetkan Naik Peringkat Meski Modal Terbatas', 'Perumda Air Minum (PDAM) Tirta Perwitasari Kabupaten Purworejo kembali menunjukkan komitmennya dalam memberikan pelayanan terbaik kepada masyarakat melalui capaian prestasi di tingkat provinsi. Berdasarkan hasil penilaian kinerja yang dilakukan oleh Badan Pengawasan Keuangan dan Pembangunan (BPKP), PDAM Tirta Perwitasari berhasil masuk dalam 10 besar kategori sehat serta menempati posisi 9 besar kinerja terbaik dari total 35 PDAM yang beroperasi di Jawa Tengah.\r\n\r\nDirektur Utama PDAM Tirta Perwitasari, Hermawan Wahyu Utomo, menyampaikan bahwa pencapaian ini merupakan hasil kerja keras dan kolaborasi seluruh jajaran perusahaan dalam menjaga kualitas layanan, tata kelola, serta kinerja keuangan yang berkelanjutan. Penilaian tersebut mencakup berbagai aspek vital, mulai dari keuangan, operasional, pelayanan pelanggan, hingga sumber daya manusia.\r\n\r\nMenurutnya, keberhasilan ini tidak lepas dari upaya peningkatan efisiensi operasional, optimalisasi distribusi air bersih, serta inovasi pelayanan yang terus dilakukan untuk memenuhi kebutuhan pelanggan. Selain itu, transparansi dan akuntabilitas dalam pengelolaan perusahaan juga menjadi faktor penting dalam meraih predikat kinerja sehat.\r\n\r\nPDAM Tirta Perwitasari juga menegaskan komitmennya untuk terus berinovasi dalam menghadapi tantangan ke depan, termasuk peningkatan cakupan layanan, pemanfaatan teknologi, serta penguatan sistem manajemen perusahaan. Dengan capaian ini, PDAM berharap dapat menjadi salah satu perusahaan daerah yang mampu memberikan kontribusi nyata bagi pembangunan daerah dan kesejahteraan masyarakat Kabupaten Purworejo.', 'berita_foto/zwrqyZCHGK35hzuU5Tbel4UkWW8LM8F6F5LqbHJN.jpg', '2026-05-20 19:09:47', '2026-05-20 19:09:47'),
(15, 'Komitmen PDAM Tirta Perwitasari Purworejo: Pastikan Bekas Galian Pipa Kembali Mulus Seperti Semula', 'Perumda Air Minum Tirta Perwitasari Kabupaten Purworejo menegaskan tanggung jawab penuhnya terhadap setiap dampak pekerjaan lapangan. \r\n\r\nPenegasan ini merespons aktivitas penggalian yang belakangan intens dilakukan di beberapa titik jalan beraspal. Direktur PDAM Tirta Perwitasari Hermawan Wahyu Utomo, S.T., M.Si. menjelaskan, penggalian merupakan prosedur wajib untuk mendeteksi lokasi pasti kebocoran pipa di bawah tanah. Selain penanganan kebocoran mendadak, PDAM juga melakukan perawatan rutin pada pipa-pipa tua peninggalan tahun 1978, seperti di jalur Tuksongo hingga depan Gedung DPRD Purworejo, dengan mengganti komponen sambungan yang aus menggunakan material PVC dan HDPE.\r\n\r\nTerkait kualitas pengembalian jalan PDAM Purworejo melakukan pemesanan aspal khusus dari Yogyakarta atas rekomendasi Dinas Pekerjaan Umum (DPU) agar spesifikasinya sesuai dengan aspal yang ada di Kabupaten Purworejo. \r\n\r\nProsesnya dilakukan secara bertahap, mulai dari penutupan sirtu (pasir batu) hingga menunggu material mengeras sebelum akhirnya dilakukan pengaspalan permanen. Upaya ini memastikan bahwa infrastruktur publik tetap terjaga kualitasnya meski harus melalui proses perbaikan jaringan air yang vital bagi masyarakat.', 'berita_foto/3tjjtdScqDiVGLGbzPRaQ6qWO1HdmY4UWzzycNS5.jpg', '2026-05-24 06:47:01', '2026-05-24 06:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `cabangs`
--

CREATE TABLE `cabangs` (
  `id` int NOT NULL,
  `nama_cabang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cabangs`
--

INSERT INTO `cabangs` (`id`, `nama_cabang`, `created_at`, `updated_at`) VALUES
(1, 'Kec. Bagelen', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(2, 'Kec. Banyuurip', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(3, 'Kec. Bayan', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(4, 'Kec. Bener', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(5, 'Kec. Butuh', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(6, 'Kec. Gebang', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(7, 'Kec. Grabag', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(8, 'Kec. Kemiri', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(9, 'Kec. Kutoarjo', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(10, 'Kec. Loano', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(11, 'Kec. Pituruh', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(12, 'Kec. Purwodadi', '2026-06-20 14:27:23', '2026-06-20 14:27:23'),
(13, 'Kec. Purworejo', '2026-06-20 14:27:23', '2026-06-20 14:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-ferdi123wahyu@gmail.com|127.0.0.1', 'i:1;', 1784770943),
('laravel-cache-ferdi123wahyu@gmail.com|127.0.0.1:timer', 'i:1784770943;', 1784770943),
('laravel-cache-sutaryanti@pdam.com|127.0.0.1', 'i:2;', 1787277244),
('laravel-cache-sutaryanti@pdam.com|127.0.0.1:timer', 'i:1787277244;', 1787277244);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeri_profils`
--

CREATE TABLE `galeri_profils` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galeri_profils`
--

INSERT INTO `galeri_profils` (`id`, `kategori`, `foto`, `created_at`, `updated_at`) VALUES
(7, 'struktur_organisasi', 'galeri_fotos/struktur-organisasi-1787234496.png', '2026-08-20 07:01:37', '2026-08-20 07:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_27_131412_create_beritas_table', 1),
(5, '2026_04_27_131417_create_pelanggans_table', 1),
(6, '2026_04_27_131417_create_pencatatan_meters_table', 1),
(7, '2026_04_27_131417_create_pengaduans_table', 1),
(8, '2026_04_28_122636_add_role_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggans`
--

CREATE TABLE `pelanggans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_kk` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_pelanggan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rt` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rw` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelurahan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabang_id` int DEFAULT NULL,
  `kecamatan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `koordinat_map` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `peruntukan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_golongan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kepemilikan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_ktp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_kk` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_rumah` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_selfie_ktp` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Survey','Approved','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `alasan_penolakan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_tagihan_pasang` int DEFAULT NULL,
  `foto_rab` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran_pasang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id_pasang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_token_pasang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ukuran_meter` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_meter` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merk_meter` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggans`
--

INSERT INTO `pelanggans` (`id`, `nama_lengkap`, `nik`, `no_kk`, `nomor_pelanggan`, `no_hp`, `email`, `alamat_lengkap`, `rt`, `rw`, `kelurahan`, `cabang_id`, `kecamatan`, `koordinat_map`, `latitude`, `longitude`, `peruntukan`, `sub_golongan`, `status_kepemilikan`, `foto_ktp`, `foto_kk`, `foto_rumah`, `foto_selfie_ktp`, `status`, `alasan_penolakan`, `created_at`, `updated_at`, `total_tagihan_pasang`, `foto_rab`, `status_pembayaran_pasang`, `order_id_pasang`, `snap_token_pasang`, `ukuran_meter`, `no_meter`, `merk_meter`, `deleted_at`) VALUES
(42, 'Slamet Riyadi', '3306011501990001', '3306011501990101', '330601-00123', '081234567801', 'slamet.riyadi01@gmail.com', 'Jl. Diponegoro No. 12', '001', '002', 'Sindurjan', 13, 'Kec. Purworejo', NULL, NULL, NULL, 'RUMAH TANGGA', 'Rumah Tangga A', 'Milik Sendiri', 'rahasia/berkas_ktp/i3X729ed4mhXv77qxOFOVdEtpXhXIxgY7XmzU4g2.jpg', 'rahasia/berkas_ktp/u6zZjEeVTfoXTY8Y5nxnBRwHyYiz7V2iMAECvSgc.jpg', 'rahasia/berkas_ktp/MfRpoW0hsKpv9n4I0eCTchM7okvyjtAWJ3CrjnQb.jpg', 'rahasia/berkas_ktp/TqRyouKNv0lxEHDb16zvmT26yjfh8XYkN85gojGt.jpg', 'Approved', NULL, '2026-08-20 05:57:32', '2026-08-20 06:15:55', NULL, NULL, NULL, NULL, NULL, '0,5', 'SN-2019-004521', 'Itron', NULL),
(44, 'Sri Wahyu', '3306022202920001', '3306022202920102', '330601-00124', '081234567802', 'sri.wahyuni02@gmail.com', 'Jl. Mayjend Sutoyo No. 5', '003', '001', 'Baledono', 13, 'Kec. Purworejo', NULL, NULL, NULL, 'RUMAH TANGGA', 'Rumah Tangga A', 'Milik Sendiri', 'rahasia/berkas_ktp/iYG9vKysM4VQEKbwCBboBpcNlqs9Mii3Y2Rr1OA5.png', 'rahasia/berkas_ktp/6na8UXcmTVZCuag1Z2R7Y3KT7VvIlLdBN0ewhacj.jpg', 'rahasia/berkas_ktp/AMrSJ7xR6wog2p62axrO5QEGZtd7nmP7ubgvJLd5.jpg', 'rahasia/berkas_ktp/9eUWgYSxaqV1a87VIwhJF3OchEknl598zjs8BXcB.jpg', 'Approved', NULL, '2026-08-20 05:59:08', '2026-10-03 02:39:39', NULL, NULL, NULL, NULL, NULL, '0,5', 'SN-2019-004522', 'Sensus', NULL),
(45, 'Bambang Sutrisno', '3306031203880003', '3306031203880103', '330603-00201', '081234567803', 'bambang.sutrisno03@gmail.com', 'Dusun Krajan No. 8', '002', '003', 'Kutoarjo', 9, 'Kec. Kutoarjo', NULL, NULL, NULL, 'RUMAH TANGGA', 'Rumah Tangga B', 'Milik Sendiri', 'rahasia/berkas_ktp/zbJVtINdDDZxJUPbWKmTsJgerbOonQzRAsBgkrFV.jpg', 'rahasia/berkas_ktp/6KWbTPbdyf8eZOj8D9d6wk0ECFOhNeSIwS8fr7X3.jpg', 'rahasia/berkas_ktp/RmIhN8YPRi3YvtyE0GFi3KD9DYbJ9wKkeJxkxba3.jpg', 'rahasia/berkas_ktp/ZbHOomm5tY1pPJwf0Q5RWBExTNW4Q0qEs1It8pSM.jpg', 'Approved', NULL, '2026-08-20 06:00:44', '2026-08-20 06:17:25', NULL, NULL, NULL, NULL, NULL, '0,5', 'SN-2020-007733', 'Amico', NULL),
(46, 'Tri Handayani', '3306042804950004', '3306042804950104', '330603-00202', '081234567804', 'tri.handayani04@gmail.com', 'Dusun Sidorejo No. 21', '004', '002', 'Semawung Daleman', 9, 'Kec. Kutoarjo', NULL, NULL, NULL, 'RUMAH TANGGA', 'Rumah Tangga B', 'Milik Sendiri', 'rahasia/berkas_ktp/QYDUlPB4lW0ug6V8giVPQIPibH0mKiBeTjCcMSh7.jpg', 'rahasia/berkas_ktp/Ww8QqoMLHbdvRj7JImcGC779ToGOGWfFRrvOJIpL.jpg', 'rahasia/berkas_ktp/QHmT1qDiOfbLZwIvHfQJ4djaEGcHFD0WnYthdfwk.jpg', 'rahasia/berkas_ktp/kRFLgvSow0GPvFZRcvfRhA41RXIY2cMJnrHYILUQ.jpg', 'Approved', NULL, '2026-08-20 06:02:42', '2026-08-20 06:19:25', NULL, NULL, NULL, NULL, NULL, '0,5', 'SN-2020-007734', 'Itron', NULL),
(47, 'Agus Purnomo', '3306051005970005', '3306051005970105', '330605-00310', '081234567805', 'agus.purnomo05@gmail.com', 'Dusun Karangrejo No. 3', '001', '001', 'Bener', 4, 'Kec. Bener', NULL, NULL, NULL, 'SOSIAL', 'Sosial Umum', 'Milik Sendiri', 'rahasia/berkas_ktp/iizwj68yGNX7Ltmd30Q8m7ZSD5xShD1NUUCYjOIJ.jpg', 'rahasia/berkas_ktp/wbW4DnZsDbhRTNpX5viy0Burmwrp2e5MD27kWnqN.jpg', 'rahasia/berkas_ktp/f7H2pCBXCMhJM4PLgg95nPBzDNiAO6beplT6euXy.jpg', 'rahasia/berkas_ktp/w6JmgBFt5rSbFCr68BoUByjiUhygsOwIbNducdG5.jpg', 'Approved', NULL, '2026-08-20 06:04:28', '2026-08-20 06:21:32', NULL, NULL, NULL, NULL, NULL, '0,5', 'SN-2018-002211', 'Sensus', NULL),
(48, 'Wahyuningsih', '3306061906930006', '3306061906930106', '330605-00311', '081234567806', 'wahyuningsih06@gmail.com', 'Dusun Kaliboto No. 17', '003', '002', 'Kamijoro', 4, 'Kec. Bener', NULL, NULL, NULL, 'SOSIAL', 'Sosial Khusus', 'Milik Sendiri', 'rahasia/berkas_ktp/rPhL4gxd5nc8Eq3e53EtplBYpTY2zmNVneqy38j0.jpg', 'rahasia/berkas_ktp/sz98vQZYhrU5rOwgbgAKKg0fgcda9ftgZYiKd73r.jpg', 'rahasia/berkas_ktp/MhipZ6oIKW7R1nYpJsQ3hrIYsYadDGDZ7jPHyHLy.jpg', 'rahasia/berkas_ktp/ZlmdVICz5r2BrLr1fIaW5kjKHlZj63S3P5s1Iy28.jpg', 'Approved', NULL, '2026-08-20 06:07:13', '2026-08-20 06:22:00', NULL, NULL, NULL, NULL, NULL, '0,5', 'SN-2018-002212', 'Amico', NULL),
(49, 'Joko Santoso', '3306072007890007', '3306072007890107', '330607-00415', '081234567807', 'joko.santoso07@gmail.com', 'Dusun Krendetan No. 9', '002', '001', 'Kalirejo', 1, 'Kec. Bagelen', NULL, NULL, NULL, 'INSTANSI', 'INSTANSI', 'Milik Sendiri', 'rahasia/berkas_ktp/Hg6xMrkpCrgaeBUWfdpk1dJqGXrjDQQU3UEK4ZNQ.jpg', 'rahasia/berkas_ktp/tjJ8NG0F8RS0ZZ9IdHCzwdafAJSYHgRB2cDFODHQ.jpg', 'rahasia/berkas_ktp/KbWk7OZK50bRKg4jnPJPHw1j0gMGszWRV0aKcMO4.jpg', 'rahasia/berkas_ktp/MthZLKtMvLhcsgVrevBBecFwVxjixvRGaKLmjLFy.jpg', 'Approved', NULL, '2026-08-20 06:08:50', '2026-08-20 06:23:42', NULL, NULL, NULL, NULL, NULL, '0,5', 'SN-2021-009981', 'Itron', NULL),
(50, 'Endang Sulistio', '3306081108960008', '3306081108960108', '330607-00416', '081234567808', 'endang.s08@gmail.com', 'Dusun Somorejo No. 14', '005', '003', 'Somorejo', 1, 'Kec. Bagelen', NULL, NULL, NULL, 'NIAGA', 'NIAGA A', 'Milik Sendiri', 'rahasia/berkas_ktp/3JqaZhEHHE8gnk00eTYvukfEpn0qsA0IYApRSJpL.jpg', 'rahasia/berkas_ktp/uuLqoB7GcTPhykYeRP4rMKLxS3fhzejtlATBxpjB.jpg', 'rahasia/berkas_ktp/nTep7NEtDE10jeLYBUq9epbDdgri7xjSeOw0DqsL.jpg', 'rahasia/berkas_ktp/CIYSjZrXowOTB3vyYxfTChJGnvOdseOEeLQKtSoO.jpg', 'Approved', NULL, '2026-08-20 06:10:29', '2026-10-03 01:53:53', NULL, NULL, NULL, NULL, NULL, '0,75', 'SN-2021-009982', 'Sensus', '2026-10-03 01:53:09'),
(51, 'Dwi Cahyono', '3306092209910009', '3306092209910109', NULL, '081234567809', 'dwi.cahyono09@gmail.com', 'Dusun Tegalsari No. 6', '001', '004', 'Banjarsari', 12, 'Kec. Purwodadi', NULL, NULL, NULL, 'RUMAH TANGGA', NULL, 'Milik Sendiri', 'rahasia/berkas_ktp/HuPAbIu0v0K1kHG8gnf75kjIbeM8pVME3hkxAKsH.jpg', 'rahasia/berkas_ktp/2FYz0UXAWTe3uhHLedVTme6HamwkqFtfNnHRtoKw.jpg', 'rahasia/berkas_ktp/jlJwA5H2lTIfjZ612Otzu1E61l4UZX14fJNspFPF.jpg', 'rahasia/berkas_ktp/1jWT3mnzacSoVqEjf8D3zHIILop2VAjm9p5ajY29.jpg', 'Pending', NULL, '2026-08-20 06:11:47', '2026-10-03 21:13:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-10-03 21:13:55'),
(52, 'Nur Aini', '3306102310940010', '3306102310940110', '330609-00416', '081234567810', 'nur.aini10@gmail.com', 'Dusun Loano No. 25', '002', '002', 'Loano', 10, 'Kec. Loano', NULL, NULL, NULL, 'INDUSTRI', 'INDUSTRI A', 'Milik Sendiri', 'rahasia/berkas_ktp/WVTlF6lxrvexX0xA4uLXr4oGoZPO248PdHU0vIRU.jpg', 'rahasia/berkas_ktp/Gws379KlTAg71JMZfXt0m0ULIxVVAQBl4BYbFCgU.jpg', 'rahasia/berkas_ktp/zgY4COwqG23SFmO2vS1VH5yWvE3UdLKC9JlM5CHU.jpg', 'rahasia/berkas_ktp/7qXpUNhypixc2hVRh9Bt175oN4duzriRYw92DewH.jpg', 'Approved', NULL, '2026-08-20 06:12:58', '2026-08-20 19:13:12', 1300000, 'rahasia/berkas_rab/1787278276_RAB_images.jpeg', 'Lunas', 'RAB-52-1787278299', '70b1f94b-c041-4e88-9b6f-b1907f28645b', '0,5', 'SN-2019-004521', 'Itron', NULL),
(53, 'Eko Prasetyo', '3306111203990011', '3306111203990111', '330602-00256', '081234567811', 'eko.prasetyo11@mail.com', 'Dusun Kembangkuning No. 7', '002', '003', 'Sindurjan', 13, 'Kec. Purworejo', NULL, NULL, NULL, 'RUMAH TANGGA', 'Rumah Tangga A', 'Milik Sendiri', 'rahasia/berkas_ktp/kp8hqzoESLaSAQEWnv3nl4TeIsGl5AhuKNPPLzHz.jpg', 'rahasia/berkas_ktp/JznVT0fXnlN2kw9ujZPiBPVP3tZZIXEHhaKODiEy.jpg', 'rahasia/berkas_ktp/7m5RjTM3iwfpoWQejqDoKTRVCilQ6aB76vgg1CUN.jpg', 'rahasia/berkas_ktp/dg1e4dyxIt9VNTYhODtwWRyWsYaIBVTQcHssa9TH.jpg', 'Approved', NULL, '2026-08-20 06:32:52', '2026-08-20 06:37:44', NULL, NULL, NULL, NULL, NULL, '0,5', 'SN-2022-011023', 'Itron', NULL),
(54, 'Retno Wulandari', '3306121407940012', '3306121407940112', '330604-00318', '081234567812', 'retno.wulandari12@mail.com', 'Dusun Semawung No. 19', '001', '002', 'Kutoarjo', 9, 'Kec. Kutoarjo', NULL, NULL, NULL, 'RUMAH TANGGA', 'Rumah Tangga C', 'Milik Sendiri', 'rahasia/berkas_ktp/EG6K3EfHIszgEDgeUbkZTkTr2YBMgKQZXa4t6P0C.jpg', 'rahasia/berkas_ktp/XlB2VSQ2Or9oc78jya6Ei1TQmPXKJ77Izd7kpmDr.jpg', 'rahasia/berkas_ktp/0uxrQfUz2FGVtctoPf7VGSYoJVeSo2aOc1O60dut.jpg', 'rahasia/berkas_ktp/Ff2LVS2TEr9wK5tsC3uOOwlCIqrL6BL9W2EgDrzn.jpg', 'Approved', NULL, '2026-08-20 06:39:05', '2026-08-20 06:39:40', NULL, NULL, NULL, NULL, NULL, '1', 'SN-2021-010456', 'Sensus', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pencatatan_meters`
--

CREATE TABLE `pencatatan_meters` (
  `id` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED NOT NULL,
  `periode` date NOT NULL,
  `meter_awal` int NOT NULL,
  `meter_akhir` int NOT NULL,
  `total_pemakaian` int NOT NULL,
  `foto_meter` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `petugas_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaduans`
--

CREATE TABLE `pengaduans` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis_pelapor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Pelanggan',
  `pelanggan_id` bigint UNSIGNED DEFAULT NULL,
  `cabang_id` bigint UNSIGNED DEFAULT NULL,
  `kecamatan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pelapor` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('Pipa Bocor','Air Mati','Kualitas Air','Lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_kejadian` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_map` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_masalah` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_bukti` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Open','Proses','Resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_balik_namas`
--

CREATE TABLE `pengajuan_balik_namas` (
  `id` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED NOT NULL,
  `nama_lama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama_baru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nik_baru` varchar(16) NOT NULL,
  `foto_ktp_baru` varchar(255) NOT NULL,
  `foto_bukti_kepemilikan` varchar(255) NOT NULL,
  `snap_token` varchar(255) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Menunggu Pembayaran','Selesai','Rejected') NOT NULL DEFAULT 'Pending',
  `alasan_penolakan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengajuan_balik_namas`
--

INSERT INTO `pengajuan_balik_namas` (`id`, `pelanggan_id`, `nama_lama`, `nama_baru`, `nik_baru`, `foto_ktp_baru`, `foto_bukti_kepemilikan`, `snap_token`, `order_id`, `status`, `alasan_penolakan`, `created_at`, `updated_at`) VALUES
(9, 50, 'Endang Sulistyowati', 'Endang Sulis', '3306081108960009', 'rahasia/berkas_ktp/ISO3unwzhbpAC9DZzq9pE1VVEuPR2KQ4zWyGVi0U.png', 'rahasia/berkas_kepemilikan/Qj2EVeTXSSz8o8XZCtgaF4BfQWeR1cG1ZBejgf3N.png', '2681589c-9103-4c2c-be49-da2d23b7835b', 'BN-9-1791016812', 'Selesai', NULL, '2026-10-03 01:39:23', '2026-10-03 01:41:02'),
(10, 50, 'Endang Sulis', 'Endang Sulistio', '3306081108960008', 'rahasia/berkas_ktp/3JqaZhEHHE8gnk00eTYvukfEpn0qsA0IYApRSJpL.jpg', 'rahasia/berkas_kepemilikan/PcMx3ezLSkb53tk8kpfZkzS1SZBrjoOzOzgaSX3M.jpg', '6b66235d-4153-471d-bf73-4b395f3ea546', 'BN-10-1791017617', 'Selesai', NULL, '2026-10-03 01:52:01', '2026-10-03 01:53:53'),
(11, 44, 'Sri Wahyuni', 'Sri Wahyu', '3306022202920001', 'rahasia/berkas_ktp/iYG9vKysM4VQEKbwCBboBpcNlqs9Mii3Y2Rr1OA5.png', 'rahasia/berkas_kepemilikan/lVbjSNXXU0HahvcHjureZyWaoqGEtbW3cnr6Kesg.png', '284cc8dc-d205-4595-af22-26a3ce925625', 'BN-11-1791020365', 'Selesai', NULL, '2026-10-03 02:38:55', '2026-10-03 02:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `ppids`
--

CREATE TABLE `ppids` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_dokumen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prestasis`
--

CREATE TABLE `prestasis` (
  `id` bigint UNSIGNED NOT NULL,
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profils`
--

CREATE TABLE `profils` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_atau_judul` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_atau_keterangan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `foto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profils`
--

INSERT INTO `profils` (`id`, `kategori`, `nama_atau_judul`, `jabatan_atau_keterangan`, `deskripsi`, `foto`, `created_at`, `updated_at`) VALUES
(7, 'direksi', 'Hermawan Wahyu Utomo', 'Direktur Utama', 'S1 Teknik Geologi\r\nDirektur Utama Batu Bara\r\nKepala Desa Banjarsari', 'profil_fotos/n8pJ7v5zyY368mZmVyDijAkHQBfOwHcdOJTpinJy.jpg', '2026-06-10 06:04:34', '2026-06-10 06:04:34'),
(8, 'direksi', 'Bagus Parmanto', 'Direktur Sampingan', 'D3 Managemen Perkantoran', 'profil_fotos/qOKT6imR3q2lrdvUo6AAqwWm7lb7QXnlnYyFUYRz.png', '2026-06-16 19:48:06', '2026-06-16 19:48:06');

-- --------------------------------------------------------

--
-- Table structure for table `rayon_petugas`
--

CREATE TABLE `rayon_petugas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rayon_code` varchar(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rayon_petugas`
--

INSERT INTO `rayon_petugas` (`id`, `user_id`, `rayon_code`, `created_at`, `updated_at`) VALUES
(11, 20, '123456', '2026-07-22 19:01:20', '2026-07-22 19:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('VqHprVM3R6bNLDVsrpJU8RuLD8T7xieO1y53P1Kq', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36 Edg/156.0.0.0', 'eyJfdG9rZW4iOiJ1UFZTQmExeWUxUFFSU0JoT1B5aW9rWFFRTTNkY09HSUJuZ094aWpFIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3BkYW0yLnRlc3QiLCJyb3V0ZSI6InBlbGFuZ2dhbi5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NywicGFzc3dvcmRfaGFzaF93ZWIiOiIxNThiYmJjOWZlMmVhNmFhZmExYzJjZjBiNjFlNmI5NTI4OTIyYTYzZjM5YjU5ZmFiNjIxMDc2ODFkMmNkYTI0In0=', 1793869458);

-- --------------------------------------------------------

--
-- Table structure for table `tagihans`
--

CREATE TABLE `tagihans` (
  `id` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED NOT NULL,
  `bulan_tagihan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meteran_awal` int NOT NULL,
  `meteran_akhir` int NOT NULL,
  `foto_meter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pemakaian` int NOT NULL,
  `total_tagihan` int NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Bayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snap_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode_pembayaran` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tagihans`
--

INSERT INTO `tagihans` (`id`, `pelanggan_id`, `bulan_tagihan`, `meteran_awal`, `meteran_akhir`, `foto_meter`, `pemakaian`, `total_tagihan`, `status`, `created_at`, `updated_at`, `order_id`, `snap_token`, `metode_pembayaran`) VALUES
(81, 41, '2026-08', 0, 13, '1787026390_METER_DFD level 0.png', 13, 59050, 'Belum Bayar', '2026-08-17 21:13:10', '2026-08-17 21:13:10', NULL, NULL, NULL),
(82, 50, '2026-08', 0, 13, '1787278069_METER_images.jpeg', 13, 175850, 'Belum Bayar', '2026-08-20 19:07:50', '2026-08-20 19:07:50', NULL, NULL, NULL),
(83, 49, '2026-11', 0, 13, '1793868334_METER_SIP.jpeg', 13, 94800, 'Pending', '2026-11-05 01:45:35', '2026-11-05 01:45:50', 'PDAM-83-1793868349', 'af6b20d8-1cd6-4608-9837-554807ecf25f', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tarif_airs`
--

CREATE TABLE `tarif_airs` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori_golongan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_golongan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_pakai` int NOT NULL DEFAULT '10',
  `tarif_blok_1` int NOT NULL,
  `tarif_blok_2` int NOT NULL,
  `tarif_blok_3` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tarif_airs`
--

INSERT INTO `tarif_airs` (`id`, `kategori_golongan`, `sub_golongan`, `min_pakai`, `tarif_blok_1`, `tarif_blok_2`, `tarif_blok_3`, `created_at`, `updated_at`) VALUES
(1, 'SOSIAL', 'Sosial Umum', 10, 2800, 2800, 2800, '2026-06-05 13:27:05', '2026-06-18 06:59:31'),
(2, 'SOSIAL', 'Sosial Khusus', 10, 2800, 2800, 2800, '2026-06-05 13:27:05', '2026-06-05 13:27:05'),
(3, 'RUMAH TANGGA', 'Rumah Tangga A', 10, 3250, 4900, 6600, '2026-06-05 13:27:05', '2026-06-05 08:57:35'),
(4, 'RUMAH TANGGA', 'Rumah Tangga B', 10, 3250, 5550, 8700, '2026-06-05 13:27:05', '2026-06-16 05:30:31'),
(12, 'RUMAH TANGGA', 'Rumah Tangga C', 10, 3350, 6200, 11600, '2026-06-21 10:36:23', '2026-06-21 10:36:23'),
(13, 'RUMAH TANGGA', 'Rumah Tangga D', 10, 4000, 6400, 12200, '2026-06-21 10:37:31', '2026-07-12 08:14:04'),
(14, 'INSTANSI', 'INSTANSI', 10, 6200, 8100, 13350, '2026-06-21 10:38:26', '2026-06-21 10:38:26'),
(15, 'NIAGA', 'NIAGA A', 20, 8200, 8200, 13350, '2026-06-21 10:40:03', '2026-06-21 10:40:03'),
(16, 'NIAGA', 'NIAGA B', 20, 12950, 12950, 16200, '2026-06-21 10:40:37', '2026-06-21 10:40:37'),
(17, 'INDUSTRI', 'INDUSTRI A', 20, 9850, 9850, 13050, '2026-06-21 10:41:21', '2026-06-21 10:41:21'),
(18, 'INDUSTRI', 'INDUSTRI B', 20, 16200, 16200, 19500, '2026-06-21 10:41:53', '2026-06-21 10:41:53'),
(23, 'SOSIAL', 'Sosial VIP', 20, 10500, 10500, 12500, '2026-08-16 17:17:47', '2026-08-23 06:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik_karyawan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cabang_id` int DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nik_karyawan`, `tempat_lahir`, `tanggal_lahir`, `username`, `email`, `role`, `cabang_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 'Bos PDAM', NULL, NULL, NULL, NULL, 'superadmin@pdam.com', 'super_admin', NULL, NULL, '$2y$12$mLQd/KIexIdt8yl4pKfHM.8.yuPcjeOJm8SE/f0ZIkuftrgX.Ss6i', NULL, '2026-05-18 20:22:01', '2026-11-05 01:43:05'),
(13, 'Yuli', '2202089', 'Purworejo', '1999-07-16', 'Yuli', 'Yuli@pdam.com', 'kepala_cabang', 12, NULL, '$2y$12$DdnrkbGdGTuy1E69eVkkhej4wlvZUSwq00p3P3J8dbqON/3zdHOsa', NULL, '2026-06-20 10:25:40', '2026-07-12 09:01:33'),
(15, 'Sutaryanti', '121213', 'Lampung', '2001-01-04', 'Tari', 'Tari@pdam.com', 'kepala_cabang', 9, NULL, '$2y$12$8fZ41G3uyivxEC86/zSTme99r1kvDSy/vUA60JHUEcyjTsFTb.f4K', NULL, '2026-06-21 04:58:28', '2026-08-20 18:53:41'),
(20, 'Wahyu Ferdiansyah', '2202089', 'Purworejo', '2026-07-22', 'wahyu', 'wahyu@gmail.com', 'petugas_meter', 12, NULL, '$2y$12$TUHjZV5gkGnvIqURHBHnW.J3Lj/FuIp2nwAujZhWPSesmjBtTElby', NULL, '2026-07-05 09:19:32', '2026-07-22 18:44:45'),
(21, 'asih', '2202089', 'bubutan', '2026-07-01', 'Asih', 'asih@pdam.com', 'petugas_pemasangan', 12, NULL, '$2y$12$IrLZxXaTWxZIKqupPddAZundTGc2QCriOc6OmiLiBtzZuH.qOrXnm', NULL, '2026-07-05 18:57:53', '2026-07-12 01:25:20'),
(22, 'Bagus', '768657545', 'Purworejo', '1995-07-12', 'Bagus', 'bagus@gmail.com', 'petugas_meter', 13, NULL, '$2y$12$D4kK3vCFuNYbIahQyxDPEe2iD970U3o2N2sM7NykQeUv7y40d2/B.', NULL, '2026-07-14 23:11:47', '2026-08-20 18:18:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beritas`
--
ALTER TABLE `beritas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cabangs`
--
ALTER TABLE `cabangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galeri_profils`
--
ALTER TABLE `galeri_profils`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pelanggans_nik_unique` (`nik`),
  ADD UNIQUE KEY `pelanggans_nomor_pelanggan_unique` (`nomor_pelanggan`);

--
-- Indexes for table `pencatatan_meters`
--
ALTER TABLE `pencatatan_meters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pencatatan_meters_pelanggan_id_foreign` (`pelanggan_id`);

--
-- Indexes for table `pengaduans`
--
ALTER TABLE `pengaduans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengajuan_balik_namas`
--
ALTER TABLE `pengajuan_balik_namas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pelanggan_balik_nama` (`pelanggan_id`);

--
-- Indexes for table `ppids`
--
ALTER TABLE `ppids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prestasis`
--
ALTER TABLE `prestasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profils`
--
ALTER TABLE `profils`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rayon_petugas`
--
ALTER TABLE `rayon_petugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tagihans`
--
ALTER TABLE `tagihans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `tarif_airs`
--
ALTER TABLE `tarif_airs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beritas`
--
ALTER TABLE `beritas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cabangs`
--
ALTER TABLE `cabangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galeri_profils`
--
ALTER TABLE `galeri_profils`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pelanggans`
--
ALTER TABLE `pelanggans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `pencatatan_meters`
--
ALTER TABLE `pencatatan_meters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengaduans`
--
ALTER TABLE `pengaduans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pengajuan_balik_namas`
--
ALTER TABLE `pengajuan_balik_namas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ppids`
--
ALTER TABLE `ppids`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prestasis`
--
ALTER TABLE `prestasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profils`
--
ALTER TABLE `profils`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rayon_petugas`
--
ALTER TABLE `rayon_petugas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tagihans`
--
ALTER TABLE `tagihans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tarif_airs`
--
ALTER TABLE `tarif_airs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pencatatan_meters`
--
ALTER TABLE `pencatatan_meters`
  ADD CONSTRAINT `pencatatan_meters_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_balik_namas`
--
ALTER TABLE `pengajuan_balik_namas`
  ADD CONSTRAINT `fk_pelanggan_balik_nama` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rayon_petugas`
--
ALTER TABLE `rayon_petugas`
  ADD CONSTRAINT `rayon_petugas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
