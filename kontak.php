<?php
ob_start();

$halaman = 'kontak';
$judul = 'Tentang & Kontak';
require __DIR__ . '/includes/header.php';

// Pengaturan WhatsApp (token Fonnte) ada di config/app.php; nomor tujuan & link sosmed diatur dari admin (menu Kontak).
$fonnte_token      = FONNTE_TOKEN;
$abaikan_ssl_lokal = ABAIKAN_SSL_LOKAL;
$nomor_wa          = preg_replace('/\D+/', '', $cfg['whatsapp']);
$link_instagram    = $cfg['instagram'];
$link_facebook     = $cfg['facebook'];
$link_youtube      = $cfg['youtube'];

$notif = '';
$error = '';

/** Kirim pesan otomatis lewat Fonnte. Return [berhasil(bool), keterangan(string)] */
function kirim_wa_fonnte($token, $target, $pesan, $abaikan_ssl = false) {
    if (!function_exists('curl_init')) {
        return [false, 'Ekstensi cURL belum aktif di PHP.'];
    }
    $ch = curl_init('https://api.fonnte.com/send');
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_HTTPHEADER     => ['Authorization: ' . $token],
        CURLOPT_POSTFIELDS     => [
            'target'      => $target,
            'message'     => $pesan,
            'countryCode' => '62',
        ],
    ]);
    if ($abaikan_ssl) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }
    $respon = curl_exec($ch);
    $err    = curl_error($ch);
    curl_close($ch);

    if ($respon === false) {
        return [false, $err];
    }
    $data = json_decode($respon, true);
    if (!empty($data['status'])) {
        return [true, 'OK'];
    }
    return [false, $data['reason'] ?? $respon];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $isi   = trim($_POST['pesan'] ?? '');

    if ($nama === '' || $isi === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Mohon isi nama, email yang valid, dan pesan.';
    } else {
        // 1) Simpan ke database (kalau gagal, tetap lanjut)
        $tersimpan = true;
        try {
            $stmt = db()->prepare('INSERT INTO pesan (nama, email, isi) VALUES (?, ?, ?)');
            $stmt->execute([$nama, $email, $isi]);
        } catch (PDOException $ex) {
            $tersimpan = false;
            error_log('Gagal simpan pesan: ' . $ex->getMessage());
        }

        $teks = "*Pesan baru dari website*\n\n"
              . "Nama: $nama\n"
              . "Email: $email\n"
              . "Pesan: $isi";

        if ($nomor_wa === '') {
            // Tidak ada nomor WhatsApp di database (tabel kontak kosong/terhapus)
            $error = $tersimpan ? 'Pesan Anda tersimpan, tetapi nomor WhatsApp tujuan belum diatur.'
                                : 'Pesan belum dapat dikirim saat ini. Silakan coba lagi nanti.';
        } elseif ($fonnte_token !== '') {
            // 2a) Kirim OTOMATIS ke WhatsApp tujuan
            [$ok, $ket] = kirim_wa_fonnte($fonnte_token, $nomor_wa, $teks, $abaikan_ssl_lokal);
            if ($ok) {
                $notif = 'Terima kasih! Pesan Anda sudah terkirim ke WhatsApp kami.';
            } else {
                error_log('Gagal kirim WA: ' . $ket);
                $error = 'Pesan Anda tersimpan, tetapi belum berhasil dikirim ke WhatsApp. Silakan coba lagi nanti.';
            }
        } else {
            // 2b) Token kosong: buka WhatsApp, pengguna menekan kirim sendiri
            ob_end_clean();
            header('Location: https://wa.me/' . $nomor_wa . '?text=' . rawurlencode($teks));
            exit;
        }
    }
}
?>

<section class="page-banner" <?= $cfg['hero']['kontak'] !== '' ? 'style="background-image:url(\'' . img_db('umum', $cfg['hero']['kontak']) . '\')"' : '' ?>>
  <div class="hero-overlay"></div>
  <div class="container">
    <h1>Tentang &amp; Kontak</h1>
    <p class="crumb"><a href="index.php">Beranda</a> › Tentang &amp; Kontak</p>
  </div>
