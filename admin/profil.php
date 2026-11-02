<?php
require_once __DIR__ . '/includes/crud.php';
crud_page([
    'judul' => 'Profil Sekolah', 'menu' => 'profil', 'nama' => 'Profil',
    'table' => 'profil_sekolah', 'pk' => 'id_profil', 'single' => true,
    'field' => [
        'nama_sekolah'  => ['label' => 'Nama Sekolah', 'type' => 'text', 'req' => true],
        'tentang'       => ['label' => 'Tentang Sekolah', 'type' => 'textarea', 'rows' => 5],
        'tahun_berdiri' => ['label' => 'Tahun Berdiri', 'type' => 'number'],
        'jumlah_siswa'  => ['label' => 'Jumlah Siswa', 'type' => 'number'],
        'jumlah_guru'   => ['label' => 'Jumlah Guru', 'type' => 'number'],
        'sejarah'       => ['label' => 'Sejarah', 'type' => 'textarea', 'rows' => 6],
        'visi'          => ['label' => 'Visi', 'type' => 'textarea'],
        'misi'          => ['label' => 'Misi', 'type' => 'textarea', 'rows' => 6, 'hint' => 'Satu poin per baris.'],
    ],
]);
