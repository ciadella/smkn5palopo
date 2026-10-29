<footer class="footer">
  <div class="container footer-grid">
    <div class="footer-brand">
      <img src="<?= img('logo.png', 'Logo') ?>" alt="Logo" class="brand-logo">
      <div>
        <strong><?= e($cfg['nama_sekolah']) ?></strong>
        <small><?= e($cfg['slogan']) ?></small>
      </div>
    </div>
    <div>
      <h4>Kontak</h4>
      <p>📞 <?= e($cfg['telepon']) ?></p>
      <p>✉️ <?= e($cfg['email']) ?></p>
      <p>📍 <?= e($cfg['lokasi_singkat']) ?></p>
    </div>
    <div>
      <h4>Ikuti Kami</h4>
      <div class="social">
        <a href="<?= e($cfg['youtube']) ?>" aria-label="YouTube">▶ </a>
        <a href="<?= e($cfg['instagram']) ?>" aria-label="Instagram">◎</a>
        <a href="<?= e($cfg['facebook']) ?>" aria-label="Facebook">f</a>
      </div>
    </div>
  </div>
  <div class="copyright">© <?= date('Y') ?> <?= e($cfg['nama_sekolah']) ?>. All rights reserved.</div>
</footer>
<script src="assets/js/main.js"></script>
</body>
</html>
