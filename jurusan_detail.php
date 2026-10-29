<?php
require_once __DIR__ . '/includes/config.php';

$id = $_GET['id'] ?? '';
$j = $cfg['jurusan'][$id] ?? null;

$halaman = 'jurusan';
$judul = $j ? $j['nama'] : 'Jurusan tidak ditemukan';
if (!$j) http_response_code(404);
require __DIR__ . '/includes/header.php';

if ($j) {
    $uraian     = $j['uraian'] ?? $j['deskripsi'];
    $kompetensi = $j['kompetensi'] ?? [];
    $karier     = $j['karier'] ?? [];
    $lainnya    = array_diff_key($cfg['jurusan'], [$id => true]);
}
?>

<section class="page-banner" style="background-image:url('<?= img($cfg['hero']['jurusan'], 'Banner') ?>')">
  <div class="hero-overlay"></div>
  <div class="container">
    <h1><?= e($judul) ?></h1>
    <p class="crumb"><a href="index.php">Beranda</a> › <a href="jurusan.php">Jurusan</a> › Detail</p>
  </div>
</section>

<section class="container section">
<?php if (!$j): ?>
  <p>Program keahlian tidak ditemukan.</p>
  <p><a href="jurusan.php" class="btn btn-primary">← Kembali ke Daftar Jurusan</a></p>
<?php else: ?>
  <div class="detail-layout">
    <article class="detail-main">
      <img class="detail-img" src="<?= img($j['gambar'], $j['nama']) ?>" alt="<?= e($j['nama']) ?>">

      <h2>Tentang Jurusan</h2>
      <p class="history"><?= nl2br(e($uraian)) ?></p>

      <?php if ($kompetensi): ?>
        <h2 class="mt">Kompetensi yang Dipelajari</h2>
        <ul class="detail-list">
          <?php foreach ($kompetensi as $k): ?><li><?= e($k) ?></li><?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if ($karier): ?>
        <h2 class="mt">Prospek Karier</h2>
        <ul class="detail-list">
          <?php foreach ($karier as $k): ?><li><?= e($k) ?></li><?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <p class="mt"><a href="jurusan.php" class="btn btn-primary">← Kembali ke Daftar Jurusan</a></p>
    </article>

    <aside class="detail-side">
      <h3>Program Keahlian Lainnya</h3>
      <ul>
        <?php foreach ($lainnya as $kunci => $l): ?>
          <li><a href="jurusan_detail.php?id=<?= urlencode($kunci) ?>"><?= e($l['nama']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </aside>
  </div>
<?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
