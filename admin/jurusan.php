<?php
require_once __DIR__ . '/includes/crud.php';

/** Kompetensi & prospek karier disimpan di tabel poin_jurusan (relasi 1-N ke program_keahlian). */
crud_page([
    'judul' => 'Program Keahlian', 'menu' => 'jurusan', 'nama' => 'Jurusan',
    'table' => 'program_keahlian', 'pk' => 'id_jurusan', 'urut' => 'urutan ASC, id_jurusan ASC',
    'cari'  => ['nama_jurusan', 'deskripsi'],
    'kolom' => ['gambar' => 'Foto', 'nama_jurusan' => 'Jurusan', 'slug' => 'Slug', 'urutan' => 'Urutan'],
    'field' => [
        'nama_jurusan'      => ['label' => 'Nama Jurusan', 'type' => 'text', 'req' => true],
        'slug'              => ['label' => 'Slug (alamat halaman)', 'type' => 'text', 'auto' => 'nama_jurusan', 'req' => true,
                                'hint' => 'Contoh: tkj → jurusan_detail.php?id=tkj. Kosongkan untuk dibuat otomatis dari nama.'],
        'urutan'            => ['label' => 'Urutan tampil', 'type' => 'number', 'hint' => 'Angka kecil tampil lebih dulu.'],
        'deskripsi'         => ['label' => 'Deskripsi Singkat', 'type' => 'textarea', 'rows' => 2],
        'deskripsi_lengkap' => ['label' => 'Deskripsi Lengkap', 'type' => 'textarea', 'rows' => 6],
        'kompetensi'        => ['label' => 'Kompetensi', 'type' => 'textarea', 'virtual' => true, 'hint' => 'Satu poin per baris.'],
        'karier'            => ['label' => 'Prospek Karier', 'type' => 'textarea', 'virtual' => true, 'hint' => 'Satu poin per baris.'],
        'gambar'            => ['label' => 'Foto', 'type' => 'image', 'folder' => 'jurusan', 'hint' => 'JPG/PNG/WEBP, maks. 2 MB. Tersimpan di assets/img/jurusan/.'],
    ],
    'muat' => function (array $row): array {
        $s = db()->prepare('SELECT jenis, isi FROM poin_jurusan WHERE id_jurusan = ? ORDER BY urutan, id_poin');
        $s->execute([$row['id_jurusan']]);
        $tmp = ['kompetensi' => [], 'karier' => []];
        foreach ($s as $p) $tmp[$p['jenis']][] = $p['isi'];
        $row['kompetensi'] = implode("\n", $tmp['kompetensi']);
        $row['karier']     = implode("\n", $tmp['karier']);
        return $row;
    },
    'setelah' => function (PDO $db, int $id, array $post): void {
        $db->prepare('DELETE FROM poin_jurusan WHERE id_jurusan = ?')->execute([$id]);
        $ins = $db->prepare('INSERT INTO poin_jurusan (id_jurusan, jenis, isi, urutan) VALUES (?, ?, ?, ?)');
        foreach (['kompetensi', 'karier'] as $jenis) {
            foreach (baris($post[$jenis] ?? '') as $i => $isi) $ins->execute([$id, $jenis, mb_substr($isi, 0, 255), $i + 1]);
        }
    },
]);
