<?php
require_once __DIR__ . '/layout.php';

function slugify(string $t): string {
    return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($t)), '-');
}

/**
 * Halaman CRUD generik.
 * $c: judul, menu, nama, table, pk, kolom (kolom daftar), field (form), urut, cari, single,
 *     default (nilai tetap saat INSERT), muat (fn(row): row — isi field virtual), setelah (fn(PDO,id,post) — simpan relasi)
 * field: nama => [label, type=text|textarea|date|email|number|image, req, hint, rows, folder (image), virtual, auto (slug dari field lain)]
 */
function crud_page(array $c): void {
    $db = db(); $t = $c['table']; $pk = $c['pk'];
    $single = $c['single'] ?? false;
    $aksi = $_GET['aksi'] ?? ($single ? 'ubah' : 'daftar');
    $id = (int)($_GET['id'] ?? 0);
    if ($single && !$id) $id = (int)$db->query("SELECT $pk FROM $t ORDER BY $pk LIMIT 1")->fetchColumn();
    $self = basename($_SERVER['SCRIPT_NAME']);
    $errors = []; $row = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        csrf_check();
        if (($_POST['aksi'] ?? '') === 'hapus' && !$single) {
            $db->prepare("DELETE FROM $t WHERE $pk = ?")->execute([(int)$_POST['id']]);
            flash('Data berhasil dihapus.'); redirect($self);
        }
        $vals = [];
        foreach ($c['field'] as $n => $f) {
            if ($f['type'] === 'image') {
                $err = null;
                $up = simpan_gambar($_FILES[$n] ?? [], $f['folder'], $err);
                if ($err) $errors[] = $err;
                $vals[$n] = $up ?? (($_POST[$n . '_lama'] ?? '') ?: null);
                continue;
            }
            $v = trim($_POST[$n] ?? '');
            if (!empty($f['auto']) && $v === '') $v = slugify($_POST[$f['auto']] ?? '');
            if (!empty($f['req']) && $v === '') $errors[] = $f['label'] . ' wajib diisi.';
            if ($f['type'] === 'email' && $v !== '' && !filter_var($v, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid.';
            if ($f['type'] === 'date' && $v !== '' && !strtotime($v)) $errors[] = $f['label'] . ' tidak valid.';
            if ($f['type'] === 'number' && $v !== '' && !ctype_digit($v)) $errors[] = $f['label'] . ' harus berupa angka.';
            if (!empty($f['auto']) && $v !== '' && $v !== slugify($v)) $errors[] = $f['label'] . ' hanya boleh huruf kecil, angka, dan tanda hubung.';
            $vals[$n] = $v === '' ? ($f['type'] === 'number' ? 0 : null) : $v;
        }
        if (!$errors) {
            $pid = (int)($_POST['id'] ?? 0);
            $simpan = array_filter($vals, fn($k) => empty($c['field'][$k]['virtual']), ARRAY_FILTER_USE_KEY);
            try {
                $db->beginTransaction();
                if ($pid) {
                    $set = implode(', ', array_map(fn($n) => "$n = ?", array_keys($simpan)));
                    $db->prepare("UPDATE $t SET $set WHERE $pk = ?")->execute([...array_values($simpan), $pid]);
                } else {
                    $semua = $simpan + ($c['default'] ?? []);
                    $cols = implode(', ', array_keys($semua));
                    $ph = implode(', ', array_fill(0, count($semua), '?'));
                    $db->prepare("INSERT INTO $t ($cols) VALUES ($ph)")->execute(array_values($semua));
                    $pid = (int)$db->lastInsertId();
                }
                if (!empty($c['setelah'])) ($c['setelah'])($db, $pid, $_POST);
                $db->commit();
                flash($_POST['id'] ? 'Perubahan berhasil disimpan.' : 'Data berhasil ditambahkan.');
                redirect($self);
            } catch (PDOException $ex) {
                if ($db->inTransaction()) $db->rollBack();
                $errors[] = $ex->getCode() === '23000' ? 'Data bentrok: nilai yang harus unik (mis. slug) sudah dipakai.' : 'Gagal menyimpan data.';
                error_log('crud: ' . $ex->getMessage());
            }
        }
        $row = $_POST; $id = (int)($_POST['id'] ?? 0);
        $aksi = $id ? 'ubah' : 'tambah';
    } elseif ($id) {
        $s = $db->prepare("SELECT * FROM $t WHERE $pk = ?"); $s->execute([$id]);
        $row = $s->fetch() ?: [];
        if (!$row && !$single) { flash('Data tidak ditemukan.', 'err'); redirect($self); }
        if ($row && !empty($c['muat'])) $row = ($c['muat'])($row);
    }

    layout_top($c['menu'], $c['judul']);

    if ($aksi === 'daftar') {
        $q = trim($_GET['q'] ?? '');
        $sql = "SELECT * FROM $t"; $p = [];
        if ($q !== '' && !empty($c['cari'])) {
            $sql .= ' WHERE ' . implode(' OR ', array_map(fn($k) => "$k LIKE ?", $c['cari']));
            $p = array_fill(0, count($c['cari']), "%$q%");
        }
        $sql .= ' ORDER BY ' . ($c['urut'] ?? "$pk DESC");
        $s = $db->prepare($sql); $s->execute($p); $rows = $s->fetchAll();
        ?>
        <div class="toolbar">
          <form method="get" class="search">
            <input type="search" name="q" value="<?= e($q) ?>" placeholder="Cari…">
            <button class="btn btn-ghost">Cari</button>
          </form>
          <a href="<?= $self ?>?aksi=tambah" class="btn btn-gold">+ Tambah <?= e($c['nama']) ?></a>
        </div>
        <div class="card table-wrap">
          <table>
            <thead><tr><?php foreach ($c['kolom'] as $lbl): ?><th><?= e($lbl) ?></th><?php endforeach; ?><th class="aksi">Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
              <tr>
                <?php foreach ($c['kolom'] as $k => $lbl):
                    $type = $c['field'][$k]['type'] ?? 'text'; $v = $r[$k] ?? ''; ?>
                  <td data-label="<?= e($lbl) ?>">
                    <?php if ($type === 'image'): ?>
                      <?php if ($v): ?><img class="thumb" src="<?= e(img_admin($c['field'][$k]['folder'], $v)) ?>" alt=""><?php else: ?>—<?php endif; ?>
                    <?php elseif ($type === 'date'): ?><?= e(tanggal_indo($v)) ?>
                    <?php else: ?><?= e(mb_strimwidth((string)$v, 0, 90, '…')) ?><?php endif; ?>
                  </td>
                <?php endforeach; ?>
                <td class="aksi">
                  <a class="btn btn-sm" href="<?= $self ?>?aksi=ubah&id=<?= (int)$r[$pk] ?>">Ubah</a>
                  <form method="post" onsubmit="return confirm('Hapus data ini?')">
                    <?= csrf_field() ?><input type="hidden" name="aksi" value="hapus"><input type="hidden" name="id" value="<?= (int)$r[$pk] ?>">
                    <button class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
            <?php if (!$rows): ?><tr><td colspan="<?= count($c['kolom']) + 1 ?>" class="empty">Belum ada data.</td></tr><?php endif; ?>
            </tbody>
          </table>
        </div>
        <?php
    } else {
        $edit = (bool)($row[$pk] ?? $id);
        ?>
        <?php if ($errors): ?><div class="alert err"><?php foreach ($errors as $er): ?><div><?= e($er) ?></div><?php endforeach; ?></div><?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="card form">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= $edit ? (int)($row[$pk] ?? $id) : 0 ?>">
          <?php foreach ($c['field'] as $n => $f): $v = $row[$n] ?? ''; ?>
            <div class="field">
              <label for="f-<?= $n ?>"><?= e($f['label']) ?><?= !empty($f['req']) ? ' <b>*</b>' : '' ?></label>
              <?php if ($f['type'] === 'textarea'): ?>
                <textarea id="f-<?= $n ?>" name="<?= $n ?>" rows="<?= (int)($f['rows'] ?? 4) ?>"><?= e($v) ?></textarea>
              <?php elseif ($f['type'] === 'image'): ?>
                <?php if ($v): ?><img class="preview" src="<?= e(img_admin($f['folder'], $v)) ?>" alt=""><?php endif; ?>
                <input type="hidden" name="<?= $n ?>_lama" value="<?= e($v) ?>">
                <input type="file" id="f-<?= $n ?>" name="<?= $n ?>" accept="image/jpeg,image/png,image/webp">
              <?php else: ?>
                <input id="f-<?= $n ?>" type="<?= $f['type'] ?>" name="<?= $n ?>" value="<?= e((string)$v) ?>"<?= $f['type'] === 'number' ? ' min="0"' : '' ?>>
              <?php endif; ?>
              <?php if (!empty($f['hint'])): ?><small><?= e($f['hint']) ?></small><?php endif; ?>
            </div>
          <?php endforeach; ?>
          <div class="actions">
            <button class="btn btn-gold">Simpan</button>
            <?php if (!$single): ?><a href="<?= $self ?>" class="btn btn-ghost">Batal</a><?php endif; ?>
          </div>
        </form>
        <?php
    }
    layout_bottom();
}
