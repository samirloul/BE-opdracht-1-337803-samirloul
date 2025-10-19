<!doctype html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title>🚚 Levering Informatie</title>
<style>
 body{font-family:Arial;margin:40px}
 table{border-collapse:collapse;width:95%}
 th,td{border:1px solid #444;padding:8px 10px;text-align:left}
 th{background:#f0f0f0}
 .box{border:1px solid #ccc;padding:10px;margin-bottom:12px;background:#fafafa}
 .muted{color:#666}
 .notice{border:1px solid #e0b4b4;background:#fff6f6;color:#9f3a38;padding:12px;margin:8px 0}
</style>
<?php if (!empty($geenVoorraad)): ?>
<script>
  // Na 4 seconden terug naar het magazijnoverzicht
  setTimeout(function(){ window.location.href = "<?= url('magazijn/overzicht') ?>"; }, 4000);
</script>
<?php endif; ?>
</head>
<body>

<h1>🚚 Levering Informatie</h1>

<div class="box">
  <div><strong>Product:</strong> <?= htmlspecialchars($productNaam ?: '-') ?></div>
  <div><strong>Barcode:</strong> <?= htmlspecialchars($barcode ?: '-') ?></div>
</div>

<div class="box">
  <strong>Leverancier(s):</strong>
  <?php if (!empty($leveranciers)): ?>
    <table style="margin-top:8px;width:100%">
      <thead>
        <tr>
          <th>Naam leverancier</th>
          <th>Contactpersoon leverancier</th>
          <th>Leveranciernummer</th>
          <th>Mobiel</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($leveranciers as $l): ?>
          <tr>
            <td><?= htmlspecialchars($l['Naam']) ?></td>
            <td><?= htmlspecialchars($l['ContactPersoon']) ?></td>
            <td><?= htmlspecialchars($l['LeverancierNummer']) ?></td>
            <td><?= htmlspecialchars($l['Mobiel']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="muted">Geen leveranciers bekend voor dit product.</div>
  <?php endif; ?>
</div>

<?php if (!empty($geenVoorraad)): ?>
  <div class="notice">
    Er is van dit product op dit moment <strong>geen voorraad</strong> aanwezig,
    de verwachte eerstvolgende levering is:
    <strong><?= htmlspecialchars($eerstvolgende ? date('d-m-Y', strtotime($eerstvolgende)) : '-') ?></strong>.
    Je wordt zo teruggestuurd naar het overzicht…
  </div>
<?php endif; ?>

<table>
  <thead>
    <tr>
      <th>Datum levering</th>
      <th>Aantal</th>
      <th>Verwachte eerstvolgende levering</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($rows)): ?>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['DatumLevering']) ?></td>
          <td><?= htmlspecialchars($r['Aantal']) ?></td>
          <td><?= htmlspecialchars($r['DatumEerstVolgendeLevering'] ?? '-') ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="3">Geen leveringen gevonden.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<p class="muted">Gesorteerd op <strong>Datum laatste levering</strong> oplopend.</p>

<p style="margin-top:20px;">
  <a href="<?= url('magazijn/overzicht') ?>">⬅️ Terug naar overzicht</a>
</p>

</body>
</html>
