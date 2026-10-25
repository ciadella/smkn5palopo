<?php
$halaman = 'kontak';
$judul = 'Tentang & Kontak';
require __DIR__ . '/includes/header.php';

$notif = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $isi   = trim($_POST['pesan'] ?? '');

    if ($nama === '' || $isi === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Mohon isi nama, email yang valid, dan pesan.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO tabel_pesan (nama, email, isi) VALUES (?, ?, ?)');
            $stmt->execute([$nama, $email, $isi]);
            $notif = 'Terima kasih! Pesan Anda sudah terkirim.';
        } catch (PDOException $ex) {
            $error = 'Pesan belum bisa disimpan. Import dulu file database/tambahan.sql (membuat tabel_pesan).';
        }
    }
}
?>

<section class="page-banner" style="background-image:url('<?= img('hero.jpg', 'Banner') ?>')">
  <div class="hero-overlay"></div>
  <div class="container">
    <h1>Tentang &amp; Kontak</h1>
    <p class="crumb"><a href="index.php">Beranda</a> › Tentang &amp; Kontak</p>
  </div>
</section>

<section class="container section">
  <div class="contact-grid">
    <div>
      <h2>Informasi Kontak</h2>
      <ul class="contact-list">
        <li><span>📍</span><div><strong>Alamat</strong><p><?= e($cfg['alamat']) ?></p></div></li>
        <li><span>📞</span><div><strong>Telepon</strong><p><?= e($cfg['telepon']) ?></p></div></li>
        <li><span>✉️</span><div><strong>Email</strong><p><?= e($cfg['email']) ?></p></div></li>
        <li><span>💬</span><div><strong>Media Sosial</strong>
          <p><?= e($cfg['media_sosial']) ?></p>
          <div class="social dark">
            <a href="<?= e($cfg['youtube']) ?>">▶</a>
            <a href="<?= e($cfg['instagram']) ?>">◎</a>
            <a href="<?= e($cfg['facebook']) ?>">f</a>
          </div></div></li>
      </ul>
    </div>

    <div class="form-card">
      <h2>Kirim Pesan</h2>
      <p class="muted">Jika ada pertanyaan, saran, atau informasi lebih lanjut, silakan hubungi kami melalui form berikut.</p>
      <?php if ($notif): ?><div class="alert ok"><?= e($notif) ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert err"><?= e($error) ?></div><?php endif; ?>
      <form method="post" action="kontak.php">
        <label>Nama Lengkap
          <input type="text" name="nama" placeholder="Masukkan nama Anda" required>
        </label>
        <label>Email
          <input type="email" name="email" placeholder="Masukkan email Anda" required>
        </label>
        <label>Pesan
          <textarea name="pesan" rows="4" placeholder="Tulis pesan Anda..." required></textarea>
        </label>
        <button type="submit" class="btn btn-primary btn-block">Kirim Pesan →</button>
      </form>
    </div>
  </div>

  <h2 class="mt">Lokasi Kami</h2>
  <div class="location-grid">
    <iframe class="map" loading="lazy"
      src="https://www.google.com/maps?q=<?= urlencode($cfg['nama_sekolah'] . ' ' . $cfg['lokasi_singkat']) ?>&output=embed"></iframe>
    <div class="hours">
      <div><span>🕒</span><div><strong>Jam Operasional</strong><p><?= e($cfg['jam_buka_hari']) ?><br><?= e($cfg['jam_buka_jam']) ?></p></div></div>
      <div><span>🚫</span><div><strong><?= e($cfg['jam_tutup_hari']) ?></strong><p><?= e($cfg['jam_tutup_ket']) ?></p></div></div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
