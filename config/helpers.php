<?php
require_once __DIR__ . '/app.php';

/** Escape output HTML */
function e(?string $s): string {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

function tanggal_indo(?string $tgl): string {
    if (!$tgl) return '-';
    $bln = [1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    $t = strtotime($tgl);
    return date('d', $t) . ' ' . $bln[(int)date('n', $t)] . ' ' . date('Y', $t);
}

/** Pecah teks banyak baris menjadi array (baris kosong dibuang). */
function baris(?string $teks): array {
    return array_values(array_filter(array_map('trim', preg_split('/\R/', (string)$teks)), fn($x) => $x !== ''));
}

/**
 * URL gambar di assets/img/<folder>/<file>.
 * $dari = awal path: '' untuk halaman di root, '../' untuk halaman di admin/.
 * Jika file belum ada → placeholder SVG otomatis.
 */
function img(string $folder, ?string $file, string $label = '', string $dari = ''): string {
    $file = $file ? basename($file) : '';
    if ($file !== '' && in_array($folder, FOLDER_GAMBAR, true)
        && file_exists(ROOT_DIR . '/' . IMG_DIR_REL . $folder . '/' . $file)) {
        return $dari . IMG_DIR_REL . $folder . '/' . rawurlencode($file);
    }
    $label = htmlspecialchars($label ?: 'Foto', ENT_QUOTES);
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400" viewBox="0 0 600 400">'
         . '<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1">'
         . '<stop offset="0" stop-color="#2b6cb0"/><stop offset="1" stop-color="#0b2a4a"/></linearGradient></defs>'
         . '<rect width="600" height="400" fill="url(#g)"/>'
         . '<text x="300" y="210" font-family="Arial" font-size="26" fill="#ffffff" fill-opacity=".75" text-anchor="middle">' . $label . '</text>'
         . '</svg>';
    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}

/** Simpan gambar upload ke assets/img/<folder>/. Return nama file, atau null (isi $error bila gagal). */
function simpan_gambar(array $file, string $folder, ?string &$error): ?string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
    if (!in_array($folder, FOLDER_GAMBAR, true)) { $error = 'Folder gambar tidak valid.'; return null; }
    if ($file['error'] !== UPLOAD_ERR_OK) { $error = 'Upload gambar gagal.'; return null; }
    if ($file['size'] > MAX_UPLOAD) { $error = 'Ukuran gambar maksimal 2 MB.'; return null; }
    $info = @getimagesize($file['tmp_name']);
    $ext  = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'][$info[2] ?? 0] ?? null;
    if (!$ext) { $error = 'Format gambar harus JPG, PNG, atau WEBP.'; return null; }
    $base = strtolower(preg_replace('/[^a-z0-9]+/i', '-', pathinfo($file['name'], PATHINFO_FILENAME)));
    $nama = (trim(substr($base, 0, 30), '-') ?: 'gambar') . '-' . bin2hex(random_bytes(3)) . '.' . $ext;
    $dir  = ROOT_DIR . '/' . IMG_DIR_REL . $folder . '/';
    if (!is_dir($dir) || !move_uploaded_file($file['tmp_name'], $dir . $nama)) {
        $error = 'Gagal menyimpan gambar (periksa izin folder assets/img/' . $folder . '/).'; return null;
    }
    return $nama;
}
