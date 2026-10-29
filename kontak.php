<?php
ob_start();

// ==== PENGATURAN WHATSAPP OTOMATIS (FONNTE) ====
// Daftar di https://fonnte.com, tambahkan device (scan QR), lalu salin TOKEN-nya ke sini
$fonnte_token = ''; // contoh: 'AbCdEf123456'  (kosong = buka WhatsApp manual)

// Nomor TUJUAN penerima pesan (format 62, tanpa + / spasi / tanda hubung)
$nomor_wa = '6281774157317';

// true = hanya untuk localhost jika muncul error SSL. Ubah ke false saat sudah online.
$abaikan_ssl_lokal = true;

// ==== LINK MEDIA SOSIAL ====
$link_instagram = 'https://www.instagram.com/smkn_5_palopo?cplk=YTFlY3k5cTNlNG0w';
$link_facebook  = 'https://www.facebook.com/share/19jWLVEGxM/?mibextid=wwXIfr';
$link_youtube   = 'https://youtube.com/@smkn5palopo?si=SHNvBK8KBMzRn8bk';

$halaman = 'kontak';
$judul = 'Tentang & Kontak';
require __DIR__ . '/includes/header.php';

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
        try {
            $stmt = db()->prepare('INSERT INTO tabel_pesan (nama, email, isi) VALUES (?, ?, ?)');
            $stmt->execute([$nama, $email, $isi]);
        } catch (PDOException $ex) {
            error_log('Gagal simpan pesan: ' . $ex->getMessage());
        }

        $teks = "*Pesan baru dari website*\n\n"
              . "Nama: $nama\n"
              . "Email: $email\n"
              . "Pesan: $isi";

        if ($fonnte_token !== '') {
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

<section class="page-banner" style="background-image:url('<?= img($cfg['hero']['kontak'], 'Banner') ?>')">
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
            <a href="<?= e($link_youtube) ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube" title="YouTube">▶</a>
            <a href="<?= e($link_instagram) ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram" title="Instagram">◎</a>
            <a href="<?= e($link_facebook) ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook" title="Facebook">f</a>
          </div></div></li>
      </ul>
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