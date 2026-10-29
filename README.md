# Website SMKN 5 Palopo

Website profil sekolah berbasis **PHP**. Halaman: Beranda, Profil, Jurusan (+ detail), Galeri, dan Kontak.
Semua isi website ada di **satu file**: `includes/konten.php`. Database hanya dipakai untuk menyimpan pesan dari form kontak.

## Struktur Folder
```
smkn5palopo-website/
├── index.php            # Beranda
├── profil.php           # Profil sekolah
├── jurusan.php          # Daftar program keahlian
├── jurusan_detail.php   # Detail satu jurusan (tombol Selengkapnya)
├── galeri.php           # Galeri kegiatan & prestasi
├── kontak.php           # Kontak + form pesan
├── includes/
│   ├── konten.php       # ★ SEMUA ISI WEBSITE (teks, jurusan, kegiatan, prestasi)
│   ├── config.php       # Pengaturan database (pesan) & fungsi bantu
│   ├── header.php
│   └── footer.php
├── assets/
│   ├── css/style.css
│   ├── js/main.js
│   └── img/             # Foto (logo, hero, gedung, kegiatan, prestasi, jurusan)
├── database/
│   └── pesan.sql        # Membuat database + tabel pesan (form kontak)
├── README.md
└── .gitignore
```

## Cara Menjalankan (Laragon / XAMPP)
1. Salin folder proyek ke `C:\laragon\www\` (Laragon) atau `htdocs` (XAMPP).
2. Jalankan **Apache** dan **MySQL**.
3. Import `database/pesan.sql` (HeidiSQL: *File → Run SQL file…*, atau phpMyAdmin: tab *Import*).
   Langkah ini hanya diperlukan agar form kontak bisa menyimpan pesan. Halaman lain tampil tanpa database.
4. Jika perlu, sesuaikan port/user/password di `includes/config.php` (bawaan: port `3306`, user `root`, tanpa password).
5. Buka `http://localhost/smkn5palopo-website/`.

## Mengubah Isi Website — semuanya di `includes/konten.php`
| Isi | Bagian di konten.php |
|---|---|
| Nama sekolah, slogan, tagline | `nama_sekolah`, `slogan`, `tagline` |
| Tentang, tahun berdiri, jumlah siswa/guru | `tentang`, `tahun_berdiri`, `jumlah_siswa`, `jumlah_guru` |
| Sejarah, visi, misi | `sejarah`, `visi`, `misi` (satu poin per baris) |
| Alamat, telepon, email, jam operasional, link sosmed | `alamat`, `telepon`, `email`, `jam_*`, `youtube`, `instagram`, `facebook` |
| Gambar hero/banner tiap halaman | `hero` |
| Jurusan + halaman detail | `jurusan` (nama, deskripsi, uraian, kompetensi, karier, gambar) |
| Kegiatan | `kegiatan` |
| Prestasi | `prestasi` |

Untuk menambah jurusan/kegiatan/prestasi, salin satu blok lalu ubah isinya.
Simpan file, lalu refresh browser.

## Foto
Simpan di `assets/img/` dengan nama huruf kecil tanpa spasi (mis. `kegiatan4.jpg`), lalu tulis nama filenya
di `konten.php`. Jika file belum ada, tampil placeholder biru. File tetap: `logo.png` dan `gedung.jpg` (foto di halaman Profil). Gambar hero tiap halaman diatur di bagian `hero` pada `konten.php`.

## Melihat Pesan Masuk
Buka HeidiSQL/phpMyAdmin → database `smkn_5_palopo` → tabel `tabel_pesan`.
