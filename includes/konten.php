<?php
/**
 * ISI WEBSITE — SEMUA TULISAN & DATA DIUBAH DI FILE INI.
 *
 * Ubah teks di antara tanda kutip ' '. Jika teksnya mengandung tanda kutip satu, tulis \'
 * Foto: simpan di assets/img/ lalu tulis nama filenya (huruf kecil, tanpa spasi).
 * Menambah jurusan / kegiatan / prestasi: salin satu blok lalu ubah isinya.
 */
return [
    // ---- Identitas ----
    'nama_sekolah'   => 'SMKN 5 PALOPO',
    'slogan'         => 'Unggul • Berkarakter • Siap Kerja',
    'tagline'        => 'Mewujudkan Generasi Unggul, Berkarakter, dan Siap Menghadapi Dunia Kerja',
    'lokasi_singkat' => 'Kota Palopo, Sulawesi Selatan',

    // ---- Gambar hero/banner tiap halaman (file di assets/img/) ----
    'hero' => [
        'beranda' => 'hero.jpg',
        'profil'  => 'hero.jpg',
        'jurusan' => 'jurusan.png',   // dipakai juga di halaman detail jurusan
        'galeri'  => 'hero.jpg',
        'kontak'  => 'hero.jpg',
    ],

    // ---- Halaman Profil ----
    'tentang'        => 'SMKN 5 Palopo adalah sekolah menengah kejuruan yang berkomitmen mencetak lulusan yang kompeten, berkarakter, dan siap kerja. Berdiri sejak tahun 2014, sekolah ini terus berkembang dalam memberikan pendidikan berkualitas dengan dukungan tenaga pendidik yang profesional dan fasilitas yang memadai.',
    'tahun_berdiri'  => '2014',
    'jumlah_siswa'   => '56',
    'jumlah_guru'    => '22',

    // ---- Sejarah, visi, misi ----
    'sejarah' => 'SMKN 5 Palopo didirikan pada tahun 2014 sebagai salah satu sekolah menengah kejuruan di Kota Palopo. Sejak awal berdiri, sekolah ini terus berkomitmen untuk memberikan pendidikan vokasi yang berkualitas dan relevan dengan kebutuhan industri dan dunia kerja.',
    'visi'    => 'menjadi lembaga pendidik dan pelatihan yang bermutu dan profesional serta mampu berprestasi berwawasan internasional sejalan dengan tuntutan ilmu pengetahuan dengan teguh pada nilai.nilai luhur dan budaya.',
    // Satu poin misi per baris
    'misi'    => [
        'Menyelenggarakan pendidikan dan pelatihan di bidang pariwisata secara konsisten sehingga menghasilkan tamatan yang memiliki kompetensi tinggi mampu bersaing di pasar tenaga kerja industri nasional dan internasional',
        'Mengupayakan hasil tamatan yang memiliki kepribadian & ketaqwaan kepada tuhan yang maha esa',
        'Meningkatkan mutu tamatan yang berbudi pekerti luhur dan profesional',
        'Selalu mengusahakan peningkatan sumber daya manusia para pendidik dan pelatih.',
    ],

    // ---- Profil Kepala Sekolah (GANTI isian di bawah dengan data asli) ----
    // Kosongkan ('') baris biodata yang tidak ingin ditampilkan.
    // Foto: simpan di assets/img/ (mis. kepsek.jpg). Jika belum ada, tampil placeholder.
    'kepala_sekolah' => [
        'nama'       => 'Hajaruddin,S.Pd., M.Pd.',
        'jabatan'    => 'Kepala SMKN 5 Palopo',
        'foto'       => 'kepsek.jpg',
        'biodata'    => [
            'NIP'                => '197202012006041020',
            'Tempat, Tgl. Lahir' => 'Mawa 01,february,1972',
            'Pendidikan Terakhir' => 'S2',
            'Masa Jabatan'       => '2017-sekarang',
        ],
        'sambutan'   => 'Selamat datang di website SMKN 5 Palopo. Kami berkomitmen mewujudkan lulusan yang berprestasi dan berakhlak mulia, kompeten di bidangnya, serta siap bersaing di dunia kerja.',
    ],

    // ---- Fasilitas Sekolah (sesuai brosur) ----
    // Menambah fasilitas: salin satu baris, ubah ikon (emoji), nama, dan keterangan.
    'fasilitas' => [
        ['ikon' => '🏫', 'nama' => 'Ruang Belajar',          'ket' => 'Ruang belajar yang nyaman'],
        ['ikon' => '💻', 'nama' => 'Tempat Praktik Jurusan', 'ket' => 'Tempat praktik jurusan TKJ, PHT, dan ULP'],
        ['ikon' => '📚', 'nama' => 'Perpustakaan',           'ket' => 'Perpustakaan sekolah'],
        ['ikon' => '🩺', 'nama' => 'UKS',                    'ket' => 'Unit Kesehatan Sekolah'],
        ['ikon' => '🧑‍🤝‍🧑', 'nama' => 'Ruang OSIS',          'ket' => 'Ruang Organisasi Siswa Intra Sekolah'],
        ['ikon' => '🚩', 'nama' => 'Lapangan Upacara',       'ket' => 'Lapangan upacara'],
        ['ikon' => '🏸', 'nama' => 'Lapangan Bulutangkis',   'ket' => 'Lapangan bulutangkis'],
    ],

    // ---- Kontak ----
    'alamat'     => 'Jl.Andi paso kelurahan mawa kecamatan sendana kota palopo sulawesi selatan',
    'telepon'      => '081774157317',
    'email'        => 'smkn5palopo@gmail.com',
    'media_sosial' => '@smkn5palopo',

    // ---- Jam operasional (halaman Kontak) ----
    'jam_buka_hari'  => 'Senin - Jumat',
    'jam_buka_jam'   => '07.00 - 15.00 WITA',
    'jam_tutup_hari' => 'Sabtu - Minggu',
    'jam_tutup_ket'  => 'Tutup',

    // ---- Link ikon media sosial ----
    'youtube'   => '#',
    'instagram' => 'smkn_5_palopo',
    'facebook'  => 'smknegrilima palopo',

    // ================= PROGRAM KEAHLIAN (JURUSAN) =================
    // Kunci ('tkj', 'tkr', ...) dipakai di alamat halaman detail: jurusan_detail.php?id=tkj
    // Gunakan huruf kecil tanpa spasi untuk kunci baru.
    'jurusan' => [
        'tkj' => [
            'nama'      => 'Teknik Komputer dan Jaringan (TKJ)',
            'deskripsi' => 'Mempelajari jaringan komputer, keamanan jaringan, dan teknologi informasi.',
            'uraian'    => 'Program keahlian Teknik Komputer dan Jaringan (TKJ) membekali siswa dengan kemampuan merakit dan memperbaiki komputer, membangun serta mengelola jaringan, dan mengamankan sistem informasi. Pembelajaran dilakukan dengan praktik langsung agar lulusan siap bekerja di bidang teknologi informasi.',
            'kompetensi' => [
                'Merakit, menginstal, dan memperbaiki komputer',
                'Instalasi dan konfigurasi jaringan LAN, WAN, dan nirkabel',
                'Administrasi server berbasis Linux dan Windows',
                'Keamanan jaringan dan sistem',
                'Dasar pemrograman dan layanan internet',
            ],
            'karier' => [
                'Teknisi jaringan',
                'Administrator jaringan dan sistem',
                'IT support',
                'Teknisi komputer dan data center',
                'Wirausaha di bidang jasa teknologi informasi',
            ],
            'gambar' => 'tkj.jpg',
        ],
        
        'ULP' => [
            'nama'      => 'usaha layanan pariwisata (ULP)',
            'deskripsi' => 'menyusun dan merancang paket wisata inbound(dalam negri).',
            'uraian'    => 'Program keahlian vokasi yang mempelajari cara merencanakan,mengelola,menyelengarakan dan melayani berbagai kebutuhan wisatawan.',
            'kompetensi' => [
                'menyususn paket wistata',
                'manajemen perjalanan',
                'pemasaran pariwisata',
            ],
            'karier' => [
                'Tour planner/Tour designer',
                'Travel consultant',
                'Tour leader/Tour guide',
            ],
            'gambar' => 'dkv.jpg',
        ],
        'hotel' => [
            'nama'      => 'Perhotelan (HOTEL)',
            'deskripsi' => 'Mempelajari layanan perhotelan, tata boga, dan pariwisata.',
            'uraian'    => 'Program keahlian Perhotelan mempelajari pelayanan di hotel dan industri pariwisata. Siswa dilatih memberikan pelayanan prima, mulai dari penerimaan tamu, penyajian makanan dan minuman, hingga kebersihan dan kerapian kamar.',
            'kompetensi' => [
                'Pelayanan tamu di bagian front office',
                'Penyajian makanan dan minuman (food and beverage service)',
                'Kebersihan dan perawatan kamar (housekeeping)',
                'Dasar tata boga',
                'Komunikasi dan pelayanan prima',
            ],
            'karier' => [
                'Resepsionis hotel',
                'Staf food and beverage',
                'Staf housekeeping',
                'Juru masak atau asisten koki',
                'Tenaga kerja di hotel, restoran, dan kapal pesiar',
            ],
            'gambar' => 'hotel.jpg',
        ],
    ],

    // ================= KEGIATAN =================
    // tanggal format TAHUN-BULAN-HARI. Yang tampil di Beranda: 3 kegiatan terbaru.
    'kegiatan' => [
        ['judul' => 'Upacara Hari Sumpah Pemuda Tingkat SMKN 5 Palopo', 'tanggal' => '2025-10-12', 'deskripsi' => 'Upacara peringatan Hari Sumpah Pemuda.', 'foto' => 'kegiatan1.jpg'],
        ['judul' => 'Kegiatan Kunjungan Industri ke PT. Vale Indonesia', 'tanggal' => '2025-10-08', 'deskripsi' => 'Kunjungan industri siswa ke PT. Vale Indonesia.', 'foto' => 'kegiatan2.jpg'],
        ['judul' => 'Lomba Kompetensi Siswa (LKS) Tingkat Kota Palopo', 'tanggal' => '2025-10-05', 'deskripsi' => 'Lomba kompetensi siswa tingkat kota.', 'foto' => 'kegiatan3.jpg'],
    ],

    // ================= PRESTASI =================
    'prestasi' => [
        ['judul' => 'Juara 1 LKS Tingkat Kota Palopo', 'tanggal' => '2025-10-05', 'deskripsi' => 'Siswa SMKN 5 Palopo meraih juara 1.', 'foto' => 'prestasi1.jpg'],
        ['judul' => 'Juara 2 Lomba Desain Grafis', 'tanggal' => '2025-09-20', 'deskripsi' => 'Prestasi siswa jurusan DKV.', 'foto' => 'prestasi2.jpg'],
        ['judul' => 'Juara Harapan Lomba Debat Bahasa Inggris', 'tanggal' => '2025-08-15', 'deskripsi' => 'Prestasi tingkat kota.', 'foto' => 'prestasi3.jpg'],
    ],
];
