-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 29, 2026 at 04:08 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smkn_5_palopo`
--

-- --------------------------------------------------------

--
-- Table structure for table `profil_sekolah`
--

CREATE TABLE `profil_sekolah` (
  `id_profil` int NOT NULL,
  `nama_sekolah` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `sejarah` text COLLATE utf8mb4_general_ci,
  `visi` text COLLATE utf8mb4_general_ci,
  `misi` text COLLATE utf8mb4_general_ci,
  `alamat` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil_sekolah`
--

INSERT INTO `profil_sekolah` (`id_profil`, `nama_sekolah`, `sejarah`, `visi`, `misi`, `alamat`) VALUES
(1, 'SMKN 5 PALOPO', 'SMKN 5 Palopo didirikan pada tahun 2008 sebagai salah satu sekolah menengah kejuruan di Kota Palopo. Sejak awal berdiri, sekolah ini terus berkomitmen untuk memberikan pendidikan vokasi yang berkualitas dan relevan dengan kebutuhan industri dan dunia kerja.', 'Menjadi sekolah menengah kejuruan yang unggul, berkarakter, dan berdaya saing di tingkat nasional.', 'Menyelenggarakan pendidikan berkualitas.\nMengembangkan kompetensi siswa sesuai kebutuhan dunia kerja.\nMenanamkan nilai-nilai karakter dan budaya kerja.\nMeningkatkan sarana dan prasarana pendidikan.', 'Jl. Pendidikan No. 1, Boting, Kec. Wara, Kota Palopo, Sulawesi Selatan');

-- --------------------------------------------------------

--
-- Table structure for table `program_keahlian`
--

