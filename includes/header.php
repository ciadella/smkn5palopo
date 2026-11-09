<?php
require_once __DIR__ . '/init.php';
$halaman = $halaman ?? 'beranda';
$judul   = $judul ?? $cfg['nama_sekolah'];
$judul_tab = trim($judul . ($cfg['nama_sekolah'] !== '' ? ' | ' . $cfg['nama_sekolah'] : ''), ' |');

function aktif(string $a, string $b): string { return $a === $b ? 'active' : ''; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($judul_tab) ?></title>
<link rel="icon" type="image/png" href="/smkn5palopo/favicon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="navbar">
  <div class="container nav-inner">
    <a href="index.php" class="brand">
      <?php if ($cfg['logo'] !== ''): ?><img src="<?= img_db('umum', $cfg['logo'], 'Logo') ?>" alt="Logo" class="brand-logo"><?php endif; ?>
      <span class="brand-text">
        <strong><?= e($cfg['nama_sekolah']) ?></strong>
        <small><?= e($cfg['slogan']) ?></small>
      </span>
    </a>
    <button class="nav-toggle" aria-label="Menu" onclick="document.querySelector('.nav-menu').classList.toggle('open')">☰</button>
    <nav class="nav-menu">
      <a href="index.php"  class="<?= aktif($halaman,'beranda') ?>">Beranda</a>
      <a href="profil.php" class="<?= aktif($halaman,'profil') ?>">Profil</a>
      <a href="jurusan.php" class="<?= aktif($halaman,'jurusan') ?>">Jurusan</a>
      <a href="galeri.php" class="<?= aktif($halaman,'galeri') ?>">Galeri</a>
      <a href="kontak.php" class="<?= aktif($halaman,'kontak') ?>">Kontak</a>
      <a href="admin/login.php" class="nav-login">Login Admin</a>
    </nav>
  </div>
</header>
<?php if (!$cfg['db_ok']): ?>
<div style="background:#fff3cd;color:#664d03;text-align:center;padding:10px 16px;font-size:14px">
  Database tidak ditemukan / tidak terhubung — isi website kosong. Impor <code>database/smkn_5_palopo.sql</code> untuk mengisinya kembali.
</div>
<?php endif; ?>
