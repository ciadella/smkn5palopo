<?php
require_once __DIR__ . '/includes/crud.php';
crud_page([
    'judul' => 'Kontak Sekolah', 'menu' => 'kontak', 'nama' => 'Kontak',
    'table' => 'kontak', 'pk' => 'id_kontak', 'single' => true,
    'default' => ['id_profil' => (int)db()->query('SELECT MIN(id_profil) FROM profil_sekolah')->fetchColumn()],
    'field' => [
        'alamat'         => ['label' => 'Alamat', 'type' => 'text'],
        'telpon'         => ['label' => 'Telepon', 'type' => 'text'],
        'email'          => ['label' => 'Email', 'type' => 'email'],
        'media_sosial'   => ['label' => 'Nama Media Sosial', 'type' => 'text', 'hint' => 'Contoh: @smkn_5_palopo'],
        'whatsapp'       => ['label' => 'WhatsApp Tujuan Form Kontak', 'type' => 'text', 'hint' => 'Format 62, tanpa + atau spasi. Contoh: 6281234567890'],
        'jam_buka_hari'  => ['label' => 'Hari Buka', 'type' => 'text'],
        'jam_buka_jam'   => ['label' => 'Jam Buka', 'type' => 'text'],
        'jam_tutup_hari' => ['label' => 'Hari Tutup', 'type' => 'text'],
        'jam_tutup_ket'  => ['label' => 'Keterangan Hari Tutup', 'type' => 'text'],
        'youtube'        => ['label' => 'Link YouTube', 'type' => 'url'],
        'instagram'      => ['label' => 'Link Instagram', 'type' => 'url'],
        'facebook'       => ['label' => 'Link Facebook', 'type' => 'url'],
    ],
]);
