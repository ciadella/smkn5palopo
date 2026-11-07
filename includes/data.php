<?php
/**
 * LAPISAN DATA WEBSITE PUBLIK — semua isi website dibaca dari database di sini.
 * Hasilnya satu array $cfg yang dipakai oleh halaman-halaman (index.php, profil.php, dst).
 *
 * PRINSIP: UI = cermin database. Tidak ada teks/gambar bawaan di kode.
 *   - Tabel dihapus / dikosongkan  → bagian UI yang memakai tabel itu ikut hilang.
 *   - Database dihapus / MySQL mati → seluruh isi UI kosong (rangka halaman tetap tampil).
 * Data dibaca LANGSUNG dari database pada setiap kali halaman dibuka (tanpa cache).
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';

/** Jalankan query; bila tabel/database tidak ada → kembalikan $kosong (bukan error). */
function aman(callable $q, $kosong = []) {
    try {
        return $q();
    } catch (PDOException $ex) {
        error_log('Database: ' . $ex->getMessage());
        return $kosong;
    }
}

function muat_situs(): array {
    // Cek koneksi sekali saja. Gagal (database dihapus / MySQL mati) → semua kosong.
    $db_ok = true;
    try {
        db();
    } catch (PDOException $ex) {
        error_log('Database: ' . $ex->getMessage());
        $db_ok = false;
    }

    $kueri  = fn(string $sql) => aman(fn() => db()->query($sql)->fetchAll());
    $satu   = fn(string $sql) => aman(fn() => db()->query($sql)->fetch() ?: [], []);

    $p   = $db_ok ? $satu('SELECT * FROM profil_sekolah ORDER BY id_profil LIMIT 1') : [];
    $idp = (int)($p['id_profil'] ?? 0);

    $ambil = function (string $tabel) use ($idp): array {
        return aman(function () use ($tabel, $idp) {
            $s = db()->prepare("SELECT * FROM $tabel WHERE id_profil = ? LIMIT 1");
            $s->execute([$idp]);
            return $s->fetch() ?: [];
        }, []);
    };
    $k   = $idp ? $ambil('kontak') : [];
    $kp  = $idp ? $ambil('kepala_sekolah') : [];
    $set = $db_ok ? aman(fn() => db()->query('SELECT kunci, nilai FROM pengaturan')->fetchAll(PDO::FETCH_KEY_PAIR)) : [];

    // Program keahlian + poin (kompetensi & karier)
    $poin = [];
    foreach ($db_ok ? $kueri('SELECT id_jurusan, jenis, isi FROM poin_jurusan ORDER BY urutan, id_poin') : [] as $r) {
        $poin[$r['id_jurusan']][$r['jenis']][] = $r['isi'];
    }
    $jurusan = [];
    foreach ($db_ok ? $kueri('SELECT * FROM program_keahlian ORDER BY urutan, id_jurusan') : [] as $j) {
        $jurusan[$j['slug']] = [
            'nama'       => $j['nama_jurusan'],
            'deskripsi'  => (string)$j['deskripsi'],
            'uraian'     => $j['deskripsi_lengkap'] ?: (string)$j['deskripsi'],
            'kompetensi' => $poin[$j['id_jurusan']]['kompetensi'] ?? [],
            'karier'     => $poin[$j['id_jurusan']]['karier'] ?? [],
            'gambar'     => $j['gambar'],
        ];
    }

    $fasilitas = [];
    foreach ($db_ok ? $kueri('SELECT * FROM fasilitas ORDER BY urutan, id_fasilitas') : [] as $f) {
        $fasilitas[] = ['ikon' => $f['ikon'], 'nama' => $f['nama'], 'ket' => (string)$f['keterangan']];
    }

    $biodata = array_filter([
        'NIP'                 => $kp['nip'] ?? '',
        'Tempat, Tgl. Lahir'  => $kp['tempat_tgl_lahir'] ?? '',
        'Pendidikan Terakhir' => $kp['pendidikan'] ?? '',
        'Masa Jabatan'        => $kp['masa_jabatan'] ?? '',
    ], fn($v) => $v !== '' && $v !== null);

    return [
        'db_ok'          => $db_ok,
        'nama_sekolah'   => (string)($p['nama_sekolah'] ?? ''),
        'slogan'         => (string)($set['slogan'] ?? ''),
        'tagline'        => (string)($set['tagline'] ?? ''),
        'lokasi_singkat' => (string)($set['lokasi_singkat'] ?? ''),
        'logo'           => (string)($set['logo'] ?? ''),
        'gedung'         => (string)($set['gambar_gedung'] ?? ''),
        'hero' => [
            'beranda' => (string)($set['hero_beranda'] ?? ''),
            'profil'  => (string)($set['hero_profil'] ?? ''),
            'jurusan' => (string)($set['hero_jurusan'] ?? ''),
            'galeri'  => (string)($set['hero_galeri'] ?? ''),
            'kontak'  => (string)($set['hero_kontak'] ?? ''),
        ],
        'tentang'       => (string)($p['tentang'] ?? ''),
        'tahun_berdiri' => (string)($p['tahun_berdiri'] ?? ''),
        'jumlah_siswa'  => (string)($p['jumlah_siswa'] ?? ''),
        'jumlah_guru'   => (string)($p['jumlah_guru'] ?? ''),
        'sejarah'       => (string)($p['sejarah'] ?? ''),
        'visi'          => (string)($p['visi'] ?? ''),
        'misi'          => baris($p['misi'] ?? ''),
        'kepala_sekolah' => [
            'nama'     => (string)($kp['nama'] ?? ''),
            'jabatan'  => (string)($kp['jabatan'] ?? ''),
            'foto'     => (string)($kp['foto'] ?? ''),
            'biodata'  => $biodata,
            'sambutan' => (string)($kp['sambutan'] ?? ''),
        ],
        'fasilitas'      => $fasilitas,
        'alamat'         => (string)($k['alamat'] ?? ''),
        'telepon'        => (string)($k['telpon'] ?? ''),
        'email'          => (string)($k['email'] ?? ''),
        'media_sosial'   => (string)($k['media_sosial'] ?? ''),
        'whatsapp'       => (string)($k['whatsapp'] ?? ''),
        'jam_buka_hari'  => (string)($k['jam_buka_hari'] ?? ''),
        'jam_buka_jam'   => (string)($k['jam_buka_jam'] ?? ''),
        'jam_tutup_hari' => (string)($k['jam_tutup_hari'] ?? ''),
        'jam_tutup_ket'  => (string)($k['jam_tutup_ket'] ?? ''),
        'youtube'        => (string)($k['youtube'] ?? ''),
        'instagram'      => (string)($k['instagram'] ?? ''),
        'facebook'       => (string)($k['facebook'] ?? ''),
        'jurusan'        => $jurusan,
        'kegiatan'       => $db_ok ? $kueri('SELECT judul, tanggal, deskripsi, foto FROM kegiatan ORDER BY tanggal DESC, id_kegiatan DESC') : [],
        'prestasi'       => $db_ok ? $kueri('SELECT judul, tanggal, deskripsi, foto FROM prestasi ORDER BY tanggal DESC, id_prestasi DESC') : [],
    ];
}

/**
 * Data galeri = gabungan tabel kegiatan + prestasi, opsional difilter kategori 'Kegiatan' / 'Prestasi'.
 * Tiap tabel dibaca sendiri-sendiri: salah satu tabel hilang → hanya bagiannya yang kosong.
 */
function muat_galeri(string $kategori = ''): array {
    $sumber = [
        'Kegiatan' => ['kegiatan', 'id_kegiatan'],
        'Prestasi' => ['prestasi', 'id_prestasi'],
    ];
    $semua = [];
    foreach ($sumber as $kat => [$tabel, $pk]) {
        if ($kategori !== '' && $kategori !== $kat) continue;
        foreach (aman(fn() => db()->query("SELECT $pk AS id, judul, tanggal, deskripsi, foto FROM $tabel")->fetchAll()) as $r) {
            $semua[] = $r + ['kategori' => $kat, 'folder' => $tabel];
        }
    }
    usort($semua, fn($a, $b) => [$b['tanggal'], $b['id']] <=> [$a['tanggal'], $a['id']]);
    return $semua;
}
