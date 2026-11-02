<?php
// Panel admin memakai konfigurasi, koneksi database, dan fungsi bantu yang SAMA dengan website (folder /config).
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/helpers.php';

/** URL gambar dilihat dari folder admin/ */
function img_admin(string $folder, ?string $file, string $label = ''): string {
    return img($folder, $file, $label, '../');
}
