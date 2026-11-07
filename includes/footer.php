<footer class="footer">
  <div class="container footer-grid">
    <div class="footer-brand">
      <?php if ($cfg['logo'] !== ''): ?><img src="<?= img_db('umum', $cfg['logo'], 'Logo') ?>" alt="Logo" class="brand-logo"><?php endif; ?>
      <div>
        <strong><?= e($cfg['nama_sekolah']) ?></strong>
        <small><?= e($cfg['slogan']) ?></small>
      </div>
    </div>
    <div>
      <?php if ($cfg['telepon'] . $cfg['email'] . $cfg['lokasi_singkat'] !== ''): ?>
      <h4>Kontak</h4>
      <?php if ($cfg['telepon'] !== ''): ?><p>📞 <?= e($cfg['telepon']) ?></p><?php endif; ?>
      <?php if ($cfg['email'] !== ''): ?><p>✉️ <?= e($cfg['email']) ?></p><?php endif; ?>
      <?php if ($cfg['lokasi_singkat'] !== ''): ?><p>📍 <?= e($cfg['lokasi_singkat']) ?></p><?php endif; ?>
      <?php endif; ?>
    </div>
    <div>
      <?php if ($cfg['youtube'] . $cfg['instagram'] . $cfg['facebook'] !== ''): ?>
      <h4>Ikuti Kami</h4>
      <?php if ($cfg['youtube'] !== ''): ?><a href="<?= e($cfg['youtube']) ?>" target="_blank" rel="noopener" aria-label="YouTube">▶</a><?php endif; ?>
      <?php if ($cfg['instagram'] !== ''): ?><a href="<?= e($cfg['instagram']) ?>" target="_blank" rel="noopener" aria-label="Instagram">◎</a><?php endif; ?>
      <?php if ($cfg['facebook'] !== ''): ?><a href="<?= e($cfg['facebook']) ?>" target="_blank" rel="noopener" aria-label="Facebook">f</a><?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
  <?php if ($cfg['nama_sekolah'] !== ''): ?><div class="copyright">© <?= date('Y') ?> <?= e($cfg['nama_sekolah']) ?>. All rights reserved.</div><?php endif; ?>
</footer>
<script src="assets/js/main.js"></script>
</body>
</html>
