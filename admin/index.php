<?php
require_once __DIR__ . '/includes/layout.php';
$db = db();
$hit = fn(string $t) => (int)$db->query("SELECT COUNT(*) FROM $t")->fetchColumn();
$stat = [
    ['Pesan Masuk', $hit('pesan'), 'pesan.php', '✉'],
    ['Kegiatan', $hit('kegiatan'), 'kegiatan.php', '📅'],
    ['Prestasi', $hit('prestasi'), 'prestasi.php', '🏆'],
    ['Program Keahlian', $hit('program_keahlian'), 'jurusan.php', '🎓'],
];
$belum = (int)$db->query('SELECT COUNT(*) FROM pesan WHERE dibaca = 0')->fetchColumn();
$pesan = $db->query('SELECT * FROM pesan ORDER BY dibuat DESC, id_pesan DESC LIMIT 5')->fetchAll();
layout_top('dashboard', 'Dashboard');
?>
<div class="welcome card">
  <div><h2>Selamat datang, <?= e($_SESSION['admin_nama']) ?> 👋</h2>
  <p>Kelola isi website SMKN 5 Palopo dari satu tempat.</p></div>
  <a href="../index.php" target="_blank" rel="noopener" class="btn btn-gold">Lihat Website ↗</a>
</div>
<div class="stats">
  <?php foreach ($stat as [$l, $n, $href, $ico]): ?>
    <a class="stat card" href="<?= $href ?>"><i><?= $ico ?></i><b><?= $n ?></b><span><?= e($l) ?></span><?php if ($href === 'pesan.php' && $belum): ?><small><?= $belum ?> belum dibaca</small><?php endif; ?></a>
  <?php endforeach; ?>
</div>
<div class="card">
  <div class="card-head"><h3>Pesan Terbaru</h3><a href="pesan.php">Lihat semua →</a></div>
  <?php foreach ($pesan as $p): ?>
    <div class="msg-row">
      <span class="avatar"><?= e(strtoupper(substr($p['nama'], 0, 1))) ?></span>
      <div><strong><?= e($p['nama']) ?></strong> <small><?= e($p['email']) ?></small>
        <p><?= e(mb_strimwidth($p['isi'], 0, 110, '…')) ?></p></div>
      <time><?= e(tanggal_indo($p['dibuat'])) ?></time>
    </div>
  <?php endforeach; ?>
  <?php if (!$pesan): ?><p class="empty">Belum ada pesan.</p><?php endif; ?>
</div>
<?php layout_bottom();