CREATE TABLE `program_keahlian` (
  `id_jurusan` int NOT NULL,
  `nama_jurusan` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `deskripsi_lengkap` text COLLATE utf8mb4_general_ci,
  `kompetensi` text COLLATE utf8mb4_general_ci,
  `prospek_karir` text COLLATE utf8mb4_general_ci,
  `gambar` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_keahlian`
--

INSERT INTO `program_keahlian` (`id_jurusan`, `nama_jurusan`, `deskripsi`, `deskripsi_lengkap`, `kompetensi`, `prospek_karir`, `gambar`) VALUES
(1, 'Teknik Komputer dan Jaringan (TKJ)', 'Mempelajari jaringan komputer, keamanan jaringan, dan teknologi informasi.', 'Program keahlian Teknik Komputer dan Jaringan (TKJ) membekali siswa dengan kemampuan merakit dan memperbaiki komputer, membangun serta mengelola jaringan, dan mengamankan sistem informasi. Pembelajaran dilakukan dengan praktik langsung agar lulusan siap bekerja di bidang teknologi informasi.', 'Merakit, menginstal, dan memperbaiki komputer\nInstalasi dan konfigurasi jaringan LAN, WAN, dan nirkabel\nAdministrasi server berbasis Linux dan Windows\nKeamanan jaringan dan sistem\nDasar pemrograman dan layanan internet', 'Teknisi jaringan\nAdministrator jaringan dan sistem\nIT support\nTeknisi komputer dan data center\nWirausaha di bidang jasa teknologi informasi', 'tkj.jpg'),
(5, 'Desain Komunikasi Visual (DKV)', 'Mempelajari desain grafis, multimedia, dan komunikasi visual.', 'Program keahlian Desain Komunikasi Visual (DKV) mengembangkan kreativitas siswa dalam menyampaikan pesan melalui gambar, tipografi, foto, dan video. Siswa belajar memakai perangkat desain digital untuk membuat karya yang siap dipakai di industri kreatif.', 'Desain grafis dan tipografi\nIlustrasi dan desain digital\nFotografi dan videografi\nEditing video dan animasi dasar\nDesain identitas visual dan media promosi', 'Desainer grafis\nEditor video dan fotografer\nPembuat konten digital\nDesainer antarmuka (UI)\nWirausaha di bidang percetakan dan kreatif', 'dkv.jpg'),
(6, 'Perhotelan (HOTEL)', 'Mempelajari layanan perhotelan, tata boga, dan parhiwata.', 'Program keahlian Perhotelan mempelajari pelayanan di hotel dan industri pariwisata. Siswa dilatih memberikan pelayanan prima, mulai dari penerimaan tamu, penyajian makanan dan minuman, hingga kebersihan dan kerapian kamar.', 'Pelayanan tamu di bagian front office\nPenyajian makanan dan minuman (food and beverage service)\nKebersihan dan perawatan kamar (housekeeping)\nDasar tata boga\nKomunikasi dan pelayanan prima', 'Resepsionis hotel\nStaf food and beverage\nStaf housekeeping\nJuru masak atau asisten koki\nTenaga kerja di hotel, restoran, dan kapal pesiar', 'hotel.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kegiatan`
--

CREATE TABLE `tabel_kegiatan` (
  `id_kegiatan` int NOT NULL,
  `judul_kegiatan` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `foto` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_kegiatan`
--

INSERT INTO `tabel_kegiatan` (`id_kegiatan`, `judul_kegiatan`, `tanggal`, `deskripsi`, `foto`) VALUES
(1, 'Upacara Hari Sumpah Pemuda Tingkat SMKN 5 Palopo', '2025-10-12', 'Upacara peringatan Hari Sumpah Pemuda.', 'kegiatan1.jpg'),
(2, 'Kegiatan Kunjungan Industri ke PT. Vale Indonesia', '2025-10-08', 'Kunjungan industri siswa ke PT. Vale Indonesia.', 'kegiatan2.jpg'),
(3, 'Lomba Kompetensi Siswa (LKS) Tingkat Kota Palopo', '2025-10-05', 'Lomba kompetensi siswa tingkat kota.', 'kegiatan3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kontak`
--

CREATE TABLE `tabel_kontak` (
  `id_kontak` int NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telpon` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `media_sosial` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_kontak`
--

INSERT INTO `tabel_kontak` (`id_kontak`, `alamat`, `telpon`, `email`, `media_sosial`) VALUES
(1, 'Jl. Pendidikan No. 1, Boting, Kec. Wara, Kota Palopo, Sulawesi Selatan', '(0471) 325xxx', 'smkn5palopo@gmail.com', '@smkn5palopo');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pesan`
--

CREATE TABLE `tabel_pesan` (
  `id_pesan` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci NOT NULL,
  `dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_pesan`
--

INSERT INTO `tabel_pesan` (`id_pesan`, `nama`, `email`, `isi`, `dibuat`) VALUES
(1, 'cia', 'Fausiafdelaaa@gmail.com', 'hai', '2026-10-28 13:57:23'),
(2, 'cia', 'Fausiafdelaaa@gmail.com', 'hai', '2026-10-29 01:21:10'),
(3, 'nisa', 'Fausiafdelaaa@gmail.com', 'hIAHHS', '2026-10-29 03:17:32'),
(4, 'LISA', 'Fausiafdelaaa@gmail.com', 'SAYA MAU DAFTAR', '2026-10-29 03:38:20'),
(5, 'LISA', 'Fausiafdelaaa@gmail.com', 'HALO SAYA MAU DAFTAR', '2026-10-29 03:43:47');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_prestasi`
--

CREATE TABLE `tabel_prestasi` (
  `id_prestasi` int NOT NULL,
  `nama_prestasi` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `gambar` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_prestasi`
--

INSERT INTO `tabel_prestasi` (`id_prestasi`, `nama_prestasi`, `tanggal`, `deskripsi`, `gambar`) VALUES
(1, 'Juara 1 LKS Tingkat Kota Palopo', '2025-10-05', 'Siswa SMKN 5 Palopo meraih juara 1.', 'prestasi1.jpg'),
(2, 'Juara 2 Lomba Desain Grafis', '2025-09-20', 'Prestasi siswa jurusan DKV.', 'prestasi2.jpg'),
(3, 'Juara Harapan Lomba Debat Bahasa Inggris', '2025-08-15', 'Prestasi tingkat kota.', 'prestasi3.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profil_sekolah`
--
ALTER TABLE `profil_sekolah`
  ADD PRIMARY KEY (`id_profil`);

--
-- Indexes for table `program_keahlian`
--
ALTER TABLE `program_keahlian`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `tabel_kegiatan`
--
ALTER TABLE `tabel_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `tabel_kontak`
--
ALTER TABLE `tabel_kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `tabel_pesan`
--
ALTER TABLE `tabel_pesan`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `tabel_prestasi`
--
ALTER TABLE `tabel_prestasi`
  ADD PRIMARY KEY (`id_prestasi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profil_sekolah`
--
ALTER TABLE `profil_sekolah`
  MODIFY `id_profil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `program_keahlian`
--
ALTER TABLE `program_keahlian`
  MODIFY `id_jurusan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tabel_kegiatan`
--
ALTER TABLE `tabel_kegiatan`
  MODIFY `id_kegiatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tabel_kontak`
--
ALTER TABLE `tabel_kontak`
  MODIFY `id_kontak` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tabel_pesan`
--
ALTER TABLE `tabel_pesan`
  MODIFY `id_pesan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tabel_prestasi`
--
ALTER TABLE `tabel_prestasi`
  MODIFY `id_prestasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
