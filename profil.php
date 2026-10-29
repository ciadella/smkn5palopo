<?php
$halaman = 'profil';
$judul = 'Profil Sekolah';
require __DIR__ . '/includes/header.php';

$misi = $cfg['misi'];
$kepsek = $cfg['kepala_sekolah'];
?>

<section class="page-banner" style="background-image:url('<?= img($cfg['hero']['profil'], 'Banner') ?>')">
  <div class="hero-overlay"></div>
  <div class="container">
    <h1>Profil Sekolah</h1>
    <p class="crumb"><a href="index.php">Beranda</a> › Profil</p>
  </div>
</section>

<section class="container section">
  <div class="about">
    <img src="<?= img('gedung.jpg', 'Gedung sekolah') ?>" alt="Gedung sekolah">
    <div>
      <h2>Tentang <?= e($cfg['nama_sekolah']) ?></h2>
      <p><?= e($cfg['tentang']) ?></p>
    </div>
  </div>

  <div class="stats">
    <div class="stat"><span class="stat-icon">📅</span><div><small>Tahun Berdiri</small><strong><?= e($cfg['tahun_berdiri']) ?></strong></div></div>
    <div class="stat"><span class="stat-icon">👥</span><div><small>Jumlah Siswa</small><strong><?= e($cfg['jumlah_siswa']) ?></strong></div></div>
    <div class="stat"><span class="stat-icon">👤</span><div><small>Jumlah Guru</small><strong><?= e($cfg['jumlah_guru']) ?></strong></div></div>
  </div>

  <h2 class="mt">Visi &amp; Misi</h2>
  <div class="visimisi">
    <div class="vm-box">
      <h3>👁 Visi</h3>
      <p class="quote">"<?= e($cfg['visi']) ?>"</p>
    </div>
    <div class="vm-box">
      <h3>🎯 Misi</h3>
      <ol>
        <?php foreach ($misi as $m): ?><li><?= e($m) ?></li><?php endforeach; ?>
      </ol>
    </div>
  </div>

  <h2 class="mt">Sejarah Singkat</h2>
  <p class="history"><?= nl2br(e($cfg['sejarah'])) ?></p>

  <h2 class="mt">Profil Kepala Sekolah</h2>
  <div class="kepsek">
    <img src="<?= img($kepsek['foto'], 'Foto Kepala Sekolah') ?>" alt="Foto <?= e($kepsek['nama']) ?>">
    <div>
      <h3><?= e($kepsek['nama']) ?></h3>
      <span class="kepsek-role"><?= e($kepsek['jabatan']) ?></span>
      <dl class="biodata">
        <?php foreach ($kepsek['biodata'] as $label => $isi): if ($isi === '') continue; ?>
          <div><dt><?= e($label) ?></dt><dd><?= e($isi) ?></dd></div>
        <?php endforeach; ?>
      </dl>
      <?php if (!empty($kepsek['sambutan'])): ?>
        <p class="quote">"<?= e($kepsek['sambutan']) ?>"</p>
      <?php endif; ?>
    </div>
  </div>

  <h2 class="mt">Fasilitas Sekolah</h2>
  <div class="facility-grid">
    <?php foreach ($cfg['fasilitas'] as $f): ?>
      <div class="facility-card">
        <span class="facility-icon"><?= e($f['ikon']) ?></span>
        <h3><?= e($f['nama']) ?></h3>
        <p><?= e($f['ket']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
