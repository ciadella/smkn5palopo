<?php
require_once __DIR__ . '/includes/crud.php';
crud_page([
    'judul' => 'Kepala Sekolah', 'menu' => 'kepsek', 'nama' => 'Kepala Sekolah',
    'table' => 'kepala_sekolah', 'pk' => 'id_kepsek', 'single' => true,
    'default' => ['id_profil' => (int)db()->query('SELECT MIN(id_profil) FROM profil_sekolah')->fetchColumn()],
    'field' => [
        'nama'             => ['label' => 'Nama Lengkap & Gelar', 'type' => 'text', 'req' => true],
        'jabatan'          => ['label' => 'Jabatan', 'type' => 'text'],
        'foto'             => ['label' => 'Foto', 'type' => 'image', 'folder' => 'umum', 'hint' => 'JPG/PNG/WEBP, maks. 2 MB.'],
        'nip'              => ['label' => 'NIP', 'type' => 'text'],
        'tempat_tgl_lahir' => ['label' => 'Tempat, Tanggal Lahir', 'type' => 'text'],
        'pendidikan'       => ['label' => 'Pendidikan Terakhir', 'type' => 'text'],
        'masa_jabatan'     => ['label' => 'Masa Jabatan', 'type' => 'text'],
        'sambutan'         => ['label' => 'Kata Sambutan', 'type' => 'textarea', 'rows' => 5],
    ],
]);
