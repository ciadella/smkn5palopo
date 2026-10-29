<?php
require_once __DIR__ . '/config.php';
$halaman = $halaman ?? 'beranda';
$judul   = $judul ?? $cfg['nama_sekolah'];

function aktif(string $a, string $b): string { return $a === $b ? 'active' : ''; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($judul) ?> | <?= e($cfg['nama_sekolah']) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="navbar">
  <div class="container nav-inner">
    <a href="index.php" class="brand">
      <img src="<?= img('logo.png', 'Logo') ?>" alt="Logo" class="brand-logo">
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
      <a href="galeri.php" class="nav-search" aria-label="Cari">🔍</a>
    </nav>
  </div>
</header>
