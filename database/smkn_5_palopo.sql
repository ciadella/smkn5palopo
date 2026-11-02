-- ============================================================
--  DATABASE WEBSITE SMKN 5 PALOPO  (MySQL 8 / MariaDB 10.4+)
--  Satu file: struktur + data awal. Dipakai oleh website publik DAN panel admin.
--
--  CARA PAKAI: import file ini (HeidiSQL: File > Run SQL file / phpMyAdmin: Import).
--  PERINGATAN: tabel lama (termasuk tabel_* versi sebelumnya) DIHAPUS lalu dibuat ulang.
--  Pesan masuk lama & akun admin ikut dimasukkan kembali di bawah.
--
--  RELASI
--    profil_sekolah 1 ── 1 kontak
--    profil_sekolah 1 ── 1 kepala_sekolah
--    program_keahlian 1 ── N poin_jurusan (kompetensi & prospek karier)
--    v_galeri = gabungan kegiatan + prestasi (dipakai halaman Galeri)
--    pengaturan, fasilitas, pesan, admin = tabel mandiri
-- ============================================================

CREATE DATABASE IF NOT EXISTS `smkn_5_palopo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `smkn_5_palopo`;
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP VIEW  IF EXISTS `v_galeri`;
DROP TABLE IF EXISTS `poin_jurusan`, `program_keahlian`, `kepala_sekolah`, `kontak`, `profil_sekolah`,
                     `pengaturan`, `fasilitas`, `kegiatan`, `prestasi`, `pesan`, `admin`,
                     `tabel_admin`, `tabel_kegiatan`, `tabel_kontak`, `tabel_pesan`, `tabel_prestasi`;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------- Akun admin ----------
CREATE TABLE `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50)  NOT NULL,
  `nama`     varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dibuat`   timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `uq_admin_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- Profil sekolah (induk) ----------
