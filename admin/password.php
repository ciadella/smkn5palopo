<?php
require_once __DIR__ . '/includes/layout.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $db = db();
    $s = $db->prepare('SELECT * FROM admin WHERE id_admin = ?'); $s->execute([$_SESSION['admin_id']]);
    $a = $s->fetch();
    $nama = trim($_POST['nama'] ?? ''); $lama = $_POST['lama'] ?? ''; $baru = $_POST['baru'] ?? ''; $ulang = $_POST['ulang'] ?? '';
    if ($nama === '') $errors[] = 'Nama wajib diisi.';
    if (!$a || !password_verify($lama, $a['password'])) $errors[] = 'Password saat ini salah.';
    if ($baru !== '' && strlen($baru) < 8) $errors[] = 'Password baru minimal 8 karakter.';
    if ($baru !== $ulang) $errors[] = 'Konfirmasi password tidak cocok.';
    if (!$errors) {
        $hash = $baru !== '' ? password_hash($baru, PASSWORD_DEFAULT) : $a['password'];
        $db->prepare('UPDATE admin SET nama = ?, password = ? WHERE id_admin = ?')->execute([$nama, $hash, $a['id_admin']]);
        $_SESSION['admin_nama'] = $nama;
        flash('Akun berhasil diperbarui.'); redirect('password.php');
    }
}
layout_top('password', 'Akun & Password');
?>
<?php if ($errors): ?><div class="alert err"><?php foreach ($errors as $er): ?><div><?= e($er) ?></div><?php endforeach; ?></div><?php endif; ?>
<form method="post" class="card form narrow">
  <?= csrf_field() ?>
  <div class="field"><label>Username</label><input value="<?= e($_SESSION['admin_user']) ?>" disabled></div>
  <div class="field"><label for="nama">Nama</label><input id="nama" name="nama" value="<?= e($_POST['nama'] ?? $_SESSION['admin_nama']) ?>" required></div>
  <div class="field"><label for="lama">Password Saat Ini <b>*</b></label><input id="lama" type="password" name="lama" required autocomplete="current-password"></div>
  <div class="field"><label for="baru">Password Baru</label><input id="baru" type="password" name="baru" autocomplete="new-password"><small>Kosongkan jika tidak ingin mengganti. Minimal 8 karakter.</small></div>
  <div class="field"><label for="ulang">Ulangi Password Baru</label><input id="ulang" type="password" name="ulang" autocomplete="new-password"></div>
  <div class="actions"><button class="btn btn-gold">Simpan</button></div>
</form>
<?php layout_bottom();
