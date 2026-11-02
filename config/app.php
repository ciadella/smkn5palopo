<?php
/**
 * PENGATURAN TEKNIS — dipakai bersama oleh website publik DAN panel admin.
 * Hanya file ini yang perlu diubah saat pindah komputer/hosting.
 */

// ---- Database (import database/smkn_5_palopo.sql) ----
const DB_HOST = '127.0.0.1';
const DB_PORT = '3306';          // Laragon/XAMPP biasanya 3306
const DB_NAME = 'smkn_5_palopo';
const DB_USER = 'root';
const DB_PASS = '';

// ---- Folder gambar (di dalam assets/img/ ada sub-folder per jenis) ----
define('ROOT_DIR', dirname(__DIR__));
const IMG_DIR_REL = 'assets/img/';
const FOLDER_GAMBAR = ['umum', 'jurusan', 'kegiatan', 'prestasi'];
const MAX_UPLOAD = 2 * 1024 * 1024;   // 2 MB

// ---- WhatsApp otomatis (Fonnte) untuk form Kontak ----
// Daftar di https://fonnte.com, scan QR, salin TOKEN ke sini. Kosong = buka WhatsApp manual.
// Nomor tujuan WA diatur dari admin: menu Kontak.
const FONNTE_TOKEN = '';
// true hanya jika di localhost muncul error SSL. Ubah ke false saat sudah online.
const ABAIKAN_SSL_LOKAL = true;