CREATE TABLE `profil_sekolah` (
  `id_profil`     int NOT NULL AUTO_INCREMENT,
  `nama_sekolah`  varchar(150) NOT NULL,
  `tentang`       text,
  `sejarah`       text,
  `visi`          text,
  `misi`          text COMMENT 'satu poin per baris',
  `tahun_berdiri` smallint DEFAULT NULL,
  `jumlah_siswa`  int DEFAULT NULL,
  `jumlah_guru`   int DEFAULT NULL,
  PRIMARY KEY (`id_profil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `kepala_sekolah` (
  `id_kepsek`        int NOT NULL AUTO_INCREMENT,
  `id_profil`        int NOT NULL,
  `nama`             varchar(150) NOT NULL,
  `jabatan`          varchar(100) DEFAULT NULL,
  `foto`             varchar(100) DEFAULT NULL COMMENT 'file di assets/img/umum/',
  `nip`              varchar(30)  DEFAULT NULL,
  `tempat_tgl_lahir` varchar(100) DEFAULT NULL,
  `pendidikan`       varchar(50)  DEFAULT NULL,
  `masa_jabatan`     varchar(50)  DEFAULT NULL,
  `sambutan`         text,
  PRIMARY KEY (`id_kepsek`),
  UNIQUE KEY `uq_kepsek_profil` (`id_profil`),
  CONSTRAINT `fk_kepsek_profil` FOREIGN KEY (`id_profil`) REFERENCES `profil_sekolah` (`id_profil`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `kontak` (
  `id_kontak`      int NOT NULL AUTO_INCREMENT,
  `id_profil`      int NOT NULL,
  `alamat`         varchar(255) DEFAULT NULL,
  `telpon`         varchar(30)  DEFAULT NULL,
  `email`          varchar(120) DEFAULT NULL,
  `media_sosial`   varchar(100) DEFAULT NULL,
  `whatsapp`       varchar(20)  DEFAULT NULL COMMENT 'nomor tujuan form kontak, format 62xxxxxxxxxx',
  `jam_buka_hari`  varchar(50)  DEFAULT NULL,
  `jam_buka_jam`   varchar(50)  DEFAULT NULL,
  `jam_tutup_hari` varchar(50)  DEFAULT NULL,
  `jam_tutup_ket`  varchar(50)  DEFAULT NULL,
  `youtube`        varchar(255) DEFAULT NULL,
  `instagram`      varchar(255) DEFAULT NULL,
  `facebook`       varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kontak`),
  UNIQUE KEY `uq_kontak_profil` (`id_profil`),
  CONSTRAINT `fk_kontak_profil` FOREIGN KEY (`id_profil`) REFERENCES `profil_sekolah` (`id_profil`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- Pengaturan tampilan (slogan, tagline, logo, banner) ----------
CREATE TABLE `pengaturan` (
  `kunci`    varchar(50)  NOT NULL,
  `nilai`    text,
  `label`    varchar(100) NOT NULL,
  `tipe`     varchar(10)  NOT NULL DEFAULT 'text' COMMENT 'text | textarea | image',
  `kelompok` varchar(50)  NOT NULL DEFAULT 'Umum',
  `urutan`   int NOT NULL DEFAULT 0,
  PRIMARY KEY (`kunci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `fasilitas` (
  `id_fasilitas` int NOT NULL AUTO_INCREMENT,
  `ikon`       varchar(20)  DEFAULT NULL COMMENT 'emoji',
  `nama`       varchar(100) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `urutan`     int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_fasilitas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- Program keahlian + poinnya ----------
CREATE TABLE `program_keahlian` (
  `id_jurusan`        int NOT NULL AUTO_INCREMENT,
  `slug`              varchar(50)  NOT NULL COMMENT 'dipakai di URL: jurusan_detail.php?id=tkj',
  `nama_jurusan`      varchar(150) NOT NULL,
  `deskripsi`         text,
  `deskripsi_lengkap` text,
  `gambar`            varchar(100) DEFAULT NULL COMMENT 'file di assets/img/jurusan/',
  `urutan`            int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_jurusan`),
  UNIQUE KEY `uq_jurusan_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `poin_jurusan` (
  `id_poin`    int NOT NULL AUTO_INCREMENT,
  `id_jurusan` int NOT NULL,
  `jenis`      varchar(10)  NOT NULL COMMENT 'kompetensi | karier',
  `isi`        varchar(255) NOT NULL,
  `urutan`     int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_poin`),
  KEY `idx_poin_jurusan` (`id_jurusan`, `jenis`, `urutan`),
  CONSTRAINT `fk_poin_jurusan` FOREIGN KEY (`id_jurusan`) REFERENCES `program_keahlian` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- Kegiatan & prestasi (kolom sengaja sama agar bisa digabung jadi galeri) ----------
CREATE TABLE `kegiatan` (
  `id_kegiatan` int NOT NULL AUTO_INCREMENT,
  `judul`     varchar(200) NOT NULL,
  `tanggal`   date NOT NULL,
  `deskripsi` text,
  `foto`      varchar(100) DEFAULT NULL COMMENT 'file di assets/img/kegiatan/',
  PRIMARY KEY (`id_kegiatan`),
  KEY `idx_kegiatan_tanggal` (`tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `prestasi` (
  `id_prestasi` int NOT NULL AUTO_INCREMENT,
  `judul`     varchar(200) NOT NULL,
  `tanggal`   date NOT NULL,
  `deskripsi` text,
  `foto`      varchar(100) DEFAULT NULL COMMENT 'file di assets/img/prestasi/',
  PRIMARY KEY (`id_prestasi`),
  KEY `idx_prestasi_tanggal` (`tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- Pesan dari form kontak ----------
CREATE TABLE `pesan` (
  `id_pesan` int NOT NULL AUTO_INCREMENT,
  `nama`   varchar(100) NOT NULL,
  `email`  varchar(120) NOT NULL,
  `isi`    text NOT NULL,
  `dibaca` tinyint(1) NOT NULL DEFAULT 0,
  `dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pesan`),
  KEY `idx_pesan_dibuat` (`dibuat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- Galeri = kegiatan + prestasi ----------
CREATE VIEW `v_galeri` AS
  SELECT 'Kegiatan' AS kategori, 'kegiatan' AS folder, id_kegiatan AS id, judul, tanggal, deskripsi, foto FROM kegiatan
  UNION ALL
  SELECT 'Prestasi', 'prestasi', id_prestasi, judul, tanggal, deskripsi, foto FROM prestasi;

-- ============================================================
--  DATA AWAL
-- ============================================================
-- Akun admin awal: username admin / password admin123 (segera ganti lewat menu Akun & Password)
INSERT INTO `admin` (`id_admin`, `username`, `nama`, `password`, `dibuat`) VALUES
(1, 'admin', 'Administrator', '$2y$10$QEX9MvR9ISDUMHShmraaxOYSXsu6J.sPqs0dxvmxvkhW4LEPILZTm', '2026-11-02 06:19:49');

INSERT INTO `profil_sekolah` (`id_profil`, `nama_sekolah`, `tentang`, `sejarah`, `visi`, `misi`, `tahun_berdiri`, `jumlah_siswa`, `jumlah_guru`) VALUES
(1, 'SMKN 5 PALOPO', 'SMKN 5 Palopo adalah sekolah menengah kejuruan yang berkomitmen mencetak lulusan yang kompeten, berkarakter, dan siap kerja. Berdiri sejak tahun 2014, sekolah ini terus berkembang dalam memberikan pendidikan berkualitas dengan dukungan tenaga pendidik yang profesional dan fasilitas yang memadai.', 'SMKN 5 Palopo didirikan pada tahun 2014 sebagai salah satu sekolah menengah kejuruan di Kota Palopo. Sejak awal berdiri, sekolah ini terus berkomitmen untuk memberikan pendidikan vokasi yang berkualitas dan relevan dengan kebutuhan industri dan dunia kerja.', 'Menjadi lembaga pendidikan dan pelatihan yang bermutu dan profesional serta mampu berprestasi, berwawasan internasional, sejalan dengan tuntutan ilmu pengetahuan, dengan teguh pada nilai-nilai luhur dan budaya.', 'Menyelenggarakan pendidikan dan pelatihan di bidang pariwisata secara konsisten sehingga menghasilkan tamatan yang memiliki kompetensi tinggi mampu bersaing di pasar tenaga kerja industri nasional dan internasional\nMengupayakan hasil tamatan yang memiliki kepribadian dan ketaqwaan kepada Tuhan Yang Maha Esa\nMeningkatkan mutu tamatan yang berbudi pekerti luhur dan profesional\nSelalu mengusahakan peningkatan sumber daya manusia para pendidik dan pelatih.', 2014, 56, 22);

INSERT INTO `kepala_sekolah` (`id_kepsek`, `id_profil`, `nama`, `jabatan`, `foto`, `nip`, `tempat_tgl_lahir`, `pendidikan`, `masa_jabatan`, `sambutan`) VALUES
(1, 1, 'Hajaruddin, S.Pd., M.Pd.', 'Kepala SMKN 5 Palopo', 'kepsek.jpg', '197202012006041020', 'Mawa, 01 Februari 1972', 'S2', '2017 - sekarang', 'Selamat datang di website SMKN 5 Palopo. Kami berkomitmen mewujudkan lulusan yang berprestasi dan berakhlak mulia, kompeten di bidangnya, serta siap bersaing di dunia kerja.');

INSERT INTO `kontak` (`id_kontak`, `id_profil`, `alamat`, `telpon`, `email`, `media_sosial`, `whatsapp`, `jam_buka_hari`, `jam_buka_jam`, `jam_tutup_hari`, `jam_tutup_ket`, `youtube`, `instagram`, `facebook`) VALUES
(1, 1, 'Jl. Andi Paso, Kelurahan Mawa, Kecamatan Sendana, Kota Palopo, Sulawesi Selatan', '081356401150', 'smkn5palopo@gmail.com', '@smkn_5_palopo', '6281774157317', 'Senin - Jumat', '07.00 - 15.00 WITA', 'Sabtu - Minggu', 'Tutup', 'https://youtube.com/@smkn5palopo', 'https://www.instagram.com/smkn_5_palopo', 'https://www.facebook.com/share/1GqjmXybTP/');

INSERT INTO `pengaturan` (`kunci`, `nilai`, `label`, `tipe`, `kelompok`, `urutan`) VALUES
('slogan', 'Unggul • Berkarakter • Siap Kerja', 'Slogan', 'text', 'Identitas', 1),
('tagline', 'Mewujudkan Generasi Unggul, Berkarakter, dan Siap Menghadapi Dunia Kerja', 'Tagline (teks di banner Beranda)', 'textarea', 'Identitas', 2),
('lokasi_singkat', 'Kota Palopo, Sulawesi Selatan', 'Lokasi singkat (footer & peta)', 'text', 'Identitas', 3),
('logo', 'logo.png', 'Logo sekolah', 'image', 'Gambar', 1),
('gambar_gedung', 'gedung.jpg', 'Foto gedung (halaman Profil)', 'image', 'Gambar', 2),
('hero_beranda', 'hero.jpg', 'Banner halaman Beranda', 'image', 'Gambar', 3),
('hero_profil', 'hero.jpg', 'Banner halaman Profil', 'image', 'Gambar', 4),
('hero_jurusan', 'jurusan.png', 'Banner halaman Jurusan', 'image', 'Gambar', 5),
('hero_galeri', 'hero.jpg', 'Banner halaman Galeri', 'image', 'Gambar', 6),
('hero_kontak', 'hero.jpg', 'Banner halaman Kontak', 'image', 'Gambar', 7);

INSERT INTO `fasilitas` (`ikon`, `nama`, `keterangan`, `urutan`) VALUES
('🏫', 'Ruang Belajar', 'Ruang belajar yang nyaman', 1),
('💻', 'Tempat Praktik Jurusan', 'Tempat praktik jurusan TKJ, PHT, dan ULP', 2),
('📚', 'Perpustakaan', 'Perpustakaan sekolah', 3),
('🩺', 'UKS', 'Unit Kesehatan Sekolah', 4),
('🧑‍🤝‍🧑', 'Ruang OSIS', 'Ruang Organisasi Siswa Intra Sekolah', 5),
('🚩', 'Lapangan Upacara', 'Lapangan upacara', 6),
('🏸', 'Lapangan Bulutangkis', 'Lapangan bulutangkis', 7);

INSERT INTO `program_keahlian` (`id_jurusan`, `slug`, `nama_jurusan`, `deskripsi`, `deskripsi_lengkap`, `gambar`, `urutan`) VALUES
(1, 'tkj', 'Teknik Komputer dan Jaringan (TKJ)', 'Mempelajari jaringan komputer, keamanan jaringan, dan teknologi informasi.', 'Program keahlian Teknik Komputer dan Jaringan (TKJ) membekali siswa dengan kemampuan merakit dan memperbaiki komputer, membangun serta mengelola jaringan, dan mengamankan sistem informasi. Pembelajaran dilakukan dengan praktik langsung agar lulusan siap bekerja di bidang teknologi informasi.', 'tkj.jpg', 1),
(2, 'ulp', 'Usaha Layanan Pariwisata (ULP)', 'Menyusun dan merancang paket wisata inbound (dalam negeri).', 'Program keahlian vokasi yang mempelajari cara merencanakan, mengelola, menyelenggarakan, dan melayani berbagai kebutuhan wisatawan.', 'ulp.jpg', 2),
(3, 'hotel', 'Perhotelan (HOTEL)', 'Mempelajari layanan perhotelan, tata boga, dan pariwisata.', 'Program keahlian Perhotelan mempelajari pelayanan di hotel dan industri pariwisata. Siswa dilatih memberikan pelayanan prima, mulai dari penerimaan tamu, penyajian makanan dan minuman, hingga kebersihan dan kerapian kamar.', 'hotel.jpg', 3);

INSERT INTO `poin_jurusan` (`id_jurusan`, `jenis`, `isi`, `urutan`) VALUES
(1, 'kompetensi', 'Merakit, menginstal, dan memperbaiki komputer', 1),
(1, 'kompetensi', 'Instalasi dan konfigurasi jaringan LAN, WAN, dan nirkabel', 2),
(1, 'kompetensi', 'Administrasi server berbasis Linux dan Windows', 3),
(1, 'kompetensi', 'Keamanan jaringan dan sistem', 4),
(1, 'kompetensi', 'Dasar pemrograman dan layanan internet', 5),
(1, 'karier', 'Teknisi jaringan', 1),
(1, 'karier', 'Administrator jaringan dan sistem', 2),
(1, 'karier', 'IT support', 3),
(1, 'karier', 'Teknisi komputer dan data center', 4),
(1, 'karier', 'Wirausaha di bidang jasa teknologi informasi', 5),
(2, 'kompetensi', 'Menyusun paket wisata', 1),
(2, 'kompetensi', 'Manajemen perjalanan', 2),
(2, 'kompetensi', 'Pemasaran pariwisata', 3),
(2, 'karier', 'Tour planner/Tour designer', 1),
(2, 'karier', 'Travel consultant', 2),
(2, 'karier', 'Tour leader/Tour guide', 3),
(3, 'kompetensi', 'Pelayanan tamu di bagian front office', 1),
(3, 'kompetensi', 'Penyajian makanan dan minuman (food and beverage service)', 2),
(3, 'kompetensi', 'Kebersihan dan perawatan kamar (housekeeping)', 3),
(3, 'kompetensi', 'Dasar tata boga', 4),
(3, 'kompetensi', 'Komunikasi dan pelayanan prima', 5),
(3, 'karier', 'Resepsionis hotel', 1),
(3, 'karier', 'Staf food and beverage', 2),
(3, 'karier', 'Staf housekeeping', 3),
(3, 'karier', 'Juru masak atau asisten koki', 4),
(3, 'karier', 'Tenaga kerja di hotel, restoran, dan kapal pesiar', 5);

INSERT INTO `kegiatan` (`judul`, `tanggal`, `deskripsi`, `foto`) VALUES
('Upacara Hari Sumpah Pemuda Tingkat SMKN 5 Palopo', '2025-10-12', 'Upacara peringatan Hari Sumpah Pemuda.', 'kegiatan1.jpg'),
('Kegiatan Kunjungan Industri ke PT. Vale Indonesia', '2025-10-08', 'Kunjungan industri siswa ke PT. Vale Indonesia.', 'kegiatan2.jpg'),
('Kegiatan Jumat Bersih', '2025-10-05', 'Kegiatan jumat bersih.', 'kegiatan3.jpg');

INSERT INTO `prestasi` (`judul`, `tanggal`, `deskripsi`, `foto`) VALUES
('Juara 1 LKS Tingkat Kota Palopo', '2025-10-05', 'Prestasi siswa SMKN 5 Palopo.', 'prestasi1.jpg'),
('Juara 2 Lomba Resensi Buku Tingkat Kota Palopo', '2025-09-20', 'Prestasi siswa SMKN 5 Palopo.', 'prestasi2.jpg'),
('Juara Harapan Penulis Terbaik Tingkat Nasional', '2025-08-15', 'Prestasi guru SMKN 5 Palopo.', 'prestasi3.jpg');

INSERT INTO `pesan` (`id_pesan`, `nama`, `email`, `isi`, `dibuat`) VALUES
(1, 'cia', 'Fausiafdelaaa@gmail.com', 'hai', '2026-10-28 13:57:23'),
(2, 'cia', 'Fausiafdelaaa@gmail.com', 'hai', '2026-10-29 01:21:10'),
(3, 'nisa', 'Fausiafdelaaa@gmail.com', 'hIAHHS', '2026-10-29 03:17:32'),
(4, 'LISA', 'Fausiafdelaaa@gmail.com', 'SAYA MAU DAFTAR', '2026-10-29 03:38:20'),
(5, 'LISA', 'Fausiafdelaaa@gmail.com', 'HALO SAYA MAU DAFTAR', '2026-10-29 03:43:47'),
(6, 'mega', 'Fausiafdelaaa@gmail.com', 'halo cia adakah seratus', '2026-10-30 05:16:33');
