<?php
require_once __DIR__ . '/includes/crud.php';
crud_page([
    'judul' => 'Fasilitas Sekolah', 'menu' => 'fasilitas', 'nama' => 'Fasilitas',
    'table' => 'fasilitas', 'pk' => 'id_fasilitas', 'urut' => 'urutan ASC, id_fasilitas ASC',
    'cari'  => ['nama', 'keterangan'],
    'kolom' => ['ikon' => 'Ikon', 'nama' => 'Nama', 'keterangan' => 'Keterangan', 'urutan' => 'Urutan'],
    'field' => [
        'ikon'       => ['label' => 'Ikon (emoji)', 'type' => 'text', 'hint' => 'Contoh: 📚 🏫 💻'],
        'nama'       => ['label' => 'Nama Fasilitas', 'type' => 'text', 'req' => true],
        'keterangan' => ['label' => 'Keterangan', 'type' => 'text'],
        'urutan'     => ['label' => 'Urutan tampil', 'type' => 'number', 'hint' => 'Angka kecil tampil lebih dulu.'],
    ],
]);
