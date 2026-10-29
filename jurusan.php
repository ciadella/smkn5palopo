<?php
$halaman = 'jurusan';
$judul = 'Program Keahlian';
require __DIR__ . '/includes/header.php';

$jurusan = $cfg['jurusan'];
?>

<section class="page-banner" style="background-image:url('<?= img($cfg['hero']['jurusan'], 'Banner') ?>')">
  <div class="hero-overlay"></div>
  <div class="container">
    <h1>Program Keahlian</h1>
    <p class="crumb"><a href="index.php">Beranda</a> › Jurusan</p>
  </div>
</section>

<section class="container section">
  <h2>Daftar Program Keahlian</h2>
  <div class="grid-2">
    <?php foreach ($jurusan as $kunci => $j): ?>
      <article class="major-card">
        <img src="<?= img($j['gambar'], $j['nama']) ?>" alt="<?= e($j['nama']) ?>">
        <div class="major-body">
          <h3><?= e($j['nama']) ?></h3>
          <p><?= e($j['deskripsi']) ?></p>
          <a href="jurusan_detail.php?id=<?= urlencode($kunci) ?>" class="btn btn-sm">Selengkapnya →</a>
        </div>
      </article>
    <?php endforeach; ?>
    <?php if (!$jurusan): ?><p>Belum ada program keahlian.</p><?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
