<?php
/**
 * LAPISAN DATA WEBSITE PUBLIK — semua isi website dibaca dari database di sini.
 * Hasilnya satu array $cfg yang dipakai oleh halaman-halaman (index.php, profil.php, dst).
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';

function muat_situs(): array {
    $db = db();
    $p = $db->query('SELECT * FROM profil_sekolah ORDER BY id_profil LIMIT 1')->fetch() ?: [];
    $idp = (int)($p['id_profil'] ?? 0);

    $ambil = function (string $tabel) use ($db, $idp) {
        $s = $db->prepare("SELECT * FROM $tabel WHERE id_profil = ? LIMIT 1");
        $s->execute([$idp]);
        return $s->fetch() ?: [];
    };
    $k = $ambil('kontak');
    $kp = $ambil('kepala_sekolah');
    $set = $db->query('SELECT kunci, nilai FROM pengaturan')->fetchAll(PDO::FETCH_KEY_PAIR);

    // Program keahlian + poin (kompetensi & karier) dalam 2 query
    $poin = [];
    foreach ($db->query('SELECT id_jurusan, jenis, isi FROM poin_jurusan ORDER BY urutan, id_poin') as $r) {
        $poin[$r['id_jurusan']][$r['jenis']][] = $r['isi'];
    }
    $jurusan = [];
    foreach ($db->query('SELECT * FROM program_keahlian ORDER BY urutan, id_jurusan') as $j) {
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
    foreach ($db->query('SELECT * FROM fasilitas ORDER BY urutan, id_fasilitas') as $f) {
        $fasilitas[] = ['ikon' => $f['ikon'], 'nama' => $f['nama'], 'ket' => (string)$f['keterangan']];
    }

    $biodata = array_filter([
        'NIP'                 => $kp['nip'] ?? '',
        'Tempat, Tgl. Lahir'  => $kp['tempat_tgl_lahir'] ?? '',
        'Pendidikan Terakhir' => $kp['pendidikan'] ?? '',
        'Masa Jabatan'        => $kp['masa_jabatan'] ?? '',
    ], fn($v) => $v !== '' && $v !== null);

    return [
        'nama_sekolah'   => $p['nama_sekolah'] ?? 'SMKN 5 Palopo',
        'slogan'         => $set['slogan'] ?? '',
        'tagline'        => $set['tagline'] ?? '',
        'lokasi_singkat' => $set['lokasi_singkat'] ?? '',
        'logo'           => $set['logo'] ?? 'logo.png',
        'gedung'         => $set['gambar_gedung'] ?? 'gedung.jpg',
        'hero' => [
            'beranda' => $set['hero_beranda'] ?? '',
            'profil'  => $set['hero_profil'] ?? '',
            'jurusan' => $set['hero_jurusan'] ?? '',
            'galeri'  => $set['hero_galeri'] ?? '',
            'kontak'  => $set['hero_kontak'] ?? '',
        ],
        'tentang'       => (string)($p['tentang'] ?? ''),
        'tahun_berdiri' => (string)($p['tahun_berdiri'] ?? ''),
        'jumlah_siswa'  => (string)($p['jumlah_siswa'] ?? ''),
        'jumlah_guru'   => (string)($p['jumlah_guru'] ?? ''),
        'sejarah'       => (string)($p['sejarah'] ?? ''),
        'visi'          => (string)($p['visi'] ?? ''),
        'misi'          => baris($p['misi'] ?? ''),
        'kepala_sekolah' => [
            'nama'     => $kp['nama'] ?? '',
            'jabatan'  => $kp['jabatan'] ?? '',
            'foto'     => $kp['foto'] ?? '',
            'biodata'  => $biodata,
            'sambutan' => $kp['sambutan'] ?? '',
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
        'kegiatan'       => $db->query('SELECT judul, tanggal, deskripsi, foto FROM kegiatan ORDER BY tanggal DESC, id_kegiatan DESC')->fetchAll(),
        'prestasi'       => $db->query('SELECT judul, tanggal, deskripsi, foto FROM prestasi ORDER BY tanggal DESC, id_prestasi DESC')->fetchAll(),
    ];
}

/** Data galeri (view v_galeri), opsional difilter kategori 'Kegiatan' / 'Prestasi'. */
function muat_galeri(string $kategori = ''): array {
    $semua = db()->query('SELECT * FROM v_galeri ORDER BY tanggal DESC, id DESC')->fetchAll();
    // Filter di PHP (bukan di SQL) agar tidak terkena beda collation antara view dan koneksi.
    return $kategori === '' ? $semua : array_values(array_filter($semua, fn($r) => $r['kategori'] === $kategori));
}