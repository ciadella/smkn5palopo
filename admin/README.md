# Panel Admin — SMKN 5 Palopo

Folder `admin/` terpisah dari website, tetapi memakai `config/` yang sama (koneksi database, fungsi bantu, folder gambar).
Lihat README utama untuk struktur lengkap dan cara pasang. Login awal: **admin / admin123**.

| Halaman | Fungsi |
|---|---|
| index.php | Dashboard (jumlah data, pesan belum dibaca) |
| pesan.php | Pesan dari form kontak: tandai dibaca, balas, hapus |
| kegiatan.php, prestasi.php | Tambah / ubah / hapus + upload foto |
| jurusan.php | Program keahlian + kompetensi + prospek karier (satu poin per baris) |
| profil.php, kepsek.php, fasilitas.php, kontak.php | Isi halaman Profil & Kontak |
| pengaturan.php | Slogan, tagline, logo, banner |
| password.php | Ganti nama & password |

Keamanan: password ter-hash, token CSRF di semua form, login dibatasi 5x percobaan, upload hanya JPG/PNG/WEBP ≤ 2 MB.
