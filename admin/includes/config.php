<?php
// Panel admin memakai konfigurasi, koneksi database, dan fungsi bantu yang SAMA dengan website (folder /config).
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/helpers.php';

/** URL gambar dilihat dari folder admin/ */
function img_admin(string $folder, ?string $file, string $label = ''): string {
    return img($folder, $file, $label, '../');
}

/**
 * Database/tabel hilang → tampilkan pesan jelas (bukan error PHP mentah).
 * Output ditahan (ob_start) supaya halaman setengah jadi tidak ikut tampil.
 */
ob_start();
set_exception_handler(function (Throwable $ex) {
    while (ob_get_level()) ob_end_clean();
    error_log('Admin: ' . $ex->getMessage());
    if ($ex instanceof PDOException) {
        http_response_code(503);
        echo '<!DOCTYPE html><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Database tidak ditemukan</title>'
           . '<body style="font-family:sans-serif;max-width:560px;margin:15vh auto;padding:0 20px;line-height:1.6">'
           . '<h2>Database / tabel tidak ditemukan</h2>'
           . '<p>Data yang dibutuhkan halaman ini tidak ada di database (mungkin sudah dihapus atau MySQL mati). '
           . 'Website publik ikut kosong sampai database diisi lagi.</p>'
           . '<p>Pulihkan dengan mengimpor <code>database/smkn_5_palopo.sql</code>, lalu <a href="javascript:location.reload()">muat ulang</a>.</p>'
           . '<p><a href="../index.php">← Lihat website</a> · <a href="logout.php">Keluar</a></p></body>';
    } else {
        http_response_code(500);
        echo 'Terjadi kesalahan.';
    }
});

/** Nama & logo sekolah dari database untuk tampilan admin (kosong bila database/tabel hilang). */
function info_situs(): array {
    static $i = null;
    if ($i === null) {
        $i = ['nama' => '', 'logo' => ''];
        try {
            $i['nama'] = (string)db()->query('SELECT nama_sekolah FROM profil_sekolah ORDER BY id_profil LIMIT 1')->fetchColumn();
        } catch (PDOException $e) {}
        try {
            $i['logo'] = (string)db()->query("SELECT nilai FROM pengaturan WHERE kunci = 'logo' LIMIT 1")->fetchColumn();
        } catch (PDOException $e) {}
    }
    return $i;
}
