<!doctype html>
<html lang="nl">
<head>
<meta charset="UTF-8">
<title> Overzicht Allergenen per product</title>
<style>
 body{font-family:Arial;margin:40px}
 table{border-collapse:collapse;width:95%}
 th,td{border:1px solid #444;padding:8px 10px;text-align:left}
 th{background:#f0f0f0}
 .head{margin-bottom:12px}
 .muted{color:#666}
</style>
<?php if (!empty($geenAllergenen) && $geenAllergenen): ?>
<script>
  setTimeout(function(){ window.location.href = "<?= url('magazijn/overzicht') ?>"; }, 4000);
</script>
<?php endif; ?>
</head>
<body>

<h1> Overzicht Allergenen</h1>

<div class="head">
  <strong>Product:</strong> <?= htmlspecialchars($productNaam ?: '-') ?> &nbsp; | &nbsp;
  <strong>Barcode:</strong> <?= htmlspecialchars($barcode ?: '-') ?>
</div>

<table>
  <thead>
    <tr>
      <th>Naam</th>
      <th>Omschrijving</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $heeftRijen = false;
    if (!empty($items)) {
      foreach ($items as $row) {
        if (!empty($row['Allergeen'])) { $heeftRijen = true; ?>
          <tr>
            <td><?= htmlspecialchars($row['Allergeen']) ?></td>
            <td><?= htmlspecialchars($row['Omschrijving']) ?></td>
          </tr>
    <?php } } }
    if (!$heeftRijen): ?>
      <tr><td colspan="2">
        In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken.
      </td></tr>
    <?php endif; ?>
  </tbody>
</table>

<p class="muted">Rijen gesorteerd op <strong>Naam</strong> oplopend.</p>

<p style="margin-top:20px;">
  <a href="<?= url('magazijn/overzicht') ?>">⬅ Terug naar overzicht</a>
</p>

</body>
</html>
