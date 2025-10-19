<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>📦 Overzicht Magazijn Jamin</title>
    <style>
        :root{
            --bg:#fafafa; --fg:#333; --muted:#666; --border:#cfcfcf; --head:#f5f7fb; --link:#0b57d0;
        }
        *{box-sizing:border-box}
        body{font-family:Arial, sans-serif; margin:40px; background:var(--bg); color:var(--fg);}
        h1{font-size:28px; margin:0 0 8px}
        .legend{color:var(--muted); margin-bottom:14px}
        table{border-collapse:collapse; width:100%; background:#fff; border:1px solid var(--border); border-radius:8px; overflow:hidden}
        th, td{border-bottom:1px solid var(--border); padding:10px 12px; text-align:left}
        thead th{background:var(--head); font-weight:700}
        tbody tr:last-child td{border-bottom:none}
        .num{text-align:right; white-space:nowrap}
        .icons a{
            display:inline-block; text-decoration:none; font-size:18px; margin-right:6px;
        }
        .icons a:hover{filter:brightness(0.9)}
        .footer{margin-top:18px}
        a.link{color:var(--link); text-decoration:none}
        a.link:hover{text-decoration:underline}
        .empty{padding:16px; color:var(--muted)}
    </style>
</head>
<body>

    <h1>📦 Overzicht Magazijn Jamin</h1>
    <div class="legend">
        Gesorteerd op <strong>Barcode</strong> (oplopend). &nbsp;Legenda: ❌ = Allergenen-info, ❓ = Leverantie-info.
    </div>

    <table aria-label="Overzicht Magazijn">
        <thead>
            <tr>
                <th style="width:16rem;">Barcode</th>
                <th>Productnaam</th>
                <th class="num" style="width:12rem;">VerpakkingsEenheid (Kg)</th>
                <th class="num" style="width:12rem;">Aantal Aanwezig</th>
                <th style="width:9rem;">Allergenen Info</th>
                <th style="width:9rem;">Leverantie Info</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($magazijn) && is_array($magazijn)): ?>
                <?php foreach ($magazijn as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Barcode'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['Naam'] ?? '-') ?></td>
                        <td class="num"><?= htmlspecialchars($row['VerpakkingsEenheidKg'] ?? '-') ?></td>
                        <td class="num"><?= htmlspecialchars(isset($row['AantalAanwezig']) ? $row['AantalAanwezig'] : '-') ?></td>
                        <td class="icons">
                            <?php if (!empty($row['Id'])): ?>
                                <a title="Allergenen voor dit product"
                                   href="<?= url('allergenen/overzicht') . '&id=' . urlencode((string)$row['Id']) ?>">❌</a>
                            <?php else: ?>
                                <span class="empty">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="icons">
                            <?php if (!empty($row['Id'])): ?>
                                <a title="Leverantie-informatie voor dit product"
                                   href="<?= url('leveringen/overzicht') . '&id=' . urlencode((string)$row['Id']) ?>">❓</a>
                            <?php else: ?>
                                <span class="empty">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="empty">Geen producten gevonden.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <a class="link" href="<?= url() ?>">⬅️ Terug naar home</a>
    </div>

</body>
</html>
