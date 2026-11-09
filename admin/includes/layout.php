<?php
require_once __DIR__ . '/auth.php';
require_login();

const MENU = [
    'dashboard' => ['Dashboard',        'index.php',     '▦'],
    'pesan'     => ['Pesan Masuk',      'pesan.php',     '✉'],
    'kegiatan'  => ['Kegiatan',         'kegiatan.php',  '📅'],
    'prestasi'  => ['Prestasi',         'prestasi.php',  '🏆'],
    'jurusan'   => ['Program Keahlian', 'jurusan.php',   '🎓'],
    'profil'    => ['Profil Sekolah',   'profil.php',    '🏫'],
    'kepsek'    => ['Kepala Sekolah',   'kepsek.php',    '👤'],
    'fasilitas' => ['Fasilitas',        'fasilitas.php', '🏢'],
    'kontak'    => ['Kontak',           'kontak.php',    '☎'],
    'pengaturan'=> ['Tampilan Website', 'pengaturan.php','🎨'],
    'password'  => ['Akun & Password',  'password.php',  '🔑'],
];

function layout_top(string $active, string $judul): void {
    $f = flash();
    $situs = info_situs();
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,nofollow">
  <title><?= e($judul) ?> | Admin <?= e($situs['nama']) ?></title>
  <link rel="icon" type="image/png" href="/smkn5palopo/favicon.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="shell">
  <aside class="sidebar" id="sidebar">
    <a href="index.php" class="side-brand">
      <?php if ($situs['logo'] !== ''): ?><img src="<?= e(img_admin('umum', $situs['logo'])) ?>" alt=""><?php endif; ?>
      <span><strong><?= e(mb_strtoupper($situs['nama'])) ?></strong><small>Panel Admin</small></span>
    </a>
    <nav>
      <?php foreach (MENU as $k => [$label, $href, $ico]): ?>
        <a href="<?= $href ?>" class="<?= $k === $active ? 'active' : '' ?>"><i><?= $ico ?></i><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
    <div class="side-foot">
      <a href="../index.php" target="_blank" rel="noopener">↗ Lihat Website</a>
      <a href="logout.php">⎋ Keluar</a>
    </div>
  </aside>
  <div class="main">
    <header class="topbar">
      <button class="burger" onclick="document.getElementById('sidebar').classList.toggle('open')" aria-label="Menu">☰</button>
      <h1><?= e($judul) ?></h1>
      <div class="who"><span class="avatar"><?= e(strtoupper(substr($_SESSION['admin_nama'] ?? 'A', 0, 1))) ?></span><?= e($_SESSION['admin_nama'] ?? 'Admin') ?></div>
    </header>
    <main class="content">
      <?php if ($f): ?><div class="alert <?= $f[1] === 'ok' ? 'ok' : 'err' ?>"><?= e($f[0]) ?></div><?php endif; ?>
<?php
}

function layout_bottom(): void {
    ?>
    </main>
  </div>
</div>
<script src="assets/js/admin.js"></script>
</body>
</html>
<?php
}
