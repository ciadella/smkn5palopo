<?php
require_once __DIR__ . '/includes/layout.php';
$db = db();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $id = (int)($_POST['id'] ?? 0);
    switch ($_POST['aksi'] ?? '') {
        case 'hapus':   $db->prepare('DELETE FROM pesan WHERE id_pesan = ?')->execute([$id]); flash('Pesan dihapus.'); break;
        case 'dibaca':  $db->prepare('UPDATE pesan SET dibaca = 1 WHERE id_pesan = ?')->execute([$id]); break;
        case 'semua':   $db->exec('UPDATE pesan SET dibaca = 1'); flash('Semua pesan ditandai sudah dibaca.'); break;
    }
    redirect('pesan.php');
}
$q = trim($_GET['q'] ?? '');
$s = $db->prepare('SELECT * FROM pesan WHERE nama LIKE ? OR email LIKE ? OR isi LIKE ? ORDER BY dibuat DESC, id_pesan DESC');
$s->execute(["%$q%", "%$q%", "%$q%"]);
$rows = $s->fetchAll();
$belum = (int)$db->query('SELECT COUNT(*) FROM pesan WHERE dibaca = 0')->fetchColumn();
layout_top('pesan', 'Pesan Masuk');
?>
<div class="toolbar">
  <form method="get" class="search"><input type="search" name="q" value="<?= e($q) ?>" placeholder="Cari nama, email, atau isi…"><button class="btn btn-ghost">Cari</button></form>
  <span class="muted"><?= count($rows) ?> pesan · <?= $belum ?> belum dibaca</span>
  <?php if ($belum): ?><form method="post"><?= csrf_field() ?><input type="hidden" name="aksi" value="semua"><button class="btn btn-ghost btn-sm">Tandai semua dibaca</button></form><?php endif; ?>
</div>
<?php foreach ($rows as $p): ?>
  <article class="card msg <?= $p['dibaca'] ? '' : 'baru' ?>">
    <header>
      <span class="avatar"><?= e(strtoupper(substr($p['nama'], 0, 1))) ?></span>
      <div><strong><?= e($p['nama']) ?><?= $p['dibaca'] ? '' : '<span class="badge">Baru</span>' ?></strong>
        <a href="mailto:<?= e($p['email']) ?>"><?= e($p['email']) ?></a></div>
      <time><?= e(tanggal_indo($p['dibuat'])) ?>, <?= e(date('H:i', strtotime($p['dibuat']))) ?></time>
    </header>
    <p><?= nl2br(e($p['isi'])) ?></p>
    <footer>
      <?php if (!$p['dibaca']): ?>
        <form method="post"><?= csrf_field() ?><input type="hidden" name="aksi" value="dibaca"><input type="hidden" name="id" value="<?= (int)$p['id_pesan'] ?>"><button class="btn btn-sm btn-ghost">Tandai dibaca</button></form>
      <?php endif; ?>
      <a class="btn btn-sm" href="mailto:<?= e($p['email']) ?>?subject=Re: Pesan ke SMKN 5 Palopo">Balas</a>
      <form method="post" onsubmit="return confirm('Hapus pesan ini?')"><?= csrf_field() ?><input type="hidden" name="aksi" value="hapus"><input type="hidden" name="id" value="<?= (int)$p['id_pesan'] ?>"><button class="btn btn-sm btn-danger">Hapus</button></form>
    </footer>
  </article>
<?php endforeach; ?>
<?php if (!$rows): ?><div class="card"><p class="empty">Tidak ada pesan.</p></div><?php endif; ?>
<?php layout_bottom();
