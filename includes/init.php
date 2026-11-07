<?php
// Dipanggil sekali oleh header.php / halaman publik: memuat konfigurasi + isi website dari database.
// muat_situs() TIDAK pernah melempar error: database/tabel hilang → isi $cfg kosong → UI ikut kosong.
require_once __DIR__ . '/data.php';

if (!isset($cfg)) {
    $cfg = muat_situs();
}
