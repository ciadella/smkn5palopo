<?php
$halaman = 'beranda';
$judul = 'Beranda';
require __DIR__ . '/includes/header.php';

$kegiatan = array_slice(urut_tanggal($cfg['kegiatan']), 0, 3);
?>

<section class="hero" style="background-image:url('<?= img($cfg['hero']['beranda'], '') ?>')">
  <div class="hero-overlay"></div>
  <div class="container hero-content">
    <p class="hero-small">Selamat Datang di</p>
    <h1><?= e($cfg['nama_sekolah']) ?></h1>
    <p class="hero-desc"><?= e($cfg['tagline']) ?></p>
    <a href="profil.php" class="btn btn-primary">Jelajahi Sekolah →</a>
  </div>
</section>

<section class="container quick">
  <a class="quick-card" href="profil.php">
    <div class="quick-icon">📘</div>
    <h3>Profil Sekolah</h3>
    <p>Kenali lebih dekat tentang <?= e($cfg['nama_sekolah']) ?></p>
  </a>
  <a class="quick-card" href="jurusan.php">
    <div class="quick-icon">🎓</div>
    <h3>Program Keahlian</h3>
    <p>Pilih jurusan sesuai minat dan bakatmu</p>
  </a>
  <a class="quick-card" href="galeri.php?kategori=Prestasi">
    <div class="quick-icon">🏆</div>
    <h3>Prestasi</h3>
    <p>Raih prestasi bersama <?= e($cfg['nama_sekolah']) ?></p>
  </a>
  <a class="quick-card" href="kontak.php">
    <div class="quick-icon">📋</div>
    <h3>Pendaftaran</h3>
    <p>Informasi pendaftaran peserta didik baru</p>
  </a>
</section>

<section class="container section">
  <div class="section-head">
    <h2>Kegiatan Terbaru</h2>
    <a href="galeri.php?kategori=Kegiatan" class="link-more">Lihat Semua →</a>
  </div>
  <div class="grid-3">
    <?php foreach ($kegiatan as $k): ?>
      <article class="news-card">
        <img src="<?= img($k['foto'], 'Kegiatan') ?>" alt="<?= e($k['judul']) ?>">
        <time><?= tanggal_indo($k['tanggal']) ?></time>
        <h3><?= e($k['judul']) ?></h3>
      </article>
    <?php endforeach; ?>
    <?php if (!$kegiatan): ?><p>Belum ada kegiatan.</p><?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
