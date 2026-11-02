<?php
// Dipanggil sekali oleh header.php / halaman publik: memuat konfigurasi + isi website dari database.
require_once __DIR__ . '/data.php';

if (!isset($cfg)) {
    try {
        $cfg = muat_situs();
    } catch (PDOException $ex) {
        error_log('Database error: ' . $ex->getMessage());
        http_response_code(503);
        exit('<!DOCTYPE html><meta charset="utf-8"><title>Website belum siap</title>'
           . '<body style="font-family:sans-serif;max-width:560px;margin:15vh auto;padding:0 20px;line-height:1.6">'
           . '<h2>Website belum dapat dibuka</h2>'
           . '<p>Database tidak terhubung. Pastikan MySQL aktif, file <code>database/smkn_5_palopo.sql</code> sudah diimpor, '
           . 'dan pengaturan di <code>config/app.php</code> sudah benar.</p></body>');
    }
}
