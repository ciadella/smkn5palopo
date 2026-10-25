<?php
$halaman = 'galeri';
$judul = 'Galeri Foto';
require __DIR__ . '/includes/header.php';

// Galeri = foto dari tabel_kegiatan + tabel_prestasi
$kategori = ['Kegiatan', 'Prestasi'];
$filter = $_GET['kategori'] ?? '';
if (!in_array($filter, $kategori, true)) $filter = '';

$sql = "SELECT * FROM (
          SELECT judul_kegiatan AS judul, tanggal, foto AS gambar, 'Kegiatan' AS kategori FROM tabel_kegiatan
          UNION ALL
          SELECT nama_prestasi AS judul, tanggal, gambar, 'Prestasi' AS kategori FROM tabel_prestasi
        ) AS g " . ($filter ? 'WHERE kategori = ? ' : '') . 'ORDER BY tanggal DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($filter ? [$filter] : []);
$foto = $stmt->fetchAll();
?>

<section class="page-banner" style="background-image:url('<?= img('hero.jpg', 'Banner') ?>')">
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
        <img src="<?= img($f['gambar'], $f['judul']) ?>" alt="<?= e($f['judul']) ?>" loading="lazy">
        <figcaption><?= e($f['judul']) ?></figcaption>
      </figure>
    <?php endforeach; ?>
    <?php if (!$foto): ?><p>Belum ada foto pada kategori ini.</p><?php endif; ?>
  </div>
</section>

<div class="lightbox" id="lightbox"><div><img src="" alt=""><p id="lightbox-caption"></p></div></div>

<?php require __DIR__ . '/includes/footer.php'; ?>
