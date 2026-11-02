# Website SMKN 5 Palopo

Website profil sekolah (PHP + MySQL) dengan panel admin. **Semua isi website disimpan di database** dan
diubah lewat panel admin — website publik dan admin memakai config, koneksi database, dan folder gambar yang sama.

## Struktur Folder
```
smkn5palopo/
├── index.php  profil.php  jurusan.php  jurusan_detail.php  galeri.php  kontak.php   ← halaman website
├── config/                  ← SATU-SATUNYA tempat pengaturan teknis (dipakai website & admin)
│   ├── app.php              #   user/password database, token WhatsApp, batas upload
│   ├── database.php         #   koneksi PDO: db()
│   └── helpers.php          #   e(), tanggal_indo(), img(), simpan_gambar(), baris()
├── includes/                ← bagian khusus website publik
│   ├── init.php  data.php   #   memuat seluruh isi website dari database ke $cfg
│   └── header.php  footer.php
├── admin/                   ← panel admin (folder sendiri, memakai config/ di atas)
│   ├── login.php  index.php  pesan.php  kegiatan.php  prestasi.php  jurusan.php
│   ├── profil.php  kepsek.php  fasilitas.php  kontak.php  pengaturan.php  password.php
│   ├── includes/            #   auth (session + CSRF), layout, CRUD generik
│   └── assets/              #   css & js admin
├── assets/
│   ├── css/  js/
│   └── img/
│       ├── umum/            #   logo, banner, foto gedung, foto kepala sekolah
│       ├── jurusan/         #   foto program keahlian
│       ├── kegiatan/        #   foto kegiatan
│       └── prestasi/        #   foto prestasi
└── database/
    └── smkn_5_palopo.sql    ← struktur + data awal (satu file)
```

## Struktur Database (relasi)
```
profil_sekolah 1──1 kontak            (alamat, telepon, jam buka, sosmed, WhatsApp tujuan)
profil_sekolah 1──1 kepala_sekolah
program_keahlian 1──N poin_jurusan    (kompetensi & prospek karier)
kegiatan + prestasi ──► v_galeri      (view untuk halaman Galeri)
pengaturan  (slogan, tagline, logo, banner)      fasilitas      pesan      admin
```
| Isi website | Tabel | Menu admin |
|---|---|---|
| Nama, tentang, sejarah, visi, misi, tahun berdiri, jumlah siswa/guru | `profil_sekolah` | Profil Sekolah |
| Kepala sekolah | `kepala_sekolah` | Kepala Sekolah |
| Alamat, telepon, email, jam buka, YouTube/Instagram/Facebook, nomor WhatsApp | `kontak` | Kontak |
| Slogan, tagline, logo, banner tiap halaman, foto gedung | `pengaturan` | Tampilan Website |
| Fasilitas | `fasilitas` | Fasilitas |
| Jurusan + kompetensi + karier | `program_keahlian`, `poin_jurusan` | Program Keahlian |
| Kegiatan / Prestasi | `kegiatan` / `prestasi` | Kegiatan / Prestasi |
| Pesan dari form Kontak | `pesan` | Pesan Masuk |
| Akun admin | `admin` | Akun & Password |

## Cara Menjalankan (Laragon / XAMPP)
1. Salin folder ke `C:\laragon\www\` (Laragon) atau `htdocs` (XAMPP), jalankan **Apache** dan **MySQL**.
2. Import **`database/smkn_5_palopo.sql`** (HeidiSQL: *File → Run SQL file…*, atau phpMyAdmin: *Import*).
   File ini membuat database `smkn_5_palopo` sekaligus mengisinya. **Tabel lama (termasuk `tabel_*`) dihapus dan dibuat ulang.**
3. Jika perlu, ubah user/password/port MySQL di **`config/app.php`** (bawaan: port 3306, user `root`, tanpa password).
4. Website: `http://localhost/smkn5palopo/`  ·  Admin: `http://localhost/smkn5palopo/admin/`
5. Login admin awal: **admin / admin123** → segera ganti di menu *Akun & Password*.

## Catatan
- Foto yang diunggah dari admin otomatis masuk ke sub-folder yang sesuai di `assets/img/`. Jika file foto belum ada, website menampilkan placeholder biru.
- Foto jurusan ULP (`assets/img/jurusan/ulp.jpg`) belum ada — unggah lewat admin: Program Keahlian → Ubah.
- WhatsApp otomatis (Fonnte): isi `FONNTE_TOKEN` di `config/app.php`; nomor tujuan diatur di admin (menu Kontak).
- Jika database mati, website menampilkan pesan "belum dapat dibuka" (bukan error PHP).
