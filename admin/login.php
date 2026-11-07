<?php
require_once __DIR__ . '/includes/auth.php';
if (admin_login_check()) redirect('index.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $_SESSION['gagal'] = $_SESSION['gagal'] ?? 0;
    if ($_SESSION['gagal'] >= 5 && time() - ($_SESSION['gagal_waktu'] ?? 0) < 300) {
        $error = 'Terlalu banyak percobaan. Coba lagi dalam 5 menit.';
    } else {
        try {
            $s = db()->prepare('SELECT * FROM admin WHERE username = ?');
            $s->execute([trim($_POST['username'] ?? '')]);
            $a = $s->fetch();
            if ($a && password_verify($_POST['password'] ?? '', $a['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = (int)$a['id_admin'];
                $_SESSION['admin_user'] = $a['username'];
                $_SESSION['admin_nama'] = $a['nama'];
                $_SESSION['gagal'] = 0;
                redirect('index.php');
            }
            $_SESSION['gagal']++; $_SESSION['gagal_waktu'] = time();
            $error = 'Username atau password salah.';
        } catch (PDOException $ex) {
            $error = 'Database belum siap. Pastikan MySQL aktif dan database/smkn_5_palopo.sql sudah diimpor.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,nofollow">
  <title>Masuk | Admin <?= e(info_situs()['nama']) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="login-body">
  <form method="post" class="login-card">
    <?php if (info_situs()['logo'] !== ''): ?><img src="<?= e(img_admin('umum', info_situs()['logo'], 'Logo')) ?>" alt="Logo"><?php endif; ?>
    <h1>Panel Admin</h1>
    <p><?= e(info_situs()['nama']) ?></p>
    <?php if ($error): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
    <?= csrf_field() ?>
    <div class="field"><label for="u">Username</label><input id="u" name="username" required autofocus autocomplete="username" value="<?= e($_POST['username'] ?? '') ?>"></div>
    <div class="field"><label for="p">Password</label><input id="p" type="password" name="password" required autocomplete="current-password"></div>
    <button class="btn btn-gold block">Masuk</button>
    <a class="back" href="../index.php">← Kembali ke website</a>
  </form>
</body>
</html>
