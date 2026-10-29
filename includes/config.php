<?php
// Konfigurasi database — HANYA dipakai untuk menyimpan pesan dari form kontak.
// Semua isi website lainnya ada di includes/konten.php
const DB_HOST = '127.0.0.1';
const DB_PORT = '3306';   // port MySQL Laragon/XAMPP biasanya 3306
const DB_NAME = 'smkn_5_palopo';
const DB_USER = 'root';
const DB_PASS = '';

/** Koneksi database (dibuat saat dibutuhkan saja, jadi website tetap jalan walau MySQL mati) */
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }
    return $pdo;
}

/** $cfg = seluruh isi website dari includes/konten.php */
$cfg = require __DIR__ . '/konten.php';

/** Escape output HTML */
function e(?string $s): string {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * URL gambar. Jika file ada di assets/img/ pakai file itu,
 * kalau belum ada tampilkan placeholder SVG otomatis.
 */
function img(?string $file, string $label = ''): string {
    if ($file && file_exists(__DIR__ . '/../assets/img/' . $file)) {
        return 'assets/img/' . e($file);
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

function tanggal_indo(string $tgl): string {
    $bln = [1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    $t = strtotime($tgl);
    return date('d', $t) . ' ' . $bln[(int)date('n', $t)] . ' ' . date('Y', $t);
}

/** Urutkan daftar (kegiatan/prestasi) dari tanggal terbaru */
function urut_tanggal(array $daftar): array {
    usort($daftar, fn($a, $b) => strcmp($b['tanggal'], $a['tanggal']));
    return $daftar;
}
