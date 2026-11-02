<?php
require_once __DIR__ . '/includes/crud.php';
crud_page([
    'judul' => 'Kegiatan Sekolah', 'menu' => 'kegiatan', 'nama' => 'Kegiatan',
    'table' => 'kegiatan', 'pk' => 'id_kegiatan', 'urut' => 'tanggal DESC, id_kegiatan DESC',
    'cari'  => ['judul', 'deskripsi'],
    'kolom' => ['foto' => 'Foto', 'judul' => 'Judul', 'tanggal' => 'Tanggal'],
    'field' => [
        'judul'     => ['label' => 'Judul Kegiatan', 'type' => 'text', 'req' => true],
        'tanggal'   => ['label' => 'Tanggal', 'type' => 'date', 'req' => true],
        'deskripsi' => ['label' => 'Deskripsi', 'type' => 'textarea'],
        'foto'      => ['label' => 'Foto', 'type' => 'image', 'folder' => 'kegiatan', 'hint' => 'JPG/PNG/WEBP, maks. 2 MB. Tersimpan di assets/img/kegiatan/.'],
    ],
]);
