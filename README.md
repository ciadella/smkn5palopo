# Website SMKN 5 Palopo

Website profil sekolah SMKN 5 Palopo berbasis **PHP (PDO) + MySQL**.
Berisi halaman Beranda, Profil, Jurusan, Galeri, dan Kontak (form pesan tersimpan ke database).

## Teknologi
- PHP 8+ (PDO)
- MySQL / MariaDB
- HTML, CSS, JavaScript
- Server lokal: XAMPP atau Laragon

## Struktur Folder
```
smkn5palopo-website/
├── index.php          # Beranda
├── profil.php         # Profil sekolah
├── jurusan.php        # Program keahlian
├── galeri.php         # Galeri kegiatan & prestasi
├── kontak.php         # Kontak + form pesan
├── includes/
│   ├── config.php     # Koneksi database & fungsi bantu
│   ├── teks.php       # Teks tetap website (slogan, visi, kontak, dll.)
│   ├── header.php
│   └── footer.php
├── assets/
│   ├── css/style.css
│   ├── js/main.js
│   └── img/           # Foto (hero, gedung, kegiatan, prestasi, jurusan)
├── database/
│   ├── smkn5palopo.sql   # Struktur + data awal database
│   ├── tambahan.sql      # Tabel tabel_pesan (form kontak)
│   └── data_contoh.sql   # Data contoh (opsional)
├── README.md
└── .gitignore
```

## Cara Menjalankan
1. Salin folder proyek ke `htdocs` (XAMPP) atau `www` (Laragon).
2. Jalankan **Apache** dan **MySQL**.
3. Buat database `smkn_5_palopo`, lalu import lewat phpMyAdmin (tab **Import**), berurutan:
   1. `database/smkn5palopo.sql`
   2. `database/tambahan.sql` (wajib)
   3. `database/data_contoh.sql` (opsional, jika tabel masih kosong)
4. Sesuaikan host/port/user/password di `includes/config.php`
   (bawaan: `127.0.0.1`, port `3307`, user `root`, tanpa password — ubah port ke `3306` jika MySQL Anda memakai port standar).
5. Buka `http://localhost/smkn5palopo-website/`.

## Mengubah Isi Website
| Isi | Lokasi |
|---|---|
| Nama sekolah, sejarah, visi, misi, alamat | tabel `profil_sekolah` |
| Jurusan | tabel `program_keahlian` |
| Kegiatan | tabel `tabel_kegiatan` |
| Prestasi | tabel `tabel_prestasi` |
| Alamat, telepon, email, media sosial | tabel `tabel_kontak` |
| Slogan, tagline, tentang, jumlah siswa/guru, jam operasional, link sosmed | `includes/teks.php` |

Misi: satu baris = satu poin.

## Foto
Kolom foto di database berisi **nama file** (huruf kecil, tanpa spasi), misalnya `kegiatan1.jpg`,
dan filenya diletakkan di `assets/img/`. Jika file belum ada, tampil placeholder biru.
File tetap: `logo.png`, `hero.jpg`, `gedung.jpg`.

## Catatan
- Nama file gambar memakai huruf kecil semua agar tetap terbaca di server Linux/hosting.
