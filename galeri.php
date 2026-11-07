<?php
$halaman = 'galeri';
$judul = 'Galeri Foto';
require __DIR__ . '/includes/header.php';

// Galeri = view v_galeri (gabungan tabel kegiatan + prestasi) di database
$kategori = ['Kegiatan', 'Prestasi'];
$filter = $_GET['kategori'] ?? '';
if (!in_array($filter, $kategori, true)) $filter = '';

$foto = muat_galeri($filter);
?>

<section class="page-banner" <?= $cfg['hero']['galeri'] !== '' ? 'style="background-image:url(\'' . img_db('umum', $cfg['hero']['galeri']) . '\')"' : '' ?>>
  <div class="hero-overlay"></div>
  <div class="container">
    <h1>Galeri Foto</h1>
    <p class="crumb"><a href="index.php">Beranda</a> › Galeri Foto</p>
  </div>
</section>

<section class="container section">
  <div class="filters">
    <a href="galeri.php" class="chip <?= $filter === '' ? 'active' : '' ?>">Semua</a>
    <?php foreach ($kategori as $k): ?>
      <a href="galeri.php?kategori=<?= urlencode($k) ?>" class="chip <?= $filter === $k ? 'active' : '' ?>"><?= e($k) ?></a>
    <?php endforeach; ?>
  </div>

  <div class="gallery">
    <?php foreach ($foto as $f): ?>
      <figure class="gallery-item" data-caption="<?= e($f['judul']) ?> — <?= tanggal_indo($f['tanggal']) ?>">
        <img src="<?= img($f['folder'], $f['foto'], $f['judul']) ?>" alt="<?= e($f['judul']) ?>" loading="lazy">
        <figcaption><?= e($f['judul']) ?></figcaption>
      </figure>
    <?php endforeach; ?>
    <?php if (!$foto): ?><p>Belum ada foto pada kategori ini.</p><?php endif; ?>
  </div>
</section>

<div class="lightbox" id="lightbox"><div><img src="" alt=""><p id="lightbox-caption"></p></div></div>

<?php require __DIR__ . '/includes/footer.php'; ?>
