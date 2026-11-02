<?php
require_once __DIR__ . '/includes/layout.php';
$db = db();
$rows = $db->query('SELECT * FROM pengaturan ORDER BY kelompok, urutan, kunci')->fetchAll();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $upd = $db->prepare('UPDATE pengaturan SET nilai = ? WHERE kunci = ?');
    foreach ($rows as $r) {
        $k = $r['kunci'];
        if ($r['tipe'] === 'image') {
            $err = null;
            $up = simpan_gambar($_FILES[$k] ?? [], 'umum', $err);
            if ($err) { $errors[] = $r['label'] . ': ' . $err; continue; }
            if ($up) $upd->execute([$up, $k]);
        } else {
            $upd->execute([trim($_POST[$k] ?? ''), $k]);
        }
    }
    if (!$errors) { flash('Pengaturan tampilan disimpan.'); redirect('pengaturan.php'); }
    $rows = $db->query('SELECT * FROM pengaturan ORDER BY kelompok, urutan, kunci')->fetchAll();
}
layout_top('pengaturan', 'Tampilan Website');
?>
<?php if ($errors): ?><div class="alert err"><?php foreach ($errors as $er): ?><div><?= e($er) ?></div><?php endforeach; ?></div><?php endif; ?>
<form method="post" enctype="multipart/form-data" class="card form">
  <?= csrf_field() ?>
  <?php $grup = null; foreach ($rows as $r):
      if ($r['kelompok'] !== $grup): $grup = $r['kelompok']; ?><h3 class="grup"><?= e($grup) ?></h3><?php endif; ?>
    <div class="field">
      <label for="f-<?= e($r['kunci']) ?>"><?= e($r['label']) ?></label>
      <?php if ($r['tipe'] === 'textarea'): ?>
        <textarea id="f-<?= e($r['kunci']) ?>" name="<?= e($r['kunci']) ?>" rows="3"><?= e($r['nilai']) ?></textarea>
      <?php elseif ($r['tipe'] === 'image'): ?>
        <?php if ($r['nilai']): ?><img class="preview" src="<?= e(img_admin('umum', $r['nilai'])) ?>" alt=""><?php endif; ?>
        <input type="file" id="f-<?= e($r['kunci']) ?>" name="<?= e($r['kunci']) ?>" accept="image/jpeg,image/png,image/webp">
        <small>JPG/PNG/WEBP, maks. 2 MB. Tersimpan di assets/img/umum/.</small>
      <?php else: ?>
        <input id="f-<?= e($r['kunci']) ?>" name="<?= e($r['kunci']) ?>" value="<?= e($r['nilai']) ?>">
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
  <div class="actions"><button class="btn btn-gold">Simpan</button></div>
</form>
<?php layout_bottom();