</section>

<section class="container section">
  <div class="contact-grid">
    <div>
      <?php if ($cfg['alamat'] . $cfg['telepon'] . $cfg['email'] . $cfg['media_sosial'] . $link_youtube . $link_instagram . $link_facebook !== ''): ?>
      <h2>Informasi Kontak</h2>
      <ul class="contact-list">
        <?php if ($cfg['alamat'] !== ''): ?><li><span>📍</span><div><strong>Alamat</strong><p><?= e($cfg['alamat']) ?></p></div></li><?php endif; ?>
        <?php if ($cfg['telepon'] !== ''): ?><li><span>📞</span><div><strong>Telepon</strong><p><?= e($cfg['telepon']) ?></p></div></li><?php endif; ?>
        <?php if ($cfg['email'] !== ''): ?><li><span>✉️</span><div><strong>Email</strong><p><?= e($cfg['email']) ?></p></div></li><?php endif; ?>
        <?php if ($cfg['media_sosial'] . $link_youtube . $link_instagram . $link_facebook !== ''): ?>
        <li><span>💬</span><div><strong>Media Sosial</strong>
          <p><?= e($cfg['media_sosial']) ?></p>
          <div class="social dark">
            <?php if ($link_youtube !== ''): ?><a href="<?= e($link_youtube) ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube" title="YouTube">▶</a><?php endif; ?>
            <?php if ($link_instagram !== ''): ?><a href="<?= e($link_instagram) ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram" title="Instagram">◎</a><?php endif; ?>
            <?php if ($link_facebook !== ''): ?><a href="<?= e($link_facebook) ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook" title="Facebook">f</a><?php endif; ?>
          </div></div></li>
        <?php endif; ?>
      </ul>
      <?php endif; ?>
    </div>

    <div class="form-card">
      <h2>Kirim Pesan</h2>
      <p class="muted">Jika ada pertanyaan, saran, atau informasi lebih lanjut, silakan hubungi kami melalui form berikut. Pesan akan langsung diteruskan ke WhatsApp kami.</p>
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
        <button type="submit" class="btn btn-primary btn-block">Kirim via WhatsApp →</button>
      </form>
    </div>
  </div>

  <?php if (trim($cfg['nama_sekolah'] . $cfg['lokasi_singkat']) !== '' || $cfg['jam_buka_hari'] . $cfg['jam_buka_jam'] . $cfg['jam_tutup_hari'] . $cfg['jam_tutup_ket'] !== ''): ?>
  <h2 class="mt">Lokasi Kami</h2>
  <div class="location-grid">
    <?php if (trim($cfg['nama_sekolah'] . $cfg['lokasi_singkat']) !== ''): ?>
    <iframe class="map" loading="lazy"
      src="https://www.google.com/maps?q=<?= urlencode($cfg['nama_sekolah'] . ' ' . $cfg['lokasi_singkat']) ?>&output=embed"></iframe>
    <?php endif; ?>
    <?php if ($cfg['jam_buka_hari'] . $cfg['jam_buka_jam'] . $cfg['jam_tutup_hari'] . $cfg['jam_tutup_ket'] !== ''): ?>
    <div class="hours">
      <?php if ($cfg['jam_buka_hari'] . $cfg['jam_buka_jam'] !== ''): ?><div><span>🕒</span><div><strong>Jam Operasional</strong><p><?= e($cfg['jam_buka_hari']) ?><br><?= e($cfg['jam_buka_jam']) ?></p></div></div><?php endif; ?>
      <?php if ($cfg['jam_tutup_hari'] . $cfg['jam_tutup_ket'] !== ''): ?><div><span>🚫</span><div><strong><?= e($cfg['jam_tutup_hari']) ?></strong><p><?= e($cfg['jam_tutup_ket']) ?></p></div></div><?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>