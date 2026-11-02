<?php
require_once __DIR__ . '/includes/crud.php';
crud_page([
    'judul' => 'Prestasi', 'menu' => 'prestasi', 'nama' => 'Prestasi',
    'table' => 'prestasi', 'pk' => 'id_prestasi', 'urut' => 'tanggal DESC, id_prestasi DESC',
    'cari'  => ['judul', 'deskripsi'],
    'kolom' => ['foto' => 'Foto', 'judul' => 'Prestasi', 'tanggal' => 'Tanggal'],
    'field' => [
        'judul'     => ['label' => 'Nama Prestasi', 'type' => 'text', 'req' => true],
        'tanggal'   => ['label' => 'Tanggal', 'type' => 'date', 'req' => true],
        'deskripsi' => ['label' => 'Deskripsi', 'type' => 'textarea'],
        'foto'      => ['label' => 'Foto', 'type' => 'image', 'folder' => 'prestasi', 'hint' => 'JPG/PNG/WEBP, maks. 2 MB. Tersimpan di assets/img/prestasi/.'],
    ],
]);
