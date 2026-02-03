-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Feb 2026 pada 02.51
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updationDate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `updationDate`) VALUES
(1, 'admin', '7488e331b8b64e5794da3fa4eb10ad5d', '31-01-2026 10:34:06 PM'),
(2, 'admin', '7488e331b8b64e5794da3fa4eb10ad5d', '31-01-2026 10:34:06 PM');

-- --------------------------------------------------------

--
-- Struktur dari tabel `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `doctorSpecialization` varchar(255) DEFAULT NULL,
  `doctorId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `consultancyFees` int(11) DEFAULT NULL,
  `appointmentDate` varchar(255) DEFAULT NULL,
  `appointmentTime` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `userStatus` int(11) DEFAULT NULL,
  `doctorStatus` int(11) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `appointment`
--

INSERT INTO `appointment` (`id`, `doctorSpecialization`, `doctorId`, `userId`, `consultancyFees`, `appointmentDate`, `appointmentTime`, `postingDate`, `userStatus`, `doctorStatus`, `updationDate`) VALUES
(1, 'ENT', 1, 1, 500, '2024-05-30', '9:15 AM', '2024-05-15 03:42:11', 1, 1, NULL),
(2, 'Endocrinologists', 2, 2, 800, '2024-05-31', '2:45 PM', '2024-05-16 09:08:54', 1, 1, NULL),
(3, 'Endocrinologists', 2, 1, 800, '2026-01-16', '2:30 PM', '2026-01-14 07:27:33', 1, 1, NULL),
(4, 'Radiology', 0, 1, 0, '2026-01-28', '2:30 PM', '2026-01-14 07:28:48', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `specilization` varchar(255) DEFAULT NULL,
  `doctorName` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `docFees` varchar(255) DEFAULT NULL,
  `contactno` bigint(11) DEFAULT NULL,
  `docEmail` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `doctors`
--

INSERT INTO `doctors` (`id`, `specilization`, `doctorName`, `address`, `docFees`, `contactno`, `docEmail`, `password`, `creationDate`, `updationDate`) VALUES
(1, 'ENT', 'Anuj kumar', 'A 123 XYZ Apartment Raj Nagar Ext Ghaziabad', '500', 142536250, 'anujk123@test.com', 'f925916e2754e5e03f75dd58a5733251', '2024-04-10 18:16:52', '2024-05-14 09:26:17'),
(2, 'Endocrinologists', 'Charu Dua', 'X 1212 ABC Apartment Laxmi Nagar New Delhi ', '800', 1231231230, 'charudua12@test.com', 'f925916e2754e5e03f75dd58a5733251', '2024-04-11 01:06:41', '2024-05-14 09:26:28'),
(4, 'Pediatrics', 'Priyanka Sinha', 'A 123 Xyz Aparmtnent Ghaziabad', '700', 74561235, 'p12@t.com', 'f925916e2754e5e03f75dd58a5733251', '2024-05-16 09:12:23', NULL),
(5, 'Orthopedics', 'Vipin Tayagi', 'Yasho Hospital New Delhi', '1200', 95214563210, 'vpint123@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-05-16 09:13:11', NULL),
(6, 'Internal Medicine', 'Dr Romil', 'Max Hospital Vaishali  GZB', '1500', 8563214751, 'drromil12@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-05-16 09:14:11', NULL),
(7, 'Obstetrics and Gynecology', 'Bhavya rathore', 'Shop 12 Indira Puram Ghaziabad', '800', 745621330, 'bhawya12@tt.com', 'f925916e2754e5e03f75dd58a5733251', '2024-05-16 09:15:18', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `doctorslog`
--

CREATE TABLE `doctorslog` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `doctorslog`
--

INSERT INTO `doctorslog` (`id`, `uid`, `username`, `userip`, `loginTime`, `logout`, `status`) VALUES
(1, 1, 'anujk123@test.com', 0x3a3a3100000000000000000000000000, '2024-05-16 05:19:33', NULL, 1),
(2, 1, 'anujk123@test.com', 0x3a3a3100000000000000000000000000, '2024-05-16 09:01:03', '16-05-2024 02:37:32 PM', 1),
(3, 1, 'anujk123@test.com', 0x3a3a3100000000000000000000000000, '2026-01-14 07:13:31', NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `doctorspecilization`
--

CREATE TABLE `doctorspecilization` (
  `id` int(11) NOT NULL,
  `specilization` varchar(255) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `doctorspecilization`
--

INSERT INTO `doctorspecilization` (`id`, `specilization`, `creationDate`, `updationDate`) VALUES
(1, 'Orthopedics', '2024-04-09 18:09:46', '2024-05-14 09:26:47'),
(2, 'Internal Medicine', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(3, 'Obstetrics and Gynecology', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(4, 'Dermatology', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(5, 'Pediatrics', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(6, 'Radiology', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(7, 'General Surgery', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(8, 'Ophthalmology', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(9, 'Anesthesia', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(10, 'Pathology', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(11, 'ENT', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(12, 'Dental Care', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(13, 'Dermatologists', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(14, 'Endocrinologists', '2024-04-09 18:09:46', '2024-05-14 09:26:56'),
(15, 'Neurologists', '2024-04-09 18:09:46', '2024-05-14 09:26:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblberita`
--

CREATE TABLE `tblberita` (
  `id` int(11) NOT NULL,
  `Judul` varchar(255) NOT NULL,
  `Kategori` varchar(100) NOT NULL,
  `Konten` text NOT NULL,
  `Gambar` varchar(255) DEFAULT NULL,
  `Penulis` varchar(100) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `TanggalPosting` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblberita`
--

INSERT INTO `tblberita` (`id`, `Judul`, `Kategori`, `Konten`, `Gambar`, `Penulis`, `Status`, `TanggalPosting`) VALUES
(5, 'Upacara Bendera 17 Agustus Berlangsung Khidmat, Tumbuhkan Semangat Nasionalisme', 'Lainnya', 'Kegiatan Upacara Peringatan Hari Kemerdekaan Republik Indonesia tanggal 17 Agustus diselenggarakan sebagai bentuk penghormatan terhadap jasa para pahlawan serta untuk menumbuhkan semangat nasionalisme dan cinta tanah air. Upacara dilaksanakan dengan rangkaian acara yang tertib dan khidmat, meliputi pengibaran bendera Merah Putih, menyanyikan lagu kebangsaan Indonesia Raya, pembacaan teks Proklamasi, pembacaan doa, serta amanat pembina upacara. Melalui kegiatan ini diharapkan seluruh peserta dapat meneladani semangat perjuangan para pahlawan, memperkuat persatuan dan kesatuan, serta meningkatkan rasa tanggung jawab dalam mengisi kemerdekaan dengan hal-hal positif bagi bangsa dan negara. ????????', '1769789644_697cd8cc1811e.jpg', 'Dzaki', 'Tidak Aktif', '2026-01-30 10:13:31'),
(6, 'Pembinaan Keagamaan Tingkatkan Keimanan Warga Binaan', 'Event', 'Lembaga Pemasyarakatan menggelar kegiatan pembinaan keagamaan sebagai bagian dari upaya pembentukan karakter warga binaan. Kegiatan ini diisi dengan ceramah agama, pembacaan doa, serta pembinaan rohani yang bertujuan menumbuhkan kesadaran diri, memperkuat keimanan, dan membangun sikap positif selama menjalani masa pembinaan. Melalui kegiatan ini diharapkan warga binaan dapat memperbaiki diri serta memiliki bekal moral yang baik saat kembali ke masyarakat.', '1769789961_697cda09055c7.jpg', 'Soleha', 'Aktif', '2026-01-30 10:19:21'),
(7, 'Lapas Selenggarakan Pelatihan Keterampilan bagi Warga Binaan', 'Lainnya', 'Dalam rangka meningkatkan kemandirian warga binaan, Lapas menyelenggarakan program pelatihan keterampilan kerja seperti kerajinan tangan, pertanian, dan keterampilan teknis lainnya. Program ini bertujuan membekali warga binaan dengan kemampuan praktis yang dapat dimanfaatkan setelah bebas nanti. Kegiatan berlangsung dengan pendampingan petugas dan instruktur, sehingga warga binaan dapat belajar secara terarah dan produktif.', '1769790052_697cda645ebd5.jpeg', 'Jamal', 'Aktif', '2026-01-30 10:20:52'),
(8, 'Kegiatan Olahraga Bersama Jaga Kesehatan Warga Binaan', 'Kesehatan', 'Sebagai bentuk perhatian terhadap kesehatan fisik dan mental, Lapas rutin mengadakan kegiatan olahraga bersama. Senam pagi dan pertandingan persahabatan menjadi sarana untuk menjaga kebugaran sekaligus mempererat kebersamaan antara warga binaan dan petugas. Kegiatan ini juga membantu menciptakan suasana yang positif dan kondusif di lingkungan Lapas.', '1769791149_697cdead54f4c.jpg', 'JJE', 'Aktif', '2026-01-30 10:39:09'),
(9, 'Lapas Gelar Penyuluhan Hukum bagi Warga Binaan', 'Kesehatan', 'Dalam upaya meningkatkan pemahaman hukum, Lapas menyelenggarakan kegiatan penyuluhan yang menghadirkan narasumber dari pihak terkait. Materi yang disampaikan mencakup hak dan kewajiban warga binaan serta pentingnya menaati hukum setelah kembali ke masyarakat. Kegiatan ini diharapkan dapat menumbuhkan kesadaran hukum dan mendorong warga binaan untuk menjalani kehidupan yang lebih baik di masa depan.\r\n\r\nDalam upaya meningkatkan pemahaman hukum, Lapas menyelenggarakan kegiatan penyuluhan yang menghadirkan narasumber dari pihak terkait. Materi yang disampaikan mencakup hak dan kewajiban warga binaan serta pentingnya menaati hukum setelah kembali ke masyarakat. Kegiatan ini diharapkan dapat menumbuhkan kesadaran hukum dan mendorong warga binaan untuk menjalani kehidupan yang lebih baik di masa depan.\r\n\r\nDalam upaya meningkatkan pemahaman hukum, Lapas menyelenggarakan kegiatan penyuluhan yang menghadirkan narasumber dari pihak terkait. Materi yang disampaikan mencakup hak dan kewajiban warga binaan serta pentingnya menaati hukum setelah kembali ke masyarakat. Kegiatan ini diharapkan dapat menumbuhkan kesadaran hukum dan mendorong warga binaan untuk menjalani kehidupan yang lebih baik di masa depan.', '1769792299_baaca09894fd0318.jpg', 'Admin1', 'Aktif', '2026-01-30 10:58:19'),
(10, 'Kunjungan dan Dukungan Keluarga', 'Layanan', 'Kegiatan kunjungan keluarga juga menjadi bagian penting dalam proses pembinaan. Interaksi dengan keluarga memberikan dukungan moral yang besar bagi warga binaan sehingga mereka lebih termotivasi untuk memperbaiki diri. Lapas memfasilitasi kegiatan ini dengan tetap memperhatikan aturan dan keamanan.\r\n\r\nKegiatan kunjungan keluarga juga menjadi bagian penting dalam proses pembinaan. Interaksi dengan keluarga memberikan dukungan moral yang besar bagi warga binaan sehingga mereka lebih termotivasi untuk memperbaiki diri. Lapas memfasilitasi kegiatan ini dengan tetap memperhatikan aturan dan keamanan.', '1769792718_01c06dfc08da8f3a.jpg', 'Admin2', 'Aktif', '2026-01-30 11:05:18'),
(11, 'Pemeriksaan Kesehatan Berkala', 'Kesehatan', 'Dalam upaya menjaga kesehatan, Lapas bekerja sama dengan tenaga medis untuk melaksanakan pemeriksaan kesehatan rutin bagi warga binaan. Pemeriksaan meliputi pengecekan kondisi fisik, konsultasi kesehatan, serta edukasi pola hidup sehat. Langkah ini menunjukkan komitmen Lapas dalam memberikan pelayanan kesehatan yang layak dan memastikan kondisi warga binaan tetap terpantau.', '1769792800_2489618193188680.jpg', 'Herlina', 'Aktif', '2026-01-30 11:06:40'),
(12, 'Penyuluhan Hukum dan Motivasi Diri', 'Kesehatan', 'Lapas menghadirkan narasumber dari instansi terkait untuk memberikan penyuluhan hukum dan motivasi kepada warga binaan. Materi yang disampaikan meliputi pemahaman tentang hukum, hak dan kewajiban warga binaan, serta motivasi untuk menjalani hidup yang lebih baik setelah bebas nanti. Kegiatan ini mendorong tumbuhnya kesadaran hukum dan perubahan pola pikir agar warga binaan tidak mengulangi kesalahan yang sama.', '1769793895_921a331dd65fdb21.jpg', 'Admin1', 'Aktif', '2026-01-30 11:24:55'),
(13, 'Lapas Tutup Sementara, Seluruh Layanan Publik Dihentikan', 'Pengumuman', 'Lembaga Pemasyarakatan (Lapas) untuk sementara waktu menutup seluruh aktivitas pelayanan kepada masyarakat. Penutupan ini dilakukan sebagai bagian dari kebijakan internal guna mendukung kelancaran proses administrasi serta menjaga keamanan dan ketertiban di lingkungan lapas.\r\n\r\nSelama masa penutupan berlangsung, seluruh layanan publik tidak dapat dilayani, termasuk kunjungan, pengurusan administrasi, dan layanan lainnya. Pihak lapas mengimbau kepada masyarakat agar dapat memahami kondisi tersebut dan menyesuaikan jadwal kunjungan maupun keperluan administrasi hingga layanan kembali dibuka.\r\n\r\nInformasi lebih lanjut terkait jadwal pembukaan kembali layanan akan diumumkan melalui saluran resmi lapas. Masyarakat diharapkan terus memantau perkembangan informasi agar tidak terjadi kesalahpahaman.', '1769878494_c292702945bb7193.jpg', 'Kalapas', 'Aktif', '2026-01-31 10:54:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblcontactus`
--

CREATE TABLE `tblcontactus` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` bigint(12) DEFAULT NULL,
  `message` mediumtext DEFAULT NULL,
  `PostingDate` timestamp NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `LastupdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `IsRead` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tblcontactus`
--

INSERT INTO `tblcontactus` (`id`, `fullname`, `email`, `contactno`, `message`, `PostingDate`, `AdminRemark`, `LastupdationDate`, `IsRead`) VALUES
(1, 'Anuj kumar', 'anujk30@test.com', 1425362514, 'This is for testing purposes.   This is for testing purposes.This is for testing purposes.This is for testing purposes.This is for testing purposes.This is for testing purposes.This is for testing purposes.This is for testing purposes.This is for testing purposes.', '2024-04-20 16:52:03', 'Done', '2026-01-27 06:25:51', 1),
(2, 'Anuj kumar', 'ak@gmail.com', 1111122233, 'This is for testing', '2024-04-23 13:13:41', 'Contact the patient', '2024-04-27 13:13:57', 1),
(3, 'dc', 'roby@gmail.com', 90878686200000000, 'dajwbxd', '2026-01-14 18:14:43', 'Done', '2026-01-31 17:44:31', 1),
(4, 'robay', 'rossby@gmail.com', 90878686200000000, 'saya akan membantu mu', '2026-01-18 07:57:48', 'oke', '2026-01-18 08:00:54', 1),
(5, 'JAMAL SAPUTA', 'jamal@gmail.com', 85609468687, 'Tolong untuk pelayanan nya dipercepat ya !!!', '2026-01-26 15:51:00', 'Baik', '2026-01-26 15:51:28', 1),
(6, 'AZKA', 'AZKA@gmail.com', 85609468687, 'Perbaiki Pelayanan di administrasi', '2026-01-26 15:53:03', '.', '2026-01-31 17:45:35', 1),
(7, 'Sigit', 'sigit@gmail.com', 85609468888, 'Perbagus Pelayanan Pada P2u', '2026-01-29 14:53:51', 'Done', '2026-01-29 14:54:20', 1),
(8, 'test1', 'test1@gmail.com', 9090909090909, 'test1', '2026-01-31 17:46:21', 'done', '2026-01-31 17:47:11', 1),
(9, 'test1@gmail.com', 'test1@gmail.com', 9090909090909, 'test1@gmail.com', '2026-01-31 17:46:39', 'done', '2026-01-31 17:47:27', 1),
(10, 'test1@gmail.com', 'test1@gmail.com', 9090909090909, 'test1@gmail.com', '2026-01-31 17:46:57', 'done', '2026-01-31 17:47:41', 1),
(11, 'LEAAL', 'LEAAL@gmail.com', 9090909090909, 'LEAALLEAALLEAALLEAALLEAALLEAALLEAALLEAALLEAAL', '2026-02-01 16:17:02', NULL, NULL, NULL),
(12, 'Robby Hidayattullah', 'robbyhidayattullah@gmail.com', 856094586877, 'Tolong Segerakan Dalam Pelayanan', '2026-02-02 15:53:52', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblinformasi`
--

CREATE TABLE `tblinformasi` (
  `id` int(11) NOT NULL,
  `nama_informasi` varchar(255) NOT NULL,
  `file_pdf` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT current_timestamp(),
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblinformasi`
--

INSERT INTO `tblinformasi` (`id`, `nama_informasi`, `file_pdf`, `deskripsi`, `tanggal_upload`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Laporan Keuangan 2024', 'laporan_keuangan_2024.pdf', 'Laporan keuangan tahunan tahun 2024', '2026-02-01 21:51:09', 'aktif', '2026-02-01 14:51:09', '2026-02-01 14:51:09'),
(2, 'Bukti Pencapaian Program', 'bukti_pencapaian_2024.pdf', 'Dokumentasi pencapaian program kerja tahun 2024', '2026-02-01 21:51:09', 'aktif', '2026-02-01 14:51:09', '2026-02-01 14:51:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblinformasipublik`
--

CREATE TABLE `tblinformasipublik` (
  `id` int(11) NOT NULL,
  `JudulInformasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `NamaFile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TanggalUnggah` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Kategori` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci DEFAULT 'Aktif',
  `UplodedBy` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DownloadCount` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tblinformasipublik`
--

INSERT INTO `tblinformasipublik` (`id`, `JudulInformasi`, `Deskripsi`, `NamaFile`, `TanggalUnggah`, `Kategori`, `Status`, `UplodedBy`, `DownloadCount`, `created_at`, `updated_at`) VALUES
(1, 'LKJIP 2025 SEMESTER 1 LAPAS LUBUKLINGGAU', 'Laporan Kinerja Instansi Pemerintah', '1770055334_78c13f183ec70dc3.pdf', '2026-02-03 01:02:14', 'Bukti Pencapaian', 'Aktif', 'Admin', 0, '2026-02-01 15:23:32', '2026-02-02 18:02:14'),
(2, 'LKJIP 2025 SEMESTER 2 LAPAS LUBUKLINGGAU', 'Laporan Kinerja Instansi Pemerintah', '1770055386_aaea1ef1f3d2a1ed.pdf', '2026-02-03 01:03:06', 'Bukti Pencapaian', 'Aktif', 'Admin', 0, '2026-02-01 16:11:54', '2026-02-02 18:03:06'),
(3, 'RENSTRA LAPAS KELAS IIA LUBUK LINGGAU 2025-2029', 'Rencana Strategi', '1770052632_7e274f6816e413a1.pdf', '2026-02-03 00:17:12', 'Bukti Pencapaian', 'Aktif', 'Admin', 0, '2026-02-02 17:17:12', '2026-02-02 17:17:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblmedicalhistory`
--

CREATE TABLE `tblmedicalhistory` (
  `ID` int(10) NOT NULL,
  `PatientID` int(10) DEFAULT NULL,
  `BloodPressure` varchar(200) DEFAULT NULL,
  `BloodSugar` varchar(200) NOT NULL,
  `Weight` varchar(100) DEFAULT NULL,
  `Temperature` varchar(200) DEFAULT NULL,
  `MedicalPres` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tblmedicalhistory`
--

INSERT INTO `tblmedicalhistory` (`ID`, `PatientID`, `BloodPressure`, `BloodSugar`, `Weight`, `Temperature`, `MedicalPres`, `CreationDate`) VALUES
(1, 2, '80/120', '110', '85', '97', 'Dolo,\r\nLevocit 5mg', '2024-05-16 09:07:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` varchar(200) DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Address` varchar(500) DEFAULT NULL,
  `WhatsApp` varchar(20) DEFAULT NULL,
  `Facebook` varchar(100) DEFAULT NULL,
  `Instagram` varchar(100) DEFAULT NULL,
  `TikTok` varchar(100) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT current_timestamp(),
  `OpenningTime` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `Address`, `WhatsApp`, `Facebook`, `Instagram`, `TikTok`, `UpdationDate`, `OpenningTime`) VALUES
(1, 'aboutus', 'About Us', '<ul style=\"padding: 0px; margin-right: 0px; margin-bottom: 1.313em; margin-left: 1.655em;\" times=\"\" new=\"\" roman\";=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" center;=\"\" background-color:=\"\" rgb(255,=\"\" 246,=\"\" 246);\"=\"\"><li style=\"text-align: left;\">Lembaga Pemasyarakatan Kelas IIA Lubuk Linggau merupakan unit pelaksana teknis di bidang pemasyarakatan yang berada di bawah Kantor Wilayah Kementerian Imigrasi dan Pemasyarakatan Sumatera Selatan. Kami berkomitmen untuk melaksanakan pembinaan dan pembimbingan Warga Binaan Pemasyarakatan melalui pendekatan yang humanis, modern, dan profesional. Dengan mengedepankan prinsip-prinsip rehabilitasi dan reintegrasi sosial, kami berupaya mengubah pola pikir dan perilaku Warga Binaan agar dapat kembali ke masyarakat sebagai individu yang produktif dan bertanggung jawab.</li></ul>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-20 07:21:52', NULL),
(2, 'contactus', 'Contact Details', 'Ulak Lebar, Kecamatan Lubuk Linggau Barat II, Kota Lubuklinggau, Sumatera Selatan 31614', 'kelasalapas64@gmail.com', 85609468687, 'Ulak Lebar, Kecamatan Lubuk Linggau Barat II, Kota Lubuklinggau, Sumatera Selatan 31614', '085609468687', 'LpLubuklinggau2a', 'lplubuklinggau', 'lapas_llg', '2020-05-20 07:24:07', '9 am To 8 Pm');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblpatient`
--

CREATE TABLE `tblpatient` (
  `ID` int(10) NOT NULL,
  `Docid` int(10) DEFAULT NULL,
  `PatientName` varchar(200) DEFAULT NULL,
  `PatientContno` bigint(10) DEFAULT NULL,
  `PatientEmail` varchar(200) DEFAULT NULL,
  `PatientGender` varchar(50) DEFAULT NULL,
  `PatientAdd` mediumtext DEFAULT NULL,
  `PatientAge` int(10) DEFAULT NULL,
  `PatientMedhis` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tblpatient`
--

INSERT INTO `tblpatient` (`ID`, `Docid`, `PatientName`, `PatientContno`, `PatientEmail`, `PatientGender`, `PatientAdd`, `PatientAge`, `PatientMedhis`, `CreationDate`, `UpdationDate`) VALUES
(1, 1, 'Rahul Singyh', 452463210, 'rahul12@gmail.com', 'male', 'NA', 32, 'Fever, Cold', '2024-05-16 05:23:35', NULL),
(2, 1, 'Amit', 4545454545, 'amitk@gmail.com', 'male', 'NA', 45, 'Fever', '2024-05-16 09:01:26', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblpejabat`
--

CREATE TABLE `tblpejabat` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `pangkat_golongan` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `status` enum('aktif','non-aktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblpejabat`
--

INSERT INTO `tblpejabat` (`id`, `nama_lengkap`, `jabatan`, `nip`, `pangkat_golongan`, `foto`, `urutan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nama Kepala Lapas', 'Kepala Lembaga Pemasyarakatan Kelas IIA Lubuk Linggau', '199001012015011001', 'Pembina Tk. I (IV/b)', NULL, 1, 'aktif', '2026-01-16 16:06:34', '2026-01-16 16:06:34'),
(2, 'Nama Wakil Kepala', 'Wakil Kepala Lembaga Pemasyarakatan', '199102022015012002', 'Pembina (IV/a)', NULL, 2, 'aktif', '2026-01-16 16:06:34', '2026-01-16 16:06:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblprofilpejabat`
--

CREATE TABLE `tblprofilpejabat` (
  `id` int(11) NOT NULL,
  `nama_pejabat` varchar(200) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `jabatan` varchar(200) NOT NULL,
  `pangkat_golongan` varchar(100) DEFAULT NULL,
  `pendidikan` varchar(200) DEFAULT NULL,
  `foto_pejabat` varchar(255) DEFAULT NULL,
  `urutan_tampil` int(11) DEFAULT 0,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `tanggal_mulai_jabatan` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `bio_singkat` text DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblprofilpejabat`
--

INSERT INTO `tblprofilpejabat` (`id`, `nama_pejabat`, `nip`, `jabatan`, `pangkat_golongan`, `pendidikan`, `foto_pejabat`, `urutan_tampil`, `status`, `tanggal_mulai_jabatan`, `email`, `no_telepon`, `alamat`, `bio_singkat`, `created_date`, `updated_date`) VALUES
(1, 'Dr. H. Ahmad Fauzi, S.H., M.H.', '197501152000031001', 'Kepala Lembaga Pemasyarakatan', 'Pembina Utama Muda (IV/c)', 'S3 Ilmu Hukum', NULL, 1, 'aktif', NULL, NULL, NULL, NULL, NULL, '2026-01-16 16:29:40', '2026-01-16 16:29:40'),
(2, 'Ir. Budi Santoso, M.M.', '198003202005021002', 'Kepala Seksi Administrasi', 'Pembina (IV/a)', 'S2 Manajemen', NULL, 2, 'aktif', NULL, NULL, NULL, NULL, NULL, '2026-01-16 16:29:40', '2026-01-16 16:29:40'),
(3, 'Dra. Siti Nurhaliza, M.Pd.', '198505102008032001', 'Kepala Seksi Pembinaan', 'Penata Tk.I (III/d)', 'S2 Pendidikan', NULL, 3, 'aktif', NULL, NULL, NULL, NULL, NULL, '2026-01-16 16:29:40', '2026-01-16 16:29:40'),
(4, 'Robby Hidayattullah, S.Kom.', '999999999999', 'Peserta Magang', 'Magang', 'S1 Ilmu Komputer', NULL, 3, 'aktif', NULL, NULL, NULL, NULL, NULL, '2026-01-16 16:29:40', '2026-01-16 16:29:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblstruktur`
--

CREATE TABLE `tblstruktur` (
  `id` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL DEFAULT 'no-image.png',
  `keterangan` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Aktif, 0=Tidak Aktif',
  `tanggal_upload` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tblstruktur`
--

INSERT INTO `tblstruktur` (`id`, `gambar`, `keterangan`, `status`, `tanggal_upload`) VALUES
(1, 'struktur-organisasi-1769707328.jpg', 'Bagan struktur organisasi Lembaga Pemasyarakatan Kelas IIA Lubuk Linggau', 1, '2026-01-30 00:22:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_visi_misi`
--

CREATE TABLE `tbl_visi_misi` (
  `id` int(11) NOT NULL DEFAULT 1,
  `visi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `misi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_visi_misi`
--

INSERT INTO `tbl_visi_misi` (`id`, `visi`, `misi`, `created_at`, `updated_at`) VALUES
(1, 'Terwujudnya Layanan Imigrasi dan Pemasyarakatan yang Modern, Transparan dan Humanis dalam Menciptakan Stabilitas Keamanan Bersama Indonesia Maju menuju Indonesia Emas 2045', 'Mewujudkan pelayanan imigrasi dan pemasyarakatan yang transparan dan berkeadilan yang berorientasi pada kepuasan masyarakat.\r\nMembangun sistem pengawasan keimigrasian yang terintegrasi dan sistem pembinaan yang humanis, produktif dan berketerampilan.\r\nMeningkatkan kompetensi dan profesionalisme sumber daya manusia dalam pelayanan imigrasi dan pemasyarakatan.\r\nMewujudkan tata kelola keimigrasian dan pemasyarakatan yang baik melalui reformasi birokrasi dan kelembagaan.', '2026-01-27 16:14:44', '2026-01-27 16:14:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NULL DEFAULT current_timestamp(),
  `logout` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `userlog`
--

INSERT INTO `userlog` (`id`, `uid`, `username`, `userip`, `loginTime`, `logout`, `status`) VALUES
(1, 1, 'johndoe12@test.com', 0x3a3a3100000000000000000000000000, '2024-05-15 03:41:48', NULL, 1),
(2, 2, 'amitk@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-16 09:08:06', '16-05-2024 02:41:06 PM', 1),
(3, 1, 'johndoe12@test.com', 0x3a3a3100000000000000000000000000, '2026-01-14 07:11:53', NULL, 1),
(4, 1, 'johndoe12@test.com', 0x3a3a3100000000000000000000000000, '2026-01-16 12:04:22', NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `fullName`, `address`, `city`, `gender`, `email`, `password`, `regDate`, `updationDate`) VALUES
(1, 'John Doe', 'A 123 ABC Apartment GZB 201017', 'Ghaziabad', 'male', 'johndoe12@test.com', 'f925916e2754e5e03f75dd58a5733251', '2024-04-20 12:13:56', '2024-05-14 09:28:15'),
(2, 'Amit kumar', 'new Delhi india', 'New Delhi', 'male', 'amitk@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2024-04-21 13:15:32', '2024-05-14 09:28:23');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `doctorslog`
--
ALTER TABLE `doctorslog`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `doctorspecilization`
--
ALTER TABLE `doctorspecilization`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblberita`
--
ALTER TABLE `tblberita`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblcontactus`
--
ALTER TABLE `tblcontactus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblinformasi`
--
ALTER TABLE `tblinformasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblinformasipublik`
--
ALTER TABLE `tblinformasipublik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`Status`),
  ADD KEY `idx_kategori` (`Kategori`),
  ADD KEY `idx_tanggal` (`TanggalUnggah`);
ALTER TABLE `tblinformasipublik` ADD FULLTEXT KEY `ft_judul` (`JudulInformasi`);
ALTER TABLE `tblinformasipublik` ADD FULLTEXT KEY `ft_deskripsi` (`Deskripsi`);

--
-- Indeks untuk tabel `tblmedicalhistory`
--
ALTER TABLE `tblmedicalhistory`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `tblpatient`
--
ALTER TABLE `tblpatient`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `tblpejabat`
--
ALTER TABLE `tblpejabat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblprofilpejabat`
--
ALTER TABLE `tblprofilpejabat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_urutan` (`urutan_tampil`);

--
-- Indeks untuk tabel `tblstruktur`
--
ALTER TABLE `tblstruktur`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_visi_misi`
--
ALTER TABLE `tbl_visi_misi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeks untuk tabel `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `doctorslog`
--
ALTER TABLE `doctorslog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `doctorspecilization`
--
ALTER TABLE `doctorspecilization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `tblberita`
--
ALTER TABLE `tblberita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tblcontactus`
--
ALTER TABLE `tblcontactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tblinformasi`
--
ALTER TABLE `tblinformasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tblinformasipublik`
--
ALTER TABLE `tblinformasipublik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tblmedicalhistory`
--
ALTER TABLE `tblmedicalhistory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tblpatient`
--
ALTER TABLE `tblpatient`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tblpejabat`
--
ALTER TABLE `tblpejabat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tblprofilpejabat`
--
ALTER TABLE `tblprofilpejabat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tblstruktur`
--
ALTER TABLE `tblstruktur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
